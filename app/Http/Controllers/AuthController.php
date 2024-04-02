<?php

namespace App\Http\Controllers;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function index($provider)
    {
        if (!in_array($provider, ['telegram'])) {
            return abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        if (!in_array($provider, ['telegram'])) {
            return abort(404);
        }

        $socialite = Socialite::driver($provider)->user();

        $user = User::firstOrNew(['telegram_id' => $socialite->getId()]);
        $user->first_name = $socialite->user['first_name'] ?? $socialite->getName();
        $user->last_name = $socialite->user['last_name'] ?? null;
        $user->username = $socialite->user['username'] ?? $socialite->getNickname();
        $user->save();

        Filament::auth()->loginUsingId($user->id);
        session()->regenerate();

        return redirect(parse_url(config('app.url'))['scheme'] . '://app.' . parse_url(config('app.url'))['host']);
    }
}
