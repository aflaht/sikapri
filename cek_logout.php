<?php
    include_once "koneksi.php";
    //log activity
    $no_anggota = $_GET["id"];
    $activity = "Logout";
    $time = date("Y-m-d H:i:s");
    $log_sql = $koneksi->query("INSERT INTO activity_log(id, no_anggota, activity, time) VALUES('', '$no_anggota', '$activity', '$time')");

    session_start();
    session_destroy();
    header("location:index.php?pesan=logout");
?>