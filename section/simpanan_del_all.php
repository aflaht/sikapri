<div class="card shadow">
    <div class="card-header">
        <h4>Konfirmasi Pembersihan Data</h4>
    </div>
    <div class="card-body">
        <form method="POST" class="">
            <div class="mb-4">
                <label for="pass"class="pb-2">Masukan password untuk melanjutkan</label>
                <input id="pass" type="password" name="password" placeholder="Masukan password" class="form-control-lg form-control shadow" require="required">
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
            backup("simpanan");
            $query_del_all_simpanan = "DELETE FROM simpanan";
            $hasil_del_all_simpanan = $koneksi->query($query_del_all_simpanan);
            if(!$hasil_del_all_simpanan){
                die("Gagal input data : ".$koneksi->error);
            }else{
                ?>
                    <script type="text/javascript">
                        alert("Berhasil Membersihkan Data Simpanan");
                        window.location.href="dashboard.php?section=simpanan";
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
