@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="/profiles/{{ $thread->creator->name }}"> {{ $thread->creator->name }} </a> posted {{ $thread->title }}
                            </span>

                            @can ('update', $thread)
                                <form action="{{ $thread->path() }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE')}}

                                    <button type="submit" class="btn btn-link">Delete Thread</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                <!-- we are making the replies component responsible for fetching all the data, 
                rather than server side pass the data to it. -->
                <replies
                    @added="repliesCount++"
                    @removed="repliesCount--"></replies>

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        This thread was published by 
                        <a href="#">{{ $thread->creator->name }}</a>  
                        {{ $thread->created_at->diffForHumans() }}, and currently has 
                        <span v-text="repliesCount"></span>
                        {{ str_plural('comment', $thread->replies_count) }}.

                        <div>
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection