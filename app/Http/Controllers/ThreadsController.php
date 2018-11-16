<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use Illuminate\Http\Request;
use Auth;

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
    public function index($channelSlug = null)
    {
        if ($channelSlug)
        {
            $channelId = Channel::where('slug' , $channelSlug)->first()->id;
            $threads = Thread::where('channel_id', $channelSlug)->latest()->get();

        } else {
            
            $threads = Thread::latest()->get();
        }

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
            'channel_id' => 'required|channels, id'
        ]);

        //dd($request->all());
        $thread = Thread::create([
            'user_id' => Auth::user()->id,
            'channel_id' =>request('channel_id'),
            'title' => $request->input('title'),
            'body' => $request->input('body')
        ]);

        Session::flash('flash_message', 'Thread successfully added!');

        return redirect('/threads');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
        return view('threads.show', compact('thread'));
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
}
