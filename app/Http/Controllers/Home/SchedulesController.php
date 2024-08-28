<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Bookings;
use App\Models\Schedules;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = [];
        $bookings = Bookings::whereNotIn('payment',['expired','ended','cancelled'])->get();

        foreach ($bookings as $booking) {
            $endTime = Carbon::parse($booking->start_time)->format('H:i:s'); // Extract the time part
            if ($endTime == '00:00:00') {
                continue;
            }
            $eventCount = $this->countEventsOnDate($booking->start_time, $bookings);
            $color = $this->getColorForEvent($eventCount, $booking->payment);

            $events[] = [
                'start' => $booking->start_time,
                'end' => $booking->end_time,
                'eventCount' => $eventCount,
                'color' => $color,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($events);
    }

    // Function to count events on a specific date
    private function countEventsOnDate($date, $bookings)
    {
        $count = 0;
        foreach ($bookings as $booking) {
            // Compare dates without the time component
            if (date('Y-m-d', strtotime($booking->start_time)) == date('Y-m-d', strtotime($date))) {
                $count++;
            }
        }
        return $count;
    }

    // Function to get color based on conditions
    private function getColorForEvent($eventCount, $paymentStatus)
    {
        // Customize color based on conditions
        if ($eventCount === 0) {
            return 'white';
        } else if ($eventCount === 1) {
            switch ($paymentStatus) {
                case 'pending':
                    return 'skyblue';
                case 'paid':
                    return 'red';
                case 'reserve':
                    return 'green';
                default:
                    return 'red';
            }
        } else if ($eventCount === 2) {
            switch ($paymentStatus) {
                case 'pending':
                    return 'skyblue';
                case 'paid':
                    return 'red';
                case 'reserve':
                    return 'green';
                default:
                    return 'red';
            }
        } else {
            switch ($paymentStatus) {
                case 'pending':
                    return 'skyblue';
                case 'paid':
                    return 'red';
                case 'reserve':
                    return 'green';
                default:
                    return 'red';
            }
        }
    }



    // public function index()
    // {
    //     $events = [];
    //     $bookings = Bookings::whereNotIn('payment',['expired','ended'])
    //     ->where(function ($query) {
    //         $query->whereTime('end_time', '!=', '00:00:00')
    //             ->orWhereNull('end_time');
    //     })
    //     ->get();

    //     foreach ($bookings as $booking) {
    //         $endTime = Carbon::parse($booking->start_time)->format('H:i:s'); // Extract the time part

    //         // Skip the iteration if end_time is '12:00 am'
    //         if ($endTime == '00:00:00') {
    //             continue;
    //         }

    //         $color = $this->getColorForBooking($booking, $bookings);
    //         $events[] = [
    //             'start' => $booking->start_time,
    //             'end' => $booking->end_time,
    //             'color' => $color,
    //         ];
    //     }

    //     header('Content-Type: application/json');
    //     echo json_encode($events);
    // }

    // private function getColorForBooking($booking, $bookings)
    // {
    //     $eventCount = $this->countEventsOnDate($booking->start_time, $bookings);

    //     if ($eventCount === 0) {
    //         return 'white';
    //     } elseif ($eventCount === 1 && $booking->payment === 'paid') {
    //         return 'red';
    //     } elseif ($eventCount === 2 && $booking->payment === 'paid') {
    //         return 'red';
    //     } elseif ($eventCount === 1 && $booking->payment === 'reserve') {
    //         return 'green';
    //     } elseif ($eventCount === 2 && $booking->payment === 'reserve') {
    //         return 'green';
    //     } elseif ($eventCount === 1 && $booking->payment === 'pending') {
    //         return '#rgba(12, 178, 228, 1)';
    //     } elseif ($eventCount === 2 && $booking->payment === 'pending') {
    //         return '#rgba(12, 178, 228, 1)';
    //     } else {
    //         return 'purple';
    //     }
    // }

    // private function countEventsOnDate($date, $bookings)
    // {
    //     $count = 0;
    //     foreach ($bookings as $booking) {
    //         if (date('Y-m-d', strtotime($booking->start_time)) == date('Y-m-d', strtotime($date))) {
    //             $count++;
    //         }
    //     }
    //     return $count;
    // }

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
    public function show(Schedules $schedules)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedules $schedules)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedules $schedules)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedules $schedules)
    {
        //
    }
}
