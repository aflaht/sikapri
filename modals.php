<!-- Edit Password -->
<!-- <div id="formModal_editPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
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
                    <input id="pasL" type="password" name="password-lama" class="form-control" autocomplete="off" required>
                    <input id="uId" type="password" name="idu" class="form-control hidden" autocomplete="off">
                    <input id="uPass" type="password" name="password" class="form-control hidden" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pasB">Password Baru</label>
                    <input id="pasB" type="password" name="password-baru" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="pasBv">Masukan Password Baru Kembali</label>
                    <input id="pasBv" type="password" name="password-baru-ver" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="pasV">Password Admin</label>
                    <input id="pasV" type="password" name="password-ver" class="form-control" autocomplete="off" required>
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
 -->

<!-- End Edit Password -->

<!-- Edit User -->
<div id="formModal_editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title">Edit Data User</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div id="modal-edit-user" class="modal-body">                
                <form method="POST" onsubmit="return checkEdit();">
                    <div class="form-group" style="display:none">
                        <label style="display:none">Id</label>
                        <input id="fId" type="text" name="id" placeholder="" class="form-control" readonly style="display:none">
                    </div>
                    <div class="form-group">
                        <label for="fNama">Nama</label>
                        <input id="fNama" type="text" name="nama" placeholder="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nomor Anggota</label>
                        <input id="fNoAnggota" type="text" name="no_anggota" placeholder="" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fUsername">Username</label>
                        <input id="fUsername" type="text" name="username" placeholder="" class="form-control" autofocus onblur="checkAvailabilityEdit()" required>
                        <span class="status-available" id="userEdit-availability-status"></span>
                        <div class="text-center"><p><img src="img/loading.gif" id="loaderIconEdit" style="display:none" class="mini pt-2"/></p></div>
                    </div>
                    <div class="form-group" style="display:none">
                        <label>Password</label>
                        <input id="fPassword" type="password" name="password" placeholder="" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fKdpr">KDPR</label>
                        <select name="kdpr" id="fkdpr" class="form-control" required>
                            <option value="" selected></option>
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
                        <select name="level" id="fLevel" class="form-control">
                            <option value="lev0">Admin</option>
                            <option value="lev3" selected>Anggota</option>
                        </select>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                        <input type="submit" name="edit_user" value="Simpan" class="btn btn-primary">
                    </div>
                </form>
            </div>
    </div>
</div>
    <?php
        include 'koneksi.php';
        if(isset($_POST['edit_user'])){
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $no_anggota = $_POST['no_anggota'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $kdpr = $_POST['kdpr'];
            $level = $_POST['level'];

            $query_edit_user = $koneksi->query("UPDATE user SET
                                                    username = '$username',

                                                    nama = '$nama',
                                                    no_anggota = '$no_anggota',
                                                    kdpr = '$kdpr',
                                                    level = '$level'
                                                WHERE id = '$id'
            ");

            if(!$query_edit_user){
                die("Gagal input data : ".$koneksi->error);
            }else{
                //log activity
                $no_anggota2 = $row2["no_anggota"];
                $activity = "edit user -> ".$username;
                $time = date("Y-m-d H:i:s");
                $log_sql = $koneksi->query("INSERT INTO activity_log(id, no_anggota, activity, time) VALUES('', '$no_anggota2', '$activity', '$time')");
                $_SESSION['alert'] = 'edit-success';
                ?>
                    <script type="text/javascript">
                        window.location.href="dashboard.php?section=user";
                    </script>
                <?php
            }
        }
    ?>
<!-- End Edit User -->

<!-- Edit Unit -->
<div id="formModal_editUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title">Edit Data Unit</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div id="modal-edit-unit" class="modal-body">
                <p>Isi form untuk mengubah data unit.</p>
                <form method="POST">
                    <div class="form-group">
                        <label for="uKdpr">KDPR</label>
                        <input id="uKdpr" type="text" name="kdpr" placeholder="" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="uNama">Nama Unit</label>
                        <input id="uNama" type="text" name="nama_unit" placeholder="" class="form-control">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                        <input type="submit" name="edit_unit" value="Simpan" class="btn btn-primary">
                    </div>
                </form>
            </div>
    </div>
</div>
    <?php
        include 'koneksi.php';
        if(isset($_POST['edit_unit'])){
            $nama = $_POST['nama_unit'];
            $kdpr = $_POST['kdpr'];

            $query_edit_user = $koneksi->query("UPDATE unit SET
                                                    kdpr = '$kdpr',
                                                    nama_unit = '$nama'
                                                WHERE kdpr = '$kdpr'
            ");

            if(!$query_edit_user){
                die("Gagal input data : ".$koneksi->error);
            }else{
                //log activity
                $no_anggota = $row2["no_anggota"];
                $activity = "edit unit->".$nama;
                $time = date("Y-m-d H:i:s");
                $log_sql = $koneksi->query("INSERT INTO activity_log(id, no_anggota, activity, time) VALUES('', '$no_anggota', '$activity', '$time')");

                ?>
                    <script type="text/javascript">
                        alert("Berhasil Mengubah Data Unit");
                        window.location.href="dashboard.php?section=unit";
                    </script>
                <?php
            }
        }
    ?>
<!-- End Edit Unit -->

<!-- Edit Pinjaman -->
<div id="formModal_editPinjaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title">Edit Data Pinjaman</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div id="modal-edit-pinjaman" class="modal-body">
                <p>Isi form untuk mengubah data pinjaman.</p>
                <form method="POST">
                    <div class="form-group">
                        <label>Id</label>
                        <input id="fIdPinjaman" type="text" name="id_pinjaman" placeholder="" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fKdpi">KDPR</label>
                        <input id="fKdpi" type="text" name="kdpi" placeholder="" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fNama">Nama</label>
                        <input id="fNama" type="text" name="nama" placeholder="" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nomor Anggota (Nanti diganti yang otomatis ya..)</label>
                        <input id="fNoAnggota" type="text" name="no_anggota" placeholder="" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fUnit">Unit</label>
                        <input id="fUnit" type="text" name="unit" placeholder="" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fPjUang">Pinjaman Uang</label>
                        <input id="fPjUang" type="text" name="pj_uang" placeholder="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fPjToko">Pinjaman Toko</label>
                        <input id="fPjToko" type="text" name="pj_toko" placeholder="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fPjJasa">Pinjaman Jasa</label>
                        <input id="fPjJasa" type="text" name="pj_jasa" placeholder="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fPeriode">Periode</label>
                        <input id="fPeriode" type="text" name="periode" placeholder="" class="form-control">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                        <input type="submit" name="edit_pinjaman" value="Simpan" class="btn btn-primary">
                    </div>
                </form>
            </div>
    </div>
</div>
    <?php
        include 'koneksi.php';
        if(isset($_POST['edit_pinjaman'])){
            $id_pinjaman = $_POST['id_pinjaman'];
            $no_anggota = $_POST['no_anggota'];
            $pj_uang = $_POST['pj_uang'];
            $pj_toko = $_POST['pj_toko'];
            $pj_jasa = $_POST['pj_jasa'];
            $total_cek = $_POST['pj_uang']+$_POST['pj_toko']+$_POST['pj_jasa'];
            if($total_cek >= 1000000000){
                $total = "error";
            }else{
                $total = $total_cek;
            }
            $periode = $_POST['periode'];

            $query_edit_pinjaman = $koneksi->query("UPDATE pinjaman SET
                                                    no_anggota = '$no_anggota',
                                                    pj_uang = '$pj_uang',
                                                    pj_toko = '$pj_toko',
                                                    pj_jasa = '$pj_jasa',
                                                    total = '$total',
                                                    periode = '$periode'
                                                WHERE id_pinjaman = '$id_pinjaman'
            ");

            if(!$query_edit_pinjaman){
                die("Gagal input data : ".$koneksi->error);
            }else{
                //log activity
                $no_anggota2 = $row2["no_anggota"];
                $activity = "edit pinjaman no anggota->".$no_anggota." periode->".$periode;
                $time = date("Y-m-d H:i:s");
                $log_sql = $koneksi->query("INSERT INTO activity_log(id, no_anggota, activity, time) VALUES('', '$no_anggota2', '$activity', '$time')");
                
                ?>
                    <script type="text/javascript">
                        alert("Berhasil Mengubah Data Pinjaman");
                        window.location.href="dashboard.php?section=pinjaman";
                    </script>
                <?php
            }
        }
    ?>
<script type="text/javascript">
        $(document).on("click", "#edit_pinjaman", function(){
            var id_pinjaman = $(this).data('id_pinjaman');
            var kdpr = $(this).data('kdpr');
            var nama = $(this).data('nama');
            var no_anggota = $(this).data('no_anggota');
            var unit = $(this).data('unit');
            var pj_uang = $(this).data('pj_uang');
            var pj_toko = $(this).data('pj_toko');
            var pj_jasa = $(this).data('pj_jasa');
            var periode = $(this).data('periode');

            $("#modal-edit-pinjaman #fIdPinjaman").val(id_pinjaman);
            $("#modal-edit-pinjaman #fKdpi").val(kdpr);
            $("#modal-edit-pinjaman #fNama").val(nama);
            $("#modal-edit-pinjaman #fNoAnggota").val(no_anggota);
            $("#modal-edit-pinjaman #fUnit").val(unit);
            $("#modal-edit-pinjaman #fPjUang").val(pj_uang);
            $("#modal-edit-pinjaman #fPjToko").val(pj_toko);
            $("#modal-edit-pinjaman #fPjJasa").val(pj_jasa);
            $("#modal-edit-pinjaman #fPeriode").val(periode);
        });
</script>
<!-- End Edit Pinjaman -->

<!-- ABOUT APP -->
<div id="aboutAppModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title">Aplikasi Pengelolaan data Pinjaman dan Simpanan</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div id="modal-edit-unit" class="modal-body">
                <p>Aplikasi ini merupakan aplikasi yang berguna untuk mengelola informasi pinjaman anggota koperasi.</p>
                <form method="POST" style="display: none;">
                    <div class="form-group">
                        <label for="uKdpr">KDPR</label>
                        <input id="uKdpr" type="text" name="kdpr" placeholder="" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="uNama">Nama Unit</label>
                        <input id="uNama" type="text" name="nama_unit" placeholder="" class="form-control">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Tutup</button>
                        <input type="submit" name="edit_unit" value="Simpan" class="btn btn-primary" style="display: none;">
                    </div>
                </form>
            </div>
    </div>
</div>
<!-- END OF ABOUT APP -->