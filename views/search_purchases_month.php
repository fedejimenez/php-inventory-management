
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
       Search Purchases by Month
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div id="resultados_ajax"></div>
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-inline">
            
            <div class="form-group">
              <div class="col-sm-10">
                <select name="month" id="month" class="form-control">
                  <option value="">MONTH</option>
                  <option value="01">JANUARY</option>
                  <option value="02">FEBRUARY</option>
                  <option value="03">MARCH</option>
                  <option value="04">APRIL</option>
                  <option value="05">MAY</option>
                  <option value="06">JUNE</option>
                  <option value="07">JULY</option>
                  <option value="08">AUGUST</option>
                  <option value="09">SEPTEMBER</option>
                  <option value="10">OCTOBER</option>
                  <option value="11">NOVEMBER</option>
                  <option value="12">DECEMBER</option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-10">
                <select name="year" id="year" class="form-control">
                  <option value="">YEAR</option>
                  <option value="2014">2014</option>
                  <option value="2015">2015</option>
                  <option value="2016">2016</option>
                  <option value="2017">2017</option>
                  <option value="2018">2018</option>
                  <option value="2019">2019</option>
                </select>
              </div>
            </div>

            <div class="btn-group text-center">
              <button type="button" class="btn btn-primary" id="btn_purchase_date_month"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
            </div>
          
          </form>
        </div>
      </div>


      <!-- Modal, show purchase detailL-->
      <?php require_once("modal/purchase_detail_modal.php");?>
        <div class="row">
          <div class="col-xs-12">
            <div class="table-responsive">
              <div class="box-header">
                <h3 class="box-title">Purchases by Month</h3>
              </div>
            
              <div class="box-body">
                <table id="purchases_date_month_data" class="table table-bordered table-striped">
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
        header("Location:".Connect::route()."index.php");
        exit();
  }

?>