@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            @forelse ($threads as $thread)
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <h4 class="flex">
                                <a href="{{ $thread->path() }}">
                                    @if (auth()->check() && $thread->hasUpdatedfor(auth()->user()))

                                        <strong> {{ $thread->title }} </strong>
                                    @else
                                        {{ $thread->title }}
                                    @endif 
                                </a>
                            </h4>
                            <a href="{{ $thread->path() }}">  {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count)}} </a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            @empty
                <p>There are no results at this time.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
