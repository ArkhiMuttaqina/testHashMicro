<?php $__env->startSection('master', 'active'); ?>
<?php $__env->startSection('master-0', 'show'); ?>
<?php $__env->startSection('master-0-karyawan', 'active'); ?>
<?php $__env->startSection('head'); ?>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="filter"></i></div>
                            Daftar Karyawan
                        </h1>
                        <div class="page-header-subtitle">Kendalikan daftar karyawan Anda. Edit dan kelola informasi
                            karyawan secara efisien</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            
            <div class="text-right p-4">
                <a class="btn btn-primary lift lift-sm" onclick="modal_tambah()">Tambah Baru</a>

            </div>

            <div class="card-body">
                <table autocomplete="false" id="data_user" class="table compact table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jatah Cuti</th>
                            <th>Masa Kerja</th>
                            <th>Department</th>
                            <th>JobTitle</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>


<div class="modal fade" id="modal_ubah" role="dialog">
    <div class="modal-lg modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data Pengguna</h5>
                <button type="button" class="btn btn-sm btn-primary close" onclick="$(function () {
                                               $('#modal_ubah').modal('toggle');
                                            });" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="ubah_id" name="ubah_id">
                <!--FORM edit anggta-->
                <div class="row m-3">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" id="ubah_nama" name="ubah_nama">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">email</label>
                            <div class="input-group">
                                <input class="form-control " type="text" id="ubah_email" name="ubah_email">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="ubah_tanggal_lahir" name="ubah_tanggal_lahir"
                                placeholder="dd-mm-yyyy" value="" min="1960-01-01" max="2030-12-31">
                        </div>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-sm">
                        <label for="ubah_birth_place">Tempat Lahir</label>
                        <div class="form-group d-flex">
                            <select class="form-select select2 d-flex" id="ubah_birth_place" style="width: 100%;"
                                required>
                                <option value="" selected> Pilih Kota</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Departments</label>

                            <select class=" form-select" id="ubah_departments" onchange="selectJobs( 'modal_ubah')"
                                required>
                                <option value="" selected> Pilih Department</option>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->id); ?>">
                                    <?php echo e($value->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Job Title</label>
                            <input hidden type="text" class="form-control" id="old_ubah_job_tittle"
                                name="old_ubah_job_tittle">
                            <select class=" form-select" id="ubah_job_tittle" required>
                                <option value="" selected> Pilih Title</option>
                                
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row m-3">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Nomor Karyawan</label>
                            <input disabled type="number" class="form-control"
                                onkeydown="if(this.value.length==10 && event.keyCode!=8) return false;"
                                name="ubah_employee_number" id="ubah_employee_number">

                        </div>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Jenis Kelamin</label>
                            <select class=" form-select" id="ubah_sex" required>
                                <option value="" selected> Pilih Jenis Kelamin</option>
                                <option value="M">Laki Laki</option>
                                <option value="F">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Status Karyawan</label>
                            <select class=" form-select" id="ubah_status_employee" required>
                                <option value="" selected> Pilih Status</option>
                                <option value="Tetap">Tetap</option>
                                <option value="Kontrak">Kontrak</option>
                                <option value="Magang">Magang</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Tanggal Bergabung</label>
                            <input type="date" class="form-control" id="ubah_tanggal_gabung" name="ubah_tanggal_gabung"
                                placeholder="dd-mm-yyyy" value="" min="1960-01-01" max="2030-12-31">
                        </div>
                    </div>
                </div>

                <div class="row m-3">
                    <div style="display: flex;" id="ubahpwisnotequal" class="alert alert-danger align-items-center p-2"
                        role="alert">
                        <div>
                            Password anda tidak sesuai.
                        </div>
                    </div>
                    <div style="display: flex;" id="ubahpwisequal" class="alert alert-success align-items-center p-2"
                        role="alert">
                        <div>
                            password anda sudah sesuai.
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            <input type="password" class="form-control" name="ubah_password" id="ubah_password">
                            <div style="margin-top: 7px;" class="d-flex g-2" id="CheckPasswordMatch">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <p>Harap password harus sama dengan konfirmasi password</p>
                            </div>
                        </div>
                    </div>
                    <span id='message'></span>
                    <div class="col">
                        <div class="form-group">
                            <label for="">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="ubah_confirm_password"
                                id="ubah_confirm_password" ">
                                                                                    <div style=" margin-top: 7px;"
                                id="CheckPasswordMatch">
                            <div class=" custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                    id="show_pw" onclick="funct_show_password()">
                                <label class="custom-control-label" for="show_pw">Tampilkan Password</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-3">
                <div class="col">
                    <button onclick="ubah()" type="submit" id="editdata" name="editdata" class="btn btn-primary">Simpan
                        Data</button>

                </div>
            </div>
        </div>
    </div>
</div>
</div>



<div class="modal fade" id="modal_tambah" role="dialog">
    <div class="modal-lg modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna</h5>
                <button type="button" class="btn btn-sm btn-primary close"
                    onclick="$(function () { $('#modal_tambah').modal('toggle'); });" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="">
                    <!--FORM edit anggta-->
                    <div class="row m-3">
                        <div class="col" -sm>
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" id="input_nama" name="input_nama">
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                    </div>

                                    <input class="form-control " type="text" id="input_Email" name="input_Email">
                                </div>
                            </div>
                        </div>


                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="input_tanggal_lahir"
                                    name="input_tanggal_lahir" placeholder="dd-mm-yyyy" value="" min="1960-01-01"
                                    max="2030-12-31">
                            </div>
                        </div>
                    </div>

                    <div class="row m-3">
                        <div class="col-sm">
                            <label for="input_birth_place">Tempat Lahir</label>
                            <div class="form-group d-flex">
                                <select class="form-select select2 d-flex" id="input_birth_place" style="width: 100%;"
                                    required>
                                    <option value="" selected> Pilih Kota</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Departments</label>
                                <select class=" form-select" id="input_departments"
                                    onchange="selectJobs( 'modal_tambah')" required>
                                    <option value="" selected> Pilih Department</option>
                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value->id); ?>">
                                        <?php echo e($value->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Job Title</label>
                                <select class=" form-select" id="input_title" required>
                                    <option value="" selected> Pilih Title</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Jenis Kelamin</label>
                                <select class=" form-select" id="input_sex" required>
                                    <option value="" selected> Pilih Jenis Kelamin</option>
                                    <option value="M"> Laki Laki</option>
                                    <option value="F"> Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Status Karyawan</label>
                                <select class=" form-select" id="input_status_employee" required>
                                    <option value="" selected> Pilih Status</option>
                                    <option value="Tetap"> Tetap</option>
                                    <option value="Kontrak"> Kontrak</option>
                                    <option value="Magang"> Magang</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="">Tanggal Bergabung</label>
                                <input type="date" class="form-control" id="input_tanggal_gabung"
                                    name="input_tanggal_gabung" placeholder="dd-mm-yyyy" value="" min="1960-01-01"
                                    max="2030-12-31">
                            </div>
                        </div>
                    </div>

                    <div class="row m-3">
                        <div style="display: flex;" id="inputpwisnotequal"
                            class="alert alert-danger align-items-center p-2" role="alert">
                            <div>
                                Password anda tidak sesuai.
                            </div>
                        </div>
                        <div style="display: flex;" id="inputpwisequal"
                            class="alert alert-success align-items-center p-2" role="alert">
                            <div>
                                password anda sudah sesuai.
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control" name="password_input" id="password_input">
                                <div style="margin-top: 7px;" class="d-flex g-2" id="CheckPasswordMatch">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <p>Harap password harus sama dengan konfirmasi password</p>
                                </div>
                            </div>
                        </div>
                        <span id='message'></span>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="confirm_password_input"
                                    id="confirm_password_input" ">
                                                                                    <div style=" margin-top: 7px;"
                                    id="CheckPasswordMatch">
                                <div class=" custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                        id="show_pw" onclick="funct_show_password_new()">
                                    <label class="custom-control-label" for="show_pw">Tampilkan Password</label>
                                </div>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
            <div class="row m-3">
                <div class="col">
                    <button type="submit" id="btn_modal_tambah" name="btn_modal_tambah" onclick="addNewData()"
                        class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {


        $('#input_birth_place').select2({
        placeholder: 'Pilih Kota',
        allowClear: true,
        ajax: {
          url: '/api/v1/master/cities',
          dataType: 'json',
          delay: 250,
          data: function (params) {
                  return {
                    search: params.term || '',
                    page: params.page || 1,
                    limit: 10
                  };
                },
                processResults: function (data, params) {
                  params.page = params.page || 1;
                  return {
                    results: data.data.map(function (city) {
                      return {
                        id: city.id,
                        text: city.name
                      };
                    }),
                    pagination: {
                      more: params.page < data.pagination.last_page
                    }
                  };
                },
                cache: true
              },
              dropdownParent: $('#modal_tambah')
            });


            $('#ubah_birth_place').select2({
        placeholder: 'Pilih Kota',
        allowClear: true,
        ajax: {
          url: '/api/v1/master/cities',
          dataType: 'json',
          delay: 250,
          data: function (params) {
                  return {
                    search: params.term || '',
                    page: params.page || 1,
                    limit: 10
                  };
                },
                processResults: function (data, params) {
                  params.page = params.page || 1;
                  return {
                    results: data.data.map(function (city) {
                      return {
                        id: city.id,
                        text: city.name
                      };
                    }),
                    pagination: {
                      more: params.page < data.pagination.last_page
                    }
                  };
                },
                cache: true
              },
              dropdownParent: $('#modal_ubah')
            });
    });


    function hideElement(elementId) {
            var element = document.getElementById(elementId);
            if (element) {
                element.style.display = 'none';
            }
        }

        function unhideElement(elementId) {
            var element = document.getElementById(elementId);
            if (element) {
            element.style.display = 'block'
            }
            }
        hideElement('inputpwisequal');
        hideElement('inputpwisnotequal');
        hideElement('ubahpwisequal');
        hideElement('ubahpwisnotequal');

        const selectJobs = ( modal) => {
                if(modal == "modal_tambah"){
                    let input_departments_id = $("#input_departments").val();

                    $("#input_title option[value='0']").remove();
                    $('#input_title').children('option:not(:first)').remove().end();
                    $.ajax({
                        url: " <?= url('employee/api/jobTitles') ?>/" + input_departments_id,
                        method: 'GET',
                        success: function(data) {
                            $.each(data, function(index, titleObj) {
                            $('#input_title').append('<option value="' + titleObj.id + '"> ' + titleObj
                                .name + ' </option>')
                            });
                        }
                    });
                }else if(modal == "modal_ubah"){
                    let ubah_departments_id = $("#ubah_departments").val();
                    let old_ubah_job_tittle = $("#old_ubah_job_tittle").val();
                    $("#ubah_job_tittle option[value='0']").remove();
                    $('#ubah_job_tittle').children('option:not(:first)').remove().end();
                    $.ajax({
                         url: " <?= url('employee/api/jobTitles') ?>/" + ubah_departments_id,
                         method: 'GET',
                         success: function(data) {
                            $.each(data, function(index, titleObj) {
                                if(titleObj.id == old_ubah_job_tittle){
                                    $('#ubah_job_tittle').append('<option value="' + titleObj.id + '" selected> ' + titleObj.name + ' </option>')
                                }else{
                                    $('#ubah_job_tittle').append('<option value="' + titleObj.id + '"> ' + titleObj.name + ' </option>')
                                }

                            });

                        }

                    });
                    $("#ubah_job_tittle").val(old_ubah_job_tittle).change();
                }
        }
            function ubah() {
                hideElement('ubahpwisequal');
                hideElement('ubahpwisnotequal');


                var ubah_id = $("#ubah_id");
                var ubah_nama = $("#ubah_nama");
                var ubah_email = $("#ubah_email");
                var ubah_tanggal_lahir = $("#ubah_tanggal_lahir");
                var ubah_birth_place = $("#ubah_birth_place").select2('data');
                var ubah_departments = $("#ubah_departments");
                var old_ubah_job_tittle = $("#old_ubah_job_tittle");
                var ubah_job_tittle = $("#ubah_job_tittle");
                var ubah_employee_number = $("#ubah_employee_number");
                var ubah_sex = $("#ubah_sex");
                var ubah_status_employee = $("#ubah_status_employee");
                var ubah_tanggal_gabung = $("#ubah_tanggal_gabung");
                var ubah_password = $("#ubah_password");



                 var invalidFields = [];


                if (!ubah_nama.val().trim()) invalidFields.push(ubah_nama);
                if (!ubah_email.val().trim()) invalidFields.push(ubah_email);
                if (!ubah_tanggal_lahir.val().trim()) invalidFields.push(ubah_tanggal_lahir);
                if (!ubah_birth_place[0].id.trim()) invalidFields.push(input_birth_place);
                if (!ubah_departments.val().trim()) invalidFields.push(input_departments);
                if (!ubah_job_tittle.val().trim()) invalidFields.push(ubah_job_tittle);
                if (!old_ubah_job_tittle.val().trim()) invalidFields.push(old_ubah_job_tittle);
                if (!ubah_sex.val().trim()) invalidFields.push(ubah_sex);
                if (!ubah_status_employee.val().trim()) invalidFields.push(ubah_status_employee);
                if (!ubah_tanggal_gabung.val().trim()) invalidFields.push(ubah_tanggal_gabung);
                if (!ubah_password.val().trim()) invalidFields.push(ubah_password);


                if (invalidFields.length > 0) {
                invalidFields.forEach(function (field) {
                field.addClass("is-invalid"); // Pastikan ini adalah elemen jQuery
                });

                // Tampilkan peringatan
                Swal.fire({
                title: "Ada yang kosong!",
                html: "<b>Pastikan semua isian sudah diisi dengan benar.</b>",
                icon: "warning",
                confirmButtonText: "OK"
                });

                return false;
                } else {

                $("input, select").removeClass("is-invalid");
                }
                    $("#ubah_password").removeClass("is-invalid");
                    $("#ubah_confirm_password").removeClass("is-invalid");
                    var password = $("#ubah_password").val();
                    var confirmPassword = $("#ubah_confirm_password").val();
                    if (password != confirmPassword) {
                        $("#ubah_password").addClass("is-invalid");
                        $("#ubah_confirm_password").addClass("is-invalid");
                        return false;
                    }



                unhideElement('inputpwisequal');
                var dataarray = new FormData();
                var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
                dataarray.append('ubah_id', ubah_id.val());
                dataarray.append('ubah_nama', ubah_nama.val());
                dataarray.append('ubah_email', ubah_email.val());
                dataarray.append('ubah_tanggal_lahir', ubah_tanggal_lahir.val());
                dataarray.append('ubah_birth_place_name', ubah_birth_place[0].text);
                dataarray.append('ubah_birth_place_id', ubah_birth_place[0].id);
                dataarray.append('ubah_departments', ubah_departments.val());
                dataarray.append('ubah_job_tittle', ubah_job_tittle.val());
                dataarray.append('old_ubah_job_tittle', old_ubah_job_tittle.val());
                dataarray.append('ubah_sex', ubah_sex.val());
                dataarray.append('ubah_status_employee', ubah_status_employee.val());
                dataarray.append('ubah_tanggal_gabung', ubah_tanggal_gabung.val());
                dataarray.append('ubah_password', ubah_password.val());

                dataarray.append('_token', CSRF_TOKEN);
                Swal.fire({
                    html: 'Ubah data Karyawan?',
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
                            url: "<?= url('employee/update') ?>",
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
                                        title: "Berhasil",
                                        html: '<b>Halaman akan kembali ke menu utama</b>',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    })

                                    window.location.replace("<?= url('employee') ?>");
                                    console.log('masuk')
                                } else {
                                    Swal.fire({
                                        html: "<h4>Kesalahan</h4>",
                                        icon: 'warning',
                                        showCancelButton: false,
                                        showConfirmButton: false
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

            function addNewData() {
                hideElement('inputpwisequal');
                hideElement('inputpwisnotequal');

                var input_nama = $("#input_nama");
                var input_Email = $("#input_Email");
                var input_tanggal_lahir = $("#input_tanggal_lahir");
                var input_birth_place = $("#input_birth_place").select2('data');
                var input_departments = $("#input_departments");
                var input_title = $("#input_title");
                var input_sex = $("#input_sex");
                var input_status_employee = $("#input_status_employee");
                var input_tanggal_gabung = $("#input_tanggal_gabung");
                var password_input = $("#password_input");
                var confirm_password_input = $("#confirm_password_input");

                var invalidFields = [];


                if (!input_nama.val().trim()) invalidFields.push(input_nama);
                if (!input_Email.val().trim()) invalidFields.push(input_Email);
                if (!input_tanggal_lahir.val().trim()) invalidFields.push(input_tanggal_lahir);
                if (!input_birth_place[0].id.trim()) invalidFields.push(input_birth_place);
                if (!input_departments.val().trim()) invalidFields.push(input_departments);
                if (!input_title.val().trim()) invalidFields.push(input_title);
                if (!input_sex.val().trim()) invalidFields.push(input_sex);
                if (!input_status_employee.val().trim()) invalidFields.push(input_status_employee);
                if (!input_tanggal_gabung.val().trim()) invalidFields.push(input_tanggal_gabung);
                if (!password_input.val().trim()) invalidFields.push(password_input);
                if (!confirm_password_input.val().trim()) invalidFields.push(confirm_password_input);

                if (invalidFields.length > 0) {
                invalidFields.forEach(function (field) {
                field.addClass("is-invalid"); // Pastikan ini adalah elemen jQuery
                });

                // Tampilkan peringatan
                Swal.fire({
                title: "Ada yang kosong!",
                html: "<b>Pastikan semua isian sudah diisi dengan benar.</b>",
                icon: "warning",
                confirmButtonText: "OK"
                });

                return false;
                } else {

                $("input, select").removeClass("is-invalid");
                }

                $("#confirm_password_input").removeClass("is-invalid")
                $("#password_input").removeClass("is-invalid")
                if (password_input.val() != confirm_password_input.val()) {
                $("#confirm_password_input").addClass("is-invalid")
                $("#password_input").addClass("is-invalid")
                unhideElement('inputpwisnotequal');

                    Swal.fire({
                        title: "Password kamu tidak sama",
                        html: '<b>Periksa kembali isian nya</b>',
                        icon: 'danger',
                        confirmButtonText: 'OK'
                    })
                return false;
                }

                unhideElement('inputpwisequal');

                var dataarray = new FormData();
                var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
                dataarray.append('input_nama', input_nama.val());
                dataarray.append('input_Email', input_Email.val());
                dataarray.append('input_tanggal_lahir', input_tanggal_lahir.val());
                dataarray.append('input_birth_place', input_birth_place[0].id);
                dataarray.append('input_birth_place_name', input_birth_place[0].text);
                dataarray.append('input_departments', input_departments.val());
                dataarray.append('input_title', input_title.val());
                dataarray.append('input_sex', input_sex.val());
                dataarray.append('input_status_employee', input_status_employee.val());
                dataarray.append('input_tanggal_gabung', input_tanggal_gabung.val());
                dataarray.append('password_input', password_input.val());
                dataarray.append('_token', CSRF_TOKEN);
                Swal.fire({
                    html: 'Tambah Baru Karyawan?',
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
                            url: "<?= url('employee/store') ?>",
                            method: "POST",
                            data: dataarray,
                            dataType: 'json',
                            contentType: false,
                            cache: false,
                            processData: false,
                            type: 'post',
                            beforeSend: function() {
                            Swal.fire({
                            title: "Memproses permintaan...",
                            html: "menambah Data Staff"
                            })
                            Swal.showLoading();
                            },
                            success: function(data) {

                                if (data.isSuccess == 'yes') {
                                    Swal.hideLoading();
                                        swal.close();
                                    Swal.fire({
                                        title: "Berhasil",
                                        html: '<b>Halaman akan kembali ke menu utama</b>',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    })
                                    window.location.replace("<?= url('employee') ?>");
                                    console.log('masuk')
                                } else {
                                    Swal.fire({
                                        html: "<h4>Kesalahan</h4>",
                                        icon: 'warning',
                                        showCancelButton: false,
                                        showConfirmButton: false
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

            $(function() {
                $("#editdata").click(function() {
                    var nama = $("#ubah_nama").val();
                    var inisial = $("#ubah_inisial").val();
                    var nohp = $("#ubah_email").val();
                    var Email = $("#ubah_Email").val();
                    if (nama == '') {
                        alert("Ada yang kosong, Coba periksa lagi");
                        return false;
                    } else if (inisial == '') {
                        alert("Ada yang kosong, Coba periksa lagi");
                        return false;
                    } else if (nohp == '') {
                        alert("Ada yang kosong, Coba periksa lagi");
                        return false;
                    } else if (Email == '') {
                        alert("Ada yang kosong, Coba periksa lagi");
                        return false;
                    }
                    return true;

                });
            });


            function modal_tambah() {
                $('#modal_tambah').modal('show');
            }

            function change(id) {

                var dataarray = new FormData();

                $.ajax({
                    url: "<?php echo url('employee/api/show'); ?>?id=" + id,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    type: 'GET',
                        beforeSend: function() {
                            Swal.fire({
                            title: "Memproses permintaan...",
                            html: "membuka Data Staff"
                            })
                            Swal.showLoading();
                        },
                    success: function(data) {
                        if (data != null) {
                            Swal.hideLoading();
                                swal.close()
                            console.log(data);
                            $("#ubah_id").val(data.id).change();
                            $("#ubah_nama").val(data.name).change();
                            $("#ubah_email").val(data.email).change();

                            $("#ubah_tanggal_lahir").val(data.email).change();
                            $("#old_ubah_job_tittle").val(data.job_title_id).change();
                            $("#ubah_employee_number").val(data.employee_number).change();
                            $("#ubah_sex").val(data.sex).change();
                            $("#ubah_departments").val(data.department_id).change();
                            $("#ubah_status_employee").val(data.status_employee).change();

                            // $("#ubah_password").val('');
                            const selectedId = data.birth_place_id;
                             const selectedText = data.birth_place;
                            const option = new Option(selectedText, selectedId, true, true);
                            $('#ubah_birth_place').append(option).trigger('change');
                            const birth_date = data.birth_date;
                            const join_date = data.join_date;
                            const datePartsbirth_date = birth_date.split('T')[0].split('-');
                            const datePartsbjoin_date= join_date.split('T')[0].split('-');
                                const year = datePartsbirth_date[0];
                                const month = datePartsbirth_date[1];
                                const day = datePartsbirth_date[2];

                                const year1 = datePartsbjoin_date[0];
                                const month1 = datePartsbjoin_date[1];
                                const day1 = datePartsbjoin_date[2];

                                const formattedDateBirth = `${year}-${month}-${day}`;

                                const formattedDateJoin = `${year1}-${month1}-${day1}`;

                                $('#ubah_tanggal_lahir').val(formattedDateBirth);
                                $('#ubah_tanggal_gabung').val(formattedDateJoin);

                            selectJobs( 'modal_ubah');
                            $("#modal_ubah").modal('show');
                        } else {
                            Swal.fire({
                                html: "<h4>Kesalahan</h4>",
                                icon: 'warning',
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            // setTimeout(location.reload.bind(location), 1500);
                        }

                    }
                });
            }

                  function activate(id, name) {
            var dataarray = new FormData();
            var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
            dataarray.append('id', id);
            dataarray.append('name', name);
            dataarray.append('state', 'delete');
            dataarray.append('_token', CSRF_TOKEN);
            Swal.fire({
                html: 'Aktifkan akses Karyawan ini ? ',
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
                        url: "<?= url('employee/activate') ?>",
                        method: "POST",
                        data: dataarray,
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        type: 'post',
                        beforeSend: function() {
                        Swal.fire({
                        title: "Memproses permintaan...",
                        html: "Memperbaharui Data Staff"
                        })
                        Swal.showLoading();
                        },
                        success: function(data) {

                           if(data.isSuccess == 'yes'){
                            Swal.hideLoading();
                                swal.close()
                        Swal.fire({
                            title: "data terhapus",
                            html: '<b>Halaman akan kembali ke menu utama</b>',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            })

                            window.location.replace( "<?= url('employee') ?>");
                    console.log('masuk')
                    }else {
                                Swal.fire({
                                    html: "<h4>Kesalahan</h4>",
                                    icon: 'warning',
                                    showCancelButton: false,
                                    showConfirmButton: false
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

         function deactivate(id, name) {
            var dataarray = new FormData();
            var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
            dataarray.append('id', id);
            dataarray.append('name', name);
            dataarray.append('state', 'delete');
            dataarray.append('_token', CSRF_TOKEN);
            Swal.fire({
                html: 'matikan akses Karyawan ini ? ',
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
                        url: "<?= url('employee/deactivate') ?>",
                        method: "POST",
                        data: dataarray,
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        type: 'post',
                        beforeSend: function() {
                        Swal.fire({
                        title: "Memproses permintaan...",
                        html: "Memperbaharui Data Staff"
                        })
                        Swal.showLoading();
                        },
                        success: function(data) {

                           if(data.isSuccess == 'yes'){
                            Swal.hideLoading();
                                swal.close();
                        Swal.fire({
                            title: "data terhapus",
                            html: '<b>Halaman akan kembali ke menu utama</b>',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            })

                            window.location.replace( "<?= url('employee') ?>");
                    console.log('masuk')
                    }else {
                                Swal.fire({
                                    html: "<h4>Kesalahan</h4>",
                                    icon: 'warning',
                                    showCancelButton: false,
                                    showConfirmButton: false
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

      function hapus(id, name) {
            var dataarray = new FormData();
            var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
            dataarray.append('id', id);
            dataarray.append('name', name);
            dataarray.append('state', 'delete');
            dataarray.append('_token', CSRF_TOKEN);
            Swal.fire({
                html: 'Hapus akses Karyawan ini ? ',
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
                        url: "<?= url('employee/destroy') ?>",
                        method: "POST",
                        data: dataarray,
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        type: 'post',
                        beforeSend: function() {
                        Swal.fire({
                        title: "Memproses permintaan...",
                        html: "Memperbaharui Data Staff"
                        })
                        Swal.showLoading();
                        },
                        success: function(data) {

                           if(data.isSuccess == 'yes'){
                            Swal.hideLoading();
                                swal.close()
                        Swal.fire({
                            title: "data terhapus",
                            html: '<b>Halaman akan kembali ke menu utama</b>',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            })

                            window.location.replace( "<?= url('employee') ?>");
                    console.log('masuk')
                    }else {
                                Swal.fire({
                                    html: "<h4>Kesalahan</h4>",
                                    icon: 'warning',
                                    showCancelButton: false,
                                    showConfirmButton: false
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



            function funct_show_password() {
                var x = document.getElementById("ubah_password");
                var y = document.getElementById("ubah_confirm_password");
                if (x.type === "text" || y.type === "text") {
                    x.type = "password";
                    y.type = "password";
                } else {
                    x.type = "text";
                    y.type = "text";
                }
            }

            function funct_show_password_new() {
                var z = document.getElementById("password_input");
                var a = document.getElementById("confirm_password_input");
                if (z.type === "text" || a.type === "text") {
                    z.type = "password";
                    a.type = "password";
                } else {
                    z.type = "text";
                    a.type = "text";
                }
            }



            $('#data_user').DataTable({
                lengthMenu: [30, 60, 80, 120],
                serverSide: true,
                        deferRender: true,
                        processing: true,
                        bLengthChange: false,
                        bInfo: false,
                        order: [],
                        language: {
                        searchPlaceholder: 'Search...',
                        emptyTable: 'Belum ada data yang ditampilkan. ',
                        zeroRecords: 'Tidak ada data yang ditampilkan. ',
                        loadingRecords: 'Memuat Data. ',
                        infoEmpty: 'Data kosong. ',
                        infoFiltered: '(dari _MAX_ data.)',
                        infoEmpty: 'Pencarian tidak ditemukan. ',
                        info: 'Menampilkan _START_ hingga _END_ baris dari _TOTAL_ data',
                        lengthMenu: 'Menampilkan _MENU_ Baris per halaman',
                        paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                        },

                        },

                        fixedHeader: false,
                        paging: true,
                        searching: true,
                        responsive: false,
                        autoWidth: true,
                        scrollY: false,
                        scrollX: false,
                        pageLength: 10,

                ajax: '<?= url('/employee/api/datatable') ?>',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },

                    {
                        data: 'jatahCuti',
                        name: 'jatahCuti'
                    },                    {
                        data: 'masaKerja',
                        name: 'masaKerja'
                    },                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'job_title',
                        name: 'job_title'
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Reimbursement SYSTEM\resources\views/employee/index.blade.php ENDPATH**/ ?>