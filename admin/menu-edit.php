<?php
  require_once '../class/menu.php';
  require_once '../class/category.php';
  $menu = new Menu();
  $category = new Category();

  if(!$menu->is_logged_in())
  {
    $menu->redirect('login.php');
  }else{
    if(isset($_GET['edit_id']))
    {
      $id_menu = $_GET['edit_id'];
      $res = $menu->getMenu($id_menu);
      if($res->rowCount() > 0)
      {
        $row = $res->fetch(PDO::FETCH_ASSOC);
      }
    include_once('core/head.php');
    include_once('core/header.php');
    include_once('core/sidebar.php');
?>
<div class="content-wrapper" style="height: 1100px;">
  <section class="content-header">
    <h1>
      Ubah Menu
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
      <li><a href="menu.php"><i class="fa fa-table"></i> Daftar Menu</a></li>
      <li class="active"><i class="fa fa-edit"></i> Ubah Menu</li>
    </ol>
  </section>

  <!-- .content -->
  <section class="content">
    <div class="row">
    <div class="col-md-8">
      <?php
        if(isset($_GET['success']))
        {
          echo "<div class='alert alert-success fade in'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>Berhasil!</strong> Tambah data menu.
          </div>";
        }
      ?>
      <div class="box box-warning">
        <div class="box-header">
          <h3>Ubah Menu</h3>
        </div>
        <form role="form" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="nm_menu">Nama</label>
              <input type="text" class="form-control" name="nm_menu" placeholder="Masukkan Nama" value="<?= $row['nm_menu']; ?>" required>
            </div>
            <div class="form-group">
              <label for="id_category">Kategori</label>
              <select class="form-control" name="id_category" required>
                <option value="">-pilih kategori-</option>
                <?php
                  $stmt = $category->getAllCategories();
                  foreach ($stmt as $key => $value){
                    if($row['id_category'] == $value['id_category']){
                  ?>
                      <option value="<?= $value['id_category']; ?>" selected><?= $value['nm_category']; ?></option>
                  <?php
                    }else{
                  ?>
                      <option value="<?= $value['id_category']; ?>"><?= $value['nm_category']; ?></option>
                  <?php
                    }
                  }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="stock">Stok</label><br>
              <input type="text" class="form-control" name="stock" placeholder="Masukkan Stok" value="<?= $row['stock']; ?>" required>
            </div>
            <div class="form-group">
              <label for="price">Harga</label>
              <input type="text" class="form-control" name="price" placeholder="Masukkan Harga" value="<?= $row['price']; ?>" required>
            </div>
            <br>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary btn-block btn-lg" name="sunting"><i class="glyphicon glyphicon-save fa-lg"></i> Simpan</button>
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
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <div class="col-md-12">
                  <img src="../img/<?= $row['image']; ?>" class="img-rounded image-responsive" id="output" width="290" height="300"/>
                  <br><br>
                <div class="row">
                  <label for="image">Gambar</label>
                  <input type="file" accept="image/*" class="form-control" name="image" onchange="loadFile(event)" required>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <div class="col-md-12">
                <div class="row">
                  <button type="submit" class="btn btn-primary btn-block btn-lg" name="sunting-foto"><i class="glyphicon glyphicon-edit"></i> Sunting</button>
                </div>
              </div>
            </div>
        </form>
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
      location.href = 'menu.php';
    });
  });
</script>
<?php
    include_once('core/footer.php');

    if(isset($_POST['sunting']))
    {
      extract($_POST);
      if($menu->menu_edit($id_menu, $nm_menu, $id_category, $stock, $price))
      {
        echo "<script>
          location.href='menu.php?success=edit';
        </script>";
      }
    }
    if(isset($_POST['sunting-foto']))
    {
      extract($_POST);
      $img = $_FILES['image']['name'];
      if($menu->edit_image($id_menu, $img))
      {
        $old = $row['image'];
        unlink("../img/$old");
        move_uploaded_file($_FILES['image']['tmp_name'], '../img/'.$img);
        echo "<script>
          location.href='menu.php?success=edit';
        </script>";
      }
    }
  }
}
?>
