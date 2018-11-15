<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    public function path()
    {
    	return "/threads/" . $this->id;
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
    	return $this->BelongsTo(User::class, 'user_id');
    }

    //add a reply to a thread.
    public function addReply($reply)
    {
        //dd($reply);
        $this->replies->make($reply);
    }
}
