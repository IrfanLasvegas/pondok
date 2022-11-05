<?= $this->extend('layout1/template') ?>

<?= $this->section('title') ?>
<title>

    <?= $title ?>
</title>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= site_url('manage-orang-tua') ?>"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1><?= $section_header ?></h1>

    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Update</h4>
            </div>
            <?php if (!empty(session()->getFlashdata('error2'))) : ?>
                <div class="alert alert-danger alert-dismissible fade show ml-4 mr-4" role="alert">
                    <?php echo (session()->getFlashdata('error2'));

                    ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <div class="card-body p-0">
                <form method="post" action="<?= site_url('manage-orang-tua/update/' . $data->id) ?>" class="pl-4 pr-4">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="password">Nama</label>
                        <input disabled type="text" name="username" value="<?= $data->username ?>" class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <?php if (!empty(session()->getFlashdata('error')['username'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?= session()->getFlashdata('error')['username'] ?>
                            </small>
                        <?php endif; ?>

                    </div>

                    <div class="form-group">
                        <label for="password">Email</label>
                        <input disabled type="email" name="email" value="<?= $data->email ?>" class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <?php if (!empty(session()->getFlashdata('error')['email'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?= session()->getFlashdata('error')['email'] ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <?php echo $data->jenis_kelamin == '3'; ?>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">select gender</option>
                            <?php
                            if ($data->jenis_kelamin == '') {
                            ?>
                                <option value="pria">pria</option>
                                <option value="wanita">wanita</option>
                            <?php
                            } else if ($data->jenis_kelamin == 'pria') {
                            ?>
                                <option selected value="pria">pria</option>
                                <option value="wanita">wanita</option>
                            <?php
                            } else if ($data->jenis_kelamin == 'wanita') {
                            ?>
                                <option value="pria">pria</option>
                                <option selected value="wanita">wanita</option>
                            <?php
                            }
                            ?>

                        </select>
                        <?php if (!empty(session()->getFlashdata('error')['jenis_kelamin'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?= session()->getFlashdata('error')['jenis_kelamin'] ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="no_telp">No.Tlp</label>
                        <input type="text" name="no_telp" value="<?= $data->no_telp ?>" class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <?php if (!empty(session()->getFlashdata('error')['no_telp'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?= session()->getFlashdata('error')['no_telp'] ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" value="<?= $data->alamat ?>" class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <?php if (!empty(session()->getFlashdata('error')['alamat'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?= session()->getFlashdata('error')['alamat'] ?>
                            </small>
                        <?php endif; ?>
                    </div>



                    <div class="form-group text-right">
                        <input type="submit" value="Submit" class="btn btn-info" />
                    </div>
                </form>
            </div>


            <div class="card-footer text-right">

            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h4>Mahasiswa</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                <input type="text" class="form-control" id="email2" placeholder="Email orang tua" aria-label="">
                                <div class="input-group-append">
                                    <button onclick="addDatav()" class="btn btn-info" type="button">Add</button>
                                </div>

                            </div>

                            <!-- <small id="passwordHelpBlock" class="form-text text-muted pl-2">
                                ssss dfjk 
                            </small>     -->
                        </div>


                    </thead>
                    <tbody class="list-parent">


                    </tbody>
                </table>
            </div>
        </div>





    </div>
</section>



<script>
    function allParent() {
        var id = String(<?= $data->id ?>);
        // console.log(String(id)+3);
        // console.log("<?= site_url('manage-take-student') ?>/"+id);
        $.ajax({
            url: "<?php echo site_url('manage-take-student') ?>/" + id,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            type: 'get',
            dataType: "json",
            success: function(response) {
                let urlEdit = "<?= site_url('manage-mahasiswa/edit') ?>/"
                // console.log(response);
                // console.log(urlEdit);

                if (response.success == 1) {
                    var data = ""
                    var n = 0;
                    $.each(response.data, function(key, value) {
                        n += 1;
                        data = data + "<tr>"
                        data = data + "<td>" + n + "</td>"
                        data = data + "<td>" + value.username + "</td>"
                        data = data + "<td>" + value.email + "</td>"
                        data = data + "<td>"
                        data = data + "<a title='Edit' href=" + urlEdit + value.mahasiswas_id + " class='btn btn-warning'><i class='fas fa-pencil-alt'></i></a>"
                        data = data + "<button type='button' onclick='deleteDatav(" + value.id + ")' class='btn btn-danger ml-2'> <i class='fas fa-trash'></i></button>"
                        data = data + "</td>"
                        data = data + "</tr>"
                        // console.log(value.username,'---', value.email);
                    })
                    // console.log(data);
                    $('.list-parent').html(data);

                } else if (response.success == 0) {
                    // console.log('ada yang salah');
                    // ----------------- start alert -----------------
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1600,
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutRight'
                        },

                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        },
                    })
                    Toast.fire({
                        icon: 'error',
                        title: "Error"
                    })
                    // ----------------- end alert -----------------
                    if ($('#toggle' + id).attr("st") == '1') {
                        $('#toggle' + id).prop("checked", true);
                    } else if ($('#toggle' + id).attr("st") == '0') {
                        $('#toggle' + id).prop("checked", false);
                    }
                }
            }
        });
    }
    allParent();

    function addDatav() {
        let id1 = String(<?= $data->id ?>)
        console.log(id1, 'iiii');
        // CSRF Hash
        var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        var email2 = $('#email2').val();
        $.ajax({
            url: "<?php echo site_url('manage-ortumhs/create2'); ?>",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            type: 'post',
            data: {
                [csrfName]: csrfHash, // adding csrf here
                tmp_id: id1,
                tmp_email: email2,
            },
            dataType: "json",
            success: function(data) {
                $('.txt_csrfname').val(data.token);
                if (data.success == 1) {
                    $('#email2').val('');
                    // console.log(data);
                    // ----------------- start alert -----------------
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1600,
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutRight'
                        },

                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        },
                    })
                    Toast.fire({
                        icon: 'success',
                        title: "Tambah  email orang tua berhasil"
                    })
                    // ----------------- end alert -----------------
                    allParent();



                } else if (data.success == 0) {
                    // ----------------- start alert -----------------
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1600,
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutRight'
                        },

                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        },
                    })
                    Toast.fire({
                        icon: 'error',
                        title: String(data.error)
                    })
                    // ----------------- end alert -----------------

                }
            }
        });
    }

    function deleteDatav(id2) {
        // console.log(id2);
        // CSRF Hash
        var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        // console.log(csrfName,'-------',csrfHash);
        Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Semua data yang terkait dengan data ini akan dihapus dan  tidak  dapat dipulihkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('manage-ortumhs/delete2'); ?>",
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        type: 'post',
                        data: {
                            [csrfName]: csrfHash, // adding csrf here
                            tmp_id: id2,
                        },
                        dataType: "json",
                        success: function(data) {

                            $('.txt_csrfname').val(data.token);
                            if (data.success == 1) {

                                // ----------------- start alert -----------------
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 1600,
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutRight'
                                    },

                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    },
                                })
                                Toast.fire({
                                    icon: 'success',
                                    title: "Delete data berhasil"
                                })
                                // ----------------- end alert -----------------
                                // console.log(data);
                                allParent();

                            } else if (data.success == 0) {
                                // ----------------- start alert -----------------
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 1600,
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutRight'
                                    },

                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    },
                                })
                                Toast.fire({
                                    icon: 'error',
                                    title: "Error"
                                })
                                // ----------------- end alert -----------------

                            }
                        }
                    });
                }
            })

    }
</script>

<?= $this->endSection() ?>