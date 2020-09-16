<?php

namespace App\Http\Controllers\Admin\Auth;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// 追記
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    use AuthenticatesUsers;

        //ログイン後ここに飛ぶ
        protected $redirectTo = '/admin';
 
        public function __construct()
        {
            $this->middleware('guest:admin')->except('logout');
        }
     
        //ログインフォームのviews
        public function showLoginForm()
        {
            return view('admins/auth/login');
        }
         // ▼ログアウト後の遷移先
        protected function loggedOut(Request $request)
        {
            // セッションを破棄
            // $request->session()->forget("auth-admin");
            return redirect('/admin/login');
        }

        // function login(Request $request){
        //     $request->session()->put("auth-admin", true);
        //     return redirect('/admin');
        // }

        //持たせるガードの名前
        protected function guard()
        {
            return Auth::guard('admin');
        }
        // ▼loginに必要な項目を追記
        public function username(){
            return 'login_id';
        }
    
}
