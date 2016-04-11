<?php
  require_once '../class/category.php';
  $category = new Category();

  if(!$category->is_logged_in())
  {
    $category->redirect('login.php');
  }else{
    if($_SESSION['level'] != 1){
      echo "<script>
        location.href='transaction.php';
      </script>";
    }
    if(isset($_GET['hapus_id'])){
      if(isset($_POST['oke'])){
        $id_category = $_GET['hapus_id'];
        if($category->category_delete($id_category)){
          echo "<script>
            location.href='category.php?success=deleted';
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
            <h4><span class="glyphicon glyphicon-trash"></span> Hapus Kategori</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger fade in">
              <strong>Yakin?</strong> Hapus data berikut.
            </div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $stmt = $category->getCategory($_GET['hapus_id']);
                  if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                ?>
                <tr>
                  <td><?= $row['id_category']; ?></td>
                  <td><?= $row['nm_category']; ?></td>
                </tr>
                <?php
                    }
                  }else{
                    echo "<script>
                      location.href='category.php';
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
        location.href='category.php';
      });
      $("#close").click(function(){
        location.href='category.php';
      });
    });
  </script>
<?php
    }
  }
?>
