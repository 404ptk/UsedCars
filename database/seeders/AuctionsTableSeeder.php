<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auction;
use App\Models\Car;

class AuctionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = Car::all();

        foreach ($cars as $car) {
            $currentMaxQueue = Auction::max('queue');

            $newQueueValue = $currentMaxQueue ? $currentMaxQueue + 1 : 1;

            Auction::create([
                'car_id' => $car->id,
                'queue' => $newQueueValue,
                'current_price' => $car->price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

