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

    $data=$purchase->get_purchases_year_current();
    $data_sale=$sale->get_sales_year_current();  
?>

<?php require_once("header.php"); ?>
<div class="content-wrapper">
  <!-- Home Page header -->
  <section class="content-header">
    <h1>
      HOME
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

    <!--  START INFO CONTENT AND GRAPHS -->

    <h2 class="container-fluid bg-primary text-white text-center mh-50">
      RESUME PURCHASES - <?php echo date("Y");?>
    </h2>
    <div class="row">
      <div class="">
        <div class="box">
          <div class="box-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10%">YEAR</th>
                  <th style="width: 10%">MONTH</th>
                  <th style="width: 10%">PERCENTAGE(%)</th>
                  <th style="width: 10%">TOTAL</th>
                  <th style="width: 30%" class="hidden-xs">MONTHLY PURCHASES - PROGRESS BAR</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $arrayReg= array();
                    for($i=0;$i<count($data);$i++){
                      array_push($arrayReg, array(
                          "year" => $data[$i]["year"],
                          "month" => $data[$i]["month"],
                          "total_purchase_month" => $data[$i]["total_purchase_month"],
                           "currency" => $data[$i]["currency"]
                      )
                    );
                  }
                ?>
                <?php  
                  $sumTotal=0;
                  for($i=0;$i<count($arrayReg);$i++){
                    $sumTotal= $sumTotal + $data[$i]["total_purchase_month"];
                  }
                ?>
                <?php
                  for($i=0;$i<count($arrayReg);$i++){
                    $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
                    $date= $arrayReg[$i]["month"];
                    $date_month = $months[date("n", strtotime($date))-1];
                    $percentage= round($arrayReg[$i]["total_purchase_month"]/$sumTotal*100,2);
                    ?>
                    <tr>
                      <td><?php echo $arrayReg[$i]["year"]?></td>
                      <td><?php echo $date_month?></td>
                      <td><?php echo $percentage?></td>
                      <td><?php echo $arrayReg[$i]["currency"]." ".$arrayReg[$i]["total_purchase_month"]?></td>
                      <td class="hidden-xs">
                        <div class="progress progress-xs">
                          <?php
                            if($percentage>24){
                              $class="progress-bar progress-bar-primary";
                            } else if($percentage>10 or $percentage<24) {
                                $class="progress-bar progress-bar-yellow";
                            } else if($percentage<=10) {
                                   $class="progress-bar progress-bar-danger";
                            }
                          ?>
                          <div class="<?php echo $class;?>" style="width: <?php echo $percentage;?>%">
                            <?php echo $percentage;?>%
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php
                  }//end for
                ?>
                <td></td>
                <td><strong>TOTAL AMMOUNT (<?php echo date("Y");?>)</strong></td>
                <td><strong>100%</strong></td>
                <td><strong><?php echo "US$ ".$sumTotal?></strong></td>
              </tbody>
            </table>
          </div><!--end box-body-->
        </div><!--end box-->
      </div><!--end col-sm-6-->
    </div><!--row-->

    <h2 class="container-fluid bg-red text-white text-center mh-50">
      RESUME SALES - <?php echo date("Y");?>
    </h2>
    <div class="row">
      <div class="">
        <div class="box">
          <div class="box-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10%">YEAR</th>
                  <th style="width: 10%">MONTH</th>
                  <th style="width: 10%">PERCENTAGE(%)</th>
                  <th style="width: 10%">TOTAL</th>
                  <th style="width: 30%" class="hidden-xs">MONTHLY SALES - PROGRESS BAR</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $arrayReg= array();
                  for($i=0;$i<count($data_sale);$i++){
                    array_push($arrayReg, array(
                        "year" => $data_sale[$i]["year"],
                        "month" => $data_sale[$i]["month"],
                        "total_sale_month" => $data_sale[$i]["total_sale_month"],
                         "currency" => $data_sale[$i]["currency"]
                        )
                    );
                  }
                ?>
                <?php  
                  $sumTotal=0;
                  for($i=0;$i<count($arrayReg);$i++){
                    $sumTotal= $sumTotal + $data_sale[$i]["total_sale_month"];
                  }
                ?>
                <?php
                  for($i=0;$i<count($arrayReg);$i++){
                    $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
                    $date= $arrayReg[$i]["month"];
                    $date_month = $months[date("n", strtotime($date))-1];
                    $percentage= round($arrayReg[$i]["total_sale_month"]/$sumTotal*100,2);
                    ?>
                    <tr>
                      <td><?php echo $arrayReg[$i]["year"]?></td>
                      <td><?php echo $date_month?></td>
                      <td><?php echo $percentage?></td>
                      <td><?php echo $arrayReg[$i]["currency"]." ".$arrayReg[$i]["total_sale_month"]?></td>
                      <td class="hidden-xs">
                        <div class="progress progress-xs">
                          <?php
                            if($percentage>24){
                              $class="progress-bar progress-bar-primary";
                            } else if($percentage>10 or $percentage<24) {
                                $class="progress-bar progress-bar-yellow";
                            } else if($percentage<=10) {
                                $class="progress-bar progress-bar-danger";
                            }
                          ?>
                          <div class="<?php echo $class;?>" style="width: <?php echo $percentage;?>%">
                            <?php echo $percentage;?>%
                          </div>
                        </div>
                      </td>
                    </tr>
                    <?php
                  }// end for
                ?>
                <td></td>
                <td><strong>TOTAL AMMOUNT(<?php echo date("Y");?>)</strong></td>
                <td><strong>100%</strong></td>
                <td><strong><?php echo "US$ ".$sumTotal?></strong></td>
              </tbody>
            </table>
          </div><!--end box-body-->
        </div><!--end box-->
      </div><!--end col-sm-6-->
    </div><!--row-->

    <!-- purchases graphs -->
    <div class="row">
      <div class="col-lg-6 col-xs-12">
        <div class="box">
          <div class="box-body">
            <h2 class="bg-primary text-white col-lg-12 text-center"> 
              RESUME PURCHASES - <?php echo date("Y");?>
            </h2>
            <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">
            </div>
          </div><!--end box-body-->
        </div><!--end box-->
      </div><!--col-sm-->

      <!-- sales graphs-->
      <div class="col-lg-6 col-xs-12">
        <div class="box">
          <div class="box-body">
            <h2 class="bg-red text-white col-lg-12 text-center"> 
              RESUME SALES - <?php echo date("Y");?>
            </h2>
            <div id="container_sales" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">
            </div>
          </div><!--end box-body-->
        </div><!--end box-->
      </div><!--col-sm-->
    </div><!--end row-->

    <!-- END CONTENT-->

  </section>
</div>

<?php require_once("footer.php"); ?>
 
<script type="text/javascript">
   /* purchases graphs*/
  $(document).ready(function() {
    var chart = new Highcharts.Chart({
        chart: {
              renderTo: 'container', 
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false,
              type: 'pie'
          },
              exporting: {
              url: 'http://export.highcharts.com/',
              enabled: false
                },
          title: {
              text: ''
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                showInLegend:true,
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: true,
                      format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                      style: {
                          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

                           fontSize: '20px'
                      }
                  }
              }
          },
           legend: {
              symbolWidth: 12,
              symbolHeight: 18,
              padding: 0,
              margin: 15,
              symbolPadding: 5,
              itemDistance: 40,
              itemStyle: { "fontSize": "17px", "fontWeight": "normal" }
          },
          series: [
                {
          name: 'Brands',
          colorByPoint: true,
          data: [
          <?php echo $data_graph= $purchase->get_purchases_year_current_graph();?>
          ]
          }], 
          exporting: {
                enabled: false
             }
      });
    });

   /* sales graphs*/
    $(document).ready(function() {
      var chart = new Highcharts.Chart({
         chart: {
              renderTo: 'container_sales', 
              plotBackgroundColor: null,
              plotBorderWidth: null,
              plotShadow: false,
              type: 'pie'
          },
              exporting: {
              url: 'http://export.highcharts.com/',
              enabled: false
                },
          title: {
              text: ''
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                showInLegend:true,
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: true,
                      format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                      style: {
                          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

                           fontSize: '20px'
                      }
                  }
              }
          },
           legend: {
              symbolWidth: 12,
              symbolHeight: 18,
              padding: 0,
              margin: 15,
              symbolPadding: 5,
              itemDistance: 40,
              itemStyle: { "fontSize": "17px", "fontWeight": "normal" }
          },

          series: [
                {
          name: 'Brands',
          colorByPoint: true,
          data: [
          <?php echo $data_graph= $sale->get_sales_year_current_graph();?>
          ]
          }], 
          exporting: {
                enabled: false
             }
      });
  });
</script>

<?php  
  } else {
    header("Location:".Connect::route()."views/index.php");
    exit();
  }

?>