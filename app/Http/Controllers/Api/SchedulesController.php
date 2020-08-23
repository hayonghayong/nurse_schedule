<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Schedule;
    
    //=======================================================================
    class SchedulesController extends Controller
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
                $schedule = Schedule::where("id","LIKE","%$keyword%")->orWhere("ward_id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->orWhere("treatment_id", "LIKE", "%$keyword%")->orWhere("patient_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $schedule = Schedule::paginate($perPage);              
            }          
            return view("schedule.index", compact("schedule"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("schedule.create");
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
				"treatment_id" => "required|integer", //integer('treatment_id')
				"patient_id" => "required|integer", //integer('patient_id')
				"start_date" => "nullable|date", //dateTime('start_date')->nullable()

            ]);
            $requestData = $request->all();
            
            Schedule::create($requestData);
    
            return redirect("schedule")->with("flash_message", "schedule added!");
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
            $schedule = Schedule::findOrFail($id);
            return view("schedule.show", compact("schedule"));
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
            $schedule = Schedule::findOrFail($id);
    
            return view("schedule.edit", compact("schedule"));
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
				"treatment_id" => "required|integer", //integer('treatment_id')
				"patient_id" => "required|integer", //integer('patient_id')
				"start_date" => "nullable|date", //dateTime('start_date')->nullable()

            ]);
            $requestData = $request->all();
            
            $schedule = Schedule::findOrFail($id);
            $schedule->update($requestData);
    
            return redirect("schedule")->with("flash_message", "schedule updated!");
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
            Schedule::destroy($id);
    
            return redirect("schedule")->with("flash_message", "schedule deleted!");
        }
    }
    //=======================================================================
    
    