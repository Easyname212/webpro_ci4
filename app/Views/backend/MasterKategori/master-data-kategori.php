<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
   <div class="row">
       <ol class="breadcrumb">
           <li><a href="<?= base_url('admin/dashboard-admin') ?>"><span class="glyphicon glyphicon-home"></span></a></li>
           <li class="active">Master Data Kategori</li>
       </ol>
   </div><!--/.row-->

   <div class="row">
       <div class="col-lg-12">
           <div class="panel panel-default">
               <div class="panel-body">                   <h3>Master Data Kategori
                       <a href="<?= base_url('admin/input-kategori');?>"><button type="button" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Input Data Kategori</button></a>
                   </h3>
                   <hr />
                   <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                       <thead>
                           <tr>
                               <th data-sortable="true">No</th>
                               <th data-sortable="true">Kode Kategori</th>
                               <th data-sortable="true">Nama Kategori</th>
                               <th data-sortable="true">Keterangan</th>
                               <th data-sortable="true">Opsi</th>
                           </tr>
                       </thead>
                       <tbody>
                            <?php
                            $no = 0;
                            foreach($dataKategori as $data) {
                            ?>
                            <tr>
                                <td data-sortable="true"><?= $no=$no+1;?></td>
                                <td data-sortable="true"><?= $data['kode_kategori'];?></td>
                                <td data-sortable="true"><?= $data['nama_kategori'];?></td>
                                <td data-sortable="true"><?= $data['keterangan'];?></td>
                                <td data-sortable="true">
                                    <?php
                                    if(session()->get('ses_level')=="1") {
                                    ?>
                                    <a href="<?= base_url('admin/edit-kategori/'.sha1($data['id_kategori']));?>"><button type="button" class="btn btn-sm btn-success">Edit</button></a>
                                    <a href="#" onclick="doDelete('<?= sha1($data['id_kategori']);?>')"><button type="button" class="btn btn-sm btn-danger">Hapus</button></a>                                    <?php } 
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
            title : "Hapus Data Kategori?",
            text : "Data ini akan terhapus secara permanen!!",
            icon : "warning",
            buttons : true,
            dangerMode : false,
        })
        .then(ok => {
            if(ok){
                window.location.href = '<?= base_url(); ?>/admin/hapus-kategori/' + idDelete;
            }
            else{
                $(this).removeAttr('disabled')
            }
        })
    }
</script>
