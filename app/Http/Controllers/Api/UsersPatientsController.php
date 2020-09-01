<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\UsersPatient;
use App\Patient;

    class UsersPatientsController extends Controller
    {
      // 担当患者登録
  public function add(Request $request) {
    foreach ((array)$request->id as $val) {
    $usersPatients = new UsersPatient;
      // $usersPatients->ward_id = Auth::ward_id();
      // Auth使えるようになるまではward_id指定する
      $usersPatients->ward_id = "1";
       // $usersPatients->user_id = Auth::id();
      // ログイン機能が実装されるまではuser_idも指定する
      $usersPatients->user_id = "1";
      $usersPatients->patient_id = $val;
      // $usersPatients->patient_id = $request->id;
      $usersPatients->end_flg = "0";
      $usersPatients->save();
      return $usersPatients;
    }
  }

    //担当患者表示
    public function get(){ 
    // $patient = Patient::find('id',$usersPatients->patient_id);
    // $patient = Patient::find('id',$usersPatients->patient_id);
    // $patientId = UsersPatient::find('patient_id''='Patient::,)
    // $room= $patient->room;
    // $wardId= Auth::ward_id();
    // $userId=Auth::id();
    // ログイン機能実装前はward_idとuser_idをこっちで指定
    $usersPatients=UsersPatient::where('user_id','=','1')
    ->where('ward_id','=','1')
    ->orderBy($room,'asc')
    ->get();
    return $usersPatients;
  }
    
    }
  
    