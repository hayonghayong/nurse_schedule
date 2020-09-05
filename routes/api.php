<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

// ログイン認証後に使用できるAPI <最終的には全てこのgroupの中に記載します
Route::group(['middleware' => 'auth'], function () {
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


  // -----teams_tabel crud -----
  // チーム生成
  Route::post('/teams/post','Api\TeamsController@post'); 

  // -----patients_tabel API -----
  // 患者一覧表示
  Route::get('/patients/get/all','Api\PatientsController@getAllPatients');

  // 患者登録
  Route::post('/patients/post','Api\PatientsController@addPatients'); 

  // 患者削除
  Route::delete('/patients/delete/', 'Api\PatientsController@destroy');

  // 更新する患者取得 
  Route::get('/patients/get/{patient}','Api\PatientsController@editPatient');

  // 患者更新
  Route::post('/patients/update/{patient}','Api\PatientsController@updatePatient');

  // -----patient_user_tabel API -----
  // 担当患者登録
  Route::post('/users_patients/add/{userPatients}','Api\UsersController@addUsersPatients'); 

  // 担当患者取得
  Route::get('/users_patients/get/all','Api\UsersController@getUsersPatients'); 

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
  // チームメンバー登録
  Route::post('/team_users/add/{staffs}','Api\TeamUsersController@addTeamUser'); 
  // チームメンバー表示
  Route::get('/team_users/get/all','Api\TeamUsersController@getTeamUsers'); 

  // -----schedule_table_API-----
  // 看護師によるスケジュールデータの登録
  Route::post('/schedules/post','Api\SchedulesController@addSchedules'); 
  
  // 登録スケジュール表示
  Route::get('/schedules/get/all','Api\SchedulesController@getSchecules');



});