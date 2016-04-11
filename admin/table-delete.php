<?php
  require_once '../class/table.php';
  $table = new Table();

  if(!$table->is_logged_in())
  {
    $table->redirect('login.php');
  }else{
    if($_SESSION['level'] != 1){
      echo "<script>
        location.href='transaction.php';
      </script>";
    }
    if(isset($_GET['hapus_id'])){
      if(isset($_POST['oke'])){
        $id_table = $_GET['hapus_id'];
        if($table->table_delete($id_table)){
          echo "<script>
            location.href='table.php?success=deleted';
          </script>";
        }
      }
?>
  <form role="form" method="post">
    <div class="modal show">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" id="close" class="close">&times;</button>
            <h4><span class="glyphicon glyphicon-trash"></span> Hapus Meja</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger fade in">
              <strong>Yakin?</strong> Hapus data berikut.
            </div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nomor Meja</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $stmt = $table->getTable($_GET['hapus_id']);
                  if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                      $status;
                      if($row['status'] == 1){
                        $status = 'Tersedia';
                      }else{
                        $status = "Tidak Tersedia";
                      }
                ?>
                <tr>
                  <td><?= $row['id_table']; ?></td>
                  <td><?= $row['no_table']; ?></td>
                  <td><?= $status; ?></td>
                </tr>
                <?php
                    }
                  }else{
                    echo "<script>
                      location.href='table.php';
                    </script>";
                  }
                ?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit" name="oke">Oke</button>
            <button id="btn-batal" class="btn btn-danger" type="button" name="batal">Batal</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <script>
    $(document).ready(function(){
      $("#btn-batal").click(function(){
        location.href='table.php';
      });
      $("#close").click(function(){
        location.href='table.php';
      });
    });
  </script>
<?php
    }
  }
?>
