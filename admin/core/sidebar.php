      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <img src="../img/logo.png" alt="logo" width="180" height="180" />
          </div>

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">Menu Navigasi</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dasbor</span></a></li>
            <?php if($_SESSION['level'] == 2){ ?>
              <li><a href="order.php"><i class="fa fa-archive"></i> <span>Pesanan</span></a></li>
            <?php } ?>
            <?php if($_SESSION['level'] == 1 || $_SESSION['level'] == 3){ ?>
              <li><a href="transaction.php"><i class="fa fa-calculator"></i> <span>Transaksi</span></a></li>
            <?php } ?>
            <?php if($_SESSION['level'] == 3){ ?>
              <li><a href="pay-transaction.php"><i class="fa fa-calculator"></i> <span>Transaksi Bayar</span></a></li>
            <?php } ?>
            <?php if($_SESSION['level'] == 1 || $_SESSION['level'] == 2){ ?>
              <li class="treeview">
                <a href="#"><i class="fa fa-table"></i> <span>Menu</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="menu.php"><i class="fa fa-circle-o"></i> Daftar Menu</a></li>
                  <li><a href="menu-add.php"><i class="fa fa-circle-o"></i> Tambah Menu</a></li>
                </ul>
              </li>
            <?php
              }
              if($_SESSION['level'] == 1){
            ?>
              <li class="treeview">
                <a href="#"><i class="fa fa-edit"></i> <span>Kategori</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="category.php"><i class="fa fa-circle-o"></i> Daftar Kategori</a></li>
                  <li><a href="category-add.php"><i class="fa fa-circle-o"></i> Tambah Kategori</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#"><i class="fa fa-glass"></i> <span>Meja</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="table.php"><i class="fa fa-circle-o"></i> Daftar Meja</a></li>
                  <li><a href="table-add.php"><i class="fa fa-circle-o"></i> Tambah Meja</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#"><i class="fa fa-user"></i> <span>Pengguna</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="user.php"><i class="fa fa-circle-o"></i> Data Pengguna</a></li>
                  <?php
                  if($_SESSION['level'] == 1){
                    echo "<li><a href='user-add.php'><i class='fa fa-circle-o'></i> Tambah Pengguna</a></li>";
                  }
                  ?>
                </ul>
              </li>
            <?php } ?>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
