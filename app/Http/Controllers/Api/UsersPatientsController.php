<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\UsersPatient;
use App\Patient;

    class UsersPatientsController extends Controller
    {

    // 担当患者登録
    public function addUsersPatients(Request $request) 
    {
      $collection = collect([1, 2, 3]);
      $ids = $collection->toArray();

      foreach ($ids as $val) {
        $usersPatients = new UsersPatient;
        $user = Auth::user();
        $user_ward_id = $user->ward_id;
        $usersPatients->ward_id = $user_ward_id;
        $usersPatients->user_id = Auth::id();
        $usersPatients->patient_id = $val;
        $usersPatients->end_flg = "0";
        $usersPatients->save();
      }
      return $usersPatients;
    }

    
    
    }
  
    