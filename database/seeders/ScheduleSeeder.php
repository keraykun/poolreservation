<?php

namespace Database\Seeders;
use App\Models\Schedules;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedules::create([
            'start'=>Carbon::createFromFormat('H:i:s', '08:00:00'), //8am
            'end'=>Carbon::createFromFormat('H:i:s', '16:00:00'), //4pm
            'rate'=>800, //4pm
        ]);

        Schedules::create([
            'start'=>Carbon::createFromFormat('H:i:s', '18:00:00'), //6pm
            'end'=>Carbon::createFromFormat('H:i:s', '23:59:59'), //12am
            'rate'=>800, //4pm
        ]);

        Schedules::create([
            'start'=>Carbon::createFromFormat('H:i:s', '18:00:00'), //6pm
            'end'=>Carbon::createFromFormat('H:i:s', '06:00:00'), //6am
            'rate'=>1600, //4pm
        ]);
    }
}
