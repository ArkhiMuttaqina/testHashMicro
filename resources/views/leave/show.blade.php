@extends('layouts.app')

@if (auth()->user()->department_id == 1 || auth()->user()->department_id == 2)

@endif
@section('leave', 'active')
@section('leave-0', 'show')
@section('leave-0-pengajuansaya', 'active')
@section('head')
@if ($state == 'true')
<title>leave</title>
@else
<title>leave - Baru</title>
@endif

{{--
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="{{ asset('css/filepond.css') }}">
<link rel="stylesheet" href="{{asset('css/reimdrop.css')}}">
@endsection
@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            @php
                            $general = new \App\Helpers\generalHelpers();
                            $var = $general->dMY_converter($data->start_date) . ' - ' . $general->dMY_converter($data->end_date);
                            $year = (int) date("Y");
                            @endphp
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Pengajuan cuti {{$data->name}} | Tahun {{$year}}
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" onclick="history.back();">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">Detail pengajuan cuti </div>
                    <div class="card-body">

                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">

                                <div class="col-md-6">
                                    <label class="small mb-1" for="desc"> Deskripsi</label>
                                    <input disabled class="form-control" id="nama_pengajuan" type="text"
                                        placeholder="Masukan Pengajuan" value="{{$data?->desc? : '-'}}" />
                                </div>


                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-4">
                                <label class="small mb-1" for="tanggal">Tanggal</label>
                                <input disabled class="form-control" id="tanggal" type="text" placeholder="Tanggal" value="{{$var}}" />
                            </div>

                            <div class="col-md-4">
                                <label class="small mb-1" for="tanggal">Jumlah Hari</label>
                                <input disabled class="form-control" id="tanggal" type="text" placeholder="Tanggal" value="{{$data->count_day? : '-'}}" />
                            </div>

                            @if($data?->status != 'diajukan')

                            <div class="col-md-4">
                                <label class="small mb-1" for="desc"> {{$data?->status}} oleh</label>
                                <input disabled class="form-control" id="nama_pengajuan" type="text" placeholder="Masukan Pengajuan"
                                    value="{{$data?->approver?->name? : ''. ' - '. $data?->approver?->SetDepartment?->name? : ''}}" />
                            </div>
                            @endif
                        </div>

                        <!-- Form Group (email address)-->
                        <a hidden id="dateNowToday_txt">{dateToday_txt}</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')
<script src="{{ URL::asset('js/filepond.js') }}"></script>
<script type="text/javascript">

</script>
@endsection
