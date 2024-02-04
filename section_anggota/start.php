<a id="button" class="button ibutton"></a>
<a id="button2" class="button2 ibutton2"></a>
<div class="card shadow mb-4">
    <div class="card-header">
        <h3>informasi</h3>
    </div>
    <div class="card-body">
        <!-- <table class="table card-text">
            <tbody>
                <tr>
                    <td>Pinjaman Uang</td>
                    <td class="text-right">Rp. <?php //echo number_format($row2['pj_uang']);?></td>                                        
                </tr>
                <tr>
                    <td>Pinjaman Toko</td>
                    <td class="text-right">Rp. <?php //echo number_format($row2['pj_toko']);?></td>                                        
                </tr>
                <tr>
                    <td>Pinjaman Jasa</td>
                    <td class="text-right">Rp. <?php //echo number_format($row2['pj_jasa']);?></td>                                        
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-right">Rp. <?php //echo number_format($row2['total']);?></td>                                        
                </tr>
            </tbody>
        </table> -->
        <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link active show" data-toggle="tab" href="#tab-1"> Pinjaman</a></li>
                <li><a class="nav-link " data-toggle="tab" href="#tab-2" style="display:none">Simpanan</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                    <div class="panel-body">
                        <div class="card card-inverse shadow px-4 py-4 mb-4">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 text-center">
                                        <?php
                                        if($num_cek > 0){
                                            ?>
                                            <p class="card-text"><strong>Total Pinjaman Bulan Ini</strong> </p>
                                            <h2 class="card-title"><strong>Rp. <?php echo number_format($row2['total']);?></strong></h2>
                                            <?php
                                        }else{
                                            ?>
                                            <h6 class="card-title"><strong>Pinjaman terbaru belum diupdate</strong></h6>
                                            <h2 class="card-title"><strong>Rp. <?php echo number_format($row2['total']);?></strong></h2>
                                            <?php
                                        }
                                        ?>
                                        <p class="card-text pt-3"><strong>Rincian Pinjaman</strong></p>                                    
                                    </div>                        
                                    <div class="col-md-4 col-sm-4 text-center pt-4">
                                        <h4><strong> Rp. <?php echo number_format($row2['pj_uang']);?></strong></h4>        
                                        <button class="btn btn-primary btn-block btn-md mt-4"> Pinjaman Uang  </button>
                                    </div>
                                    <div class="col-md-4 col-sm-4 text-center pt-4">
                                            <h4><strong> Rp. <?php echo number_format($row2['pj_toko']);?></strong></h4>  
                                        <button class="btn btn-success btn-block btn-md mt-4"> Pinjaman Toko </button>
                                    </div>
                                    <div class="col-md-4 col-sm-4 text-center pt-4">
                                            <h4><strong> Rp. <?php echo number_format($row2['pj_jasa']);?></strong></h4>  
                                        <button type="button" class="btn btn-danger btn-block btn-md mt-4"> Pinjaman Jasa </button>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" id="tab-2" class="tab-pane" >
                    <div class="panel-body">
                    <div class="card card-inverse shadow px-4 py-4 mb-4">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 text-center" >
                                        <?php
                                            if($num_cek2 > 0){
                                                ?>
                                                <p class="card-text"><strong>Total Simpanan Bulan Ini</strong> </p>
                                                <h2 class="card-title"><strong>Rp. <?php echo number_format($row3['total']);?></strong></h2>
                                                <?php
                                            }else{
                                                ?>
                                                <h6 class="card-title"><strong>Simpanan terbaru belum diupdate</strong></h6>
                                                <h2 class="card-title"><strong>Rp. <?php echo number_format($row3['total']);?></strong></h2>
                                                <?php
                                            }
                                        ?>
                                        
                                        <p class="card-text pt-3"><strong>Rincian Simpanan</strong></p>                                    
                                    </div>                        
                                    <div class="col-md-4 col-sm-4 text-center pt-4">
                                        <h4><strong> Rp. <?php echo number_format($row3['sp_pokok']);?></strong></h4>        
                                        <button class="btn btn-primary btn-block btn-md mt-4"> Simpanan Pokok  </button>
                                    </div>
                                    <div class="col-md-4 col-sm-4 text-center pt-4">
                                            <h4><strong> Rp. <?php echo number_format($row3['sp_wajib']);?></strong></h4>  
                                        <button class="btn btn-success btn-block btn-md mt-4"> Simpanan Wajib </button>
                                    </div>
                                    <div class="col-md-4 col-sm-4 text-center pt-4">
                                            <h4><strong> Rp. <?php echo number_format($row3['sp_lain']);?></strong></h4>  
                                        <button type="button" class="btn btn-danger btn-block btn-md mt-4"> Simpanan Lain </button>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-5">
    <div class="card-header">
        <h3>Riwayat Pinjaman</h3>
    </div>
    <?php
        
    ?>
    <div class="card-body">
        <canvas id="chartPjTot" class="mb-4"></canvas>
        <table id="table-total" class="table display">
            <thead>
                <tr>
                    <th>No</th>
                    <th class="text-right">Periode</th>
                    <th class="text-right">Total</th>                                            
                </tr>
            </thead>
            <tbody>
                <?php
                $No = '1';
                while($r_all_pj=mysqli_fetch_array($q_all_pj)){
                    ?>
                    <tr>
                        <td><?php echo $No; ?></td>                        
                        <td class="text-right"><?php echo pertodate($r_all_pj['periode']); ?></td>
                        <td class="text-right"><?php echo "Rp. ".number_format($r_all_pj['total']); ?></td>                                                
                    </tr>                                            
                    <?php
                    $No++;
                }
                ?>
            </tbody>
        </table>
        <?php
            $sql_periode = "SELECT periode FROM user u INNER JOIN pinjaman p ON p.no_anggota=u.no_anggota WHERE id='$account_number' order by periode asc";
            $sql_total ="SELECT total FROM user u INNER JOIN pinjaman p ON p.no_anggota=u.no_anggota WHERE id='$account_number' order by periode asc";

            $q_periode = $koneksi->query($sql_periode);
            $q_total = $koneksi->query($sql_total);
        ?>
    </div>
</div>
<div class="card shadow mb-5" style="display:none">
    <div class="card-header">
        <h3>Riwayat Simpanan</h3>
    </div>
    <?php
        
    ?>
    <div class="card-body">
        <canvas id="chartSpTot" class="mb-4"></canvas>
        <table id="table-total2" class="table display">
            <thead>
                <tr>
                    <th>No</th>
                    <th class="text-right">Periode</th>
                    <th class="text-right">Total</th>                                            
                </tr>
            </thead>
            <tbody>
                <?php
                $No = '1';
                while($r_all_sp=mysqli_fetch_array($q_all_sp)){
                    ?>
                    <tr>
                        <td><?php echo $No; ?></td>                        
                        <td class="text-right"><?php echo pertodate($r_all_sp['periode']); ?></td>
                        <td class="text-right"><?php echo "Rp. ".number_format($r_all_sp['total']); ?></td>                                                
                    </tr>                                            
                    <?php
                    $No++;
                }
                ?>
            </tbody>
        </table>
        <?php
            $sql_periode_sp = "SELECT periode FROM user u INNER JOIN simpanan s ON s.no_anggota=u.no_anggota WHERE username='$account_number' order by periode asc";
            $sql_total_sp ="SELECT total FROM user u INNER JOIN simpanan s ON s.no_anggota=u.no_anggota WHERE username='$account_number' order by periode asc";

            $q_periode_sp = $koneksi->query($sql_periode_sp);
            $q_total_sp = $koneksi->query($sql_total_sp);
        ?>
    </div>
</div>