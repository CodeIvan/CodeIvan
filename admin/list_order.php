<?php
  require_once '../class/transaction.php';
  $trans = new Transaction();
  $s = $_POST['s'];
  // $where='';
  // if($s != ""){
  //   $where = "WHERE name like '%$s%'";
  // }
  //$stmt = $trans->oTrans("SELECT * FROM transactions $where ORDER BY no_trans DESC");
  $stmt = $trans->getOrderDay($s);
  if($stmt->rowCount() > 0)
  {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      $status = '';
      if($row['s1'] == 1){
        $status = "<font color='red'>Belum</font>";
      }elseif($row['s1'] == 2) {
        $status = "<font color='green'>Selesai</font>";
      }
      ?>
      <tr>
        <td><?= $row['no_trans']; ?></td>
        <td><?= $row['date']; ?></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['no_table']; ?></td>
        <td class="sts_<?= $row['no_trans']; ?>"><?= $status; ?></td>
        <td>
          <a role="button" class="btn btn-info" href="detail.php?no_trans=<?= $row['no_trans']; ?>"><i class="fa fa-fw fa-file"></i> Detail</a>
          <?php if($row['s1'] == 1){ ?>
            <button id="masak_<?= $row['no_trans']; ?>" type="button" class="btn btn-warning masak" data-id="<?= $row['no_trans']; ?>" name="masak">Masak</button>
            <span style="display:none" class="selesai_<?= $row['no_trans']; ?>" >
              <font color="green"><i class="fa fa-fw fa-check"></i> Selesai</font>
            </span>
          <?php }else{ ?>
            <span class="selesai_<?= $row['no_trans']; ?>" >
              <font color="green"><i class="fa fa-check"></i> Selesai</font>
            </span>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
    <script>
      $(document).ready(function(){
        $(".masak").click(function(){
          var no_trans = $(this).attr('data-id');
          console.log($.ajax({
            method: "GET",
            url: "list_order.php",
            data: { no_trans: no_trans },
            success: function(data){
              $("#masak_"+no_trans).hide();
              $(".selesai_"+no_trans).show();
              $(".sts_"+no_trans).html("<font color='green'>Selesai</font>");
            }
          }));
        });
      });
    </script>
<?php
    if($_GET['no_trans']){
      $no_trans = $_GET['no_trans'];
      $trans->s1_update($no_trans, 2);
    }
  }else{
?>
  <tr>
    <td colspan="6" align="center">Tidak ada data untuk ditampilkan.</td>
  </tr>
<?php } ?>
