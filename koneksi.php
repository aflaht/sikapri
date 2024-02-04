<?php        
    include_once 'koneksi_data.php';
    $koneksi = mysqli_connect($con['host'],$con['user'],$con['pass'],$con['db']);

    if(mysqli_connect_errno()){
        echo "Koneksi ke database gagal : ". mysqli_connect_error();
    }
?>