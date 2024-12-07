<?php if(auth()->user()->department_id == 1 || auth()->user()->department_id == 2): ?>

<?php endif; ?>
<?php $__env->startSection('leave', 'active'); ?>
<?php $__env->startSection('leave-0', 'show'); ?>
<?php $__env->startSection('leave-0-pengajuansaya', 'active'); ?>
<?php $__env->startSection('head'); ?>
<title>leave - Baru</title>

<link rel="stylesheet" href="<?php echo e(asset('css/filepond.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/reimdrop.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/stylesDateRangePick.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Buat Pengajuan Baru
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

<?php if($data['currentDoc'] != NULL): ?>
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-12">
                <div class="alert alert-danger" role="alert">
                    kamu masih memiliki pengajuan yang belum di setujui oleh HR & GA. 
                </div>

            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-12">
                <?php if($data['current_quota_leave'] == 0): ?>
                <?php if($data['masa_kerja'] == 0): ?>
                <div class="alert alert-danger" role="alert">
                    Masa kerja mu masih kurang dari 6 bulan, jadi kamu belum memiliki kuota cuti, hubungi HR & GA.
                </div>
                <?php else: ?>

                <div class="alert alert-danger" role="alert">
                    untuk tahun ini kamu tidak memiliki kuota cuti, hubungi HR & GA.
                </div>
                <?php endif; ?>

                <?php else: ?>
                <div class="alert alert-primary" role="alert">
                    Sisa kuota cuti kamu adalah <b><?php echo e($data['current_quota_leave']); ?> Hari</b>, Pergunakan dengan bijak!
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <?php if($data['current_quota_leave'] != 0): ?>

    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">Detail pengajuan</div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="small mb-1" for="desc">Deskripsi</label>
                            <input class="form-control" id="desc" type="text" placeholder="Deskripsi Pengajuan"
                                value="" />
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <label class="small mb-1" for="desc">Tanggal Cuti</label>
                            <div class="input-group flex-grow-1">
                                <div class="input-group-text fw-semibold bg-white">Pilih tanggal</div>
                                <input type="text" class="form-control icon-date" id="datePick"
                                    placeholder="Choose date">
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <a hidden id="dateNowToday_txt">{dateToday_txt}</a>
                        <div class="mb-3">
                            <button class="btn btn-primary" onclick="submit()" type="button">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

</main>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/locale/id.min.js"
    integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<?php if($data['current_quota_leave'] != 0): ?>

<script type="text/javascript">
    function getCurrentYear() {
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    return currentYear;
    }

var formattedDate = '';
    $(document).ready(function() {
        var datePick = $("#datePick").val();
        var daterangeDate = new Date(document.getElementById('datePick').value);
        var now = new Date();
        console.log(formattedDate);
        $("#dateNowToday_txt").text('(' + formattedDate + ')').change();
        })
        var spanDays = <?php echo $data['current_quota_leave'] ?>

        $('#datePick').daterangepicker({
        "maxYear": getCurrentYear(),
        "singleDatePicker": false,
        "minDate": new Date(),
        "showDropdowns": true,
        "ranges": {
        'Hari Ini': [moment(), moment()]
        },
        "maxSpan": {
        "days": spanDays
        },
        "locale": {
        "format": "DD MMMM YYYY",
        "separator": " - ",
        "applyLabel": "Oke",
        "cancelLabel": "Batal",
        "fromLabel": "Dari",
        "toLabel": "ke",
        "customRangeLabel": "Kustom",
        "weekLabel": "Mg",
        "daysOfWeek": [
        "Ming",
        "Sen",
        "Sel",
        "Rab",
        "Kam",
        "Jum",
        "Sab"
        ],
        "monthNames": [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
        ],
        "firstDay": 1
        },
        "alwaysShowCalendars": true,
        "applyButtonClasses": "btn btn-lg btn-primary wv",
        "cancelClass": "btn btn-lg btn-dark wv"
        }, function(start, end, label) {
        $('#txt-daterange').text(label).change();

        enddate = start.format('MM/DD/YYYY');
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
        'YYYY-MM-DD') + ' (predefined range: ' + label + ')');

        var Sdate = start.format('YYYY-MM-DD');
        var tanggalArray = Sdate.split('-');
        var tahun = tanggalArray[0];
        var bulanIndex = parseInt(tanggalArray[1]) - 1;
        var hari = tanggalArray[2];
        var namaBulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        var namaHari = [
        "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
        ];

        var bulan = namaBulan[bulanIndex];
        var tanggalObj = new Date(tahun, bulanIndex, hari);
        var hariIndex = tanggalObj.getDay();
        var hariNama = namaHari[hariIndex];

        var formattedDate = hariNama + ", " + hari + " " + bulan + " " + tahun;


        });

       function submit() {
            var desc = $("#desc").val();
            var datePick = $("#datePick").val();
            var dates = datePick.split(' - ');
            var startDate = dates[0];
            var endDate = dates[1];
            var CSRF_TOKEN ="<?php echo e(csrf_token()); ?>";

            var create = new FormData();
            create.append('_token', CSRF_TOKEN);
            create.append('startDate', startDate);
            create.append('endDate', endDate);
            create.append('desc', desc);


            $.ajax({
                    url: "<?= url('leave/store') ?>",
                    method: "post",
                    data: create,
                    contentType: false,
                    cache: true,
                    processData: false,
                    type: 'post',
                    success: function(data) {
                        console.log(data);

                    if(data.isSuccess == 'yes'){
                        Swal.fire({
                            title: "data tersimpan",
                            html: '<b>Halaman akan kembali ke menu utama</b>',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            })

                            window.location.replace( "<?= url('leave') ?>");
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
<?php endif; ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Reimbursement SYSTEM\resources\views/leave/create.blade.php ENDPATH**/ ?>