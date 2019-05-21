<div id="reply-{{ $reply->id }}" class="card card-block">
    <div class="card card">
        <div class="card-body">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile', $reply->owner) }}">{{$reply->owner->name}}</a> said {{ $reply->created_at->diffForHumans() }}
                </h5>

                <div>
                    @if ($reply->myFavorite())
                    <form method="POST" action="/replies/{{$reply->id}}/favorites">
                        {{csrf_field()}}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-secondary">
                            {{ $reply->favorites_count }} {{ str_plural('UnFavorite', $reply->favorites_count) }}
                        </button>
                    </form>
                    @else
                    <form method="POST" action="/replies/{{$reply->id}}/favorites">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-primary">
                            {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            {{ $reply->body }}
        </div>

        @can('update', $reply)
        <div class="card-footer">
            <a href="/replies/{{$reply->id}}" class="btn btn-xs mr-1">Edit</a>
            <form method="POST" action="/replies/{{$reply->id}}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger btn-xs">Delete Reply</button>
            </form>
        </div>
        @endcan
    </div>
