<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\UsersPatient;
    
    //=======================================================================
    class UsersPatientsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\View\View
         */
        public function index(Request $request)
        {
            $keyword = $request->get("search");
            $perPage = 25;
    
            if (!empty($keyword)) {
                $users_patient = UsersPatient::where("id","LIKE","%$keyword%")->orWhere("ward_id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->orWhere("patient_id", "LIKE", "%$keyword%")->orWhere("end_flg", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $users_patient = UsersPatient::paginate($perPage);              
            }          
            return view("users_patient.index", compact("users_patient"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("users_patient.create");
        }
    
        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function store(Request $request)
        {
            $this->validate($request, [
				"ward_id" => "required|integer", //integer('ward_id')
				"user_id" => "required|integer", //integer('user_id')
				"patient_id" => "required", //json('patient_id')
				"end_flg" => "required|integer", //integer('end_flg')

            ]);
            $requestData = $request->all();
            
            UsersPatient::create($requestData);
    
            return redirect("users_patient")->with("flash_message", "users_patient added!");
        }
    
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\View\View
         */
        public function show($id)
        {
            $users_patient = UsersPatient::findOrFail($id);
            return view("users_patient.show", compact("users_patient"));
        }
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\View\View
         */
        public function edit($id)
        {
            $users_patient = UsersPatient::findOrFail($id);
    
            return view("users_patient.edit", compact("users_patient"));
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  int  $id
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function update(Request $request, $id)
        {
            $this->validate($request, [
				"ward_id" => "required|integer", //integer('ward_id')
				"user_id" => "required|integer", //integer('user_id')
				"patient_id" => "required", //json('patient_id')
				"end_flg" => "required|integer", //integer('end_flg')

            ]);
            $requestData = $request->all();
            
            $users_patient = UsersPatient::findOrFail($id);
            $users_patient->update($requestData);
    
            return redirect("users_patient")->with("flash_message", "users_patient updated!");
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function destroy($id)
        {
            UsersPatient::destroy($id);
    
            return redirect("users_patient")->with("flash_message", "users_patient deleted!");
        }
    }
    //=======================================================================
    
    