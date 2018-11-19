@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                <form method="POST" action="/threads">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="channel_id"> Choose a channel: </label>
                        <select name="channel_id" class="form-control" id="channel_id" required>
                            <option value="">Choose one...</option>

                            @foreach ($channels as $channel)
                                <option value="{{ $channel->id }} {{ old('channel_id') == $channel->id ? 'selected' : '' }}"> {{ $channel->name }}</option>
                                @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="title"> Title: </label>
                        <input type="text" class="form-control" id="title" placeholder="title" name="title" value="{{ old('title') }}" required/>
                    </div>

                    <div class="form-group">
                        <label for="body"> Body: </label>
                        <textarea name="body" class="form-control" id="body" rows="6" required> </textarea>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary"> Publish </button>
                    </div>
                    
                </form>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
