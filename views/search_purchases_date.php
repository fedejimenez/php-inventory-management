
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
       Search Purchases by Date
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
               <button type="button" class="btn btn-primary" id="btn_purchase_date"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
             </div>

         </form>
        </div>
      </div>


      <!-- modal to see purchase detail-->
      <?php require_once("modal/purchase_detail_modal.php");?>
      <div class="row">
        <div class="col-xs-12">
          <div class="table-responsive">
            <div class="box-header">
              <h3 class="box-title">Purchases by Date</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="purchases_date_data" class="table table-bordered table-striped">
                <thead>
                  <tr style="background-color:#A9D0F5">
                    <th>See Detail</th>
                    <th>Purchase Date</th>
                    <th>Purchase Number</th>
                    <th>Supplier</th>
                    <th>Id Number Supplier</th>
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

<!--AJAX PURCHASES-->
<script type="text/javascript" src="js/purchase.js"></script>


<?php
   
  } else {
        header("Location:".Connect::route()."views/index.php");
     }

?>