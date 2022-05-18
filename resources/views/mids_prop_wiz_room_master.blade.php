<?php

use App\Models\ItemType;
use App\Models\MyItem;
use App\Models\MyPropertyRoom;
use Illuminate\Support\Facades\DB;


// make this show the rooms & number of items in each room

// $room = MyPropertyRoom::get()->where('my_property_id',session('g_my_property_id'))->count();



// $room = MyPropertyRoom::join('MyItem','MyPropertyRooms.property_room_id','MyItem.property_room_id')
//          ->where('MyPropertyRoom.my_property_id',session('g_my_property_id'))
//          ->select(
//                   'MyPropertyRoom.property_room_id',
//                   'MyPropertyRoom.room_name'
//           )
//          ->get();


$rooms = DB::table('my_property_rooms')
    ->join('room_types', 'my_property_rooms.room_type_id', 'room_types.room_type_id')
    ->select('my_property_rooms.*')
    ->where('my_property_rooms.my_property_id', session('g_my_property_id'))
    ->orderBy('room_types.seq')
    ->orderBy('my_property_rooms.room_name')
    ->get();

$i = 0;

?>

@extends('layouts.mids_logged_in_lite')

@section('content')

<!-- 
    
Display a grid of tiles reflecting the rooms that have been identified and with summary
information in each one. Each tile is itself a link into the room items wizard.

-->

<div class="container pt-2">

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body background bg-dark text-white">
                    <h5 class="card-title">Wizard - Room Master</h5>

                    <p class="card-text background">Use this page to see an overview of rooms you have identified with summary information. Click on any room tile to manage that room's details</p>


                </div>
                <div class="card-footer">


                    <div class="row">

                        @foreach ($rooms as $room)
                        <?php
                        
                        $i = $i+1;


                        $num_items = 0;
                        $num_items = MyItem::where('property_room_id', $room->property_room_id)->count();

                        ?>


                        <div class="col">
                            <div class="card">

                                <div class="card-body background bg-light">
                                    <h5 class="card-title">{{$room->room_name}}</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>



                            </div>
                        </div>

                        <?php
                   

                        // end the row div whenever the count is divisible by 3 exactly - using modulus
                        if ($i % 3 == 0)
                          echo '</div> <div class="row">';
                        
                        ?>
                        @endforeach

                    </div>





                </div>
            </div>
        </div>
    </div>

</div>

@endsection

<script>
    function toggle() {
        alert("toggle!");
    }
</script>