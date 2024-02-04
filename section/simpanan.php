<!-- CARD TABEL SIMPANAN -->
<div class="card shadow">
    <div class="card-header">
        <h4>Tabel Simpanan</h4>
    </div>

    <!-- ================= -->
    <div class="card-body">
        <div class="mb-3 d-flex justify-content-end">
            <div class="mx-1">
                <button type="button" data-toggle="modal" data-target="#formDelete-simp" class="btn btn-danger"><i class="fa fa-dumpster-fire"></i> Bersihkan data</button>
            </div>
            <!-- <div class="mx-1">
                <button type="button" data-toggle="modal" data-target="#formModal-pinj" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> Tambah simpanan</button>
            </div> -->
            <div class="mx-1">
                <button type="button" data-toggle="modal" data-target="#formUpload-simp" class="btn btn-info btn-xs"><i class="fa fa-upload"></i> Import Data</button>
            </div>
        </div>
        <?php
        include 'section/simpanan_proc.php';
        ?>
        <div class="row my-2">
            <div class="col col-md-4">
            <form method="POST">
                <label>Periode</label>
                <div class="mb-1 d-flex justify-content-start">
                    <div class="form-group">
                        <select name="pil" class="form-control" id="pilperiode">
                            <?php
                                for($i = 0; $i < 7;$i++){
                                    $oldperiode = date("ym", strtotime("-$i months"));
                                    echo "<option value=".$oldperiode.">".$oldperiode."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <input type="submit" name="go" value="Go" style="height:40px;" class="btn btn-primary ml-3">
                    <input type="submit" name="semua" value="Semua" style="height:40px;" class="btn btn-warning tw ml-2">
                </div>
            </form>
            </div>
            <div class="col col-md-4"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col col-md-6">
        <!-- CARD EXPORT LAPORAN -->
        <div class="card shadow mt-4">
            <div class="card-header">
                <h4>Buat Laporan</h4>
            </div>
            <div class="card-body">
                <div></div>
                <table class="table">
                    <tr>
                        <td class="text-left">Laporan simpanan per-unit</td>
                        <td class="text-right">
                        <!-- <a id="cetakLapUnit" href="section/export_pj_unit.php" class="btn tw logout"><i class="fa fa-download"></i></a> -->
                        <!-- <a id="cetakLapUnit" class="btn tw logout"><i class="fa fa-download"></i></a> -->
                        <button type="button" data-toggle="modal" data-target="#formCetak-pinj" class="btn btn-info"><i class="fa fa-download"></i></button>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td class="text-left">Laporan laporan laporan</td>
                        <td class="text-right"><a href="section/backup.php" class="btn tw logout"><i class="fa fa-download"></i></a></td>
                    </tr> -->
                </table>
            </div>
        </div>
    </div>
    <div class="col col-md-4"></div>
</div>

<!-- MULAI MODAL TAMBAH SIMPANAN -->
<div id="formModal-simp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Tambah Simpanan</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Isi form untuk menambah simpanan.</p>
            <form method="POST">
            <div class="form-group">
                <label>Nomor Anggota</label>
                <input id="no_anggota2" type="text" name="no_anggota" placeholder="" class="form-control" onblur="chekAddSimpanan()" required>
                <span class="status-available" id="simpanan-availability-status"></span>
            </div>
            <div class="form-group">
                <label>KDPR</label>
                <input id="kdpr" type="text" name="kdpi" placeholder="" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input id="nama" type="text" name="nama" placeholder="" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input id="unit" type="text" name="unit" placeholder="" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Simpanan Uang</label>
                <input type="number" name="sp_pokok" placeholder="" class="form-control">
            </div>
            <div class="form-group">
                <label>Simpanan Toko</label>
                <input type="number" name="sp_wajib" placeholder="" class="form-control">
            </div>
            <div class="form-group">
                <label>Simpanan Jasa</label>
                <input type="number" name="sp_lain" placeholder="" class="form-control">
            </div>
            <div class="form-group">
                <label>Total</label>
                <input type="text" placeholder="Total akan di-inputkan otomatis" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Periode</label>
                <input type="text" name="periode" placeholder="" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
            <input type="submit" name="simpan_simpanan" value="Simpan" class="btn btn-primary">
        </div>
        </div>
        </form>
    </div>
</div>
<?php
    require "import/vendor/autoload.php";
    use Ramsey\Uuid\Uuid;
    if(isset($_POST['simpan_simpanan'])){
        $id = Uuid::uuid4()->toString();
        $no_anggota = $_POST['no_anggota'];
        $sp_pokok = $_POST['sp_pokok'];
        $sp_wajib = $_POST['sp_wajib'];
        $sp_lain = $_POST['sp_lain'];
        $total = $_POST['sp_pokok']+$_POST['sp_wajib']+$_POST['sp_lain'];
        $periode = $_POST['periode'];

        $query_add_simpanan = "INSERT INTO simpanan(id_simpanan, no_anggota, sp_pokok, sp_wajib, sp_lain, total, periode) VALUES ('$id', '$no_anggota','$sp_pokok','$sp_wajib','$sp_lain','$total','$periode')";

        $hasil_add_simpanan = $koneksi->query($query_add_simpanan);

        if(!$hasil_add_simpanan){
            die("Gagal input data : ".$koneksi->error);
        }else{
            ?>
                <script type="text/javascript">
                    alert("Berhasil Menambahkan Data Simpanan");
                    window.location.href="dashboard.php?section=simpanan";
                </script>
            <?php
        }
    }else if(isset($_POST['importSimpanan'])){
        $file = $_FILES['file']['name'];
        $ekstensi = explode(".", $file);
        $file_name = "file-".round(microtime(true)).".".end($ekstensi);
        $sumber = $_FILES['file']['tmp_name'];
        $target_dir = "section/file/";
        $target_file = $target_dir.$file_name;
        $upload = move_uploaded_file($sumber, $target_file);
        if($upload){
            echo "upload file berhasil";
        }else{
            echo "upload file gagal";
        }

        $obj = PHPExcel_IOFactory::createReaderForFile($target_file);
        $obj->setReadDataOnly(true);
        $ex_obj = $obj->load($target_file);
        $worksheet = $ex_obj->getSheet(0);
        $lr = $worksheet->getHighestRow();

        $all_data = $worksheet->toArray(null, true, true, true);
        //$all_data = $obj->getActiveSheet()->toArray(null, true, true, true);

        $query_add_pj_excl = "INSERT INTO simpanan(id_simpanan, no_anggota, sp_pokok, sp_wajib, sp_lain, total, periode) VALUES";
        for($i=2; $i <= $lr; $i++){
            $id_x = Uuid::uuid4()->toString();
            $no_anggota_x = $all_data[$i]['C'];
            $sp_pokok_x = $all_data[$i]['E'];
            $sp_wajib_x = $all_data[$i]['F'];
            $sp_lain_x = $all_data[$i]['G'];
            $total_x = (int)$sp_pokok_x+(int)$sp_wajib_x+(int)$sp_lain_x;
            $periode_x = $all_data[$i]['I'];

            $query_add_pj_excl .= "('$id_x', '$no_anggota_x', '$sp_pokok_x', '$sp_wajib_x', '$sp_lain_x', '$total_x', '$periode_x'),";
        }
        $query_add_pj_excl = substr($query_add_pj_excl,0,-1);
        $hasil_excl = $koneksi->query($query_add_pj_excl);
        if($hasil_excl){
            echo "upload file berhasil";
        }else{
            die("Gagal input data : ".$koneksi->error);
        }

        unlink($target_file);
        echo "<script>window.location='dashboard.php?section=simpanan'</script>";

    }else if(isset($_POST['importUser'])){
        $file = $_FILES['file']['name'];
        $ekstensi = explode(".", $file);
        $file_name = "file-".round(microtime(true)).".".end($ekstensi);
        $sumber = $_FILES['file']['tmp_name'];
        $target_dir = "section/file/";
        $target_file = $target_dir.$file_name;
        $upload = move_uploaded_file($sumber, $target_file);
        if($upload){
            echo "upload file berhasil";
        }else{
            echo "upload file gagal";
        }

        $obj = PHPExcel_IOFactory::createReaderForFile($target_file);
        $obj->setReadDataOnly(true);
        $ex_obj = $obj->load($target_file);
        $worksheet = $ex_obj->getSheet(0);
        $lr = $worksheet->getHighestRow();

        $all_data = $worksheet->toArray(null, true, true, true);
        //$all_data = $obj->getActiveSheet()->toArray(null, true, true, true);

        $query_imp_user ="INSERT IGNORE INTO user (id, username, password, no_anggota, nama, kdpr, level) VALUES";
        for($j=2; $j <= $lr; $j++){
            $id_x = Uuid::uuid4()->toString();
            $kdpr_x = $all_data[$j]['A'];
            // $unit_x = $all_data[$j]['B'];
            $no_anggota_x = $all_data[$j]['C'];
            $nama_x = str_replace("'","",$all_data[$j]['D']);
            // $sp_pokok_x = $all_data[$i]['E'];
            // $sp_wajib_x = $all_data[$i]['F'];
            // $sp_lain_x = $all_data[$i]['G'];
            // $total_x = $all_data[$i]['H'];
            // $periode_x = $all_data[$i]['I'];
            $username_imp = substr(str_replace(" ","",$nama_x),0,4).$no_anggota_x;
            $password_imp = $username_imp;
            $level_imp = "lev3";
            $query_imp_user .= "('$id_x', '$username_imp', '$password_imp', '$no_anggota_x', '$nama_x', '$kdpr_x', '$level_imp'),";
        }
        $query_imp_user = substr($query_imp_user,0,-1);
        //echo $query_imp_user;
        $hasil_imp_user = $koneksi->query($query_imp_user);
        // if($hasil_imp_user){
        //     echo "upload file berhasil";
        // }else{
        //     die("Gagal input data : ".$koneksi->error);
        // }
        $query_add_pj_excl = "INSERT INTO simpanan(id_simpanan, no_anggota, sp_pokok, sp_wajib, sp_lain, total, periode) VALUES";
        for($i=2; $i <= $lr; $i++){
            $id_xs = Uuid::uuid4()->toString();
            $no_anggota_xs = $all_data[$i]['C'];
            $sp_pokok_x = $all_data[$i]['E'];
            $sp_wajib_x = $all_data[$i]['F'];
            $sp_lain_x = $all_data[$i]['G'];
            $total_x = (int)$sp_pokok_x+(int)$sp_wajib_x+(int)$sp_lain_x;
            $periode_x = $all_data[$i]['I'];

            $query_add_pj_excl .= "('$id_xs', '$no_anggota_xs', '$sp_pokok_x', '$sp_wajib_x', '$sp_lain_x', '$total_x', '$periode_x'),";
        }
        $query_add_pj_excl = substr($query_add_pj_excl,0,-1);
        $hasil_excl = $koneksi->query($query_add_pj_excl);
        if($hasil_excl){
            echo "upload file berhasil";
        }else{
            die("Gagal input data : ".$koneksi->error);
        }
        unlink($target_file);
        echo "<script>window.location='dashboard.php?section=simpanan'</script>";
    }else if(isset($_POST['importUnit'])){
        $file = $_FILES['file']['name'];
        $ekstensi = explode(".", $file);
        $file_name = "file-".round(microtime(true)).".".end($ekstensi);
        $sumber = $_FILES['file']['tmp_name'];
        $target_dir = "section/file/";
        $target_file = $target_dir.$file_name;
        $upload = move_uploaded_file($sumber, $target_file);
        if($upload){
            echo "upload file berhasil";
        }else{
            echo "upload file gagal";
        }

        $obj = PHPExcel_IOFactory::createReaderForFile($target_file);
        $obj->setReadDataOnly(true);
        $ex_obj = $obj->load($target_file);
        $worksheet = $ex_obj->getSheet(0);
        $lr = $worksheet->getHighestRow();

        $all_data = $worksheet->toArray(null, true, true, true);
        //$all_data = $obj->getActiveSheet()->toArray(null, true, true, true);

        $query_imp_unit ="INSERT IGNORE INTO unit(kdpr,nama_unit) VALUES";
        for($j=2; $j <= $lr; $j++){
            // $id_x = Uuid::uuid4()->toString();
            $kdpr_x = $all_data[$j]['A'];
            $unit_x = $all_data[$j]['B'];
            // $no_anggota_x = $all_data[$i]['C'];
            // $nama_x = $all_data[$i]['D'];
            // $sp_pokok_x = $all_data[$i]['E'];
            // $sp_wajib_x = $all_data[$i]['F'];
            // $sp_lain_x = $all_data[$i]['G'];
            // $total_x = $all_data[$i]['H'];
            // $periode_x = $all_data[$i]['I'];;
            $query_imp_unit .= "('$kdpr_x', '$unit_x'),";
        }
        $query_imp_unit = substr($query_imp_unit,0,-1);
        $hasil_imp_unit = $koneksi->query($query_imp_unit);
        if($hasil_imp_unit){
            echo "upload file berhasil";
        }else{
            die("Gagal input data : ".$koneksi->error);
        }

        unlink($target_file);
        echo "<script>window.location='dashboard.php?section=simpanan'</script>";
    }else if(isset($_POST['delete'])){
        $periode = $_POST['periode'];
        $query_del_simpanan = "DELETE FROM simpanan WHERE periode='$periode'";

        $hasil_del_simpanan = $koneksi->query($query_del_simpanan);

        if(!$hasil_del_simpanan){
            die("Gagal input data : ".$koneksi->error);
        }else{
            ?>
                <script type="text/javascript">
                    alert("Berhasil Membersihkan Data Simpanan");
                    window.location.href="dashboard.php?section=simpanan";
                </script>
            <?php
        }
    }
?>

<!-- MULAI MODAL IMPORT DATA-->
<div id="formUpload-simp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Import Data</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Pilih file</p>
            <h6>Pastikan file excel yang diupload tidak memiliki format tertentu pada cell-nya (format general) serta tidak terdapat error.</h6>
            <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" id="file" name="file" placeholder="" class="form-control" required>
                        <div class="row my-4 text-center">
                            <div class="col">
                                <input type="submit" style="width: 160px;" name="importUser" value="Import Simpanan" class="btn btn-info mb-2">
                            </div>
                            <div class="col">
                                <input type="submit" style="width: 160px;" name="importUnit" value="Import Unit" class="btn btn-info">
                                <!-- <input type="submit" style="width: 160px;" name="importSimpanan" value="Import Simpanan" class="btn btn-info mb-2">
                                <input type="submit" style="width: 160px;" name="importAll" value="Import Semua" class="btn btn-info">  -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="section/file/sample/simpanan-sample.xlsx" class="btn tw btn-warning btn-xs"><i class="fa fa-download pr-2"></i>Download Format Excel</a>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary btn-xs">Batal</button>
                </div>
                </div>
            </form>
    </div>
</div>


<!-- MULAI MODAL BERSIHKAN DATA-->
<div id="formDelete-simp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Bersihkan Data</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Membersihkan data simpanan</p>
            <form method="POST">
                    <div class="form-group">
                        <label>Berdasarkan Periode</label>
                        <input type="text" name="periode" placeholder="format (TahunBulan, misal : 1901)" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="delAll" href="dashboard.php?section=delAllSimpanan" class="btn tw btn-danger btn-xs"><i class="fa fa-trash pr-2"></i>Hapus semua</a>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                    <input type="submit" name="delete" value="Bersihkan" class="btn btn-primary">
                </div>
                </div>
            </form>
    </div>
</div>

<!-- MULAI MODAL CETAK LAPORAN-->
<div id="formCetak-pinj" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Cetak Laporan Unit</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Cetak Lopran Simpanan per-Unit</p>
            <form method="POST" action="section/export_pj_unit.php">
                    <div class="form-group">
                        <label>Berdasarkan Periode</label>
                        <select name="pil2" class="form-control" id="pilperiode2" required>
                            <?php
                                for($i = 0; $i < 7;$i++){
                                    $oldperiode = date("ym", strtotime("-$i months"));
                                    echo "<option value=".$oldperiode.">".$oldperiode."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <a id="cetakLapUnit" href="section/export_pj_unit.php" class="btn tw logout"><i class="fa fa-download"></i></a> -->
                    <input type="submit" name="cetak" value="Cetak" style="height:40px;" class="btn btn-primary ml-3">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                </div>
                </div>
            </form>
    </div>
</div>
