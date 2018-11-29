<?php


namespace App\Http\Controllers;

use App\Thread;
use App\Reply;
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
            'body' => 'required'
        ]);

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }
        return back()->with('flash', 'Yor reply has been added to the thread.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted.']);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(['body' => request('body')]);
    }

    
}