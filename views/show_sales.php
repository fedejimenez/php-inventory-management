
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
        Sales - Search
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div id="resultados_ajax"></div>
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="btn-group text-center">
            <a href="sales.php" id="add_button" class="btn btn-primary btn-lg" ><i class="fa fa-plus" aria-hidden="true"></i> New Sale</a>
          </div>
       </div>
      </div>

      <!-- MODAL FOR SALES DETAILS-->
      <?php require_once("modal/sale_detail_modal.php");?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Sales List</h3>
            </div>
            <div class="box-body">
              <table id="sales_data" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>See Details</th>
                    <th>Sale DAte</th>
                    <th>Sale Number</th>
                    <th>Client</th>
                    <th>Client Id Number</th>
                    <th>Seller</th>
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

<script type="text/javascript" src="js/sale.js"></script>

<?php
  } else {
        header("Location:".Connect::rutes()."views/index.php");
  }

?>