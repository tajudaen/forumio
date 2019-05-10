@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card card-default">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                    @foreach($threads as $thread)
                    <article>
                        <h4>
                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                        </h4>
                        <div class="body">{{ $thread->body }}</div>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
