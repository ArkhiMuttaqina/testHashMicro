<?php if(auth()->user()->department_id == 1 || auth()->user()->department_id == 2): ?>
<?php endif; ?>
<?php $__env->startSection('reimbursements', 'active'); ?>
<?php $__env->startSection('reimbursements-0', 'show'); ?>
<?php $__env->startSection('reimbursements-0-semualist', 'active'); ?>
<?php $__env->startSection('head'); ?>
    <title>reimbursements - List</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="dollar-sign"></i></div>
                                Daftar Pengajuan Pengembalian Uang
                            </h1>
                            <div class="page-header-subtitle">Kelola pengembalian uang staf Anda. Edit reimbursementss dengan
                                praktis dan akurat.</div>
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
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Nominal</th>
                                        <th>Pembuat</th>
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
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Nominal</th>
                                    <th>Pembuat</th>
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
            </div>
        </div>


    </main>
    <div class="modal fade" id="lihatPengajuan" role="dialog">
        <div class="modal-lg modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Singkat Pengajuan</h5>
                    <button type="button" class="btn btn-sm btn-primary close"
                        onclick="$(function () { $('#lihatPengajuan').modal('toggle'); });" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input hidden disabled type="text" class="form-control" id="UID" name="UID">
                    <!--FORM edit anggta-->
                    <div class="row m-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input disabled type="text" class="form-control" id="nama_reimbursements"
                                    name="nama_reimbursements">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Nominal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-money-bill-1-wave"></i>
                                        </div>
                                    </div>

                                    <input disabled type="text" id="nominal_reimbursements" name="nominal_reimbursements"
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
                    <div class="mb-3">
                        <button onclick="unduh()" class="btn btn-sm btn-primary"><i class="fa-solid fa-download"></i>Unduh
                            File </button>
                        

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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function hapus(id, name) {
            var dataarray = new FormData();
            var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
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
                        url: "<?= url('reimbursements/delete') ?>",
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
            var name = $("#nama_reimbursements").val();
            var dataarray = new FormData();
            var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
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
                        url: "<?= url('reimbursements/rejected') ?>",
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

                                window.location.replace("<?= url('reimbursements') ?>");
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
                function unduh() {
            var id = $("#UID").val();


            Swal.fire({
                html: 'Unduh File ini ? ',
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
                    var uid = $("#UID").val();
                    var url = "<?= url('reimbursements/downloadFile/"+uid+"') ?>";
                  window.open(url, '_blank');
                } else if (result.isDenied) {
                    return false;
                }
            });
        }


        function approved() {
            var id = $("#UID").val();
            var name = $("#nama_reimbursements").val();
            var dataarray = new FormData();
            var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
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
                        url: "<?= url('reimbursements/approved') ?>",
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

                                window.location.replace("<?= url('reimbursements') ?>");
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
               url: "<?php echo url('reimbursements/apiByID/'); ?>/" + id,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                type: 'GET',
                success: function(data) {

                    if (data != null) {
                        console.log(data);
                        $("#UID").val(data.id);
                        $("#nama_reimbursements").val(data.name);
                        $("#nominal_reimbursements").val(data.nominal).change();
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

            ajax: '<?= url('/reimbursements/api/all?state=all') ?>',
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
                    data: 'name',
                    name: 'name'
                },

                {
                    data: 'desc',
                    name: 'desc'
                },
                {
                    data: 'nominal',
                    name: 'nominal'
                },
                {
                    data: 'creator',
                    name: 'creator'
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

            ajax: '<?= url('/reimbursements/api/all?state=update') ?>',
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
                    data: 'name',
                    name: 'name'
                },

                {
                    data: 'desc',
                    name: 'desc'
                },
                {
                    data: 'nominal',
                    name: 'nominal'
                },
                {
                    data: 'creator',
                    name: 'creator'
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Reimbursement SYSTEM\resources\views/reimbursements/all_special_access/index.blade.php ENDPATH**/ ?>