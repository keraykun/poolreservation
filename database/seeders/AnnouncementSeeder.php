<?php

namespace Database\Seeders;

use App\Models\Announcements;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i=1; $i <=10 ; $i++) {
            Announcements::create([
                'title'=>$faker->unique()->paragraph(1),
                'description'=>$faker->paragraph(6),
                'due_at'=>$faker->dateTimeBetween('now','+7 days'),
           ]);
        }
    }
}
