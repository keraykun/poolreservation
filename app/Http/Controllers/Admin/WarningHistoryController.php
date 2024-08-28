<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingsHistory;
use App\Models\MessagesTitle;
use Illuminate\Http\Request;

class WarningHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $bookings = BookingsHistory::with('user')->get();
        // return view('admin.warning.index',['bookings'=>$bookings]);
        $messages = MessagesTitle::with(['client'])
       ->withCount('message as total_message')
       ->get();
        return view('admin.warning.index',['messages'=>$messages]);
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
    public function show(string $id)
    {
        $warning = MessagesTitle::where('id',$id)->with(['client','message','user'])
       ->first();

       return view('admin.warning.show',['warning'=>$warning]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
