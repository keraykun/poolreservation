<?php

namespace Database\Seeders;

use App\Models\Bookings;
use App\Models\BookingsFoods;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       foreach (Bookings::all() as $booking) {
            BookingsFoods::create([
                'booking_id'=>$booking->id,
                'name'=>'none',
                'price'=>0
            ]);
       }
    }
}
