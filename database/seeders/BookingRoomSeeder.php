<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bookings;
use App\Models\BookingsRooms;

class BookingRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Bookings::where('title','Couple Size')->get() as $booking) {
            BookingsRooms::create([
                'booking_id'=>$booking->id,
                //'name'=>$booking->title,
                'price'=>1000
            ]);
       }
       foreach (Bookings::where('title','Invidual Size')->get() as $booking) {
            BookingsRooms::create([
                'booking_id'=>$booking->id,
                //'name'=>$booking->title,
                'price'=>500
            ]);
        }
        foreach (Bookings::where('title','Family Size')->get() as $booking) {
            BookingsRooms::create([
                'booking_id'=>$booking->id,
                //'name'=>$booking->title,
                'price'=>2000
            ]);
        }
    }
}
