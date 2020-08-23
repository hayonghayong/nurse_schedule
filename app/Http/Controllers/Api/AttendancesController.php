<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Attendance;
    
    //=======================================================================
    class AttendancesController extends Controller
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
                $attendance = Attendance::where("id","LIKE","%$keyword%")->orWhere("ward_id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->orWhere("attendance_flg", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $attendance = Attendance::paginate($perPage);              
            }          
            return view("attendance.index", compact("attendance"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("attendance.create");
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
				"attendance_flg" => "required|integer", //integer('attendance_flg')

            ]);
            $requestData = $request->all();
            
            Attendance::create($requestData);
    
            return redirect("attendance")->with("flash_message", "attendance added!");
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
            $attendance = Attendance::findOrFail($id);
            return view("attendance.show", compact("attendance"));
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
            $attendance = Attendance::findOrFail($id);
    
            return view("attendance.edit", compact("attendance"));
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
				"attendance_flg" => "required|integer", //integer('attendance_flg')

            ]);
            $requestData = $request->all();
            
            $attendance = Attendance::findOrFail($id);
            $attendance->update($requestData);
    
            return redirect("attendance")->with("flash_message", "attendance updated!");
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
            Attendance::destroy($id);
    
            return redirect("attendance")->with("flash_message", "attendance deleted!");
        }
    }
    //=======================================================================
    
    