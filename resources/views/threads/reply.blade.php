<div class="card card-default">
    <div class="card-body">
        <a href="#">
            {{$reply->owner->name}}
        </a>
        said {{ $reply->created_at->diffForHumans() }}
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
