<?php
  require_once 'class/table.php';
  $meja = new Table();
  include_once('core/head.php');
  include_once('core/navbar.php');
  include_once('core/header1.php');
  if(isset($_SESSION['nama']) && isset($_SESSION['no_meja']))
  {
    $meja->redirect('menu.php');
  }else{
    if(isset($_POST['oke']))
    {
      extract($_POST);
      $res = $meja->getTable($no_meja);
      if($res > 0)
      {
        $meja->table_edit($no_meja, 2);
        $r = $res->fetch(PDO::FETCH_ASSOC);
        $_SESSION['nama'] = $nama;
        $_SESSION['no_meja'] = $r['no_table'];
        header('location: menu.php');
      }
    }
?>
  <section id="content">
    <div class="container">
      <br><br><br>
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <?php
            $meja->alertDanger('logindulu', 'Silakan login dulu!');
          ?>
          <div class="login-panel panel-warning">
            <div class="panel-heading" style="background-color: #F75200; color: #fff;">
              Silakan Login Dulu.
            </div>
            <div class="panel-body" style="border: 1px solid #F75200">
              <form role="form" method="post">
                <div class="form-group">
                  <input type="text" class="form-control" name="nama" placeholder="Nama Pelanggan" required autofocus>
                </div>
                <div class="form-group">
                  <select class="form-control" name="no_meja" required>
                    <option value="">-pilih nomor meja-</option>
                    <?php
                      $sql = "SELECT * FROM tables WHERE status = '1'";
                      $stmt = $meja->oTable($sql);
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                      {
                    ?>
                        <option value="<?= $row['id_table']; ?>"><?= $row['no_table']; ?></option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-warning btn-block" name="oke" value="OK">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
    include_once('core/footer.php');
  }
?>
