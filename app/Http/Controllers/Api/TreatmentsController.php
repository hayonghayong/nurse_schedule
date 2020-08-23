<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Treatment;
    
    //=======================================================================
    class TreatmentsController extends Controller
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
                $treatment = Treatment::where("id","LIKE","%$keyword%")->orWhere("ward_id", "LIKE", "%$keyword%")->orWhere("name", "LIKE", "%$keyword%")->orWhere("time_required", "LIKE", "%$keyword%")->orWhere("required_flg", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $treatment = Treatment::paginate($perPage);              
            }          
            return view("treatment.index", compact("treatment"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("treatment.create");
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
				"time_required" => "required|integer", //integer('time_required')
				"required_flg" => "required|max:1", //char('required_flg',1)

            ]);
            $requestData = $request->all();
            
            Treatment::create($requestData);
    
            return redirect("treatment")->with("flash_message", "treatment added!");
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
            $treatment = Treatment::findOrFail($id);
            return view("treatment.show", compact("treatment"));
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
            $treatment = Treatment::findOrFail($id);
    
            return view("treatment.edit", compact("treatment"));
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
				"time_required" => "required|integer", //integer('time_required')
				"required_flg" => "required|max:1", //char('required_flg',1)

            ]);
            $requestData = $request->all();
            
            $treatment = Treatment::findOrFail($id);
            $treatment->update($requestData);
    
            return redirect("treatment")->with("flash_message", "treatment updated!");
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
            Treatment::destroy($id);
    
            return redirect("treatment")->with("flash_message", "treatment deleted!");
        }
    }
    //=======================================================================
    
    