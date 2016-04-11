<?php
  require_once '../class/menu.php';
  require_once '../class/category.php';
  $menu = new Menu();
  $category = new Category();
  if(!$menu->is_logged_in())
  {
    $menu->redirect('login.php');
  }else{
    if($_SESSION['level'] == 3){
      echo "<script>
        location.href='transaction.php';
      </script>";
    }else{
      include_once('core/head.php');
      include_once('core/header.php');
      include_once('core/sidebar.php');
?>
      <!-- .content-wrapper -->
      <div class="content-wrapper" style="height:1000px;">
        <section class="content-header">
          <h1>
            Daftar Menu
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
            <li class="active"><i class="fa fa-table"></i> Daftar Menu</li>
          </ol>
        </section>

        <!-- .content -->
        <section class="content">
          <div class="col-lg-12">
            <?php
              if(isset($_GET['success']))
              {
                if($_GET['success'] == 'deleted'){
                  echo "<div id='alert' class='alert alert-success fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Berhasil!</strong> Hapus data menu.
                  </div>";
                }
                if($_GET['success'] == 'edit'){
                  echo "<div id='alert' class='alert alert-success fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Berhasil!</strong> Ubah data menu.
                  </div>";
                }
              }
            ?>
            <div class="box box-warning">
              <div class="box-header">
                <h3>Daftar Menu</h3>
              </div>
              <div class="box-body table-responsive">
                <table id="menu" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Gambar</th>
                      <th>Kategori</th>
                      <th>Stok</th>
                      <th>Harga</th>
                      <th>Pilihan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if(isset($_GET['stok-min'])){
                        $stmt = $menu->getStockMin();
                      }else{
                        $stmt = $menu->getAllMenus();
                      }
                      if($stmt->rowCount() > 0)
                      {
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                          $ctg = $category->getCategory($row['id_category']);
                          $c = $ctg->fetch(PDO::FETCH_ASSOC);
                          ?>
                          <tr>
                            <td><?= $row['id_menu']; ?></td>
                            <td><?= $row['nm_menu']; ?></td>
                            <td><img src="../img/<?= $row['image']; ?>" width="100" height="100" /></td>
                            <td><?= $c['nm_category'] ?></td>
                            <td>
                              <?php
                                if($row['stock'] <= 5){
                                  echo "<font color='red'>".$row['stock']."<i class='fa fa-fw fa-exclamation-triangle pull-right'></i></font>";
                                }else{
                                  echo $row['stock'];
                                }
                              ?>
                            </td>
                            <td><?= $row['price']; ?></td>
                            <td>
                              <a href="menu-edit.php?edit_id=<?= $row['id_menu']; ?>" role="button" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-edit"></i></a>
                              <a href="?hapus_id=<?= $row['id_menu']; ?>" role="button" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></a>
                            </td>
                          </tr>
                        <?php
                      }
                    }else{
                      ?>
                      <tr>
                        <?php
                          if(isset($_GET['stok-min'])){
                            echo "<td colspan='8' align='center'>Tidak ada stok yang hampir habis.</td>";
                          }else{
                            echo "<td colspan='8' align='center'>Tidak ada data untuk ditampilkan.</td>";
                          }
                        ?>
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
      <?php include_once('menu-delete.php'); ?>
      <script>
        $(document).ready(function(){
          cusDT("#menu");
        });
      </script>
<?php
      include_once('core/footer.php');
    }
  }
?>
