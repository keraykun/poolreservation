<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bookings;
use Illuminate\Support\Carbon;

class BookedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('home.booked.index');
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
         $user = User::where('id',Auth::id())
        ->whereHas('booking',function($query){
            $query->where('payment','pending')
            ->orWhere('payment','paid');
        })
        ->with('booking')->first();

        abort_if(Auth::check()==null,403);
        abort_if(Auth::id()==null,404);

        if($user==null){
            return redirect()->route('home.booked.index');
        }

        if($user->booking==null){
            return redirect()->route('home.booked.index');
        }

        $toDay = Carbon::now('Asia/Manila');
        if ($toDay->gt($user->booking->expire)) {
            $expiration = 'Expired';
            Bookings::where('barcode',$user->booking->barcode)
            ->where('payment','pending')
            ->update(['payment'=>'Expired']);
        } else {
            $expiration = $toDay->diffForHumans($user->booking->expire).' Expiration ';
        }
       return view('home.booked.show')->with(compact('user','expiration'));
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
