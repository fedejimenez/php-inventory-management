<?php
/* Only INLINE STYLES, NO BOOTSTRAP OR CSS*/
require_once("../config/connection.php"); 
  if(isset($_SESSION["idnumber"]) and isset($_SESSION["email"])){
    require_once("../models/Client.php");
    require_once("../models/Sale.php");
    require_once("../models/Company.php");

    $clients=new Client();
    $sale = new Sale();
    $info_company=new Company();

    $data=$clients->get_client_by_idnumber($_POST["idnumber"]);
    $sales=$sale->get_sale_by_date($_POST["idnumber"],$_POST["datepicker"],$_POST["datepicker2"]);
    $total_products=$sale->get_quantity_products_by_date($_POST["idnumber"],$_POST["datepicker"],$_POST["datepicker2"]);
    $data_company=$info_company->get_company();
    ob_start(); 
?>

<link type="text/css" rel="stylesheet" href="dompdf/css/print_static.css"/>
  <style type="text/css">
    .Estilo1{
      font-size: 13px;
      font-weight: bold;
    }
    .Estilo2{font-size: 13px}
    .Estilo3{font-size: 13px; font-weight: bold;}
    .Estilo4{color: #FFFFFF}
  </style>
  <table style="width: 100%;" class="header">
    <tr>
      <td width="54%" height="111"><h1 style="text-align: left; margin-right:20px;"><img src="../public/images/logo_market.jpg" width="340" height="200"  /></h1>
      </td>
      <td width="46%" height="111">
        <table style="width: 100%; font-size: 10pt;">
          <tr>
            <td><strong>COMPANY DATA</strong></td>
          </tr>
          <tr>
            <td><strong>COMPANY ID NUMBER: </strong> <?php echo $data_company[0]["idnumber_company"]; ?></td>
          </tr>
          <tr>
            <td><strong>COMPANY: </strong> <?php echo $data_company[0]["name_company"]; ?></td>
          </tr>
          <tr>
            <td width="43%"><strong>SELLER DATA:</strong></td>
          </tr>
          <tr>
            <td><strong>NAME </strong><?php echo $_SESSION["name"]; ?></td>
          </tr>
          <tr>
            <td><strong>ID NUMBER: </strong><?php echo $_SESSION["idnumber"]; ?></td>
          </tr>
          <tr>
            <td><strong>DATE/TIME PRINTED: </strong>
              <?php echo $date=date("d-m-Y h:i:s A"); ?></td>
          </tr>
          <tr></tr>
        </table><!-- end second table-->
      </td> 
    </tr>
  </table>

  <div align="center" style="color:black; font-weight:bolder; font-size:20px;">DETAILS  </div>
    <table width="101%" class="change_order_items">
      <tr>
        <th colspan="5" style="font-size:15pt">CLIENT DATA: </th>
      </tr>
      <tr>
        <th width="5%" bgcolor="#317eac"><span class="Estilo11">ID NUMBER</span>
        </th>
        <th width="15%" bgcolor="#317eac"><span class="Estilo11">NAME</span></th>
        <th width="12%" bgcolor="#317eac"><span class="Estilo11">PHONE</span></th>
        <th width="38%" bgcolor="#317eac"><span class="Estilo11">ADDRESS</span></th>
        <th width="30%" bgcolor="#317eac"><span class="Estilo11">EMAIL</span></th>
        <?php
          if(empty($_POST["idnumber"])){
            echo "<span style='font-size:20px; color:red'>SELECT A SUPPLIER</span>";
          }
        ?>
      </tr>
      <?php
        for($i=0;$i<sizeof($data);$i++){
          ?>
          <tr style="font-size:10pt" class="even_row">
          <td><div align="center"><span class=""><?php echo $data[$i]["idnumber_client"];?></span></div></td>
          <td style="text-align: center"><div align="center"><span class=""><?php echo $data[$i]["idnumber_client"];?></span></div></td>
          <td style="text-align: center"><div align="center"><span class=""><?php echo $data[$i]["phone_client"];?></span></div></td>
          <td style="text-align: right"><div align="center"><span class=""><?php echo $data[$i]["address_client"];?></span></div></td>
          <td style="text-align:center"><div align="center"><span class=""><?php echo $data[$i]["email_client"];?></span></div></td>
          </tr>
          <?php
        }
      ?>
    </table>
  </div>
  <div style="font-size: 7pt">
    <table width="102%" class="change_order_items">
      <tr>
        <td colspan="5" style="font-size:15pt"><div align="center"><strong>SALES LIST </strong></div></td>
      </tr>
      <tr>
        <th width="15%" bgcolor="#317eac"><span class="Estilo1">PRODUCT </span></th>
        <th width="10%" bgcolor="#317eac"><span class="Estilo11">SALE PRICE</span></th>
        <th width="5%" bgcolor="#317eac"><span class="Estilo11">QUANTITY</span></th>
        <th width="10%" bgcolor="#317eac"><span class="Estilo11">QUANTITY * SALE PRICE</span>
        <th width="10%" bgcolor="#317eac"><span class="Estilo11">SALE DATE </span></th>
        <?php
          if(is_array($sales)==true and count($sales)==0){
             echo "<span style='font-size:20px; color:red'>The client doesn't have associated products in this dates</span>";
          }
        ?>
      </tr>
        <?php
        $totalPayment=0;
        for($j=0;$j<count($sales);$j++){
          $choice=$sales[$j]["sale_price"] * $sales[$j]["sale_quantity"];
          $totalPayment= $totalPayment + $choice;
          ?>
          <tr class="even_row" style="font-size:10pt">
            <td style="text-align: center"><span><?php echo $sales[$j]["product"];?></span></td>
             <td style="text-align: center"><span><?php echo $sales[$j]["currency"]." ".$sales[$j]["sale_price"];?></span></td>
            <td style="text-align: center"><span><?php echo $sales[$j]["sale_quantity"];?></span></td>
            <td style="text-align: center"><span class=""><?php echo $sales[$j]["currency"]." ".$sales[$j]["sale_quantity"] * $sales[$j]["sale_price"];?></span></td>
            <td style="text-align: center"><span><?php echo $date=date("d-m-Y",strtotime($sales[$j]["sale_date"])); ?></span></td>
          </tr>
          <?php 
        } ?>
        <tr class="even_row">
          <td colspan="5" style="text-align: center">
            <table style="width: 100%; font-size: 8pt;">
              <tr>
                <td class="even_row" style="text-align: center">&nbsp;</td>
                <td class="odd_row" style="text-align: right; border-right-style: none;">&nbsp;</td>
              </tr>
              <tr>
                <td width="84%" class="even_row" style="font-size:10pt; text-align: center">
                <div align="right"><strong><span style="text-align: right;">SALE TOTAL:</span></strong></div>
                </td>
                <td width="16%" class="odd_row" style="font-size:12pt" text-align: right; border-right-style: none;">
                  <div align="center">
                    <strong>
                      <?php
                       if($totalPayment!=0){
                        echo $sales[0]["currency"]." ".$totalPayment;
                       } else {
                            echo "US$ ".$totalPayment; 
                       }
                      ?>
                    </strong>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="even_row" style="font-size:10pt; text-align: center">
                  <div align="right"><strong><span style="text-align:right;">TOTAL SOLD PRODUCTS:</span></strong></div>
                </td>
                <td class="odd_row" style="font-size:12pt;text-align: right; border-right-style: none;">
                  <div align="center">
                    <strong>
                      <?php 
                        if($totalPayment!=0){
                          echo $total_products["total"];
                        } else {
                          echo "0";
                        }
                      ?>
                    </strong>
                  </div>
                </td>
              </tr> 
            </table>
          </td>
        </tr>     
      </table>

      <table style="border-top: 1px solid black; padding-top: 2em; margin-top: 2em;">
        <tr>
          <td style="padding-top: 0em"><span class="Estilo2"><strong>REVISITED BY :</strong></span></td>
          <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
        </tr>
        <tr>
          <td style="padding-top: 0em"><span class="Estilo3"><span id="result_box" lang="es" xml:lang="es">THIS REPORT IS NOT VALID WITHOUT A SIGNATURE</span></span></td>
          <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
        </tr>
        <tr>
          <td style="padding-top: 0em">&nbsp;</td>
          <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
        </tr>
        <tr>
          <td style="padding-top: 0em"><span class="Estilo1">DATE <?php echo date("d")?> - <?php echo Connect::transform_dates(date('m'))?> - <?php echo date("Y")?></span></td>
          <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
        </tr>
      </table>
    </div>

  <?php
  $output_html = ob_get_contents();
  ob_end_clean(); 
    require_once("dompdf/dompdf_config.inc.php");       
    $dompdf = new DOMPDF();
    $dompdf->load_html($output_html);
    $dompdf->render();
    $dompdf->stream("Products List.pdf", array('Attachment'=>'0'));
  } else{
     header("Location:".Connect::route()."views/index.php");
  }
?>