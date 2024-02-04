<div id="load-table"></div>
    <!-- Query Tabel User -->
    <?php
    //periode terbaru
    $time = date("ym");
    //cek data base
    $cek_sp = mysqli_query($koneksi, "SELECT * FROM simpanan WHERE periode = '$periode'");
    $num_cek2 = mysqli_num_rows($cek_sp);
    
    if($num_cek2 > 0){
        $lastTimeSp = $time;
    }else{
        $lastTimeSp = $time-1;
    }
        if(isset($_POST["go"])){
            $pil = $_POST["pil"];
            $sql_get_all_simpanan = "SELECT * FROM simpanan p INNER JOIN user u ON p.no_anggota=u.no_anggota INNER JOIN unit t ON u.kdpr=t.kdpr WHERE periode='$pil'";
            $query_get_all_simpanan = $koneksi->query($sql_get_all_simpanan);
        }else if(isset($_POST["semua"])){
            $sql_get_all_simpanan = "SELECT * FROM simpanan p INNER JOIN user u ON p.no_anggota=u.no_anggota INNER JOIN unit t ON u.kdpr=t.kdpr";
            $query_get_all_simpanan = $koneksi->query($sql_get_all_simpanan);
        }else{
            $sql_get_all_simpanan = "SELECT * FROM simpanan p INNER JOIN user u ON p.no_anggota=u.no_anggota INNER JOIN unit t ON u.kdpr=t.kdpr WHERE periode='$lastTimeSp' ORDER BY nama";
            $query_get_all_simpanan = $koneksi->query($sql_get_all_simpanan);
        }
    ?>

    <table id="table-simpanan" class="table display nowrap card-text">
        <thead>
            <tr>
                <th>Unit</th>
                <th>Nama</th>
                <th>Simpanan Pokok</th>
                <th>Simpanan Wajib</th>
                <th>Simpanan Lain</th>
                <th>Total</th>
                <th>Periode</th>
                <!-- <th class="text-center" >Aksi</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
                while ($row_simp = mysqli_fetch_array($query_get_all_simpanan)){
            ?>
                <tr>
                    <td><?php echo $row_simp['nama_unit'];?></td>
                    <td class="text-capitalize"><?php echo $row_simp['nama'];?></td>
                    <td class="text-right"><?php echo "Rp. ".number_format($row_simp['sp_pokok'])."";?></td>
                    <td class="text-right"><?php echo "Rp. ".number_format($row_simp['sp_wajib'])."";?></td>
                    <td class="text-right"><?php echo "Rp. ".number_format($row_simp['sp_lain'])."";?></td>
                    <?php
                        $total = $row_simp['sp_pokok']+$row_simp['sp_wajib']+$row_simp['sp_lain'];
                        if($total != $row_simp['total']){
                            $pr = "Data tidak sesuai";
                        }else{
                            $pr = "Rp. ".number_format($row_simp['total'])."";
                        }
                    ?>
                    <td class="text-right"><?php echo $pr;?></td>
                    <td class="text-center"><?php echo $row_simp['periode'];?></td>
                    
                </tr>
                <?php
                }//endwhile
                mysqli_free_result($query_get_all_simpanan);
            ?>
        </tbody>
    </table>
