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
            <a href="<?= site_url('manage-keuangan')?>"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1><?= $section_header ?></h1>
        
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Update</h4>
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
                <form method="post" action="<?= site_url('manage-detail-keuangan/update/'. $data->id) ?>" enctype="multipart/form-data" class="pl-4 pr-4" >
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="PUT"> 

                    <div class="form-group">
                        <label>Keuangan</label>
                        <select name="keuangan" class="form-control">
                        <option value="">select keuangan</option>
                        <?php
                            
                            foreach ($base_keuangan as $row) { 
                                ?>
                                    <?php 
                                        if ($data->keuangans_id == $row->id) {
                                            ?>
                                                <option selected value="<?=$row->id?>"><?=$row->title?></option>
                                            <?php
                                        }else if($data->keuangans_id == $row->id){
                                            ?>
                                                <option selected value="<?=$row->id?>"><?=$row->title?></option>
                                            <?php
                                        }else{
                                            ?>
                                                <option value="<?=$row->id?>"><?=$row->title?></option>
                                            <?php
                                        }
                                    ?>
                                    
                                <?php
                            }
                        ?>
                        </select>
                        <?php if (!empty(session()->getFlashdata('error')['keuangan'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['keuangan']?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Nominal</label>
                        <input type="text" name="nominal" id="nominal" value="Rp. <?=number_format($data->nominal,0,".",".") ?>"  class="form-control" aria-describedby="passwordHelpBlock" autocomplete="off">
                        <?php if (!empty(session()->getFlashdata('error')['nominal'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['nominal']?>
                            </small>
                        <?php endif; ?>
                        
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                        <option value="">select status</option>
                        <?php 
                            if ($data->status == '1') {
                                ?>
                                    <option selected value="1">active</option>
                                    <option value="0">inactive</option>
                                <?php
                            }else if ($data->status == '0') {
                                ?>
                                    <option value="1">active</option>
                                    <option selected value="0">inactive</option>
                                <?php
                            }
                        ?>
                        </select>
                        <?php if (!empty(session()->getFlashdata('error')['status'])) : ?>
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                <?=session()->getFlashdata('error')['status']?>
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

<script>
    $('#nominal').keyup(function() {
            nominal.value = formatRupiah(this.value, 'Rp. ');            
        });
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>

<?= $this->endSection() ?>