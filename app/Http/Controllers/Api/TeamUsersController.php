<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\TeamUser;
    
    //=======================================================================
    class TeamUsersController extends Controller
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
                $team_user = TeamUser::where("id","LIKE","%$keyword%")->orWhere("ward_id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $team_user = TeamUser::paginate($perPage);              
            }          
            return view("team_user.index", compact("team_user"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("team_user.create");
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
            
            TeamUser::create($requestData);
    
            return redirect("team_user")->with("flash_message", "team_user added!");
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
            $team_user = TeamUser::findOrFail($id);
            return view("team_user.show", compact("team_user"));
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
            $team_user = TeamUser::findOrFail($id);
    
            return view("team_user.edit", compact("team_user"));
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
            
            $team_user = TeamUser::findOrFail($id);
            $team_user->update($requestData);
    
            return redirect("team_user")->with("flash_message", "team_user updated!");
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
            TeamUser::destroy($id);
    
            return redirect("team_user")->with("flash_message", "team_user deleted!");
        }
    }
    //=======================================================================
    
    