<?php

    header("content-type: application/json; charset=UTF-8");

    $response = array();

    if ($_POST['undo']=="unit"){
        include_once 'koneksi.php';

        $sql = $koneksi->query("SELECT * FROM re_query WHERE db = 'unit' ORDER BY time DESC LIMIT 1");
        while($fetch = $sql->fetch_assoc()){
            $query = $fetch['query'];
            $query = str_replace("@","'",$query);
            $h = $koneksi->query($query);
            $id = $fetch['id_recovery'];
            $sql_del = $koneksi->query("DELETE FROM re_query WHERE id_recovery = '$id'");
        }
                
        if($sql){
            $response['status'] = 'success';
            $response['message'] = 'Data Berhasil Dikembalikan';
        }else{
            $response['status'] = 'error';
            $response['message'] = 'Tidak Bisa Mengembalikan Data';
        }
        echo json_encode($response);
    }

?>