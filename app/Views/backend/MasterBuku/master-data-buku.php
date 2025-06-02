<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
   <div class="row">
       <ol class="breadcrumb">
           <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
           <li class="active">Data Buku</li>
       </ol>
   </div><!--/.row-->

   <div class="row">
       <div class="col-lg-12">
           <div class="panel panel-default">
               <div class="panel-body">
                   <h3>Data Buku
                       <a href="<?= base_url('admin/input-buku');?>"><button type="button" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Data Buku</button></a>
                   </h3>
                   <hr />
                   <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                       <thead>
                           <tr>
                               <th data-sortable="true">No</th>
                               <th data-sortable="true">Cover Buku</th>
                               <th data-sortable="true">Judul Buku</th>
                               <th data-sortable="true">Pengarang</th>
                               <th data-sortable="true">Penerbit</th>
                               <th data-sortable="true">Tahun</th>
                               <th data-sortable="true">Jumlah Eksemplar</th>
                               <th data-sortable="true">Kategori Buku</th>
                               <th data-sortable="true">Keterangan</th>
                               <th data-sortable="true">Rak</th>
                               <th data-sortable="true">Opsi</th>
                           </tr>
                       </thead>
                       <tbody>
                            <?php
                            $no = 0;
                            foreach($dataBuku as $data) {
                            ?>
                            <tr>
                                <td data-sortable="true"><?= $no=$no+1;?></td>
                                <td data-sortable="true">
                                    <?php if(!empty($data['cover_buku']) && file_exists('assets/cover_buku/'.$data['cover_buku'])): ?>
                                        <img src="<?= base_url('assets/cover_buku/'.$data['cover_buku']); ?>" alt="Cover Buku" style="width: 50px; height: 70px; object-fit: cover;">
                                    <?php else: ?>
                                        <span class="text-muted">No Cover</span>
                                    <?php endif; ?>
                                </td>
                                <td data-sortable="true"><?= $data['judul_buku'];?></td>
                                <td data-sortable="true"><?= $data['pengarang'];?></td>
                                <td data-sortable="true"><?= $data['penerbit'];?></td>
                                <td data-sortable="true"><?= $data['tahun_terbit'];?></td>
                                <td data-sortable="true"><?= $data['jumlah_buku'];?></td>
                                <td data-sortable="true"><?= $data['nama_kategori'];?></td>
                                <td data-sortable="true"><?= $data['keterangan'];?></td>
                                <td data-sortable="true"><?= $data['nama_rak'];?></td>
                                <td data-sortable="true">
                                    <?php
                                    if(session()->get('ses_level')=="1") {
                                    ?>
                                    <a href="<?= base_url('admin/edit-buku/'.sha1($data['id_buku']));?>"><button type="button" class="btn btn-sm btn-success">Edit</button></a>
                                    <a href="#" onclick="doDelete('<?= sha1($data['id_buku']);?>')"><button type="button" class="btn btn-sm btn-danger">Hapus</button></a>
                                    <?php } 
                                    else echo "#"; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div><!--/.main-->

<script type="text/javascript">
    function doDelete(idDelete){
        swal({
            title : "Hapus Data Buku?",
            text : "Data ini akan terhapus secara permanen!!",
            icon : "warning",
            buttons : true,
            dangerMode : false,
        })
        .then(ok => {
            if(ok){
                window.location.href = '<?= base_url(); ?>/admin/hapus-buku/' + idDelete;
            }
            else{
                $(this).removeAttr('disabled')
            }
        })
    }
</script>