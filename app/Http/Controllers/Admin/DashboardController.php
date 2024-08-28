<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\Foods;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\Announcements;
use App\Models\Concerns;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::now('Asia/Manila');

        $users = User::where('role','employee')
        ->withCount(['activities'=>function($query) use($today){
            $query->where('causer_type', 'App\\Models\\User')
            ->whereIn('event', ['login', 'logout'])
            ->whereDate('created_at',$today)
            ->orderBy('created_at');
        }])
        ->get();

        $processedUsers = [];


        foreach ($users as $user) {
            $activities = $user->activities;

            $firstLoginDate = null;
            $lastLogoutDate = null;

            foreach ($activities as $activity) {

                if(date('Y-m-d',strtotime($activity->created_at))!=date('Y-m-d',strtotime($today))){
                    continue;
                }

                if ($activity->event == 'login' && $firstLoginDate === null ||  $activity->created_at < $firstLoginDate) {
                    $firstLoginDate = $activity->created_at;
                } elseif ($activity->event == 'logout') {
                    $lastLogoutDate = $activity->created_at;
                }
            }

            // if ($firstLoginDate && $lastLogoutDate) {
            //     $durationInHours = $firstLoginDate->diffInHours($lastLogoutDate);
            //     $totalAmount = $durationInHours * 20;

            //     $processedUsers[] = [
            //         'user' => $user,
            //         'firstLoginDate' => $firstLoginDate,
            //         'lastLogoutDate' => $lastLogoutDate,
            //         'durationInHours' => $durationInHours,
            //         'totalAmount' => $totalAmount,
            //     ];
            // }
            if ($firstLoginDate && $lastLogoutDate) {
                $dateDiff = $firstLoginDate->diff($lastLogoutDate);
                $diffInMinutes = $dateDiff->i;
                $diffInHours = $dateDiff->h;

                $hoursWorked = "$diffInHours hours, $diffInMinutes minutes";
                // $totalAmount = round(($diffInHours + $diffInMinutes / 60) * 20);

                /*--- fix hour ---*/
                $durationInHours = $firstLoginDate->diffInHours($lastLogoutDate);
                $totalAmount = $durationInHours * 20;
                 /*------*/



                $processedUsers[] = [
                    'user' => $user,
                    'firstLoginDate' => $firstLoginDate,
                    'lastLogoutDate' => $lastLogoutDate,
                    'hoursWorked' => $hoursWorked,
                    'totalAmount' => $totalAmount,
                ];
            }
        }
        $announcement = Announcements::orderBy('due_at','desc')->first();

         $concern_count = Concerns::count();
         $users_count = User::where('role','user')->count();
         $bookings_pending = Bookings::where('payment','pending')->count();
         $bookings_reserve = Bookings::where('payment','reserve')->count();
         $bookings_paid = Bookings::where('payment','paid')->count();
         $bookings_expired = Bookings::where('payment','expired')->count();
         $foods_count = Foods::count();
         $room_count = Room::count();
         $employee_count =  User::where('role','employee')->count();
        //return $processedUsers;
        return view('admin.dashboard.index',[
            'activities'=>$processedUsers,
            'users_count'=>$users_count,
            'bookings_pending'=>$bookings_pending,
            'bookings_reserve'=>$bookings_reserve,
            'bookings_paid'=>$bookings_paid,
            'bookings_expired'=>$bookings_expired,
            'foods_count'=>$foods_count,
            'room_count'=>$room_count,
            'concern_count'=>$concern_count,
            'employee_count'=>$employee_count
            ,'announcement'=>$announcement
        ]);
    }

    public function history(User $employee)
    {
        //return $employee;
        $userLogs = Activity::where('causer_type', 'App\\Models\\User')
        ->where('causer_id',$employee->id)
        ->whereIn('event', ['login', 'logout'])
        ->orderBy('created_at')
        ->get();

    $loginLogoutTimes = [];

    foreach ($userLogs as $log) {
        $date = Carbon::parse($log->created_at)->toDateString();

        if ($log->event == 'login') {
            if (!isset($loginLogoutTimes[$date]['firstLogin'])) {
                $loginLogoutTimes[$date]['firstLogin'] = Carbon::parse($log->created_at)->format('H:i:s');
            }
            $loginLogoutTimes[$date]['user'] = $log->log_name;
        } elseif ($log->event == 'logout') {
            $loginLogoutTimes[$date]['logout'] = Carbon::parse($log->created_at)->format('H:i:s');
        }
    }

    $uniqueLoginDates = [];
    foreach ($loginLogoutTimes as $date => $times) {
        $uniqueLoginDates[] = [
            'date' => $date,
            'firstLogin' => $times['firstLogin'] ?? null,
            'lastLogout' => $times['logout'] ?? null,
            'name' => $times['user'] ?? null,
        ];

       // return $uniqueLoginDates;

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

    //return $uniqueLoginDates;
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

        return view('admin.dashboard.history',['activities'=>$uniqueLoginDates]);
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
