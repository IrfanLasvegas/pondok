<?= $this->extend('layout1/template') ?>

<?= $this->section('title') ?>
<title>

    <?= $title ?>
</title>
<?= $this->endSection() ?>


<?= $this->section('content-search') ?>
<div class="search-element">
    <input class="form-control" type="search" name="keyword" value="<?= $tmp_keyword ?>" placeholder="Search" aria-label="Search" data-width="250">
    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
</div>
<?= $this->endSection() ?>



<?= $this->section('content') ?>

<!-- CSRF token --> 
<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
<section class="section">
    <div class="section-header">
        <h1><?= $section_header ?></h1>
        
    </div>

    <div class="section-body">
        <div class="card ">
            <div class="card-header">
            <a href="<?= site_url('manage-keuangan/create') ?>" class=" ml-2 btn btn-primary"> Add New</a>
            <a href="<?= site_url('manage-detail-keuangan') ?>" class=" ml-2 btn btn-primary"> Detail Keuangan</a>
            
            </div>

            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success alert-dismissible fade show ml-4 mr-4" role="alert">
                    <?php echo session()->getFlashdata('success'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-md">

                        <tbody>
                        <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $no = 1;
                            if ($currentPage > 1) {
                                $no = ($per_page * ($currentPage - 1));
                            } else {
                                $no = 0;
                            }
                            foreach ($data_keuangan as $row) {
                            ?>
                                <tr>
                                    <td class="text-sm align-middle"><?= $no = $no + 1  ?></td>
                                    <td class="text-sm align-middle"><?= $row->title; ?></td>
                                    <td class="text-sm align-middle"><?= $row->description; ?></td>
                                    <td class="text-sm align-middle"><?= $row->created_at; ?></td>
                                    <td>
                                        <a title="Edit" href="<?= base_url("manage-keuangan/edit/" . $row->id); ?>" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                        <form action="<?= base_url("manage-keuangan/delete/" . $row->id) ?>" method="post" class="d-inline" id="formDel<?= $row->id ?>">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="button" onclick="deleteDatav(<?= $row->id ?>)" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                                        </form>

                                    </td>

                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <!-- parameter pertama group_nama tabel di db  -->
                <?= $pager->links('group_keuangan', 'custom_pager1') ?>
            </div>
        </div>
    </div>
</section>

<script>
    function changeStatus(id){
        // CSRF Hash
       var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
       var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        //    $('#toggle'+id).prop("checked", false);
        // console.log('id ='+id);
        $.ajax({
            url : "<?php echo site_url('manage-user/changest'); ?>",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            type: 'post',
            data: { 
                [csrfName]: csrfHash, // adding csrf here
                tmp_id_user: id, 
                tmp_st_user: $('#toggle'+id).attr("st"), 
            }, 
            dataType: "json",         
            success : function(data)
            {   
                // console.log(data);
                // Update CSRF hash
                // console.log($('#toggle'+id).attr("st"));
                $('.txt_csrfname').val(data.token);
                if (data.success==1) {
                    if(data.st_u == 1){
                        $('#toggle'+id).prop("checked", true);
                        $('#toggle'+id).attr("st","1");
                    }else if(data.st_u == 0){
                        $('#toggle'+id).prop("checked", false);
                        $('#toggle'+id).attr("st","0");
                    }

                    // console.log('data berhasil');
                    // console.log($('#toggle'+id).attr("st"));
                    // $('#toggle'+id).attr("st","kia kia")
                    // console.log($('#toggle'+id).attr("st"));
                    
                    
                }else if (data.success==0) {
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
                    if ($('#toggle'+id).attr("st")=='1') {
                        $('#toggle'+id).prop("checked", true);
                    }else if($('#toggle'+id).attr("st")=='0'){
                        $('#toggle'+id).prop("checked", false);
                    }
                }
            }  
        });
    }


    function deleteDatav(id){
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
                $( "#formDel"+id).submit();
            }
        })
    }
</script>

<?= $this->endSection() ?>