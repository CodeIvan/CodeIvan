  <body>
    <?php
      $total = 0;
      if(isset($_SESSION['cart']))
      {
        foreach ($_SESSION['cart'] as $key => $val)
        {
          $total = $total + $val;
        }
      }
    ?>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" data-toggle="collapse" data-target="#target-list">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="index.php" class="navbar-brand" style="color:#fff;">RestoW</a>
        </div>
        <div class="collapse navbar-collapse" id="target-list">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="cart.php" id="acart" style="padding:20px;"><img id="cart" src="img/cart.png" alt="cart" width="40" height="40" />(<?= $total; ?>)</a></li>
            <li></li>
          </ul>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        $("#acart").on({
          "mouseover": function(){
            $("#cart").attr("src","img/cart1.png");
          },
          "mouseout": function(){
            $("#cart").attr("src","img/cart.png");
          }
        });
      });
    </script>
