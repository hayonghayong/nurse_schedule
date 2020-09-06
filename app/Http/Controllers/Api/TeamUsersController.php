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
    
    class TeamUsersController extends Controller
    {
      // チームメンバー登録
      public function addTeamUser(Request $request) 
        {
          $staffs = new TeamUser;
          $staffs->team_id =Team::find(Auth::user()->id)->id;
          $staffs->user_id =$request->id; 
          $staffs->save();
          $staffs->users()->attach($request->id); 
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

          // そのチームに所属するuser_idを取得
          $team_users = $teams->map(function($team)
          {
            return $team
            ->team_users;
          });
          foreach($team_users as $val)
          {
            $staffs = $val
            ->pluck('user_id');
          }

          // そのuser_idのuser情報を取得
          // foreach ($team_usersId as $userId)
          // { 
          //   $staffs = TeamUser::with(['users'])->where('user_id',$userId)->get();
          // }
          return $staffs;
        }
    }
    
    