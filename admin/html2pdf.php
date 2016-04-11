<?php
  session_start();
  ob_start();
  include('report.php');
  $content = ob_get_clean();
  $content = '<page>'.nl2br($content).'</page>';
  require_once('../assets/plugins/html2pdf/html2pdf.class.php');
  try {
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->setTestTdInOnePage(false);
    $html2pdf->WriteHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('report.pdf');
  } catch (HTML2PDF_Exception $e) {
    echo $e;
    exit;
  }

?>
