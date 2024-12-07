@extends('layouts.app')

@if (auth()->user()->department_id == 1 || auth()->user()->department_id == 2)
@endif
@section('leave', 'active')
@section('leave-0', 'show')
@section('leave-0-semualist', 'active')
@section('head')
<title>Permit for Leave - List</title>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
@endsection
@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="file-text"></i></div>
                            Daftar Pengajuan izin cuti
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills" id="cardPill" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="semua-pill" href="#semuaPill"
                            data-bs-toggle="tab" role="tab" aria-controls="semua" aria-selected="true">All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" id="needAction-pill" href="#needActionPill"
                            data-bs-toggle="tab" role="tab" aria-controls="needAction" aria-selected="false">Need
                            Action</a></li>

                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardPillContent">
                    <div class="tab-pane fade show active" id="semuaPill" role="tabpanel" aria-labelledby="semua-pill">

                        <table id="datatablesALL" class="table compact table-responsive ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Tgl cuti</th>
                                    <th>Total hari</th>
                                    <th>Disetujui</th>
                                    <th>status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="needActionPill" role="tabpanel" aria-labelledby="needAction-pill">
                    <table id="datatablesneedAction" class="table compact">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Tgl cuti</th>
                                <th>Total hari</th>
                                <th>Disetujui</th>
                                <th>status</th>
                                <th>Aksi</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</main>
<div class="modal fade" id="lihatPengajuan" role="dialog">
    <div class="modal-lg modal-dialog">
        <div class="modal-content">
            @php

            $year = (int) date("Y");
            @endphp
            <div class="modal-header">
                <h5 class="modal-title">Detail Singkat Pengajuan tahun {{$year}}</h5>
                <button type="button" class="btn btn-sm btn-primary close"
                    onclick="$(function () { $('#lihatPengajuan').modal('toggle'); });" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input hidden disabled type="hidden" class="form-control" id="UID" name="UID">
                <!--FORM edit anggta-->
                <div class="row m-3">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input disabled type="text" class="form-control" id="nama_leave" name="nama_leave">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">Cuti</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-money-bill-1-wave"></i>
                                    </div>
                                </div>

                                <input disabled type="text" id="current_quota" name="current_quota"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Deskripsi Pengajuan</label>
                            <input disabled type="text" class="form-control" name="desc" id="desc">
                        </div>
                    </div>

                </div>

                <div class="row m-3">
                    <div class="col">

                        <button type="submit" id="btn_tambahanggota" name="btn_tambahanggota" onclick="approved()"
                            class="btn btn-primary">Setujui Pengajuan</button>
                        <button type="submit" id="btn_tambahanggota" name="btn_tambahanggota" onclick="rejected()"
                            class="btn btn-danger">Tolak Pengajuan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    function hapus(id, name) {
            var dataarray = new FormData();
            var CSRF_TOKEN = "{{ csrf_token() }}";
            dataarray.append('id', id);
            dataarray.append('name', name);
            dataarray.append('state', 'delete');
            dataarray.append('_token', CSRF_TOKEN);
            Swal.fire({
                html: 'Hapus Pengajuan ini ? ',
                icon: 'question',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                customClass: {
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= url('leave/delete') ?>",
                        method: "POST",
                        data: create,
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        type: 'post',
                        success: function(data) {

                            if (data != null) {

                            } else {
                                Swal.fire({
                                    html: "<h4>Kesalahan</h4>",
                                    icon: 'warning',
                                    showCancelButton: false, // There won't be any cancel button
                                    showConfirmButton: false // There won't be any confirm button
                                });
                                // setTimeout(location.reload.bind(location), 1500);
                            }

                        }
                    });
                } else if (result.isDenied) {
                    return false;
                }
            });
        }

        function rejected() {
            var id = $("#UID").val();
            var name = $("#nama_leave").val();
            var dataarray = new FormData();
            var CSRF_TOKEN = "{{ csrf_token() }}";
            dataarray.append('id', id);
            dataarray.append('name', name);
            dataarray.append('state', 'approval');
            dataarray.append('_token', CSRF_TOKEN);
            Swal.fire({
                html: 'Batalkan pengajuan ' + name + ' ini ? ',
                icon: 'question',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                customClass: {
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= url('leave/rejected') ?>",
                        method: "POST",
                        data: dataarray,
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        type: 'post',
                        success: function(data) {

                            if (data.isSuccess == 'yes') {
                                Swal.fire({
                                    title: "Pengajuan dibatalkan",
                                    html: '<b>Halaman akan kembali ke menu utama</b>',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                })

                                window.location.replace("<?= url('leave') ?>");
                                console.log('masuk')
                            } else {
                                Swal.fire({
                                    html: "<h4>Kesalahan</h4>",
                                    icon: 'warning',
                                    showCancelButton: false, // There won't be any cancel button
                                    showConfirmButton: false // There won't be any confirm button
                                });
                                // setTimeout(location.reload.bind(location), 1500);
                            }

                        }
                    });
                } else if (result.isDenied) {
                    return false;
                }
            });
        }



        function approved() {
            var id = $("#UID").val();
            var name = $("#nama_leave").val();
            var dataarray = new FormData();
            var CSRF_TOKEN = "{{ csrf_token() }}";
            dataarray.append('id', id);
            dataarray.append('name', name);
            dataarray.append('state', 'approval');
            dataarray.append('_token', CSRF_TOKEN);
            Swal.fire({
                html: 'Ajukan pengajuan ' + name + ' ini ? ',
                icon: 'question',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                customClass: {
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= url('leave/approved') ?>",
                        method: "POST",
                        data: dataarray,
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        type: 'post',
                        success: function(data) {

                            if (data.isSuccess == 'yes') {
                                Swal.fire({
                                    title: "Data berhasil diajukan",
                                    html: '<b>Halaman akan kembali ke menu utama</b>',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                })

                                window.location.replace("<?= url('leave') ?>");
                                console.log('masuk')
                            } else {
                                Swal.fire({
                                    html: "<h4>Kesalahan</h4>",
                                    icon: 'warning',
                                    showCancelButton: false, // There won't be any cancel button
                                    showConfirmButton: false // There won't be any confirm button
                                });
                                // setTimeout(location.reload.bind(location), 1500);
                            }

                        }
                    });
                } else if (result.isDenied) {
                    return false;
                }
            });
        }


        function showDetail(id) {
            var dataarray = new FormData();
            $.ajax({
                url: "<?php echo url('leave/api'); ?>?id=" + id,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                type: 'GET',
                success: function(data) {

                    if (data != null) {
                        console.log(data);
                        $("#UID").val(data.id);
                        $("#nama_leave").val(data.name);
                        $("#desc_leave").val(data.desc);
                        $("#current_quota").val(data.count_day + ' Hari').change();
                        $("#desc").val(data.desc).change();
                        $("#lihatPengajuan").modal('show');
                    } else {
                        Swal.fire({
                            html: "<h4>Kesalahan</h4>",
                            icon: 'warning',
                            showCancelButton: false, // There won't be any cancel button
                            showConfirmButton: false // There won't be any confirm button
                        });
                        // setTimeout(location.reload.bind(location), 1500);
                    }

                }
            });


        }



        $('#datatablesALL').DataTable({
            lengthMenu: [30, 60, 80, 120],
            fixedHeader: {
                header: true
            },
            processing: true,
            serverSide: true,
            ajax: '<?= url('/leave/api/all?state=all') ?>',
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                 {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'creator',
                    name: 'creator'
                },

                {
                    data: 'desc',
                    name: 'desc'
                },
                {
                    data: 'dateLeave',
                    name: 'dateLeave'
                },{
                    data: 'totalDay',
                    name: 'totalDay'
                },
                {
                    data: 'approver',
                    name: 'approver'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                }
            ]
        });

        $('#datatablesneedAction').DataTable({
            lengthMenu: [30, 60, 80, 120],
            fixedHeader: {
                header: true
            },

            serverSide: true,

            ajax: '<?= url('/leave/api/all?state=update') ?>',
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'creator',
                    name: 'creator'
                },

                {
                    data: 'desc',
                    name: 'desc'
                },
                {
                    data: 'dateLeave',
                    name: 'dateLeave'
                },{
                    data: 'totalDay',
                    name: 'totalDay'
                },
                {
                    data: 'approver',
                    name: 'approver'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                }
            ]
        });
</script>
@endsection
