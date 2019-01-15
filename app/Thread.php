<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\ThreadFilters;
use App\Notifications\ThreadWasUpdated;
use App\Events\ThreadHasNewReply;
use App\Events\ThreadReceivedNewReply;

class Thread extends Model
{
    use RecordsActivity;
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'user_id',
        'channel_id',
        'title',
        'body'
    ];

    protected $with = ['creator', 'channel'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['isSubscribedTo'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('replyCount', function ($builder) {
            
        //     $builder->withCount('replies');
        // });

        /**
         * When deleting a thread, we are deleting the associated replies also.
         */
        static::deleting(function ($thread) {
            $thread->replies->each->delete(); // psuedo class
        });

    }

    public function path()
    {
    	return "/threads/{$this->channel->slug}/{$this->id}";
    }

    //Thread can have many replies. 
    //connect it to the reply class using hasMany relationship.

    //a thread belongs to a user.
    public function creator()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    //thread belongs to a channel.
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * A thread may have many replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    /**
     * Add a reply to the thread.
     *
     * @param $reply
     * @param  array $reply
     * @return Reply
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        //$this->notifySubscribers($reply);

        //event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

    public function notifySubscribers($reply)
    {
        //prepare notifications for all subscribers

        $this->subscriptions
            ->where("user_id", "!=", $reply->user_id)
            ->each
            ->notify($reply);
    }


    /**
     * Apply all relevant thread filters.
     *
     * @param  Builder       $query
     * @param  ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;

    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
        

    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubcription::class);

    }

    /**
     * Determine if the current user is subscribed to the thread.
     *
     * @return boolean
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * Determine if the thread has been updated since the user last read it.
     *
     * @param  User $user
     * @return bool
     */
    public function hasUpdatedfor($user)
    {
        //Look in the cache for the proper key

        $key = $user->visitedThreadCacheKey($this);

        //compare that carbon instance with the $thread->updated_at.
        return $this->updated_at > cache($key);
    }
}
