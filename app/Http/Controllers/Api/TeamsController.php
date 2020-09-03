<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Team;
    
    //=======================================================================
    class TeamsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\View\View
         */
        public function post()
        {
            // インスタンス生成
            $team = new Team;
            // ログイン中のユーザー情報を取得
            $userId = Auth::id();
            $wardId = Auth::user()->ward_id;
            // postデータを格納
            $team->user_id = $userId;
            $team->ward_id = $wardId;
            $team->save();
        }
    
    }
    //=======================================================================
    
    