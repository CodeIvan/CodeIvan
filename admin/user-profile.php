<?php
  require_once '../class/user.php';
  $user = new User();
  if(!$user->is_logged_in())
  {
    header('location: login.php');
  }else{
    $stmt = $user->getUser($_SESSION['id_user']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_user = $_SESSION['id_user'];
    if(isset($_POST['save-name']))
    {
      $nm_user = $_POST['new-name'];
      if($user->name_edit($id_user, $nm_user))
      {
        $_SESSION['nm_user'] = $nm_user;
        echo "<script>
          location.href = 'user-profile.php?success=edit-name';
        </script>";
      }
    }
    if(isset($_POST['save-username']))
    {
      $username = $_POST['new-username'];
      if($user->username_edit($id_user, $username))
      {
        $_SESSION['username'] = $username;
        echo "<script>
          location.href = 'user-profile.php?success=edit-username';
        </script>";
      }
    }
    if(isset($_POST['save-password']))
    {
      $password = $_POST['password'];
      $newpass = $_POST['new-password'];
      $confpass = $_POST['conf-password'];
      $hash = $row['password'];
      $pass = $user->passwordVerify($password, $hash);
      if($pass)
      {
        if($newpass == $confpass)
        {
          $newpass = $user->passwordHash($newpass);
          $user->password_edit($id_user, $newpass);
          echo "<script>
            location.href = 'user-profile.php?success=edit-password';
          </script>";
        }else{
          echo "<script>
            location.href = 'user-profile.php?failed=not-match';
          </script>";
        }
      }else{
        echo "<script>
          location.href = 'user-profile.php?failed=wrong-password';
        </script>";
      }
    }
    include_once('core/head.php');
    include_once('core/header.php');
    include_once('core/sidebar.php');
?>
      <!-- .content-wrapper -->
      <div class="content-wrapper" style="min-height:901px;">
        <section class="content-header">
          <h1>
            Profil Pengguna
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
            <li class="active"><i class="fa fa-user"></i> Profil Pengguna</li>
          </ol>
        </section>

        <!-- .content -->
        <section class="content">
          <div class="col-lg-12">
            <?php
              if(isset($_GET['success']))
              {
                if($_GET['success'] == 'edit-name')
                {
                  echo "<div id='alert' class='alert alert-success fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Berhasil!</strong> Ubah nama.
                  </div>";
                }
                if($_GET['success'] == 'edit-username')
                {
                  echo "<div id='alert' class='alert alert-success fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Berhasil!</strong> Ubah nama pengguna.
                  </div>";
                }
                if($_GET['success'] == 'edit-password')
                {
                  echo "<div id='alert' class='alert alert-success fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Berhasil!</strong> Ubah kata sandi.
                  </div>";
                }
              }elseif(isset($_GET['failed'])){
                if($_GET['failed'] == 'not-match')
                {
                  echo "<div id='alert' class='alert alert-danger fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Gagal!</strong> password tidak cocok.
                  </div>";
                }
                if($_GET['failed'] == 'wrong-password')
                {
                  echo "<div id='alert' class='alert alert-danger fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Gagal!</strong> password salah.
                  </div>";
                }
              }
            ?>
            <div class="box box-warning">
              <div class="box-header">
                <h3>Profil Pengguna</h3>
              </div>
              <div class="box-body">
                <div class="col-lg-12 col-md-12">
                  <div class="row">
                    <div class="col-lg-4 col-md-4">
                      <label><b>Nama</b></label>
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <span><?= $row['nm_user']; ?></span>
                    </div>
                    <div class="col-lg-2 col-md-2">
                      <a href="#" id="name"><i class="fa fa-fw fa-edit"></i> Sunting</a>
                    </div>
                  </div>
                  <!-- sunting nama -->
                  <div class="row  col-lg-offset-1 col-md-offset-1" id="stg-name">
                    <br>
                    <div class="col-xs-offset-1 col-xs-10">
                      <form class="form-horizontal" role="form" method="post">
                        <div class="row">
                          <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3" for="new-name">Nama Baru : </label>
                            <div class="col-lg-6 col-md-6">
                              <input type="text" class="form-control" name="new-name" placeholder="Masukkan nama baru" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group">
                            <div class="col-lg-3 col-md-3"></div>
                            <div class="col-lg-3 col-md-3">
                              <button type="submit" class="btn btn-success btn-block" name="save-name"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                            </div>
                            <div class="col-lg-3 col-md-3">
                              <button type="reset" class="btn btn-danger btn-block" id="btn-batal-name" name="reset"><span class="glyphicon glyphicon-remove"></span> Batal</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- sunting nama -->
                  <hr>

                  <div class="row">
                    <div class="col-md-4">
                      <label><b>Nama Pengguna</b></label>
                    </div>
                    <div class="col-md-6">
                      <span><?= $row['username']; ?></span>
                    </div>
                    <div class="col-md-2">
                      <a href="#" id="username"><i class="fa fa-fw fa-edit"></i> Sunting</a>
                    </div>
                  </div>
                  <!-- sunting nama pengguna -->
                  <div class="row  col-lg-offset-1 col-md-offset-1" id="stg-username">
                    <br>
                    <div class="col-xs-offset-1 col-xs-10">
                      <form class="form-horizontal" role="form" method="post">
                        <div class="row">
                          <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3" for="new-username">Nama Baru : </label>
                            <div class="col-lg-6 col-md-6">
                              <input type="text" class="form-control" name="new-username" placeholder="Masukkan nama pengguna baru" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group">
                            <div class="col-lg-3 col-md-3"></div>
                            <div class="col-lg-3 col-md-3">
                              <button type="submit" class="btn btn-success btn-block" name="save-username"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                            </div>
                            <div class="col-lg-3 col-md-3">
                              <button type="reset" class="btn btn-danger btn-block" id="btn-batal-username" name="reset"><span class="glyphicon glyphicon-remove"></span> Batal</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- sunting nama pengguna -->
                  <hr>

                  <div class="row">
                    <div class="col-md-4">
                      <label><b>Kata Sandi</b></label>
                    </div>
                    <div class="col-md-6">
                      <span>
                        <?php
                          if($row['lu'] != "0000-00-00 00:00:00")
                          {
                            $ex = explode(" ", $row['lu']);
                            echo "Terakhir diperbarui tanggal $ex[0], jam $ex[1]";
                          }else{
                            echo "Belum pernah diperbarui.";
                          }
                        ?>
                      </span>
                    </div>
                    <div class="col-md-2">
                      <a href="#" id="password"><i class="fa fa-fw fa-edit"></i> Sunting</a>
                    </div>
                  </div>
                  <!-- sunting kata sandi -->
                  <div class="row  col-lg-offset-1 col-md-offset-1" id="stg-password">
                    <br>
                    <div class="col-xs-offset-1 col-xs-10">
                      <form class="form-horizontal" role="form" method="post">
                        <div class="row">
                          <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3" for="password">Kata Sandi : </label>
                            <div class="col-lg-6 col-md-6">
                              <input type="password" class="form-control" name="password" placeholder="Masukkan kata sandi anda" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3" for="new-password">Kata Sandi Baru : </label>
                            <div class="col-lg-6 col-md-6">
                              <input type="password" class="form-control" name="new-password" placeholder="Masukkan kata sandi baru" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group">
                            <label class="control-label col-lg-3 col-md-3" for="conf-password">Konfirmasi : </label>
                            <div class="col-lg-6 col-md-6">
                              <input type="password" class="form-control" name="conf-password" placeholder="Konfirmasi kata sandi baru" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group">
                            <div class="col-lg-3 col-md-3"></div>
                            <div class="col-lg-3 col-md-3">
                              <button type="submit" class="btn btn-success btn-block" name="save-password"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                            </div>
                            <div class="col-lg-3 col-md-3">
                              <button type="reset" class="btn btn-danger btn-block" id="btn-batal-password" name="reset"><span class="glyphicon glyphicon-remove"></span> Batal</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- sunting kata sandi -->
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <script>
        $(document).ready(function(){
          $("#name").click(function(){
            $(this).fadeOut(500);
            $("#stg-name").slideDown(500);
            $("#stg-username").slideUp(500);
            $("#username").fadeIn(500);
            $("#stg-password").slideUp(500);
            $("#password").fadeIn(500);
          });
          $("#btn-batal-name").click(function(){
            $("#stg-name").slideUp(500);
            $("#name").fadeIn(500);
          });

          $("#username").click(function(){
            $(this).fadeOut(500);
            $("#stg-username").slideDown(500);
            $("#stg-name").slideUp(500);
            $("#name").fadeIn(500);
            $("#stg-password").slideUp(500);
            $("#password").fadeIn(500);
          });
          $("#btn-batal-username").click(function(){
            $("#stg-username").slideUp(500);
            $("#username").fadeIn(500);
          });

          $("#password").click(function(){
            $(this).fadeOut(500);
            $("#stg-password").slideDown(500);
            $("#stg-name").slideUp(500);
            $("#name").fadeIn(500);
            $("#stg-username").slideUp(500);
            $("#username").fadeIn(500);
          });
          $("#btn-batal-password").click(function(){
            $("#stg-password").slideUp(500);
            $("#password").fadeIn(500);
          });
        });
      </script>
<?php
    include_once('core/footer.php');
  }
?>
