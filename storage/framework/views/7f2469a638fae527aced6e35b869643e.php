<?php if(auth()->user()->department_id == 1 || auth()->user()->department_id == 2): ?>

<?php endif; ?>
<?php $__env->startSection('reimbursements', 'active'); ?>
<?php $__env->startSection('reimbursements-0', 'show'); ?>
<?php $__env->startSection('reimbursements-0-pengajuansaya', 'active'); ?>
<?php $__env->startSection('head'); ?>
<?php if($state == 'true'): ?>
<title>reimbursements</title>
<?php else: ?>
<title>reimbursements - Baru</title>
<?php endif; ?>


<link rel="stylesheet" href="<?php echo e(asset('css/filepond.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/reimdrop.css')); ?>">
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
                            <?php if($state == 'true'): ?>
                            Pengajuan <?php echo e($reimbursements->name); ?>

                            <?php else: ?>
                            Buat Pengajuan Baru
                            <?php endif; ?>

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

                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="nama_pengajuan">Nama pengajuan </label>
                                    <input <?php echo e($state == 'true' ? 'disabled' : ''); ?> class="form-control" id="nama_pengajuan" type="text"
                                        placeholder="Masukan Pengajuan" value="<?php echo e($state == 'true' ? $reimbursements->name : ''); ?>" />

                                        <input <?php echo e($state == 'true' ? 'disabled' : ''); ?> class="form-control" id="id" type="hidden"
                                         value="<?php echo e($state == 'true' ? $reimbursements->id : ''); ?>" />
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="nominal">Nominal</label>
                                    <input <?php echo e($state == 'true' ? 'disabled' : ''); ?> class="form-control" id="nominal" type="number" placeholder="Nominal"
                                        value="<?php echo e($state == 'true' ? $reimbursements->nominal : ''); ?>" />
                                </div>
                            </div>
                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="desc">Deskripsi Pengajuan</label>
                                <input <?php echo e($state == 'true' ? 'disabled' : ''); ?> class="form-control" id="desc" type="text" placeholder="Deskripsi Pengajuan"
                                    value="<?php echo e($state == 'true' ? $reimbursements->desc : ''); ?>" />
                            </div>
                            <!-- Form Group (Group Selection Checkboxes)-->
                            <div class="mb-3">
                                <button onclick="unduh()" class="btn btn-sm btn-primary"><i class="fa-solid fa-download"></i>Unduh File </button>
                                

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('js/filepond.js')); ?>"></script>
<script type="text/javascript">
                   function unduh() {

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
                    var uid = $("#id").val();
                    var url = "<?= url('reimbursements/downloadFile/"+uid+"') ?>";
                  window.open(url, '_blank');
                } else if (result.isDenied) {
                    return false;
                }
            });
        }


</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Reimbursement SYSTEM\resources\views/reimbursements/show.blade.php ENDPATH**/ ?>