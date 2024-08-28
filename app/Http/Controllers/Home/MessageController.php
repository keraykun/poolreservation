<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use App\Models\MessagesTitle;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $message)
    {

        $user = User::where('id',Auth::id())->with(['messagetitle'=>function($count){
             $count->withCount(['message'=>function($query){
                $query->where('seen',1);
             }])->orderBy('created_at','desc');
       }])->first();

       abort_if(Auth::id()!=$message->id,404);
       return view('home.message.show',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function inbox(MessagesTitle $message)
    {
        $user = User::where('id',Auth::id())
       ->with(['messagetitlebelong'=>function($query) use($message){
            $query->where('id',$message->id)
            ->with(['message']);
      }])->first();

      Messages::where('to_user_id',Auth::id())->where('messages_title_id',$message->id)
            ->update(['seen'=>0]);

        return view('home.message.inbox',['user'=>$user]);
    }


    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Messages $messages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Messages $messages)
    {
        //
    }
}
