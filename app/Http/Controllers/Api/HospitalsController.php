<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Hospital;
    
    //=======================================================================
    class HospitalsController extends Controller
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
                $hospital = Hospital::where("id","LIKE","%$keyword%")->orWhere("name", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $hospital = Hospital::paginate($perPage);              
            }          
            return view("hospital.index", compact("hospital"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("hospital.create");
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
				"name" => "required", //string('name')

            ]);
            $requestData = $request->all();
            
            Hospital::create($requestData);
    
            return redirect("hospital")->with("flash_message", "hospital added!");
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
            $hospital = Hospital::findOrFail($id);
            return view("hospital.show", compact("hospital"));
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
            $hospital = Hospital::findOrFail($id);
    
            return view("hospital.edit", compact("hospital"));
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
				"name" => "required", //string('name')

            ]);
            $requestData = $request->all();
            
            $hospital = Hospital::findOrFail($id);
            $hospital->update($requestData);
    
            return redirect("hospital")->with("flash_message", "hospital updated!");
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
            Hospital::destroy($id);
    
            return redirect("hospital")->with("flash_message", "hospital deleted!");
        }
    }
    //=======================================================================
    
    