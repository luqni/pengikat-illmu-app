<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // ✅ stateless WAJIB di shared hosting
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'       => $googleUser->getName(),
                'google_id'  => $googleUser->getId(),
                'avatar'     => $googleUser->getAvatar(),
                // ✅ FIX PASSWORD
                'password'   => Hash::make(Str::random(40)),
            ]
        );

        Auth::login($user);

        return redirect()->route('notes.index');
    }
}
