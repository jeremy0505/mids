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
                <div class="card-body background w-100 text-black" style="background:var(--info-panel-bg)">
                    <h5 class="card-title">New user?</h5>

                    <p class="card-text">You don't yet have any properties defined. We can help you through the process here by using the wizard or you can come back and use it later. Or if you prefer, you can manually add details of your properties and their contents independently of the wizard. </p>


                </div>
                <div class="card-footer">
                    <div class="container-fluid">
                        <div class="float-left"><a href="/prop_wizard" class="btn btn-dark">Continue with wizard</a>
                        <div class="float-end"><a href="/home" class="btn btn-warning">Continue to dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection