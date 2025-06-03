<?= $this->include('backend/template/header') ?>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?= $this->include('backend/template/sidebar') ?>
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Input Data Kategori</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-plus"></i> Form Input Kategori
                        </div>
                        <div class="panel-body">
                            <form action="<?= base_url('admin/simpan-kategori') ?>" method="POST" role="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Kategori</label>
                                            <input type="text" class="form-control" name="nama_kategori" 
                                                   placeholder="Masukkan Nama Kategori" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" name="keterangan" rows="3" 
                                                     placeholder="Masukkan Keterangan Kategori"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                        <a href="<?= base_url('admin/master-kategori'); ?>" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('backend/template/footer') ?>
</body>
</html>
