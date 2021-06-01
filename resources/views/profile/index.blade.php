@extends('templates.default')

@section('content')

    <div class="row">
        <div class="col-lg-5">
            @include('user.partials.userblock')
            <hr>
        </div>
        <div class="col-lg-4 col-lg-offset-3">
            @if(Auth::user()->hasFriendRequestPending($user))
                <p>Waiting For <b>{{ $user->getNameOrUsername() }}</b> To Accept Your Request.</p>
            @elseif(Auth::user()->hasFriendRequestReceived($user))
                <a href="{{ route('friends.accept', ['username' => $user->username]) }}" class="btn btn-primary">Accept Friend Request</a>
            @elseif(Auth::user()->isFriendWith($user))
                <p>You And {{ $user->getNameOrUsername() }} Are Friends.</p>
            @elseif(Auth::user()->id !== $user->id)
                <a href="{{ route('friends.add', ['username' => $user->username]) }}" class="btn btn-primary">Add Friend</a>
            @endif

            <h4>{{ $user->getFirstNameOrUsername() }}'s Friends.</h4>
            
            @if(!$user->friends()->count())
                <p>{{ $user->getFirstNameOrUsername() }} Has No Friends.</p>
            @else
                @foreach($user->friends() as $user)
                    @include('user/partials/userblock')
                @endforeach
            @endif
        </div>
    </div>

@endsection