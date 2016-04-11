<?php
  require_once 'class/menu.php';
  require_once 'class/transaction.php';
  $menu = new Menu();
  $trans = new Transaction();
  if(!isset($_SESSION['nama']) && !isset($_SESSION['no_meja']))
  {
    $menu->redirect('login.php');
  }else{
    include_once('core/head.php');
    include_once('core/navbar.php');
    include_once('core/header1.php');
?>
  <section id="content">
    <div class="container">
      <div class="col-md-12">
        <div class="table-responsive">
          <form role="form" action="confirm.php" method="post">
            <h1>Daftar Pesanan Anda</h1><br>
            <h4>Nama : <?= $_SESSION['nama']; ?></h4>
            <h4>Nomer Meja : <?= $_SESSION['no_meja']; ?></h4>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Kategori</th>
                  <th>Stok</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
                  <th>Total</th>
                </tr>
              </thead>
              <?php
                $no = 0;
                $temp = 0;
                if(!empty($_SESSION['cart']))
                {
                  foreach ($_SESSION['cart'] as $key => $val) {
                    $sql = "SELECT * FROM menus WHERE id_menu = '$key'";
                    $stmt = $menu->oMenu($sql);
                    $m = $stmt->fetch(PDO::FETCH_ASSOC);
                    $no++;
                    $temp += $m['price'] * $val;
              ?>
              <tbody>
                <tr>
                  <td><?= $no; ?></td>
                  <td><?= $m['nm_menu']; ?></td>
                  <td><?= $m['id_category']; ?></td>
                  <td><?= $m['stock']; ?></td>
                  <input type="hidden" name="hasilstok[<?= $key; ?>]" value="<?= $m['stock']; ?>">
                  <td><?= $m['price']; ?></td>
                  <td><?= $val; ?></td>
                  <td><?= $m['price']*$val; ?></td>
                </tr>
              <?php
                  }
              ?>
                <tr>
                  <td colspan="6"><b>Grand Total</b></td>
                  <td><b><?= $temp; ?></b></td>
                </tr>
                <tr>
                  <td colspan="6"><a class="btn btn-warning" role="button" href="cart.php">Kembali</a></td>
                  <td><a class="btn btn-success" role="button" href="?aksi=OK">Selesai</a></td>
                </tr>
              <?php
                }else{
                  echo "<tr>
                    <td colspan='8' align='center'>Tidak ada pesanan dikeranjang anda.</td>
                  </tr>";
                }
              ?>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </section>
<?php
    include_once('core/footer.php');
    if(isset($_GET['aksi']) == "OK")
    {
      date_default_timezone_set("Asia/Jakarta");
      $no_trans = date('YmdHis');
      $date = date('Y-m-d');
      $name = $_SESSION['nama'];
      $no_table = $_SESSION['no_meja'];
      $trans->transaction_add($no_trans, $date, $name, $no_table, 1, 1, $temp);
      foreach ($_SESSION['cart'] as $key => $value)
      {
        $trans->detail_add($no_trans, $key, $value);
        $s = $menu->getMenu($key);
        $a = $s->fetch(PDO::FETCH_ASSOC);
        $r = $a['stock'] - $value;
        $menu->edit_stock($key, $r);
        unset($_SESSION['cart'][$key]);
      }
      unset($_SESSION['nama']);
      unset($_SESSION['no_meja']);
      echo "<script>
        swal({
          title: 'Berhasil Pesan!',
          text: 'terima kasih sudah memesan, mohon menunggu.',
          type: 'success',
          showCancelButton: false,
          closeOnConfirm: false,
          showLoaderOnConfirm: false
        },
        function(){
          location.href='menu.php';
        });
      </script>";
    }
  }
?>
