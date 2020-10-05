<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Validate;
use DB;
use App\Schedule;
use App\Task;
use App\Team;
use App\TeamUser;
use App\User;
use Illuminate\Support\Arr;

    
    class TasksController extends Controller
    {
      // 新規<複数>スケジュール登録 (スタッフ)
    public function addTasks(Request $request,$shcedule_id) 
    {
      // $user = Auth::id();
      foreach($request->all() as $val){
        $task = new Task;
        $task->schedule_id = $shcedule_id;
        $task->treatment_id = $val['treatment_id'];
        $task->patient_id = $val['patient_id'];
        $task->start_date = $val['start_date'];
        $task->save();
      }
      return $request->all();
    }
      // 新規スケジュール登録 
    public function addNewTask(Request $request) 
    {
      // $user = Auth::id();
      $task = new Task;
      $task->schedule_id = $request->schedule_id;
      $task->patient_id = $request->patient_id;
      $task->treatment_id = $request->treatment_id;
      $task->start_date = $request->start_date;
      $task->save();
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
      public function getTeamTasks($team_id)
      { 
        $user_id = Auth::id();
          // ログインユーザーのチームとteam_usersを取得
          $team = TeamUser::where('team_id', $team_id)
          ->get();

          // そのチームに所属するuserのuser_id取得
          $userIds = $team->pluck('user_id');

          // user_idからshcedule_id取得 < 最新のschedule_id取得
          $schedules = [];
          foreach($userIds as $val){
          $shcedule = Schedule::where('user_id',$val)
                        ->orderBy('id','desc')
                        ->first()
                        ->id;
            array_push($schedules,$shcedule);
          } 
          // schedule_idに紐づいてるtreatmentとpatient情報を取得
          $all = Task::with('treatment','patient')
          ->whereIn('schedule_id',$schedules)
          ->with('schedule')
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
    public function updateLeaderSchedule(Request $request ,$task_id) 
    { 
      $task = Task::find($task_id);
      $task->schedule_id = $request->schedule_id;
      $task->patient_id = $request->patient_id;
      $task->treatment_id = $request->treatment_id;
      $task->start_date = $request->start_date;
      $task->save();
      return $task;
    }
    // タスク完了へ変更
    public function updateEndFlgFinished($task_id) 
    { 
      // $datetime = Carbon::now();
      $task = Task::find($task_id);
      $task->end_flg =1;
      $task->end_time =Carbon::now();
      $task->save();
      return $task;
    }
    // タスク未完了へ変更
    public function updateEndFlgUnfinished($task_id) 
    { 
      $task = Task::find($task_id);
      $task->end_flg =0;
      $task->end_time =null;
      $task->save();
      return $task;
    }

    // 
    }
    