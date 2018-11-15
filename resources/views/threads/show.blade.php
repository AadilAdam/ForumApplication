@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#"> {{ $thread->creator->name }} </a> posted {{ $thread->title }}</div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($thread->replies as $reply)
                @include ('threads.reply')
            @endforeach
        </div>
    </div>

    @if (auth()->check())
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ $thread->path() . '/replies' }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea rows="5" placeholder="please enter your text" class="form-control" name="reply" id="reply"> </textarea>
                </div>
                <button type="submit" class="btn btn-default" >Submit</button>
            </form>
        </div>
    </div>
    @else
        <p class="text-center"><a href="{{ route('login') }}">Please sign in to continue..</a></p>
    @endif


</div>
@endsection