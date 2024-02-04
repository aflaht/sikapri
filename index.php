<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <!-- Bootstrap-->
    <link rel="stylesheet" href="import/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
</head>
<body class="bg1">

    <!-- Check Login Status -->
    <?php 
    
    if(isset($_SESSION['level'])){
        if($_SESSION['level'] == "lev0"){
        ?>
        <script>
        window.location.href="dashboard.php?section=start";
        </script>
        <?php
//            header("location:dashboard.php?section=start");
            exit();
        } else if($_SESSION['level'] == "lev1"){
        ?>
        <script>
        window.location.href="dashboard.php?section=start";
        </script>
        <?php
//            header("location:dashboard.php?section=start");
            exit();
        } else if($_SESSION['level'] == "lev2"){
        ?>
        <script>
        window.location.href="dashboard_user.php?section=start";
        </script>
        <?php
//            header("location:dashboard_user.php?section=start");
            exit();
        } else if($_SESSION['level'] == "lev3"){
        ?>
        <script>
        window.location.href="dashboard_user.php?section=start";
        </script>
        <?php
//            header("location:dashboard_user.php?section=start");
            exit();
        }
    }
    
	
    ?>
    
    <div class="page-holder d-flex align-items-center">
        <div class="container">
            <div class="row py-2">
                <div class="col text-center">
                    <div class="card shadow pt-1">
                        <h3 class="hhs">SISTEM INFORMASI SIMPAN & PEMBIAYAAN</h3>
                        <h5 class="pb-0">KOPERASI PEGAWAI REPUBLIK INDONESIA UNIVERSITAS DIPONEGORO</h5>
                        <hr class="my-0 py-0">
                        <p class="bl my-1 py-0">Jl. Prof. Soedarto,SH Tembalang, Semarang Telp (024)7470612,</p>
                        <p class="bl">email : kapridipo@gmail.com, website : www.kpri.ac.id</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-3"></div>
                <div class="col px-lg-4 mx-5 text-center align-self-end">
                    <div class="">
                        <div class="card shadow">
                            <div class="">
                            <img src="img/logo.png" alt="" class="thumb mt-3">
                            </div>
                            <div class="card-body">
                                <?php
                                if(isset($_GET['pesan'])){
                                    if($_GET['pesan'] == "gagal"){
                                        echo "<div class=\"alert alert-danger alert-dismissable \">                                        
                                        Login Gagal ! username dan password salah. <a class=\"alert-link\" href=\"#\"></a>
                                    </div>";
                                    }else if($_GET['pesan'] == "logout"){
                                        echo "<div class=\"alert alert-success alert-dismissable text-center\">                                        
                                        Anda berhasil logout. <a class=\"alert-link\" href=\"#\"></a>
                                    </div>";
                                    }
                                }
                                ?>
                                <form method="post" action="cek_login.php" class="mt-4">
                                    <div class="mb-4">
                                        <input type="text" name="username" placeholder="Masukan username" class="form-control-lg form-control shadow" required autofocus pattern=".{4,}" title="Harus lebih dari 4 karakter">
                                    </div>
                                    <div class="mb-4">
                                        <input type="password" name="password" placeholder="Masukan password" class="form-control-lg form-control shadow" required autocomplete="off" pattern=".{4,}" title="Harus lebih dari 4 karakter">
                                    </div>
                                    <button type="submit" class="btn btn-info shadow">- Log In -</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="bl mt-3 mb-3 text-center">Aplikasi ini memberikan informasi mengenai saldo pinjaman dan simpanan anggota KPRI UNDIP.<br> Untuk dapat mengakses harus memiliki username dan password dari pihak KPRI UNDIP.<br> KPRI UNDIP - 2019 </p>
        </div>
    </div>
</body>

<script type="text/javascript" src="import/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="import/jquery/jquery.min.js"></script>
<script type="text/javascript" src="import/popper.js/umd/popper.min.js"> </script>
</html>