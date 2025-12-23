<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [ 'name'=> '太郎', 'email' => 'test1@example.com'],
            [ 'name'=> '次郎', 'email' => 'test2@example.com'],
            [ 'name'=> '三郎', 'email' => 'test3@example.com'],
            [ 'name'=> '四郎', 'email' => 'test4@example.com'],
            [ 'name'=> '五郎', 'email' => 'test5@example.com'],
            [ 'name'=> '六郎', 'email' => 'test6@example.com'],
        ];

        foreach ($users as $user) {
            $createdUser = User::create([
                'email' => $user['email'],
                'password' => Hash::make('Password'),
            ]);
            
            Profile::create([
                'user_id' => $createdUser->id,
                'user_name' => $user['name'],
            ]);
        }
    }
}
