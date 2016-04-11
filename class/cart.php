<?php
  $aksi = isset($_GET['aksi'])?$_GET['aksi']:"";
  if(isset($_GET['aksi']))
  {
    $id = isset($_POST['id_menu'])?$_POST['id_menu']:"0";
    $id_menu = isset($_GET['id_menu'])?$_GET['id_menu']:"0";
    switch ($aksi) {
      case 'tambah':
        if(!empty($_SESSION['cart'][$id_menu]))
        {
          $_SESSION['cart'][$id_menu]+=1;
        }else{
          $_SESSION['cart'][$id_menu]=1;
        }
        header('location: menu.php');
        break;
      case 'ubah':
        require_once '../class/menu.php';
        $menu = new Menu();

        if(!empty($_SESSION['cart']))
        {
          $jumlah = isset($_POST['jumlah'])?$_POST['jumlah']:"";
          $hasilstok = isset($_POST['hasilstok'])?$_POST['hasilstok']:"";
          $id = isset($_POST['id'])?$_POST['id']:"";
          $price = isset($_POST['price'])?$_POST['price']:"";
          if($jumlah <= $hasilstok)
          {
            if($jumlah == 0){
              $_SESSION['cart'][$id]=1;
            }else{
              $_SESSION['cart'][$id]=$jumlah;
            }
          }else{
            $_SESSION['cart'][$id]=$hasilstok;
          }
          $temp = '';
          foreach ($_SESSION['cart'] as $key => $val) {
            $sql = "SELECT * FROM menus WHERE id_menu = '$key'";
            $stmt = $menu->oMenu($sql);
            $m = $stmt->fetch(PDO::FETCH_ASSOC);
            $temp += $m['price'] * $val;
          }
          $total = $_SESSION['cart'][$id];
          $total = $total * $price;
          $res = array('total' => $total, 'gtotal' => $temp);
          echo json_encode($res);
          die();
        }
        break;
      case 'hapus':
        $id = $_POST['id_menu'];
        if(!empty($_SESSION['cart'][$id_menu])){
          unset($_SESSION['cart'][$id_menu]);
          header('location:cart.php');
        }else{
          header('location:cart.php');
        }
        break;
    }
  }
?>
