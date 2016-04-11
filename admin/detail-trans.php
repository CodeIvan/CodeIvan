<?php
  require_once '../class/transaction.php';
  require_once '../class/menu.php';
  require_once '../class/table.php';
  $trans = new Transaction();
  $menu = new Menu();
  $table = new Table();

  if(isset($_GET['no_trans']))
  {
    include_once 'core/head.php';
    include_once 'core/header.php';
    include_once 'core/sidebar.php';

    $no_trans = $_GET['no_trans'];
    $stmt = $trans->getTransaction($no_trans);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $timestamp = strtotime($row['date']);
?>
<div class="content-wrapper" style="height:1000px;">
  <section class="content-header">
    <h1>
      Detail Transaksi
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
      <li><a href="transaction.php"><i class="fa fa-table"></i> Daftar Transaksi</a></li>
      <li class="active"><i class="fa fa-table"></i> Detail Transaksi</li>
    </ol>
  </section>

  <section class="content">
    <div class="col-lg-12">
      <div class="box box-warning">
        <div class="box-header">
          <h3>Detail Transaksi #<?= $row['no_trans']; ?></h3>
        </div>
        <div class="box-body table-responsive">
          <div class="row">
            <div class="col-md-2">
              <img src="../img/logo.png" alt="logo" width="120" height="120" />
            </div>
            <div class="col-md-6">
              <h1>RestoW</h1>
              <p>Jl. Pekalongan Dalam no.20</p>
            </div>
            <div class="col-md-4">
              <table class="table" align="center" width="100%">
                <tbody>
                  <tr>
                    <td><b>No</b></td>
                    <td>:</td>
                    <td><?= "#".$row['no_trans']; ?></td>
                  </tr>
                  <tr>
                    <td><b>Tanggal</b></td>
                    <td>:</td>
                    <td><?= date('d-m-Y', $timestamp); ?></td>
                  </tr>
                  <tr>
                    <td><b>Nama</b></td>
                    <td>:</td>
                    <td><?= $row['name']; ?></td>
                  </tr>
                  <tr>
                    <td><b>No. Meja</b></td>
                    <td>:</td>
                    <td><?= $row['no_table']; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <table class="table">
            <thead>
              <th>ID</th>
              <th>Menu</th>
              <th>Harga @</th>
              <th>Jumlah</th>
              <th width="200">Total</th>
            </thead>
            <tbody>
              <?php
                $stmt1 = $trans->getDetail($no_trans);
                if($stmt1->rowCount() > 0)
                {
                  $gtotal = 0;
                  while ($ro = $stmt1->fetch(PDO::FETCH_ASSOC))
                  {
                    $m = $menu->getMenu($ro['id_menu']);
                    $r = $m->fetch(PDO::FETCH_ASSOC);
                    $total = $r['price'] * $ro['qty'];
                    $gtotal += $total;
              ?>
                    <tr>
                      <td><?= "#".$ro['id_menu']; ?></td>
                      <td><?= $r['nm_menu']; ?></td>
                      <td><?= $r['price']; ?></td>
                      <td><?= $ro['qty']; ?></td>
                      <td><?= $total; ?></td>
                    </tr>
              <?php
                  }
              ?>
                  <tr>
                    <td colspan="4" align="right"><b>Grand Total : </b></td>
                    <td>
                      <input type="hidden" id="gtotal" name="gtotal" value="<?= $gtotal; ?>">
                      <?= "<b>".$gtotal."</b>"; ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><b>Bayar : </b></td>
                    <td>
                      <?php
                        if($row['pay'] == 0)
                        {
                          echo "<font color='red'>Belum bayar</font>";
                        }else{
                          echo "<b>".$row['pay']."</b>";
                        }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><b>Kembali : </b></td>
                    <td>
                      <?= "<b>".$row['refund']."</b>"; ?>
                    </td>
                  </tr>
              <?php
                }
              ?>
            </tbody>
          </table>
          <a role="button" id="kembali" class="btn btn-warning no-print" href="transaction.php"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a>
          <?php
            if($row['s2'] == 1)
            {
          ?>
              <a role='button' class='btn btn-success' href='pay.php?no_trans=<?= $no_trans; ?>'><i class='fa fa-fw fa-print'></i> Cetak</a>
          <?php
            }
          ?>
        </div>
      </div>
    </div>
  </section><!-- /.content -->
</div>
<?php
    include_once 'core/footer.php';
  }
?>
