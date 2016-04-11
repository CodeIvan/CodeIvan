<?php
  require_once 'dbconfig.php';
  class Transaction extends Database
  {
    private $conn;
    public function __construct()
    {
      $db = $this->dbConnection();
      $this->conn = $db;
    }
    public function getAllTransaction()
    {
      $stmt = $this->conn->prepare("SELECT * FROM transactions ORDER BY no_trans DESC");
      $stmt->execute();
      return $stmt;
    }
    public function getDetail($no_trans)
    {
      $stmt = $this->conn->prepare("SELECT * FROM details WHERE no_trans = :no_trans");
      $stmt->execute(array(":no_trans" => $no_trans));
      return $stmt;
    }
    public function getTransaction($no_trans)
    {
      $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE no_trans = :no_trans");
      $stmt->execute(array(":no_trans" => $no_trans));
      return $stmt;
    }
    public function getTransDone()
    {
      $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE `s2`=2 ORDER BY no_trans DESC");
      $stmt->execute();
      return $stmt;
    }
    public function getTransPay()
    {
      $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE `s2`=1 ORDER BY no_trans DESC");
      $stmt->execute();
      return $stmt;
    }
    public function getReport($tgl1, $tgl2)
    {
      $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE `date` >= :tgl1 AND `date` <= :tgl2 AND s2 = '2'");
      $stmt->execute(array(":tgl1" => $tgl1, ":tgl2" => $tgl2));
      return $stmt;
    }
    public function oTrans($sql)
    {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt;
    }
    public function getOrderDay($like=null)
    {
      date_default_timezone_set("Asia/Jakarta");
      $date = date('Y-m-d');
      if($like != null){
        $like="%$like%";
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE `date`='$date' AND name LIKE :like ORDER BY no_trans DESC");
        $stmt->bindparam(":like", $like);
      }else{
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE `date`='$date' ORDER BY no_trans DESC");
      }
      $stmt->execute();
      return $stmt;
    }
    public function transaction_add($no_trans, $date, $name, $no_table, $s1, $s2, $gtotal)
    {
      try {
        $stmt = $this->conn->prepare("INSERT INTO transactions (no_trans, date, name, no_table, s1, s2, gtotal) VALUES
          (:no_trans, :date, :name, :no_table, :s1, :s2, :gtotal)");
        $stmt->bindparam(":no_trans", $no_trans);
        $stmt->bindparam(":date", $date);
        $stmt->bindparam(":name", $name);
        $stmt->bindparam(":no_table", $no_table);
        $stmt->bindparam(":s1", $s1);
        $stmt->bindparam(":s2", $s2);
        $stmt->bindparam(":gtotal", $gtotal);
        $stmt->execute();
        return true;

      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function transaction_edit($no_trans, $s2, $pay, $refund)
    {
      try {
        $stmt = $this->conn->prepare("UPDATE transactions SET s2 = :s2, pay = :pay, refund = :refund WHERE no_trans = :no_trans");
        $stmt->bindparam(":s2", $s2);
        $stmt->bindparam(":pay", $pay);
        $stmt->bindparam(":refund", $refund);
        $stmt->bindparam(":no_trans", $no_trans);
        $stmt->execute();
        return true;

      } catch (PDOException $e) {
        echo $e->getMessage;
        return false;
      }

    }
    public function s1_update($no_trans, $s1)
    {
      try {
        $stmt = $this->conn->prepare("UPDATE transactions SET s1 = :s1 WHERE no_trans = :no_trans");
        $stmt->execute(array(":s1" => $s1, ":no_trans" => $no_trans));
        return true;

      } catch (PDOException $e) {
        $e->getMessage();
        return false;
      }

    }
    public function detail_add($no_trans, $id_menu, $qty)
    {
      try {
        $stmt = $this->conn->prepare("INSERT INTO details (no_trans, id_menu, qty) VALUES (:no_trans, :id_menu, :qty)");
        $stmt->bindparam(":no_trans", $no_trans);
        $stmt->bindparam(":id_menu", $id_menu);
        $stmt->bindparam(":qty", $qty);
        $stmt->execute();
        return true;

      } catch (PDOException $e) {
        $e->getMessage();
        return false;
      }

    }
  }
?>
