<?php


// enable entry of car reg and retrieval of the details from DVLA



?>

@extends('layouts.mids_logged_in_lite')

@section('content')

<!-- 
    

-->

<div>

    <div>

        <form method="POST" action="/checkreg" name="regform">
            @csrf

            @method('PUT')


            <div class="row mb-2">
                <label for="reg" class="col-sm-1 col-form-label">Enter reg.</label>

                <div class="col-sm-2">
                    <input type="" name="reg" class="form-control" id="reg" value="re68rvj">
                </div>
            </div>
            <div class="btn btn-warning mb-3" onclick="getreg()">Get car details</div>
            <div class="btn btn-warning mb-3" onclick="preflight()">Preflight</div>
            <div class="btn btn-warning mb-3" onclick="simplereq()">SimpleReq</div>

        </form>

    </div>

    <div id="car" style="display:none">

        (will show car details here)

    </div>

</div>





<script>
    function simplereq() {

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'https://google.com');
        xhr.setRequestHeader('Access-Control-Allow-Origin', 'http://localhost:8000/carreg');

        xhr.send();
        //alert("responseText=" + xhr.responseText);


    }

    function preflight() {

        alert("preflight-1");


        const xhr = new XMLHttpRequest();

        const url = 'https://people.googleapis.com/v1/people/me/connections';

        alert("1 - xhr.readyState=" + xhr.readyState);

        xhr.open('GET', url);
        alert("2 - xhr.readyState=" + xhr.readyState);

        xhr.setRequestHeader('Access-Control-Allow-Origin', 'http://localhost:8000/carreg');
        xhr.onreadystatechange = alert("code executed by the onreadystatechange");
        xhr.send();
        alert("XMLHttpRequest.withCredentials=" + XMLHttpRequest.withCredentials);
        alert("3 - xhr.readyState=" + xhr.readyState);

        alert("status=" + xhr.status);
        alert("responseText=" + xhr.responseText);
        alert("preflight-2");

    }

    function getreg() {

        var errorstat = "1";

        //alert(document.forms.regform.reg.value);




        const xhttp = new XMLHttpRequest();


        // xhttp.onload = function() {
        //     car.innerHTML = "hello"
        //         //this.responseText
        //         ;
        //             car.style.display = "block";

        // }

        xhttp.open("PUT", "https://driver-vehicle-licensing.api.gov.uk/vehicle-enquiry/v1/vehicles");


        // xhttp.setRequestHeader( 'Access-Control-Allow-Origin', 'http://localhost' );
        // xhttp.setRequestHeader( 'Content-Type', 'application/json' );
        // xhttp.setRequestHeader( 'Accept', 'application/json' );
        xhttp.setRequestHeader('x-api-key', 'xtya97mSK93EJJgjPmopnwWsqQwaeXi4WDaEflDb');



        xhttp.send('registrationNumber=kS14UTH');


        // xhttp.send('{ "registrationNumber": "ER19BAD" }');

        // alert("ready");

        // fetch('http://localhost:8000/testfiles/jsonfile.json', {
        //         mode: 'same-origin'
        //     })
        //     .then(response => response.json())
        //     .then(data => console.log(data))
        //     .catch(error => {
        //         console.log("error");
        //         errorstat = "errorstat";
        //     });


        // console.log("logging");


        // alert(errorstat);

    }
</script>

@endsection