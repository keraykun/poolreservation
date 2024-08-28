<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class BookedHistoryController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    //      $bookings = DB::table('bookings_cancelleds')
    //         ->where('bookings_cancelleds.user_id','=',Auth::id())
    //         ->join('users', 'bookings_cancelleds.user_id', '=', 'users.id')
    //         ->leftJoin('bookings_foods', 'bookings_cancelleds.booking_id', '=', 'bookings_foods.booking_id')
    //         ->leftJoin('bookings_summaries', 'bookings_cancelleds.barcode', '=', 'bookings_summaries.barcode')
    //         ->leftJoin('gcashes', 'bookings_cancelleds.barcode', '=', 'gcashes.barcode')
    //         ->select(
    //             'bookings_cancelleds.user_id',
    //             DB::raw("MIN(bookings_cancelleds.booking_id) as id"),
    //             'bookings_cancelleds.title',
    //             'bookings_cancelleds.payment',
    //             'bookings_cancelleds.expire',
    //             'bookings_cancelleds.is_rated',
    //             DB::raw("GROUP_CONCAT(DISTINCT (bookings_cancelleds.start_time)) as concatenated_start_time"),
    //             DB::raw("GROUP_CONCAT(DISTINCT (bookings_cancelleds.end_time)) as concatenated_end_time"),
    //             DB::raw("GROUP_CONCAT(CONCAT (bookings_foods.name)) as concatenated_foods_names"),
    //             DB::raw("CONCAT(bookings_cancelleds.barcode) as concatenated_barcode"),
    //             'users.name',
    //             'users.contact',
    //             'users.contact',
    //             'bookings_summaries.room_price',
    //             'bookings_summaries.schedule_price',
    //             'bookings_summaries.food_price',
    //             'bookings_summaries.total',
    //             'gcashes.barcode as gcash_code'
    //         )
    //         ->groupBy(
    //             'bookings_cancelleds.barcode',
    //             'bookings_cancelleds.user_id',
    //             'bookings_cancelleds.title',
    //             'bookings_cancelleds.is_rated',
    //             'bookings_cancelleds.payment',
    //             'bookings_cancelleds.expire',
    //             'users.id',
    //             'users.name',
    //             'users.contact',
    //             'bookings_summaries.room_price',
    //             'bookings_summaries.schedule_price',
    //             'bookings_summaries.food_price',
    //             'bookings_summaries.total',
    //             'gcashes.barcode'
    //         )
    // ->get();

     $bookings = DB::table('bookings')
        ->where('bookings.user_id','=',Auth::id())
        ->whereIn('bookings.payment',['cancelled','expired'])
        ->join('users', 'bookings.user_id', '=', 'users.id')
        ->leftJoin('bookings_foods', 'bookings.id', '=', 'bookings_foods.booking_id')
        ->leftJoin('bookings_summaries', 'bookings.barcode', '=', 'bookings_summaries.barcode')
        ->leftJoin('gcashes', 'bookings.barcode', '=', 'gcashes.barcode')
        ->select(
            'bookings.user_id',
            DB::raw("MIN(bookings.id) as id"),
            'bookings.title',
            'bookings.payment',
            'bookings.expire',
            'bookings.is_rated',
            DB::raw("GROUP_CONCAT(DISTINCT (bookings.start_time)) as concatenated_start_time"),
            DB::raw("GROUP_CONCAT(DISTINCT (bookings.end_time)) as concatenated_end_time"),
            DB::raw("GROUP_CONCAT(CONCAT (bookings_foods.name)) as concatenated_foods_names"),
            DB::raw("CONCAT(bookings.barcode) as concatenated_barcode"),
            'users.name',
            'users.contact',
            'users.contact',
            'bookings_summaries.room_price',
            'bookings_summaries.schedule_price',
            'bookings_summaries.food_price',
            'bookings_summaries.total',
            'gcashes.barcode as gcash_code'
        )
        ->groupBy(
            'bookings.barcode',
            'bookings.user_id',
            'bookings.title',
            'bookings.is_rated',
            'bookings.payment',
            'bookings.expire',
            'users.id',
            'users.name',
            'users.contact',
            'bookings_summaries.room_price',
            'bookings_summaries.schedule_price',
            'bookings_summaries.food_price',
            'bookings_summaries.total',
            'gcashes.barcode'
        )
    ->get();


    abort_if(Auth::check()==null,403);

    abort_if(Auth::id()==null,404);
   return view('home.history.show')->with(compact('bookings'));
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
