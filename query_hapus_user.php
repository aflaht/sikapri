<?php

    header("content-type: application/json; charset=UTF-8");

    $response = array();

    if ($_POST['id']){
        include_once 'koneksi.php';

        $id = $_POST['id'];

        $sql_recovery = $koneksi->query("SELECT * FROM user WHERE id = '$id'");
        $fetch = $sql_recovery->fetch_assoc();
        $id = $fetch["id"];
        $nama = $fetch["nama"];
        $no_anggota = $fetch["no_anggota"];
        $username = $fetch["username"];
        $password = $fetch["password"];
        $kdpr = $fetch["kdpr"];
        $level = $fetch["level"];
        $makeQ = "INSERT INTO user(id, username, password, no_anggota, nama, kdpr, level) VALUES (@$id@,@$username@,@$password@,@$no_anggota@,@$nama@,@$kdpr@,@$level@)";
        $time = date("Y-m-d H:i:s");

        $sql_recovery_pj = $koneksi->query("SELECT * FROM pinjaman WHERE no_anggota = '$no_anggota'");
        
        $makeQ_pj = "INSERT INTO pinjaman(id_pinjaman, no_anggota, pj_uang, pj_toko, pj_jasa, total, periode) VALUES";
        while($fetch_pj = $sql_recovery_pj->fetch_assoc()){
            $id_pinjaman = $fetch_pj["id_pinjaman"];
            $no_anggota_pj = $fetch_pj["no_anggota"];
            $pj_uang = $fetch_pj["pj_uang"];
            $pj_toko = $fetch_pj["pj_toko"];
            $pj_jasa = $fetch_pj["pj_jasa"];
            $total = $fetch_pj["total"];
            $periode = $fetch_pj["periode"];

            $makeQ_pj .= "(@$id_pinjaman@,@$no_anggota_pj@,@$pj_uang@,@$pj_toko@,@$pj_jasa@,@$total@,@$periode@),";
        }
        $makeQ_pj = substr($makeQ_pj,0,-1);

        $sql_recovery_sp = $koneksi->query("SELECT * FROM simpanan WHERE no_anggota = '$no_anggota'");
        
        $makeQ_sp = "INSERT INTO simpanan(id, no_anggota, sp_pokok, sp_wajib, sp_lain, total, periode) VALUES";
        while($fetch_sp = $sql_recovery_sp->fetch_assoc()){
            $id_simpanan = $fetch_sp["id"];
            $no_anggota_sp = $fetch_sp["no_anggota"];
            $sp_pokok = $fetch_sp["sp_pokok"];
            $sp_wajib = $fetch_sp["sp_wajib"];
            $sp_lain = $fetch_sp["sp_lain"];
            $total = $fetch_sp["total"];
            $periode = $fetch_sp["periode"];

            $makeQ_sp .= "(@$id_simpanan@,@$no_anggota_pj@,@$sp_pokok@,@$sp_wajib@,@$sp_lain@,@$total@,@$periode@),";
        }
        $makeQ_sp = substr($makeQ_sp,0,-1);

        $insert_rec =  $koneksi->query("INSERT INTO re_query(id_recovery, query, db, time) VALUES ('', '$makeQ', 'user', '$time'),('', '$makeQ_pj', 'pinjaman', '$time'),('', '$makeQ_sp', 'simpanan', '$time')");

        $sql = $koneksi->query("DELETE FROM user WHERE id = '$id'");
        $sql2 = $koneksi->query("DELETE FROM pinjaman WHERE no_anggota = '$no_anggota'");
        $sql3 = $koneksi->query("DELETE FROM simpanan WHERE no_anggota = '$no_anggota'");

        if($sql && $sql2 && $insert_rec){
            $response['status'] = 'error';
            $response['message'] = 'Tidak Bisa Menghapus Data';
        }else{
            $response['status'] = 'success';
            $response['message'] = 'Data Berhasil Dihapus';
            
        }
        echo json_encode($response);
    }

?>