<!DOCTYPE html>
<html lang="en">

<head>
    <title>title...</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<!-- Local styles -->
<style>
    p {
        font-family: Nunito;
    }

    #outline {
        border: 1px solid lightgrey;
        margin: 10px;
        padding: 10px;
    }

    .header {
        border-radius: 10px;

        margin: 10px;
        padding: 10px;

        border: 1px solid palegoldenrod;
        height: 60px;

        background-color: #ebf2d5;
    }

    .headerleft {

        float: left;
    }


    #userstat {
        float: right;
        vertical-align: middle;
    }

    .crumb {
        border-radius: 10px;
        width: 90%;

        margin: 10px;
        padding: 10px;

        /* border: 1px solid grey; */
        height: auto;
    }

    .context {
        border-radius: 10px;

        margin: 10px;
        padding: 10px;

        border: 1px solid green;
        height: 150;
    }

    .maincontent {
        border-radius: 10px;

        margin: 10px;
        padding: 10px;

        border: 1px solid orange;
        /* height: auto; */
        overflow: auto;

    }

    #topleft {

   float: left;
        width: 48%;

        min-height: 250px;


        border: 1px solid black;

    }

    #topright {

        float: right;
        width: 48%;
        min-height: 250px;

        border: 1px solid black;

    }

    .footer {
        border-radius: 5px;

        /* margin: 10px; */
        padding: 10px;

        background-color: darkslategrey;
        color: white;


    }

    .footer a:link {
        color: white
    }

    .bignum{
        font-size:4rem;
    }
</style>

<body>

    <div id="outline">
        <div class="header">
            <div class="headerleft">
                <p>MiDigitalSafe</p>
            </div>
            <div id="userstat">

                @auth
                <span class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </span>
                @endauth

            </div>
        </div>

        <div class="crumb">
            <p>crumbtrail</p>
        </div>

        <div class="context">
            <p>context</p>

        </div>

        <div class="maincontent">
            <p>maincontent area</p>
            <main>
                <div id="topleft">
                @yield('topleft')
                </div>
                <div id="topright">
      
                </div>




            </main>
        </div>





        <div class="footer">
            <p>Copyright (c) 2022 - MiDigitalSafe | <a href="#">Terms of use</a> | <a href="#">Privacy policy</a></p>
        </div>

    </div>
</body>

</html>