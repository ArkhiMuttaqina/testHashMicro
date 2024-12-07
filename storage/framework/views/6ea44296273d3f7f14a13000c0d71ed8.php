<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="AppReimburs" />
    <meta name="author" content="ArkhiMS" />

    <link href="<?php echo e(URL::asset('css/styles.css')); ?>" rel="stylesheet" />
    <link
            href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/fc-5.0.0/r-3.0.0/sr-1.4.0/datatables.min.css"
            rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="<?php echo e(URL::asset('assets/img/favicon.png')); ?>">
    <?php echo $__env->yieldContent('head'); ?>

</head>

<body class="nav-fixed">
    <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
            <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
</script>
    </script>
    <script src="<?php echo e(URL::asset('js/scripts.js')); ?>"></script>
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
    <script src="<?php echo e(URL::asset('js/litepicker.js')); ?>"></script>

    <script>
        var apiURL = "";
    </script>
    <?php echo $__env->yieldContent('script'); ?>
</body>

</html>
<?php /**PATH E:\xampp\htdocs\Reimbursement SYSTEM\resources\views/layouts/app.blade.php ENDPATH**/ ?>