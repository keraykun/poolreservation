<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
    {
        $currentDate = Carbon::now()->toDateString();
        $userLogs = Activity::where('causer_type', 'App\\Models\\User')
            ->where('causer_id', Auth::id())
            ->whereJsonContains('properties->is_release',0)
            ->whereIn('event', ['login', 'logout'])
            ->whereDate('created_at', $currentDate)
            ->orderBy('created_at')
            ->get();

        $firstLogin = null;
        $lastLogout = null;
        $firstLoginByDate = [];
        $lastLogoutByDate = []; // Array to store the last logout for each login date

        foreach ($userLogs as $log) {
            if ($log->event == 'login') {
                $date = Carbon::parse($log->created_at)->toDateString();
                if ($firstLogin === null || $log->created_at < $firstLogin->created_at) {
                    $firstLogin = $log;
                    if (!isset($firstLoginByDate[$date]) || $log->created_at < $firstLoginByDate[$date]->created_at) {
                        $firstLoginByDate[$date] = $log;
                    }
                }
            } elseif ($log->event == 'logout') {
                if ($lastLogout === null || $log->created_at > $lastLogout->created_at) {
                    $lastLogout = $log;
                }

                // Store the last logout date for the corresponding login date
                $loginDate = Carbon::parse($log->created_at)->toDateString();
                $lastLogoutByDate[$loginDate] = $log;
            }
        }

        $timer = '';

        if ($firstLogin && $lastLogout) {
            $firstLoginDate = Carbon::parse($firstLogin->created_at);
            $lastLogoutDate = Carbon::parse($lastLogout->created_at);

            $dateDiff = $firstLoginDate->diff($lastLogoutDate);

            $diffInSeconds = $dateDiff->s;
            $diffInMinutes = $dateDiff->i;
            $diffInHours = $dateDiff->h;

            $timer = "$diffInHours hours, $diffInMinutes minutes";
        }

        return view('employee.dashboard.index', [
            'activities' => $userLogs,
            'timer' => $timer,
            'login' => $firstLoginByDate,
            'logout' => $lastLogoutByDate, // Pass the last logout for each login date to the view
        ]);
    }

    // public function index()
    // {
    //     $userLogs = Activity::where('causer_type', 'App\\Models\\User')
    //     ->where('causer_id', 37)
    //     ->whereIn('event', ['login', 'logout'])
    //     ->orderBy('created_at')
    //     ->get();
    //     $firstLogin = null;
    //     $lastLogout = null;

    //     $firstLoginByDate = [];
    //     foreach ($userLogs as $log) {

    //         if ($log->event == 'login') {
    //             $date = Carbon::parse($log->created_at)->toDateString();
    //             if ($firstLogin === null || $log->created_at < $firstLogin->created_at) {
    //                 $firstLogin = $log;
    //                 if (!isset($firstLoginByDate[$date]) || $log->created_at < $firstLoginByDate[$date]->created_at) {
    //                     $firstLoginByDate[$date] = $log;
    //                 }
    //             }
    //         } elseif ($log->event == 'logout') {
    //             if ($lastLogout === null || $log->created_at > $lastLogout->created_at) {
    //                 $lastLogout = $log;
    //             }
    //         }
    //         }
    //         return $firstLoginByDate;
    //         $timer = '';
    //         if ($firstLogin && $lastLogout) {
    //             $firstLoginDate = Carbon::parse($firstLogin->created_at);
    //             $lastLogoutDate = Carbon::parse($lastLogout->created_at);

    //             $dateDiff = $firstLoginDate->diff($lastLogoutDate);

    //             $diffInSeconds = $dateDiff->s;
    //             $diffInMinutes = $dateDiff->i;
    //             $diffInHours = $dateDiff->h;

    //             $timer = "$diffInHours hours, $diffInMinutes minutes";
    //         }

    //         $activities = Activity::where('causer_id',Auth::id())->get();
    //         return view('employee.dashboard.index',['activities'=>$activities,'timer'=>$timer]);
    // }

    // public function index()
    // {
    //     $currentDate = Carbon::now()->toDateString();
    //     $userLogs = Activity::where('causer_type', 'App\\Models\\User')
    //     ->where('causer_id', Auth::id())
    //     ->whereIn('event', ['login', 'logout'])
    //     ->whereDate('created_at', $currentDate)
    //     ->orderBy('created_at')
    //     ->get();
    //     $firstLogin = null;
    //     $lastLogout = null;

    //     $firstLoginByDate = [];
    //     $lastOutByDate = [];
    //     foreach ($userLogs as $log) {
    //             if ($log->event == 'login') {
    //                 $date = Carbon::parse($log->created_at)->toDateString();
    //                 if ($firstLogin === null || $log->created_at < $firstLogin->created_at) {
    //                     $firstLogin = $log;
    //                     if (!isset($firstLoginByDate[$date]) || $log->created_at < $firstLoginByDate[$date]->created_at) {
    //                         $firstLoginByDate[$date] = $log;
    //                     }
    //                 }
    //             } elseif ($log->event == 'logout') {
    //                 if ($lastLogout === null || $log->created_at > $lastLogout->created_at) {
    //                     $lastLogout = $log;
    //                 }
    //             }

    //         }
    //         $timer = '';

    //         if ($firstLogin && $lastLogout) {
    //             $firstLoginDate = Carbon::parse($firstLogin->created_at);
    //             $lastLogoutDate = Carbon::parse($lastLogout->created_at);

    //             $dateDiff = $firstLoginDate->diff($lastLogoutDate);

    //             $diffInSeconds = $dateDiff->s;
    //             $diffInMinutes = $dateDiff->i;
    //             $diffInHours = $dateDiff->h;

    //             $timer = "$diffInHours hours, $diffInMinutes minutes";
    //         }
    //        // return $firstLoginByDate;
    //         return view('employee.dashboard.index',['activities'=>$userLogs,'timer'=>$timer,'login'=>$firstLoginByDate]);
    // }



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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
