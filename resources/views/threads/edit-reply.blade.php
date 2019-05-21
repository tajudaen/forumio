@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                        <form method="POST" action="/replies/{{$reply->id}}">
                            {{csrf_field()}}
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <textarea name="body" id="body" class="form-control" rows="5" required>{{ $reply->body }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-default">Update</button>
                        </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
