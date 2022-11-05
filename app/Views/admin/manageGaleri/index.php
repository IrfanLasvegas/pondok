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

                <a href="<?= site_url('manage-galeri/create') ?>" class=" ml-2 btn btn-primary"> Add New</a>
            </div>

            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success alert-dismissible fade show ml-4 mr-4" role="alert">
                    <?php echo session()->getFlashdata('success'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>


            <div class="card-body">
                <div class="row">
                    <?php
                    $no = 1;
                    if ($currentPage > 1) {
                        $no = ($per_page * ($currentPage - 1));
                    } else {
                        $no = 0;
                    }
                    foreach ($data_galeri as $row) {
                    ?>
                        <!-- <p><?= $row->title ?></p> -->
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <article class="article article-style-b">
                                <div class="article-header">
                                    <!-- <div class="article-image" data-background="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" > -->
                                    <div class="article-image" data-background="<?= base_url() . "/uploads/galeri/" . $row->gambar; ?>">
                                    </div>
                                </div>
                                <div class="article-details">
                                    <div class="article-title">
                                        <h2><a href="#" class="crop1"><?= $row->title ?></a></h2>
                                    </div>
                                    <div class="crop3 text-justify"><?= $row->description ?> </div>
                                    <div class="article-cta">
                                        <!-- <a href="#" class="btn btn-icon btn-sm btn-danger" style="width: 35px;"><i class="fas fa-times"></i></a> -->
                                        <form action="<?= base_url("manage-galeri/delete/" . $row->id) ?>" method="post" class="d-inline" id="formDel<?= $row->id ?>">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="button" onclick="deleteDatav(<?= $row->id ?>)" class="btn btn-sm btn-danger" style="width: 35px;"> <i class="fas fa-trash"></i></button>
                                        </form>
                                        <a href="<?= base_url("manage-galeri/edit/" . $row->id) ?>" class="btn btn-icon btn-sm btn-warning" style="width: 35px;"><i class="far fa-edit"></i></a>
                                        <a href="<?= base_url("manage-galeri/show/" . $row->id) ?>" class="btn btn-icon btn-sm btn-info" style="width: 35px;"><i class="fas fa-eye"></i></i></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php
                    }

                    ?>
                </div>

                <!-- <div class="gallery">    
                    <div class="gallery-item" data-image="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" data-title="Image 1" href="../assets/img/news/img01.jpg" title="Image 1" style="background-image: url(&quot;../assets/img/news/img01.jpg&quot;);"></div>
                    <div class="gallery-item" data-image="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" data-title="Image 1" href="../assets/img/news/img01.jpg" title="Image 1" style="background-image: url(&quot;../assets/img/news/img01.jpg&quot;);"></div>
                    <div class="gallery-item" data-image="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" data-title="Image 1" href="../assets/img/news/img01.jpg" title="Image 1" style="background-image: url(&quot;../assets/img/news/img01.jpg&quot;);"></div>
                    <div class="gallery-item" data-image="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" data-title="Image 1" href="../assets/img/news/img01.jpg" title="Image 1" style="background-image: url(&quot;../assets/img/news/img01.jpg&quot;);"></div>
                    <div class="gallery-item" data-image="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" data-title="Image 1" href="../assets/img/news/img01.jpg" title="Image 1" style="background-image: url(&quot;../assets/img/news/img01.jpg&quot;);"></div>
                    <div class="gallery-item" data-image="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" data-title="Image 1" href="../assets/img/news/img01.jpg" title="Image 1" style="background-image: url(&quot;../assets/img/news/img01.jpg&quot;);"></div>
                    <div class="gallery-item" data-image="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" data-title="Image 1" href="../assets/img/news/img01.jpg" title="Image 1" style="background-image: url(&quot;../assets/img/news/img01.jpg&quot;);"></div>
                    <div class="gallery-item" data-image="../assets/img/news/img08.jpg" data-title="Image 8" href="../assets/img/news/img08.jpg" title="Image 8" style="background-image: url(&quot;../assets/img/news/img08.jpg&quot;);"></div>
                </div> -->

            </div>
            <div class="card-footer text-right">
                <?= $pager->links('group_galeri', 'custom_pager1') ?>
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