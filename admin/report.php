<?php
  require_once '../class/transaction.php';
  $trans = new Transaction();

  if(!$trans->is_logged_in())
  {
    $trans->redirect('login.php');
  }else{
    if(isset($_POST['cetak']))
    {

      $tgl1 = $_POST['tgl1'];
      $tgl2 = $_POST['tgl2'];

      require_once 'core/head.php';
?>
    <body>
      <form role="form" method="post">
      <div class="container">
        <h3 align="center">Laporan Transaksi</h3>
        <h4 align="center">Tanggal <?= $tgl1; ?> Sampai Tanggal <?= $tgl2; ?></h4>
        <table class="table table-responsive table-bordered">
          <thead>
            <tr>
              <th>No. Trans</th>
              <th>Tanggal</th>
              <th>Nama Pelanggan</th>
              <th>No. Meja</th>
              <th>Gtotal</th>
            </tr>
          </thead>
          <tbody>
<?php
      $stmt = $trans->getReport($tgl1, $tgl2);
      if($stmt->rowCount() > 0)
      {
        $total = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
?>

            <tr>
              <td><?= $row['no_trans']; ?></td>
              <td><?= $row['date']; ?></td>
              <td><?= $row['name']; ?></td>
              <td><?= $row['no_table']; ?></td>
              <td align="right"><?= $row['gtotal']; ?></td>
            </tr>
<?php
          $total = $total + $row['gtotal'];
        }
?>           <tr>
              <td colspan="4" align="right"><b>Total</b></td>
              <td align="right"><b><?= $total; ?></b></td>
            </tr>
          </tbody>
        </table>
        <div class="pull-left">
          <a role="button" class="btn btn-warning no-print" href="transaction.php"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a>
        </div>
        <div class="pull-right">
          <!-- <a role="button" href="html2pdf.php" class="btn btn-danger"><i class="fa fa-fw fa-file"></i> Cetak PDF</a> -->
          <button type="button" id="cetak" class="btn btn-success no-print" name="excel"><i class="fa fa-fw fa-file"></i> Cetak</button>
        </div>
      </div>
      </form>
    </body>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#cetak").click(function(){
          window.print();
          location.href='transaction.php';
        });
      });
    </script>
  </html>
<?php
      }
    }
  }
?>
