<?php  

  require_once("../config/connection.php");

  if (isset($_SESSION["email"])) {
    
    require_once("../models/Supplier.php");
    require_once("../models/Purchase.php");
    require_once("../models/Client.php");
    require_once("../models/Sale.php");

    $supplier = new Supplier();
    $purchase = new Purchase();
    $client = new Client();
    $sale = new Sale();
  
?>

<?php require_once("header.php"); ?>

<div class="content-wrapper">
  <!-- Home Page header -->
  <section class="content-header">
    <h1>
      
    </h1>
  </section>
  
  <!-- Main Content -->
  <section class="content">
    <div class="row panel-modules">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <a href="<?php echo Connect::route()?>views/clients.php">
              <h3><?php echo $client-> get_rows_clients() ?></h3>
              <h2>CLIENTS</h2>
            </a>
          </div>
          <div class="icon">
            <i class="fa fa-users" aria-hidden="true"></i>
          </div>
        </div>
      </div> <!-- END COL CLIENTS-->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <a href="<?php echo Connect::route()?>views/sales.php">
              <h3><?php echo $sale-> get_rows_sales() ?></h3>
              <h2>SALES</h2>
            </a>
          </div>
          <div class="icon">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
          </div>
        </div>
      </div> <!-- END COL SALES-->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <a href="<?php echo Connect::route()?>views/suppliers.php">
              <h3><?php echo $supplier-> get_rows_suppliers() ?></h3>
              <h2>SUPPLIERS</h2>
            </a>
          </div>
          <div class="icon">
            <i class="fa fa-truck" aria-hidden="true"></i>
          </div>
        </div>
      </div> <!-- END COL SUPPLIERS-->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <a href="<?php echo Connect::route()?>views/purchases.php">
              <h3><?php echo $purchase-> get_rows_purchases() ?></h3>
              <h2>PURCHASES</h2>
            </a>
          </div>
          <div class="icon">
            <i class="fa fa-cart-plus" aria-hidden="true"></i>
          </div>
        </div>
      </div> <!-- END COL PURCHASES -->
    </div> <!-- END ROW -->
  </section>
</div>

<?php require_once("footer.php"); ?>
 
<?php  
  } else {
    header("Location:".Connect::route()."views/index.php");
    exit();
  }

?>