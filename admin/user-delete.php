<?php
  require_once '../class/user.php';
  $user = new User();

  if(!$user->is_logged_in())
  {
    $user->redirect('login.php');
  }else{
    if($_SESSION['level'] != 1){
      echo "<script>
        location.href='transaction.php';
      </script>";
    }
    if(isset($_GET['hapus_id'])){
      if ($_GET['hapus_id'] == $_SESSION['id_user']) {
        echo "<script>
          location.href='user.php';
        </script>";
      }else{
      if(isset($_POST['oke'])){
        $id_user = $_GET['hapus_id'];
        if($user->user_delete($id_user)){
          echo "<script>
            location.href='user.php?success';
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
            <h4><span class="glyphicon glyphicon-trash"></span> Hapus Pengguna</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger fade in">
              <strong>Yakin?</strong> Hapus data berikut.
            </div>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Nama Pengguna</th>
                    <th>Jenis Kelamin</th>
                    <th>Level</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $stmt = $user->getUser($_GET['hapus_id']);
                    if($stmt->rowCount() > 0){
                      while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $jk='';
                        if($row['gender'] == 1){
                          $jk = "Laki-laki";
                        }else{
                          $jk = "Perempuan";
                        }
                        $level = '';
                        if($row['level'] == 1){
                          $level = "Administrator";
                        }elseif($row['level'] == 2) {
                          $level = "Chef";
                        }elseif ($row['level'] == 3) {
                          $level = "Cashier";
                        }
                  ?>
                  <tr>
                    <td><?= $row['id_user']; ?></td>
                    <td><?= $row['nm_user']; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $jk; ?></td>
                    <td><?= $level; ?></td>
                  </tr>
                  <?php
                      }
                    }else{
                      echo "<script>
                        location.href='user.php';
                      </script>";
                    }
                  ?>
                </tbody>
              </table>
            </div>
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
        location.href='user.php';
      });
      $("#close").click(function(){
        location.href='user.php';
      });
    });
  </script>
<?php
    }
  }
}
?>
