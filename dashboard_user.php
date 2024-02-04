<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="import/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="import/DataTables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="import/fontawesome-free-5.6.3-web/css/all.css">
    <link rel="stylesheet" href="import/DataTables/Buttons-1.5.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="import/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
    <!-- Toast Notification by PeHaa(simple notification solution) -->
    <link rel="stylesheet" href="https://unpkg.com/simple-notifications-solution@1.0.0/dist/Notifications.css">    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/4ac800bafe.js"></script>
    
    <!-- PHP func -->
    <?php        
        include 'koneksi.php';

        if($_SESSION['level']==""){
        ?>
        <script>
        window.location.href="index.php?pesan=gagal";
        </script>        
        <?php
//            header("location:index.php?pesan=gagal");
        }

        $periode = date('ym');

        function pertodate($periode){
            $mont = substr($periode,2);
            $yr = substr($periode,0,-2);
            $m;
            switch($mont){
                case "01":
                    $m = "Jan";
                    break;
                case "02":
                    $m = "Feb";
                    break;
                case "03":
                    $m = "Mar";
                    break;
                case "04":
                    $m = "Apr";
                    break;
                case "05":
                    $m = "Mei";
                    break;
                case "06":
                    $m = "Jun";
                    break;
                case "07":
                    $m = "Jul";
                    break;
                case "08":
                    $m = "Ags";
                    break;
                case "09":
                    $m = "Sep";
                    break;
                case "10":
                    $m = "Okt";
                    break;
                case "11":
                    $m = "Nov";
                    break;
                case "12":
                    $m = "Des";
                    break;
            }
            echo $m."-20".$yr;
        }
         //periode terbaru
         $time = date("ym");
         //cek data base
         $cek_pj = mysqli_query($koneksi,"SELECT * FROM pinjaman WHERE periode = '$periode'");
         $num_cek = mysqli_num_rows($cek_pj);

         $cek_sp = mysqli_query($koneksi, "SELECT * FROM simpanan WHERE periode = '$periode'");
         $num_cek2 = mysqli_num_rows($cek_sp);

         if($num_cek > 0){
             $lastTimePj = $time;
         }else if($num_cek2 > 0){
             $lastTimeSp = $time;
         }else if(($num_cek && $num_cek2) > 0){
             $lastTimePj = $time;
             $lastTimeSp = $time;
         }else{
             $lastTime = $time-1;
             $lastTimePj = $time-1;
             $lastTimeSp = $time-1;
         }
        $account_number = $_SESSION['account_id'];
        $query2 = "SELECT * FROM user u INNER JOIN unit t ON u.kdpr=t.kdpr WHERE id='$account_number'";
        $query = "SELECT * FROM user u INNER JOIN pinjaman p ON p.no_anggota=u.no_anggota  INNER JOIN unit t ON t.kdpr=u.kdpr  WHERE id='$account_number' AND p.periode='$lastTimePj'";
        $query3 = "SELECT * FROM user u INNER JOIN simpanan s ON s.no_anggota=u.no_anggota  INNER JOIN unit t ON t.kdpr=u.kdpr  WHERE id='$account_number' AND s.periode='$lastTimeSp'";
        
        $res = $koneksi->query($query);
        $res2 = $koneksi->query($query2);
        $res3 = $koneksi->query($query3);

        $row = $res2->fetch_assoc();
        $row2 = $res->fetch_assoc();
        $row3 = $res3->fetch_assoc();

        $sql_all_pj = "SELECT * FROM user u INNER JOIN pinjaman p ON p.no_anggota=u.no_anggota WHERE id='$account_number' order by periode asc";
        $q_all_pj = $koneksi->query($sql_all_pj);

        $sql_all_sp = "SELECT * FROM simpanan s INNER JOIN user u ON s.no_anggota=u.no_anggota WHERE id='$account_number' order by periode asc";
        $q_all_sp = $koneksi->query($sql_all_sp);
        //$r_all_pj = $q_all_pj->fetch_assoc();
    ?>  
    <title>KPRI UNDIP</title>
</head>
<body class="bg">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script> 
<?php if(isset($_SESSION['alert'])){
    if($_SESSION['alert'] == 'username-success'){
        echo '<div id="alert-username-s"></div>';
    }else if($_SESSION['alert'] == 'password-success'){
        echo '<div id="alert-password-s"></div>';
    }

    unset($_SESSION['alert']);
} ?>
    <div class="content-wrapper">
        <header>
            <nav class="navbar no-brdr-rad fixed shadow">
                <div class="container-fluid">                            
                    <h4> KPRI UNDIP</h4>
                    <?php pertodate($periode); ?>
                </div>
            </nav>
        </header>
        <div class="content mt-5">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-3 col-sm-3 mb-5 hidden-xs">
                        <div class="card shadow">
                            <div class="card-header">
                                <table class="mb-2">
                                    <tr>
                                        <!-- <td>
                                            <h6>Nama</h6>
                                        </td>
                                        <td><h6>:</h6></td> -->
                                        <td>
                                            <h6><?php echo $row['nama'];?></h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- <td>
                                            <p class="wl py-0 my-0">No.</p>
                                        </td>
                                        <td><p class="wl py-0 my-0">:</p></td> -->
                                        <td>
                                            <p class="wl py-0 my-0"><?php echo $row['no_anggota'];?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- <td>
                                            <p class="wl py-0 my-0">Unit</p>
                                        </td>
                                        <td><p class="wl py-0 my-0">:</p></td> -->
                                        <td>
                                            <p class="wl py-0 my-0"><?php echo $row['nama_unit'];?></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="card-body">
                                <a href="dashboard_user.php?section=start">Beranda</a> 
                                <p></p>
 <!--                                <p>Simpanan</p>
                                <p>Pinjaman</p> -->
                                <div class="line"></div>
                                <p>Tentang Web</p>
                                <a href="dashboard_user.php?section=pengaturan">Pengaturan</a> 
                                <p></p>   
                                <a href="cek_logout.php?id=<?php echo $row["no_anggota"]; ?>">Keluar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <?php
                            $section = $_GET['section'];

                            if($section == "start"){
                                include 'section_anggota/start.php';
                            }else if($section == "pengaturan"){
                                include 'section_anggota/pengaturan.php';
                            }
                        ?>                                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script type="text/javascript" src="import/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="import/DataTables/datatables.min.js"></script>    
    <script type="text/javascript" src="import/DataTables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="import/DataTables/js/dataTables.bootstrap4.min.js"></script>  
    <script type="text/javascript" src="import/DataTables/Buttons-1.5.4/js/dataTables.buttons.min.js"></script> 
    <script type="text/javascript" src="import/DataTables/Buttons-1.5.4/js/buttons.html5.min.js"></script>  
    <script type="text/javascript" src="import/DataTables/Buttons-1.5.4/js/buttons.flash.min.js"></script>   


    <script type="text/javascript" src="import/popper.js/umd/popper.min.js"> </script>
    <script type="text/javascript" src="import/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="import/jquery/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="import/chart.js/Chart.js"></script>
    <!-- Sweet Alert untuk alert yg cute -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <!-- Toast Notification by PeHaa(simple notification solution) -->
    <script src="https://unpkg.com/simple-notifications-solution/dist/Notifications.js"></script>    

    <script type="text/javascript">
        $(document).ready(function () {                                    
            $('#table-total').DataTable({
                "language": {
                    "lengthMenu": "Menampilkan _MENU_ records per halaman",
                    "zeroRecords": "Hasil pencarian tidak ditemukan - maaf",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
                    "thousands":      ".",
                    "infoEmpty": "Record tidak ditemukan",
                    "search":         "Cari:",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Berikutnya",
                        "previous":   "Sebelumnya"
                    },
                    "infoFiltered": "(filtered from _MAX_ total records)"
                },                
                "order": [[ 0, "asc" ]]
            });      
            $('#table-total2').DataTable({
                "language": {
                    "lengthMenu": "Menampilkan _MENU_ records per halaman",
                    "zeroRecords": "Hasil pencarian tidak ditemukan - maaf",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
                    "thousands":      ".",
                    "infoEmpty": "Record tidak ditemukan",
                    "search":         "Cari:",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Berikutnya",
                        "previous":   "Sebelumnya"
                    },
                    "infoFiltered": "(filtered from _MAX_ total records)"
                },                
                "order": [[ 0, "asc" ]]
            }); 

            var alertUsername = $('#alert-username-s');
            var alertPassword = $('#alert-password-s');

            if(alertUsername.length){
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil',
                    text: 'Berhasil Mengubah Username',
                });
            } else if(alertPassword.length){
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil',
                    text: 'Berhasil Mengubah Password',
                });
            }                                    
        });

        function checkAvailabilityEdit() {
            $("#loaderIconEdit").show();
            jQuery.ajax({
                url: "section/user_check_availability.php",
                data:'usernameEdit='+$("#usernameB").val()+'&id='+$("#fId").val(),
                type: "POST",
                success:function(response){
                    $("#userEdit-availability-status").html(response);
                    $("#loaderIconEdit").hide();
                    if(response == "Tersedia."){
                        return true;
                    }else{
                        return false;
                    }                        
                },
                error:function (){}
            });
        }

        function checkEdit(){
            var editUsername = document.getElementById("userEdit-availability-status").innerHTML;

            if(editUsername == "Tersedia."){
                return true;            
            } else {            
                swal.fire("Terdapat data yang salah");
                return false;
                event.preventDefault();
            }
        }
        var btn = $('#button');
        var btn2 = $('#button2');
        btn2.addClass('show');
        $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
            btn2.removeClass('show');
        } else {
            btn.removeClass('show');
            btn2.addClass('show');
        }
        });


        btn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '300');
        });

        btn2.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:1500}, '300');
        });


    </script>
    <?php
        $rend ='';
        while($r = mysqli_fetch_array($q_periode)){
            $perp = ($r['periode']);
            $mont = substr($perp,2);
            $m;
            switch($mont){
                case "01":
                    $m = "Jan";
                    break;
                case "02":
                    $m = "Feb";
                    break;
                case "03":
                    $m = "Mar";
                    break;
                case "04":
                    $m = "Apr";
                    break;
                case "05":
                    $m = "Mei";
                    break;
                case "06":
                    $m = "Jun";
                    break;
                case "07":
                    $m = "Jul";
                    break;
                case "08":
                    $m = "Ags";
                    break;
                case "09":
                    $m = "Sep";
                    break;
                case "10":
                    $m = "Okt";
                    break;
                case "11":
                    $m = "Nov";
                    break;
                case "12":
                    $m = "Des";
                    break;
            }
            // $rend = $rend.'"'.$perp.'"';
            // $kom = ",";
            $rend = $rend.'"'.$m.'",';
        }
        $rend = trim($rend, ",");
       
    ?>
    <script>
        var ctx = document.getElementById("chartPjTot");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php echo $rend;?>],
                datasets: [{
                        label: 'total pinjaman',
                        data: [<?php while ($p = mysqli_fetch_array($q_total)) { echo '"' . $p['total'] . '",';}?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderWidth: 1
                    }]
            },
            options: {
                tooltips: {
                    mode: 'label',
                    label: 'mylabel',
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
                    },
                scales: {
                    yAxes: [{
                            ticks: {
                                callback: function(label, lideData, labels) { return label/1000000; },
                                beginAtZero: true
                            }
                        }]
                }
            }
        });
    </script>

    <?php
        $rend2 ='';
        while($r2 = mysqli_fetch_array($q_periode_sp)){
            $perp2 = ($r2['periode']);
            $mont2 = substr($perp2,2);
            $m2;
            switch($mont2){
                case "01":
                    $m2 = "Jan";
                    break;
                case "02":
                    $m2 = "Feb";
                    break;
                case "03":
                    $m2 = "Mar";
                    break;
                case "04":
                    $m2 = "Apr";
                    break;
                case "05":
                    $m2 = "Mei";
                    break;
                case "06":
                    $m2 = "Jun";
                    break;
                case "07":
                    $m2 = "Jul";
                    break;
                case "08":
                    $m2 = "Ags";
                    break;
                case "09":
                    $m2 = "Sep";
                    break;
                case "10":
                    $m2 = "Okt";
                    break;
                case "11":
                    $m2 = "Nov";
                    break;
                case "12":
                    $m2 = "Des";
                    break;
            }
            // $rend = $rend.'"'.$perp.'"';
            // $kom = ",";
            $rend2 = $rend2.'"'.$m2.'",';
        }
        $rend2 = trim($rend2, ",");
       
    ?>
    <script>
        var ctx2 = document.getElementById("chartSpTot");
        var myChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: [<?php echo $rend2;?>],
                datasets: [{
                        label: 'total simpanan',
                        data: [<?php while ($s = mysqli_fetch_array($q_total_sp)) { echo '"' . number_format($s['total'],0,'','') . '",';}?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderWidth: 1
                    }]
            },
            options: {
                tooltips: {
                    mode: 'label',
                    label: 'mylabel',
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
                    },
                scales: {
                    yAxes: [{
                            ticks: {
                                callback: function(label, lideData, labels) { return label/1000000; },
                                beginAtZero: true
                            }
                        }]
                }
            }
        });
    </script>
</body>
</html>