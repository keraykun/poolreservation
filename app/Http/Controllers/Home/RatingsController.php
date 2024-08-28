<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\Ratings;
use App\Models\RatingsComments;
use App\Models\RatingsFoods;
use App\Models\RatingsPools;
use App\Models\RatingsRooms;
use App\Models\RatingsStaffs;
use App\Models\BookingsHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    public function index()
    {
        $ratings = Ratings::with(['booking.user','food','comment','pool','room','staff'])->orderBy('booked_at','desc')->get();
        $count = Ratings::count();
        return view('home.rating.index',['ratings'=>$ratings,'count'=>$count]);
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

       //return $request;
       Bookings::where('barcode',$request->barcode)->update([
        'is_rated'=>1
       ]);

       $request->validate([
            'room'=>['required'],
            'food'=>['required'],
            'pool'=>['required'],
            'staff'=>['required'],
       ]);


      DB::transaction(function () use($request){
        $rating = Ratings::create([
            'booking_id'=>$request->booking_id,
            'booked_at'=>$request->start_time
        ]);
        RatingsRooms::create([
            'rating_id'=>$rating->id,
            'star'=>$request->room,
        ]);
        RatingsFoods::create([
            'rating_id'=>$rating->id,
            'star'=>$request->food,
        ]);
        RatingsPools::create([
            'rating_id'=>$rating->id,
            'star'=>$request->pool,
        ]);
        RatingsStaffs::create([
            'rating_id'=>$rating->id,
            'star'=>$request->staff,
        ]);
        RatingsComments::create([
            'rating_id'=>$rating->id,
            'comments'=>$request->comment,
        ]);
      });

      Bookings::where('barcode',$request->barcode)->update([
        'payment'=>'done',
        'expire'=>null
      ]);
      return redirect()->route('home.rating.index');
    }

    public function done(Request $request)
    {

        Bookings::where('barcode',$request->barcode)->update([
            'payment'=>'done',
            'expire'=>null
        ]);
        $booking = Bookings::where('barcode',$request->barcode)->first();
        // BookingsHistory::create([
        //     'user_id'=>$request->user_id,
        //     'title'=>$request->room,
        //     'payment'=>$request->payment,
        //     'barcode'=>$request->barcode,
        //     'date_booked'=>$request->schedule,
        //     'warning'=>0
        // ]);
       // Bookings::where('barcode',$request->barcode)->delete();
        header('Content-Type: application/json');
        return response()->json($booking);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Bookings $rating)
    {

        $this->middleware('auth');
        abort_if($rating==null,404);
        //$booking = Bookings::where('barcode',$rating)->where('payment','paid')->first();
        $booking = Bookings::where('id',$rating->id)
        ->where('is_rated',null)
        ->where('user_id',$rating->user_id)
        ->where('payment','done')->first();
        abort_if($booking==null,404);
        return view('home.rating.show',['booking'=>$booking]);
    }

    public function list(String $rating)
    {

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ratings $ratings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ratings $ratings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ratings $ratings)
    {
        //
    }
}
