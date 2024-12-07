<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">

            <div class="sidenav-menu-heading d-sm-none">Account</div>
            <!-- Sidenav Link (Alerts)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                Alerts
                <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
            </a>
            <!-- Sidenav Link (Messages)-->
            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
            <a class="nav-link d-sm-none" href="#!">
                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                Messages
                <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
            </a>
            <?php if(auth()->user()->department_id == 2): ?>
            <div class="sidenav-menu-heading">Core</div>
            <a class="nav-link collapsed <?php echo $__env->yieldContent('master'); ?>" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#Core" aria-expanded="false" aria-controls="Core">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Master
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php echo $__env->yieldContent('master-0'); ?>" id="Core" data-bs-parent="#Core">
                <nav class="sidenav-menu-nested nav accordion " id="accordionSidenavPages">
                    <a class="nav-link <?php echo $__env->yieldContent('master-0-karyawan'); ?>" href="<?php echo e(route('employee')); ?>">
                        Karyawan
                        
                    </a>

                    <a class="nav-link <?php echo $__env->yieldContent('master-0-hirarchyDepartement'); ?>" href="<?php echo e(url('/departments/hierarchy')); ?>">
                       Hirarki Departement
                        
                    </a>

                </nav>
            </div>
            <?php endif; ?>
            <!-- Sidenav Heading (Custom)-->
            <div class="sidenav-menu-heading">Apps</div>
            <!-- Sidenav Accordion (Pages)-->
            <a class="nav-link collapsed <?php echo $__env->yieldContent('reimbursements'); ?>" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#Apps" aria-expanded="false" aria-controls="Apps">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Reimbursements
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php echo $__env->yieldContent('reimbursements-0'); ?>" id="Apps" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <a class="nav-link <?php echo $__env->yieldContent('reimbursements-0-pengajuansaya'); ?>"
                        href="<?php echo e(url('/reimbursements?me='.auth()->user()->id)); ?>">
                        Pengajuan Saya
                        
                    </a>
                    <?php if(auth()->user()->department_id == 2 || auth()->user()->department_id == 2): ?>
                    <a class="nav-link <?php echo $__env->yieldContent('reimbursements-0-semualist'); ?>"
                        href="<?php echo e(url('/reimbursements/all?role='.auth()->user()->department_id)); ?>">Semua List</a>
                    <?php endif; ?>

                </nav>
            </div>

            <a class="nav-link collapsed <?php echo $__env->yieldContent('leave'); ?>" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#Apps" aria-expanded="false" aria-controls="Apps">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Izin
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php echo $__env->yieldContent('leave-0'); ?>" id="Apps" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <a class="nav-link <?php echo $__env->yieldContent('leave-0-pengajuansaya'); ?>"
                        href="<?php echo e(url('/leave?me='.auth()->user()->id)); ?>">
                        Pengajuan Saya
                        
                    </a>
                    <?php if(auth()->user()->department_id == 2 || auth()->user()->department_id == 2): ?>
                    <a class="nav-link <?php echo $__env->yieldContent('leave-0-semualist'); ?>"
                        href="<?php echo e(url('/leave/all?role='.auth()->user()->department_id)); ?>">Semua List</a>
                    <?php endif; ?>

                </nav>
            </div>
            <a class="nav-link collapsed <?php echo $__env->yieldContent('charmatch'); ?>" href="javascript:void(0);" data-bs-toggle="collapse"
                data-bs-target="#Apps" aria-expanded="false" aria-controls="Apps">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                CharPersetage Match
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php echo $__env->yieldContent('charmatch-0'); ?>" id="Apps" data-bs-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <a class="nav-link <?php echo $__env->yieldContent('charmatch-0-ajax'); ?>"
                        href="<?php echo e(url('/charmatch/ajax')); ?>">
                        home
                        
                    </a>


                </nav>
            </div>


        </div>
    </div>
    <!-- Sidenav Footer-->
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title"><?php echo e(auth()->user()->name); ?></div>
        </div>
    </div>
</nav>
<?php /**PATH E:\xampp\htdocs\Reimbursement SYSTEM\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>