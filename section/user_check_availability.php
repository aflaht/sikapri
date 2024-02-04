<?php
    include_once '../koneksi_data.php';

    $koneksi = mysqli_connect($con['host'],$con['user'],$con['pass'],$con['db']);
    if(!empty($_POST["username"])){
        $q_check_username = "SELECT * FROM user WHERE username = '" . $_POST["username"] . "'";
        $sql_check_username = $koneksi->query($q_check_username);
        if(mysqli_num_rows($sql_check_username) > 0) {
            echo "<span class='status-not-available'>Username telah digunakan.</span>";
        }else{
            //echo "<span class='status-available'>Tersedia.</span>";
            echo "Tersedia.";
        }
    }
    if(!empty($_POST["usernameEdit"])){
        $q_check_username = "SELECT * FROM user WHERE username = '" . $_POST["usernameEdit"] . "' AND id != '" . $_POST["id"] . "'";
        $sql_check_username = $koneksi->query($q_check_username);
        if(mysqli_num_rows($sql_check_username) > 0) {
            echo "<span class='status-not-available'>Username telah digunakan.</span>";
        }else{
            //echo "<span class='status-available'>Tersedia.</span>";
            echo "Tersedia.";
        }
    }
    if(!empty($_POST["no_anggota"])){
        $q_check_cust = "SELECT * FROM user WHERE no_anggota = '" . $_POST["no_anggota"] . "'";
        $sql_check_cust = $koneksi->query($q_check_cust);
        if(mysqli_num_rows($sql_check_cust) > 0) {
            echo "<span class='status-not-available'>Nomor anggota sudah terdaftar.</span>";
        }else{
            //echo "<span class='status-available'>Tersedia.</span>";
            echo "Tersedia.";
        }
    }    
?>