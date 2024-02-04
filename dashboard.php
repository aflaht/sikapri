<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Admin</title>

    <!-- Bootstrap-->
    <link rel="stylesheet" href="import/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="import/DataTables/css/dataTables.bootstrap4.min.css">
    <!-- <link rel="stylesheet" href="import/fontawesome-free-5.6.3-web/css/all.css"> -->
    <link rel="stylesheet" href="import/DataTables/Buttons-1.5.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="import/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
    <!-- Toast Notification by PeHaa(simple notification solution) -->
    <link rel="stylesheet" href="https://unpkg.com/simple-notifications-solution@1.0.0/dist/Notifications.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/4ac800bafe.js"></script>

    <!-- PHP func -->
    <?php
        include 'koneksi.php';
        include 'modals.php';

        //cek session jika ndak ada kembali ke index
        if(!isset($_SESSION['username'])){
            ?>
            <script>
                    window.location.href="index.php?pesan=gagal";
            </script><?php
//            header("location:index.php?pesan=gagal");
            exit();
        }

        if($_SESSION['level']==""){
            ?><script>
                    window.location.href="index.php?pesan=gagal";
            </script><?php
//            header("location:index.php?pesan=gagal");
        }else if(($_SESSION['level']=="lev2") || ($_SESSION['level']=="lev3")){
            ?><script>
                    window.location.href="dashboard_user.php?section=start";
            </script><?php
//            header("location:dashboard_user.php?section=start");
            exit();
        }

        //Bentuk array user
        $account_number = $_SESSION['account_id'];
        $query2 = "SELECT * FROM user WHERE id='$account_number'";
        $res2 = $koneksi->query($query2);
        $row2 = $res2->fetch_assoc();

        //===========================GLOBAL VARIABLE===========================//
        //Periode Saat Ini
        $periode = date('ym');

        //Jumlah Periode Pada Tabel Pinjaman
        $countPeriodePj = mysqli_query($koneksi,"SELECT COUNT(DISTINCT(periode)) FROM pinjaman");
        $rowCountPeriodePj = $countPeriodePj->fetch_assoc();
        $totalPeriode = $rowCountPeriodePj["COUNT(DISTINCT(periode))"];

        //Nomor Anggota Admin
        //->Digunakan pada saat penghapusan data pinjaman secara menyeluruh agar data pinjaman admin tidak ikut terhapus
        $queryFindAdminNum = mysqli_query($koneksi,"SELECT no_anggota FROM user WHERE level='lev0'");
        $findAdminNum = $queryFindAdminNum->fetch_array(MYSQLI_ASSOC);
        
        $NumAdmin = $findAdminNum["no_anggota"];


        //=====================================================================//

        //Cek database pinjaman dan simpanan apakah sudah uptodate
        $cek_pj = mysqli_query($koneksi,"SELECT * FROM pinjaman WHERE periode = '$periode'");
        $num_cek = mysqli_num_rows($cek_pj);

        $cek_sp = mysqli_query($koneksi, "SELECT * FROM simpanan WHERE periode = '$periode'");
        // $num_cek2 = mysqli_num_rows($cek_sp);
        $num_cek2 = 1;
        if(($num_cek > 0) || ($num_cek2 > 0)){
            if($num_cek2 > 0){
                if($num_cek > 0){

                }else{
                    ?>
                        <p class="notification is-warning" role=""><i class="fa fa-exclamation-circle mr-2"></i> Data pinjaman periode terbaru belum diupdate !<button class="delete" type="button">x</button></p>
                    <?php
                }
            }else{
                ?>
                <p class="notification is-warning" role=""><i class="fa fa-exclamation-circle mr-2"></i> Data simpanan periode terbaru belum diupdate !<button class="delete" type="button">x</button></p>
                <?php
            }
        }else{
            ?>
            <p class="notification is-warning" role="alert"><i class="fa fa-exclamation-circle mr-2"></i> Data pinjaman dan simpanan periode terbaru belum diupdate !<button class="delete" type="button">x</button></p>
            <?php
        }
    ?>

</head>
<body>
<?php if(isset($_SESSION['alert'])){
    if($_SESSION['alert'] == 'tambah-success'){
        echo '<div id=\'alert-tambah-s\'></div>';
    }else if($_SESSION['alert'] == 'edit-success'){
        echo '<div id=\'alert-edit-s\'></div>';
    }

    unset($_SESSION['alert']);
} ?>
    <div class="wrapper">
        <!-- Navbar  -->
        <header>
            <nav class="navbar navbar-expand-s shadow fixed-top">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info btn-sm">
                        <span><i class="fa fa-bars mr-2"></i>Menu</span>
                    </button>
                    <h5 class="center">SISTEM INFORMASI KPRI UNDIP</h5>
                </div>
            </nav>
        </header>
        <!-- Sidebar  -->
        <nav id="sidebar" class="shadow">
            <div class="sidebar-header text-center">
                <img src="img/logo.png" alt="" class="thumb text-center mb-3">
                <h5>Admin SIKAPRI</h5>
            </div>

            <ul class="list-unstyled">
                <p class="name ml-2"><?php echo $row2["nama"]; ?></p>
                <p class="level ml-2">
                    <?php
                        if($row2['level']=='lev0'){
                            $t = 'admin';
                        }else if($row2['level']=='lev1'){
                            $t = 'admin';
                        }else if($row2['level']=='lev2'){
                            $t = 'karyawan';
                        }else{
                            $t = 'anggota';
                        }
                        echo $t;
                    ?>
                </p>
            </ul>
            <ul class="list-unstyled components">
                <p class="header text-center">Menu</p>
                <li>
                    <a href="?section=start" class="menu"><i class="fa fa-home px-2"></i>Beranda</a>
                </li>
                <li>
                    <a href="?section=user" class="menu"><i class="fa fa-users px-2"></i>User</a>
                </li>
                <li>
                    <!-- <a href="?section=pinjaman" class="menu"><i class="fa fa-handshake px-2"></i>Pinjaman</a> -->
                </li>
                <li>
                    <a href="?section=simpanan" class="menu"><i class="fa fa-hand-holding-usd px-2"></i>Simpanan</a>
                </li>
                <li>
                    <a href="?section=unit" class="menu"><i class="fa fa-university px-2"></i>Unit</a>
                </li>
                
            </ul>

            <ul class="list-unstyled">
                <li class="CTAs">
                    <a href="dashboard.php?section=userprofile&id=<?php echo $row2["id"]; ?>" class="profile">Profil</a>
                </li>
                <li class="CTAs">
                    <a href="cek_logout.php?id=<?php echo $row2["no_anggota"]; ?>" class="logout">Logout</a>
                </li>
                <li class="CTAs scroller">
                    <a data-toggle="modal" data-target="#aboutAppModal" href="" >about this app</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <div class="container-fluid px-xl-1">
                <section class="">
                    <?php
                        $section = $_GET['section'];

                        if($section == "start"){
                            include 'section/start.php';
                        }else if($section == "user"){
                            include 'section/user.php';
                        }else if($section == "pinjaman"){
                            include 'section/pinjaman.php';
                        }else if($section == "delAll"){
                            include 'section/pinjaman_del_all.php';
                        }else if($section == "delAllSimpanan"){
                            include 'section/simpanan_del_all.php';
                        }else if($section == "userprofile"){
                            include 'section/user_profile.php';
                        }else if($section == "simpanan"){
                            include 'section/simpanan.php';
                        }else if($section == "delAllUser"){
                            include 'section/user_del_all.php';
                        }else if($section == "unit"){
                            include 'section/unit.php';
                        }else if($section == "delAllUnit"){
                            include 'section/unit_del_all.php';
                        }else if($section == "inventaris"){
                            include 'section/inventaris.php';
                        }
                    ?>
                </section>
            </div>
        </div>
    </div>

    <!-- JavaScript files-->
    <script type="text/javascript" src="import/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="import/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="import/DataTables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="import/DataTables/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="import/popper.js/umd/popper.min.js"> </script>
    <script type="text/javascript" src="import/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="import/jquery/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="import/chart.js/Chart.js"></script>
    <!-- Sweet Alert untuk alert yg cute -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <!-- Toast Notification by PeHaa(simple notification solution) -->
    <script src="https://unpkg.com/simple-notifications-solution/dist/Notifications.js"></script>

    <!-- ======================= Modals ========================== -->
                            <!-- Edit Password -->
    <div id="formModal_editPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" aria-hidden="true" style="display: none;">
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

    <?php
        if(isset($_POST['edit_password'])){
            $password_lama = $_POST['password-lama'];
            $password_baru = $_POST['password-baru'];
            $password_baru_ver = $_POST['password-baru-ver'];
            $password_ver = $_POST['password-ver'];
            $idUser = $_POST['idu'];
            if($password_lama == $hasil_prof_user['password']){
                if($password_baru == $password_baru_ver){
                    if($password_ver == $row2['password']){
                        $query_edit_password = $koneksi->query("UPDATE user SET
                                                        password = '$password_baru_ver'
                                                    WHERE id = '$idUser'
                        ");
                        if(!$query_edit_password){
                            die("Gagal input data : ".$koneksi->error);
                        }else{
                            //log activity
                            $no_anggota = $row2["no_anggota"];
                            $activity = "edit password->".$hasil_prof_user['username'];
                            $time = date("Y-m-d H:i:s");
                            $log_sql = $koneksi->query("INSERT INTO activity_log(id, no_anggota, activity, time) VALUES('', '$no_anggota', '$activity', '$time')");

                            ?>
                                <script type="text/javascript">
                                var id = $(this).data('id');
                                    alert("Berhasil Mengubah Data User");
                                    // window.location.href="dashboard.php?section=user_profile&id=$idUser";
                                </script>
                            <?php
                            // header("location:section=user_profile&id=$idUser");
                        }
                    }
                }
            }else{
                ?>
                <script type="text/javascript">
                    alert("Password User Tidak Sesuai");
                </script>
                <?php
            }
        }
    ?>
                         <!-- End Edit Password -->

    <?php include 'javascript.php';?>
</body>
</html>
