<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\BookingsSummary;
use App\Models\MessagesTitle;
use App\Models\Messages;
use App\Models\Gcash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SortAvailityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.avaibility.index');
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


        $startDate = explode(" ",$request->startDate)[0];
        $startTime = explode(" ",$request->startDate)[1];
        $endTime = explode(" ",$request->startDate)[3];

        $date = date('mdY',strtotime(Carbon::now('Asia/Manila')));
        $time = date('his',strtotime(Carbon::now('Asia/Manila')));
        $barCode = str_pad(Auth::id().'-'.$date.'-'.$time, 10, STR_PAD_RIGHT);

        // $startTime = explode(" ",$splitTime)[0];
        // $endTime = explode(" ",$splitTime)[1];

        // $startDatetime = Carbon::parse("$startDate $startTime");
        // $endDatetime = Carbon::parse("$startDate $endTime");

        $startDatetime = Carbon::parse("$startDate $startTime");
        $endDatetime = Carbon::parse("$startDate $endTime");



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

                    DB::transaction(function () use($request,$startDate,$barCode){
                        $addDay = date('Y-m-d',strtotime(Carbon::parse($startDate)->addDay())); //dummy day
                        $startCreatedDate =  Carbon::parse($startDate." ".date('H:i:s',strtotime(Carbon::create(null, null, null, 18, 00, 00))));
                        $endCreatedDate = Carbon::parse($startDate." ".date('H:i:s',strtotime(Carbon::create(null, null, null, 23, 59, 59))));


                        Bookings::create([
                            'start_time'=>date('Y-m-d H:i:s',strtotime($startCreatedDate)),
                            'end_time'=>date('Y-m-d H:i:s',strtotime($endCreatedDate)),
                            'user_id'=>Auth::id(),
                            'title'=>'SCHEDULE CLOSED',
                            'expire'=>NULL,
                            'barcode'=>$barCode,
                            'payment'=>'paid'
                        ]);

                            $secondStartCreatedDate = Carbon::parse($addDay." ".date('H:i:s',strtotime(Carbon::create(null, null, null, 00, 00, 00))));
                            $secondSEndCreatedDate = Carbon::parse($addDay." ".date('H:i:s',strtotime(Carbon::create(null, null, null, 06, 00, 00))));

                        Bookings::create([
                                'start_time'=>date('Y-m-d H:i:s',strtotime($secondStartCreatedDate)),
                                'end_time'=>date('Y-m-d H:i:s',strtotime($secondSEndCreatedDate)),
                                'user_id'=>Auth::id(),
                                'title'=>'SCHEDULE CLOSED',
                                'expire'=>NULL,
                                'barcode'=>$barCode,
                                'payment'=>'pending'
                            ]);
                    });

                        header('Content-Type: application/json');
                        return response()->json(['success'=>"Success Schedule has been Closed"]);
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
             DB::transaction(function () use($request,$barCode,$startDatetime,$endDatetime){



                $book = Bookings::create([
                    'start_time'=>date('Y-m-d H:i:s',strtotime($startDatetime)),
                    'end_time'=>date('Y-m-d H:i:s',strtotime($endDatetime)),
                    'user_id'=>Auth::id(),
                    'title'=>'SCHEDULE CLOSED',
                    'expire'=>NULL,
                    'barcode'=>$barCode,
                    'payment'=>'paid'
                ]);

            });

            header('Content-Type: application/json');
            return response()->json(['success'=>"Success Schedule has been Closed"]);
         }

      }

    /**
     * Display the specified resource.
     */

    public function show($availity)
    {
        abort_if(Auth::check()==null,403);


        $booking = DB::table('bookings')
        ->whereIn('bookings.payment',['pending','paid','reserve'])
        ->where('bookings.user_id','=',$availity)
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
    ->first();
        $qrcode = '';
        if($booking!=null){
            if($booking->payment=='paid'){
                $bookingArray = (array) $booking;
                if (array_key_exists('concatenated_barcode', $bookingArray)) {
                    $bookingArray['barcode'] = $bookingArray['concatenated_barcode'];
                    unset($bookingArray['concatenated_barcode']);
                }
                $fieldsToRemove = ['user_id', 'expire', 'concatenated_foods_names','concatenated_start_time','concatenated_end_time'];
                 $bookingArray = array_diff_key($bookingArray, array_flip($fieldsToRemove));
                $text = implode("\n", array_map(function ($key, $value) {
                    return "$key: " . ucfirst($value);
                }, array_keys($bookingArray), $bookingArray));
                $qrcode = QrCode::size(300)->color(34, 71, 114)->generate($text);
            }
        }
       if($booking==null){
            return redirect()->route('home.booked.show',Auth::id());
       }

       // $total = $booking->total + (int)$booking->total_foods_price;
        $toDay = Carbon::now('Asia/Manila');
        if ($toDay->gt($booking->expire)) {
            $expiration = 'Expired';
            Bookings::where('barcode',$booking->concatenated_barcode)
            ->where('payment','pending')
            ->update(['payment'=>'Expired']);
        } else {
            $expiration = $toDay->diffForHumans($booking->expire).' Expiration ';
        }

        return view('admin.avaibility.show')->with(compact('booking','expiration','qrcode'));
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
    public function destroy(Request $request , $booking)
    {

        DB::transaction(function() use($request, $booking){

           $message =  MessagesTitle::create([
            'user_id'=>Auth::id(),
            'to_user_id'=>$request->user,
            'title'=>'your booking has been deleted',
            'name'=>'DELETION SCHEDULE',
         ]);

            Messages::create([
                'messages_title_id'=>$message->id,
                'to_user_id'=>$request->user,
                'from_user_id'=>Auth::id(),
                'description'=>'Sorry your schedule has been delete or closed due to emergency',
            ]);

            BookingsSummary::where('barcode',$booking)->delete();
            Gcash::where('barcode',$booking)->delete();
            Bookings::where('barcode',$booking)->delete();

        });
            header('Content-Type: application/json');
            return response()->json(["Successfully schedule has been deleted"]);

    }
}
