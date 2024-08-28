<?php

namespace Database\Seeders;

use App\Models\BookingsSummary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class BookingSummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $startDate =  Carbon::now('Asia/Manila');

        for ($i = 1; $i <= 90; $i++) {
            $amount = $faker->randomFloat(2, 1000, 10000); // Random amount between 1000 and 10000 with 2 decimal places

            BookingsSummary::create([
                'partial' => $amount,
                'date_at' => $startDate->format('Y-m-d'),
                'barcode' => '12-' . $startDate->format('dmY') . '-052441',
            ]);
            // Increment the date by one day for the next iteration
            $startDate->subDay();
        }

        for ($i=1; $i <=3 ; $i++) {
            BookingsSummary::create([
                'partial' => $amount,
                'date_at' =>  Carbon::now('Asia/Manila'),
                'barcode' => '12-' . $startDate->format('dmY') . '-052441',
            ]);
        }

        // for ($i = 1; $i <= 90; $i++) {
        //     $amount = $faker->randomFloat(2, 1000, 10000); // Random amount between 1000 and 10000 with 2 decimal places

        //     BookingsSummary::create([
        //         'partial' => $amount,
        //         'date_at' => $startDate->format('Y-m-d'),
        //         'barcode' => '12-' . $startDate->format('dmY') . '-052441',
        //     ]);
        //     $startDate->addDay();
        // }
    }
}
