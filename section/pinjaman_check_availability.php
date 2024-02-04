<?php

    header("content-type: application/json; charset=UTF-8");

    $response = array();

    if ($_POST['no_anggota']){
        include_once 'koneksi.php';

        $no = $_POST['no_anggota'];

        $sql = $koneksi->query("SELECT * FROM user WHERE no_anggota='$no'");
        $row = $sql->fetch_assoc();
        
        if($sql){
            $response['kdpr'] = $row['kdpr'];
            $response['nama'] = $row['nama'];
            $response['unit'] = $row['unit'];
            $response['message'] = 'Tersedia.';
        }else{
            $response['kdpr'] = "";
            $response['nama'] = "";
            $response['unit'] = "";
            $response['message'] = 'User sudah memiliki pinjaman..';
        }
        echo json_encode($response);
    }

?>