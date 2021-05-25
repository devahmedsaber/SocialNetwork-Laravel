@extends('templates.default')

@section('content')
    <h3>Your Search For "{{ app('request')->input('query') }}"</h3>

    @if(!$users->count())
        <p>No Results Found, Sorry.</p>
    @else
        <div class="row">
            <div class="col-lg-12">
                @foreach($users as $user)
                    @include('user.partials.userblock')
                @endforeach
            </div>
        </div>
    @endif
@endsection