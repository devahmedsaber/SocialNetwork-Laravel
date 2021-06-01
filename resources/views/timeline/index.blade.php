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

        </div>
    </div>
@endsection