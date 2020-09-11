<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Schedule;
use App\Team;
use App\User;
use Illuminate\Support\Arr;
    
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

    // 自分のスケジュール取得
    public function getSchecules()
      { 
        // スケジュールと同時に処置と患者情報も全て取得
        $user_id = Auth::user()->id;
        $all = Schedule::with('treatments','patients')
        ->where('user_id',$user_id)
        ->get();

        // // スケジュールと関連する患者情報のみ取得
        $allPatients = $all->pluck('patients');
        $patient = Arr::flatten($allPatients);

        // // スケジュールと関連する処置情報のみ取得
        $allTreatments = $all->pluck('treatments');
        $treatment = Arr::flatten($allTreatments);

        return [$patient,$treatment];
      }

      // チームのスケジュール取得
      public function getTeamSchecules()
      { 
        $user_id = Auth::id();
          // ログインユーザーのチームとteam_usersを取得
          $teams = Team::with(['team_users'])
          ->where('user_id', $user_id)
          ->get();

          // そのチームに所属するuser情報を取得
          $allUsers = $teams->pluck('team_users');
          $users = Arr::flatten($allUsers);

          // user情報からuser_id取得
          foreach($users as $val)
          {
            $usersId = $val
            ->pluck('user_id');
          }

          // user_idに紐づいてるtreatmentとpatient情報を取得
          $all = Schedule::with('treatments','patients')
          ->whereIn('user_id',$usersId)
          ->get();

          // // スケジュールと関連する患者情報のみ取得
          $allPatients = $all->pluck('patients');
          $patient = Arr::flatten($allPatients);
          
          // // スケジュールと関連する処置情報のみ取得
          $allTreatments = $all->pluck('treatments');
          $treatment = Arr::flatten($allTreatments);
          
          return [$patient,$treatment];
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
        $usersPatientsSchedules = Schedule::with('treatments','patients')
        ->whereIn('patient_id',$usersPatientsId)
        ->where('user_id',$user_id)
        ->get();

        return $usersPatientsSchedules;
      }

      // 編集するスケジュール取得
    public function editSchedule(Schedule $schedule)
    { 
      return $schedule;
    }
  
    // 患者編集
    public function updatePatient(PatientPageApiRequest $request,Patient $patient) 
    {
    $patients = Patient::find($request->id);
    $user = Auth::user();
    $user_ward_id = $user->ward_id;
    $patients->ward_id = $user_ward_id;
    $patients->room = $request->room;
    $patients->name = $request->name;
    $patients->sex = $request->sex;
    $patients->birthday = $request->birthday;
    $patients->hospitalization_date = $request->hospitalization_date;
    $patients->surgery_date = $request->surgery_date;
    $patients->memo = $request->memo;
    $patients->discharge_flg = "0";
    $patients->save();
    return $patients;
  }


    }
    