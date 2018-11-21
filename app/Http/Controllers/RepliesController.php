<?php


namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;


class RepliesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');

    }


    public function store ($channelId, Thread $thread)
    {
        //associate a reply to a thread.
        //do the reply to the thread with the user id.

        //validate that the title attribute is required.
        $this->validate(request(), [
            'reply' => 'required'
        ]);

        $thread->addReply([
            'body' => request('reply'),
            'user_id' => auth()->id()
        ]);

        
        //dd($thread);

        return back();
    }


    
}