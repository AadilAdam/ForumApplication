@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#"> {{ $thread->creator->name }} </a> posted {{ $thread->title }}</div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>

            <div>
            @foreach ($replies as $reply)
                @include ('threads.reply')
            @endforeach
            </div>


            @if (auth()->check())
            <div class="row">
                <div class="col-md-8">
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea rows="5" placeholder="please enter your text" class="form-control" name="reply" id="reply"> </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" >Submit</button>
                    </form>
                </div>
            </div>
            @else
                <p class="text-center"><a href="{{ route('login') }}">Please sign in to continue..</a></p>
            @endif

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    This thread was published by 
                    <a href="#">{{ $thread->creator->name }}</a>  
                    {{ $thread->created_at->diffForHumans() }}, and currently has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                </div>
            </div>
        </div>


    </div>
</div>
@endsection