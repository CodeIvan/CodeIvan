<?php
  session_start();
  class Database
  {
    private $host = "localhost";
    private $db_name = "resto";
    private $username = "root";
    private $password = "";
    private $conn;

    public function dbConnection()
    {
      $this->conn = NULL;
      try {
        $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo "Connection Error : ".$e->getMessage();
      }
      return $this->conn;
    }
    public function paging($query, $record_per_page)
    {
      $starting_position=0;
      if(isset($_GET["page_no"]))
      {
        $starting_position = ($_GET["page_no"]-1)*$record_per_page;
      }
      $query2 = $query." limit $starting_position, $record_per_page";
      return $query2;
    }
    public function paging_link($query, $record_per_page, $url)
    {
      //$self = "menu.php?q=".$_GET['q'];

      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      $total_no_of_record = $stmt->rowCount();

      if($total_no_of_record > 0)
      {
        ?>
        <ul class="pagination">
        <?php
        $total_no_of_pages = ceil($total_no_of_record/$record_per_page);
        $current_page = 1;
        if(isset($_GET["page_no"]))
        {
          $current_page = $_GET["page_no"];
        }
        if($current_page >= 1)
        {
          if($current_page == 1)
          {
            $previous = $current_page;
            echo "<li class='disabled'><a href='#'>First</a></li>";
            echo "<li class='disabled'><a href='#'>Previous</a></li>";
          }else{
            $previous = $current_page-1;
            echo "<li><a href='".$url."page_no=1'>First</a></li>";
            echo "<li><a href='".$url."page_no=".$previous."'>Previous</a></li>";
          }
        }
        for ($i=1; $i <= $total_no_of_pages; $i++)
        {
          if($i==$current_page)
          {
            echo "<li class='active'><a href='#'>".$i."</a></li>";
          }else{
            echo "<li><a href='".$url."page_no=".$i."'>".$i."</a></li>";
          }
        }
        if($current_page <= $total_no_of_pages)
        {
          if($current_page == $total_no_of_pages)
          {
            echo "<li class='disabled'><a href='#'>Next</a></li>";
            echo "<li class='disabled'><a href='#'>Last</a></li>";
          }else{
            $next = $current_page+1;
            echo "<li><a href='".$url."page_no=".$next."'>Next</a></li>";
            echo "<li><a href='".$url."page_no=".$total_no_of_pages."'>Last</a></li>";
          }
        }
        ?>
        </ul>
        <?php
      }
    }
    public function is_logged_in()
    {
      if(isset($_SESSION['username']))
      {
        return true;
      }
    }
    public function redirect($url)
    {
      header("location: $url");
    }
    public function setAlert($nama)
    {
      $_SESSION[$nama] = 1;
    }
    public function alertDanger($nama, $isi)
    {
      if(isset($_SESSION[$nama]))
      {
        echo "<div id='alert' class='alert alert-danger fade in'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          $isi
        </div>";
      }
      unset($_SESSION[$nama]);
    }
    public function alertSuccess($nama, $isi)
    {
      if(isset($_SESSION[$nama]))
      {
        echo "<div id='alert' class='alert alert-success fade in'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          $isi
        </div>";
      }
      unset($_SESSION[$nama]);
    }
    public function generatePassword($password)
    {
      $pass1 = md5($password);
      $char = '7ds9s5d92d8n2027en2vv2ndgejql82';
      $pass2 = sha1(sha1($char).$pass1);
      return substr($pass2, 10, 20);
    }
    public function passwordHash($password)
    {
      $options = [
        'cost' => 11,
        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
      ];
      return password_hash($password, PASSWORD_BCRYPT, $options);
    }
    public function passwordVerify($password, $hash)
    {
      if(password_verify($password, $hash))
      {
        return true;
        //echo "jos";
      }else{
        return false;
        //echo "gak";
      }
    }
  }
?>
