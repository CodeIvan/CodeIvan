<?php
  require_once '../class/transaction.php';
  require_once '../class/menu.php';
  $trans = new Transaction();
  $menu = new Menu();

  if(!$trans->is_logged_in())
  {
    header('location: login.php');
  }else{
    if(isset($_GET['no_trans'])){
      include_once('core/head.php');
      include_once('core/header.php');
      include_once('core/sidebar.php');
      $no_trans = $_GET['no_trans'];
      $stmt = $trans->getTransaction($no_trans);
      $r = $stmt->fetch(PDO::FETCH_ASSOC);
?>
      <!-- .content-wrapper -->
      <div class="content-wrapper" style="min-height:901px;">
        <section class="content-header">
          <h1>
            Detail Pesanan
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
            <li><a href="order.php"><i class="fa fa-table"></i> Daftar Pesanan</a></li>
            <li class="active"><i class="fa fa-detail"></i> Detail Pesanan</li>
          </ol>
        </section>

        <!-- .content -->
        <section class="content">
          <div class="col-lg-12">
            <div class="box box-warning">
              <div class="box-header">
                <h3>Detial Pesanan #<?= $r['no_trans']; ?></h3>
              </div>
              <div class="box-body table-responsive">
                <h4><b>Nama Pelanggan : </b><?= $r['name']; ?></h4>
                <h4><b>No. Meja : </b><?= $r['no_table']; ?></h4>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>no_trans</th>
                      <th>Menu</th>
                      <th>Jumlah</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $stmt1 = $trans->getDetail($no_trans);
                      if($stmt1->rowCount() > 0)
                      {
                        while($row = $stmt1->fetch(PDO::FETCH_ASSOC))
                        {
                          $stmt2 = $menu->getMenu($row['id_menu']);
                          $ro = $stmt2->fetch(PDO::FETCH_ASSOC);
                        ?>
                          <tr>
                            <td><?= $row['no_trans']; ?></td>
                            <td><?= $ro['nm_menu']; ?></td>
                            <td><?= $row['qty']; ?></td>
                          </tr>
                        <?php
                        }
                      }else{
                        ?>
                          <tr>
                            <td colspan="6" align="center">Tidak ada data untuk ditampilkan.</td>
                          </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <br>
                <a role="button" class="btn btn-warning" href="order.php"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a>
              </div>
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php
      include_once('core/footer.php');
    }else{
      echo "<script>
        location.href='order.php';
      </script>";
    }
  }
?>
