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
          return $staffs;
        }

      // チームメンバー取得
      public function getTeamUsers()
        { 
          // $user_id = Auth::user()->id;
          $staffs = TeamUser::where('team_id','=','1')
          // ->user
          // ->name;
          ->get();
        }
    }
   
    
    