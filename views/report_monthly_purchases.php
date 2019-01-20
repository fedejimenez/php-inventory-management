<?php
   require_once("../config/connection.php");
   if(isset($_SESSION["id_user"])){
    require_once("../models/Purchase.php");
    $purchases=new Purchase();

    if(isset($_POST["year"])){
      $data= $purchases->get_purchases_monthly($_POST["year"]);  
    } else {
      $start_date=date("Y");
      $data= $purchases->get_purchases_monthly($start_date);  
    }
    $date_purchases= $purchases->get_year_purchases();
?>

<?php require_once("header.php");?>
  <div class="content-wrapper">
    <h2 class="reporte_purchases_general container-fluid bg-red text-white col-lg-12 text-center mh-50">
      REPORT - PURCHASES BY MONTH
    </h2>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="btn-group text-center">
          <button type='button' id="buttonExport" class="btn btn-primary btn-lg" ><i class="fa fa-print" aria-hidden="true"></i> Print</button>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-body">
        <form action="report_monthly_purchases.php" class="form-inline" method="post">
          <div class="form-group">
            <div class="col-sm-10">
              <select class="form-control" name="year" id="year">
                <option value="0">Select...</option>
                <?php
                  if(isset($_POST["year"])){
                    for($i=0; $i<count($date_purchases); $i++){
                      if($date_purchases[$i]["date"]==$_POST["year"]){
                        echo '<option value="'.$date_purchases[$i]["date"].'" selected=selected>'.$date_purchases[$i]["date"].'</option>';
                      } else{ 
                        echo '<option value="'.$date_purchases[$i]["date"].'">'.$date_purchases[$i]["date"].'</option>';
                      } 
                    }// end for
                  } else {
                  for ($i=0; $i<count($date_purchases); $i++){
                    echo '<option value="'. $date_purchases[$i]["date"].'" selected=selected>'. $date_purchases[$i]["date"].'</option>';
                  }// end for
                }//end else*/
              ?>
            </select>
          </div>
        </div>
        <div class="btn-group text-center">
          <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
      <div class="box">
        <div class="">
          <h2 class="report_purchases_general container-fluid bg-primary text-white col-lg-12 text-center mh-50">REPORT - PURCHASES BY MONTH
          </h2>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>YEAR</th>
                <th>N° MONTH</th>
                <th>MONTH NAME</th>
                <th>TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(isset($_POST["year"])){
                  $data= $purchases->get_purchases_monthly($_POST["year"]);
                  for($i=0;$i<count($data);$i++){
                    $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
                    $date= $data[$i]["month"];
                    $date_month = $months[date("n", strtotime($date))-1];
                    ?>
                    <tr>
                      <td><?php echo $data[$i]["year"]?></td>
                      <td><?php echo $data[$i]["number_month"]?></td>
                      <td><?php echo $date_month?></td>
                      <td><?php echo $data[$i]["currency"]." ".$data[$i]["total_purchase"]?></td>
                    </tr>
                    <?php
                  }// end for
                } else {
                  $start_date=date("Y");
                  $data= $purchases->get_purchases_monthly($start_date);  
                  for($i=0;$i<count($data);$i++){
                    $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
                    $date= $data[$i]["month"];
                    $date_month = $months[date("n", strtotime($date))-1];
                    ?>
                    <tr>
                      <td><?php echo $data[$i]["year"]?></td>
                      <td><?php echo $data[$i]["number_month"]?></td>
                      <td><?php echo $date_month?></td>
                      <td><?php echo $data[$i]["currency"]." ".$data[$i]["total_purchase"]?></td>
                    </tr>
                    <?php
                  }//end for
                }//end else
              ?>
            </tbody>
          </table>
       </div><!--end box-body-->
      </div><!--end box-->
    </div><!--end col-xs-12-->
      
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
      <div class="box">
        <h2 class="report_purchases_general container-fluid bg-red text-white col-lg-12 text-center mh-50">REPORT - PURCHASES BY MONTH
        </h2>
        <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">
        </div>
      </div><!--end box-->
    </div><!--end col-xs-6-->
  </div><!--end row-->
</div>

<?php require_once("footer.php");?>
  <script type="text/javascript">
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
          <?php 
      if(isset($_POST["year"])){
          echo $data_grafica= $purchases->suma_purchases_anio_month_grafica($_POST["year"]);
           } else {
           $start_date=date("Y");
            echo $data_grafica= $purchases->suma_purchases_anio_month_grafica($start_date);
           }
          ?>
          ]
          }], 
          exporting: {
                enabled: false
             }
      });
      $('#buttonExport').click(function() {
            printHTML()
      document.addEventListener("DOMContentLoaded", function(event) {
       printHTML(); 
      });
    }); 
});

function printHTML() { 
  if (window.print) { 
    window.print();
  }
}
  
</script>

<?php
   } else {
      header("Location:".Connect::routes()."views/index.php");
   }
?>