<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{config('app.name')}}</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="{{asset('plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" media="screen" />
        <link href="{{asset('plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
        <link href="{{asset('plugins/switchery/css/switchery.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
        <link href="{{asset('plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css" media="screen" />
        <link class="main-stylesheet" href="{{asset('pages/css/themes/corporate.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body class="fixed-header dashboard menu-pin menu-behind" id="dashboard">

        {{-- Begin Content --}}
        @yield('content')
        {{-- End Content --}}

        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{asset('plugins/modernizr.custom.js')}}"></script>
        <script src="{{asset('plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
        <script src="{{asset('plugins/classie/classie.js')}}"></script>
        <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{asset('plugins/popper/umd/popper.min.js')}}"></script>
        <script src="{{asset('plugins/jquery/jquery-easy.js')}}"></script>
        <script src="{{asset('plugins/jquery-unveil/jquery.unveil.min.js')}}"></script>
        <script src="{{asset('plugins/jquery-ios-list/jquery.ioslist.min.js')}}"></script>
        <script src="{{asset('plugins/jquery-actual/jquery.actual.min.js')}}"></script>
        <script src="{{asset('plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    
        <script src="{{asset('pages/js/pages.min.js')}}"></script>

        {{-- Pages custom script --}}
        @yield('custom-scripts')
        {{-- End --}}
    </body>
</html>
