<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

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

        $user = User::find($request->user_id);
         if($user->role=='employee'){

            $date = date('Y-m-d',strtotime($request->start_time));
            $check = Activity::where('causer_id',$user->id)->whereDate('created_at',$date)->count();
            if($check>0){
               return redirect()->back()->with('danger',date('M d ,Y',strtotime($date)).' is already exist or started');
            }

            $dateTime = Carbon::parse($request->start_time);

            activity()
            ->performedOn($user)
            ->causedBy($user)
            ->inLog($user->email)
            ->withProperties([
                'is_release'=>0,
                'login' =>$dateTime,
            ])
            ->createdAt($dateTime)
            ->event('login')
            ->log('The ' . $user->name . ' has been login out');
            return redirect()->back()->with('success','The timer has been started');
        }
        abort(500);
    }

    public function out(Request $request)
    {
         $date = $request->start_date.' '.$request->end_time;

         $dateTime = Carbon::parse($date);
         $user = User::find($request->user_id);
        if($user->role=='employee'){
                activity()
                ->performedOn($user)
                ->causedBy($user)
                ->inLog($user->email)
                ->withProperties([
                    'is_release'=>0,
                    'logout' =>$dateTime,
                ])
                ->createdAt($dateTime)
                ->event('logout')
                ->log('The ' . $user->name . ' has been logged out');
                return redirect()->back()->with('success','The timer has been ended');
        }
        abort(500);
    }


    public function release(Request $request)
    {
      //  return $request;

        $user = User::find($request->user_id);

        Activity::where('causer_type', 'App\\Models\\User')
        ->where('causer_id',$user->id)
        ->whereJsonContains('properties->is_release',0)
        ->whereIn('event', ['login', 'logout'])
        ->update(['properties->is_release' => 1]);
        return redirect()->back()->with('success','Salary has been released !');
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
        //
    }

    public function timein(Request $request, string $id)
    {
      //return $request;
      $date = $request->start_date.' '.$request->start_time;
      Activity::where('id',$request->login_id)->update([
        'created_at'=>$date
      ]);
      return redirect()->back()->with('success','Start time has been updated!');
    }

    public function timeout(Request $request, string $id)
    {

     //   return $request;
      $date = $request->start_date.' '.$request->end_time;
      Activity::where('id',$request->logout_id)->update([
        'created_at'=>$date
      ]);
      return redirect()->back()->with('success','Out time has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
