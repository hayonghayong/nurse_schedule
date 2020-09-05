<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\TeamUser;
use App\Team;
    
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
          $user_id = Auth::user()->id;
          $team = Team::where('user_id',$user_id)
          ->value('id');  //ログインユーザーが所属してるチームid取得
          $staffs = TeamUser::where('team_id',$team)
          ->pluck('id');  //チームに所属しているuser_id取得
          // foreach ($team_users as $team_user){
          //   $staffs = TeamUser::find($team_user)   //チームメンバーidをuser_tableから探す
          // ->users;
          // }
          return $staffs;
        }
    }
   
    
    