<?php

namespace App\Http\Controllers\Auth;
use App\Models\AuthProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToLine() {
//        return Socialite::driver('line')->redirect();
        return Socialite::driver('line')->redirect();

    }
    public function handleLineCallback() {
        try{
            $user = Socialite::driver('line')->user();
//            dd($user);
            $finduser = AuthProvider::where('provider', 'line')->where('provider_id', $user->id)->first();
            if ($finduser) {
//                dd('if');
                $user = User::where('id', $finduser->user_id)->first();
                Auth::login($user);
                return redirect('/suc');
            } else {
//                dd('else',$user);
                $newUser = new User();
//                $newUser->name = $user->name ? $user->name : $user->nickname;
                $newUser->name = 'name';
//                $newUser->email = $user->email ? $user->email : 'aofphuwadech@gmail.com';
                $newUser->email = 'aofphuwadech@gmail.com';
                $newUser->assignRole = 'Member';
                $newUser->password = Hash::make('1111');
                $newUser->save();

                $new_user = new AuthProvider();
                $new_user->user_id = $newUser->id;
                $new_user->provider = 'line';
                $new_user->provider_id = $user->id;
                $new_user->save();
                Auth::login($newUser);

                return redirect('/suc');
            }
        }
        catch(Exception $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            return redirect('/');
        }

    }
}
