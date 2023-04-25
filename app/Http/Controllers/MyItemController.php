<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\MyItem;
use App\Models\MyProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class MyItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MyItem  $myItem
     * @return \Illuminate\Http\Response
     */
    public function show(MyItem $myItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MyItem  $myItem
     * @return \Illuminate\Http\Response
     */
    public function edit(MyItem $myItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MyItem  $myItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyItem $myItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MyItem  $myItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyItem $myItem)
    {
        //
    }


    public function createsample()
    {

        // this will be a protected (by sanctum) function
        // we don't want to create sample items if there are already ones created - they are identified by 
        // the column "sample_flag" being set to Y
        //

        // 

        $user = Auth::user();

        $numitems = MyItem::orderBy('my_item_id', 'ASC')
            ->where('user_id', $user->id)
            ->where('sample_flag', 'Y')
            ->count();

        // return ['num_items' => $numitems];

        if ($numitems == 0) {
            //return('will create sample');
            // want to do an 'insert into select from' here - can we?

            // check for a property
            $props = MyProperty::where('user_id', $user->id)->count();
            if ($props == 0) {
                // create a property record
                DB::insert("insert into my_properties (user_id, client_id, friendly_name,country)
                            values ('$user->id',0,'Home','UK')");
            }


            DB::insert("insert into my_items 
                        (item_type_id, user_id,my_property_id, client_id, status, version, date_effective_from,name,mfr,serial_number,model_name, 
                        cost_initial, val_now, purch_date, start_date, expiry_date,cost_recurring,cost_recurring_freq,colour, mileage, mot_date, sample_flag)
                        select it.item_type_id, '$user->id', 
                        mp.my_property_id,
                        0,
                        'ACTIVE',
                        1, 
                        curdate(),mfr, 
                        mfr,serial_number,model_name,cost_initial, val_now,purch_date,start_date,expiry_date,cost_recurring,cost_recurring_freq,colour, mileage, mot_date, 'Y'
                        from sample_my_items smy, item_types it, my_properties mp
                        where smy.item_code = it.code
                        and   mp.user_id = '$user->id'");

            return ['status' => 'OK', 'message' => 'Sample data created OK'];
        } else {
            return ['status' => 'OK', 'message' => 'Sample data already present'];
        }
    }


    public function item_summary_counts()
    {

        // this will be a protected (by sanctum) function
        // we don't want to create sample items if there are already ones created - they are identified by 
        // the column "sample_flag" being set to Y
        //

        // 

        $cats = "('ENTERTAINMENT','INSURANCE','MOTOR','CLOUD')";

        $user = Auth::user();

        // get the number of items by category from the view v_my_items_summary

        // DB::select("select * from v_my_items_summary where ifnull(user_id,$user->id) = $user->id");



        $results = DB::table('v_my_items_summary')
            ->select(
                DB::raw(
                    'sum(count_items) count_items,
                    sum(sum_cost_recurring) sum_cost_recurring,
                    reporting_category'
                )
            )
            ->whereRaw("ifnull(user_id,$user->id)=$user->id
                        and reporting_category in $cats")
            ->groupBy('reporting_category')
            ->orderBy('reporting_category')
            ->get();

        // do some post-query processing to ensure that the JSON we return has everything required - we want to add
        // "zero" hint and also long label and graph label

        $hint = array();
        $label_long = array();
        $label_graph = array();

        $i = 0;
        foreach ($results as $r) {
            if ($r->reporting_category == 'ENTERTAINMENT') {
                $label_long[$i] = 'Entertainment services';
                $label_graph[$i] = 'Entertainment';
            } elseif ($r->reporting_category == 'CLOUD') {
                $label_long[$i] = 'Cloud Subscriptions';
                $label_graph[$i] = 'Cloud';
            } elseif ($r->reporting_category == 'INSURANCE') {
                $label_long[$i] = 'Insurance policies';
                $label_graph[$i] = 'Insurance';
            } elseif ($r->reporting_category == 'MOTOR') {
                $label_long[$i] = 'Vehicles';
                $label_graph[$i] = 'Vehicles';
            } else {
                $label_long[$i] = $r->reporting_category;
                $label_graph[$i] = $r->reporting_category;
            }


            if ($r->count_items == 0) {
                if ($r->reporting_category == 'ENTERTAINMENT')
                    $hint[$i] = 'Hint: set up details of TV and Audio subscriptions such as Netflix an Spotify';
                elseif ($r->reporting_category == 'CLOUD')
                    $hint[$i] = 'Hint: set up details of your DropBox, iCloud, Office 365 etc. subscriptions';
                elseif ($r->reporting_category == 'INSURANCE')
                    $hint[$i] = 'Hint: set up details of your home, buildings, vehicle and other insurance policies';
                elseif ($r->reporting_category == 'MOTOR')
                    $hint[$i] = 'Hint: set up details of your cars, motorcycles, quad bikes etc.';
                else
                    $hint[$i] = 'Hint (empty)';
            } else {
                $hint[$i] = '';
            }


            $i++;
        }

        // so we have the additional texts that we want; now we have to build the final array
        $finarray = array();

        $i = 0;
        foreach ($results as $r) {
            $finarray[$i] = array('reporting_category' => $r->reporting_category, 
                                  'count_items' => $r->count_items, 
                                  'sum_cost_recurring' => $r->sum_cost_recurring, 
                                  'label_graph' => $label_graph[$i], 
                                  'label_long' => $label_long[$i],
                                  'hint' => $hint[$i]);
            $i++;
        }

        return $finarray;
    }

	static function item_basic_data($systype)
	{


		$user = Auth::user();


		return (DB::table('v_my_items')
			->select(DB::raw('*,concat(mids.mfr_strip(mfr), ".png") mfr_logo'))
			->where('cat_system_type', '=', strtoupper($systype))
			->where('user_id', $user->id)
			->get());
	}

}
