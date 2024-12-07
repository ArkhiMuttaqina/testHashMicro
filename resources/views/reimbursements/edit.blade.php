@extends('layouts.app')

@if (auth()->user()->department_id == 1 || auth()->user()->department_id == 2)

@endif
@section('reimbursements', 'active')
@section('reimbursements-0', 'show')
@section('reimbursements-0-pengajuansaya', 'active')
@section('head')
@if ($state == 'true')
<title>reimbursements</title>
@else
<title>reimbursements - Baru</title>
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
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            @if ($state == 'true')
                            Pengajuan {{$reimbursements->name}}
                            @else
                            Buat Pengajuan Baru
                            @endif

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
                    <div class="card-header">Detail pengajuan</div>
                    <div class="card-body">

                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="nama_pengajuan">Nama pengajuan </label>
                                    <input {{ $state == 'true' ? '' : '' }} class="form-control" id="nama_pengajuan" type="text"
                                        placeholder="Masukan Pengajuan" value="{{ $state == 'true' ? $reimbursements->name : '' }}" />
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="nominal">Nominal</label>
                                    <input {{ $state == 'true' ? '' : '' }} class="form-control" id="nominal" type="number" placeholder="Nominal"
                                        value="{{ $state == 'true' ? $reimbursements->nominal : '' }}" />
                                </div>
                            </div>
                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="desc">Deskripsi Pengajuan</label>
                                <input {{ $state == 'true' ? '' : '' }} class="form-control" id="desc" type="text" placeholder="Deskripsi Pengajuan"
                                    value="{{ $state == 'true' ? $reimbursements->desc : '' }}" />
                            </div>
@if ($reimbursements->files != null)
                            <div class="mb-3">
                                <label class="small mb-1">Lihat File Lama <a href="{{route('reimbursements_downloadFile', $reimbursements->id)}}">Link file</a></label>
                            </div>
                            @endif
                            <div class="mb-3">

                                <label class="small mb-1">Unggah Ulang File gambar / pdf</label>
                                <div class="col-6">
                                    <input type="file" class="reimdrop" id="unggah" nama="unggah" />
                                </div>
                            </div>


                            <div class="mb-3">
                            <button class="btn btn-primary" onclick="submit()" type="button">Simpan</button>
                            </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')

<script type="text/javascript">

        function inputRupiah(nameID) {
            var dengan_rupiah = document.getElementById(nameID);
            dengan_rupiah.addEventListener('keyup', function(e) {
                dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
            });

        }

        function formatRupiah(angka = 0, prefix) {

            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
        inputRupiah('nominal');

  function submit() {
            var nama_pengajuan = $("#nama_pengajuan").val();
            var nominal = $("#nominal").val();
            var desc = $("#desc").val();
            var CSRF_TOKEN ="{{ csrf_token() }}";
            var create = new FormData();
            if ($('#unggah')[0].files.length != 0) {
                var files1 = $('#unggah')[0].files;
                create.append('unggah', files1[0]);
                // console.log('unggah added');
            }else{
                create.append('unggah', null);
            }

            create.append('_token', CSRF_TOKEN);
            create.append('nama_pengajuan', nama_pengajuan);
            create.append('nominal', nominal);
            create.append('desc', desc);
            create.append('id', {{$reimbursements->id}});


            $.ajax({
                    url: "<?= url('reimbursements/update') ?>",
                    method: "post",
                    data: create,
                    contentType: false,
                    cache: true,
                    processData: false,
                    type: 'post',
                    enctype: 'multipart/form-data',
                    success: function(data) {
                        console.log(data);

                    if(data.isSuccess == 'yes'){
                        Swal.fire({
                            title: "data tersimpan",
                            html: '<b>Halaman akan kembali ke menu utama</b>',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            })

                            window.location.replace( "<?= url('reimbursements') ?>");
                    console.log('masuk')
                    }else if(data.isSuccess == 'no'){

                        Swal.fire({
                            title: "Error",
                            html: '<b>'+data.msg+'</b>',
                            icon: 'danger',
                            confirmButtonText: 'OK'
                            })
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });


        }
</script>
@endsection
