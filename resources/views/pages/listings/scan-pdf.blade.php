<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ config('app.name') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>
    <!-- Styles -->
    <style type="text/css">
        .page-break {
            page-break-after: always;
        }

        *, :after, :before {
            box-sizing: border-box;
        }
        * {
            outline: none;
        }
        body {
            margin: 0;
            font-family: "Source Sans Pro", sans-serif;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.5;
            text-align: left;
            overflow-x: hidden;
            color: #3e5569;
            background: #fff;
        }
        a {
            color: #2962FF;
            text-decoration: none;
            background-color: transparent;
        }
        p {
            color: #4c4c4c;
            font-weight: 500;
            margin-top: 0;
            margin-bottom: 16px;
        }
        table {
            border-collapse: collapse;
        }
        tr {
            position: relative;
        }
        th {
            text-align: inherit;
        }
        th, td {
            padding: 3px 4px;
        }
        table th {
            font-weight: 600;
            color: #000;
            text-align: center;
        }
        table td {
            font-size: 16px;
            text-align: center;
        }
        img {
            vertical-align: middle;
            border-style: none;
        }
        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: 8px;
            font-family: inherit;
            font-weight: 700;
            line-height: 1.2;
            color: inherit;
        }
        .h1, h1 {
            font-size: 36px;
        }
        .h2, h2 {
            font-size: 30px;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 16px;
            background-color: transparent;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .row {
            display: block;
            margin-right: -10px;
            margin-left: -10px;
            padding: 0;
        }
        .col-12{
            position: relative;
            display: inline-block;
            width: 100%;
            min-height: 1px;
            padding-right: 10px;
            padding-left: 10px;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 4px 12px;
            font-size: 14px;
            line-height: 1.5;
            border-radius: 2px;
        }
        .mb-0, .my-0 {
            margin-bottom: 0!important;
        }

        .business-scan-results {}

        .business-scan-results h1 {
            color: #030303;
            font-size: 52px;
            font-weight: 400;
        }
        .business-scan-results .blue-box h1 {
            color: #ffffff;
            font-size: 29px;
            font-weight: bold;
        }
        .business-scan-results h2 {
            color: #030303;
            font-size: 21px;
            font-weight: 400;
        }
        .business-scan-results .blue-box h2 {
            color: #ffffff;
            font-size: 22px;
            font-weight: normal;
        }

        .text-center {
            text-align: center!important;
        }

        .pt-2, .py-2 {
            padding-top: 8px!important;
        }
        .pt-3, .py-3 {
            padding-top: 16px!important;
        }
        .mb-3, .my-3 {
            margin-bottom: 16px!important;
        }

        .business-scan-results .blue-box {
            padding: 80px 110px 70px;
            background-color: #043e88;
        }
        .col-top {
            display: inline-block;
            margin: 0;
            padding: 0;
        }
        .col-top.left {
            width: 220px;
            height: 220px;
        }
        .col-top.center {
            width: 300px;
            height: 220px;
            padding: 30px;
            margin-top: 40px;
        }
        .col-top.right {
            width: 220px;
            height: 220px;
            margin-top: 40px;
            padding: 30px 0;
        }

        .easy-pie-chart {
            display: block;
            width: 220px;
            height: 220px;
            border-radius: 110px;
            background: #fff;
        }
        .easy-pie-chart .percent {
            width: 220px;
            height: 220px;
            line-height: 160px;
            display: block;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            color: #3b3b3b;
            font-size: 56px;
            font-weight: 700;
        }

        .business-scan-results .blue-box .yellow-box {
            box-shadow: -8px 9px 7px 0 rgba(0,0,0,0.51);
            border-radius: 8px;
            background-color: #f7cf47;
            padding: 15px 15px 20px;
            margin-top: 30px;
        }
        .business-scan-results .btn-blue {
            background-color: #043e88;
            border-radius: 5px;
            color: #fff;
            font-size: 15px;
            width: 100%;
        }
        .business-scan-results .blue-box p {
            color: #c9c9c9;
            font-size: 20px;
        }
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
        }
        .search-results-tble-cont {
            background: #e9e9e9;
            border: 1px solid #e9e9e9;
        }
        .business-scan-results .search-results-tble-cont .table-bordered {
            border: none;
            margin: 0;
        }
        .business-scan-results .search-results-tble-cont .table thead th {
            line-height: 24px;
            padding: 10px 12px;
            color: #030303;
            font-weight: normal;
            font-size: 16px;
            border: none;
            background: #e9e9e9;
        }
        .business-scan-results .search-results-tble-cont tbody tr.nth-of-type-odd {
            background: #c9c9c9;
        }
        .business-scan-results .search-results-tble-cont .table-bordered td {
            line-height: 18px;
            padding: 15px 12px;
            border: none;
            background: #fff;
            vertical-align: top;
            font-size: 16px;
            min-width: 75px;
        }
        .business-scan-results .search-results-tble-cont .table-bordered td.first-child {
            background: #e9e9e9;
            vertical-align: middle;
            padding: 15px 20px;
        }
        .search-results-tble-cont table tbody tr td .fa {
            font-size: 36px;
            width: 20px;
            margin: 0 auto 5px;
        }
        .score_red_txt {
            color: #ef1035;
            font-weight: 500;
            font-size: 40px;
        }
        .d-flex {
            display: block;
        }
        .flex-column {
            text-align: center;
        }
        .align-items-center {
            vertical-align: middle;
            margin-top: 8px;
        }
        .fa.listed {
            color: #008000;
        }
        .fa.mismatch {
            color: #e88c14;
        }
        .fa.notlist {
            color: #ef1035;
        }
    </style>
</head>
<body>
<div id="app">
    <div class="business-scan-results">
        <div class="row">
            <div class="col-12 pt-3">
                <div class="blue-box">
                    <div class="row">
                        <div class="col-top left">
                            <div class="easy-pie-chart">
                                <div class="percent"> <span class="number">{{ $result['mean_score'] }}%</span></div>
                            </div>
                        </div>
                        <div class="col-top center">
                            <div>
                                <h1>{{ $result['name'] }}</h1>
                                <h2>{{ $result['address'] }}</h2>
                                <h2>{{ $result['phone'] }}</h2>
                            </div>
                        </div>
                        <div class="col-top right">
                            <div>
                                <div class="yellow-box text-center">
                                    <h1 class="text-center"><span style="font-size: 25px; font-weight: normal;">Get to</span> 100%</h1>
                                    <a href="#" class="btn btn-blue" style="white-space: pre-wrap;">Improve with GEOKING</a>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="col-12 text-center pt-3">
                            <p class="mb-0">The Listing Score is designed to rate the online visibility of your business.</p>
                            <p class="mb-0">This score takes into consideration the listing's accuracy, completeness, duplicates, and claim status.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-break"></div>

        @php
            $otherRows = [
                public_path('assets/images/bing-icon-big.png'),
                public_path('assets/images/fb-icon-big.png'),
                public_path('assets/images/force-icon-big.png'),
            ];
        @endphp

        @if (count($listResults) === 1)
        <div class="row">
            <div class="col-12 pt-4">
                <div class="table-responsive search-results-tble-cont">
                    <table id="searchResults" class="table table-striped table-bordered" width="100%">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Score</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="nth-of-type-even">
                            <td class="first-child"><img src="{{ public_path('assets/images/google-icon-big.png') }}"/></td>
                            <td>
                                <span @if ($result['google']['total_status'] === 'Listed')
                                   class="fa fa-check-circle listed"
                                   @else
                                   class="fa fa-exclamation-circle notlist"
                                   @endif
                                   aria-hidden="true">
                                </span>
                                <br>
                                {{ $result['google']['total_status'] }}
                            </td>
                            <td>
                                <span @if ($result['google']['name']['status'] === 'Match')
                                   class="fa fa-check-circle listed"
                                   @elseif ($result['google']['name']['status'] === 'Mismatch')
                                   class="fa fa-exclamation-circle mismatch"
                                   @else
                                   class="fa fa-exclamation-circle notlist"
                                   @endif
                                   aria-hidden="true">
                                </span>
                                <br>
                                {{ $result['google']['name']['status'] }}
                            </td>
                            <td>
                                <span @if ($result['google']['address']['status'] === 'Match')
                                   class="fa fa-check-circle listed"
                                   @elseif ($result['google']['address']['status'] === 'Mismatch')
                                   class="fa fa-exclamation-circle mismatch"
                                   @else
                                   class="fa fa-exclamation-circle notlist"
                                   @endif
                                   aria-hidden="true">
                                </span>
                                <br>
                                {{ $result['google']['address']['status'] }}
                            </td>
                            <td>
                                <span @if ($result['google']['phone']['status'] === 'Match')
                                   class="fa fa-check-circle listed"
                                   @elseif ($result['google']['phone']['status'] === 'Mismatch')
                                   class="fa fa-exclamation-circle mismatch"
                                   @else
                                   class="fa fa-exclamation-circle notlist"
                                   @endif
                                   aria-hidden="true">
                                </span>
                                <br>
                                {{ $result['google']['phone']['status'] }}
                            </td>
                            <td>
                                <div class="d-flex flex-column align-items-center">
                                    <p class="score_red_txt mb-3 pt-2">{{ $result['google']['score'] }}%</p>
                                </div>
                            </td>
                        </tr>

                        @foreach ($otherRows as $row)
                            <tr class="{{ ($loop->iteration & 1) ? 'nth-of-type-odd' : 'nth-of-type-even' }}">
                                <td class="first-child"><img src="{{ $row }}"/></td>
                                <td><span class="fa fa-exclamation-circle notlist" aria-hidden="true"> </span> <br>Not Listed</td>
                                <td><span class="fa fa-exclamation-circle notlist" aria-hidden="true"> </span> <br>Not Listed</td>
                                <td><span class="fa fa-exclamation-circle notlist" aria-hidden="true"> </span> <br>Not Listed</td>
                                <td><span class="fa fa-exclamation-circle notlist" aria-hidden="true"> </span> <br>Not Listed</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <p class="score_red_txt mb-3 pt-2">0%</p>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12 pt-4">
                <div class="table-responsive search-results-tble-cont">
                    <table id="searchResults" class="table table-striped table-bordered" width="100%">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            @foreach ($listResults as $result)
                                <th class="sorting_disabled">{{ $result['name'] }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="nth-of-type-even">
                            <td class="first-child"><img src="{{ public_path('assets/images/google-icon-big.png') }}"/></td>
                            @foreach ($listResults as $result)
                                <td>{{ $result['google']['score'] }}%</td>
                            @endforeach
                        </tr>
                        @foreach ($otherRows as $row)
                        <tr class="{{ ($loop->iteration & 1) ? 'nth-of-type-odd' : 'nth-of-type-even' }}">
                            <td class="first-child"><img src="{{ $row }}"></td>
                            @for ($i = 0, $len = count($listResults); $i < $len; $i++)
                                <td>0%</td>
                            @endfor
                        </tr>
                        @endforeach
                        <tr class="{{ ((count($otherRows)+1) & 1) ? 'nth-of-type-odd' : 'nth-of-type-even' }}">
                            <td class="font-22 font-weight-bold first-child">Net Score</td>
                            @for ($i = 0, $len = count($listResults); $i < $len; $i++)
                                <td>0%</td>
                            @endfor
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

    </div>

</div>

</body>
</html>