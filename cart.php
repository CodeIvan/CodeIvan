<?php
  require_once 'class/menu.php';
  $menu = new Menu();
  if(!isset($_SESSION['nama']) && !isset($_SESSION['no_meja']))
  {
    $menu->redirect('login.php');
    $menu->setAlert('logindulu');
  }else{
    include_once('core/head.php');
    include_once('core/navbar.php');
    include_once('core/header1.php');
?>
  <section id="content">
    <div class="container">
      <div class="col-md-12">
        <div class="table-responsive">
          <form role="form" action="cart.php?aksi=ubah" method="post">
            <h1>Keranjang</h1>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Kategori</th>
                  <th>Stok</th>
                  <th>Harga/@</th>
                  <th width="100">Jumlah</th>
                  <th>Total</th>
                  <th>Pilihan</th>
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
                <tr class="row_<?= $key; ?>">
                  <td><?= $no; ?></td>
                  <td><?= $m['nm_menu']; ?></td>
                  <td><?= $m['id_category']; ?></td>
                  <td><?= $m['stock']; ?></td>
                  <td><?= $m['price']; ?></td>
                  <td>
                    <div class="col-md-12">
                      <input type="text" class="form-control qty" data-id="<?= $m['id_menu']; ?>" data-stock="<?= $m['stock']; ?>" data-price="<?= $m['price']; ?>" name="jumlah[<?= $key; ?>]" value="<?= $val; ?>">
                    </div>
                  </td>
                  <td class="total"><?= $m['price']*$val; ?></td>
                  <td><a href="cart.php?aksi=hapus&id_menu=<?= $key; ?>" data-id="<?= $key; ?>" class="delete"><i class="fa fa-fw fa-trash delete"></i> Hapus</a></td>
                </tr>
              <?php
                  }
              ?>
                <tr>
                  <td colspan="6"><b>Grand Total</b></td>
                  <td colspan="2"><b class="gtotal"><?= $temp; ?></b></td>
                </tr>
                <tr>
                  <td colspan="6"><a class="btn btn-warning" role="button" href="menu.php">Kembali</a></td>
                  <td colspan="2"><a class="btn btn-success" role="button" href="confirm.php">Selesai</a></td>
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
  <script>
    $(document).ready(function(){
      $("#ubah").click(function(){
        $.get('cart.php',{'aksi':'ubah'});
      });

      $(".qty").keyup(function(){
        var id = $(this).attr('data-id');
        var stock = $(this).attr('data-stock');
        var jumlah = $(this).val();
        var price = $(this).attr('data-price');
        var boxTotal = $(this).parents("tr").find(".total");

        $.ajax({
          method: "POST",
          url: "class/cart.php?aksi=ubah",
          data: { id: id, hasilstok: stock, jumlah: jumlah, price: price },
          dataType: "json",
          success: function(data){
            boxTotal.html(data.total);
            $(".gtotal").html(data.gtotal);
          }
        });
      });

      // $(".delete").on('click', function(){
      //   var id_menu = $(this).attr('data-id');
      //   $.ajax({
      //     method: "POST",
      //     url: "class/cart.php?aksi=hapus",
      //     data: { id_menu: id_menu },
      //     datatype: "json",
      //     success: function(data){
      //       alert(data);
      //       if(data == "OK"){
      //         $(".row_"+id).fadeOut();
      //       }
      //     }
      //   });
      // });
    });
  </script>
<?php
    include_once('core/footer.php');
  }
?>
