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


    public function store(Thread $thread)
    {
        //associate a reply to a thread.
        //do the reply to the thread with the user id.

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }


    
}