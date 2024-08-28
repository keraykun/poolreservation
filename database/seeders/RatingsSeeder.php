<?php

namespace Database\Seeders;
use App\Models\Bookings;
use App\Models\Ratings;
use App\Models\RatingsComments;
use App\Models\RatingsFoods;
use App\Models\RatingsPools;
use App\Models\RatingsRooms;
use App\Models\RatingsStaffs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (Bookings::where('is_rated',1)->where('payment','done')->get() as $booking){
            $rating = Ratings::create([
                'booking_id'=>$booking->id,
                'booked_at'=>$booking->start_time
            ]);
            RatingsFoods::create([
                'rating_id'=>$rating->id,
                'star'=>rand(1, 5),
            ]);
            RatingsPools::create([
                'rating_id'=>$rating->id,
                'star'=>rand(1, 5),
            ]);
            RatingsRooms::create([
                'rating_id'=>$rating->id,
                'star'=>rand(1, 5),
            ]);
            RatingsStaffs::create([
                'rating_id'=>$rating->id,
                'star'=>rand(1, 5),
            ]);
            RatingsComments::create([
                'rating_id'=>$rating->id,
                'comments'=>$faker->paragraph(6)
            ]);
        }
    }
}
