<?php
  require_once '../class/user.php';
  require_once '../class/menu.php';
  require_once '../class/table.php';
  $user = new User();
  $menu = new Menu();
  $table = new Table();

  if(!$user->is_logged_in())
  {
    $user->redirect('login.php');
  }else{
    include_once('core/head.php');
    include_once('core/header.php');
    include_once('core/sidebar.php');
?>
      <!-- .content-wrapper -->
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Dasbor
          </h1>
          <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Dasbor</li>
          </ol>
        </section>

        <!-- .content -->
        <section class="content">

          <div class="row">
            <?php if($_SESSION['level'] == 1){ ?>
            <div class="col-lg-4 col-xs-4">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>
                    <?php
                      $count_user = $user->countUser();
                      $cuser = $count_user->fetch(PDO::FETCH_ASSOC);
                      echo $cuser['count_user'];
                    ?>
                  </h3>
                  <p>Semua Pengguna</p>
                </div>
                <div class="icon">
                  <i class="fa fa-fw fa-user"></i>
                </div>
                <a href="user.php" class="small-box-footer">Selengkapnya... <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-4 col-xs-4">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>
                    <?php
                      $count_table = $table->countTableAvailable();
                      $ctable = $count_table->fetch(PDO::FETCH_ASSOC);
                      echo $ctable['table_available'];
                    ?>
                  </h3>
                  <p>Meja Tersedia</p>
                </div>
                <div class="icon">
                  <i class="fa fa-fw fa-glass"></i>
                </div>
                <a href="table.php" class="small-box-footer">Selengkapnya... <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <?php } ?>
            <?php if($_SESSION['level'] == 1 || $_SESSION['level'] == 2){ ?>
            <div class="col-lg-4 col-xs-4">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>
                    <?php
                      $stmt = $menu->stockMin();
                      $row = $stmt->fetch(PDO::FETCH_ASSOC);
                      echo $row['stock_min'];
                    ?>
                  </h3>
                  <p>Stok Hampir Habis</p>
                </div>
                <div class="icon">
                  <i class="fa fa-fw fa-exclamation-triangle"></i>
                </div>
                <a href="menu.php?stok-min" class="small-box-footer">Selengkapnya... <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div>
          <?php } ?>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-solid bg-yellow-gradient">
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                  <i class="fa fa-calendar"></i>
                  <h3 class="box-title">Calendar</h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <!-- button with a dropdown -->
                    <button class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div><!-- /. tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <!--The calendar -->
                  <div id="calendar" style="width: 100%"></div>
                </div><!-- /.box-body -->
              </div>
            </div>
          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <script src="../assets/plugins/datepicker/bootstrap-datepicker.js"></script>
      <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
      <script>
        $(document).ready(function(){
          $("#calendar").datepicker({
            todayHighlight: true
          });
        });
      </script>
<?php
    include_once('core/footer.php');
  }
?>
