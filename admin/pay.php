<?php
  require_once '../class/transaction.php';
  require_once '../class/menu.php';
  require_once '../class/table.php';
  $trans = new Transaction();
  $menu = new Menu();
  $table = new Table();

  if($_SESSION['level'] == 3){
    include_once 'core/head.php';

    if(isset($_GET['no_trans']))
    {
      $no_trans = $_GET['no_trans'];
      $stmt = $trans->getTransaction($no_trans);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $timestamp = strtotime($row['date']);
      if($row['s2'] == 2)
      {
        echo "<script>
          location.href = 'pay-transaction.php';
        </script>";
      }
?>
  <div class="container">
    <div class="col-md-2"></div>
    <div class="col-md-8">
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
      <div class="row">
        <div class="col-md-12">
          <form role="form" method="post">
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
                        <input type="text" style="border: none;" id="bayar" name="bayar" required autofocus>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" align="right"><b>Kembali : </b></td>
                      <td>
                        <input type="text" style="border: none;" id="kembali" name="kembali" value="" readonly>
                      </td>
                    </tr>
                <?php
                  }
                ?>
              </tbody>
            </table>
            <a role="button" id="kembali" class="btn btn-warning no-print" href="pay-transaction.php"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a>
            <button type="submit" id="cetak" class="btn btn-success no-print" name="cetak" style="display:none;"><i class="fa fa-fw fa-print"></i> Cetak</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php
    if(isset($_POST['cetak']))
    {
      $no_trans = $_GET['no_trans'];
      $no_meja = $row['no_table'];
      $bayar = $_POST['bayar'];
      $kembali = $_POST['kembali'];

      $trans->transaction_edit($no_trans, 2, $bayar, $kembali);
      $table->table_edit($no_meja, 1);
      echo "<script>
        location.href = 'pay-transaction.php';
      </script>";
    }
  ?>
  <script>
    $(document).ready(function(){
      $("#bayar").keyup(function(){
        var bayar = $("#bayar").val();
        var gtotal = $("#gtotal").val();
        var kembali = bayar-gtotal;
        if(bayar == "")
        {
          $("#kembali").val(0);
        }else{
          $("#kembali").val(kembali);
        }
        if(kembali >= 0)
        {
          $("#cetak").show();
        }else{
          $("#cetak").css({'display':'none'});
        }
      });
      $("#cetak").click(function(){
        window.print();
        location.href = 'pay-transaction.php';
      });
    });
  </script>
<?php
    }
  }else{
    echo "<script>
      location.href='transaction.php';
    </script>";
  }
?>
