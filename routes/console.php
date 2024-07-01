<?php

use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\AuctionJob;
use App\Console\Commands\AuctionCommand;

// Schedule::call(function (Schedule $schedule) {
//     ([AuctionController::class, 'test']);
//     echo 'Zakończono aukcję.';
//     $schedule->call('App\Http\Controllers\AuctionController@test');
// })->everyTenSeconds();

// Schedule::job(new AuctionJob)->everyTenSeconds();

// Schedule::command('auction:end', ['1'])->everyTenSeconds();
//Schedule::command('auction:end');
Schedule::command('auction:end')->everyFiveMinutes();

