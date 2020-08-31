<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Patient;
    
  class PatientsController extends Controller
  {
     //患者表示
    public function Allpatients(){ 
    // $wardId= Auth::ward_id();
     // $patients = Patient::where('ward_id','=', $wardId)
    // ->orderBy('room', 'asc')
    // ->get();
    $patients = Patient::orderBy('room','asc')->get();
    return $patients;
  }
    // 新規患者追加
    public function add(Request $request) {
    $patients = new Patient;
      // $patients->ward_id = Auth::ward_id();
      // Auth使えるようになるまではward_id指定する
      $patients->ward_id = "1";
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
    //   return response()->json(['patients'=>$patients], 200);

    }
  
    // 患者削除
    public function destroy(Request $request) {
      $patients = Patient::where('id', $request->id)->delete();
      return $patients;
    //   return response()->json(['patients'=>$patients], 200);
    }

    // 編集する患者取得
  public function editPatient(Patient $patient){ 
    return $patient;
  }
  
  // 患者編集
  public function updatePatient(Request $request,Patient $patient) {
    $patients = Patient::find($request->id);
      // $patients->ward_id = Auth::ward_id();
      // Auth使えるようになるまではward_id指定する
    $patients->ward_id = "1";
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
