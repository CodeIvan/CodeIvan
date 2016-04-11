<?php
  require_once '../class/user.php';
  $user = new User();
  if(!$user->is_logged_in())
  {
    header('location: login.php');
  }else{
    if($_SESSION['level'] != 1){
      echo "<script>
        location.href='transaction.php';
      </script>";
    }else{
      include_once('core/head.php');
      include_once('core/header.php');
      include_once('core/sidebar.php');
?>
      <!-- .content-wrapper -->
      <div class="content-wrapper" style="min-height:901px;">
        <section class="content-header">
          <h1>
            Daftar Pengguna
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
            <li class="active"><i class="fa fa-table"></i> Daftar Pengguna</li>
          </ol>
        </section>

        <!-- .content -->
        <section class="content">
          <div class="col-lg-12">
            <?php
              if(isset($_GET['success']))
              {
                echo "<div class='alert alert-success fade in'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  <strong>Berhasil!</strong> Hapus data pengguna.
                </div>";
              }
            ?>
            <div class="box box-warning">
              <div class="box-header">
                <h3>Daftar Pengguna</h3>
              </div>
              <div class="box-body table-responsive">
                <table id="user" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Nama Pengguna</th>
                      <th>Jenis Kelamin</th>
                      <th>Level</th>
                      <?php
                      if($_SESSION['level'] == 1){
                        echo "<th>Pilihan</th>";
                      }
                      ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $stmt = $user->getAllUsers();
                      if($stmt->rowCount() > 0)
                      {
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                          $jk='';
                          if($row['gender'] == 1){
                            $jk = "Laki-laki";
                          }else{
                            $jk = "Perempuan";
                          }
                          $level = '';
                          if($row['level'] == 1){
                            $level = "Administrator";
                          }elseif($row['level'] == 2) {
                            $level = "Chef";
                          }elseif ($row['level'] == 3) {
                            $level = "Cashier";
                          }
                          ?>
                          <tr>
                            <td><?= $row['id_user']; ?></td>
                            <td><?= $row['nm_user']; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= $jk; ?></td>
                            <td><?= $level; ?></td>
                            <?php
                            if($_SESSION['level'] == 1){
                              if($row['id_user'] != $_SESSION['id_user']){
                                echo "<td><a href='?hapus_id=".$row['id_user']."' role='button' class='btn btn-danger btn-sm'><i class='fa fa-fw fa-trash'></i></a></td>";
                              }else{
                                echo "<td><a href='#' role='button' class='btn btn-danger btn-sm disabled'><i class='fa fa-fw fa-trash'></i></a></td>";
                              }
                            }
                            ?>
                          </tr>
                        <?php
                      }
                    }else{
                      ?>
                      <tr>
                        <td colspan="6" align="center">Tidak ada data untuk ditampilkan.</td>
                      </tr>
                      <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include_once('user-delete.php'); ?>
      <script>
        $(document).ready(function(){
          cusDT("#user");
        });
      </script>
<?php
      include_once('core/footer.php');
    }
  }
?>
