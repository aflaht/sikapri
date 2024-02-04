<?php

    header("content-type: application/json; charset=UTF-8");

    $response = array();

    if ($_POST['id_pinjaman']){
        include_once 'koneksi.php';

        $id = $_POST['id_pinjaman'];

        $sql = $koneksi->query("UPDATE pinjaman SET pj_uang = '0', pj_toko = '0', pj_jasa = '0', total = '0' WHERE pinjaman.id_pinjaman = '$id'");
        
        if($sql){
            $response['status'] = 'success';
            $response['message'] = 'Data Berhasil Dikosongkan';
        }else{
            $response['status'] = 'error';
            $response['message'] = 'Tidak Bisa Menghapus Data';
        }
        echo json_encode($response);
    }

?>