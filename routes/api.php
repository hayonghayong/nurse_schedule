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
  // 病棟内の全ユーザー取得
  Route::get('/users/get/all','Api\UsersController@allstaffs');

  // -----teams_tabel crud -----
  // チーム生成
  Route::post('/teams/post','Api\TeamsController@post'); 

  // -----はよん追記-----
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

  // -----usersPatients_tabel API -----
  // 佐藤<ここは命名いじってません
  // 担当患者登録
  Route::post('/add/{userPatients}','Api\UsersPatientsController@add'); 

  // 担当患者取得
  Route::get('/get','Api\UsersPatientsController@get'); 

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

});