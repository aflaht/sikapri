<script type="text/javascript">
    //notificator
    var notifications = new Notifications(".notification", {animationInName: "fadein", startTopPosition: 60});
    notifications.init();

    $(document).ready(function () {
        //custom scroll bar pada side bar
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });
        //sidebare colapse
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
        //data table, tabel user
        $('#table-user').DataTable({
            "columns": [
                null,
                null,
                null,
                null,
                null,
                { "orderable": false }
            ],
            "pagingType":"simple",
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
            }
        });
        //data table, tabel unit
        $('#table-unit').DataTable({
            "columns": [
                null,
                null,
                null,
                { "orderable": false }
            ],
            "pagingType":"simple",
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
            }
        });
        //data table, tabel pinjaman
        $('#table-pinjaman').DataTable({
            "language": {
                "lengthMenu": "Menampilkan _MENU_ records per halaman",
                "zeroRecords": "Hasil pencarian tidak ditemukan - maaf",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
                "infoEmpty": "Record tidak ditemukan",
                "thousands":      ".",
                "search":         "Cari:",
                "paginate": {
                    "first":      "Pertama",
                    "last":       "Terakhir",
                    "next":       "Berikutnya",
                    "previous":   "Sebelumnya"
                },
                "infoFiltered": "(filtered from _MAX_ total records)"
            },
            "pagingType":"simple",
            "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null
                // { "orderable": false }
            ],
            "order": [[ 6, "desc" ]]
        });
        //data table, tabel pinjaman
        $('#table-simpanan').DataTable({
            "language": {
                "lengthMenu": "Menampilkan _MENU_ records per halaman",
                "zeroRecords": "Hasil pencarian tidak ditemukan - maaf",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
                "infoEmpty": "Record tidak ditemukan",
                "thousands":      ".",
                "search":         "Cari:",
                "paginate": {
                    "first":      "Pertama",
                    "last":       "Terakhir",
                    "next":       "Berikutnya",
                    "previous":   "Sebelumnya"
                },
                "infoFiltered": "(filtered from _MAX_ total records)"
            },
            "pagingType":"simple",
            "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                //{ "orderable": false }
            ],
            "order": [[ 6, "desc" ]]
        });
        //data table, table log
        $('#table-log').DataTable({
            "language": {
                "lengthMenu": "Menampilkan _MENU_ records per halaman",
                "zeroRecords": "Hasil pencarian tidak ditemukan - maaf",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
                "infoEmpty": "Record tidak ditemukan",
                "thousands":      ".",
                "search":         "Cari:",
                "paginate": {
                    "first":      "Pertama",
                    "last":       "Terakhir",
                    "next":       "Berikutnya",
                    "previous":   "Sebelumnya"
                },
                "infoFiltered": "(filtered from _MAX_ total records)"
            },
            "pagingType":"simple",
            "columns": [
                null,
                { "orderable": false },
                null,
            ]
        });
        //alert
        var alert = $('#alert-tambah-s');
        var alertEdit = $('#alert-edit-s');

        if(alert.length){
            Swal.fire({
                type: 'success',
                title: 'Berhasil',
                text: 'Berhasil Menambah Data',
            });
        } else if(alertEdit.length){
            Swal.fire({
                type: 'success',
                title: 'Berhasil',
                text: 'Berhasil Mengubah Data',
            });
        }

    });
        //autofill di edit modal user
        $(document).on("click", "#edit_user", function(){
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var no_anggota = $(this).data('no_anggota');
            var username = $(this).data('username');
            var password = $(this).data('password');
            var kdpr = $(this).data('kdpr');
            var level = $(this).data('level');

            $("#modal-edit-user #fId").val(id);
            $("#modal-edit-user #fNama").val(nama);
            $("#modal-edit-user #fNoAnggota").val(no_anggota);
            $("#modal-edit-user #fUsername").val(username);
            $("#modal-edit-user #fPassword").val(password);
            $("#modal-edit-user #fKdpr").val(kdpr);
            $("#modal-edit-user #fLevel").val(level);
        });
        //autofill di edit modal unit
        $(document).on("click", "#edit_unit", function(){
            var kdpr = $(this).data('kdpr');
            var nama = $(this).data('nama_unit');

            $("#modal-edit-unit #uKdpr").val(kdpr);
            $("#modal-edit-unit #uNama").val(nama);
        });
        //autofill di edit modal edit password
        $(document).on("click", "#edit_password", function(){
            var id = $(this).data('idu');
            var pw = $(this).data('password');

            $("#modal-edit-password #uId").val(id);
            $("#modal-edit-password #uPass").val(pw);
        });
        //alert di delete user
        $(document).on("click", "#delete_user", function(e){
            var user_id = $(this).data('id');
            swalDelete(user_id);
            e.preventDefault();
        });
        //alert di delete unit
        $(document).on("click", "#delete_unit", function(e){
            var kdpr = $(this).data('kdpr');
            swalDeleteUnit(kdpr);
            e.preventDefault();
        });
        //alert di delete pinjaman
        $(document).on("click", "#delete_pinjaman", function(e){
            var id_pinjaman = $(this).data('id_pinjaman');
            swalDeletePinjaman(id_pinjaman);
            e.preventDefault();
        });
        //alert di undo user
        $(document).on("click", "#undo_user", function(e){
            swalUndoUser();
            e.preventDefault();
        });
        //alert di undo user
        $(document).on("click", "#undo_unit", function(e){
            swalUndoUnit();
            e.preventDefault();
        });
        //fungsi delet user
        function swalDelete(user_id){
            swal.fire({
                title: "Apakah anda yakin?",
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                showLoaderOnConfirm: true,

                preConfirm: function(){
                    return new Promise(function(resolve){
                        $.ajax({
                            url: "query_hapus_user.php",
                            type: "POST",
                            data: "id="+user_id,
                            dataType: "json"
                        })
                        .then(function(response){
                            swal.fire("Data Berhasil Dihapus", response.message, response.status);
                            window.location.href="dashboard.php?section=user";
                        })
                        .catch(function(){
                            swal.fire("Oops...", "Terdapat error pada ajax !","error");
                        });
                    });
                },
                allowOutsideClick: false
            });
        }
        //fungsi delet unit
        function swalDeleteUnit(kdpr){
            swal.fire({
                title: "Apakah anda yakin?",
                text: "Data yang telah dihapus tidak dapat dikembalikan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                showLoaderOnConfirm: true,

                preConfirm: function(){
                    return new Promise(function(resolve){
                        $.ajax({
                            url: "query_hapus_unit.php",
                            type: "POST",
                            data: "kdpr="+kdpr,
                            dataType: "json"
                        })
                        .then(function(response){
                            swal.fire("Data Berhasil Dihapus", response.message, response.status);
                            window.location.href="dashboard.php?section=unit";
                        })
                        .catch(function(){
                            swal.fire("Oops...", "Terdapat error pada ajax !","error");
                        });
                    });
                },
                allowOutsideClick: false
            });
        }
        //fungsi delet pinjaman
        function swalDeletePinjaman(id_pinjaman){
            swal.fire({
                title: "Apakah anda yakin?",
                text: "Data yang telah dikosongkan tidak dapat dikembalikan!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                showLoaderOnConfirm: true,

                preConfirm: function(){
                    return new Promise(function(resolve){
                        $.ajax({
                            url: "query_hapus_pinjaman.php",
                            type: "POST",
                            data: "id_pinjaman="+id_pinjaman,
                            dataType: "json"
                        })
                        .then(function(response){
                            swal.fire("Data Berhasil Dikosongkan", response.message, response.status);
                            window.location.href="dashboard.php?section=pinjaman";
                        })
                        .catch(function(){
                            swal.fire("Oops...", "Terdapat error pada ajax !","error");
                        });
                    });
                },
                allowOutsideClick: false
            });
        }
        //fungsi undo user
        function swalUndoUser(){
            swal.fire({
                title: "Apakah anda yakin untuk mengembalikan data?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                cancelButtonColor: "#d33",
                confirmButtonText: "Undo",
                cancelButtonText: "Batal",
                showLoaderOnConfirm: true,

                preConfirm: function(){
                    return new Promise(function(resolve){
                        $.ajax({
                            url: "query_undo_user.php",
                            type: "POST",
                            data: "undo=user",
                            dataType: "json"
                        })
                        .then(function(response){
                            swal.fire("Data Berhasil Dikembalikan", response.message, response.status);
                            window.location.href="dashboard.php?section=user";
                        })
                        .catch(function(){
                            swal.fire("Oops...", "Terdapat error pada ajax !","error");
                        });
                    });
                },
                allowOutsideClick: false
            });
        }
        //fungsi undo unit
        function swalUndoUnit(){
            swal.fire({
                title: "Apakah anda yakin untuk mengembalikan data?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                cancelButtonColor: "#d33",
                confirmButtonText: "Undo",
                cancelButtonText: "Batal",
                showLoaderOnConfirm: true,

                preConfirm: function(){
                    return new Promise(function(resolve){
                        $.ajax({
                            url: "query_undo_unit.php",
                            type: "POST",
                            data: "undo=unit",
                            dataType: "json"
                        })
                        .then(function(response){
                            swal.fire("Data Berhasil Dikembalikan", response.message, response.status);
                            window.location.href="dashboard.php?section=unit";
                        })
                        .catch(function(){
                            swal.fire("Oops...", "Terdapat error pada ajax !","error");
                        });
                    });
                },
                allowOutsideClick: false
            });
        }
        //fungsi cek pinjaman (removed)
        function chekAddPinjaman(){
            jQuery.ajax({
                url: "section/pinjaman_check_availability.php",
                data: 'no_anggota='+$("#no_anggota2").val(),
                type: "POST",
                dataType: "json",
                success:function(response){
                    $("#pinjaman-availability-status").html(response.message);
                    if(response.message == "Tersedia."){
                        $("#kdpr").val(response.kdpr);
                        console.log(response);
                        $("#nama").val(response.nama);
                        $("#unit").val(response.unit);
                        return true;
                    }else{
                        return false;
                    }
                },
                error:function (){}
                    });
        }
        //fungsi cek ketersediaan username pada modal edit
        function checkAvailabilityEdit() {
            $("#loaderIconEdit").show();
            jQuery.ajax({
                url: "section/user_check_availability.php",
                data:'usernameEdit='+$("#fUsername").val()+'&id='+$("#fId").val(),
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

        //
        function checkAvailabilityNow() {
            $("#loaderIconEdit").show();
            jQuery.ajax({
                url: "section/user_check_availability.php",
                data:'usernameNow='+$("#fUsernameNow").val()+'&id='+$("#fId").val(),
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
        //fungsi pengecekan submit pada modal edit
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
        //validasi upload file excel
        $('#file').change(function(e){
            var file = e.target.files[0];
            var extension = file.name.replace(/^.*\./, "");
            console.log(extension);
            if(extension != "xlsx"){
                swal.fire("Extensi file harus excel !");
                $("#file").val("");
            }else{

            }
        });

        //some new
        var btn = $('#button');
        var btn2 = $('#button2');
        btn2.addClass('show');
        $(window).scroll(function() {
        if ($(window).scrollTop() > 100) {
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

<!-- Chart db -->
<script type="text/javascript">
    <?php
        $sql_periode = "SELECT p.periode,SUM(total) as total FROM pinjaman p GROUP BY p.periode ORDER BY periode ASC";
        $sql_data = "SELECT p.periode,SUM(total) as total FROM pinjaman p GROUP BY p.periode ORDER BY periode ASC";

        $q_periode = $koneksi->query($sql_periode);
        $q_data = $koneksi->query($sql_data);
    ?>
    var lineData = {
        labels: [<?php while ($r=mysqli_fetch_array($q_periode)) { echo '"' . $r['periode'] . '",';}?>],
        datasets: [

            {
                label: "Total Pinjaman",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php while ($r2=mysqli_fetch_array($q_data)) { echo '"' . $r2['total'] . '",';}?>]
            }
        ]
    };

    var lineOptions = {
        responsive: true,
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
    };
 
    var ctx = document.getElementById("dbChart").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});

    <?php
        $sql_periode_sp = "SELECT s.periode,SUM(total) as total FROM simpanan s GROUP BY s.periode ORDER BY periode ASC";
        $sql_data_sp = "SELECT s.periode,SUM(total) as total FROM simpanan s GROUP BY s.periode ORDER BY periode ASC";

        $q_periode_sp = $koneksi->query($sql_periode_sp);
        $q_data_sp = $koneksi->query($sql_data_sp);
    ?>
    var lineDataSp = {
        labels: [<?php while ($r_sp=mysqli_fetch_array($q_periode_sp)) { echo '"' . $r_sp['periode'] . '",';}?>],
        datasets: [

            {
                label: "Total Simpanan",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php while ($r2_sp=mysqli_fetch_array($q_data_sp)) { echo '"' . $r2_sp['total'] . '",';}?>]
            }
        ]
    };
    var lineOptionsSp = {
        responsive: true,
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
    };

    var ctx2 = document.getElementById("dbChartSp").getContext("2d");
    new Chart(ctx2, {type: 'line', data: lineDataSp, options:lineOptionsSp});
</script>