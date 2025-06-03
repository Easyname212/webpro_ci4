<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Buku;
use App\Models\M_Rak;
use App\Models\M_Kategori;
use App\Models\M_Anggota;

class Admin extends BaseController
{
    public function login()
    {
        return view('backend/Login/login');
    }    public function dashboard()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        else{
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/Login/dashboard_admin');
            echo view('Backend/Template/footer');
        }
    }public function autentikasi() 
    {
        $modelAdmin = new M_Admin(); // proses inisiasi model
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Debug: cek apakah data terkirim
        if (empty($username) || empty($password)) {
            session()->setFlashdata('error', 'Username dan Password harus diisi!');
            return redirect()->to('admin/login-admin');
        }

        $cekUsername = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getNumRows();
        if ($cekUsername == 0) {
            session()->setFlashdata('error', 'Username Tidak Ditemukan!');
            return redirect()->to('admin/login-admin');
        }
        else {
            $dataUser = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getRowArray();
            $passwordUser = $dataUser['password_admin'];

            $verifikasiPassword = password_verify($password, $passwordUser);
            if (!$verifikasiPassword) {
                session()->setFlashdata('error', 'Password Tidak Sesuai!');
                return redirect()->to('admin/login-admin');
            }
            else {
                $dataSession = [
                    'ses_id' => $dataUser['id_admin'],
                    'ses_user' => $dataUser['nama_admin'],
                    'ses_level' => $dataUser['akses_level']
                ];
                session()->set($dataSession);
                session()->setFlashdata('success', 'Login Berhasil!');
                return redirect()->to('admin/dashboard-admin');
            }
        }
    }
      public function logout()
    {
        session()->remove('ses_id');
        session()->remove('ses_user');
        session()->remove('ses_level');
        session()->setFlashdata('info','Anda telah keluar dari sistem!');
        ?>
        <script>
            document.location = "<?= base_url('admin/login-admin');?>";
        </script>
        <?php
    }
      public function master_data_admin(){
        if(session()->get('ses_id')=="" or session()->get('ses_user')=="" or session()->get('ses_level')==""){
            session()->setFlashdata('error','silakan login terlebih dahulu!');
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin');?>";
            </script>
            <?php
        }
        else{
            $modelAdmin = new M_Admin; // inisiasi

            $uri = service('uri');
            $pages = $uri->getSegment(2);
            $dataUser = $modelAdmin->getDataAdmin(['is_delete_admin' => '0', 'akses_level !=' => '1'])->getResultArray();

            $data['pages'] = $pages;
            $data['data_user'] = $dataUser;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAdmin/master-data-admin', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_data_admin(){
        if(session()->get('ses_id')=="" or session()->get('ses_user')=="" or session()->get('ses_level')==""){
            session()->setFlashdata('error','silakan login terlebih dahulu!');
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin');?>";
            </script>
            <?php
        }
        else{
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterAdmin/input-admin');
            echo view('Backend/Template/footer');
        }
    }

    public function simpan_data_admin(){
        if(session()->get('ses_id')=="" or session()->get('ses_user')=="" or session()->get('ses_level')==""){
            session()->setFlashdata('error','silakan login terlebih dahulu!');
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin');?>";
            </script>
            <?php
        }
        else{
            $modelAdmin = new M_Admin; // inisiasi

            $nama = $this->request->getPost('nama');
            $username = $this->request->getPost('username');
            $level = $this->request->getPost('level');

            $cekUname = $modelAdmin->getDataAdmin(['username_admin' => $username])->getNumRows();
            if($cekUname > 0){
                session()->setFlashdata('error','Username sudah digunakan!');
                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
            }
            else{
                $hasil = $modelAdmin->autoNumber()->getRowArray();
                if(!$hasil){
                    $id = "ADM001";
                }
                else{
                    $kode = $hasil['id_admin'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = "ADM".sprintf("%03s", $noUrut);
                }

                $dataSimpan = [
                    'id_admin' => $id,
                    'nama_admin' => $nama,
                    'username_admin' => $username,
                    'password_admin' => password_hash('pass_admin', PASSWORD_DEFAULT),
                    'akses_level' => $level,
                    'is_delete_admin' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $modelAdmin->saveDataAdmin($dataSimpan);
                session()->setFlashdata('success','Data Admin Berhasil Ditambahkan!!');
                ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-admin');?>";
                </script>
                <?php
            }
        }
    }

    public function edit_data_admin()
    {
        $uri = service('uri');
        $idEdit = $uri->getSegment(3);
        $modelAdmin = new M_Admin;

        // Mengambil data admin dari table admin di database berdasarkan parameter yang dikirimkan
        $dataAdmin = $modelAdmin->getDataAdmin(['sha1(id_admin)' => $idEdit])->getRowArray();
        session()->set(['idUpdate' => $dataAdmin['id_admin']]);

        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Edit Data Admin";
        $data['data_admin'] = $dataAdmin; // mengirim array data admin ke view

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAdmin/edit-admin', $data);
        echo view('Backend/Template/footer', $data);
    }    
    
    public function update_data_admin()
    {
        $modelAdmin = new M_Admin;

        $idUpdate = session()->get('idUpdate');
        $nama = $this->request->getPost('nama');
        $level = $this->request->getPost('level');

        if($nama=="" or $level==""){
            session()->setFlashdata('error','Isian tidak boleh kosong!!');
    ?>
    <script>
        history.go(-1);
    </script>
    <?php
        }
        else{
            $dataUpdate = [
                'nama_admin' => $nama,
                'akses_level' => $level,
                'updated_at' => date("y-m-d H:i:s")
            ];
            $whereUpdate = ['id_admin' => $idUpdate];

            $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
            session()->remove('idUpdate');
            session()->setFlashdata('success','Data Admin Berhasil Diperbaharui!');
    ?>
    <script>
        document.location = "<?= base_url('admin/master-data-admin');?>";
    </script>
    <?php
        }
    }

    public function hapus_data_admin()
    {
        $modelAdmin = new M_Admin;

        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataUpdate = [
            'is_delete_admin' => '1',
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $whereUpdate = ['sha1(id_admin)' => $idHapus];
        $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
        session()->setFlashdata('success','Data Admin Berhasil Dihapus!');
    ?>
    <script>
        document.location = "<?= base_url('admin/master-data-admin');?>";
    </script>
    <?php    }
    // Akhir modul admin    // Awal Modul Buku
    public function master_buku()
    {
        $modelBuku = new M_Buku;

        // Mengambil data keseluruhan buku dari table buku di database
        $dataBuku = $modelBuku->getDataBukuJoin(['tbl_buku.is_delete_buku' => '0'])->getResultArray();

        $uri = service('uri');
        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Master Data Buku";
        $data['dataBuku'] = $dataBuku; // mengirim array data buku ke view

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterBuku/master-data-buku', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function input_data_buku(){
        if(session()->get('ses_id')=="" or session()->get('ses_user')=="" or session()->get('ses_level')==""){
            session()->setFlashdata('error','silakan login terlebih dahulu!');
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin');?>";
            </script>
            <?php
        }        else{
            $modelKategori = new M_Kategori;
            $modelRak = new M_Rak;
            
            $dataKategori = $modelKategori->findAll();
            $dataRak = $modelRak->findAll();

            $data['kategori'] = $dataKategori;
            $data['rak'] = $dataRak;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterBuku/input-buku', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function simpan_data_buku(){
        if(session()->get('ses_id')=="" or session()->get('ses_user')=="" or session()->get('ses_level')==""){
            session()->setFlashdata('error','silakan login terlebih dahulu!');
            ?>
            <script>
                document.location = "<?= base_url('admin/login-admin');?>";
            </script>
            <?php
        }
        else{
            $modelBuku = new M_Buku; // inisiasi

            $judul = $this->request->getPost('judul');
            $pengarang = $this->request->getPost('pengarang');
            $penerbit = $this->request->getPost('penerbit');
            $tahun = $this->request->getPost('tahun');
            $kategori = $this->request->getPost('kategori');
            $rak = $this->request->getPost('rak');
            $stok = $this->request->getPost('stok');
            $deskripsi = $this->request->getPost('deskripsi');

            if($judul=="" or $pengarang=="" or $kategori=="" or $rak=="" or $stok==""){
                session()->setFlashdata('error','Isian wajib tidak boleh kosong!');
                ?>
                <script>
                    history.go(-1);
                </script>
                <?php
            }
            else{
                // Proses upload file cover buku
                $coverBuku = $this->request->getFile('cover_buku');
                $ext1 = $coverBuku->getClientExtension();
                $namaFile1 = "Cover-Buku-".date("ymdHis").".".$ext1;
                $coverBuku->move('Assets/CoverBuku', $namaFile1);

                // Proses upload file e-book
                $eBook = $this->request->getFile('e_book');
                $ext2 = $eBook->getClientExtension();
                $namaFile2 = "E-Book-".date("ymdHis").".".$ext2;
                $eBook->move('Assets/E-Book', $namaFile2);

                // Auto number
                $hasil = $modelBuku->autoNumber()->getRowArray();
                if(!$hasil){
                    $id = "BKU001";
                }
                else{
                    $kode = $hasil['id_buku'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = "BKU".sprintf("%03s", $noUrut);
                }

                $dataSimpan = [
                    'id_buku' => $id,
                    'judul_buku' => ucwords($judul),
                    'pengarang' => ucwords($pengarang),
                    'penerbit' => ucwords($penerbit),
                    'tahun' => $tahun,
                    'jumlah_eksemplar' => $stok,
                    'id_kategori' => $kategori,
                    'keterangan' => $deskripsi,
                    'id_rak' => $rak,
                    'cover_buku' => $namaFile1,
                    'e_book' => $namaFile2,
                    'is_delete_buku' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $modelBuku->saveDataBuku($dataSimpan);
                session()->setFlashdata('success', 'Data Buku Berhasil Diperbaharui!');
                ?>
                <script>
                    document.location = "<?= base_url('admin/master-buku'); ?>";
                </script>
                <?php
            }
        }
    }

    public function edit_data_buku()
    {
        $uri = service('uri');        $idEdit = $uri->getSegment(3);
        $modelBuku = new M_Buku;
        $modelKategori = new M_Kategori;
        $modelRak = new M_Rak;

        // Mengambil data buku dari table buku di database berdasarkan parameter yang dikirimkan
        $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idEdit])->getRowArray();
        $dataKategori = $modelKategori->findAll();
        $dataRak = $modelRak->findAll();
        
        session()->set(['idUpdate' => $dataBuku['id_buku']]);

        $page = $uri->getSegment(2);

        $data['page'] = $page;
        $data['web_title'] = "Edit Data Buku";
        $data['data_buku'] = $dataBuku;
        $data['kategori'] = $dataKategori;
        $data['rak'] = $dataRak;

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterBuku/edit-buku', $data);
        echo view('Backend/Template/footer', $data);
    }    
    
    public function update_data_buku()
    {
        $modelBuku = new M_Buku;
        $idUpdate = session()->get('idUpdate');
        
        $judul = $this->request->getPost('judul');
        $pengarang = $this->request->getPost('pengarang');
        $penerbit = $this->request->getPost('penerbit');
        $tahun = $this->request->getPost('tahun');
        $kategori = $this->request->getPost('kategori');
        $rak = $this->request->getPost('rak');
        $stok = $this->request->getPost('stok');
        $deskripsi = $this->request->getPost('deskripsi');

        if($judul=="" or $pengarang=="" or $kategori=="" or $rak=="" or $stok==""){
            session()->setFlashdata('error','Isian wajib tidak boleh kosong!!');
    ?>
    <script>
        history.go(-1);
    </script>
    <?php
        }
        else{
            $dataUpdate = [
                'judul_buku' => $judul,
                'pengarang' => $pengarang,
                'penerbit' => $penerbit,
                'tahun_terbit' => $tahun,
                'id_kategori' => $kategori,
                'id_rak' => $rak,
                'stok' => $stok,
                'deskripsi' => $deskripsi,
                'updated_at' => date("y-m-d H:i:s")
            ];
            $whereUpdate = ['id_buku' => $idUpdate];

            $modelBuku->updateDataBuku($dataUpdate, $whereUpdate);
            session()->remove('idUpdate');
            session()->setFlashdata('pesan','Data Buku Berhasil Diperbaharui!');
    ?>
    <script>
        document.location = "<?= base_url('admin/master-data-buku');?>";
    </script>
    <?php
        }
    }

    public function hapus_data_buku()
    {
        $modelBuku = new M_Buku;

        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataUpdate = [
            'is_delete_buku' => '1',
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $whereUpdate = ['sha1(id_buku)' => $idHapus];
        $modelBuku->updateDataBuku($dataUpdate, $whereUpdate);
        session()->setFlashdata('pesan','Data Buku Berhasil Dihapus!');
    ?>
    <script>
        document.location = "<?= base_url('admin/master-data-buku');?>";
    </script>
    <?php
    }

    public function input_buku()
    {
        $modelKategori = new M_Kategori;
        $modelRak = new M_Rak;
        $uri = service('uri');
        $page = $uri->getSegment(2);

        $data['page'] = $page;        $data['web_title'] = "Input Data Buku";
        $data['data_kategori'] = $modelKategori->findAll();
        $data['data_rak'] = $modelRak->findAll();

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterBuku/input-buku', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function simpan_buku()
    {
        $modelBuku = new M_Buku;

        $judulBuku = $this->request->getPost('judul_buku');
        $pengarang = $this->request->getPost('pengarang');
        $penerbit = $this->request->getPost('penerbit');
        $tahun = $this->request->getPost('tahun');
        $jumlahEksemplar = $this->request->getPost('jumlah_eksemplar');
        $kategoriBuku = $this->request->getPost('kategori_buku');
        $keterangan = $this->request->getPost('keterangan');
        $rak = $this->request->getPost('rak');

        if(!$this->validate([
            'cover_buku' => 'uploaded[cover_buku]|max_size[cover_buku,1024]|ext_in[cover_buku,jpg,jpeg,png]',
        ])){
            session()->setFlashdata('error', "Format file yang diizinkan : jpg, jpeg, png dengan maksimal ukuran 1 MB");
            return redirect()->to('/admin/input-buku')->withInput();
        }

        if(!$this->validate([
            'e_book' => 'uploaded[e_book]|max_size[e_book,10240]|ext_in[e_book,pdf]',
        ])){
            session()->setFlashdata('error', "Format file yang diizinkan : pdf dengan maksimal ukuran 10 MB");
            return redirect()->to('/admin/input-buku')->withInput();
        }

        // Proses upload file cover buku
        $coverBuku = $this->request->getFile('cover_buku');
        $ext1 = $coverBuku->getClientExtension();
        $namaFile1 = "Cover-Buku-".date("ymdHis").".".$ext1;
        $coverBuku->move('Assets/CoverBuku', $namaFile1);

        // Proses upload file e-book
        $eBook = $this->request->getFile('e_book');
        $ext2 = $eBook->getClientExtension();
        $namaFile2 = "E-Book-".date("ymdHis").".".$ext2;
        $eBook->move('Assets/E-Book', $namaFile2);

        // Auto number
        $hasil = $modelBuku->autoNumber()->getRowArray();
        if(!$hasil){
            $id = "BKU001";
        }
        else{
            $kode = $hasil['id_buku'];
            $noUrut = (int) substr($kode, -3);
            $noUrut++;
            $id = "BKU".sprintf("%03s", $noUrut);
        }

        $dataSimpan = [
            'id_buku' => $id,
            'judul_buku' => ucwords($judulBuku),
            'pengarang' => ucwords($pengarang),
            'penerbit' => ucwords($penerbit),
            'tahun' => $tahun,
            'jumlah_eksemplar' => $jumlahEksemplar,
            'id_kategori' => $kategoriBuku,
            'keterangan' => $keterangan,
            'id_rak' => $rak,
            'cover_buku' => $namaFile1,
            'e_book' => $namaFile2,
            'is_delete_buku' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $modelBuku->saveDataBuku($dataSimpan);
        session()->setFlashdata('success', 'Data Buku Berhasil Diperbaharui!');
        ?>
        <script>
            document.location = "<?= base_url('admin/master-buku'); ?>";
        </script>
        <?php
    }

    public function hapus_buku()
    {
        $modelBuku = new M_Buku;

        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataHapus = $modelBuku->getDataBuku(['id_buku' => $idHapus])->getRowArray();
        unlink('Assets/CoverBuku/'.$dataHapus['cover_buku']); // hapus file yang lama
        unlink('Assets/E-Book/'.$dataHapus['e_book']); // hapus file yang lama

        $modelBuku->hapusDataBuku(['id_buku' => $idHapus]);
        session()->setFlashdata('success', 'Data Buku Berhasil Dihapus!');
        ?>
        <script>
            document.location = "<?= base_url('admin/master-buku'); ?>";
        </script>
        <?php
    }    // ================= MASTER RAK =================
    public function master_rak()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        $modelRak = new M_Rak;
        $data['dataRak'] = $modelRak->findAll();

        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('Backend/MasterRak/master-data-rak', $data);
        echo view('Backend/Template/footer');
    }    public function input_rak()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('backend/MasterRak/input-rak');
        echo view('Backend/Template/footer');
    }    public function simpan_rak()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        $modelRak = new M_Rak;

        // Auto generate kode rak
        $lastData = $modelRak->orderBy('id_rak', 'DESC')->first();
        $lastNumber = $lastData ? (int)substr($lastData['kode_rak'], 3) : 0;
        $newNumber = $lastNumber + 1;
        $kodeRak = 'RAK' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $data = [
            'kode_rak' => $kodeRak,
            'nama_rak' => ucwords($this->request->getPost('nama_rak')),
            'lokasi' => ucwords($this->request->getPost('lokasi')),
            'keterangan' => ucwords($this->request->getPost('keterangan'))
        ];

        $modelRak->simpanDataRak($data);        session()->setFlashdata('success', 'Data Rak Berhasil Disimpan!');
        ?>
        <script>
            document.location = "<?= base_url('admin/master-data-rak'); ?>";
        </script>
        <?php
    }    public function edit_rak()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        $modelRak = new M_Rak;

        $uri = service('uri');
        $idEdit = $uri->getSegment(3);

        // Decrypt SHA1 encoded ID
        $allRak = $modelRak->findAll();
        $dataEdit = null;
        
        foreach ($allRak as $rak) {
            if (sha1($rak['id_rak']) === $idEdit) {
                $dataEdit = $rak;
                break;
            }
        }

        if (!$dataEdit) {
            session()->setFlashdata('error', 'Data Rak tidak ditemukan!');
            return redirect()->to('admin/master-data-rak');
        }

        $data['dataEdit'] = $dataEdit;

        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('backend/MasterRak/edit-rak', $data);
        echo view('Backend/Template/footer');
    }    public function update_rak()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        $modelRak = new M_Rak;

        $idUpdate = $this->request->getPost('id_rak');
        $data = [
            'nama_rak' => ucwords($this->request->getPost('nama_rak')),
            'lokasi' => ucwords($this->request->getPost('lokasi')),
            'keterangan' => ucwords($this->request->getPost('keterangan'))
        ];

        $modelRak->ubahDataRak($data, ['id_rak' => $idUpdate]);        session()->setFlashdata('success', 'Data Rak Berhasil Diupdate!');
        ?>
        <script>
            document.location = "<?= base_url('admin/master-data-rak'); ?>";
        </script>
        <?php
    }    public function hapus_rak()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        $modelRak = new M_Rak;

        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        // Decrypt SHA1 encoded ID
        $allRak = $modelRak->findAll();
        $dataHapus = null;
        
        foreach ($allRak as $rak) {
            if (sha1($rak['id_rak']) === $idHapus) {
                $dataHapus = $rak;
                break;
            }
        }

        if (!$dataHapus) {
            session()->setFlashdata('error', 'Data Rak tidak ditemukan!');
        } else {
            $modelRak->hapusDataRak(['id_rak' => $dataHapus['id_rak']]);
            session()->setFlashdata('success', 'Data Rak Berhasil Dihapus!');
        }
        ?>
        <script>
            document.location = "<?= base_url('admin/master-data-rak'); ?>";
        </script>
        <?php
    }// ================= MASTER KATEGORI =================
    public function master_kategori()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        $modelKategori = new M_Kategori;
        $data['dataKategori'] = $modelKategori->findAll();

        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('Backend/MasterKategori/master-data-kategori', $data);
        echo view('Backend/Template/footer');
    }

    public function input_kategori()
    {
        return view('backend/MasterKategori/input-kategori');
    }

    public function simpan_kategori()
    {
        $modelKategori = new M_Kategori;

        // Auto generate kode kategori
        $lastData = $modelKategori->orderBy('id_kategori', 'DESC')->first();
        $lastNumber = $lastData ? (int)substr($lastData['kode_kategori'], 3) : 0;
        $newNumber = $lastNumber + 1;
        $kodeKategori = 'KAT' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $data = [
            'kode_kategori' => $kodeKategori,
            'nama_kategori' => ucwords($this->request->getPost('nama_kategori')),
            'keterangan' => ucwords($this->request->getPost('keterangan'))
        ];

        $modelKategori->simpanDataKategori($data);
        session()->setFlashdata('success', 'Data Kategori Berhasil Disimpan!');
        ?>
        <script>
            document.location = "<?= base_url('admin/master-kategori'); ?>";
        </script>
        <?php
    }    public function edit_kategori()
    {
        $modelKategori = new M_Kategori;

        $uri = service('uri');
        $idEdit = $uri->getSegment(3);

        $data['dataEdit'] = $modelKategori->where('id_kategori', $idEdit)->first();

        return view('backend/MasterKategori/edit-kategori', $data);
    }

    public function update_kategori()
    {
        $modelKategori = new M_Kategori;

        $idUpdate = $this->request->getPost('id_kategori');
        $data = [
            'nama_kategori' => ucwords($this->request->getPost('nama_kategori')),
            'keterangan' => ucwords($this->request->getPost('keterangan'))
        ];

        $modelKategori->ubahDataKategori($data, ['id_kategori' => $idUpdate]);
        session()->setFlashdata('success', 'Data Kategori Berhasil Diupdate!');
        ?>
        <script>
            document.location = "<?= base_url('admin/master-kategori'); ?>";
        </script>
        <?php
    }

    public function hapus_kategori()
    {
        $modelKategori = new M_Kategori;

        $uri = service('uri');
        $idHapus = $uri->getSegment(3);

        $modelKategori->hapusDataKategori(['id_kategori' => $idHapus]);        session()->setFlashdata('success', 'Data Kategori Berhasil Dihapus!');
        return redirect()->to('admin/master-kategori');
    }

    // ================= MASTER ANGGOTA =================
    public function master_anggota()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        $modelAnggota = new M_Anggota;
        
        // Gunakan method CodeIgniter standard yang lebih simple
        $dataAnggota = $modelAnggota->orderBy('nama_anggota', 'ASC')->findAll();
        
        // Debug: Tampilkan jumlah data
        session()->setFlashdata('info', 'Jumlah data anggota: ' . count($dataAnggota));
        
        $data['dataAnggota'] = $dataAnggota;        echo view('backend/template/header');
        echo view('backend/template/sidebar');
        echo view('backend/MasterAnggota/master-data-anggota', $data);
        echo view('backend/template/footer');
    }

    public function input_anggota()
    {
        // Cek session login
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }        echo view('backend/template/header');
        echo view('backend/template/sidebar');
        echo view('backend/MasterAnggota/input-anggota');
        echo view('backend/template/footer');
    }

    public function simpan_anggota()
    {
        $modelAnggota = new M_Anggota;
        
        try {
            $data = [
                'nama_anggota' => $this->request->getPost('nama_anggota'),
                'email' => $this->request->getPost('email'),  
                'no_tlp' => $this->request->getPost('no_tlp'),
                'alamat' => $this->request->getPost('alamat'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin')
            ];

            $result = $modelAnggota->simpanDataAnggota($data);
            
            if($result) {
                session()->setFlashdata('success', 'Data berhasil disimpan!');
            } else {
                session()->setFlashdata('error', 'Gagal menyimpan data!');
            }
            
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());        }
        
        return redirect()->to('admin/master-data-anggota');
    }

    public function edit_anggota()
    {
        // Cek session login
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        $modelAnggota = new M_Anggota;

        $uri = service('uri');
        $hashId = $uri->getSegment(3);
        
        // Cari data berdasarkan hash SHA1
        $allData = $modelAnggota->findAll();
        $dataEdit = null;
        
        foreach($allData as $row) {
            if(sha1($row['id_anggota']) == $hashId) {
                $dataEdit = $row;
                break;
            }
        }
        
        if(!$dataEdit) {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
            return redirect()->to('admin/master-data-anggota');
        }
        
        $data['dataEdit'] = $dataEdit;

        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('Backend/MasterAnggota/edit-anggota', $data);
        echo view('Backend/Template/footer');
    }

    public function update_anggota()
    {
        // Cek session login
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        $modelAnggota = new M_Anggota;
        $idUpdate = $this->request->getPost('id_anggota');
        $dataUpdate = [
            'nama_anggota' => ucwords($this->request->getPost('nama_anggota')),
            'email' => $this->request->getPost('email'),
            'no_tlp' => $this->request->getPost('no_tlp'),
            'alamat' => ucwords($this->request->getPost('alamat')),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin')
        ];
        $modelAnggota->ubahDataAnggota($dataUpdate, ['id_anggota' => $idUpdate]);        session()->setFlashdata('success', 'Data Anggota Berhasil Diupdate!');
        return redirect()->to('admin/master-data-anggota');
    }

    public function hapus_anggota()
    {
        // Cek session login
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')===""){
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('admin/login-admin');
        }
        
        $modelAnggota = new M_Anggota;

        $uri = service('uri');
        $hashId = $uri->getSegment(3);
        
        // Cari ID asli berdasarkan hash SHA1
        $allData = $modelAnggota->findAll();
        $idHapus = null;
        
        foreach($allData as $row) {
            if(sha1($row['id_anggota']) == $hashId) {
                $idHapus = $row['id_anggota'];
                break;
            }
        }
        
        if($idHapus) {
            $modelAnggota->hapusDataAnggota(['id_anggota' => $idHapus]);
            session()->setFlashdata('success', 'Data Anggota Berhasil Dihapus!');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
        }
        
        return redirect()->to('admin/master-data-anggota');
    }
}
