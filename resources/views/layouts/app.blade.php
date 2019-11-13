<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />

    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="preload" as="style">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/main.css') }}" rel="preload" as="style">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    

    <link href="{{ asset('css/light_custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-2.css') }}" rel="stylesheet">
    
    <style>
      #team-form .avatar-cropper .avatar-cropper-img-input {
        display: block;
        opacity: 0;
        width: 0;
        height: 0;
      }
      .create-post-form [type="url"] {
        border: 0;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        border-bottom: 1px solid #bdbdbd !important;
        outline: 0;
        padding-left: 0;
        padding-right: 0;
        font-size: 19px;
        color: #4a4a4a;
      }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
</head>
<body class="lang_{{app()->getLocale()}}">
    <div id="app" class="box-sizing-inherit">

        <!-- Preloader - style you can find in spinners.css --> 
        <div class="preloader">
          <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
          </div>
        </div>

        @yield('content')

        <the-alert></the-alert>
    </div>


    <script src="{{ mix('js/app.js') }}"></script>

    <!--Pie Chart --> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js"></script>

    <!-- HighChart JS-->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/maps/modules/map.js"></script>
    <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.2.2/proj4.js"></script>

    <!-- Google Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!--Index -->
    <script src="{{ mix('js/index-location.js') }}"></script>
    
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js'></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script>
      $(document).ready(function(){ 
      $('#location').multiselect({
        includeSelectAllOption : true,
        nonSelectedText: 'Select an Option'
      });
      $('#location-dropdown').multiselect({
        includeSelectAllOption : true,
        nonSelectedText: 'Select an Option'
      });
      $('#review_location').multiselect({
      includeSelectAllOption : true,
        nonSelectedText: 'location',
        allSelectedText: 'All'
      });
      $("#timezone").select2({ width: '30%' });
    });
    </script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 
</body>
</html>
