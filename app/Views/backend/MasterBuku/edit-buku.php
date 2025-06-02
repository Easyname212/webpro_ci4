<?= $this->include('backend/template/header') ?>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?= $this->include('backend/template/sidebar') ?>
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Data Buku</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-edit"></i> Form Edit Buku - <?= $data_buku['kode_buku'] ?>
                        </div>
                        <div class="panel-body">
                            <form action="<?= base_url('admin/update-buku') ?>" method="POST" role="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Buku</label>
                                            <input type="text" class="form-control" 
                                                   value="<?= $data_buku['kode_buku'] ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Judul Buku <span class="text-danger">*</span></label>
                                            <input type="text" name="judul" class="form-control" 
                                                   value="<?= $data_buku['judul_buku'] ?>"
                                                   placeholder="Masukkan judul buku" required 
                                                   onkeypress="return goodchars(event,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890., ')">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Pengarang <span class="text-danger">*</span></label>
                                            <input type="text" name="pengarang" class="form-control" 
                                                   value="<?= $data_buku['pengarang'] ?>"
                                                   placeholder="Masukkan nama pengarang" required
                                                   onkeypress="return goodchars(event,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ., ')">
                                        </div>

                                        <div class="form-group">
                                            <label>Penerbit</label>
                                            <input type="text" name="penerbit" class="form-control" 
                                                   value="<?= $data_buku['penerbit'] ?>"
                                                   placeholder="Masukkan nama penerbit"
                                                   onkeypress="return goodchars(event,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890., ')">
                                        </div>

                                        <div class="form-group">
                                            <label>Tahun Terbit</label>
                                            <input type="number" name="tahun" class="form-control" 
                                                   value="<?= $data_buku['tahun_terbit'] ?>"
                                                   placeholder="Contoh: 2023" min="1900" max="<?= date('Y') ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kategori <span class="text-danger">*</span></label>
                                            <select name="kategori" class="form-control" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                <?php if (!empty($kategori)): ?>
                                                    <?php foreach ($kategori as $kat): ?>
                                                        <option value="<?= $kat['id_kategori'] ?>" 
                                                                <?= ($kat['id_kategori'] == $data_buku['id_kategori']) ? 'selected' : '' ?>>
                                                            <?= $kat['nama_kategori'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Rak <span class="text-danger">*</span></label>
                                            <select name="rak" class="form-control" required>
                                                <option value="">-- Pilih Rak --</option>
                                                <?php if (!empty($rak)): ?>
                                                    <?php foreach ($rak as $r): ?>
                                                        <option value="<?= $r['id_rak'] ?>" 
                                                                <?= ($r['id_rak'] == $data_buku['id_rak']) ? 'selected' : '' ?>>
                                                            <?= $r['nama_rak'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Stok <span class="text-danger">*</span></label>
                                            <input type="number" name="stok" class="form-control" 
                                                   value="<?= $data_buku['stok'] ?>"
                                                   placeholder="Masukkan jumlah stok" required min="0">
                                        </div>

                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control" rows="4" 
                                                      placeholder="Masukkan deskripsi buku (opsional)"><?= $data_buku['deskripsi'] ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fa fa-save"></i> Update Data
                                        </button>
                                        <a href="<?= base_url('admin/master-data-buku') ?>" class="btn btn-default">
                                            <i class="fa fa-arrow-left"></i> Kembali
                                        </a>
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
