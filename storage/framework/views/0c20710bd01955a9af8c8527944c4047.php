<?php if(auth()->user()->department_id == 1 || auth()->user()->department_id == 2): ?>
<?php endif; ?>
<?php $__env->startSection('charmatch', 'active'); ?>
<?php $__env->startSection('charmatch-0', 'show'); ?>
<?php $__env->startSection('charmatch-0-ajax', 'active'); ?>
<?php $__env->startSection('head'); ?>
<title>Department Hierarchy</title>
<style>
    ul {
        list-style-type: circle;
    }

    li {
        margin: 5px 0;
    }

    .department {
        font-weight: bold;
        color: var(--bs-blue);
    }

    .job-titles-user {
        margin-left: 20px;
        color: var(--bs-indigo);
    }

    .user-list {
        margin-left: 40px;
        color: var(--bs-dark);
    }



</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-5">

        <div class="card mb-4 mt-5">
            <div class="card-body p-5">
                <div class="row align-items-center justify-content-center">
                    <h1 style="font-display: bold"> Department Hierarchy </h1>
                    <div class="row">

                        
                        <div class="tree">
                            <ul>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="department">
                                    <h1 class="badge bg-primary"><?php echo e($department['department_name']); ?></h1>
                                    <ul>
                                        <?php $__currentLoopData = $department['job_Title']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job_Title_set_users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="job-titles-user">
                                            <h4 class="badge bg-secondary position-relative"><?php echo e($job_Title_set_users['name']); ?> <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    <?php echo e($job_Title_set_users['user_count']); ?>

                                                    <b class="visually-hidden">(<?php echo e($job_Title_set_users['user_count']); ?>

                                                        )</b>
                                                </span></h4>


                                            <ul class="user-list">
                                                <?php $__currentLoopData = $job_Title_set_users['users']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li style="font-size: 11px"><?php echo e($user); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script>

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Reimbursement SYSTEM\resources\views/department/hierarchy/index.blade.php ENDPATH**/ ?>