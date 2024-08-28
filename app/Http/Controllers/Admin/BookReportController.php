<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if($request->search){
            $search = $request->search;
            $bookings = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->where(function($query) use($search){
                $query->where('users.name','like','%'.$search.'%')
                ->whereIn('bookings.payment',['paid']);
            })
            ->orWhere(function($query) use( $search){
                $query->where('users.contact','like','%'.$search.'%')
                ->whereIn('bookings.payment',['paid']);
            })
            ->orWhere(function($query) use( $search){
                $query->where('bookings.title','like','%'.$search.'%')
                ->whereIn('bookings.payment',['paid']);
            })
            ->orWhere(function($query) use( $search){
                $query->where('bookings.payment','like','%'.$search.'%')
                ->whereIn('bookings.payment',['paid']);
            })
            ->orWhere(function($query) use( $search){
                $query->where('bookings_foods.name','like','%'.$search.'%')
                ->whereIn('bookings.payment',['paid']);
            })
            ->leftJoin('bookings_foods', 'bookings.id', '=', 'bookings_foods.booking_id')
            ->leftJoin('bookings_summaries', 'bookings.barcode', '=', 'bookings_summaries.barcode')
            ->leftJoin('gcashes', 'bookings.barcode', '=', 'gcashes.barcode')
            ->select(
                'bookings.user_id',
                'bookings.title',
                'bookings.payment',
                'bookings.expire',
                DB::raw("GROUP_CONCAT(CONCAT(bookings.start_time)) as concatenated_start_time"),
                DB::raw("GROUP_CONCAT(CONCAT(bookings.end_time)) as concatenated_end_time"),
                DB::raw("CONCAT(bookings.barcode) as concatenated_barcode"),
                DB::raw('(SELECT COUNT(*) FROM bookings_histories WHERE bookings_histories.user_id = users.id) as warning_count'),
                DB::raw("GROUP_CONCAT(CONCAT (bookings_foods.name)) as concatenated_foods_names"),
                'users.name',
                'users.contact',
                'gcashes.image',
                'bookings_summaries.room_price',
                'bookings_summaries.schedule_price',
                'bookings_summaries.total',
                'bookings_summaries.partial',
            )
            ->groupBy(
                'bookings.barcode',
                'bookings.user_id',
                'bookings.title',
                'bookings.payment',
                'bookings.expire',
                'users.id',
                'users.name',
                'users.contact',
                'gcashes.image',
                'bookings_summaries.room_price',
                'bookings_summaries.schedule_price',
                'bookings_summaries.total',
                'bookings_summaries.partial',
            )
            ->paginate(10);
        }else{
            $bookings = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->whereIn('bookings.payment',['paid','done'])
            ->leftJoin('bookings_foods', 'bookings.id', '=', 'bookings_foods.booking_id')
            ->leftJoin('bookings_summaries', 'bookings.barcode', '=', 'bookings_summaries.barcode')
            ->leftJoin('gcashes', 'bookings.barcode', '=', 'gcashes.barcode')
            ->select(
                'bookings.user_id',
                'bookings.title',
                'bookings.payment',
                'bookings.expire',
                DB::raw("GROUP_CONCAT(CONCAT(bookings.start_time)) as concatenated_start_time"),
                DB::raw("GROUP_CONCAT(CONCAT(bookings.end_time)) as concatenated_end_time"),
                DB::raw("CONCAT(bookings.barcode) as concatenated_barcode"),
                DB::raw('(SELECT COUNT(*) FROM bookings_histories WHERE bookings_histories.user_id = users.id) as warning_count'),
                DB::raw("GROUP_CONCAT(CONCAT (bookings_foods.name)) as concatenated_foods_names"),
                'users.name',
                'users.contact',
                'gcashes.image',
                'bookings_summaries.room_price',
                'bookings_summaries.schedule_price',
                'bookings_summaries.total',
                'bookings_summaries.partial',
            )
            ->orderBy('bookings.updated_at','desc')
            ->groupBy(
                'bookings.barcode',
                'bookings.user_id',
                'bookings.title',
                'bookings.payment',
                'bookings.expire',
                'users.id',
                'users.name',
                'users.contact',
                'gcashes.image',
                'bookings_summaries.room_price',
                'bookings_summaries.schedule_price',
                'bookings_summaries.total',
                'bookings_summaries.partial',
            )
            ->paginate(10);


        }

       // return $bookings = Bookings::with(['user.warning'])->get();
        $user = User::where('id',Auth::id())->where('role','admin')->first();
        return view('admin.bookingsreports.index')->with(compact('bookings'));
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
