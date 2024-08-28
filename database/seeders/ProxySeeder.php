<?php

namespace Database\Seeders;

use App\Models\Proxy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class ProxySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Proxy::create([
        'proxy_date' => Carbon::now()->addDays(4)->toDateString()
       ]);
    }
}
