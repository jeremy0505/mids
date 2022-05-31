<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MyItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


use App\Models\MyProperty;
use App\Models\RoomType;
use App\Models\MyPropertyRoom;

// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | AddProperty Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the creation of a new property record
    |
    */


    /**
     * Where to redirect users after adding a property.
     *
     * @var string
     */
    protected $redirectTo = "/propwizard2";


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
     * Get a validator for an incoming registration data.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        dd('h3');

        return Validator::make($data, [
            'friendly_name' => ['required', 'string', 'max:80'],
            'postal_code' => ['required', 'string', 'email', 'max:10'],
            'currency' => ['required', 'string', 'min:2', 'max:3'],
        ]);
    }

    /**
     * Create a new property instance after a valid form submission.
     *
     * @param  array  $data
     * @return \App\Models\MyProperty
     */
    protected function create(array $data)
    {

        // dd('0-' . str_pad('1',8,'0',STR_PAD_LEFT));

        dd("debug 2");
        $proprec = MyProperty::create([
            'friendly_name' => $data['friendly_name'],
            'postal_code' => $data['postal_code'],
            'currency' => $data['currency'],
        ]);


        return $proprec;
    }


    public function prop_wiz1()
    {

        return view('mids_prop_wiz1');
    }

    public function prop_wiz1_db(Request $data)
    {
        // validate the submitted form data and then store the 
        // new property record

        $validated = $data->validate([
            'friendly_name' => 'required|max:80',
            'postal_code' => 'required|min:5|max:10',
        ]);

        //    Now create the record in my_properties


        $prec = MyProperty::create([
            'user_id' => Auth::id(),
            'friendly_name' => $data['friendly_name'],
            'postal_code' => $data['postal_code'],
            'client_id' => 0,
            'country' => $data['country'],
            'currency' => $data['currency'],

        ]);

        if (session('g_my_property_id') == "")
            Session::put('g_my_property_id', $prec->my_property_id);
        return view('mids_prop_wiz2', [
            'prec' => $prec,
            'rtypes' => RoomType::All()->sortBy('seq')
        ]);
    }



    public function prop_wiz2_db(Request $data)
    {
        // validate the submitted form data and then store the 
        // individual property room records


        // hack - we'll delete the records that exsit for this user

        $deleted = MyPropertyRoom::where('my_property_id', $data->my_property_id)->delete();


        $ids   = $data['room_type_id'];
        $nums  = $data['num'];
        $names = $data['name'];

        $numrecs = count($ids);
        $i = 0;

        // this loop is for the room types 
        while ($i <= $numrecs - 1) {

            if ($nums[$i] != "") {


                // Now create the records in my_property_rooms
                // we want to create multiple room records of the same type if $nums is > 1

                // this loop is for the number of rooms within a room type

                $rec_count = 0;

                if (is_numeric($nums[$i])) {

                    while ($rec_count < $nums[$i]) {
                        $rec_count = $rec_count + 1;

                        if ($nums[$i] == 1)
                            $suffix = "";
                        else
                            $suffix = " " . $rec_count;

                        $proproom = MyPropertyRoom::create([
                            'room_type_id' => $ids[$i],
                            'client_id' => 0,
                            'my_property_id' => $data->my_property_id,
                            'room_name' => $names[$i] . $suffix,

                        ]);

                        // safety net - did introduce an endless loop in early dev

                        if ($rec_count > 100)
                            dd('Bailing out - excess records written for a single room type');
                    }
                }
            }

            $i++;
        }


        // generate an object comprising the room for this property with the ordering from room_types

        $rooms = DB::table('my_property_rooms')
            ->join('room_types', 'my_property_rooms.room_type_id', '=', 'room_types.room_type_id')
            ->orderBy('seq')
            ->get()
            ->where('my_property_id', $data->my_property_id);

        $prec = MyProperty::where('my_property_id', $data->my_property_id)
            ->first();




        return view('mids_prop_wiz3', [
            'prec' => $prec,
            'rooms' => $rooms,
        ]);
    }



    public function prop_wiz3_db(Request $data)
    {
        // validate the submitted form data and then update the 
        // individual property room records with assigned names & comments


        $ids   = $data['property_room_id'];
        $room_names  = $data['room_name'];
        $comments = $data['comments'];

        $numrecs = count($ids);


        $i = 0;

        // this loop is for the room types 
        while ($i <= $numrecs - 1) {

            // a bit lazy but we'll update every record irrespective of whether the comments / names have been 
            // modified

            // the eloquent docs suggest that you need to retrieve the record before updating it - you can use DB 
            // (query builder) approach but this I beleive may bypass the good things that eloquent offers such as
            // updated_date etc.

            // We'll also pull out the first property_room_id as the one we'll pass to the next step of the wizard


            if ($i == 0)
                $property_room_id = $ids[$i];

            MyPropertyRoom::where('property_room_id', $ids[$i])
                ->update([
                    'room_name' => $room_names[$i],
                    'comments'  => $comments[$i]
                ]);

            $i++;
        }


        // $rooms = DB::table('my_property_rooms')
        //     ->join('room_types', 'my_property_rooms.room_type_id', '=', 'room_types.room_type_id')
        //     ->orderBy('seq')
        //     ->get()
        //     ->where('my_property_id', $data->my_property_id);

        // $prec = MyProperty::where('my_property_id', $data->my_property_id)
        //     ->orderBy('my_property_id')
        //     ->first();

        // session(['g_my_property_id' => $data->my_property_id]);


        return view(
            'mids_prop_wiz4',
            ['rmid' => $property_room_id]
        );
    }


    public function prop_wiz4_db(Request $data)
    {
        // validate the submitted form data and then create the "my_items"
        // records - this is not an "update" capability at this time

        $ids         = $data['item_type_id'];
        $qtys         = $data['qty'];
        $names        = $data['name'];
        $comments    = $data['comments'];

        $numrecs = 0;

        if ($ids != "")
            $numrecs     = count($ids);

        $i = 0;

        // this loop is for the item_type_ids - we want to populate by inserting into 
        // my_items



        while ($i <= $numrecs - 1) {

            // if the qty is non-zero then we want to store it

            if ($qtys[$i] != "") {

                $itemrec = MyItem::create([
                    'user_id' => Auth::id(),
                    'item_type_id' => $ids[$i],
                    'property_room_id' => $data['property_room_id'],
                    'my_property_id' => session('g_my_property_id'),
                    'name' => $names[$i],
                    'qty' => $qtys[$i],
                    'comments' => $comments[$i],
                    'client_id' => 0,
                    'version' => 1,
                    'date_effective_from' => now(),
                    'status' => 'ACTIVE'

                ]);

            }

            $i++;
        }


        // we want to redirect the user to the "next" room - which would be the next in sequence after the current room

        //dd("next=" . $data['property_room_id_next']);

        if ($data['property_room_id_next'] == 0) {

            Session::put('g_wizard_mode','N');

            return view(
                'mids_prop_wiz_room_master',
                ['rmid' => session('g_my_property_id')]
            );

        }
        else

            // return view('mids_prop_wiz_room_master',['property_id',session('g_my_property_id')]);


            //        /roomwiz/{{$room->property_room_id}}
            return view(
                'mids_prop_wiz4',
                ['rmid' => $data['property_room_id_next']]

            );
    }
}
