<?php
  require_once('dbconfig.php');
  class Category extends Database
  {
    private $conn;
    public function __construct()
    {
      $db = $this->dbConnection();
      $this->conn = $db;
    }
    public function getAllCategories()
    {
      $stmt = $this->conn->prepare("SELECT * FROM categories");
      $stmt->execute();
      return $stmt;
    }
    public function getCategory($id_category)
    {
      $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id_category = :id_category");
      $stmt->execute(array(":id_category" => $id_category));
      return $stmt;
    }
    public function category_add($nm_category)
    {
      try {
        $stmt = $this->conn->prepare("INSERT INTO categories (nm_category) VALUES (:nm_category)");
        $stmt->execute(array(":nm_category" => $nm_category));
        return true;
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function category_edit($id_category, $nm_category)
    {
      try {
        $stmt = $this->conn->prepare("UPDATE categories SET nm_category = :nm_category WHERE id_category = :id_category");
        $stmt->execute(array(":nm_category" => $nm_category, ":id_category" => $id_category));
        return true;
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function category_delete($id_category)
    {
      $stmt = $this->conn->prepare("DELETE FROM categories WHERE id_category = :id_category");
      $stmt->execute(array(":id_category" => $id_category));
      return true;
    }
  }
?>
