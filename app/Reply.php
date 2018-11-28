<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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


    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
