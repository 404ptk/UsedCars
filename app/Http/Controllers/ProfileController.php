<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class ProfileController extends Controller
{
    //
    public function show()
    {
        $user = auth()->user();
        //$totalCurrentPrice = AuctionController::count_money_to_pay();
        $totalUserAuctions = AuctionController::count_auctions_of_user();
        $count = AuctionController::count_money_cars();
        $discount = AuctionController::discount();
        $totalUserCars = AuctionController::count_cars_of_user();
        return view('profile.show', compact('user','count', 'totalUserAuctions', 'discount', 'totalUserCars'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($user->avatar) {
            Storage::delete('avatars/' . $user->avatar);
        }

        $avatarPath = $request->file('avatar')->store('avatars', 'public');

        $user->avatar = $avatarPath;
        
        $user->is_default_avatar = false;
        
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Avatar został pomyślnie zaktualizowany.');
    }

    public function editProfile(){

        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|confirmed',
                'old_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Nieprawidłowe stare hasło.');
                    }
                }]
            ]);

            $user->password = Hash::make($request->password);
        }

        $user->name = $request->filled('name') ? $request->name : $user->name;
        $user->surname = $request->filled('surname') ? $request->surname : $user->surname;
        $user->mail = $request->filled('mail') ? $request->mail : $user->mail;

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Pomyślnie zaktualizowano profil.');
    }

    public function users(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
                    ->where('username', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('mail', 'like', "%{$search}%")
                    ->paginate(5);

        return view('administrator.users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('administrator.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('password')) {
            $request->validate([
                'password' => 'required|confirmed',
            ]);

            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->mail = $request->mail;
        $user->save();

        return redirect()->route('administrator.users')->with('success', 'Dane użytkownika zostały pomyślnie zaktualizowane.');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'Użytkownik został pomyślnie usunięty.');
        } else {
            return redirect()->back()->with('error', 'Nie udało się znaleźć użytkownika.');
        }
    }
    
}
