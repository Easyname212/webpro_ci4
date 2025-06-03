<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li><a href="<?= base_url('admin/master-data-rak') ?>">Master Data Rak</a></li>
            <li class="active">Edit Data Rak</li>
        </ol>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Edit Data Rak - <?= $dataEdit['kode_rak'] ?></h3>
                    <hr />
                    <form action="<?= base_url('admin/update-rak'); ?>" method="post">
                        <input type="hidden" name="id_rak" value="<?= $dataEdit['id_rak'] ?>">
                        
                        <div class="form-group col-md-6">
                            <label>Kode Rak</label>
                            <input type="text" class="form-control" value="<?= $dataEdit['kode_rak'] ?>" readonly>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Nama Rak</label>
                            <input type="text" class="form-control" name="nama_rak" value="<?= $dataEdit['nama_rak'] ?>" placeholder="Masukkan Nama Rak" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" value="<?= $dataEdit['lokasi'] ?>" placeholder="Masukkan Lokasi Rak" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-12">
                            <label>Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan Keterangan Rak"><?= $dataEdit['keterangan'] ?></textarea>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="<?= base_url('admin/master-data-rak'); ?>" class="btn btn-warning">Kembali</a>
                        </div>
                        <div style="clear:both;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
