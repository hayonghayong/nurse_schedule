<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validate;
use DB;
use App\User;
use App\Patient;


    class UsersController extends Controller
    {
        // ログイン中のユーザー情報を取得
        public function getLoginUser()
        {   
            if(Auth::guard('user')->check()){
                $userData = Auth::guard('user')->user(); 
                return response()->json($userData);
            }else if(Auth::guard('admin')->check()){
              $userData = Auth::guard('admin')->user();
              return response()->json($userData);
            }
            return '未ログイン';
        }
        public function getAdmin()
        {   
            $userData = Auth()->guard('admin')->user();
              return response()->json($userData);
        }

        //登録ユーザー表示
        public function allstaffs()
        { 
          $user = Auth::user();
          $user_ward_id = $user->ward_id;
          $staffs = User::where('ward_id','=', $user_ward_id)
            ->where('admin_flg','=',0) //管理者を除く
            ->orderBy('id', 'asc')
            ->get();
          return $staffs;
        }

        // 退職済みユーザーを取得
        public function getRetiredUser()
        { 
          $user = Auth::user();
          $user_ward_id = $user->ward_id;
          $staffs = User::where('ward_id','=', $user_ward_id)
            ->where('admin_flg','=',0) //管理者を除く
            ->orderBy('id', 'asc')
            ->onlyTrashed()
            ->get();
          return $staffs;
        }

        // 選択したユーザー情報を取得
        public function getSelectUser($user_id)
        {   
            // 病棟の情報を格納
            $ward_id = Auth::user()->ward_id; 
            // ユーザー情報を取得
            $userData = User::where('ward_id','=', $ward_id)
                        ->where('id','=',$user_id)
                        ->withTrashed()
                        ->first();
            return response()->json($userData);
        }

        // ユーザーを更新 <今は名前だけ
        public function updateUser(Request $request)
        {   
            // インスタンス生成
            $userData = User::withTrashed()
                        ->find($request->id);
    
            // 病棟の情報を取得
            $ward_id = Auth::user()->ward_id;
            // 更新するデータを格納
            $userData->name = $request->name;
            $userData->save();
        }

        // ユーザーをソフトデリート 
        public function deleteUser(Request $request)
        {   
            // インスタンス生成&削除実行
            $userData = User::withTrashed()
                        ->find($request->id)->delete();
        }

        // ソフトデリートを解除
        public function restoreUser(Request $request)
        {   
            // インスタンス生成&削除実行
            $userData = User::withTrashed()
                        ->find($request->id)
                        ->restore();
        }

        // 担当患者取得
        public function getUsersPatients()
        { 
          $user_id = Auth::user()->id;
          $usersPatients = User::find($user_id)
          ->patients;
          return $usersPatients;
        }

        // 担当患者登録
        public function addUsersPatients(Request $request) 
        {
          $usersPatients = Auth::user();
          // $usersPatients->patients()->attach([$request->id]); 
          $usersPatients->patients()->attach($request->id); 
          return $usersPatients;
        }

        // 特定のuserの担当患者取得
        public function selectUsersPatients($user)
        { 
          $usersPatients = User::find($user)
          ->patients;
          return $usersPatients;
        }

        

    }
    
    