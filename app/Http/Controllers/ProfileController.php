<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->scopes([
            "public_profile, pages_show_list", "pages_read_engagement", "pages_manage_posts", "pages_manage_metadata"
        ])->redirect();
    }

    public function handleProviderFacebookCallback()
    {
        try {
        $user = Socialite::driver('facebook')->stateless()->user();
        } catch (\RuntimeException $rt) {
            echo 'Erreur lors de la connexion a facebook <br>'. $rt->getMessage();
            exit;
        }
        //dd($user);
        $saveUser = User::where('facebook_app_id', $user->id)->first();

        if ($saveUser) {
            $saveUser->facebook_app_id = $user->id;
            $saveUser->token = $user->token;
            $saveUser->save();
        }
        else {
            $saveUser = User::create([
                'email' => $user->id.'@gmail.com',
                'name' => $user->name,
                'facebook_app_id' => $user->id,
                'token' => $user->token,
                'password' => \Hash::make(12345678)
            ]);   
        }
        //dd($saveUser);
        

        Auth::loginUsingId($saveUser->id);

        return redirect()->to('/home');
    }

}
