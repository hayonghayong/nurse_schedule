<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\UsersPatient;
use App\Patient;
use App\Schedule;

    class UsersPatientsController extends Controller
    {


    // 担当患者登録
        public function addUsersPatients(Request $request) 
        {
          $user = Auth::id();
          $ids = $request->id;
          foreach ($ids as $val) {
          $usersPatients = new UsersPatient;
          $usersPatients->schedule_id =Schedule::orderBy('created_at', 'desc')
          ->where('user_id',$user)
          ->first()
          ->id;
          $usersPatients->patient_id = $val;
          $usersPatients->save();
          }
        }
    
     // 担当患者取得
        public function getUsersPatients()
        { 
          $user = Auth::id();
          $scheduleId = Schedule::orderBy('created_at', 'desc')
          ->where('user_id',$user)
          ->first()
          ->id;
          $allusersPatients = UsersPatient::with('patient')
          ->where('schedule_id',$scheduleId)
          ->get();
          $usersPatients = $allusersPatients->pluck('patient');
          return $usersPatients;
        }


    
    
    }
  
    