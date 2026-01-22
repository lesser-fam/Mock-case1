<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Profile;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make(
            $input,
            (new RegisterRequest)->rules(),
            (new RegisterRequest)->messages()
        )->validate();

        $user = User::create([
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->profile()->create([
            'user_name' => $input['user_name'],
        ]);

        event(new Registered($user));

        Auth::logout();

        session(['verify_user_id' => $user->id]);

        return $user;
    }
}