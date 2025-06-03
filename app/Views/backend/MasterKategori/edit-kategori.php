<?= $this->include('backend/template/header') ?>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?= $this->include('backend/template/sidebar') ?>
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Data Kategori</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-edit"></i> Form Edit Kategori - <?= $dataEdit['kode_kategori'] ?>
                        </div>
                        <div class="panel-body">
                            <form action="<?= base_url('admin/update-kategori') ?>" method="POST" role="form">
                                <input type="hidden" name="id_kategori" value="<?= $dataEdit['id_kategori'] ?>">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Kategori</label>
                                            <input type="text" class="form-control" 
                                                   value="<?= $dataEdit['kode_kategori'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Kategori</label>
                                            <input type="text" class="form-control" name="nama_kategori" 
                                                   value="<?= $dataEdit['nama_kategori'] ?>" 
                                                   placeholder="Masukkan Nama Kategori" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" name="keterangan" rows="3" 
                                                     placeholder="Masukkan Keterangan Kategori"><?= $dataEdit['keterangan'] ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
