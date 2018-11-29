<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\ThreadFilters;

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
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            
            $builder->withCount('replies');
        });

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
        return $this->replies()->create($reply);
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
}
