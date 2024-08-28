<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $users = User::where('role','employee')
        // ->withCount(['activities'=>function($query) use($today){
        //     $query->where('causer_type', 'App\\Models\\User')
        //     ->whereIn('event', ['login', 'logout'])
        //     ->orderBy('created_at');
        // }])
        // ->get();

        return view('admin.employee.index');
    }


    public function history(User $employee)
    {

        $userLogs = Activity::where('causer_type', 'App\\Models\\User')
        ->where('causer_id',$employee->id)
        ->whereJsonContains('properties->is_release',0)
        ->whereIn('event', ['login', 'logout'])
        ->orderBy('created_at')
        ->get();

        $loginLogoutTimes = [];

        foreach ($userLogs as $log) {
            $date = Carbon::parse($log->created_at)->toDateString();
            $loginLogoutTimes[$date]['user_id'] = $log->causer_id;
            if ($log->event == 'login') {
                if (!isset($loginLogoutTimes[$date]['firstLogin'])) {
                    $loginLogoutTimes[$date]['login_id'] = $log->id;
                    $loginLogoutTimes[$date]['firstLogin'] = Carbon::parse($log->created_at)->format('H:i:s');
                }
                $loginLogoutTimes[$date]['user'] = $log->log_name;
            } elseif ($log->event == 'logout') {
                $loginLogoutTimes[$date]['logout_id'] = $log->id;
                $loginLogoutTimes[$date]['logout'] = Carbon::parse($log->created_at)->format('H:i:s');
            }
        }

        $uniqueLoginDates = [];
        foreach ($loginLogoutTimes as $date => $times) {
            $uniqueLoginDates[] = [
                'user_id' => $times['user_id'] ?? null,
                'date' => $date,
                'login_id' => $times['login_id'] ?? null,
                'firstLogin' => $times['firstLogin'] ?? null,
                'logout_id' => $times['logout_id'] ?? null,
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

       // return $uniqueLoginDates;
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



        return view('admin.employee.history',['activities'=>$uniqueLoginDates,'employee'=>$employee]);
    }


    public function paid(Request $request, User $employee)
    {

        $monthSalary = $request->search;
        if($request->search){
            $search =  $request->search;
            $userLogs = Activity::where('causer_type', 'App\\Models\\User')
            ->whereMonth('created_at',$search)
            ->where('causer_id',$employee->id)
            ->whereJsonContains('properties->is_release',1)
            ->whereIn('event', ['login', 'logout'])
            ->orderBy('created_at')
            ->get();
        }else{
            $userLogs = Activity::where('causer_type', 'App\\Models\\User')
            ->where('causer_id',$employee->id)
            ->whereJsonContains('properties->is_release',1)
            ->whereIn('event', ['login', 'logout'])
            ->orderBy('created_at')
            ->get();
        }


        $loginLogoutTimes = [];

        foreach ($userLogs as $log) {
            $date = Carbon::parse($log->created_at)->toDateString();
            $loginLogoutTimes[$date]['user_id'] = $log->causer_id;
            if ($log->event == 'login') {
                if (!isset($loginLogoutTimes[$date]['firstLogin'])) {
                    $loginLogoutTimes[$date]['login_id'] = $log->id;
                    $loginLogoutTimes[$date]['firstLogin'] = Carbon::parse($log->created_at)->format('H:i:s');
                }
                $loginLogoutTimes[$date]['user'] = $log->log_name;
            } elseif ($log->event == 'logout') {
                $loginLogoutTimes[$date]['logout_id'] = $log->id;
                $loginLogoutTimes[$date]['logout'] = Carbon::parse($log->created_at)->format('H:i:s');
            }
        }

        $uniqueLoginDates = [];
        foreach ($loginLogoutTimes as $date => $times) {
            $uniqueLoginDates[] = [
                'user_id' => $times['user_id'] ?? null,
                'date' => $date,
                'login_id' => $times['login_id'] ?? null,
                'firstLogin' => $times['firstLogin'] ?? null,
                'logout_id' => $times['logout_id'] ?? null,
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

       // return $uniqueLoginDates;
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


        $monthSalary = date('F',strtotime($monthSalary));
        return view('admin.employee.paid',['salary'=>$monthSalary,'paginated' => $paginatedItems,'activities'=>$uniqueLoginDates,'employee'=>$employee]);
    }

    public function  list(){
        $users = User::where('role','employee')
        ->withCount(['activities'=>function($query){
            $query->where('causer_type', 'App\\Models\\User')
            ->whereIn('event', ['login', 'logout'])
            ->orderBy('created_at');
        }])
        ->get();

        $tableRows = '';
        foreach ($users as $user) {
            $tableRows .= '<tr>';
            $tableRows .= '<td><a style="color:#50b8e7;" href="'.route('admin.employee.history',$user->id).'">' . $user->name . '</a></td>';
            $tableRows .= '<td>' . $user->email . '</td>';
            $tableRows .= '<td>' . $user->contact . '</td>';
            $tableRows .= '<td>';
            $tableRows .= '<a href="'.route('admin.employee.history',$user->id).'" class="mr-2 btn-sm btn bg-lime-700 hover:bg-lime-600 text-white rounded-md shadow-md">UNPAID</a>';
            $tableRows .= '<a href="'.route('admin.employee.paid',$user->id).'" class="btn-sm btn bg-sky-700 hover:bg-sky-800 text-white rounded-md shadow-md">PAID</a>';
            $tableRows .= '</td>';
            $tableRows .= '<td>';
            $tableRows .= '<button type="button"  class="mr-2 btn-sm btn bg-sky-700 hover:bg-sky-800 text-white rounded-md shadow-md" onclick="editEmployee('.$user->id.')">EDIT</button>';
            $tableRows .= '<button type="button"  class="btn-sm btn bg-red-700 hover:bg-red-800 text-white rounded-md shadow-md" onclick="deleteEmployee('.$user->id.')">DELETE</button>';
            $tableRows .= '</td>';
            $tableRows .= '</tr>';
        }

        echo $tableRows;
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


        User::create([
            'name'=>$request->employeeName,
            'email'=>$request->employeeEmail,
            'contact'=>$request->employeeContact,
            'role'=>'employee',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        return response()->json(['message'=>'successfully added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $employee)
    {
        //return $employee;


        $today = Carbon::now('Asia/Manila');

        $user = User::where('role','employee')
        ->where('id',$employee->id)
        ->with(['activities'=>function($query) use($today){
            $query->where('causer_type', 'App\\Models\\User')
            ->whereIn('event', ['login', 'logout'])
            ->whereDate('created_at',$today)
            ->orderBy('created_at');
        }])
        ->first();

        return view('admin.employee.show',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $employee)
    {
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $employee)
    {

        User::where('id',$employee->id)
        ->update([
            'name'=>$request->editEmployeeName,
            'contact'=>$request->editEmployeeContact,
        ]);
        return response()->json(['message'=>'successfully updated']);

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $employee)
    {
        User::destroy($employee->id);
        return response()->json(['message'=>'successfully deleted']);
    }
}
