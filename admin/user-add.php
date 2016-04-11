<?php
  require_once '../class/user.php';
  $user = new User();
  if(!$user->is_logged_in())
  {
    header('location: login.php');
  }else{
    if($_SESSION['level'] != 1){
      $user->redirect('user.php');
    }else{
      if(isset($_POST['save']))
      {
        $nm_user = $_POST['nm_user'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $level = $_POST['level'];
        if($user->user_add($nm_user, $username, $password, $gender, $level))
        {
          $user->redirect('user-add.php?success');
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
      Tambah Pengguna
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
      <li class="active"><i class="fa fa-edit"></i> Tambah pengguna</li>
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
            <strong>Berhasil!</strong> Tambah data pengguna.
          </div>";
        }
      ?>
      <div class="box box-warning">
        <div class="box-header">
          <h3>Tambah Pengguna</h3>
        </div>
        <form role="form" action="user-add.php" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="nm_user">Nama</label>
              <input type="text" class="form-control" name="nm_user" placeholder="Masukkan Nama" required autofocus>
            </div>
            <div class="form-group">
              <label for="username">Nama Pengguna</label>
              <input type="text" class="form-control" name="username" placeholder="Masukkan Nama Pengguna" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
            </div>
            <div class="form-group">
              <label for="gender">Jenis Kelamin</label><br>
              <div class="radio">
                <label><input type="radio" name="gender" value="1" checked>Laki-laki</label>
                <label><input type="radio" name="gender" value="2" >Perempuan</label>
              </div>
            </div>
            <div class="form-group">
              <label for="level">Level</label>
              <select class="form-control" name="level" required>
                <option value="">-pilih level-</option>
                <option value="1">Administrator</option>
                <option value="2">Chef</option>
                <option value="3">Cashier</option>
              </select>
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
