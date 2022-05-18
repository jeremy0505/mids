<?php
// dd($prec->friendly_name);
//dd($rtypes->first()->code);

?>

@extends('layouts.mids_logged_in_lite')

@section('content')

<!-- create a layout that utilises the top of the screen for navigation initially -->

<!-- The user will now have a property and so we want to now find out how many of each type of room there is


-->


<div class="container pt-2">

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body background bg-dark text-white">
                    <h5 class="card-title">Wizard step 2</h5>

                    <p class="card-text background">Now we'd like to know how many rooms of each type you have at {{ $prec->friendly_name}}.</p>


                </div>
                <div class="card-footer">


                    <form method="POST" action="/storenumrooms">
                        @csrf

                        @method('PUT')
                        

                        <input type="hidden" name="my_property_id" value="{{ $prec->my_property_id}}">

                        @foreach ($rtypes as $rtype)

                        <input type="hidden" name="room_type_id[]" value="{{ $rtype->room_type_id }}">
                        <input type="hidden" name="name[]" value="{{ trim($rtype->name) }}">

                        <div class="row mb-3">
                            <label for="{{$rtype->code}}" class="col-sm-4 col-form-label">{{ trim($rtype->name) }}</label>
                            <div class="col-sm-3">
                            <input type="" name="num[]" class="form-control" id="{{ trim($rtype->code)}}" placeholder="#rooms">
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