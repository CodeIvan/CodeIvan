<?php
  require_once '../class/table.php';
  $table = new Table();
  if(!$table->is_logged_in())
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
        $cek = $table->oTable("SELECT * FROM tables WHERE no_table = '$no_table'");
        if($no_table != ""){
          if($cek->rowCount() > 0)
          {
            $table->setAlert('sudahAda');
          }else{
            if($table->table_add($no_table))
            {
              $table->setAlert('suksesMeja');
            }
          }
        }else{
          $table->setAlert('harusDiisi');
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
      Tambah Meja
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
      <li class="active"><i class="fa fa-edit"></i> Tambah Meja</li>
    </ol>
  </section>

  <!-- .content -->
  <section class="content">
    <div class="col-md-offset-1 col-md-10">
      <?php
        $table->alertSuccess('suksesMeja','<strong>Sukses!</strong> tambah data meja');
        $table->alertDanger('harusDiisi','<strong>Gagal!</strong> tidak boleh kosong');
        $table->alertDanger('sudahAda','<strong>Gagal! nomer meja sudah ada</strong>');
      ?>
      <div class="box box-warning">
        <div class="box-header">
          <h3>Tambah Meja</h3>
        </div>
        <form role="form" id="table" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="no_table">Nomor Meja</label>
              <input type="text" class="form-control" id="no_table" name="no_table" placeholder="Masukkan Nomor Meja" required autofocus>
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
      // if(isset($_POST['not']))
      // {
      //   $not = $_POST['not'];
      //   $cek = $table->oTable("SELECT * FROM tables WHERE no_table = '$not'");
      //   if($cek->rowCount() > 0)
      //   {
      //     die('0');
      //   }else{
      //     $table->table_add($_POST['not']);
      //   }
      // }
      include_once('core/footer.php');
    }
  }
?>
