@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form method="post" action="{{ route('status.post') }}" role="form">
                @csrf
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <textarea class="form-control" name="status" placeholder="What's Up {{ Auth::user()->getFirstNameOrUsername() }} ?" rows="2"></textarea>
                    @if($errors->has('status'))
                        <span class="help-block">{{ $errors->first('status') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-default">Update Status</button>
            </form>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            @if(!$statuses->count())
                <p>There is Nothing In Your Timeline, Yet.</p>
            @else
                @foreach($statuses as $status)
                    <div class="media">
                        <a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
                            <img class="media-object" src="{{ $status->user->getAvatarUrl() }}" alt="{{ $status->user->getNameOrUsername() }}">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}">{{ $status->user->getNameOrUsername() }}</a></h4>
                            <p>{{ $status->body }}</p>
                            <ul class="list-inline">
                                <li>{{ $status->created_at->diffForHumans() }}</li>
                                <li><a href="#">Like</a></li>
                                <li>10 Likes</li>
                            </ul>

                            <form role="form" action="#" method="post">
                                <div class="form-group">
                                    <textarea name="reply-1" class="form-control" placeholder="Reply to this status" rows="2"></textarea>
                                </div>
                                <input type="submit" value="Reply" class="btn btn-default btn-sm" name="" id="">
                            </form>
                        </div>
                    </div>
                @endforeach
                {{ $statuses->render() }}
            @endif
        </div>
    </div>
@endsection