<?php

  require_once("../config/connection.php");
  if(isset($_SESSION["id_user"])){

?>

<?php require_once("header.php");?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
       Search Sales by Date
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div id="results_ajax"></div>
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-inline">

            <div class="form-group">
              <label for="staticEmail" class="col-sm-2 col-form-label">Start Date</label>
               <div class="col-sm-10">
                 <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Start Date">
               </div>
            </div>

            <div class="form-group">
              <label for="inputPassword" class="col-sm-2 col-form-label">End Date</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="datepicker2" name="datepicker2" placeholder="End Date">
              </div>
            </div>

            <div class="btn-group text-center">
               <button type="button" class="btn btn-primary" id="btn_sale_date"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
            </div>
          </form>

        </div>
      </div>

      <!-- Modal with details-->
      <?php require_once("modal/sale_detail_modal.php");?>
    
      <div class="row">
        <div class="col-xs-12">
          <div class="table-responsive">
            <div class="box-header">
              <h3 class="box-title">Sales by Date</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <table id="sales_date_data" class="table table-bordered table-striped">
                <thead>
                <tr style="background-color:#A9D0F5">
                  <th>See Detail</th>
                  <th>Sale Date</th>
                  <th>Purchase Number</th>
                  <th>Client</th>
                  <th>Cliente Id Number</th>
                  <th>Seller</th>
                  <th>Payment Type</th>
                  <th>Total</th>
                  <th>Status</th>
                </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php require_once("footer.php");?>

  <script type="text/javascript" src="js/sale.js"></script>

<?php
   
  } else {
      header("Location:".Connetc::route()."views/index.php");
  }

?>