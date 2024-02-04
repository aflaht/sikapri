<?php

    header("content-type: application/json; charset=UTF-8");

    $response = array();

    if ($_POST['kdpr']){
        include_once 'koneksi.php';

        $id = $_POST['kdpr'];

        $sql_recovery = $koneksi->query("SELECT * FROM unit WHERE kdpr = '$id'");
        $fetch = $sql_recovery->fetch_assoc();        
        $nama = $fetch["nama_unit"];
        $kdpr = $fetch["kdpr"];
        $makeQ = "INSERT INTO unit(kdpr, nama_unit) VALUES (@$kdpr@,@$nama@)";
        $time = date("Y-m-d H:i:s");

        $insert_rec =  $koneksi->query("INSERT INTO re_query(id_recovery, query, db, time) VALUES ('', '$makeQ', 'unit', '$time')");

        $sql = $koneksi->query("DELETE FROM unit WHERE kdpr = '$id'");
        
        if($sql){
            $response['status'] = 'success';
            $response['message'] = 'Data Berhasil Dihapus';
        }else{
            $response['status'] = 'error';
            $response['message'] = 'Tidak Bisa Menghapus Data';
        }
        echo json_encode($response);
    }

?>