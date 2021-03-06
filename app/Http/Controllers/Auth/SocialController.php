<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use App\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        // $userSocial =   Socialite::driver($provider)->user();

        $userSocial =   Socialite::driver($provider)->stateless()->user();
        $users       =   User::where(['email' => $userSocial->getEmail()])->first();

        dd($userSocial);
        if($users){
            Auth::login($users);
            return redirect('/');
        }else{
        // $user = User::create([
        //         'name'          => $userSocial->getName(),
        //         'email'         => $userSocial->getEmail(),
        //         // 'image'         => $userSocial->getAvatar(),
        //         'provider_id'   => $userSocial->getId(),
        //         'provider'      => $provider,
        //     ]);

            return redirect()->route('home')->with('user');
        }
    }
}
