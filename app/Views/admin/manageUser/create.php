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
            <a href="<?= site_url('manage-user')?>"><i class="fas fa-arrow-left"></i></a>
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
                <form method="post" action="<?= base_url('manage-user/store') ?>" class="pl-4 pr-4" >
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="POST"> 
                    <div class="form-group">
                        <label for="password">Nama</label>
                        <input type="text" name="username" value="<?= old('username') ?>"  class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <?php if (!empty(session()->getFlashdata('error')['username'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['username']?>
                            </small>
                        <?php endif; ?>
                        
                    </div>

                    <div class="form-group">
                        <label for="password">Email</label>
                        <input type="email" name="email" value="<?= old('email') ?>"  class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <?php if (!empty(session()->getFlashdata('error')['email'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['email']?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                        <option value="">select role</option>
                            <?php
                            foreach ($groups as $row){
                                ?>
                                    <option value="<?=$row->name?>"><?=$row->name?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php if (!empty(session()->getFlashdata('error')['role'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['role']?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password"  class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <?php if (!empty(session()->getFlashdata('error')['password'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['password']?>
                            </small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <!-- <div class="section-title mt-0">Repeat Password</div> -->
                        <label for="pass_confirm">Repeat Password</label>
                        <input type="password" name="pass_confirm"  class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <?php if (!empty(session()->getFlashdata('error')['pass_confirm'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['pass_confirm']?>
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