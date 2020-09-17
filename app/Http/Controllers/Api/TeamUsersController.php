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
          $leader_id = Auth::id();
          // 配列処理
          foreach($request->id as $val)
          {
            $staffs = new TeamUser;
            // $staffs->team_id =Team::find(Auth::user()->id)->id;
            // 最新のチームidを取得して格納
            $staffs->team_id =Team::orderBy('created_at', 'desc')->where('user_id','=',$leader_id)->first()->id;
            $staffs->user_id =$val; 
            $staffs->save(); 
          }
        }

      // チームメンバー表示
      public function getTeamUsers($team_id)
        { 
          $user_id = Auth::id();
          // ログインユーザーのチームとteam_usersを取得
          $teams = Team::with(['team_users'])
          ->where('id', $team_id)
          ->get();

          // // そのチームに所属するuser情報を取得
          $allUsers = $teams->pluck('team_users');
          $users = Arr::flatten($allUsers);

          // user情報からuser_id取得
          $users_id = [];
          foreach($users as $val)
          {
            array_push($users_id,$val->user_id);
          }
          $staffs = User::find($users_id);
          return $staffs;
        }
        
    }
    
    