<?php
    $id = $_GET["id"];

    //periode terbaru
    $time = date("ym");
    //cek data base
    $cek_pj = mysqli_query($koneksi,"SELECT * FROM pinjaman WHERE periode = '$periode'");
    $num_cek = mysqli_num_rows($cek_pj);

    $cek_sp = mysqli_query($koneksi, "SELECT * FROM simpanan WHERE periode = '$periode'");
    $num_cek2 = mysqli_num_rows($cek_sp);

    if($num_cek > 0){
        $lastTimePj = $time;
    }else if(($num_cek && $num_cek2) > 0){
        $lastTimePj = $time;
    }else{
        $lastTime = $time-1;
        $lastTimePj = $time-1;
    }

    $sql_prof_user = "SELECT * FROM user u INNER JOIN unit t ON u.kdpr=t.kdpr WHERE id = '$id'";
    $query_prof_user = $koneksi->query($sql_prof_user);
    $hasil_prof_user = mysqli_fetch_array($query_prof_user);
    
    $sql_prof_pinjaman = "SELECT * FROM user u INNER JOIN pinjaman p ON p.no_anggota=u.no_anggota INNER JOIN unit t ON t.kdpr=u.kdpr WHERE id='$id' AND periode='$lastTimePj'";
    $query_prof_pinjaman = $koneksi->query($sql_prof_pinjaman);
    $hasil_prof_pinjaman = mysqli_fetch_array($query_prof_pinjaman); 
    
    $sql_prof_simpanan = "SELECT * FROM user u INNER JOIN simpanan s ON s.no_anggota=u.no_anggota INNER JOIN unit t ON t.kdpr=u.kdpr WHERE id='$id' AND periode='$lastTimePj'";
    $query_prof_simpanan = $koneksi->query($sql_prof_simpanan);
    $hasil_prof_simpanan = mysqli_fetch_array($query_prof_simpanan);  
?>
<div class="">
    <div class="card shadow">
        <div class="card-header">
            <h4>profil user</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body mr-auto" style="margin-left: -10px;"> 
                            <table class="">
                                <tr>
                                    <td><h6>Nama</h6></td>
                                    <td></td>
                                    <td><h6> : </h6></td>
                                    <td></td>
                                    <td><h6 class="ml-2 text-capitalize"><?php echo $hasil_prof_user["nama"]; ?></h6></td>
                                </tr>
                                <tr>
                                    <td><h6>Nomor Anggota</h6></td>
                                    <td></td>
                                    <td><h6> : </h6></td>
                                    <td></td>
                                    <td><h6 class="ml-2"><?php echo $hasil_prof_user["no_anggota"];?></h6></td>
                                </tr>
                                <tr>
                                    <td><h6>Username</h6></td>
                                    <td></td>
                                    <td><h6>:</h6></td>
                                    <td></td>
                                    <td><h6 class="ml-2"><?php echo $hasil_prof_user["username"]; ?></h6></td>
                                </tr>
                                 <tr>
                                    <td><h6>KDPR</h6></td>
                                    <td></td>
                                    <td><h6>:</h6></td>
                                    <td></td>
                                    <td><h6 class="ml-2"><?php echo $hasil_prof_user["kdpr"]; ?></h6></td>
                                </tr>
                                <tr>
                                    <td><h6>Unit</h6></td>
                                    <td></td>
                                    <td><h6>:</h6></td>
                                    <td></td>
                                    <td><h6 class="ml-2"><?php echo $hasil_prof_user["nama_unit"]; ?></h6></td>
                                </tr>
                                <tr>
                                    <td><h6>Level</h6></td>
                                    <td></td>
                                    <td><h6> : </h6></td>
                                    <td></td>
                                    <td><h6 class="ml-2 text-capitalize"><?php                                         
                                        if($hasil_prof_user['level']=='lev0'){
                                            $t = 'admin';
                                        }else if($hasil_prof_user['level']=='lev1'){
                                            $t = 'admin';
                                        }else if($hasil_prof_user['level']=='lev2'){
                                            $t = 'karyawan';
                                        }else{
                                            $t = 'anggota';
                                        }
                                        echo $t;                                                                            
                                        ?></h6></td>
                                </tr>
                            </table>                                                   
                        </div>
                        <div class="card-footer text-right">
                            <a  id="edit_password" data-toggle="modal" data-target="#formModal_editPassword"
                                data-password="<?php echo $hasil_prof_user['password'];?>"
                                data-idu = "<?php echo $hasil_prof_user["id"];?>"
                                class="btn tw btn-warning">
                                <i class="fa fa-key pr-2"></i>
                                Ubah password
                            </a>
                            <a  id="edit_user" data-toggle="modal" data-target="#formModal_editUser" 
                                data-id = "<?php echo $hasil_prof_user["id"];?>"
                                data-nama = "<?php echo $hasil_prof_user['nama'];?>"
                                data-kdpr = "<?php echo $hasil_prof_user['kdpr'];?>"
                                data-no_anggota = "<?php echo $hasil_prof_user['no_anggota'];?>"
                                data-username = "<?php echo $hasil_prof_user['username'];?>"
                                
                                data-level = "<?php echo $hasil_prof_user['level'];?>"
                                class="btn tw btn-info">
                                <i class="fa fa-edit"></i>                                
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li style="display:none"><a class="nav-link active show" data-toggle="tab" href="#tab-1"> Pinjaman</a></li>
                                    <li><a class="nav-link " data-toggle="tab" href="#tab-2">Simpanan</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" id="tab-1" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="card card-inverse shadow px-4 py-4 mb-4">
                                                <div class="card-block">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 text-center">
                                                            <p class="card-text"><strong>Total Pinjaman</strong> </p>
                                                            <h2 class="card-title"><strong>Rp. <?php echo number_format($hasil_prof_pinjaman["total"]);?></strong></h2>
                                                            <p class="card-text pt-3"><strong>Rincian Pinjaman</strong></p>                                    
                                                        </div>                        
                                                        <div class="col-md-4 col-sm-4 text-center pt-4">
                                                            <h5><strong> Rp. <?php echo number_format($hasil_prof_pinjaman["pj_uang"]);?></strong></h5>        
                                                            <button class="btn btn-primary btn-block btn-md mt-4"> Pinjaman Uang  </button>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 text-center pt-4">
                                                                <h5><strong> Rp. <?php echo number_format($hasil_prof_pinjaman["pj_toko"]);?></strong></h5>  
                                                            <button class="btn btn-success btn-block btn-md mt-4"> Pinjaman Toko </button>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 text-center pt-4">
                                                                <h5><strong> Rp. <?php echo number_format($hasil_prof_pinjaman["pj_jasa"]);?></strong></h5>  
                                                            <button type="button" class="btn btn-danger btn-block btn-md mt-4"> Pinjaman Jasa </button>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="tab-2" class="tab-pane active show">
                                        <div class="panel-body">
                                        <div class="card card-inverse shadow px-4 py-4 mb-4">
                                                <div class="card-block">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 text-center">
                                                            <p class="card-text"><strong>Total Simpanan</strong> </p>
                                                            <h2 class="card-title"><strong>Rp. <?php echo number_format($hasil_prof_simpanan["total"]);?></strong></h2>
                                                            <p class="card-text pt-3"><strong>Rincian Simpanan</strong></p>                                    
                                                        </div>                        
                                                        <div class="col-md-4 col-sm-4 text-center pt-4">
                                                            <h5><strong> Rp. <?php echo number_format($hasil_prof_simpanan["sp_pokok"]);?></strong></h5>        
                                                            <button class="btn btn-primary btn-block btn-md mt-4"> Simpanan Pokok </button>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 text-center pt-4">
                                                                <h5><strong> Rp. <?php echo number_format($hasil_prof_simpanan["sp_wajib"]);?></strong></h5>  
                                                            <button class="btn btn-success btn-block btn-md mt-4"> Simpanan Wajib </button>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 text-center pt-4">
                                                                <h5><strong> Rp. <?php echo number_format($hasil_prof_simpanan["sp_lain"]);?></strong></h5>  
                                                            <button class="btn btn-danger btn-block btn-md mt-4"> Simpanan Lain </button>  
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
                </div>
            </div>
        </div>
    </div>
</div>