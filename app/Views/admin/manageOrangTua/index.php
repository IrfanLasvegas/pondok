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
                                <th>Email</th>
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
                            foreach ($data_user as $row) {
                            ?>
                                <tr>
                                    <td class="text-sm align-middle"><?= $no = $no + 1  ?></td>
                                    <td class="text-sm align-middle"><?= $row->username; ?></td>
                                    <td class="text-sm align-middle"><?= $row->email; ?></td>
                                    <td class="text-sm align-middle"><?= $row->created_at; ?></td>
                                    <td>
                                        <a title="Edit" href="<?= base_url("manage-orang-tua/edit/" . $row->id); ?>" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                        <form action="<?= base_url("manage-orang-tua/delete/" . $row->id) ?>" method="post" class="d-inline" id="formDel<?= $row->id ?>">
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
                
                <?= $pager->links('group_parent', 'custom_pager1') ?>

            </div>
        </div>
    </div>
</section>

<script>
    function deleteDatav(id) {
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
                    $("#formDel" + id).submit();
                }
            })
    }
</script>

<?= $this->endSection() ?>