@extends('layouts.mids_logged_in')



@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">


                    @foreach ($plans as $p)
                    <article>

                        {{$p->name}}


                    </article>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('topleft')
<span class="bignum">117</span><p>items catalogued.</p>
@endsection