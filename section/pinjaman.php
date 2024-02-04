<!-- CARD TABEL PINJAMAN -->
<a id="button" class="button ibutton"></a>
<a id="button2" class="button2 ibutton2"></a>
<div class="card shadow">
    <div class="card-header">
        <h4>Tabel Pinjaman</h4>
    </div>

    <!-- ================= -->
    <div class="card-body">
        <div class="mb-3 d-flex justify-content-end">
            <div class="mx-1">
                <button type="button" data-toggle="modal" data-target="#formDelete-pinj" class="btn btn-danger"><i class="fa fa-dumpster-fire"></i> Bersihkan data</button>
            </div>
            <!-- <div class="mx-1">
                <button type="button" data-toggle="modal" data-target="#formModal-pinj" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> Tambah pinjaman</button>
            </div> -->
            <div class="mx-1">
                <button type="button" data-toggle="modal" data-target="#formUpload-pinj" class="btn btn-info btn-xs"><i class="fa fa-upload"></i> Import Data</button>
            </div>
        </div>
        <?php
        include 'section/pinjaman_proc.php';
        ?>
        <div class="row my-2">
            <div class="col col-md-4">
            <form method="POST">
                <label>Periode</label>
                <div class="mb-1 d-flex justify-content-start">
                    <div class="form-group">
                        <select name="pil" class="form-control" id="pilperiode">
                            <?php
                                for($i = 0; $i < $totalPeriode;$i++){
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
                        <td class="text-left">Laporan pinjaman per-unit</td>
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

<!-- MULAI MODAL TAMBAH PINJAMAN -->
<div id="formModal-pinj" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Tambah Pinjaman</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Isi form untuk menambah pinjaman.</p>
            <form method="POST">
            <div class="form-group">
                <label>Nomor Anggota</label>
                <input id="no_anggota2" type="text" name="no_anggota" placeholder="" class="form-control" onblur="chekAddPinjaman()" required>
                <span class="status-available" id="pinjaman-availability-status"></span>
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
                <label>Pinjaman Uang</label>
                <input type="number" name="pj_uang" placeholder="" class="form-control">
            </div>
            <div class="form-group">
                <label>Pinjaman Toko</label>
                <input type="number" name="pj_toko" placeholder="" class="form-control">
            </div>
            <div class="form-group">
                <label>Pinjaman Jasa</label>
                <input type="number" name="pj_jasa" placeholder="" class="form-control">
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
            <input type="submit" name="simpan_pinjaman" value="Simpan" class="btn btn-primary">
        </div>
        </div>
        </form>
    </div>
</div>
<?php
    require "import/vendor/autoload.php";
    use Ramsey\Uuid\Uuid;
    if(isset($_POST['importUser'])){
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
        for($j=1; $j <= $lr; $j++){
            $id_x = Uuid::uuid4()->toString();
            $kdpr_x = $all_data[$j]['A'];
            $no_anggota_x = $all_data[$j]['C'];
            $nama_x = str_replace("'","",$all_data[$j]['D']);
            $username_imp = substr(str_replace(" ","",$nama_x),0,4).$no_anggota_x;
            $password_imp = $username_imp;
            $level_imp = "lev3";
            $query_imp_user .= "('$id_x', '$username_imp', '$password_imp', '$no_anggota_x', '$nama_x', '$kdpr_x', '$level_imp'),";
        }
        $query_imp_user = substr($query_imp_user,0,-1);
        $hasil_imp_user = $koneksi->query($query_imp_user.'WHERE username IS NOT NULL');
        // if($hasil_imp_user){
        //     echo "upload file berhasil";
        // }else{
        //     die("Gagal input data : ".$koneksi->error);
        // }
        $query_add_pj_excl = "INSERT INTO pinjaman(id_pinjaman, no_anggota, pj_uang, pj_toko, pj_jasa, total, periode) VALUES";
        for($i=2; $i <= $lr; $i++){
            $id_x = Uuid::uuid4()->toString();
            $no_anggota_x = $all_data[$i]['C'];
            $pj_uang_x = $all_data[$i]['E'];
            $pj_toko_x = $all_data[$i]['F'];
            $pj_jasa_x = $all_data[$i]['G'];
            $total_x = (int)$pj_uang_x+(int)$pj_toko_x+(int)$pj_jasa_x;
            $periode_x = $all_data[$i]['I'];

            $query_add_pj_excl .= "('$id_x', '$no_anggota_x', '$pj_uang_x', '$pj_toko_x', '$pj_jasa_x', '$total_x', '$periode_x'),";
        }
        $query_add_pj_excl = substr($query_add_pj_excl,0,-1);
        $hasil_excl = $koneksi->query($query_add_pj_excl);
        if($hasil_excl){
            echo "upload file berhasil";
        }else{
            die("Gagal input data : ".$koneksi->error);
        }
        unlink($target_file);
        echo "<script>window.location='dashboard.php?section=pinjaman'</script>";
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
            // $pj_uang_x = $all_data[$i]['E'];
            // $pj_toko_x = $all_data[$i]['F'];
            // $pj_jasa_x = $all_data[$i]['G'];
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
        echo "<script>window.location='dashboard.php?section=pinjaman'</script>";
    }else if(isset($_POST['delete'])){
        $periode = $_POST['pil2'];
        $query_del_pinjaman = "DELETE FROM pinjaman WHERE periode='$periode'";

        $hasil_del_pinjaman = $koneksi->query($query_del_pinjaman);

        if(!$hasil_del_pinjaman){
            die("Gagal input data : ".$koneksi->error);
        }else{
            ?>
                <script type="text/javascript">
                    alert("Berhasil Membersihkan Data Pinjaman");
                    window.location.href="dashboard.php?section=pinjaman";
                </script>
            <?php
        }
    }
?>

<!-- MULAI MODAL IMPORT DATA-->
<div id="formUpload-pinj" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
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
                                <input type="submit" style="width: 160px;" name="importUser" value="Import Pinjaman" class="btn btn-info mb-2">
                            </div>
                            <div class="col">
                                <input type="submit" style="width: 160px;" name="importUnit" value="Import Unit" class="btn btn-info">
                                <!-- <input type="submit" style="width: 160px;" name="importPinjaman" value="Import Pinjaman" class="btn btn-info mb-2">
                                <input type="submit" style="width: 160px;" name="importAll" value="Import Semua" class="btn btn-info">  -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="section/file/sample/pinjaman-sample.xlsx" class="btn tw btn-warning btn-xs"><i class="fa fa-download pr-2"></i>Download Format Excel</a>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary btn-xs">Batal</button>
                </div>
                </div>
            </form>
    </div>
</div>


<!-- MULAI MODAL BERSIHKAN DATA-->
<div id="formDelete-pinj" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Bersihkan Data</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p>Membersihkan data pinjaman</p>
            <form method="POST">
                    <div class="form-group">
                        <label>Berdasarkan Periode</label>
                        <select name="pil2" class="form-control" id="pilperiode2" required>
                            <?php
                                for($i = 0; $i < $totalPeriode;$i++){
                                    $oldperiode = date("ym", strtotime("-$i months"));
                                    echo "<option value=".$oldperiode.">".$oldperiode."</option>";
                                }
                            ?>
                        </select>
                        <!-- <input type="text" name="periode" placeholder="format (TahunBulan, misal : 1901)" class="form-control" required> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="delAll" href="dashboard.php?section=delAll" class="btn tw btn-danger btn-xs"><i class="fa fa-trash pr-2"></i>Hapus semua</a>
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
            <p>Cetak Lopran Pinjaman per-Unit</p>
            <form method="POST" action="section/export_pj_unit.php">
                    <div class="form-group">
                        <label>Berdasarkan Periode</label>
                        <select name="pil2" class="form-control" id="pilperiode2" required>
                            <?php
                                for($i = 0; $i < $totalPeriode;$i++){
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
