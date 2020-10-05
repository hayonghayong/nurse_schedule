<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

// ログイン認証後に使用できるAPI <最終的には全てこのgroupの中に記載します
// Route::group(['middleware' => 'auth'], function () {
  // -----users_tabel crud -----
  // ログイン中のユーザー情報取得
  Route::get('/users/login-user', 'Api\UsersController@getLoginUser');
  // 病棟内の全現役ユーザー取得
  Route::get('/users/get/all','Api\UsersController@allstaffs');
  // 病棟内の全退職済みユーザー取得
  Route::get('/users/get/retired','Api\UsersController@getRetiredUser');
  // 選択したユーザー取得
  Route::get('/users/get/{user_id}','Api\UsersController@getSelectUser');
  // ユーザー情報を更新
  Route::post('/users/update','Api\UsersController@updateUser');
  // ユーザー情報をソフトデリート
  Route::post('/users/delete','Api\UsersController@deleteUser');
  // ソフトデリートを解除
  Route::post('/users/restore','Api\UsersController@restoreUser');

  // ログイン中のユーザー情報取得
  Route::get('/users/admin-user', 'Api\UsersController@getAdmin');



  // -----teams_tabel crud -----
  // チーム生成
  Route::post('/teams/post','Api\TeamsController@post'); 



  // -----patients_tabel API -----
  // 病棟内患者一覧取得
  Route::get('/patients/get/all','Api\PatientsController@getAllPatients');

  // 患者登録
  Route::post('/patients/post','Api\PatientsController@addPatients'); 

  // 患者削除
  Route::delete('/patients/delete/', 'Api\PatientsController@destroy');

  // 更新する患者取得 
  Route::get('/patients/get/{patient}','Api\PatientsController@editPatient');

  // 患者更新
  Route::post('/patients/update/{patient}','Api\PatientsController@updatePatient');

  // 患者とその担当看護師取得 
  Route::get('/patients_users/get/{patient}','Api\PatientsController@patientUser');


  // -----users_patients_tabel API -----
  // 担当患者登録
  Route::post('/users_patients/add','Api\UsersPatientsController@addUsersPatients'); 

  // 担当患者取得
  Route::get('/users_patients/get/all','Api\UsersPatientsController@getUsersPatients'); 

  // 特定のuserの担当患者取得
  Route::get('/users_patients/get/{user_id}','Api\UsersPatientsController@getSelectUsersPatients');
  
  // 担当患者更新
  Route::post('/users_patients/update','Api\UsersPatientsController@updateUsersPatients'); 



  // -----treatment_tabel API -----
  // 処置一覧表示
  Route::get('/treatments/get/all','Api\TreatmentsController@alltreatments');

  // 処置登録
  Route::post('/treatments/post','Api\TreatmentsController@addTreatment'); 

  // 処置削除
  Route::delete('/treatments/delete', 'Api\TreatmentsController@destroy');

  // 更新する処置取得
  Route::get('/treatments/get/{treatment}','Api\TreatmentsController@editTreatment');

  // 処置更新
  Route::post('/treatments/update/{editTreatment}','Api\TreatmentsController@updateTreatment');



  // -----team_users_table API-----
  // チームメンバー登録  !済！
  Route::post('/team_users/add','Api\TeamUsersController@addTeamUser'); 

  // チームメンバー取得  !済！
  Route::get('/team_users/get/all/{team_id}','Api\TeamUsersController@getTeamUsers'); 



  // -----task_table_API-----
    // タスクデータの登録
    Route::post('/tasks/post/new','Api\TasksController@addNewTask'); 
    
  // 看護師による<複数>タスクデータの登録
  Route::post('/tasks/post/{task_id}','Api\TasksController@addtasks'); 

  // 登録タスク取得
  Route::get('/tasks/get/all/{schedule_id}','Api\TasksController@getTasks');

  // チームのタスク表示
  Route::get('/tasks/get/team/{team_id}','Api\TasksController@getTeamTasks');

  // 患者のタスク取得
  Route::get('/tasts/get/patients','Api\TasksController@getPatientsSchecules');

  // 更新するタスク取得 
  Route::get('/tasks/get/{task_id}','Api\TasksController@editSchedule');

   // スケジュール更新<スタッフ>
  Route::post('/tasks/update/{task_id}','Api\TasksController@updateSchedule');
   // スケジュール更新<リーダー>
  Route::post('/tasks/update/leader/{schedule_id}','Api\TasksController@updateLeaderSchedule');

  // タスク完了に変更
  Route::post('/tasks/end_flg/finished/{task_id}','Api\TasksController@updateEndFlgFinished');
  // タスク未完了に変更
  Route::post('/tasks/end_flg/unfinished/{task_id}','Api\TasksController@updateEndFlgUnfinished');





  // -----schedules_tabel crud -----
  // チーム生成
  Route::post('/schedules/post','Api\SchedulesController@post'); 



// });
