<div class="card shadow">
    <div class="card-header">
        <h4>Konfirmasi Pembersihan Data</h4>
    </div>
    <div class="card-body">
        <form method="POST" class="">            
            <div class="mb-4">
                <label for="pass"class="pb-2">Masukan password untuk melanjutkan</label>
                <input id="pass" type="password" name="password" placeholder="Masukan password" class="form-control-lg form-control shadow" required>
            </div>
            <input type="submit" name="deleteAll" value="Lanjutkan" class="btn btn-info shadow">              
        </form>
    </div>
</div>

<?php
    if(isset($_POST['deleteAll'])){
        $pass = $_POST['password'];
        $ver = $row2["password"];

        if($pass == $ver){
            include_once "backup.php";
            backup("user,pinjaman,simpanan");
            $query_del_all_user_pj = "DELETE user,pinjaman,simpanan FROM user INNER JOIN pinjaman ON pinjaman.no_anggota = user.no_anggota INNER JOIN simpanan ON simpanan.no_anggota = user.no_anggota WHERE user.level='lev3'";
            $query_del_all_user = "DELETE FROM user WHERE level='lev3'";
            $hasil_del_all_user_pj = $koneksi->query($query_del_all_user_pj);
            $hasil_del_all_user = $koneksi->query($query_del_all_user);
            if((!$hasil_del_all_user_pj) || (!$hasil_del_all_user)){
                die("Gagal input sql : ".$koneksi->error);
            }else{
                ?>                                            
                    <script type="text/javascript">
                        alert("Berhasil Membersihkan Data User");
                        window.location.href="dashboard.php?section=user";
                    </script>
                <?php
            }
        }else{
            ?>                                            
                <script type="text/javascript">
                    alert("Password salah");
                </script>
            <?php
        }        
    }
?>