<?php

use Illuminate\Support\Facades\Session;

Session::put('g_wizard_mode','Y');


?>



@extends('layouts.mids_logged_in_lite')

@section('content')

<!-- create a layout that utilises the top of the screen for navigation initially -->

<!-- The user has no properties so we want to offer two options
    - access the wizard 
    - contine to dashboard
-->



<div class="container pt-2">

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body background bg-dark text-white">
                    <h5 class="card-title">Wizard step 1</h5>

                    <p class="card-text background">Firstly please tell us about your property.</p>


                </div>
                <div class="card-footer">

                    <form method="POST" action="/storeproperty">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="friendly_name" class="form-label">Property name</label>
                            <input type="" name="friendly_name" class="form-control" id="friendly_name" value="{{ old('friendly_name') }}"placeholder="What I call this property" required>
                        </div>

                        <div class="mb-3">
                            <label for="postal_code" class="form-label">Postal code</label>
                            <input type="" name="postal_code" class="form-control" id="postal_code" value="{{ old('postal_code') }}" placeholder="Postal code" required>
                        </div>




                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>

                            <select name="country" class="custom-select custom-select-lg mb-3" required>

                                <!-- <select name="country" required> -->


                                <option value="GB" selected="selected">Great Britain</option>
                                <option value="IE">Ireland</option>
                                <option value="US">United States</option>
                                <option value="AU">Australia</option>
                                <option value="NZ">New Zealand</option>




                            </select>


                        </div>





                        <div class="mb-3">
                            <label for="currency" class="form-label">Default Currency</label>
                            <!-- <input type="" class="form-control" id="xxx" placeholder="" required> -->


                            <select name="currency" required>


                                <option value="GBP" selected="selected">UK Pounds Sterling</option>
                                <option value="EUR">Euros</option>
                                <option value="USD">US Dollars</option>
                                <option value="CAD">Canadian Dollars</option>
                                <option value="AUD">Australian Dollars</option>




                            </select>


                        </div>


                        <!-- Photo upload of property -->

                        <!--  code here is lifted straight from bootstrap docs 
                         looks awful on the page. Also don't know how the uploaded
                         file content should be stored - in DB or external -->


                        <!-- <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div> 
                        -->

                        <button type="submit" class="btn btn-primary mb-3">Save & continue...</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection