<?php

namespace Database\Seeders;

use App\Models\Foods;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Foods::create([
        //     'name'=>'Kanin',
        //     'price'=>200,
        //     'quantity'=>2
        // ]);
        // Foods::create([
        //     'name'=>'Kanin',
        //     'price'=>400,
        //     'quantity'=>2
        // ]);
        // Foods::create([
        //     'name'=>'Kanin',
        //     'price'=>500,
        //     'quantity'=>2
        // ]);
        Foods::create([
            'name'=>'Lechon Manok',
            'price'=>500,
            'quantity'=>2
        ]);
        Foods::create([
            'name'=>'Pritong Baboy',
            'price'=>200,
            'quantity'=>2
        ]);
       Foods::create([
        'name'=>'Lechon Baboy',
        'price'=>5000,
        'quantity'=>1
       ]);
       Foods::create([
        'name'=>'Inihaw na Bangus',
        'price'=>200,
        'quantity'=>2
       ]);
       Foods::create([
        'name'=>'Inihaw na Baka',
        'price'=>1000,
        'quantity'=>2
       ]);
       Foods::create([
        'name'=>'Inihaw na Pusit',
        'price'=>300,
        'quantity'=>2
       ]);
       Foods::create([
        'name'=>'Pritong Pusit',
        'price'=>250,
        'quantity'=>2
       ]);
       Foods::create([
        'name'=>'Pakbet',
        'price'=>120,
        'quantity'=>2
       ]);
       Foods::create([
        'name'=>'Pritong Hipon',
        'price'=>200,
        'quantity'=>2
       ]);
       Foods::create([
        'name'=>'Pansit',
        'price'=>600,
        'quantity'=>2
       ]);
       Foods::create([
        'name'=>'Binagoongan Baboy',
        'price'=>1000,
        'quantity'=>2
       ]);
    }
}
