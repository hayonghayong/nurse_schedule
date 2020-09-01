<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\User;
    
    class UsersController extends Controller
    {
      //看護師表示
    public function allstaffs(){ 
    // $wardId= Auth::ward_id();
     // $patients = Patient::where('ward_id','=', $wardId)
    // ->orderBy('room', 'asc')
    // ->get();
    $staffs = User::orderBy('id','asc')->get();
    return $staffs;
  }  
    }
    
    