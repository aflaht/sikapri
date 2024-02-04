<div class="row pb-2">
    <div class="col-md-4">
        <div class="card mb-4">
        <?php
            //periode terbaru
            $time = date("ym");
            //cek data base
            $cek_pj = mysqli_query($koneksi,"SELECT * FROM pinjaman WHERE periode = '$periode'");
            $numCek = mysqli_num_rows($cek_pj);

            $cek_sp = mysqli_query($koneksi, "SELECT * FROM simpanan WHERE periode = '$periode'");
            $numCek2 = mysqli_num_rows($cek_sp);
        // QUERY TOTAL PINJAMAN SIMPANAN
            if(($numCek > 0) || ($numCek2 > 0)){
                $lastTimePj = $time;
                $lastTimeSp = $time;
            }else if(($numCek && $numCek2) > 0){
                $lastTimePj = $time;
                $lastTimeSp = $time;
            }else{
                $lastTime = $time-1;
                $lastTimePj = $time-1;
                $lastTimeSp = $time-1;
            }
            $sql_get_total = mysqli_query($koneksi, "SELECT SUM(total) as jml FROM pinjaman WHERE periode='$lastTimePj'");            
            $r_get_total = $sql_get_total->fetch_array();
        // QUERY TOTAL SIMPANAN
            $sql_get_total_sp = mysqli_query($koneksi, "SELECT SUM(total) as jml FROM simpanan WHERE periode='$lastTimeSp'");            
            $r_get_total_sp = $sql_get_total_sp->fetch_array();
        // QUERY PENGGUNA AKTIF
            $sql_get_acuser = mysqli_query($koneksi, "SELECT * FROM user WHERE kdpr NOT IN ('U99')");
            $r_get_acuser = mysqli_num_rows($sql_get_acuser);
        ?>
            <div class="card-header">
                <span class="label label-success float-right"><?php echo substr($lastTimePj,-2,2).'/'.substr($lastTimePj,0,-2);?></span>
                <h6>Total simpanan koperasi</h6>
            </div>
            <div class="card-body">                                    
                <h4 class="text-center">Rp. <?php echo number_format($r_get_total['jml']); ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
    <div class="card mb-4" style="display:none">
        <div class="card-header" >
            <span class="label label-warning float-right"><?php echo substr($lastTimeSp,0,-1);?></span>
            <h6>Total simpanan koperasi</h6>
        </div>
        <div class="card-body">
            <h4 class="text-center">Rp. <?php echo number_format($r_get_total_sp['jml']); ?></h4>
        </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header">
                <span class="label label-info float-right"><?php echo substr($time,-2,2).'/'.substr($time,0,-2);?></span>
                <h6>Jumlah Pengguna Aktif</h6>
            </div>
            <div class="card-body">
                <h4 class="text-center"><?php echo $r_get_acuser; ?></h4>
            </div>
        </div>
    </div>
</div>
<div class="row pb-2">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li style="display:none"><a class="nav-link active show" data-toggle="tab" href="#tab-grafpin"> Pinjaman</a></li>
                        <li><a class="nav-link " data-toggle="tab" href="#tab-grafsimp">Simpanan</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-grafpin" class="tab-pane">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-8 mt-2">
                                        <canvas id="dbChart"></canvas>                        
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div>                          
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-grafsimp" class="tab-pane active show">
                            <div class="panel-body">
                            <div class="row">
                                    <div class="col-sm-8 mt-2">
                                        <canvas id="dbChartSp"></canvas>                        
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>                                                              
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header">
                <h4>Unit View</h4>
            </div>
            <div class="card-body">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active show" data-toggle="tab" href="#tab-1"> Pinjaman</a></li>
                        <li style="display:none"><a class="nav-link " data-toggle="tab" href="#tab-2">Simpanan</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active show">
                            <div class="panel-body mt-1">
                            <?php
                                $sql_view_unit = mysqli_query($koneksi, "SELECT u.kdpr,nama_unit,SUM(total) as total FROM unit t INNER JOIN user u ON t.kdpr=u.kdpr INNER JOIN pinjaman p ON p.no_anggota=u.no_anggota WHERE periode='$lastTimePj' GROUP BY nama_unit ORDER BY total ASC LIMIT 5");
                            ?>

                                <strong>5 Unit dengan pinjaman terendah</strong>
                                <table class="table border display nowarp mt-1">
                                    <thead>
                                        <tr>
                                            <th>unit</th>
                                            <th>total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $no = 0;
                                            while ($row_view = mysqli_fetch_array($sql_view_unit)){
                                        ?>  
                                            <tr>
                                                <td><?php echo $row_view['nama_unit'];?></td>
                                                <td><?php echo number_format($row_view['total'])."";?></td>                                                                                        
                                            </tr>
                                            <?php } ?>
                                    </tbody>                                                                        
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane ">
                            <div class="panel-body mt-1">
                            <?php
                                $sql_view_unit_sp = mysqli_query($koneksi, "SELECT u.kdpr,nama_unit,SUM(total) as total FROM unit t INNER JOIN user u ON t.kdpr=u.kdpr INNER JOIN simpanan p ON p.no_anggota=u.no_anggota WHERE periode='$lastTimeSp' GROUP BY nama_unit ORDER BY total ASC LIMIT 5");
                            ?>

                                <strong>5 Unit dengan simpanan terendah</strong>
                                <table class="table border display nowarp mt-1">
                                    <thead>
                                        <tr>
                                            <th>unit</th>
                                            <th>total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $no = 0;
                                            while ($row_view_sp = mysqli_fetch_array($sql_view_unit_sp)){
                                        ?>  
                                            <tr>
                                                <td><?php echo $row_view_sp['nama_unit'];?></td>
                                                <td><?php echo number_format($row_view_sp['total'])."";?></td>                                                                                        
                                            </tr>
                                            <?php } ?>
                                    </tbody>                                                                        
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>