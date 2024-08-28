<?php

namespace App\Http\Controllers;

use App\Models\Ratings;
use Illuminate\Http\Request;
use App\Models\Announcements;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $announcement = Announcements::orderBy('due_at','asc')->first();
        $ratings = Ratings::with(['booking.user','food','comment','pool','room','staff'])
        ->orderBy('booked_at','desc')
        ->take(3)
        ->get();
        $count = Ratings::count();
        return view('home/index',['ratings'=>$ratings,'count'=>$count,'announcement'=>$announcement]);
    }
}
