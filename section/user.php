<div class="card shadow mb-4">
    <!-- Query Tabel User -->
    <?php
        $sql_user_get = mysqli_query($koneksi, "SELECT * FROM user u JOIN unit t ON t.kdpr=u.kdpr");        
    ?>
    <!-- ================= -->
    <div class="card-header">
        <h4>Tabel User</h4>
    </div>
    <div class="card-body">
        <div class="mb-3 d-flex justify-content-end">
            <div class="mx-1">
                <button type="button" data-toggle="modal" data-target="#formDelete-user" class="btn btn-danger"><i class="fa fa-dumpster-fire"></i> Bersihkan data</button>
            </div>
            <div class="mx-1">
                <button type="button" data-toggle="modal" data-target="#formModal" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> Tambah user</button>                                                    
            </div>
            <div class="mx-1">
                <button type="button" id="undo_user" data-toggle="modal" data-target="" class="btn btn-info btn-xs"><i class="fa fa-undo-alt"></i></button>                                                 
            </div>
        </div>       
        <table id="table-user" class="table display nowrap">
            <thead>
                <tr>
                    <th>No Anggota</th>
                    <th>Nama</th>                                                          
                    <th>Unit</th> 
                    <th>Username</th>                   
                    <th>Level</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = mysqli_fetch_array($sql_user_get)){
                ?>  
                    <tr>                        
                        <td class="align-middle"><?php echo $row['no_anggota'];?></td>
                        <td class="text-capitalize align-middle"><?php echo $row['nama'];?></td>
                        <td class="align-middle"><?php echo $row['nama_unit'];?></td> 
                        <td class="align-middle"><?php echo $row['username'];?></td>                        
                        <td class="align-middle"><?php 
                            if($row['level']=='lev0'){
                                $t = 'admin';
                            }else if($row['level']=='lev1'){
                                $t = 'admin';
                            }else if($row['level']=='lev2'){
                                $t = 'karyawan';
                            }else{
                                $t = 'anggota';
                            }
                            echo $t;?>
                        </td>
                        <td class="text-center">
                            <a id="edit_user" data-toggle="modal" data-target="#formModal_editUser" 
                                data-id = "<?php echo $row['id'];?>"
                                data-nama = "<?php echo $row['nama'];?>"
                                data-no_anggota = "<?php echo $row['no_anggota'];?>"                                
                                data-username = "<?php echo $row['username'];?>"
                                data-password = "<?php echo $row['password'];?>"
                                data-kdpr = "<?php echo $row['kdpr'];?>"
                                data-level = "<?php echo $row['level'];?>"
                                class="btn tw btn-info">
                                <i class="fa fa-edit"></i>                                
                            </a>
                            <?php if($row['level']!='lev0'){ ?>
                            <a id="delete_user"                            
                            data-id = "<?php echo $row['id'];?>"
                            class="btn tw btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                            <?php } ?>
                            <a href="dashboard.php?section=userprofile&id=<?php echo $row['id'];?>" class="btn tw btn-success">
                                <i class="fa fa-user"></i>                                
                            </a>
                        </td>
                    </tr>                                              
                        
                    <?php
                    }//endwhile
                    mysqli_free_result($sql_user_get);
                ?>
            </tbody>              
        </table>         
    </div>
</div>


<!-- MULAI MODAL TAMBAH USER-->
<div id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Tambah User</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Isi form untuk menambah user.</p>
            <form method="POST" onsubmit="return checkAll()">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" placeholder="" class="form-control" required>
                    </div>
                    <div class="form-group">       
                        <label>Nomor Anggota</label>
                        <input type="text" name="no_anggota" id="no_anggota" placeholder="" class="form-control" onblur="checkAvailabilityCust()" required pattern=".{3,}" title="Harus lebih dari 3 karakter">
                        <span class="status-available" id="cust-availability-status"></span>
                        <div class="text-center"><p><img src="img/loading.gif" id="loaderIconCust" style="display:none" class="mini pt-2"/></p></div>                        
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" id="username" placeholder="" class="form-control" onblur="checkAvailability()" required pattern=".{4,}" title="Harus lebih dari 4 karakter">
                        <span class="status-available" id="user-availability-status"></span>
                        <div class="text-center"><p><img src="img/loading.gif" id="loaderIconUser" style="display:none" class="mini pt-2"/></p></div>                        
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="password" placeholder="" class="form-control" required autocomplete="off" pattern=".{4,}" title="Harus lebih dari 4 karakter">
                    </div>
                    <div class="form-group">
                        <label>KDPR</label>                        
                        <select name="kdpr" class="form-control" required>
                            <?php
                                $show_unit=mysqli_query($koneksi,"SELECT * FROM unit");                                    
                                while($r_show_unit = mysqli_fetch_array($show_unit)){
                                    echo "<option value=".$r_show_unit['kdpr'].">".$r_show_unit['nama_unit']."</option>";                                    
                                }
                                mysqli_free_result($show_unit);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select name="level" id="" class="form-control">
                            <option value="lev0">Admin</option>
                            <option value="lev3" selected>Anggota</option>
                        </select>                        
                    </div>                                                                                    
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                </div>
                </div>
            </form>
    </div>
</div>

<!-- MULAI MODAL BERSIHKAN DATA-->
<div id="formDelete-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Bersihkan Data</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Membersihkan data user kecuali user admin</p>                        
            <a id="delAll" href="dashboard.php?section=delAllUser" class="btn tw btn-danger btn-xs mb-2"><i class="fa fa-trash pr-2"></i>Hapus semua</a>                                
                <div class="modal-footer">                    
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>                                                
            </div>
        </div>                             
    </div>
</div>


<script type="text/javascript">
    
    function checkAvailability() {
        $("#loaderIconUser").show();
        jQuery.ajax({
            url: "section/user_check_availability.php",
            data:'username='+$("#username").val(),
            type: "POST",
            success:function(response){
                $("#user-availability-status").html(response);
                $("#loaderIconUser").hide();
                if(response == "Tersedia."){
                    return true;
                }else{
                    return false;
                }                
            },
            error:function (){}
        });
    }
    function checkAvailabilityCust() {
        $("#loaderIconCust").show();
        jQuery.ajax({
            url: "section/user_check_availability.php",            
            data: 'no_anggota='+$("#no_anggota").val(),        
            type: "POST",
            success:function(response){
                $("#cust-availability-status").html(response);
                $("#loaderIconCust").hide();
                if(response == "Tersedia."){
                    return true;
                }else{
                    return false;
                }                
            },
            error:function (){}
        });
    }
    function checkAll(){
        var username = document.getElementById("user-availability-status").innerHTML;
        var cust = document.getElementById("cust-availability-status").innerHTML;

        if((username && cust) == "Tersedia."){
            return true;            
        } else {            
            alert("Terdapat data yang salah");
            return false;
            event.preventDefault();
        }
    }

</script>

<?php
    require "import/vendor/autoload.php";
    use Ramsey\Uuid\Uuid;
    if(isset($_POST['simpan'])){
        $id = Uuid::uuid4()->toString();
        $nama = $_POST['nama'];
        $no_anggota = $_POST['no_anggota'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $kdpr = $_POST['kdpr'];
        $level = $_POST['level'];
        $periodeimp = date("ym");

        $idP = Uuid::uuid4()->toString();
        $pj_uang = "";
        $pj_toko = "";
        $pj_jasa = "";
        $total = "";

        $idS = Uuid::uuid4()->toString();
        
        $sql_add_user = mysqli_query($koneksi, "INSERT INTO user(id, username, password, no_anggota, nama, kdpr, level) VALUES ('$id','$username','$password','$no_anggota','$nama', '$kdpr','$level')");        
        $sql_add_pinjaman = mysqli_query($koneksi, "INSERT INTO pinjaman(id_pinjaman, no_anggota, pj_uang, pj_toko, pj_jasa, total, periode) VALUES ('$idP', '$no_anggota','$pj_uang','$pj_toko','$pj_jasa','$total','$periodeimp')");
        $sql_add_simpanan = mysqli_query($koneksi, "INSERT INTO simpanan(id_simpanan, no_anggota, sp_pokok, sp_wajib, sp_lain, total, periode) VALUES ('$idS', '$no_anggota', '$pj_uang', '$pj_uang', '$pj_uang', '$pj_uang', '$periodeimp')");

        $makeQ_recovery_user = "DELETE FROM user WHERE no_anggota = @$no_anggota@";
        $makeQ_recovery_pj = "DELETE FROM pinjaman WHERE id_pinjaman = @$idP@";
        $makeQ_recovery_sp = "DELETE FROM simpanan WHERE id = @$idS@";
        $time = date("Y-m-d H:i:s");

        $insert_rec =  $koneksi->query("INSERT INTO re_query(id_recovery, query, db, time) VALUES ('', '$makeQ_recovery_user', 'user', '$time'),('', '$makeQ_recovery_pj', 'pinjaman', '$time'),('', '$makeQ_recovery_sp', 'simpanan', '$time')");

        if((!$sql_add_user) && (!$sql_add_pinjaman) && (!$sql_add_simpanan)){
            die("Gagal input data : ".$koneksi->error);
        }else{
            $no_anggota2 = $row2["no_anggota"];
            $activity = "tambah anggota no anggota->".$no_anggota;
            $time = date("Y-m-d H:i:s");
            $log_sql = $koneksi->query("INSERT INTO activity_log(id, no_anggota, activity, time) VALUES('', '$no_anggota2', '$activity', '$time')");
            $_SESSION['alert'] = 'tambah-success';
            ?>                                            
                <script type="text/javascript">
                    window.location.href="dashboard.php?section=user";
                </script>
            <?php
        }
    }else if(isset($_POST['import'])){
        $file = $_FILES['file']['name'];
        $ekstensi = explode(".", $file);
        $file_name = "file-".round(microtime(true)).".".end($ekstensi);
        $sumber = $_FILES['file']['tmp_name'];
        $target_dir = "section/file/";
        $target_file = $target_dir.$file_name;
        $upload = move_uploaded_file($sumber, $target_file);
      
        $obj = PHPExcel_IOFactory::load($target_file);
        $all_data = $obj->getActiveSheet()->toArray(null, true, true, true);

        $query_add_user_excl = "INSERT INTO user (id, username, password, no_anggota, nama, level) VALUES";
        for($i=2; $i <= count($all_data); $i++){
            $id_x = Uuid::uuid4()->toString();
            $username_x = $all_data[$i]['B'];
            $password_x = $all_data[$i]['A'];
            $no_anggota_x = $all_data[$i]['A'];
            $nama_x = $all_data[$i]['B'];
            $level_x = 'lev3';
            $query_add_user_excl .= "('', '$username_x', '$password_x', '$no_anggota_x', '$nama_x', '$level_x'),";
        }
        $query_add_user_excl = substr($query_add_user_excl,0,-1);
        $hasil_excl = $koneksi->query($query_add_user_excl);        

        unlink($target_file);
        echo "<script>window.location='dashboard.php?section=user'</script>";
    }
?>

<!-- MULAI MODAL IMPORT DATA-->
<div id="formUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Import Data</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Pilih file</p>
            <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="file" name="file" placeholder="" class="form-control" required>
                    </div>                                                                                                      
                </div>
                <div class="modal-footer">
                    <a href="section/file/sample/Book1.xlsx" class="btn tw btn-warning btn-xs"><i class="fa fa-download pr-2"></i>Download Format Excel</a>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <input type="submit" name="import" value="Upload" class="btn btn-primary">                                                
                </div>
                </div>
            </form>                          
    </div>
</div>

