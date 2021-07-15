<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite as Socialite;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class GoogleController extends Controller
{
    //
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        $user = Socialite::driver('google')->user();
        $this->_registerOrLoginUser($user);
        return redirect('mahasiswa');
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->google_id = $data->id;
            $user->password = bcrypt('12345678');
            $user->save();
        }

        Auth::login($user);
    }
}
