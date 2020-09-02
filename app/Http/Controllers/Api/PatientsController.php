<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Patient;

  class PatientsController extends Controller
  {
     //患者表示
    public function getAllPatients()
    { 
      $user = Auth::user();
      $user_ward_id = $user->ward_id;
      $patients = Patient::where('ward_id','=', $user_ward_id)
      ->orderBy('room', 'asc')
      ->get();
      return $patients;
    }

    // 新規患者追加
    public function addPatient(Request $request) 
    {
      $patients = new Patient;
      $user = Auth::user();
      $user_ward_id = $user->ward_id;
      $patients->ward_id = $user_ward_id;
      $patients->room = $request->room;
      $patients->name = $request->name;
      $patients->sex = $request->sex;
      $patients->birthday = $request->birthday;
      $patients->hospitalization_date = $request->hospitalization;
      $patients->surgery_date = $request->surgery;
      $patients->memo = $request->memo;
      $patients->discharge_flg = "0";
      $patients->save();
      return $patients;
    }
  
    // 患者削除
    public function destroy(Request $request)
    {
      $patients = Patient::where('id', $request->id)->delete();
      $user = Auth::user();
      $user_ward_id = $user->ward_id;
      $upDatePatientsData = Patient::where('ward_id','=', $user_ward_id)
      ->orderBy('room','asc')
      ->get();
      return $upDatePatientsData;
    }

    // 編集する患者取得
    public function editPatient(Patient $patient)
    { 
      return $patient;
    }
  
    // 患者編集
    public function updatePatient(Request $request,Patient $patient) 
    {
    $patients = Patient::find($request->id);
    $user = Auth::user();
    $user_ward_id = $user->ward_id;
    $patients->ward_id = $user_ward_id;
    $patients->room = $request->patient_room;
    $patients->name = $request->patient_name;
    $patients->sex = $request->patient_sex;
    $patients->birthday = $request->patient_birthday;
    $patients->hospitalization_date = $request->patient_hospitalization;
    $patients->surgery_date = $request->patient_surgery;
    $patients->memo = $request->patient_memo;
    $patients->discharge_flg = "0";
    $patients->save();
    return $patient;
  }


  }
