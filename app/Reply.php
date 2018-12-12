<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Reply extends Model
{
    use Favorable, RecordsActivity;
    
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * When deleting a thread, we are deleting the associated replies also.
         */
        static::created(function ($reply) {
            $reply->thread->increment('replies_count'); // psuedo class
        });

        /**
         * When deleting a thread, we are deleting the associated replies also.
         */
        static::deleted(function ($reply) {
            $reply->thread->increment('replies_count'); // psuedo class
        });

    }

    /**
     * Whenever we cast to a json, used if we want to append any custom attribute to json.
     */
    protected $appends = ['favoritesCount', 'isFavorited'];

    /**
     * A reply has an owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function wasJustPublished()
    {
        //if the created at time is greater than carbon now() time, then you are posting too soon.
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    /**
     * Fetch all mentioned users within the reply's body.
     *
     * @return array
     */
    public function mentionedUsers()
    {
        preg_match_all('/\@([^\s\.]+)/', $this->body, $matches);
        
        return $matches[1];
    }


    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
