<?php
  require_once '../class/user.php';
  $user = new User();
  if($user->is_logged_in())
  {
    $user->redirect('index.php');
  }else{
    if(isset($_POST['signin']))
    {
      $username = $_POST['username'];
      $password = $_POST['password'];

      if($user->doLogin($username, $password))
      {
        $user->redirect('index.php');
      }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>RestoW | Log in</title>

    <!-- CSS -->
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
    <link href="../assets/dist/css/admin.min.css" rel="stylesheet">
    <link href="../assets/plugins/iCheck/square/orange.css" rel="stylesheet">

    <!-- JavaScript -->
    <script src="../assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/iCheck/icheck.min.js"></script>
  </head>
  <body class="login-page">
      <div class="login-box">
        <div class="login-logo">
          <a href="#" ><b>Resto</b>W</a>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
          <?php
            if(isset($_GET['error']))
            {
              echo "
                <div class='alert alert-danger fade in'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  <strong>Gagal!</strong> nama pengguna atau kata sandi salah.
                </div>
              ";
            }
          ?>
          <form action="login.php" method="post">
            <div class="form-group has-feedback">
              <input type="text" name="username" class="form-control" placeholder="Nama Pengguna" autofocus required/>
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required/>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-8">
                <div class="checkbox icheck">
                  <label>
                    <input type="checkbox" checked> Ingat saya
                  </label>
                </div>
              </div><!-- /.col -->
                <div class="col-xs-4">
                  <button type="submit" class="btn btn-warning btn-block btn-flat" name="signin"><i class="fa fa-fw fa-sign-in"></i> Masuk</button>
                </div><!-- /.col -->
            </div>
          </form>
        </div><!-- /.login-box-body -->
      </div><!-- /.login-box -->
      <script>
        $(function () {
          $('input').iCheck({
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange',
            increaseArea: '20%' // optional
          });
        });
    </script>
  </body>
</html>
<?php } ?>
