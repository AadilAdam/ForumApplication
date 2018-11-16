<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

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


    public function path()
    {
    	return "/threads/{$this->channel->slug}/{$this->id}";
    }

    //Thread can have many replies. 
    //connect it to the reply class using hasMany relationship.
    public function replies()
    {
    	return $this->hasMany(Reply::class);
    }

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

    //add a reply to a thread.
    public function addReply($reply)
    {
        //dd($reply);
        $this->replies->make($reply);
    }
}
