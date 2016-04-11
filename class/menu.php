<?php
  require_once('dbconfig.php');
  class Menu extends Database
  {
    private $conn;
    public function __construct()
    {
      $db = $this->dbConnection();
      $this->conn = $db;
    }
    public function getAllMenus()
    {
      $stmt = $this->conn->prepare("SELECT * FROM menus");
      $stmt->execute();
      return $stmt;
    }
    public function getMenu($id_menu)
    {
      $stmt = $this->conn->prepare("SELECT * FROM menus WHERE id_menu = :id_menu");
      $stmt->execute(array(":id_menu" => $id_menu));
      return $stmt;
    }
    public function getStock($id_menu)
    {
      $stmt = $this->conn->prepare("SELECT stock FROM menus WHERE id_menu = ':id_menu'");
      $stmt->execute(array(":id_menu" => $id_menu));
      return $stmt;
    }
    public function getStockMin()
    {
      $stmt = $this->conn->prepare("SELECT * FROM menus WHERE stock <= 5");
      $stmt->execute();
      return $stmt;
    }
    public function stockMin()
    {
      $stmt = $this->conn->prepare("SELECT COUNT(*) AS stock_min FROM menus WHERE stock <= 5");
      $stmt->execute();
      return $stmt;
    }
    public function oMenu($sql)
    {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt;
    }
    public function menu_add($nm_menu, $image, $id_category, $stock, $price)
    {
      try {
        $stmt = $this->conn->prepare("INSERT INTO menus (nm_menu, image, id_category, stock, price) VALUES (:nm_menu, :image, :id_category, :stock, :price)");
        $stmt->bindparam(":nm_menu", $nm_menu);
        $stmt->bindparam(":image", $image);
        $stmt->bindparam(":id_category", $id_category);
        $stmt->bindparam(":stock", $stock);
        $stmt->bindparam(":price", $price);
        $stmt->execute();
        return true;
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function menu_edit($id_menu, $nm_menu, $id_category, $stock, $price)
    {
      try {
        $stmt = $this->conn->prepare("UPDATE menus SET nm_menu = :nm_menu, id_category = :id_category, stock = :stock, price = :price WHERE id_menu = :id_menu");
        $stmt->bindparam(":nm_menu", $nm_menu);
        $stmt->bindparam(":id_category", $id_category);
        $stmt->bindparam(":stock", $stock);
        $stmt->bindparam(":price", $price);
        $stmt->bindparam(":id_menu", $id_menu);
        $stmt->execute();
        return true;
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function edit_stock($id_menu, $stock)
    {
      try {
        $stmt = $this->conn->prepare("UPDATE menus SET stock = :stock WHERE id_menu = :id_menu");
        $stmt->bindparam(":stock", $stock);
        $stmt->bindparam(":id_menu", $id_menu);
        $stmt->execute();
        return true;

      } catch (PDOException $e) {
        $e->getMessage();
        return false;
      }

    }
    public function edit_image($id_menu, $img)
    {
      try {
        $stmt = $this->conn->prepare("UPDATE menus SET image = :image WHERE id_menu = :id_menu");
        $stmt->execute(array(":image" => $img, ":id_menu" => $id_menu));
        return true;
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function menu_delete($id_menu)
    {
      $stmt = $this->conn->prepare("DELETE FROM menus WHERE id_menu = :id_menu");
      $stmt->execute(array(":id_menu" => $id_menu));
      return true;
    }
  }
?>
