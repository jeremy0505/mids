@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div>
<!-- show number of items in the database 
Perhaps we pass into this blade the object (i.e. would be items but we'll send plans in 
as we have a model for that already)
-->

<p>
Database contains {{$plans->count();}} plans.
<br>
Database contains {{$itemtypes->count();}} item types.
</p>


</div>
@endsection
