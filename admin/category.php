<?php
  require_once '../class/category.php';
  $category = new Category();
  if(!$category->is_logged_in())
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
            Daftar Kategori
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
            <li class="active"><i class="fa fa-table"></i> Daftar Kategori</li>
          </ol>
        </section>

        <!-- .content -->
        <section class="content">
          <div class="col-lg-12">
            <?php
              if(isset($_GET['success']))
              {
                if($_GET['success'] == 'edit'){
                  echo "<div id='alert' class='alert alert-success fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Berhasil!</strong> Ubah data kateogri.
                  </div>";
                }
                if($_GET['success'] == 'deleted'){
                  echo "<div id='alert' class='alert alert-success fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Berhasil!</strong> Hapus data kateogri.
                  </div>";
                }
              }
            ?>
            <div class="box box-warning">
              <div class="box-header">
                <h3>Daftar Kategori</h3>
              </div>
              <div class="box-body table-responsive">
                <table id="category" class="table table-bordered table-stripped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th width="700">Nama</th>
                      <th>Pilihan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $stmt = $category->getAllCategories();
                      if($stmt->rowCount() > 0)
                      {
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                          ?>
                          <tr>
                            <td><?= $row['id_category']; ?></td>
                            <td><?= $row['nm_category']; ?></td>
                            <td>
                              <a href="category-edit.php?edit_id=<?= $row['id_category']; ?>" role='button' class='btn btn-warning btn-sm'><i class='fa fa-fw fa-edit'></i></a>
                              <a href="?hapus_id=<?= $row['id_category']; ?>" role='button' class='btn btn-danger btn-sm'><i class='fa fa-fw fa-trash'></i></a>
                            </td>
                          </tr>
                        <?php
                      }
                    }else{
                      ?>
                      <tr>
                        <td colspan="4" align="center">Tidak ada data untuk ditampilkan.</td>
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
      <?php include_once('category-delete.php'); ?>
      <script>
        $(document).ready(function(){
          cusDT("#category");
        });
      </script>
<?php
      include_once('core/footer.php');
    }
  }
?>
