<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bookings;
use App\Models\BookingsSchedules;

class BookingScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Bookings::whereRaw('HOUR(start_time) != 0')->get() as $booking) {
            BookingsSchedules::create([
                'booking_id'=>$booking->id,
                'price'=>800
            ]);
        }
    //     foreach (Bookings::whereRaw('HOUR(start_time) = 18 AND end_time = "23:59:59"')->get() as $booking) {
    //         BookingsSchedules::create([
    //             'booking_id'=>$booking->id,
    //             'price'=>800
    //         ]);
    //    }
    //    foreach (Bookings::whereRaw('HOUR(start_time) = 8 AND HOUR(start_time) = 16')->get() as $booking) {
    //         BookingsSchedules::create([
    //             'booking_id'=>$booking->id,
    //             'price'=>800
    //         ]);
    //     }

    }
}
