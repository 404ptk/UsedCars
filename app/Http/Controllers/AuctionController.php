<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use App\Events\AuctionPriceUpdated;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Cron\CronExpression;

class AuctionController extends Controller
{
    public function create()
    {
        return view('auctions.create');
    }

    public function store(Request $request)
    {
        $ownerId = auth()->id();

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'brand' => 'required|string|max:25',
            'capacity' => 'required|integer|min:0',
            'engine' => 'required|string|max:10',
            'hp' => 'required|integer|min:0',
            'mileage' => 'required|integer|min:0',
            'gearbox' => 'required|string|max:50',
            'drive' => 'required|string|max:50',
            'condition' => 'required|string|max:50',
            'vin' => 'required|string|min:17|max:17|unique:cars,vin',
            'color' => 'required|string|max:30',
            'body' => 'required|string|max:20',
            'localization' => 'required|string|max:70',
            'country_of_origin' => 'required|string|max:50',
            'production_date' => 'required|date',
            'first_registration' => 'required|date',
            'description' => 'required|string|max:500|min:10',
            'price' => 'required|integer|min:100',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5086',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        $validated['owner_id'] = $ownerId;

        $car = Car::create($validated);
        $currentMaxQueue = Auction::max('queue');

        $newQueueValue = $currentMaxQueue ? $currentMaxQueue + 1 : 1;

        Auction::create([
            'car_id' => $car->id,
            'queue' => $newQueueValue,
            'current_price' => $car->price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('mainpage')->with('success', 'Aukcja została dodana.');
    }

    public function delete($id)
    {
        $car = Car::find($id);
        if (!$car) {
            return redirect()->back()->with('error', 'Aukcja nie istnieje.');
        }

        if ($car->owner_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do usunięcia tej aukcji.');
        }

        $car->delete();

        return redirect()->route('profile.auctions', ['id' => auth()->id()])->with('success', 'Aukcja została pomyślnie usunięta.');
    }


    public function edit()
    {

    }

    public function userAuctions($id)
    {
        $user = User::findOrFail($id);
        if ($user->id !== auth()->id()) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do przeglądania tych aukcji.');
        }
        return view('profile.auctions', compact('user'));
    }

    public function placeBid(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:' . ($auction->current_price + 100), // w wysłanej dokumentacji było +1 | poprawka
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $amount = $request->input('amount');

        if ($amount <= $auction->current_price) {
            return redirect()->back()->with('error', 'Kwota musi być większa niż obecna cena.');
        }

        $bid = new Bid([
            'auction_id' => $auction->id,
            'user_id' => auth()->id(),
            'amount' => $amount,
        ]);
        $bid->save();

        $auction->current_price = $amount;
        $auction->current_bid_id = $bid->id;
        $auction->save();


        AuctionPriceUpdated::dispatch($auction);

        return redirect()->back()->with('success', 'Licytacja została złożona.');
    }
    public function show($id = null)
    {
        $currentTimeString = Cache::get('auction_time');
        if ($id) {
            $auction = Auction::findOrFail($id);
            $car = $auction->car;
            $latestBids = $auction->bids()->orderBy('created_at', 'desc')->take(3)->get();

            $nextAuction = Auction::where('queue', '>', $auction->queue)->orderBy('queue')->first();

            return view('auction.show', compact('auction', 'car', 'latestBids', 'nextAuction','currentTimeString'));
        } else {
            $auctions = Auction::with('car')->where('queue', 1)->get();
            $nextAuction = Auction::where('queue', '>', 1)->orderBy('queue')->first(); // Sprawdzenie następnej aukcji
            return view('mainpage', compact('auctions', 'nextAuction','currentTimeString'));
        }
    }

    public function delete_on_mainpage($id)
    {
        $auction = Auction::find($id);
        if (!$auction) {
            return redirect()->back()->with('error', 'Aukcja nie istnieje.');
        }

        if ($auction->owner_id !== auth()->id() && auth()->user()->role_id !== 1) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do usunięcia tej aukcji.');
        }

        if ($auction->car) {
            $auction->car->delete();
        }

        $deletedQueueValue = $auction->queue;

        $auction->delete();

        $this->reindexAuctionQueue($deletedQueueValue);

        return redirect()->route('mainpage')->with('success', 'Aukcja została pomyślnie usunięta.');
    }

    protected function reindexAuctionQueue($deletedQueueValue)
    {
        $auctions = Auction::where('queue', '>', $deletedQueueValue)->orderBy('queue')->get();

        foreach ($auctions as $auction) {
            $auction->queue--;
            $auction->save();
        }
    }

    public function administrator_show_auctions(Request $request)
    {
        $search = $request->input('search');

        $auctions = Auction::with('car')
            ->whereHas('car', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            })
            ->paginate(5);

        $auctions->appends(['search' => $search]);

        return view('administrator.auctions', compact('auctions'));
    }
    public function administrator_delete_auctions($id)
    {
        $auction = Auction::find($id);
        if (!$auction) {
            return redirect()->back()->with('error', 'Aukcja nie istnieje.');
        }

        $deletedQueueValue = $auction->queue;
        $auction->delete();
        $this->reindexAuctionQueue($deletedQueueValue);

        return redirect()->route('administrator.auctions')->with('success', 'Aukcja została pomyślnie usunięta.');
    }

    public function administrator_edit_auctions($id)
    {
        $auction = Auction::findOrFail($id);
        return view('administrator.edit_auction', compact('auction'));
    }

    public function administrator_update_auctions(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
        $auction->current_price = $request->input('current_price');
        $auction->save();

        return redirect()->route('administrator.auctions')->with('success', 'Aukcja została pomyślnie zaktualizowana.');
    }

    public function endAuction(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);

        DB::transaction(function () use ($auction) {
            if ($auction->bids()->count() == 0) {
                $maxQueue = Auction::max('queue');
                $deletedQueueValue = $auction->queue;

                $auction->update(['queue' => $maxQueue + 1]);

                $this->rindexAuctionQueue($deletedQueueValue);
            } else {
                $auction->update(['status' => 'ended']);

                if ($auction->currentBid) {
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
        });

        return redirect()->route('mainpage')->with('success', 'Aukcja została zakończona.');
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

    public function userCars($id)
    {
        $user = User::findOrFail($id);
        if ($user->id !== auth()->id()) {
            return redirect()->back()->with('error', 'Nie masz uprawnień do przeglądania tych samochodów.');
        }

        $cars = Car::where('owner_id', $id)->get();
        return view('profile.cars', compact('user', 'cars'));
    }
    public function stats()
    {
        $totalAuctions = Auction::count();
        $totalUsers = User::count();
        $totalBids = Bid::count();
        $highestBid = Bid::max('amount');

        return view('administrator.stats', compact(
            'totalAuctions',
            'totalUsers',
            'totalBids',
            'highestBid',
        )
        );
    }

    public static function count_money_auctions()
    {
        $user = Auth::user();
        $auctions = Auction::whereIn('car_id', function ($query) use ($user) {
            $query->select('id')->from('cars')->where('owner_id', $user->id);
        })->get();

        $totalCurrentPrice = 0;

        foreach ($auctions as $auction) {
            $totalCurrentPrice += $auction->current_price;
        }

        return $totalCurrentPrice;
    }

    public static function discount()
    {
        $user = Auth::user();
        $cars = $user->cars;

        $totalCarValue = 0;

        foreach ($cars as $car) {
            $totalCarValue += $car->price;
        }

        $discountPercentage = self::count_cars_of_user();

        if ($discountPercentage > 5) {
            $discountPercentage = 5;
        }

        return ((self::count_money_cars() / 100) * (100 - $discountPercentage));
    }

    public static function count_money_cars()
    {
        $user = Auth::user();
        $cars = $user->cars;

        $totalCarValue = 0;

        foreach ($cars as $car) {
            $totalCarValue += $car->price;
        }

        return $totalCarValue - self::count_money_auctions();
    }


    public static function count_auctions_of_user()
    {
        $user = Auth::user();
        $auctions = Auction::whereIn('car_id', function ($query) use ($user) {
            $query->select('id')->from('cars')->where('owner_id', $user->id);
        })->get();

        $totalUserAuctions = 0;

        foreach ($auctions as $auction) {
            $totalUserAuctions += 1;
        }

        return $totalUserAuctions;
    }

    public static function count_cars_of_user()
    {
        $user = Auth::user();
        $cars = $user->cars;

        $totalUserCars = 0;

        foreach ($cars as $car) {
            $totalUserCars += 1;
        }

        return $totalUserCars;
    }
}