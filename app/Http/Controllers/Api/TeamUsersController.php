<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\TeamUser;
use App\Team;
use App\User;
use Illuminate\Support\Arr;
    
    class TeamUsersController extends Controller
    {
      // チームメンバー登録
      public function addTeamUser(Request $request) 
        {
          // 配列処理
          foreach($request->id as $val)
          {
          $staffs = new TeamUser;
          $staffs->team_id =Team::find(Auth::user()->id)->id;
          $staffs->user_id =$val; 
          $staffs->save(); 
          }
          // 全てのuserをリターン
          $user = Auth::user();
          $user_ward_id = $user->ward_id;
          $staffs = User::where('ward_id', $user_ward_id)
            ->where('admin_flg','=',0) //管理者を除く
            ->orderBy('id', 'asc')
            ->get();
          return $staffs;
        }

      // チームメンバー表示
      public function getTeamUsers()
        { 
          $user_id = Auth::id();
          // ログインユーザーのチームとteam_usersを取得
          $teams = Team::with(['team_users'])
          ->where('user_id', $user_id)
          ->get();

          // そのチームに所属するuser情報を取得
          $allUsers = $teams->pluck('team_users');
          $users = Arr::flatten($allUsers);

          // user情報からuser_id取得
          foreach($users as $val)
          {
            $user = $val
            ->pluck('user_id');
          }

            $staffs = User::find($user);

          return $staffs;
        }
        
    }
    
    