<?php
  require_once '../class/menu.php';
  require_once '../class/category.php';
  $menu = new Menu();
  $category = new Category();

  if(!$menu->is_logged_in()){
    $menu->redirect('login.php');
  }else{
    if(isset($_POST['save']))
    {
      extract($_POST);
      $img = $_FILES['image']['name'];
      if($menu->menu_add($nm_menu, $img, $id_category, $stock, $price))
      {
        move_uploaded_file($_FILES['image']['tmp_name'], '../img/'.$img);
        $menu->redirect('menu-add.php?success');
      }
    }
    include_once('core/head.php');
    include_once('core/header.php');
    include_once('core/sidebar.php');
?>
<div class="content-wrapper" style="height: 1100px;">
  <section class="content-header">
    <h1>
      Tambah Menu
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
      <li class="active"><i class="fa fa-edit"></i> Tambah Menu</li>
    </ol>
  </section>

  <!-- .content -->
  <section class="content">
    <div class="col-md-12">
      <?php
        if(isset($_GET['success']))
        {
          echo "<div id='alert' class='alert alert-success fade in'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Tambah data menu.
          </div>";
        }
      ?>
      <div class="row">
        <div class="col-md-8">
          <div class="box box-warning">
            <div class="box-header">
              <h3>Tambah Menu</h3>
            </div>
            <form role="form" action="menu-add.php" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="nm_menu">Nama</label>
                  <input type="text" class="form-control" name="nm_menu" placeholder="Masukkan Nama" required autofocus>
                </div>
                <div class="form-group">
                  <label for="image">Gambar</label>
                  <input type="file" accept="image/*" class="form-control" name="image" onchange="loadFile(event)" required>
                </div>
                <div class="form-group">
                  <label for="id_category">Kategori</label>
                  <select class="form-control" name="id_category" required>
                    <option value="">-pilih kategori-</option>
                    <?php
                      $stmt = $category->getAllCategories();
                      foreach ($stmt as $key => $value){
                      ?>
                        <option value="<?= $value['id_category']; ?>"><?= $value['nm_category']; ?></option>
                      <?php
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="stock">Stok</label><br>
                  <input type="text" class="form-control" name="stock" placeholder="Masukkan Stok" required>
                </div>
                <div class="form-group">
                  <label for="price">Harga</label>
                  <input type="text" class="form-control" name="price" placeholder="Masukkan Harga" required>
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
        <div class="col-md-4">
          <div class="box box-warning">
            <div class="box-body">
              <div class="col-md-12">
                <img src="../img/no.png" class="img-rounded image-responsive" id="output" width="300" height="300"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
  var loadFile = function(event){
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
  $(document).ready(function(){
    $("#batal").click(function(){
      location.href = 'index.php';
    });
  });
</script>
<?php
    include_once('core/footer.php');
  }
?>
