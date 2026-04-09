<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function redirect(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        $existingUser = User::where('email', $user->email)->first();
        
        if ($existingUser) {
            $existingUser->provider_id = $user->id;
            $existingUser->access_token = $user->token;
            $existingUser->save();
            Auth::login($existingUser);
            session()->regenerate();
            return redirect()->to('/');
        }
    }
}
