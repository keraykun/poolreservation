<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BookingsFoods;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       \App\Models\User::factory(30)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin Account',
            'role'=>'admin',
            'contact'=>fake()->randomElement(['09195393811','09133393811','09169393811']),
            'email'=>'admin@yahoo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'User Account',
            'role'=>'user',
            'contact'=>fake()->randomElement(['09195393811','09133393811','09169393811']),
            'email'=>'user@yahoo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'User2 Account',
            'role'=>'user',
            'contact'=>fake()->randomElement(['09195393811','09133393811','09169393811']),
            'email'=>'user2@yahoo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'User3 Account',
            'role'=>'user',
            'contact'=>fake()->randomElement(['09195393811','09133393811','09169393811']),
            'email'=>'user3@yahoo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'User4 Account',
            'role'=>'user',
            'contact'=>fake()->randomElement(['09195393811','09133393811','09169393811']),
            'email'=>'user4@yahoo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'User5 Account',
            'role'=>'user',
            'contact'=>fake()->randomElement(['09195393811','09133393811','09169393811']),
            'email'=>'user5@yahoo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Employee Account',
            'role'=>'employee',
            'contact'=>fake()->randomElement(['09195393811','09133393811','09169393811']),
            'email'=>'employee@yahoo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Employee2 Account',
            'role'=>'employee',
            'contact'=>fake()->randomElement(['09195393811','09133393811','09169393811']),
            'email'=>'employee2@yahoo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Employee3 Account',
            'role'=>'employee',
            'contact'=>fake()->randomElement(['09195393811','09133393811','09169393811']),
            'email'=>'employee3@yahoo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);


        $this->call([
            ScheduleSeeder::class,
            FoodSeeder::class,
            RoomSeeder::class,
            AnnouncementSeeder::class,
            BookingsSeeder::class,
            RatingsSeeder::class,
            ProxySeeder::class
       ]);



        ///************************************* */
        // $this->call([
        //     ProxySeeder::class
        // ]);
        //  $this->call([
        //     BookingFoodSeeder::class,
        //     BookingRoomSeeder::class,
        //     BookingScheduleSeeder::class
        // ]);

            $this->call([
                BookingSummarySeeder::class
            ]);

    }
}
