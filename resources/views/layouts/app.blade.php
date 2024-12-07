<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="AppReimburs" />
    <meta name="author" content="ArkhiMS" />

    <link href="{{ URL::asset('css/styles.css') }}" rel="stylesheet" />
    <link
            href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/fc-5.0.0/r-3.0.0/sr-1.4.0/datatables.min.css"
            rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/img/favicon.png') }}">
    @yield('head')

</head>

<body class="nav-fixed">
    @include('layouts.topbar')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('layouts.sidebar')
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
</script>
    </script>
    <script src="{{ URL::asset('js/scripts.js') }}"></script>
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29/moment.min.js" crossorigin="anonymous"></script>

    <script
            src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/fc-5.0.0/r-3.0.0/sr-1.4.0/datatables.min.js">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('js/litepicker.js') }}"></script>

    <script>
        var apiURL = "";
    </script>
    @yield('script')
</body>

</html>
