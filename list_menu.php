<?php
  require_once 'class/menu.php';
  $menu = new Menu();
?>
<style>
  .caption{
    height: 198px;
  }
</style>
<div class="container">
  <?php
  if(isset($_GET['q'])){
    if($_GET['q'] == "")
    {
      $sql = "SELECT * FROM menus WHERE stock > 0";
      $url = "menu.php?";
    }
    elseif($_GET['q'] == "all")
    {
      $sql = "SELECT * FROM menus WHERE stock > 0";
      $url = "menu.php?";
    }else{
      $q = intval($_GET['q']);
      $sql = "SELECT * FROM menus WHERE stock > 0 AND id_category = '$q'";
      $url = "menu.php?q=".$_GET['q']."&";
    }
  }else{
    $sql = "SELECT * FROM menus WHERE stock > 0";
    $url = "menu.php?";
  }
  $rpp = 8;
  $new_sql = $menu->paging($sql, $rpp);
  $stmt = $menu->oMenu($new_sql);
  if($stmt->rowCount() > 0)
  {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      ?>
      <div class="col-sm-3 col-md-3">
        <div class="thumbnail">
          <img class="img-rounded" src="img/<?= $row['image']; ?>" width="250" height="200" alt="image">
          <div class="caption">
            <h3><?= $row['nm_menu']; ?></h3>
            <span>Stok : <?= $row['stock']; ?></span><br>
            <span>Harga : <?= $row['price']; ?></span><br><br>
            <a href="menu.php?aksi=tambah&id_menu=<?= $row['id_menu']; ?>" class="btn btn-warning" role="button">Pesan <i class="fa fa-fw fa-cart-plus fa-lg"></i></a>
            <!-- <button type="button" class="btn btn-warning pesan" data-id="<?= $row['id_menu']; ?>">Coba <i class="fa fa-fw fa-cart-plus fa-lg"></i></a> -->
          </div>
        </div>
      </div>
      <?php
    }
  }
  ?>
</div>
<div class="container">
  <div class="col-md-12">
    <div class="pagination-wrap" style="float:right;">
      <?php
        $menu->paging_link($sql, $rpp, $url);
      ?>
    </div>
  </div>
</div>
