@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a> posted:
                    {{ $thread->title }}
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>


            @foreach($thread->replies as $reply)
            @include('threads.reply')
            @endforeach

            {{ $replies->links() }}

            @if(auth()->check())
            <form method="POST" action="{{$thread->path() . '/replies'}}">
                {{csrf_field()}}
                <div class="form-group">
                    <textarea name="body" id="body" class="form-control" placeholder="What do you think?" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-default">Post</button>
            </form>
            @else
            <p class="text-center">Please <a href="{{ route('login') }}">login</a> to respond.</p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    This thread was created {{ $thread->created_at->diffForHumans() }}
                    <a href="#">{{ $thread->creator->name }}</a> and currently has {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count)}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
