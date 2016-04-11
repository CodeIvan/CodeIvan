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
      if(isset($_POST['save']))
      {
        extract($_POST);
        if($category->category_add($nm_category))
        {
          $category->redirect('category-add.php?success');
        }
      }
      include_once('core/head.php');
      include_once('core/header.php');
      include_once('core/sidebar.php');
?>
<!-- .content-wrapper -->
<div class="content-wrapper" style="height: 700px;">
  <section class="content-header">
    <h1>
      Tambah Kategori
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
      <li class="active"><i class="fa fa-edit"></i> Tambah kategori</li>
    </ol>
  </section>

  <!-- .content -->
  <section class="content">
    <div class="col-md-offset-1 col-md-10">
      <?php
        if(isset($_GET['success']))
        {
          echo "<div id='alert' class='alert alert-success fade in'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Tambah data kategori.
          </div>";
        }
      ?>
      <div class="box box-warning">
        <div class="box-header">
          <h3>Tambah Kategori</h3>
        </div>
        <form role="form" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="nm_category">Nama</label>
              <input type="text" class="form-control" name="nm_category" placeholder="Masukkan Nama Kategori" required autofocus>
            </div>
            <br>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary btn-block btn-lg" name="save"><i class="glyphicon glyphicon-save fa-lg"></i> Simpan</button>
                </div>
                <div class="col-md-6">
                  <button type="reset" class="btn btn-danger btn-block btn-lg" name="reset" id="batal"><i class="glyphicon glyphicon-remove fa-lg"></i> Batal</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
  $(document).ready(function(){
    $("#batal").click(function(){
      location.href = 'index.php';
    });
  });
</script>
<?php
      include_once('core/footer.php');
    }
  }
?>
