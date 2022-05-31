<?php

use App\Models\ItemType;
use App\Models\MyPropertyRoom;
use App\Models\RoomType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


// Log::info('MIDS_PROP_WIZ4: Session variables .', ['my_property_id', session('g_my_property_id')]);
// Log::info('MIDS_PROP_WIZ4: Session variables .', ['data', session()->all()]);

function dbg($mesg)
{
    echo $mesg;
    echo "<br>";
};

// $rmid is the property_room_id - passed in from the router

$roomrec = MyPropertyRoom::where('property_room_id', $rmid)->get();

// did we get a record?

if ($roomrec->count() == 0) {
    echo "Unable to access roomrec details or user not authenticated";
    return;
}


$thisroom = $roomrec->first()->room_name;
$room_type_id = $roomrec->first()->room_type_id;

// get the next room in sequence



$g_rooms = session('g_rooms');

if ($g_rooms == "") {

    $rooms = MyPropertyRoom::orderBy('seq', 'ASC')
        ->orderBy('room_name', 'ASC')
        ->where('my_property_id', session('g_my_property_id'))
        ->join('room_types', 'my_property_rooms.room_type_id', '=', 'room_types.room_type_id')
        ->get();

    Session::put('g_rooms', $rooms);
    $g_rooms = session('g_rooms');
}

// get the next (based on sequence) room ID which we will asutomatically take the user to upon submission

$property_room_id_next = 0;

$flag = "N";

foreach ($g_rooms as $r) {



    if ($flag <> "Y") {

        if ($r->property_room_id == $rmid) {
            $flag = "P";
        } elseif ($flag == "P") {
            $property_room_id_next = $r->property_room_id;
            $flag = "Y";
        }
    }
};


if (session('g_rooms')->count() == 0) {
    echo "Unable to access list of rooms or user not authenticated";
    return;
}


$items = ItemType::all()->where('dflt_room_type_id', $room_type_id)
    ->where('include_in_wizard', 'Y');


// also ideentify now if there is already any room items data for this room - if so then
// we will display the current info stored as opposed to prompting


?>

@extends('layouts.mids_logged_in_lite')

@section('content')

<!-- create a layout that utilises the top of the screen for navigation initially -->

<!--
    
Ok this next part is to present the relevant items per room from which 
the user is asked to specify how many of each they have

-->

<div class="container pt-2">

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body background bg-dark text-white">
                    <h5 class="card-title">Wizard step 4</h5>

                    <p class="card-text background">Now we will help you identify the items you have in each room of your property - selected room is {{ $thisroom}}</p>


                </div>
                <div class="card-footer">

                    @if (session('g_wizard_mode'=='Y'))
                    <div class="dropdown align-content-end">
                        <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Room selector
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach ($g_rooms as $room)
                            <li><a class="dropdown-item" href="/roomwiz/{{$room->property_room_id}}">{{$room->room_name}}</a></li>

                            @endforeach
                        </ul>

                        <!-- items available -->


                    </div>
                    @endif

                    <form method="POST" action="/storeroomitems">
                        @csrf

                        @method('PUT')


                        <input type="hidden" name="property_room_id" value="{{ $rmid}}">
                        <input type="hidden" name="property_room_id_next" value="{{ $property_room_id_next}}">
                        <input type="hidden" name="wizard_mode" value="{{ session('g_wizard_mode') }}">


                        <!-- Need to display now each of the items and allow quantity to be entered -->
                        @foreach ($items as $item)

                        <input type="hidden" name="item_type_id[]" value="{{ $item->item_type_id}}">




                        <div class="row mb-3">
                            <label for="{{$item->name}}" class="col-sm-2 col-form-label">{{ trim($item->name) }}</label>
                            <div class="col-sm-1">
                                <input type="" name="qty[]" class="form-control" id="{{ trim($item->item_type_id)}}" value="" placeholder="Qty" onchange="toggle();">
                            </div>

                            <div class="col-sm-1">
                                <div class="form-check">

                                    <input type="checkbox" name="same[]" class="form-check-input" id="{{ trim($item->item_type_id)}}" placeholder="?">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <input type="" name="name[]" class="form-control" id="{{ trim($item->item_type_id)}}" value="{{ trim($item->name) }}" placeholder="Your name for this item">
                            </div>



                            <div class="col-sm-4">
                                <input type="" name="comments[]" class="form-control" id="{{ trim($item->item_type_id)}}" placeholder="Add comments">
                            </div>
                        </div>


                        @endforeach
                        <p></p>
          
                        @if (session('g_wizard_mode') == 'Y')
                        <button type="submit" class="btn btn-primary mb-3">Save & next room...</button>
                        @else
                        <button type="submit" class="btn btn-primary mb-3">Save</button>
                        @endif
                    </form>


                </div>
            </div>
        </div>
    </div>

</div>

@endsection

<script>
    function toggle() {
        // alert("toggle!");
        return;
    }
</script>