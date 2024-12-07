<?php if(auth()->user()->department_id == 1 || auth()->user()->department_id == 2): ?>
<?php endif; ?>
<?php $__env->startSection('charmatch', 'active'); ?>
<?php $__env->startSection('charmatch-0', 'show'); ?>
<?php $__env->startSection('charmatch-0-ajax', 'active'); ?>
<?php $__env->startSection('head'); ?>
<title>Char Persentage Match</title>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<main>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-5">

        <div class="card card-waves mb-4 mt-5">
            <div class="card-body p-5">
                <div class="row align-items-center justify-content-between">
                    <h1 style="font-display: bold"> Char Persentage Match </h1>
                    <div class="row">

                        <div class="col">
                        <div class="col">

                            <div class="form-group">
                                <label for="input1">Input 1:</label>
                                <input type="text" class="form-control" id="input1" name="input1">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="input2">Input 2:</label>
                                <input type="text" class="form-control" id="input2" name="input2">
                            </div>
                            <br>
                            <button class="btn btn-primary" onclick="calculateNow()" type="submit">Check</button>
                    </div>


                    <h3 style="margin-top:10px;" >Result: </h3>
                    <h4 style="font-display: bold" id="result"> </h4>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script>
    $(document).ready(function () {

     });
            function calculateNow() {

                const input1 = $('#input1').val();
                const input2 = $('#input2').val();


                var dataarray = new FormData();
                var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
                dataarray.append('input1', input1);
                dataarray.append('input2', input2);
                dataarray.append('_token', CSRF_TOKEN);

                $.ajax({
                    url: '/charmatch/ajax',
                    method: "POST",
                    data: dataarray,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    type: 'post',
                    beforeSend: function() {
                             Swal.fire({
                                 title: "Processsing..",
                                 html: "Count the cbar"
                             })
                             Swal.showLoading();
                         },
                    success: function (response) {
                        Swal.hideLoading();
                        swal.close()
                        $('#result').html(
                            `<p>Percentage Match: ${response.percentage}%</p>
                            <p>Matched Characters: ${response.matched_characters}</p>
                            <p>Total Unique Characters in Input 1: ${response.total_characters}</p>`
                        );
                    },
                    error: function (xhr) {
                         Swal.fire({
                                        html: "<h4>"+xhr.responseJSON.message+"</h4>",
                                        icon: 'warning',
                                        showCancelButton: false,
                                        showConfirmButton: false
                                    });
                    }
                });
            }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Reimbursement SYSTEM\resources\views/charPersentage/index.blade.php ENDPATH**/ ?>