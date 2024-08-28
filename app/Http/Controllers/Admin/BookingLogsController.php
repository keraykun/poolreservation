<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingsHistory;
use Illuminate\Http\Request;
use DB;

class BookingLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


         $bookings = DB::table('bookings')
        ->join('users', 'bookings.user_id', '=', 'users.id')
        ->whereNotIn('bookings.payment',['pending','paid'])
        ->select(
            'bookings.user_id',
            'bookings.title',
            'bookings.payment',
            'bookings.expire',
            DB::raw("GROUP_CONCAT(CONCAT(bookings.start_time)) as concatenated_start_time"),
            DB::raw("GROUP_CONCAT(CONCAT(bookings.end_time)) as concatenated_end_time"),
            DB::raw("CONCAT(bookings.barcode) as concatenated_barcode"),
            DB::raw('(SELECT COUNT(*) FROM bookings_histories WHERE bookings_histories.user_id = users.id) as warning_count'),
            'users.name',
            'users.contact',
            'users.contact',
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
        )
        ->get();
        return view('admin.bookingslogs.index')->with(compact('bookings'));
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
       return 'here';
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
        return 'here';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
