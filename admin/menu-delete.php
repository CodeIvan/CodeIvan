<?php
  require_once '../class/menu.php';
  $menu = new Menu();
  if(!$menu->is_logged_in())
  {
    $menu->redirect('login.php');
  }else{
    if(isset($_GET['hapus_id'])){
?>
  <form role="form" method="post">
    <div class="modal show">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" id="close" class="close">&times;</button>
            <h4><span class="glyphicon glyphicon-trash"></span> Hapus Menu</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger fade in">
              <strong>Yakin?</strong> Hapus data berikut.
            </div>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    //$file;
                    $stmt = $menu->getMenu($_GET['hapus_id']);
                    if($stmt->rowCount() > 0){
                      $row = $stmt->fetch(PDO::FETCH_ASSOC);
                      $file = $row['image'];
                  ?>
                  <tr>
                    <td><?= $row['id_menu']; ?></td>
                    <td><?= $row['nm_menu']; ?></td>
                    <td><?= $row['image']; ?></td>
                    <td><?= $row['id_category']; ?></td>
                    <td><?= $row['stock']; ?></td>
                    <td><?= $row['price']; ?></td>
                  </tr>
                  <?php
                    }else{
                      echo "<script>
                        location.href='menu.php';
                      </script>";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit" name="oke">Oke</button>
            <button id="btn-batal" class="btn btn-danger" type="button" name="batal">Batal</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <script>
    $(document).ready(function(){
      $("#btn-batal").click(function(){
        location.href='menu.php';
      });
      $("#close").click(function(){
        location.href='menu.php';
      });
    });
  </script>
<?php
      if(isset($_POST['oke'])){
        $id_menu = $_GET['hapus_id'];
        if($menu->menu_delete($id_menu)){
          unlink("../img/$file");
          echo "<script>
            location.href='menu.php?success=deleted';
          </script>";
        }
      }
    }
  }
?>
