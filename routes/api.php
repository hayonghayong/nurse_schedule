<?php

use Illuminate\Http\Request;
use App\Patient;

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

// ログイン認証後に使用できるAPI <最終的には全てこのgroupの中に記載します
Route::group(['middleware' => 'auth'], function () {
  // -----users_tabel crud -----
  // ログイン中のユーザー情報取得
  Route::get('user/fetch', 'Api\UsersController@show');

});


// -----はよん追記-----
// -----patients_tabel API -----
// 患者一覧表示
Route::get('/allPatient','PatientsController@Allpatients');

// 患者登録
Route::post('/addPatient','PatientsController@add'); 

// 患者削除
Route::delete('/delPatient', 'PatientsController@destroy');

// 更新する患者取得
Route::get('/getPatient/{patient}','PatientsController@editPatient');

// 患者更新
Route::post('/updatePatient/{editPatient}','PatientsController@updatePatient');

// -----usersPatients_tabel API -----
// 担当患者登録
Route::post('/add/{userPatients}','UsersPatientsController@add'); 

// 担当患者取得
Route::get('/get','UsersPatientsController@get'); 

// -----treatment_tabel API -----
// 処置一覧表示
Route::get('/allTreatment','TreatmentsController@alltreatments');

// 処置登録
Route::post('/addTreatment','TreatmentsController@addTreatment'); 

// 患者削除
Route::delete('/delTreatment', 'TreatmentsController@destroy');

// 更新する患者取得
Route::get('/getTreatment/{treatment}','TreatmentsController@editTreatment');

// 患者更新
Route::post('/updateTreatment/{editTreatment}','TreatmentsController@updateTreatment');