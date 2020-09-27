<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Schedule;
use App\Task;
use App\Team;
use App\User;
use Illuminate\Support\Arr;
    
    class TasksController extends Controller
    {
      // 新規スケジュール登録 (スタッフ)
    public function addTasks(Request $treatmentSchedule) 
    {
      $schedules = new Task;
      $user = Auth::id();
      $scheduleId = Schedule::orderBy('created_at', 'desc')
      ->where('user_id',$user)
      ->first()
      ->id;
      $schedules->schedule_id = $scheduleId;
      $schedules->treatment_id = $treatmentSchedule->treatment_id;
      $schedules->patient_id = $request->patient_id;
      $schedules->start_date = $request->start_date;
      $schedules->save();
      return $schedules;
    }

    // 自分のスケジュール取得（スタッフ）
    public function getTasks($schedule_id)
      { 
        // スケジュールと同時に処置と患者情報も全て取得
        $user = Auth::id();
        $all = Task::with('treatment','patient')
        ->where('schedule_id',$schedule_id)
        ->get();
        return $all;
      }

      // チームのスケジュール取得
      public function getTeamTasks()
      { 
        $user_id = Auth::id();
          // ログインユーザーのチームとteam_usersを取得
          $team = Team::with(['team_users'])
          ->orderBy('created_at', 'desc')
          ->where('user_id', $user_id)
          ->first();

          // そのチームに所属するuserのuser_id取得
          $userIds = $team->team_users->pluck('user_id');
          
          // user_idからshcedule_id取得
          $scheduleId = Schedule::whereIn('user_id',$userIds)
          ->get();

          // schedule_idに紐づいてるtreatmentとpatient情報を取得
          $all = Task::with('treatment','patient')
          ->whereIn('schedule_id',$scheduleId)
          ->get();
          return $all;
      }

      // 自分の担当患者のスケジュール取得
      public function getPatientsSchecules()
      { 
        // 担当患者取得
        $user_id = Auth::id();
        $usersPatients = User::find($user_id)
        ->patients;
        $usersPatientsId = $usersPatients->pluck('id');

        // スケジュールテーブルから自分の担当患者と担当患者の処置情報を取得
        $usersPatientsSchedules = Schedule::with('treatment','patient')
        ->whereIn('patient_id',$usersPatientsId)
        ->where('user_id',$user_id)
        ->get();

        return $usersPatientsSchedules;
      }

      // 編集するスケジュール取得
    public function editSchedule(Schedule $schedule)
    { 
      $editSchedules = Schedule::with('treatment','patient')
      ->find($schedule);
      return $editSchedules;
    }
  
    // スケジュール編集<スタッフ>
    public function updateSchedule(Request $request ,$task_id) 
    { 
      $task = Task::find($task_id);
      // $task->schedule_id = $$request->schedule_id;
      $task->patient_id = $request->patient_id;
      $task->treatment_id = $request->treatment_id;
      $task->start_date = $request->start_date;
      $task->save();
      return $task;
    }
  
    // スケジュール編集<リーダー>
    public function updateLeaderSchedule(Request $request ,$schedule) 
    { 
      $schedules = Schedule::find($schedule);
      $schedules->user_id =  $request->user_id;
      $schedules->patient_id = $request->patient_id;
      $schedules->treatment_id = $request->treatment_id;
      $schedules->start_date = $request->start_date;
      $schedules->save();
      return $schedules;
    }


    }
    