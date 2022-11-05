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
            <a href="<?= site_url('manage-user') ?>"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1><?= $section_header ?></h1>

    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4><?= $data->title ?></h4>

                <div class="card-header-action">
                    <?= $data->username ?> | <?= $data->created_at ?>
                </div>
            </div>
            <div class="card-body">
                <div class="chocolat-parent">
                    <a href="<?= base_url() . "/uploads/berita/" . $data->gambar; ?>" class="chocolat-image" title="Just an example">
                        <div data-crop-image="285" style="overflow: hidden; position: relative; height: 285px;">
                            <img alt="image" src="<?= base_url() . "/uploads/berita/" . $data->gambar; ?>" class="img-fluid">
                        </div>
                    </a>
                </div>
                <div>
                    <?= $data->description ?>
                </div>






            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 id="titleComment">Leave a Comment:</h4>
            </div>
            <div class="card body">
                
                <div class="p-4" id="tmpComment">
                    <div class="media border p-1 mb-2" >
                        <div class="col-sm-12">
                            <span id="commentReplayNama" style="font-size: 16;font-weight: 500;"></span>
                            <p class="ml-3" id="commentReplay"></p>
                        </div> 
                    </div>
                </div>
                
                <form method="post" id="form_komen" class="pl-4 pr-4">
                    <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                    <input type="hidden" name="berita_id" id="berita_id" value="<?= $data->id ?>">
                    <input type="hidden" name="parent_komentar_id" id="parent_komentar_id" value="0" />
                    <span id="success_message"></span>
                    <div class="form-group">
                        <textarea name="komen" id="komen" class="form-control" placeholder="Tulis Komentar" class="form-control" rows="2"></textarea>
                        <span id="name_comment" class="text-danger mt1"></span>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary" id="btnBatal">Batal</button>
                        <input type="button" onclick="addKomen()" name="do-komen" id="do-komen" class="btn btn-primary" value="Comment">
                    </div>
                    <div id="all-error"></div>
                </form>
                <!-- Comment with nested comments -->
                <div class="p-4" id="display_comment"></div>
            </div>
        </div>
    </div>
</section>

<script>
    // disable button submit if empty
    $('#do-komen').prop('disabled', true);
    function validateNextButton() {
        var buttonDisabled = $('#komen').val().trim() === '';
        $('#do-komen').prop('disabled', buttonDisabled);
    }
    $('#komen').on('keyup', validateNextButton);



    function load_comment() {
        var id = String(<?= $data->id ?>);
        $.ajax({
            url: "<?php echo site_url('manage-komentar/show') ?>/" + id,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            type: 'get',
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    $('#display_comment').html(response.allComment);

                } else if (response.success == 0) {
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
    load_comment();

    function addKomen() {
        var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        var berita_id = $('#berita_id').val();
        var parent_komentar_id = $('#parent_komentar_id').val();
        var komen = $('#komen').val();

        $.ajax({
            url: "<?php echo site_url('manage-komentar/store'); ?>",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            type: 'post',
            data: {
                [csrfName]: csrfHash, // adding csrf here
                berita_id: berita_id,
                parent_komentar_id: parent_komentar_id,
                komen: komen,
            },
            dataType: "json",
            success: function(response) {
                $('.txt_csrfname').val(response.token);
                // console.log(response);
                if (response.success == 1) {
                    $('#komen').val('');
                    $('#parent_komentar_id').val('0');
                    $('#do-komen').prop('disabled', true);
                    $("#btnBatal").hide();
                    $("#tmpComment").hide("slow");
                    load_comment();
                } else if (response.success == 0) {
                    data='';
                    data = data + "<div class='mt-2 alert alert-danger alert-dismissible fade show' role='alert'><h4>Form error</h4></hr>"
                    data = data + "<div class='errors' role='aler'>" + response.error + "</div>"
                    $('#all-error').html(data);
                }
            }
        });
    }

    //replay comment
    $(document).on('click', '.reply', function(event){
        var parent_komentar_id = $(this).attr("id");
        var split_parent_komentar_id = parent_komentar_id.split("-_-");
        
        $('#parent_komentar_id').val(split_parent_komentar_id[0]);
        $('#commentReplayNama').html(
            "@"+$("#nama"+split_parent_komentar_id[1]).html()
        );
        $('#commentReplay').html(
            $("#komentar"+split_parent_komentar_id[1]).html()
        );
        // $('#komen').focus();
        //console.log(parent_komentar_id);
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $("#titleComment").offset().top -100
        }, 1500,'swing', function() {
            $("#komen").focus();
        });
        $("#btnBatal").show();
        $("#tmpComment").show("slow");
    });

    $(document).on('click', '#btnBatal', function(event){
        var komentar_id = $(this).attr("id");
        $('#parent_komentar_id').val('0');
        $("#btnBatal").hide();
        $("#tmpComment").hide("slow");
    });

    $(document).on('click', '.deleteReplay', function(event){
        var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
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
                        url: "<?php echo site_url('manage-komentar/delete'); ?>",
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        type: 'post',
                        data: {
                            [csrfName]: csrfHash, // adding csrf here
                            tmp_id: $(this).attr("id"),
                        },
                        dataType: "json",
                        success: function(response) {

                            $('.txt_csrfname').val(response.token);
                            if (response.success == 1) {
                                load_comment();
                            } else if (response.success == 0) {
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
        event.preventDefault();///berfungsi agar posisi view tetap
        
    });





    
    if ($('#parent_komentar_id').val() == "0") {
        $("#btnBatal").hide();
        $("#tmpComment").hide();
    } else {
        $("#btnBatal").show();
    }
</script>

<?= $this->endSection() ?>