@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach($threads as $thread)
            <div class="card card-block">
                <div class="card-header">
                    <div class="level">
                        <h4 class="flex">
                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                        </h4>
                        <a href="{{$thread->path()}}">
                            <strong>{{$thread->replies_count}} {{ str_plural('reply', $thread->replies_count) }}</strong>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
