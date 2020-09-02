<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Treatment;
    
    class TreatmentsController extends Controller
    {
    //処置表示
    public function alltreatments()
    { 
      $user = Auth::user();
      $user_ward_id = $user->ward_id;
      $treatments = Treatment::where('ward_id','=', $user_ward_id)
      ->orderBy('id', 'asc')
      ->get();
      return $treatments;
    }

    // 新規処置登録
    public function addTreatment(Request $request) 
    {
      $treatments = new Treatment;
      $user = Auth::user();
      $user_ward_id = $user->ward_id;
      $treatments->ward_id = $user_ward_id;
      $treatments->name = $request->name;
      $treatments->time_required = $request->time_required;
      $treatments->required_flg = $request->required_flg;
      $treatments->save();
      return $treatments;
    }

    // 処置削除
    public function destroy(Request $request) 
    {
      $treatments = Treatment::where('id', $request->id)->delete();
      $user = Auth::user();
      $user_ward_id = $user->ward_id;
      $upDateTreatmentsData = Treatment::where('ward_id','=', $user_ward_id)
      ->orderBy('id', 'asc')
      ->get();
      return $upDateTreatmentsData;
    }

    // 編集する患者取得
    public function editTreatment(Treatment $treatment)
    { 
    return $treatment;
    }

    // 処置編集
    public function updateTreatment(Request $request,Treatment $treatment) 
    {
      $treatments = Treatment::find($request->id);
      $user = Auth::user();
      $user_ward_id = $user->ward_id;
      $treatments->ward_id = $user_ward_id;
      $treatments->name = $request->treatment_name;
      $treatments->time_required = $request->treatment_time;
      $treatments->required_flg = $request->treatment_required;
      $treatments->save();
      return $treatment;
    }
  }

    