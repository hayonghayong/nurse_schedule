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
use App\Task;

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
    
     // ログイン中の担当患者取得
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

     // 選択されたスタッフの担当患者取得
        public function getSelectUsersPatients($userId)
        { 
          $scheduleId = Schedule::orderBy('created_at', 'desc')
          ->where('user_id',$userId)
          ->first()
          ->id;
          $allusersPatients = UsersPatient::with('patient')
          ->where('schedule_id',$scheduleId)
          ->get();
          $usersPatients = $allusersPatients->pluck('patient');
          return $usersPatients;
        }

        // 担当患者を変更
        public function updateUsersPatients(Request $request)
        { 
          // 変更元のschedule_idを取得
          $from_schedule_id = Schedule::where('user_id',$request->change_from_id)
          ->orderBy('id','desc')
          ->first()
          ->id;
          // 変更先のschedule_idを取得
          $to_schedule_id =  Schedule::where('user_id',$request->change_to_id)
          ->orderBy('id','desc')
          ->first()
          ->id;
          // users_patientsテーブルを変更
          $target_users_patients = UsersPatient::where('schedule_id',$from_schedule_id)
          ->where('patient_id',$request->patient_id)
          ->first();
          $target_users_patients->schedule_id = $to_schedule_id;
          $target_users_patients->save();
          // tasksテーブルを変更
          $target_tasks = Task::where('schedule_id',$from_schedule_id)
          ->where('patient_id',$request->patient_id)
          ->get();
          foreach($target_tasks as $task){
            $task->schedule_id = $to_schedule_id;
            $task->save();
          }
        }


    
    
    }
  
    