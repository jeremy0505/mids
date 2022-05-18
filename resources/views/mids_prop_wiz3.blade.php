<?php
// dd($prec->friendly_name);
//dd($rtypes->first()->code);

?>

@extends('layouts.mids_logged_in_lite')

@section('content')

<!-- create a layout that utilises the top of the screen for navigation initially -->

<!-- Now let's walk the user through the rooms that have been defined - we will expose the default 
     assigned name as well as provide a comments box

-->


<div class="container pt-2">

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body background bg-dark text-white">
                    <h5 class="card-title">Wizard step 3</h5>

                    <p class="card-text background">Thank you for identifying the numbers of each types of room at {{ $prec->friendly_name}}. Now we'd like you to assign alternative names for rooms so that they are more easily recognised by you.</p>


                </div>
                <div class="card-footer">


                    <form method="POST" action="/storeroomnames">
                        @csrf

                        @method('PUT')


                        <input type="hidden" name="my_property_id" value="{{ $prec->my_property_id}}">

                        <!-- Need to display now each of the rooms and allow its name to be edited -->
                        @foreach ($rooms as $room)

                        <input type="hidden" name="property_room_id[]" value="{{ $room->property_room_id }}">

                        <div class="row mb-3">
                            <label for="{{$room->room_name}}" class="col-sm-4 col-form-label">{{ trim($room->room_name) }}</label>
                            <div class="col-sm-3">
                                <input type="" name="room_name[]" class="form-control" id="{{ trim($room->property_room_id)}}" value="{{ trim($room->room_name) }}">
                            </div>
                            <div class="col-sm-5">
                                <input type="" name="comments[]" class="form-control" id="{{ trim($room->property_room_id)}}" placeholder="Add comments">
                            </div>
                        </div>


                        @endforeach


                        <button type="submit" class="btn btn-primary mb-3">Save & continue...</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection