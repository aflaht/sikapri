<div id="load-table"></div>
    <!-- Query Tabel User -->
    <?php
         //periode terbaru
         $time = date("ym");
         //cek data base
         $cek_pj = mysqli_query($koneksi,"SELECT * FROM pinjaman WHERE periode = '$periode'");
         $num_cek = mysqli_num_rows($cek_pj);

         if($num_cek > 0){
             $lastTimePj = $time;
         }else{
             $lastTimePj = $time-1;
         }
        if(isset($_POST["go"])){                
            $pil = $_POST["pil"];            
            $sql_get_all_pinjaman = "SELECT * FROM pinjaman p INNER JOIN user u ON p.no_anggota=u.no_anggota INNER JOIN unit t ON u.kdpr=t.kdpr WHERE periode='$pil'";
            $query_get_all_pinjaman = $koneksi->query($sql_get_all_pinjaman);
        }else if(isset($_POST["semua"])){
            $sql_get_all_pinjaman = "SELECT * FROM pinjaman p INNER JOIN user u ON p.no_anggota=u.no_anggota INNER JOIN unit t ON u.kdpr=t.kdpr";
            $query_get_all_pinjaman = $koneksi->query($sql_get_all_pinjaman);
        }else{
            $sql_get_all_pinjaman = "SELECT * FROM pinjaman p INNER JOIN user u ON p.no_anggota=u.no_anggota INNER JOIN unit t ON u.kdpr=t.kdpr WHERE periode='$lastTimePj' ORDER BY nama";
            $query_get_all_pinjaman = $koneksi->query($sql_get_all_pinjaman);
        }
    ?>

    <table id="table-pinjaman" class="table display nowrap card-text">
        <thead>
            <tr>
                <th>Unit</th>
                <th>Nama</th>
                <th>Pinjaman Uang</th>
                <th>Pinjaman Toko</th>
                <th>Pinjaman Jasa</th>
                <th>Total</th>
                <th>Periode</th>
                <!-- <th class="text-center" >Aksi</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
                while ($row_pinj = mysqli_fetch_array($query_get_all_pinjaman)){
            ?>  
                <tr>                   
                    <td><?php echo $row_pinj['nama_unit'];?></td>
                    <td class="text-capitalize"><?php echo $row_pinj['nama'];?></td>
                    <td class="text-right"><?php echo "Rp. ".number_format($row_pinj['pj_uang'])."";?></td>
                    <td class="text-right"><?php echo "Rp. ".number_format($row_pinj['pj_toko'])."";?></td>
                    <td class="text-right"><?php echo "Rp. ".number_format($row_pinj['pj_jasa'])."";?></td>
                    <?php
                        $total = $row_pinj['pj_uang']+$row_pinj['pj_toko']+$row_pinj['pj_jasa'];
                        if($total != $row_pinj['total']){
                            $pr = "Data tidak sesuai";
                        }else{
                            $pr = "Rp. ".number_format($row_pinj['total'])."";
                        }
                    ?>
                    <td class="text-right"><?php echo $pr;?></td>
                    <td class="text-center"><?php echo $row_pinj['periode'];?></td>
                    <!-- <td class="text-center">
                        <a id="edit_pinjaman" data-toggle="modal" data-target="#formModal_editPinjaman" 
                            data-id_pinjaman = "<?php //echo $row_pinj['id_pinjaman'];?>"
                            data-kdpr = "<?php //echo $row_pinj['kdpr'];?>"
                            data-nama = "<?php //echo $row_pinj['nama'];?>"
                            data-no_anggota = "<?php //echo $row_pinj['no_anggota'];?>"
                            data-unit = "<?php //echo $row_pinj['nama_unit'];?>"
                            data-pj_uang = "<?php //echo $row_pinj['pj_uang'];?>"
                            data-pj_toko = "<?php //echo $row_pinj['pj_toko'];?>"
                            data-pj_jasa = "<?php //echo $row_pinj['pj_jasa'];?>"
                            data-total = "<?php //echo $row_pinj['total'];?>"
                            data-periode = "<?php //echo $row_pinj['periode'];?>"
                            class="btn tw btn-info">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a id="delete_pinjaman"                            
                        data-id_pinjaman = "<?php //echo $row_pinj['id_pinjaman'];?>"                            
                        class="btn tw btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td> -->
                </tr>                                              
                <?php
                }//endwhile
                mysqli_free_result($query_get_all_pinjaman);
            ?>
        </tbody>
    </table>        