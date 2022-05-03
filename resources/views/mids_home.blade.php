@extends('layouts.mids_logged_in')

@section('content')

<!-- create a layout that utilises the top of the screen for navigation initially -->

<!-- The navbar is within the layout blade - we will add
     - crumb trail
     - search box
     - container itself containing 2 columns of cards

     The footer is within the layour blade


-->


<!-- info / direction -->
<div class="container pt-2">

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body background w-100 text-black" style="background:var(--info-panel-bg)">
                    <h5 class="card-title">Welcome</h5>
                    
                    <p class="card-text">We have no specific messages for you at this time.</p>


                </div>
            </div>
        </div>
    </div>

</div>


<!-- 4-card, 2-up block -->

<div class="container pt-5">
    <!-- Row 1 -->
    <div class="row">
        <div class="col">
            <div class="card">

                <div class="card-body background bg-light">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>



            </div>
        </div>
        <div class="col">
            <div class="card">

                <div class="card-body background bg-light">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>



            </div>

        </div>
    </div>




    <!-- Row 2 -->
    <div class="row pt-5">
        <div class="col">
            <div class="card">

                <div class="card-body background bg-light">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>



            </div>
        </div>
        <div class="col">
            <div class="card">

                <div class="card-body background bg-light">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>



            </div>

        </div>
    </div>
</div>

<div>


</div>
@endsection