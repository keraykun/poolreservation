<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use App\Models\MessagesTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
       DB::transaction(function () use($request){
        $message =  MessagesTitle::create([
            'user_id'=>Auth::id(),
            'to_user_id'=>$request->user,
            'name'=>$request->title,
        ]);

        Messages::create([
            'messages_title_id'=>$message->id,
            'to_user_id'=>$request->user,
            'from_user_id'=>Auth::id(),
            'description'=>$request->message,
        ]);

       });
       header('Content-Type: application/json');
       return response()->json(['success'=>'Your message has been sent']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Messages $messages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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
