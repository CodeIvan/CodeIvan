<?php
  require_once '../class/transaction.php';
  $trans = new Transaction();
  if(!$trans->is_logged_in())
  {
    header('location: login.php');
  }else{
    if($_SESSION['level'] == 3){
      include_once('core/head.php');
      include_once('core/header.php');
      include_once('core/sidebar.php');
?>
      <!-- .content-wrapper -->
      <div class="content-wrapper" style="min-height:901px;">
        <section class="content-header">
          <h1>
            Daftar Transaksi
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
            <li class="active"><i class="fa fa-table"></i> Daftar Transaksi</li>
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
                <h3>Daftar Transaksi</h3>
              </div>
              <div class="box-body table-responsive">
                <table id="transaction" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>no_trans</th>
                      <th>Tanggal</th>
                      <th>Nama Pelanggan</th>
                      <th>No.Meja</th>
                      <th>Status</th>
                      <th>Gtotal</th>
                      <th>Bayar</th>
                      <th>Kembali</th>
                      <th>Pilihan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $stmt = $trans->getTransPay();
                      if($stmt->rowCount() > 0)
                      {
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                          $status = '';
                          if($row['s2'] == 1){
                            $status = "<font color='red'>Belum bayar</font>";
                          }elseif($row['s2'] == 2) {
                            $status = "<font color='green'>Lunas</font>";
                          }
                          ?>
                          <tr>
                            <td><?= $row['no_trans']; ?></td>
                            <td><?= $row['date']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['no_table']; ?></td>
                            <td><?= $status; ?></td>
                            <td><?= $row['gtotal']; ?></td>
                            <td><?= $row['pay']; ?></td>
                            <td><?= $row['refund']; ?></td>
                            <td>
                              <a role="button" class="btn btn-info" href="detail-trans-pay.php?no_trans=<?= $row['no_trans']; ?>"><i class="fa fa-fw fa-file"></i> Detail</a>
                              <?php
                                if($row['s2'] == 2)
                                {
                              ?>
                                  <a role='button' class='btn btn-success disabled' href='#'><i class='fa fa-fw fa-print'></i> Cetak</a>
                              <?php
                                }else{
                              ?>
                                  <a role='button' class='btn btn-success' href='pay.php?no_trans=<?= $row['no_trans']; ?>'><i class='fa fa-fw fa-print'></i> Bayar</a>
                              <?php
                                }
                              ?>
                            </td>
                          </tr>
                        <?php
                      }
                    }else{
                      ?>
                      <tr>
                        <td colspan="9" align="center">Tidak ada transaksi untuk hari ini.</td>
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
      <script>
        $(document).ready(function(){
          //cusDT("#transaction");
        });
      </script>
<?php
      include_once('core/footer.php');
    }else{
      echo "<script>
        location.href='transaction.php';
      </script>";
    }
  }
?>
