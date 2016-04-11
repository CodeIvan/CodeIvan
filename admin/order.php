<?php
  require_once '../class/transaction.php';
  $trans = new Transaction();
  if(!$trans->is_logged_in())
  {
    header('location: login.php');
  }else{
    if($_SESSION['level'] != 2){
      echo "<script>
        location.href='transaction.php';
      </script>";
    }else{
      include_once('core/head.php');
      include_once('core/header.php');
      include_once('core/sidebar.php');
?>
      <!-- .content-wrapper -->
      <div class="content-wrapper" style="height:1366px;">
        <section class="content-header">
          <h1>
            Daftar Pesanan
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
            <li class="active"><i class="fa fa-table"></i> Daftar Pesanan</li>
          </ol>
        </section>

        <!-- .content -->
        <section class="content">
          <div class="col-lg-12">
            <?php
              if(isset($_GET['success']))
              {
                echo "<div class='alert alert-success fade in'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  <strong>Berhasil!</strong> Hapus data pengguna.
                </div>";
              }
            ?>
            <div class="box box-warning">
              <div class="box-header">
                <h3>Daftar Pesanan</h3>
              </div>
              <div class="box-body table-responsive">
                <div class="pull-right">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-2">
                        <i class="glyphicon glyphicon-search fa-lg"></i>
                      </div>
                      <div class="col-md-10">
                        <input type="text" class="form-control" id="valSearch" name="search" value="">
                      </div>
                    </div>
                  </div>
                </div><br><br>
                <table id="order" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>no_trans</th>
                      <th>Tanggal</th>
                      <th>Nama Pelanggan</th>
                      <th>No.Meja</th>
                      <th>Status</th>
                      <th>Pilihan</th>
                    </tr>
                  </thead>
                  <tbody id="dtBody"></tbody>
                </table>
              </div>
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <script>
        $(document).ready(function(){
          setInterval(function(){
            var search = $("#valSearch").val();
            $.ajax({
              method: "POST",
              url: "list_order.php",
              cache: false,
              data: {s:search},
              success: function(tampung){
                $("#dtBody").html(tampung);
              }
            });
          }, 1000);
        });
      </script>
<?php
      include_once('core/footer.php');
    }
  }
?>
