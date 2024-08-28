<?php

namespace Database\Seeders;

use App\Models\Bookings;
use App\Models\Room;
use App\Models\User;
use App\Models\Schedules;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::now();
        foreach (User::where('role', 'user')->whereIn('id',[1,2,3,4,5,6,8,9,10,11,12,13])->get() as $key => $user) {
            $schedule = Schedules::whereIn('id',[1,2])->inRandomOrder()->first();
            Bookings::create([
                'user_id' => $user->id,
                'start_time' => $startDate->format('Y-m-d '.$schedule->start),
                'end_time' => $startDate->format('Y-m-d '.$schedule->end),
                'title' => Room::all()->random()->name,
                'payment' => 'paid',
                'barcode' => '12-'.$startDate->format('dY').'-052441'
            ]);
            $startDate->modify('+1 day');
        }

        $pastDate = Carbon::now()->subDay();

        foreach (User::where('role', 'user')->whereNotIn('id',[1,2,3,4,5,6,8,9,10,11,12,13])->get() as $key => $user) {
            $schedule = Schedules::whereIn('id',[1,2])->inRandomOrder()->first();
            Bookings::create([
                'user_id' => $user->id,
                'start_time' => $pastDate->format('Y-m-d '.$schedule->start),
                'end_time' => $pastDate->format('Y-m-d '.$schedule->end),
                'title' => Room::all()->random()->name,
                'payment' => 'done',
                'barcode' => '12-'.$pastDate->format('dY').'-052441',
                'is_rated'=>1
            ]);
            $pastDate->modify('-1 day');
        }


    }
}
