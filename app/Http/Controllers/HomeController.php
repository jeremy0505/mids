<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\ItemType;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login_check()
    {
        // if the user has no properties defined then take them to 
        // a different page

        // get number of properties for this user


        $numprops = DB::table('my_properties')
            ->select('my_property_id')
            ->where('user_id', auth()->user()->id)
            ->get()->count();



        // dd($props, auth()->user()->id, 'hello');

        if ($numprops === 0)
            return view('mids_no_props_yet');
        else
            return view('mids_home', [
                'plans' =>  Plan::all(),
                'itemtypes' => ItemType::all()
            ]);
    }
    public function index()
    {
  
          return view('mids_home');
    }    
    
    public function prop_wizard()
    {
  
          return view('mids_prop_wizard');
    }
}
