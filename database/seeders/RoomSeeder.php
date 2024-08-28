<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Room::create([
            'name'=>'Invidual Size',
            'price'=>500,
       ]);
       Room::create([
        'name'=>'Couple Size',
        'price'=>1000,
       ]);
       Room::create([
        'name'=>'Family  Size',
        'price'=>2000,
       ]);
    }
}
