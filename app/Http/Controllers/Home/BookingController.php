<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Bookings;
use App\Models\BookingsCancelled;
use App\Models\BookingsFoods;
use App\Models\BookingsHistory;
use App\Models\BookingsRooms;
use App\Models\BookingsSchedules;
use App\Models\BookingsSummary;
use App\Models\Foods;
use App\Models\Gcash;
use App\Models\Room;
use App\Models\Schedules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;



class BookingController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {

       $this->middleware('auth')->only(['store']);
       foreach (Bookings::where('payment','pending')->get() as $booking) {
            $toDay = Carbon::now('Asia/Manila');
            if ($toDay->gt($booking->expire)) {
                Bookings::where('barcode',$booking->concatenated_barcode)
                ->where('payment','pending')
                ->update(['payment'=>'Expired']);
            }
        }
    }

    public function list(Request $request)
    {
       $month =  date('m',strtotime($request->startDate));
       $day = date('d',strtotime($request->startDate));
       $year = date('Y',strtotime($request->startDate));
       $list = DB::table('bookings')
       ->whereNotIn('payment',['expired','ended','cancelled'])
       ->join('users', 'bookings.user_id', '=', 'users.id')
       ->whereYear('start_time',$year)
       ->whereMonth('start_time',$month)
       ->whereDay('start_time',$day)
       ->whereRaw('HOUR(start_time) != 0')
       ->get();
        return $list;
    }


    public function index()
    {


        // $user = Bookings::where('user_id',Auth::id())->where('payment','pending')->first();
        // if($user){
        //     return redirect()->route('home.bookings.show',Auth::id());
        // }
       // return $booking = Bookings::all();
       // return $booking = Bookings::where('user_id',Auth::id())->with(['user.warning'])->first();
        $booking = BookingsHistory::where('user_id',Auth::id())->where('warning',1)->count();
        $schedules = Schedules::all();
        $rooms = Room::all();
        $foods = Foods::all();
        return view('home.bookings.index')->with(compact('schedules','booking','rooms','foods'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function done(Request $request)
    {
        return 'here';
        // Bookings::where('barcode',$book)->update([
        //     'payment'=>'done',
        //     'expire'=>null
        // ]);

        // DB::transaction(function() use($request){
        //     BookingsHistory::create([
        //         'user_id'=>$request->user_id,
        //         'title'=>$request->title,
        //         'payment'=>$request->payment,
        //         'barcode'=>$request->barcode,
        //         'date_booked'=>$request->date_booked
        //    ]);
        // Bookings::where('barcode',$request->barcode)->delete();
        // });

        return redirect()->back()->with('success','Schedule has been Approved !');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(auth()->user()->role=='admin' || auth()->user()->role=='employee'){
            header('Content-Type: application/json');
            return response()->json(['user'=>Auth::id(),'moderator'=>"Sorry moderator not allowed to book."]);
        }

         $summaryTime = intval(str_replace(',', '',$request->summaryTimeSub));
         $summaryRoom = intval(str_replace(',', '',$request->summaryRoomSub));


         $user = Bookings::where('user_id',Auth::id())
         ->whereIn('payment',['pending','paid','reserve'])
         ->count();

         if($user>=3){
             header('Content-Type: application/json');
             return response()->json(['user'=>Auth::id(),
             'exist'=>"
             You have already reached the maximum booking limit.
              A total of 3 bookings, including pending and paid, reserve ,
               has been reached. No further bookings can be processed at this time.
               Please review your booking history or contact customer support for assistance.."]);
         }


        // $user = Bookings::where('user_id',Auth::id())
        // ->whereNotIn('payment',['pending','ended','done','reserve','cancelled','expired'])
        // ->count();

        // if($user>0){
        //     header('Content-Type: application/json');
        //     return response()->json(['user'=>Auth::id(),'exist'=>" You already have a on going schedule. Please wait for the current schedule."]);
        // }

        $user = User::where('id',Auth::id())->first();
        $startDate = explode(" ",$request->startDate)[0];
         $startTime = explode(" ",$request->startDate)[1];
         $endTime = explode(" ",$request->startDate)[3];
        //$splitTime = $request->input('  ');

        // $startDate = $request->input('startDate');

        $date = date('mdY',strtotime(Carbon::now('Asia/Manila')));
        $time = date('his',strtotime(Carbon::now('Asia/Manila')));
        $barCode = str_pad($user->id.'-'.$date.'-'.$time, 10, STR_PAD_RIGHT);

        // $startTime = explode(" ",$splitTime)[0];
        // $endTime = explode(" ",$splitTime)[1];

        // $startDatetime = Carbon::parse("$startDate $startTime");
        // $endDatetime = Carbon::parse("$startDate $endTime");

        $startDatetime = Carbon::parse("$startDate $startTime");
        $endDatetime = Carbon::parse("$startDate $endTime");



        $rangeExists = Bookings::where(function ($query) use ($startDatetime, $endDatetime) {
            $query->where('start_time', '<=', $endDatetime)
                  ->where('end_time', '>=', $startDatetime)
                  ->whereNotIn('payment',['expired','ended','done','pending','cancelled']);
        })
        ->exists();

        if ($rangeExists) {
            header('Content-Type: application/json');
            return response()->json(['error'=>"the schedule time is already taken, or adjust another minutes for your schedule thank you."]);
        }

        if($startDatetime->diffInHours($endDatetime)===12){
            $currentDate = Carbon::now()->startOfDay();
            $targetDate = Carbon::parse("$startDate")->addDay();

            if ($targetDate->isAfter($currentDate)) {
                $startCreatedDate =  Carbon::parse($startDate." ".date('H:i:s',strtotime(Carbon::create(null, null, null, 18, 00, 00))));
                $endCreatedDate = Carbon::parse($startDate." ".date('H:i:s',strtotime(Carbon::create(null, null, null, 23, 59, 59))));

                $rangeExists = Bookings::where(function ($query) use ($startCreatedDate, $endCreatedDate) {
                    $query->where('start_time', '<=', $startCreatedDate)
                          ->where('end_time', '>=', $endCreatedDate)
                          ->where('payment','!=','expired');
                })->exists();

                if ($rangeExists) {
                    header('Content-Type: application/json');
                    return response()->json(['error'=>"the schedule time is already taken, or adjust another minutes for your schedule thank you."]);

                }else{

                    DB::transaction(function () use($request,$user,$startDate,$barCode,$summaryRoom,$summaryTime){
                        $addDay = date('Y-m-d',strtotime(Carbon::parse($startDate)->addDay())); //dummy day
                        $startCreatedDate =  Carbon::parse($startDate." ".date('H:i:s',strtotime(Carbon::create(null, null, null, 18, 00, 00))));
                        $endCreatedDate = Carbon::parse($startDate." ".date('H:i:s',strtotime(Carbon::create(null, null, null, 23, 59, 59))));

                        $names = $request->startFood[0];
                        $prices = $request->startFood[1];
                        $mergeFoodPrice = [];

                        $food_total = 0;

                        if($names!='none'){
                            for ($i = 0; $i < count($names); $i++) {
                                $name = ucwords($names[$i]);  // Capitalize the first letter of each word in the name
                                $price = (int) str_replace(',', '', $prices[$i]);   // Remove commas and convert price to an integer
                                $food_total += $price;
                                $mergeFoodPrice[] = ['name' => $name, 'price' => $price];
                            }
                        }else{
                            $mergeFoodPrice[] = ['name'=>'none','price'=>0];
                        }

                        $book = Bookings::create([
                            'start_time'=>date('Y-m-d H:i:s',strtotime($startCreatedDate)),
                            'end_time'=>date('Y-m-d H:i:s',strtotime($endCreatedDate)),
                            'user_id'=>$user->id,
                            'title'=>$request->input('startTitle'),
                            'expire'=>Carbon::now('Asia/Manila')->addHour(),
                            'barcode'=>$barCode,
                            'payment'=>'pending'
                        ]);

                            BookingsRooms::create([
                                'booking_id'=>$book->id,
                                'price'=>$summaryRoom
                            ]);
                            BookingsSchedules::create([
                                'booking_id'=>$book->id,
                                'price'=>$summaryTime
                            ]);
                            $summaryTotal = $summaryTime + $summaryRoom + $food_total;

                            BookingsSummary::create([
                                'barcode'=>$barCode,
                                'room_price'=>$summaryRoom,
                                'schedule_price'=>$summaryTime,
                                'food_price'=>$food_total,
                                'total'=>$summaryTotal
                            ]);

                            $secondStartCreatedDate = Carbon::parse($addDay." ".date('H:i:s',strtotime(Carbon::create(null, null, null, 00, 00, 00))));
                            $secondSEndCreatedDate = Carbon::parse($addDay." ".date('H:i:s',strtotime(Carbon::create(null, null, null, 06, 00, 00))));

                        Bookings::create([
                                'start_time'=>date('Y-m-d H:i:s',strtotime($secondStartCreatedDate)),
                                'end_time'=>date('Y-m-d H:i:s',strtotime($secondSEndCreatedDate)),
                                'user_id'=>$user->id,
                                'title'=>$request->input('startTitle'),
                                'expire'=>Carbon::now('Asia/Manila')->addHour(),
                                'barcode'=>$barCode,
                                'payment'=>'pending'
                            ]);

                            foreach ($mergeFoodPrice as $menu) {
                                BookingsFoods::create([
                                    'booking_id'=>$book->id,
                                    'name'=>$menu['name'],
                                    'price'=>$menu['price'],
                                    'quantity'=>3
                                ]);
                            }

                    });

                        header('Content-Type: application/json');
                        return response()->json(['user'=>$user,'success'=>"Success Registered"]);
                }


            } else {
                // Target date is before or the same as the current date
                header('Content-Type: application/json');
                return response()->json(['error'=>"Target date is in the past. invalid date"]);
            }

      }else{

              $date = Carbon::now('Asia/Manila');
              $endTT = date('Y-m-d H:i',strtotime($endDatetime));
             if (Carbon::parse($date)->isAfter($endTT)) {
                header('Content-Type: application/json');
                return response()->json(['error'=>"Invalid Date or the end time has been already past."]);

             }
            // return date('Y-m-d H:i:s',strtotime($startDatetime));
             DB::transaction(function () use($request,$user,$barCode,$startDatetime,$endDatetime,$summaryRoom,$summaryTime){

                $names = $request->startFood[0];
                $prices = $request->startFood[1];
                $mergeFoodPrice = [];

                $food_total = 0;
                // Loop through the arrays and merge the data

                if($names!='none'){
                    for ($i = 0; $i < count($names); $i++) {
                        $name = ucwords($names[$i]);  // Capitalize the first letter of each word in the name
                        $price = (int) str_replace(',', '', $prices[$i]);   // Remove commas and convert price to an integer
                        $food_total += $price;
                        $mergeFoodPrice[] = ['name' => $name, 'price' => $price];
                    }
                }else{
                    $mergeFoodPrice[] = ['name'=>'none','price'=>0];
                }

                $book = Bookings::create([
                    'start_time'=>date('Y-m-d H:i:s',strtotime($startDatetime)),
                    'end_time'=>date('Y-m-d H:i:s',strtotime($endDatetime)),
                    'user_id'=>$user->id,
                    'title'=>$request->input('startTitle'),
                    'expire'=>Carbon::now('Asia/Manila')->addHour(),
                    'barcode'=>$barCode,
                    'payment'=>'pending'
                ]);

                BookingsRooms::create([
                    'booking_id'=>$book->id,
                    'price'=>$summaryRoom
                ]);

                BookingsSchedules::create([
                    'booking_id'=>$book->id,
                    'price'=>$summaryTime
                ]);

                $summaryTotal = $summaryTime + $summaryRoom + $food_total;

                BookingsSummary::create([
                    'barcode'=>$barCode,
                    'room_price'=>$summaryRoom,
                    'food_price'=>$food_total,
                    'schedule_price'=>$summaryTime,
                    'total'=>$summaryTotal
                ]);


                foreach ($mergeFoodPrice as $menu) {
                    BookingsFoods::create([
                        'booking_id'=>$book->id,
                        'name'=>$menu['name'],
                        'price'=>$menu['price'],
                        'quantity'=>3
                    ]);
                }
            });


            header('Content-Type: application/json');
            return response()->json(['user'=>$user,'success'=>"Success Registered"]);
         }

      }
    /**
     * Display the specified resource.
     */
    public function show($bookings)
    {
        abort_if(Auth::check()==null,403);
        abort_if(Auth::id()==null,404);
        $user = Auth::id();
        $user_url = User::where('id',$bookings)->first();
        abort_if($user_url==null,404);
        abort_if($user_url->id!=$user,403);

        $bookings = DB::table('bookings')
        ->whereIn('bookings.payment',['pending','paid','reserve'])
        ->where('bookings.user_id','=',$user)
        ->join('users', 'bookings.user_id', '=', 'users.id')
        ->leftJoin('bookings_foods', 'bookings.id', '=', 'bookings_foods.booking_id')
        ->leftJoin('bookings_summaries', 'bookings.barcode', '=', 'bookings_summaries.barcode')
        ->leftJoin('gcashes', 'bookings.barcode', '=', 'gcashes.barcode')
        ->select(
        DB::raw("MIN(bookings.id) as min_booking_id"),
        'bookings.user_id',
        'bookings.title',
        'bookings.payment',
        'bookings.expire',
        DB::raw("GROUP_CONCAT(DISTINCT (bookings.start_time)) as concatenated_start_time"),
        DB::raw("GROUP_CONCAT(DISTINCT (bookings.end_time)) as concatenated_end_time"),
        DB::raw("GROUP_CONCAT(CONCAT (bookings_foods.name)) as concatenated_foods_names"),
        DB::raw("SUM(CONVERT(SUBSTRING_INDEX(bookings_foods.price, ',', -1), DECIMAL(10,2))) as total_foods_price"),
        DB::raw("CONCAT(bookings.barcode) as concatenated_barcode"),
        'users.name',
        'users.contact',
        'users.contact',
        'gcashes.barcode',
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
        'gcashes.barcode',
        'gcashes.image',
        'users.contact',
        'bookings_summaries.room_price',
        'bookings_summaries.schedule_price',
        'bookings_summaries.total',
        'bookings_summaries.partial',
    )
    ->get();
        // $qrcode = '';
        // if($booking!=null){
        //     if($booking->payment=='paid' || $booking->payment=='reserve'){
        //         $bookingArray = (array) $booking;
        //         if (array_key_exists('concatenated_barcode', $bookingArray)) {
        //             $bookingArray['barcode'] = $bookingArray['concatenated_barcode'];
        //             unset($bookingArray['concatenated_barcode']);
        //         }
        //         $fieldsToRemove = ['user_id', 'expire', 'concatenated_foods_names','concatenated_start_time','concatenated_end_time'];
        //          $bookingArray = array_diff_key($bookingArray, array_flip($fieldsToRemove));
        //         $text = implode("\n", array_map(function ($key, $value) {
        //             return "$key: " . ucfirst($value);
        //         }, array_keys($bookingArray), $bookingArray));
        //         $qrcode = QrCode::size(300)->color(34, 71, 114)->generate($text);
        //     }
        // }
       if($bookings->count()===0){
            return redirect()->route('home.booked.show',Auth::id());
       }

        // $toDay = Carbon::now('Asia/Manila');
        // if ($toDay->gt($booking->expire)) {
        //     $expiration = 'Expired';
        //     Bookings::where('barcode',$booking->concatenated_barcode)
        //     ->where('payment','pending')
        //     ->update(['payment'=>'Expired']);
        // } else {
        //     $expiration = $toDay->diffForHumans($booking->expire).' Expiration ';
        // }

        // return view('home.bookings.show')->with(compact('booking','expiration','qrcode'));

        return view('home.bookings.show')->with(compact('bookings'));
    }

    /**
     * Show the form for editing the specified resource.
     */


    public function edit(Bookings $bookings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookings $bookings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $booking)
    {
         $booked = Bookings::where('barcode',$booking)->first();
        $gcash = Gcash::where('barcode',$booking)->first();
        if($gcash){
            $filePath = public_path('images/gcash/' . $gcash->image);
            if (file_exists($filePath)) {
            unlink($filePath);
           // Gcash::where('barcode',$booking)->delete();
            }
        }
        //BookingsSummary::where('barcode',$booking)->delete();
        BookingsCancelled::create([
            'booking_id'=>$booked->id,
            'user_id'=>$booked->user_id,
            'barcode'=>$booked->barcode,
            'end_time'=>$booked->end_time,
            'start_time'=>$booked->start_time,
            'payment'=>'cancelled',
            'expire'=>NULL,
            'title'=>$booked->title,
        ]);
        // Bookings::where('barcode',$booking)->delete();
        Bookings::where('barcode',$booking)->update(['payment'=>'cancelled']);
        header('Content-Type: application/json');
        return response()->json(['id'=>Auth::id()]);
    }
}
