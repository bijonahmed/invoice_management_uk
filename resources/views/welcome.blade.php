<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AccountManagement</title>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ env('APP_NAME') }}</title>
    {{-- <link rel="shortcut icon" href="{{ asset('backend//assets/media/logos/favicon.ico') }}" /> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&amp;display=swap"
        rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('/backend/assets/vendors/core/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('/backend/assets/vendors/flatpickr/flatpickr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/backend/assets/fonts/feather-font/css/iconfont.css') }}" />
    <link rel="stylesheet" href="{{ asset('/backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/backend/assets/vendors/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/backend/assets/css/demo1/style.min.css') }}" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.0/css/all.css">
    <link rel="shortcut icon" href="{{ asset('/backend/assets/images/favicon.png') }}" />

    <script src="{{ asset('/backend/assets/jquery-3.6.1.min.js') }}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" defer></script>
    <script src="
    https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/build/jquery.datetimepicker.full.min.js
    "></script>
    <link href="
https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/jquery.datetimepicker.min.css
"
        rel="stylesheet">
    <style>
        .sidebar .sidebar-body .nav {
            display: flex;
            flex-direction: column;
            padding: 5px 25px 25px 25px;
        }
    </style>
</head>
@if (Auth::check())
    <script>
        window.authUser = {!! json_encode(Auth::user()) !!};
    </script>
@else
    <script>
        window.authUser = null;
    </script>
@endif
@vite(['resources/css/app.css', 'resources/js/app.js'])
<div id="app"></div>
 



<script src="{{ asset('/backend/assets/vendors/core/core.js') }}" defer></script>
<script src="{{ asset('/backend/assets/vendors/flatpickr/flatpickr.min.js') }}" defer></script>
<script src="{{ asset('/backend/assets/vendors/apexcharts/apexcharts.min.js') }}" defer></script>
<script src="{{ asset('/backend/assets/vendors/feather-icons/feather.min.js') }}" defer></script>
<script src="{{ asset('/backend/assets/js/template.js') }}" defer></script>
<script src="{{ asset('/backend/assets/js/select2.js') }}" defer></script>

</html>
