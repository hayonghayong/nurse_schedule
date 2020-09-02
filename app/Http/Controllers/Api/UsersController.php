<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validate;
use DB;
use App\User;

    class UsersController extends Controller
    {
        // ログイン中のユーザー情報を取得
        public function getLoginUser()
        {   
            if(Auth::user()){
                $userData = Auth::user(); 
                return response()->json($userData);
            }
        }

        //看護師表示
        public function allstaffs()
        { 
          $user = Auth::user();
          $user_ward_id = $user->ward_id;
          $staffs = User::where('ward_id','=', $user_ward_id)
          ->orderBy('id', 'asc')
          ->get();
          return $staffs;
        }
    }
    
    