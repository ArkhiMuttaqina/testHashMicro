@extends('layouts.app')

@section('content')
    <main>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-5">

            <div class="card card-waves mb-4 mt-5">
                <div class="card-body p-5">
                    <div class="row align-items-center justify-content-between">
                        <div class="col">
                            <h2 class="text-primary">Selamat Datang Kembali!</h2>
                            <p class="text-gray-700">-.</p>
                            <a class="btn btn-primary p-3" href="#!">
                                Let's Go
                                <i class="ms-1" data-feather="arrow-right"></i>
                            </a>
                        </div>
                        <div class="col d-none d-lg-block mt-xxl-n4"><img class="img-fluid px-xl-4 mt-xxl-n5"
                                src="{{ URL::asset('assets/img/illustrations/statistics.svg') }}" /></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')

<script type="text/javascript">

            window.setInterval(function() {
                $('#clock').html(moment().format('dddd DD-MM-YYYY H:mm:ss'))
            }, 1000);
            </script>
@endsection
