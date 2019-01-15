@forelse ($threads as $thread)
    <div class="card">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h4>
                        <a href="{{ $thread->path() }}">
                            @if (auth()->check() && $thread->hasUpdatedfor(auth()->user()))

                                <strong> {{ $thread->title }} </strong>
                            @else
                                {{ $thread->title }}
                            @endif 
                        </a>
                    </h4>
                    <h6>
                        Posted By: <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                    </h6>
                </div>
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