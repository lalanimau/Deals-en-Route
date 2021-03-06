<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo \Config::get('app.url') . '/public/frontend/img/favicon.png' ?>">
        <title>@yield('title')</title>
        <!-- common css -->
        <link href="{{ asset('frontend/fonts/fontawesome/font-awesome.css') }}" rel="stylesheet">
             <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
        <link href="{{ asset('frontend/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
         <link href="{{ asset('frontend/css/jasny-bootstrap.css')}}" rel="stylesheet">
        <link href="{{ asset('frontend/css/pages.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/fancyhome.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/easy-autocomplete.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/easy-autocomplete.min.css.map') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/easy-autocomplete.themes.min.css') }}" rel="stylesheet">

        <link href="{{ asset('https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i') }}" rel="stylesheet">
        <!--Dynamic StyleSheets added from a view would be pasted here-->
        @yield('styles')
    </head>
    <body class="pages pages-homepage">
         <input type="hidden" name="hidAbsUrl" id="hidAbsUrl" value="{{URL::to('/')}}" />
        <div id="loadingDiv"> <img src="<?php echo \Config::get('app.url') . '/public/frontend/img/489.gif' ?>" class="loading-gif"></div>
        <div class="errorpopup">
              @if (Session::has('success'))

              <div class="alert-fade alert-success custom-alert">
                <div class="alert alert-success alert-dismissable" role="alert"  >
                    <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <div class="tick-mark-circle"></div>
                    <div class="alert-content">
                        <h3 class="success-text">Success</h3>
                        <span class="msg-text">{{ Session::get('success') }}</span>
                    </div>
                    <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
                </div>
            </div>
            @endif
            
  @if (Session::has('error'))
             <div class="alert-fade alert-danger custom-alert">
                <div class="alert alert-danger alert-dismissable" role="alert"  >
                    <!-- <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <div class="close-circle"></div>
                    <div class="alert-content">
                        <h3 class="success-text">Failed</h3>
                        <span class="msg-text">{{ Session::get('error') }}</span>
                    </div>
                    <button type="button" class="btn btn-success closepopup" aria-label="Close" aria-hidden="true">OK</button>
                </div>
            </div>
    @endif
            <!-- <div class="alert alert-success alert-dismissible" role="alert"  >
                <button type="button" class="close " aria-label="Close"><span aria-hidden="true">&times;</span></button>
                fgfdgdggdfgg
            </div> -->  
         
           
        
        </div>
        <div class="base-wrapper">
            <nav class="navbar nav">
                <div class="wrapper"> <a class="logo smooth-scroll" href="<?php echo \Config::get('app.url')?>"></a></div>
            </nav>

            <!-- end of navbar -->
            @yield('content')
            @include('frontend/modal/login')

            @include('frontend/footer/footer_main')
            <!-- Mainly scripts -->
            <script src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js') }}"></script>
            <script src="{{ asset('frontend/js/bootstrap.js') }}"></script>
          <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
                  <script src="{{ asset('frontend/js/jquery.easy-autocomplete.min.js') }}"></script> 
            <script type="text/javascript" src="{{ asset('frontend/js/webjs/commonweb.js')}}"></script>
            <script type="text/javascript" src="{{ asset('frontend/js/jQuery.fileinput.js')}}"></script>
            <script type="text/javascript" src="{{ asset('frontend/js/webjs/forget.js')}}"></script>
            <script type="text/javascript" src="{{ asset('frontend/js/cleave.min.js')}}"></script>
            <script src="{{ asset('frontend/js/jasny-bootstrap.js')}}"></script>
            <script type="text/javascript" src="{{ asset('frontend/js/webjs/login.js')}}"></script>
            <script type="text/javascript" src="{{ asset('frontend/js/webjs/register.js')}}"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key={{ \Config::get('googlemaps.key') }}&libraries=places&callback=initAutocomplete"
            async defer></script>
            @yield('scripts')


    </body>
</html>

