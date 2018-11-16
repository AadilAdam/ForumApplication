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


    public function store(Thread $thread, $channelId)
    {
        //associate a reply to a thread.
        //do the reply to the thread with the user id.

        //validate that the title attribute is required.
        $this->validate($request, [
            'body' => 'required'
        ]);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }


    
}