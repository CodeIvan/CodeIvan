<?php
  require_once 'class/menu.php';
  require_once 'class/category.php';
  $menu = new Menu();
  $category = new Category();
  if(!isset($_SESSION['nama']) && !isset($_SESSION['no_meja']))
  {
    $menu->redirect('login.php');
  }else{
    include_once('core/head.php');
    include_once('core/navbar.php');
    include_once('core/header1.php');
?>
      <script>
        $(document).ready(function(){
          $("#sel").change(function(){
            var a = $(this).val();
            //$("#listMenu").load('list_menu.php?q='+a);

            // $.get('list_menu.php',{'q':a}).done(function(data){
            //   $('#listMenu').html(data);
            // });

            $.ajax({
              method: "GET",
              url: "list_menu.php",
              data: { q : a },
              success: function(data){
                $("#listMenu").html(data);
              }
            });
          });
          // $(".pesan").on('click', function(){
          //   var id = $(this).attr('data-id');
          //   $.ajax({
          //     method: "GET",
          //     url: "menu.php",
          //     data: { aksi: 'tambah', id_menu: id },
          //     success: function(data){
          //       $("#acart").html("<img id='cart' src='img/cart.png' alt='cart' width='40' height='40' />(5)</a>");
          //     }
          //   });
          // });
        });
      </script>
      <section id="content">
        <div class="container">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-10">
                <h1>Menu</h1>
              </div>
              <div class="col-md-2" style="margin-top:20px; margin-bottom:10px;">
                <a href="logout.php" role="button" class="btn btn-danger btn-lg"><i class="fa fa-fw fa-sign-out"></i> Batal Pesan</a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3" style="margin-top:10px; margin-bottom:10px;">
                <select class="form-control" name="ktg" id="sel">
                  <option value="">-pilih kategori-</option>
                  <option value="all">Semua</option>
                  <?php
                    $ctg = $category->getAllCategories();
                    foreach ($ctg as $key => $value):
                  ?>
                    <option value="<?= $value['id_category']; ?>"><?= $value['nm_category']; ?></option>
                  <?php
                    endforeach;
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div id="listMenu">
          <?php include_once 'list_menu.php'; ?>
        </div>
      </section>
<?php
    include_once('core/footer.php');
  }
?>
