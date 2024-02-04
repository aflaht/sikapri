<div class="card shadow">
    <div class="card-header">
        <h5>log aktivitas user</h5>
    </div>
    <div class="card-body">
        <table id="table-log" class="display table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>aktifitas</th>
                    <th>waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql_log = mysqli_query($koneksi,"SELECT * FROM activity_log a INNER JOIN user u ON u.no_anggota=a.no_anggota ORDER BY time DESC");
                    $no=0;
                    while ($rol = mysqli_fetch_array($sql_log)){
                        $no++;
                ?>  
                    <tr>                        
                        <th><?php echo $no;?></th>
                        <td>
                            user
                            <b><?php echo $rol['nama']; ?></b>
                            melakukan
                            <b><?php echo $rol['activity']; ?></b>
                            sebagai
                            <b><?php echo $rol['username']; ?></b>
                        </td>
                        <td><?php echo $rol['time'];?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        
        <?php
        function userLog($time, $no_anggota, $activity){
            include_once "../koneksi.php";
            $log_sql = mysqli_query($koneksi,"INSERT INTO activity_log(id, no_anggota, activity, time) VALUES(NULL, '$no_anggota', '$activity', '$time')");
        }
        ?>
    </div>
</div>
