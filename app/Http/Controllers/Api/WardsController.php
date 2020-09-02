<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Ward;
    
    //=======================================================================
    class WardsController extends Controller
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
                $ward = Ward::where("id","LIKE","%$keyword%")->orWhere("hospital_id", "LIKE", "%$keyword%")->orWhere("name", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $ward = Ward::paginate($perPage);              
            }          
            return view("ward.index", compact("ward"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("ward.create");
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
				"hospital_id" => "required|integer", //integer('hospital_id')
				"name" => "required", //string('name')

            ]);
            $requestData = $request->all();
            
            Ward::create($requestData);
    
            return redirect("ward")->with("flash_message", "ward added!");
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
            $ward = Ward::findOrFail($id);
            return view("ward.show", compact("ward"));
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
            $ward = Ward::findOrFail($id);
    
            return view("ward.edit", compact("ward"));
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
				"hospital_id" => "required|integer", //integer('hospital_id')
				"name" => "required", //string('name')

            ]);
            $requestData = $request->all();
            
            $ward = Ward::findOrFail($id);
            $ward->update($requestData);
    
            return redirect("ward")->with("flash_message", "ward updated!");
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
            Ward::destroy($id);
    
            return redirect("ward")->with("flash_message", "ward deleted!");
        }
    }
    //=======================================================================
    
    