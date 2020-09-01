<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validate;
use DB;
use App\User;

    //=======================================================================
    class UsersController extends Controller
    {
        // ログイン中のユーザー情報を取得
        public function show()
        {   
            if(Auth::user()){
                $userData = Auth::user(); 
                return response()->json($userData);
            }
        }
    }
    //=======================================================================
    
    