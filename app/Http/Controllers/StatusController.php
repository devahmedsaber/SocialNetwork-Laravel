<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function postStatus(Request $request){
        $this->validate($request, [
            'status' => 'required|max:1000'
        ]);
        
        Auth::user()->statuses()->create([
            'body' => $request->input('status')
        ]);

        return redirect()->route('home')->with('info', 'Status Posted.');
    }

    public function postReply(Request $request, $statusId){
        $this->validate($request, [
            "reply-{$statusId}" => 'required|max:1000'
        ], [
            'required' => 'The reply body is required.'
        ]);

        $status = Status::notReply()->find($statusId);

        if(!$status){
            return redirect()->route('home');
        }

        if(!Auth::user()->isFriendWith($status->user) && Auth::user()->id !== $status->user->id){
            return redirect()->route('home');
        }

        $reply = Status::create([
            'user_id' => Auth::user()->id,
            'body' => $request->input("reply-{$statusId}")
        ])->user()->associate(Auth::user());

        $status->replies()->save($reply);

        return redirect()->back();
    }

    public function getLike($statusId){
        $status = Status::find($statusId);
        
        if(!$status){
            return redirect()->route('home');
        }

        if(!Auth::user()->isFriendWith($status->user)){
            return redirect()->route('home');
        }

        if(Auth::user()->hasLikedStatus($status)){
            return redirect()->back();
        }

        $like = $status->likes()->create([
            'user_id' => Auth::user()->id
        ]);

        Auth::user()->likes()->save($like);

        return redirect()->back();
    }

}
