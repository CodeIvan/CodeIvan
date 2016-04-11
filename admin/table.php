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
      include_once('core/head.php');
      include_once('core/header.php');
      include_once('core/sidebar.php');
?>
      <!-- .content-wrapper -->
      <div class="content-wrapper" style="min-height:901px;">
        <section class="content-header">
          <h1>
            Daftar Meja
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Dasbor</a></li>
            <li class="active"><i class="fa fa-table"></i> Daftar Meja</li>
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
                    <strong>Berhasil!</strong> Ubah data meja.
                  </div>";
                }
                if($_GET['success'] == 'deleted'){
                  echo "<div id='alert' class='alert alert-success fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Berhasil!</strong> Hapus data meja.
                  </div>";
                }
              }
              $table->alertDanger('harusDiisi','<strong>Gagal!</strong> tidak boleh kosong');
            ?>
            <div class="box box-warning">
              <div class="box-header">
                <h3>Daftar Meja</h3>
              </div>
              <div class="box-body table-responsive">
                <table id="table" class="table table-bordered table-stripped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nomor Meja</th>
                      <th>Status</th>
                      <th>Pilihan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $id_table;
                      $stmt = $table->getAllTable();
                      if($stmt->rowCount() > 0)
                      {
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                          $status = '';
                          ?>
                          <tr>
                            <td><?= $row['id_table']; ?></td>
                            <td><?= $row['no_table']; ?></td>
                            <td>
                              <?php
                              if($row['status'] == 1){
                                $status = "Tersedia";
                                echo "
                                  <div class='available_$row[id_table]'>
                                    <button type='button' class='btn btn-success available' name='available' data-id='$row[id_table]'>Tersedia <i class='fa fa-fw fa-refresh'></i></button>
                                  </div>
                                ";
                                echo "
                                  <div class='not-available_$row[id_table]' style='display:none;'>
                                    <button type='button' class='btn btn-warning not-available' name='not-available' data-id='$row[id_table]'>Dipakai <i class='fa fa-fw fa-refresh'></i></button>
                                  </div>
                                ";
                              }else{
                                $status = "Dipakai";
                                echo "
                                  <div class='available_$row[id_table]' style='display:none;'>
                                    <button type='button' class='btn btn-success available' name='available' data-id='$row[id_table]'>Tersedia <i class='fa fa-fw fa-refresh'></i></button>
                                    </div>
                                ";
                                echo "
                                  <div class='not-available_$row[id_table]'>
                                    <button type='button' class='btn btn-warning not-available' name='not-available' data-id='$row[id_table]'>Dipakai <i class='fa fa-fw fa-refresh'></i></button>
                                  </div>
                                ";
                              }
                              ?>
                            </td>
                            <td><a href="?hapus_id=<?= $row['id_table']; ?>" role='button' class='btn btn-danger btn-sm'><i class='fa fa-fw fa-trash'></i></a></td>
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
      <?php include_once('table-delete.php'); ?>
      <script>
        $(document).ready(function(){
          cusDT("#table");
          $(document).delegate(".available", "click", function(){
            var id = $(this).attr('data-id');
            $.ajax({
              method: "POST",
              url : "table.php",
              data: { id : id, type : "edit1" },
              success: function(data){
                $(".available_"+id).hide();
                $(".not-available_"+id).show();
              }
            });
          });

          $(document).delegate(".not-available", "click", function(){
            var id = $(this).attr('data-id');
            $.ajax({
              method: "POST",
              url : "table.php",
              data: { id : id, type : "edit2" },
              success: function(data){
                $(".not-available_"+id).hide();
                $(".available_"+id).show();
              }
            });
          });
        });
      </script>
<?php
      if(isset($_POST['id']))
      {
        if($_POST['type'] == "edit1")
        {
          $table->table_edit($_POST['id'],2);
        }elseif($_POST['type'] == "edit2")
        {
          $table->table_edit($_POST['id'],1);
        }
      }
      include_once('core/footer.php');
    }
  }
?>
