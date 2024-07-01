<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Auction;
use Illuminate\Support\Facades\Cache;
use Cron\CronExpression;
use Illuminate\Support\Carbon;

class AuctionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = Carbon::now();
        Log::info('Czas rozpoczęcia aukcji: ' . $currentTime);
        $currentTime->addMinutes(5);
        Log::info('Czas zakończenia aukcji: ' . $currentTime);
        $currentTimeString = $currentTime->format('H:i:s');

        Cache::put('auction_time', $currentTimeString, 300);

        $count = Auction::count();
        if (!$count) {
            Log::info('Brak aukcji do zakończenia');
            return;
        }

        $auction = Auction::where('queue', 1)->first();

        if ($auction->bids()->count() == 0) {
            $maxQueue = Auction::max('queue');
            $deletedQueueValue = $auction->queue;

            $auction->update(['queue' => $maxQueue + 1]);

            Log::info('Aukcja zakończona bez ofert: ' . $auction->car->name);
            Log::info($auction);

            $this->rindexAuctionQueue($deletedQueueValue);
        } else {
            if ($auction->currentBid) {
                Log::info('Aukcja zakończona z ofertą: ' . $auction->car->name . ' - cena: ' . $auction->current_price . ' zł');
                Log::info($auction);
                $auction->car->update([
                    'owner_id' => $auction->currentBid->user_id,
                    'status' => 'sold',
                    'price' => $auction->current_price
                ]);
            }

            $deletedQueueValue = $auction->queue;

            $auction->delete();

            $this->rindexAuctionQueue($deletedQueueValue);
        }
        
    }

    protected function rindexAuctionQueue($deletedQueueValue)
    {
        // znajdujemy wszystkie aukcje o numerach kolejki większych niż $deletedQueueValue
        $auctions = Auction::where('queue', '>', $deletedQueueValue)->orderBy('queue')->get();
        
        // nowy numer kolejki, który będziemy nadawać aukcjom
        $newQueueNumber = 1;

        foreach ($auctions as $auction) {
            // przypisujemy nowy numer kolejki dla aukcji
            $auction->queue = $newQueueNumber++;
            $auction->save();
        }
    }
    
}
