<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\ItemType;
use App\Models\MyProperty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;



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




        $props = MyProperty::where('user_id', auth()->user()->id)->get();       

         
        // dd($props, auth()->user()->id, 'hello');

        Log::info('Checking property details for user .', ['id' => auth()->user()->id]);
        Log::info('#properties = ' . $props->count());


        if ($props->count() === 0)
        
            return view('mids_no_props_yet');

        elseif ($props->count() === 1){
            
            Session::put('g_my_property_id',$props->first()->my_property_id);

            Log::info('g_my_property_id = ' . $props->first()->my_property_id);

            return view('mids_home', [
                'plans' =>  Plan::all(),
                'itemtypes' => ItemType::all()
            ]);
        }
        else
          dd("user has more than 1 property - code yet to be built!");

    }
    public function index()
    {
  
          return view('mids_home');
    }    
    
}
