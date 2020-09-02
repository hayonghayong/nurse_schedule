<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    
    // protected $redirectTo = RouteServiceProvider::HOME;

    // ▼admin_flgでログイン後のページ遷移を振り分ける
    protected  function redirectTo()
    {
        $admin_flg = $this->guard()->user()->admin_flg;
        if($admin_flg == 1){
            return '/admin/setting/';
        }else if($admin_flg == 0){
            return '/staff/select-role/';
        }
    }

    // ▼ログアウト後の遷移先
    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        return redirect('/login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // ▼loginに必要な項目を追記
    public function username(){
      return 'login_id';
    }
}
