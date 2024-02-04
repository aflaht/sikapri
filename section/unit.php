<div class="card shadow">
    <!-- Query Tabel User -->
    <?php
        $sql_unit_get = mysqli_query($koneksi, "SELECT * FROM unit");        
    ?>
    <!-- ================= -->
    <div class="card-header">
        <h4>Tabel Unit</h4>
    </div>
    <div class="card-body">
        <div class="mb-3 d-flex justify-content-end">
            <div class="mx-1">
                <button type="button" data-toggle="modal" data-target="#formDelete-unit" class="btn btn-danger"><i class="fa fa-dumpster-fire"></i> Bersihkan data</button>
            </div>
            <div class="mx-1">
                <button type="button" data-toggle="modal" data-target="#formModalUnit" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> Tambah unit</button>                                                    
            </div>
            <div class="mx-1">
                <button type="button" id="undo_unit" data-toggle="modal" data-target="" class="btn btn-info btn-xs"><i class="fa fa-undo-alt"></i></button>                                                 
            </div>
        </div>       
        <table id="table-unit" class="table display nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>KDPR</th>
                    <th>Nama Unit</th>                                                                              
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no=0;
                    while ($rowu = mysqli_fetch_array($sql_unit_get)){
                        $no++;
                ?>  
                    <tr>                        
                        <th class="align-middle"><?php echo $no;?></th>
                        <td class="text-capitalize align-middle"><?php echo $rowu['kdpr'];?></td>
                        <td class="align-middle"><?php echo $rowu['nama_unit'];?></td>                    
                        <td class="text-center">
                            <a id="edit_unit" data-toggle="modal" data-target="#formModal_editUnit"                             
                                data-nama_unit = "<?php echo $rowu['nama_unit'];?>"                                                                                                
                                data-kdpr = "<?php echo $rowu['kdpr'];?>"                                
                                class="btn tw btn-info">
                                <i class="fa fa-edit"></i>                                
                            </a>
                            <a id="delete_unit"                            
                            data-kdpr = "<?php echo $rowu['kdpr'];?>"
                            
                            class="btn tw btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>                            
                        </td>
                    </tr>                                              
                        
                    <?php
                    }//endwhile
                    mysqli_free_result($sql_unit_get);
                ?>
            </tbody>              
        </table>         
    </div>
</div>

<!-- MULAI MODAL TAMBAH UNIT-->
<div id="formModalUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Tambah Unit</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Isi form untuk menambah unit.</p>
            <form method="POST">
                    <div class="form-group">
                        <label>Nama Unit</label>
                        <input type="text" name="nama_unit" placeholder="" class="form-control" required>
                    </div>
                    <div class="form-group">       
                        <label>KDPR</label>
                        <input type="text" name="kdpr" id="uKdpr" placeholder="" class="form-control" required>
                        <span class="status-available" id="unit-availability-status"></span>
                        <div class="text-center"><p><img src="img/loading.gif" id="loaderIconUnit" style="display:none" class="mini pt-2"/></p></div>                        
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary" >                                                
                </div>
                </div>
            </form>
    </div>
</div>
<!-- MULAI MODAL BERSIHKAN DATA-->
<div id="formDelete-unit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Bersihkan Data</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Membersihkan semua data unit</p>                        
            <a id="delAll" href="dashboard.php?section=delAllUnit" class="btn tw btn-danger btn-xs mb-2"><i class="fa fa-trash pr-2"></i>Hapus semua</a>                                
                <div class="modal-footer">                    
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>                                                
            </div>
        </div>                             
    </div>
</div>

<?php
if(isset($_POST['simpan'])){    
    $nama = $_POST['nama_unit'];   
    $kdpr = $_POST['kdpr'];

    $sql_add_unit = mysqli_query($koneksi, "INSERT INTO unit(kdpr, nama_unit) VALUES ('$kdpr','$nama')");        

    if(!$sql_add_unit){
        die("Gagal input data : ".$koneksi->error);
    }else{
        //log activity
        $no_anggota = $row2["no_anggota"];
        $activity = "edit unit->".$nama;
        $time = date("Y-m-d H:i:s");
        $log_sql = $koneksi->query("INSERT INTO activity_log(id, no_anggota, activity, time) VALUES('', '$no_anggota', '$activity', '$time')");

        ?>                                            
            <script type="text/javascript">
                alert("Berhasil Menambah Data Unit");
                window.location.href="dashboard.php?section=unit";
            </script>
        <?php
    }
}
?>