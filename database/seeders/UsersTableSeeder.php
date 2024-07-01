<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // role_id = 1 | administrator
        // role_id = 2 | uzytkownik
        DB::table('users')->insert([
            [
                'name' => 'Patryk',
                'surname' => 'Jarosiewicz',
                'username' => 'pjarosiewicz',
                'mail' => 'pjarosiewicz@example.com',
                'password' => Hash::make('test'),
                'role_id' => 1,
                'avatar' => 'images/pfp.jpg', // zdjęcie inne niż defaultowe, które jest na dysku
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dawid',
                'surname' => 'Wójcik',
                'username' => 'dawidjasper',
                'mail' => 'dawidjasper@example.com',
                'password' => Hash::make('test'),
                'role_id' => 2,
                'avatar' => 'images/default-avatar.jpg', 
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ryszard',
                'surname' => 'Wójcik',
                'username' => 'rysiu123',
                'mail' => 'rysiu123@example.com',
                'password' => Hash::make('test'),
                'role_id' => 2,
                'avatar' => 'images/default-avatar.jpg', // zdjęcie defaultowe
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Adam',
                'surname' => 'Nowak',
                'username' => 'adamnowak',
                'mail' => 'adamnowak@example.com',
                'password' => Hash::make('test'),
                'role_id' => 1,
                'avatar' => 'images/pfp3.jpg',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Piotr',
                'surname' => 'Kowal',
                'username' => 'kowalp',
                'mail' => 'kowalp@example.com',
                'password' => Hash::make('test'),
                'role_id' => 2,
                'avatar' => 'images/pfp3.jpg',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hubert',
                'surname' => 'Sosnowski',
                'username' => 'hubi99',
                'mail' => 'hubi99@example.com',
                'password' => Hash::make('hubi123'),
                'role_id' => 2,
                'avatar' => 'images/default-avatar.jpg',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sebastian',
                'surname' => 'Kuzyk',
                'username' => 'kuzyks',
                'mail' => 'kuzyks@example.com',
                'password' => Hash::make('lol321'),
                'role_id' => 2,
                'avatar' => 'images/default-avatar.jpg',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        $user = User::find(1);
        $user -> is_default_avatar = false;
        $user -> save();
        $user = User::find(4);
        $user -> is_default_avatar = false;
        $user -> save();
    }
}
