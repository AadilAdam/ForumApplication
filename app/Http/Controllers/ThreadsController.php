<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use Illuminate\Http\Request;
use Auth;
use App\Filters\ThreadFilters;

class ThreadsController extends Controller
{
    /**
     * Threads controller constructor
     * 
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        //$threads = $this->getThreads($channel);
        

        /*if ($channel->exists)
        {
            //dd($channel);
            $threads = $channel->threads()->latest();
            //dd($threads);

        } else {
            
            //dd($channel);
            $threads = Thread::latest();
        }

        if($username = request('by'))
        {
            $user = Thread::where('name', $username)->firstOrFail();

            $threads->where('user_id', $user->id);
        }
        //dd($threads);
        $threads = $threads->get();*/

        //return view('threads.index', compact('threads'));

        $threads = $this->getThreads($channel, $filters);
        return view('threads.index', compact('threads'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validate that the title attribute is required.
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels, id'
        ]);

        //dd($request->all());
        $thread = Thread::create([
            'user_id' => auth()->id,
            'channel_id' =>request('channel_id'),
            'title' => $request->input('title'),
            'body' => $request->input('body')
        ]);

        Session::flash('flash_message', 'Thread successfully added!');

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {

        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(25)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }

    /**
     * Fetch all relevant threads.
     *
     * @param Channel       $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);


        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->get();
    }

}
