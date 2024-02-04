<?php
// mengaktifkan session php
session_start();

// menghubungkan dengan koneksi
include 'koneksi.php';

// menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = trim($_POST['password']);

// menyeleksi data admin dengan username dan password yang sesuai
$data = mysqli_query($koneksi,"select * from user where username='$username' and password='$password'");
$cek = mysqli_num_rows($data);

// multyuser
if($cek > 0){
    $data = mysqli_fetch_assoc($data);
    //log activity
    $no_anggota = $data["no_anggota"];
    $activity = "Login";
    $time = date("Y-m-d H:i:s");
    $log_sql = $koneksi->query("INSERT INTO activity_log(id, no_anggota, activity, time) VALUES('', '$no_anggota', '$activity', '$time')");

    // super admin
    if($data['level']=="lev0"){
        $_SESSION["account_id"] = $data["id"];
        $_SESSION['username']=$username;
        $_SESSION['level']="lev0";
        header("location:dashboard.php?section=start");        
    }else if($data['level']=="lev1"){
        $_SESSION['username']=$username;
        $_SESSION['level']="lev1";
        header("location:admin.php");
    }else if($data['level']=="lev2"){
        $_SESSION['username']=$username;
        $_SESSION['level']="lev2";
        header("location:dashboard_user.php?section=start");    
    }else if($data['level']=="lev3"){
        $_SESSION["account_id"] = $data["id"];
        $_SESSION['username']=$username;
        $_SESSION['level']="lev3";
        header("location:dashboard_user.php?section=start");
    }else{
        header("location:index.php?pesan=gagal");
    }
}else{
    header("location:index.php?pesan=gagal");
    exit();
}

if(mysqli_num_rows($data) > 0){
    $row_akun = mysqli_fetch_array($data);
    $_SESSION["account_id"] = $row_akun["id"];
}

?>