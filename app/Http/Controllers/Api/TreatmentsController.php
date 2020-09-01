<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Treatment;
    
    class TreatmentsController extends Controller
    {
    //処置表示
    public function alltreatments(){ 
    // $wardId= Auth::ward_id();
     // $patients = Patient::where('ward_id','=', $wardId)
    // ->orderBy('room', 'asc')
    // ->get();
    $treatments = Treatment::orderBy('id','asc')->get();
    return $treatments;
  }

  // 新規処置登録
    public function addTreatment(Request $request) {
    $treatments = new Treatment;
      // $patients->ward_id = Auth::ward_id();
      // Auth使えるようになるまではward_id指定する
      $treatments->ward_id = "1";
      $treatments->name = $request->name;
      $treatments->time_required = $request->time_required;
      $treatments->required_flg = $request->required_flg;
      $treatments->save();
      return $treatments;
    }

  // 処置削除
    public function destroy(Request $request) {
      $treatments = Treatment::where('id', $request->id)->delete();
      //　ログインができたら記述を変更（ward_idでselectが必要）
      $upDateTreatmentsData = Treatment::orderBy('id','asc')->get();
      return $upDateTreatmentsData;
    }
     // 編集する患者取得
  public function editTreatment(Treatment $treatment){ 
    return $treatment;
  }

  // 処置編集
  public function updateTreatment(Request $request,Treatment $treatment) {
    $treatments = Treatment::find($request->id);
      // $patients->ward_id = Auth::ward_id();
      // Auth使えるようになるまではward_id指定する
    $treatments->ward_id = "1";
    $treatments->name = $request->treatment_name;
    $treatments->time_required = $request->treatment_time;
    $treatments->required_flg = $request->treatment_required;
    $treatments->save();
    return $treatment;
    }
  }

    