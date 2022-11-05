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
            <a href="<?= site_url('manage-galeri')?>"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1><?= $section_header ?></h1>
        
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Add New</h4>
            </div>
            <?php if (!empty(session()->getFlashdata('error2'))) : ?>
                <div class="alert alert-danger alert-dismissible fade show ml-4 mr-4"  role="alert">                   
                    <?php  echo(session()->getFlashdata('error2'));
                            
                    ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <div class="card-body p-0">
                <form method="post" action="<?= site_url('manage-galeri/update/'. $data->id) ?>" enctype="multipart/form-data" class="pl-4 pr-4" >
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT"> 
                    <div class="form-group">
                        <label for="password">Title</label>
                        <input type="text" name="title" value="<?= $data->title ?>"  class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <?php if (!empty(session()->getFlashdata('error')['title'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['title']?>
                            </small>
                        <?php endif; ?>
                        
                    </div>

                    <div class="form-group">
                        <label for="password">Description</label>
                        <textarea name="description" class="form-control" rows="10"><?= $data->description ?></textarea>
                        
                        <?php if (!empty(session()->getFlashdata('error')['description'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['description']?>
                            </small>
                        <?php endif; ?>
                        
                    </div>

                    <div class="form-group">
                        <label for="password">Gambar</label>
                        <input type="file" name="file" value="<?= old('file') ?>"  class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3 mt-2">
                            <article class="article article-style-b">
                                <div class="article-header">
                                    <!-- <div class="article-image" data-background="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Siberischer_tiger_de_edit02.jpg/400px-Siberischer_tiger_de_edit02.jpg" > -->
                                    <div class="article-image" data-background="<?= base_url() . "/uploads/galeri/" . $data->gambar; ?>">
                                    </div>
                                </div>

                            </article>
                        </div>

                        <?php if (!empty(session()->getFlashdata('error')['file'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['file']?>
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
    </div>
</section>

<?= $this->endSection() ?>