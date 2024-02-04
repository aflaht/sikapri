<?php
if(isset($_SESSION['status'])){
    echo '<div id="alert-password"></div>';
    unset($_SESSION['status']);
}
?>
<div class="card shadow mb-4">
    <div class="card-header">
        <h5>Pengaturan Profil</h5>
    </div>
    <div class="card-body">
        <a  id="edit_password" data-toggle="modal" data-target="#formModal_editPassword"
            data-password="<?php echo $row['password'];?>"
            data-id = "<?php echo $row["id"];?>"
            class="btn tw btn-warning mb-3">
            <i class="fa fa-key pr-2"></i>
            Ubah password            
        </a>
        <a  id="edit_username" data-toggle="modal" data-target="#formModal_editUsername"            
            class="btn tw btn-info mb-3">
            <i class="fa fa-user pr-2"></i>
            Ubah username     
        </a>
    </div>
</div>

<!-- MODALS EDIT PASSWORD -->
<div id="formModal_editPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left mt-5" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title">Edit Password User</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div id="modal-edit-password" class="modal-body">
            <form method="POST">                
                <div class="form-group">
                    <label for="pasL">Password Lama</label>
                    <input id="pasL" type="password" name="password-lama" class="form-control" required autocomplete="off" pattern=".{4,}" title="Harus lebih dari 4 karakter">
                </div>
                <div class="form-group">
                    <label for="pasB">Password Baru</label>
                    <input id="pasB" type="password" name="password-baru" class="form-control" required autocomplete="off" pattern=".{4,}" title="Harus lebih dari 4 karakter">
                </div>
                <div class="form-group">
                    <label for="pasBv">Masukan Password Baru Kembali</label>
                    <input id="pasBv" type="password" name="password-baru-ver" class="form-control" required autocomplete="off" pattern=".{4,}" title="Harus lebih dari 4 karakter">
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <input type="submit" name="edit_password" value="Simpan" class="btn btn-primary">
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- MODALS EDIT USERNAME -->
<div id="formModal_editUsername" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left mt-5" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title">Edit Password User</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div id="modal-edit-username" class="modal-body">
            <form method="POST" onsubmit="return checkEdit();">
                <input id="fId" type="text" name="id" placeholder="" class="form-control" readonly value="<?php echo $row['id'];?>" style="display: none;">          
                <div class="form-group">
                    <label for="usernameL">Username Lama</label>
                    <input id="usernameL" type="text" name="username-lama" class="form-control" required autocomplete="off" pattern=".{4,}" title="Harus lebih dari 4 karakter">
                </div>
                <div class="form-group">
                    <label for="usernameB">Username Baru</label>
                    <input id="usernameB" type="text" name="username-baru" class="form-control" autofocus onblur="checkAvailabilityEdit()" required autocomplete="off" pattern=".{4,}" title="Harus lebih dari 4 karakter">
                    <span class="status-available" id="userEdit-availability-status"></span>
                    <div class="text-center"><p><img src="img/loading.gif" id="loaderIconEdit" style="display:none" class="mini pt-2"/></p></div>
                </div>                
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <input type="submit" name="edit_username" value="Simpan" class="btn btn-primary">
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<?php
    if(isset($_POST['edit_password'])){
        $password_lama = $_POST['password-lama'];
        $password_baru = $_POST['password-baru'];
        $password_baru_ver = $_POST['password-baru-ver'];
        //chaptca
        $idUser = $row["id"];
        if($password_lama == $row['password']){
            if($password_baru == $password_baru_ver){
                $query_edit_password = $koneksi->query("UPDATE user SET                                                         
                                                    password = '$password_baru_ver'                                                        
                                                WHERE id = '$idUser'
                    ");
                if(!$query_edit_password){
                    die("Gagal input data : ".$koneksi->error);
                }else{
                    $_SESSION['alert'] == 'password-success';
                    ?>
                        <script type="text/javascript">
                            // alert("Berhasil Mengubah Data User");
                            window.location.href="dashboard_user.php?section=pengaturan";
                        </script>
                    <?php
                    // header("location:dashboard_user.php?section=pengaturan");
                }
            }
        }else{
            ?>                            
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>                
            <script type="text/javascript">
                // alert("Password User Tidak Sesuai");
                Swal.fire({
                    type: 'error',
                    title: 'Data tidak sesuai',
                    text: 'Mohon masukan data user anda dengan benar.',
                });
            </script>
            <?php    
        }
    }
    if(isset($_POST['edit_username'])){
        $username_lama = $_POST['username-lama'];
        $username_baru = $_POST['username-baru'];
        //chaptca
        $idUser = $row["id"];
        if($username_lama == $row['username']){
            $query_edit_username = $koneksi->query("UPDATE user SET                                                         
                                                username = '$username_baru'                                                        
                                            WHERE id = '$idUser'
                ");
            if(!$query_edit_username){
                die("Gagal input data : ".$koneksi->error);
            }else{
                $_SESSION['alert'] == 'username-success';
                unset($_SESSION['username']);
                $_SESSION['username'] == $username_baru;
                ?>
                    <script type="text/javascript">
                        //alert("Berhasil Mengubah Data User");
                        window.location.href="dashboard_user.php?section=pengaturan";
                    </script>
                <?php
                // header("location:dashboard_user.php?section=pengaturan");
            }
        
        }else{
            ?>                            
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>                
            <script type="text/javascript">
                // alert("Password User Tidak Sesuai");
                Swal.fire({
                    type: 'error',
                    title: 'Data Tidak Sesuai',
                    text: 'Mohon masukan data user anda dengan benar.',
                });
            </script>
            <?php    
        }
    }
?>
                        <!-- End Edit Password -->
<script>
var alert = $("#alert-password").length
if(alert){
    Swal.fire({
        type: 'success',
        title: 'Berhasil',
        text: 'Data berhasil diubah.',
    });
}
</script>