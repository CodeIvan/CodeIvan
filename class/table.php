<?php
  require_once 'dbconfig.php';
  class Table extends Database
  {
    private $conn;
    public function __construct()
    {
      $db = $this->dbConnection();
      $this->conn = $db;
    }
    public function getAllTable()
    {
      $stmt = $this->conn->prepare("SELECT * FROM tables");
      $stmt->execute();
      return $stmt;
    }
    public function getTable($id_table)
    {
      $stmt = $this->conn->prepare("SELECT * FROM tables WHERE id_table = :id_table");
      $stmt->execute(array(":id_table" => $id_table));
      return $stmt;
    }
    public function countTableAvailable()
    {
      $stmt = $this->conn->prepare("SELECT COUNT(*) as table_available FROM tables WHERE status = 1");
      $stmt->execute();
      return $stmt;
    }
    public function oTable($sql)
    {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt;
    }
    public function table_add($no_table)
    {
      try {
        $stmt = $this->conn->prepare("INSERT INTO tables (no_table, status) VALUES (:no_table, '1')");
        $stmt->execute(array(":no_table" => $no_table));
        return true;
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function table_edit($id_table, $sts)
    {
      try {
        $stmt = $this->conn->prepare("UPDATE tables SET status = :status WHERE id_table = :id_table");
        $stmt->execute(array(":status" => $sts, ":id_table" => $id_table));
        return true;

      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function table_delete($id_table)
    {
      $stmt = $this->conn->prepare("DELETE FROM tables WHERE id_table = :id_table");
      $stmt->execute(array(":id_table" => $id_table));
      return true;
    }
  }
  //$table = new Table();
  // if($_POST['type'] == "satu")
  // {
  //   $table->table_edit($_POST['id'],2);
  // }
  // if($_POST['type'] == "edit2")
  // {
  //   $table->table_edit($_POST['id'],1);
  // }
?>
