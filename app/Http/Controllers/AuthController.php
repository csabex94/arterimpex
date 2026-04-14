<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    private array $accessType = ['access_type' => 'offline', 'prompt' => 'consent select_account'];

    public function redirect(Request $request)
    {
        return Socialite::driver('google')->with($this->accessType)->redirect();
    }

    public function callback(Request $request)
    {
        $user = Socialite::driver('google')->with(['access_type' => 'offline'])->stateless()->user();
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            $existingUser->provider_id = $user->id;
            $existingUser->access_token = $user->token;
            $existingUser->refresh_token = $user->refreshToken;
            $existingUser->save();
            Auth::login($existingUser, $remember = true);
            session()->regenerate();
            return redirect()->to('/');
        }

        $existingUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => env('MASTER_PASSWORD'),
            'access_token' => $user->token,
            'refresh_token' => $user->refreshToken,
            'provider_id' => $user->id
        ]);

        Auth::login($existingUser, $remember = true);
        session()->regenerate();
        return redirect()->to('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->flush();
        session()->regenerateToken();
        return redirect()->route('home.page');
    }
}
