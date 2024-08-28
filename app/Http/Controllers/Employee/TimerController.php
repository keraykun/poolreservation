<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TimerController extends Controller
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
        try {
            $user = Auth::user();
            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->inLog($user->email)
                ->withProperties([
                    'is_release'=>0,
                    'login' =>Carbon::now(),
                ])
                ->event('login')
                ->log('The '.$user->name.' has been login');
        } catch (\Exception $e) {
            \Log::error('Error logging activity: ' . $e->getMessage());
            \Log::error($e);
        }

        return redirect()->back()->with('success','The timer has been started');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

        $user = Auth::user();
        if($user->role=='employee'){
                activity()
                ->performedOn($user)
                ->causedBy($user)
                ->inLog($user->email)
                ->withProperties([
                    'is_release'=>0,
                    'logout' =>Carbon::now(),
                ])

                ->event('logout')
                ->log('The ' . $user->name . ' has been logged out');
        }
        return redirect()->back()->with('success','The timer has been ended');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
