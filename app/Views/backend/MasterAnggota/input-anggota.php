<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard-admin') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
            <li><a href="<?= base_url('admin/master-data-anggota') ?>">Master Data Anggota</a></li>
            <li class="active">Input Data Anggota</li>
        </ol>
    </div><!--/.row-->
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Input Data Anggota</h3>
                    <hr />
                    <form action="<?= base_url('admin/simpan-anggota'); ?>" method="post">
                        <div class="form-group col-md-6">
                            <label>Nama Anggota</label>
                            <input type="text" class="form-control" name="nama_anggota" placeholder="Masukkan Nama Anggota" 
                                   value="<?= old('nama_anggota') ?>" required="required">
                            <?php if(isset($validation) && $validation->hasError('nama_anggota')): ?>
                                <small class="text-danger"><?= $validation->getError('nama_anggota') ?></small>
                            <?php endif; ?>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email Anggota" 
                                   value="<?= old('email') ?>" required="required">
                            <?php if(isset($validation) && $validation->hasError('email')): ?>
                                <small class="text-danger"><?= $validation->getError('email') ?></small>
                            <?php endif; ?>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Nomor Telepon</label>
                            <input type="text" class="form-control" name="no_tlp" placeholder="Masukkan Nomor Telepon" 
                                   value="<?= old('no_tlp') ?>" required="required">
                            <?php if(isset($validation) && $validation->hasError('no_tlp')): ?>
                                <small class="text-danger"><?= $validation->getError('no_tlp') ?></small>
                            <?php endif; ?>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-6">
                            <label>Jenis Kelamin</label>
                            <select class="form-control" name="jenis_kelamin" required="required">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                            <?php if(isset($validation) && $validation->hasError('jenis_kelamin')): ?>
                                <small class="text-danger"><?= $validation->getError('jenis_kelamin') ?></small>
                            <?php endif; ?>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-12">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap" required="required"><?= old('alamat') ?></textarea>
                            <?php if(isset($validation) && $validation->hasError('alamat')): ?>
                                <small class="text-danger"><?= $validation->getError('alamat') ?></small>
                            <?php endif; ?>
                        </div>
                        <div style="clear:both;"></div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Simpan Data
                            </button>
                            <a href="<?= base_url('admin/master-data-anggota'); ?>" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div><!--/.main-->
