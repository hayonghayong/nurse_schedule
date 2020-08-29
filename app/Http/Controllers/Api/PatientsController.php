<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Patient;
    
//=======================================================================
  class PatientsController extends Controller
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
                $patient = Patient::where("id","LIKE","%$keyword%")->orWhere("ward_id", "LIKE", "%$keyword%")->orWhere("name", "LIKE", "%$keyword%")->orWhere("sex", "LIKE", "%$keyword%")->orWhere("room", "LIKE", "%$keyword%")->orWhere("memo", "LIKE", "%$keyword%")->orWhere("discharge_flg", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $patient = Patient::paginate($perPage);              
            }          
            return view("patient.index", compact("patient"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("patient.create");
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
				"name" => "required", //string('name')
				"birthday" => "required|date", //date('birthday')
				"sex" => "required|max:1", //char('sex',1)
				"room" => "nullable|integer", //integer('room')->nullable()
				"hospitalization_date" => "nullable|date", //date('hospitalization_date')->nullable()
				"surgery_date" => "nullable|date", //date('surgery_date')->nullable()
				"memo" => "nullable", //text('memo')->nullable()
				"discharge_flg" => "required|max:1", //char('discharge_flg',1)

            ]);
            $requestData = $request->all();
            
            Patient::create($requestData);
    
            return redirect("patient")->with("flash_message", "patient added!");
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
            $patient = Patient::findOrFail($id);
            return view("patient.show", compact("patient"));
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
            $patient = Patient::findOrFail($id);
    
            return view("patient.edit", compact("patient"));
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
				"name" => "required", //string('name')
				"birthday" => "required|date", //date('birthday')
				"sex" => "required|max:1", //char('sex',1)
				"room" => "nullable|integer", //integer('room')->nullable()
				"hospitalization_date" => "nullable|date", //date('hospitalization_date')->nullable()
				"surgery_date" => "nullable|date", //date('surgery_date')->nullable()
				"memo" => "nullable", //text('memo')->nullable()
				"discharge_flg" => "required|max:1", //char('discharge_flg',1)

            ]);
            $requestData = $request->all();
            
            $patient = Patient::findOrFail($id);
            $patient->update($requestData);
    
            return redirect("patient")->with("flash_message", "patient updated!");
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
            Patient::destroy($id);
    
            return redirect("patient")->with("flash_message", "patient deleted!");
        }
    
    // -----はよん記載-----
     //患者表示
    public function Allpatients(){ 
    // $wardId= Auth::ward_id();
     // $patients = Patient::where('ward_id','=', $wardId)
    // ->orderBy('room', 'asc')
    // ->get();
    // $patients = Patient::orderBy('created_at', 'asc')->get();
    $patients = Patient::orderBy('room','asc')->get();
    return $patients;
  }
    // 新規患者追加
    public function add(Request $request) {
      $patients = new Patient;
      // $patients->ward_id = Auth::ward_id();
      $patients->room = $request->room;
      $patients->name = $request->name;
      $patients->sex = $request->sex;
      $patients->birthday = $request->birthday;
      $patients->hospitalization = $request->hospitalization;
      $patients->surgery = $request->surgery;
      $patients->memo = $request->memo;
      $patients->save();
      $patients = Patient::all();
      return $patients;
    }


}