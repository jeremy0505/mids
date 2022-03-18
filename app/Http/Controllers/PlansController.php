<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;


class PlansController extends Controller
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
    public function fn_plan()
    {

        return view('plans', ['plans' =>  Plan::all()]);
        //return view('plans');
    }
}
