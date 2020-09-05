<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Schedule;
    
    class SchedulesController extends Controller
    {
      // 新規スケジュール登録
    public function addSchedules(Request $request) 
    {
      $schedules = new Schedule;
      $user = Auth::user();
      $schedules->ward_id = $user->ward_id;
      $schedules->user_id = $user->id;
      $schedules->treatment_id = $request->treatment_id;
      $schedules->patient_id = $request->patient_id;
      $schedules->start_date = $request->start_date;
      $schedules->save();
      $schedules->treatments()->attach($request->treatment_id); 
      $schedules->patients()->attach($request->patient_id); 
      return $schedules;
    }

    public function getSchecules()
      { 
        $user_id = Auth::user()->id;
        $schedules = Schedule::with('treatments','patients')
        ->where('user_id',$user_id)
        ->get();
        return $schedules;
        }
    }
    