<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\AuthSocialService;
use Illuminate\Support\Facades\Log;
use Socialite;

class AuthSocialController extends Controller
{
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        $user = AuthSocialService::createOrGetUser(Socialite::driver($social)->user(), $social);
        auth()->login($user);

        return redirect()->route('home');
    }
}
