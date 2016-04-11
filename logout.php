<?php
  require_once 'class/table.php';
  $table = new Table();
  if($table->table_edit($_SESSION['no_meja'], 1))
  {
    unset($_SESSION['nama']);
    unset($_SESSION['no_meja']);
    $table->redirect('login.php');
  }
?>
