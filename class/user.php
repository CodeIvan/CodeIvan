<?php
  require_once "dbconfig.php";
  class User extends Database
  {
    private $conn;
    public function __construct()
    {
      $db = $this->dbConnection();
      $this->conn = $db;
    }
    public function getAllUsers()
    {
      $stmt = $this->conn->prepare("SELECT * FROM users");
      $stmt->execute();
      return $stmt;
    }
    public function getUser($id_user)
    {
      $stmt = $this->conn->prepare("SELECT * FROM users WHERE id_user = :id_user");
      $stmt->execute(array(":id_user" => $id_user));
      return $stmt;
    }
    public function countUser()
    {
      $stmt = $this->conn->prepare("SELECT COUNT(*) as count_user FROM users");
      $stmt->execute();
      return $stmt;
    }
    public function doLogin($username, $password)
    {
      $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
      $stmt->execute(array(":username" => $username));
      if($stmt->rowCount() > 0)
      {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $hash = $result['password'];
        $pass = $this->passwordVerify($password, $hash);

        if($pass)
        {
          $_SESSION['id_user'] = $result['id_user'];
          $_SESSION['nm_user'] = $result['nm_user'];
          $_SESSION['username'] = $result['username'];
          $_SESSION['gender'] = $result['gender'];
          $_SESSION['level'] = $result['level'];
          return true;
        }else{
          $this->redirect('login.php?error');
          exit;
        }
      }else{
        $this->redirect('login.php?error');
        exit;
      }
    }
    public function doLogout()
    {
      session_destroy();
      $_SESSION['username'] = false;
    }
    public function user_add($nm_user, $username, $password, $gender, $level)
    {
      try {
        $pass = $this->passwordHash($password);
        $stmt = $this->conn->prepare("INSERT INTO users (nm_user, username, password, gender, level) VALUES (:nm_user, :username, :password, :gender, :level)");
        $stmt->bindparam(":nm_user", $nm_user);
        $stmt->bindparam(":username", $username);
        $stmt->bindparam(":password", $pass);
        $stmt->bindparam(":gender", $gender);
        $stmt->bindparam(":level", $level);
        $stmt->execute();
        return $stmt;
      } catch (PDOException $e) {
        echo $e->getMessage();
      }
    }
    public function name_edit($id_user, $nm_user)
    {
      try {
        $stmt = $this->conn->prepare("UPDATE users SET nm_user = :nm_user WHERE id_user = :id_user");
        $stmt->bindparam(":nm_user", $nm_user);
        $stmt->bindparam(":id_user", $id_user);
        $stmt->execute();
        return true;
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function username_edit($id_user, $username)
    {
      try {
        $stmt = $this->conn->prepare("UPDATE users SET username = :username WHERE id_user = :id_user");
        $stmt->bindparam(":username", $username);
        $stmt->bindparam(":id_user", $id_user);
        $stmt->execute();
        return true;
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function password_edit($id_user, $password)
    {
      try {
        date_default_timezone_set("Asia/Jakarta");
        $lu = date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE users SET password = :password, lu = :lu WHERE id_user = :id_user");
        $stmt->bindparam(":password", $password);
        $stmt->bindparam(":lu", $lu);
        $stmt->bindparam(":id_user", $id_user);
        $stmt->execute();
        return true;
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }
    public function user_delete($id_user)
    {
      $stmt = $this->conn->prepare("DELETE FROM users WHERE id_user = :id_user");
      $stmt->execute(array(":id_user" => $id_user));
      return true;
    }
    public function nm_user()
    {
      $nama = explode(" ", $_SESSION['nm_user']);
      $baru = array();
      foreach($nama as $kata)
      {
        $dpnbsr = ucfirst(strtolower($kata));
        $baru[] = $dpnbsr;
      }
      $gabung = implode(" ", $baru);
      return ucfirst($gabung);
    }
    public function level()
    {
      if($_SESSION['level'] == 1){
        return "Administrator";
      }else if($_SESSION['level'] == 2){
        return "Chef";
      }else if($_SESSION['level'] == 3){
        return "Cashier";
      }
    }
    public function foto($class)
    {
      if($_SESSION['gender'] == 1)
      {
        return "<img src='../assets/dist/img/avatar5.png' class='$class' alt='User Image'>";
      }else{
        return "<img src='../assets/dist/img/avatar2.png' class='$class' alt='User Image'>";
      }
    }
  }
  $user = new User();
  if(isset($_POST['uname'])){
    if($user->doLogin($_POST['uname'], $_POST['pwd'])){
      echo "OK";
    }else{
      echo "NO";
    }
  }
?>
