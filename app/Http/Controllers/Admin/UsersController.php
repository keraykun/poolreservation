<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->search){
            $users = User::
            where('users.role','user')
            ->where('name','like','%'.$request->search.'%')
            ->orWhere('email','like','%'.$request->search.'%')
            ->orWhere('contact','like','%'.$request->search.'%')
            ->withCount('warning as warning_count')
            ->where('role','user')->paginate(10);
        }else{
            $users = User::withCount('warning as warning_count')->where('role','user')->paginate(10);
        }
        return view('admin.users.index',compact('users'));
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
         User::where('id',$user->id)->update(['active'=>0]);
        return redirect()->back()->with('success','User '.$user->name.' has been banned');
    }

    public function unban(Request $request, User $user)
    {
        User::where('id',$user->id)->update(['active'=>1]);
        return redirect()->back()->with('success','User '.$user->name.' has been remove from banned');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
