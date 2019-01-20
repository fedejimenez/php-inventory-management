
<?php

  require_once("../config/connection.php");

    if(isset($_SESSION["id_user"])){
        

?>


<?php require_once("header.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Purchases List
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div id="results_ajax"></div>
        <div class="panel panel-default">
          <div class="panel-body">
         
           <div class="btn-group text-center">
            <a href="purchases.php" id="add_button" class="btn btn-primary btn-lg" ><i class="fa fa-plus" aria-hidden="true"></i> New Purchase</a>
           </div>

       </div>
      </div>

       <!--MODAL with purchase details-->
     <?php require_once("modal/purchase_detail_modal.php");?>
   
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Purchases List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <table id="purchases_data" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>See Details</th>
                  <th>Purchase date</th>
                  <th>Purchase Numebr</th>
                  <th>Supplier</th>
                  <th>Id Number Proveedor</th>
                  <th>Purchaser</th>
                  <th>Payment Type</th>
                  <th>Total</th>
                  <th>Status</th>
                </tr>
                </thead>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php require_once("footer.php");?>

    <!--AJAX SUPPLIERS-->
    <script type="text/javascript" src="js/purchase.js"></script>


<?php
   
  } else {
         header("Location:".Connect::route()."index.php");
     }

?>