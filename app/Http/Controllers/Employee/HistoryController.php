<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        if($request->search){

         $search =  $request->search;
        $userLogs = Activity::where('causer_type', 'App\\Models\\User')
        ->whereMonth('created_at',$search)
        ->whereJsonContains('properties->is_release',1)
        ->where('causer_id',Auth::id())
        ->whereIn('event', ['login', 'logout'])
        ->orderBy('created_at')
        ->get();

        }else{
            $userLogs = Activity::where('causer_type', 'App\\Models\\User')
            ->where('causer_id',Auth::id())
            ->whereJsonContains('properties->is_release',1)
            ->whereIn('event', ['login', 'logout'])
            ->orderBy('created_at')
            ->get();
        }

    $loginLogoutTimes = [];

    foreach ($userLogs as $log) {
        $date = Carbon::parse($log->created_at)->toDateString();

        if ($log->event == 'login') {
            if (!isset($loginLogoutTimes[$date]['firstLogin'])) {
                $loginLogoutTimes[$date]['firstLogin'] = Carbon::parse($log->created_at)->format('H:i:s');
                $loginLogoutTimes[$date]['login_id'] = $log->id;
            }
        } elseif ($log->event == 'logout') {
            $loginLogoutTimes[$date]['logout'] = Carbon::parse($log->created_at)->format('H:i:s');
            $loginLogoutTimes[$date]['logout_id'] = $log->id;
        }
    }

   // return $loginLogoutTimes;

    $uniqueLoginDates = [];
    foreach ($loginLogoutTimes as $date => $times) {
        $uniqueLoginDates[] = [
            'date' => $date,
            'login_id' => $times['login_id'] ?? null,
            'firstLogin' => $times['firstLogin'] ?? null,
            'logout_id' => $times['logout_id'] ?? null,
            'lastLogout' => $times['logout'] ?? null,
        ];

        // Calculate the hours
        if(isset($times['logout']) || isset($times['logout'])){
            if ($times['firstLogin'] && $times['logout']) {
                $firstLoginDate = Carbon::parse($date . ' ' . $times['firstLogin']);
                $lastLogoutDate = Carbon::parse($date . ' ' . $times['logout']);

                $dateDiff = $firstLoginDate->diff($lastLogoutDate);

                $diffInMinutes = $dateDiff->i;
                $diffInHours = $dateDiff->h;

                $hoursWorked = "$diffInHours hours, $diffInMinutes minutes";
              //  $totalAmount = round(($diffInHours + $diffInMinutes / 60) * 20); // Round to the nearest whole number
                     /*--- fix hour ---*/
                $durationInHours = $firstLoginDate->diffInHours($lastLogoutDate);
                $totalAmount = $durationInHours * 20;
                      /*------*/

                $uniqueLoginDates[count($uniqueLoginDates) - 1]['hours'] = $hoursWorked;
                $uniqueLoginDates[count($uniqueLoginDates) - 1]['totalAmount'] = $totalAmount;
            }
        }

    }


    $currentDate = date('Y-m-d');

    // Sort the array with a custom comparison function
    usort($uniqueLoginDates, function($a, $b) use ($currentDate) {
        if ($a['date'] == $currentDate) {
            return -1; // $a (current date) comes first
        } elseif ($b['date'] == $currentDate) {
            return 1; // $b (current date) comes first
        } else {
            return strtotime($a['date']) - strtotime($b['date']);
        }
    });


    $perPage = 10; // Adjust the number of items per page as needed
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $currentItems = array_slice($uniqueLoginDates, ($currentPage - 1) * $perPage, $perPage);

    $paginatedItems = new LengthAwarePaginator($currentItems, count($uniqueLoginDates), $perPage);
    $paginatedItems->setPath(url()->current());


   // return $uniqueLoginDates;
     $monthSalary = $request->search;
   // return $monthSalary = date('F',strtotime($dates));
    return view('employee.history.index',['salary'=>$monthSalary,'paginated' => $paginatedItems,'activities'=>$uniqueLoginDates]);
    }


    // public function index()
    // {
    //     $userLogs = Activity::where('causer_type', 'App\\Models\\User')
    //         ->where('causer_id', Auth::id())
    //         ->whereIn('event', ['login', 'logout'])
    //         ->orderBy('created_at')
    //         ->get();

    //     $loginLogoutTimes = [];

    //     foreach ($userLogs as $log) {
    //         $date = Carbon::parse($log->created_at)->toDateString();

    //         if ($log->event == 'login') {
    //             if (!isset($loginLogoutTimes[$date]['firstLogin'])) {
    //                 $loginLogoutTimes[$date]['firstLogin'] = [
    //                     'time' => Carbon::parse($log->created_at)->format('H:i:s'),
    //                     'id' => $log->causer_id,
    //                 ];
    //             }
    //         } elseif ($log->event == 'logout') {
    //             $loginLogoutTimes[$date]['logout'] = [
    //                 'time' => Carbon::parse($log->created_at)->format('H:i:s'),
    //                 'id' => $log->causer_id,
    //             ];
    //         }
    //     }

    //     $uniqueLoginDates = [];

    //     foreach ($loginLogoutTimes as $date => $times) {
    //         $uniqueLoginDates[] = [
    //             'date' => $date,
    //             'firstLogin' => $times['firstLogin'] ?? null,
    //             'lastLogout' => $times['logout'] ?? null,
    //         ];

    //         if (isset($times['firstLogin']['time']) && isset($times['logout']['time'])) {
    //             $firstLoginDate = Carbon::parse($date . ' ' . $times['firstLogin']['time']);
    //             $lastLogoutDate = Carbon::parse($date . ' ' . $times['logout']['time']);

    //             $dateDiff = $firstLoginDate->diff($lastLogoutDate);

    //             $diffInMinutes = $dateDiff->i;
    //             $diffInHours = $dateDiff->h;

    //             $hoursWorked = "$diffInHours hours, $diffInMinutes minutes";

    //             $durationInHours = $firstLoginDate->diffInHours($lastLogoutDate);
    //             $totalAmount = $durationInHours * 20;

    //             $uniqueLoginDates[count($uniqueLoginDates) - 1]['hours'] = $hoursWorked;
    //             $uniqueLoginDates[count($uniqueLoginDates) - 1]['totalAmount'] = $totalAmount;
    //             $uniqueLoginDates[count($uniqueLoginDates) - 1]['userId'] = $times['firstLogin']['id'];
    //         }
    //     }

    //     $currentDate = date('Y-m-d');

    //     usort($uniqueLoginDates, function ($a, $b) use ($currentDate) {
    //         if ($a['date'] == $currentDate) {
    //             return -1;
    //         } elseif ($b['date'] == $currentDate) {
    //             return 1;
    //         } else {
    //             return strtotime($a['date']) - strtotime($b['date']);
    //         }
    //     });

    //     return $uniqueLoginDates;
    //     // return view('employee.history.index', ['activities' => $uniqueLoginDates]);
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

       $userLogs = Activity::where('causer_type', 'App\\Models\\User')
       ->where('causer_id', Auth::id())
       ->whereIn('event', ['login', 'logout'])
       ->whereDate('created_at', $id)
       ->orderBy('created_at')
       ->get();
       $firstLogin = null;
       $lastLogout = null;

       $firstLoginByDate = [];
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

           return view('employee.history.show',['activities'=>$userLogs,'timer'=>$timer]);

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
