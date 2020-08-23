<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Team;
    
    //=======================================================================
    class TeamsController extends Controller
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
                $team = Team::where("id","LIKE","%$keyword%")->orWhere("ward_id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $team = Team::paginate($perPage);              
            }          
            return view("team.index", compact("team"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("team.create");
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

            ]);
            $requestData = $request->all();
            
            Team::create($requestData);
    
            return redirect("team")->with("flash_message", "team added!");
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
            $team = Team::findOrFail($id);
            return view("team.show", compact("team"));
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
            $team = Team::findOrFail($id);
    
            return view("team.edit", compact("team"));
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

            ]);
            $requestData = $request->all();
            
            $team = Team::findOrFail($id);
            $team->update($requestData);
    
            return redirect("team")->with("flash_message", "team updated!");
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
            Team::destroy($id);
    
            return redirect("team")->with("flash_message", "team deleted!");
        }
    }
    //=======================================================================
    
    