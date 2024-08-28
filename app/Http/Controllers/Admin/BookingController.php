<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\BookingsHistory;
use App\Models\BookingsSummary;
use App\Models\Gcash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Messages;
use App\Models\MessagesTitle;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('expireHour');
    }

    public function index(Request $request)
    {

        if($request->search){
            $search = $request->search;
            $bookings = DB::table('bookings')
            ->where('users.role','user')
            ->where('users.name','like','%'.$search.'%')
            ->orWhere('users.contact','like','%'.$search.'%')
            ->orWhere('bookings.title','like','%'.$search.'%')
            ->orWhere('bookings.payment','like','%'.$search.'%')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->whereIn('bookings.payment',['pending','reserve','expired'])
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
            ->where('users.role','user')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->whereIn('bookings.payment',['pending','reserve','expired'])
            ->leftJoin('bookings_foods', 'bookings.id', '=', 'bookings_foods.booking_id')
            ->leftJoin('bookings_summaries', 'bookings.barcode', '=', 'bookings_summaries.barcode')
            ->leftJoin('gcashes', 'bookings.barcode', '=', 'gcashes.barcode')
            ->select(
                'bookings.user_id',
                'bookings_summaries.partial_status',
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
                'bookings_summaries.partial_status',
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
        return view('admin.bookings.index')->with(compact('bookings'));
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
         $file = $request->file('file');
        if($file==''){
           return redirect()->back()->with('file','File must be required');
        }
        $fileName = $file->getClientOriginalName();

        DB::transaction(function() use($request,$fileName,$file){
            $file->move(public_path('images/gcash'), $fileName); // You can change the storage path
            Gcash::create([
                'barcode'=>$request->barcode,
                'image'=>$fileName
            ]);
        });

       return redirect()->back()->with('success','Proof of payment has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookings $bookings)
    {
        //
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
    public function update(Request $request, Bookings $booking)
    {

        Bookings::where('barcode',$booking->concatenated_barcode)->update([
            'payment'=>'paid',
            'expire'=>null
        ]);
        return redirect()->back()->with('success','Schedule has been Approved !');
    }


    public function paid(Request $request , string $book)
    {
        $total = (int)$request->total + (int)$request->partial;

        BookingsSummary::where('barcode',$book)->update([
            'partial'=>$total,
            'total'=>0,
            'date_at'=>now()
        ]);

        Bookings::where('barcode',$book)->update([
            'payment'=>'paid',
            'expire'=>null,
            'updated_at'=>now()
        ]);
        return redirect()->route('admin.bookreport.index')->with('success','Schedule has been Approved !');
    }

    public function partial(Request $request ,string $book)
    {

        if($request->booking_total<$request->partial_amount){
            return redirect()->back()->with('file','Invalid Amount. The partial must be higher than the balance.');
        }


        $total = $request->booking_total - $request->partial_amount;

        //return $request->partial_amount;
        BookingsSummary::where('barcode',$book)->update([
            'partial'=>$request->partial_amount,
            'total'=>$total,
            'partial_status'=>1
        ]);
        Bookings::where('barcode',$book)->update([
            'payment'=>'reserve',
            'expire'=>null
        ]);
        return redirect()->back()->with('success','Schedule has been Partial has been updated !');
    }


    public function partialupdate(Request $request ,string $book)
    {

    $amount = (int)$request->partial_amount;
    $partial = (int)$request->booking_partial;
    $total = (int)$request->booking_total;

    if($amount>$total){
        return redirect()->back()->with('file','Invalid Amount. The partial must be higher than the balance.');
    }

    // Calculate the result
    $result = $amount - $partial;

    // Calculate the updated total and partial values
    $total_decrement = $total - $result; // Updated total
    $partial_increment = $partial + $result; // Updated partial

    // Update the database using Eloquent
    BookingsSummary::where('barcode', $book)->update([
        'partial' => $partial_increment,
        'total' => $total_decrement,
        'partial_status' => 1
    ]);

        Bookings::where('barcode',$book)->update([
            'payment'=>'reserve',
            'expire'=>null
        ]);
        return redirect()->back()->with('success','Schedule has been Partial has been updated !');
    }

    public function done(string $book)
    {
        //return here
        Bookings::where('barcode',$book)->update([
            'payment'=>'done',
            'expire'=>null
        ]);

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



    public function warning(Request $request)
    {

        Bookings::where('barcode',$request->barcode)->update([
            'payment'=>'ended',
            'expire'=>null
        ]);
        DB::transaction(function() use($request){
            BookingsHistory::create([
                'user_id'=>$request->user_id,
                'title'=>$request->title,
                'payment'=>$request->payment,
                'barcode'=>$request->barcode,
                'date_booked'=>$request->date_booked
           ]);
        //Bookings::where('barcode',$request->barcode)->delete();
        });

        return redirect()->back()->with('danger','Booking warning has been updated !');
    }

    public function delete(Request $request)
    {
        //return $request;
        Bookings::where('barcode',$request->barcode)->update([
            'payment'=>'ended',
            'expire'=>null
        ]);
        DB::transaction(function() use($request){
            BookingsHistory::create([
                'user_id'=>$request->user_id,
                'title'=>$request->title,
                'payment'=>$request->payment,
                'barcode'=>$request->barcode,
                'date_booked'=>$request->date_booked
           ]);

           $message =  MessagesTitle::create([
            'user_id'=>Auth::id(),
            'to_user_id'=>$request->user_id,
            'barcode'=>$request->barcode,
            'title'=>'your booking '.$request->title.' '.$request->date_booked,
            'name'=>'DELETION SCHEDULE',
         ]);

            Messages::create([
                'messages_title_id'=>$message->id,
                'to_user_id'=>$request->user_id,
                'from_user_id'=>Auth::id(),
                'description'=>$request->message,
            ]);
        //Bookings::where('barcode',$request->barcode)->delete();
        });

        return redirect()->back()->with('danger','Booking warning has been updated !');
    }


}
