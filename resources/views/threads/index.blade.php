@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            @include ('threads._list')


            {{ $threads->render() }}
        </div>
    </div>
</div>
@endsection
