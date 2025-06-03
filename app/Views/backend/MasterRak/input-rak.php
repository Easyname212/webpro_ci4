<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li><a href="<?= base_url('admin/master-data-rak') ?>">Master Data Rak</a></li>
            <li class="active">Input Data Rak</li>
        </ol>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Input Data Rak</h3>
                    <hr />
                    <form action="<?= base_url('admin/simpan-rak'); ?>" method="post">
                        <div class="form-group col-md-6">
                            <label>Nama Rak</label>
                            <input type="text" class="form-control" name="nama_rak" placeholder="Masukkan Nama Rak" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" placeholder="Masukkan Lokasi Rak" required="required">
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-12">
                            <label>Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan Keterangan Rak"></textarea>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <a href="<?= base_url('admin/master-data-rak'); ?>" class="btn btn-warning">Kembali</a>
                        </div>
                        <div style="clear:both;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
