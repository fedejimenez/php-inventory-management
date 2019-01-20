
<?php
/* Only Style as attribute, no css or bootstrap*/

  require_once("../config/connection.php"); 

  if(isset($_SESSION["name"]) and isset($_SESSION["email"])){

  require_once("../models/Supplier.php");
  require_once("../models/Purchase.php");
  require_once("../models/Company.php");

  $suppliers=new Supplier();
  $purchase = new Purchase();
  $info_company=new Company();


  $data=$suppliers->get_supplier_by_idnumber($_POST["idnumber"]);
  $orders=$purchase->get_order_by_date($_POST["idnumber"],$_POST["datepicker"],$_POST["datepicker2"]);

  $total_products=$purchase->get_qty_products_by_date($_POST["idnumber"],$_POST["datepicker"],$_POST["datepicker2"]);

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
          <td><strong>COMPANY INFORMATION</strong></td>
        </tr>

        <tr>
          <td><strong>COMPANY ID NUMBER: </strong> <?php echo $data_company[0]["idnumber_company"]; ?></td>
        </tr>
        <tr>
          <td><strong>COMPANY: </strong> <?php echo $data_company[0]["name_company"]; ?></td>
        </tr>
        
        <tr>
          <td width="43%"><strong>SELER INFORMATION</strong></td>
        </tr>
        <tr>
          <td><strong>NAME: </strong><?php echo $_SESSION["name"]; ?></td>
        </tr>
        <tr>
          <td><strong>ID NUMBER: </strong><?php echo $_SESSION["idnumber"]; ?></td>
        </tr>
        <tr>
          <td><strong>DATE-TIME PRINTED: </strong>
            <?php echo $date=date("d-m-Y h:i:s A"); ?></td>
        </tr>
         <tr></tr>
      </table>
    </td> 
  </tr>
</table>

<div align="center" style="color:black; font-weight:bolder; font-size:20px;">PURCHASES  
</div>
<table width="101%" class="change_order_items">
  <tr>
    <th colspan="5" style="font-size:15pt">SUPPLIER INFORMATION </th>
  </tr>
  <tr>
    <th width="5%" bgcolor="#317eac"><span class="Estilo11">IDNUMBER</span>
    </th>
    <th width="15%" bgcolor="#317eac"><span class="Estilo11">NAME</span>
    </th>
    <th width="12%" bgcolor="#317eac"><span class="Estilo11">PHONE</span>
    </th>
    <th width="38%" bgcolor="#317eac"><span class="Estilo11">ADDRESS</span>
    </th>
    <th width="30%" bgcolor="#317eac"><span class="Estilo11">EMAIL</span>
    </th>
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
    <td><div align="center"><span class=""><?php echo $data[$i]["idnumber"];?></span></div>
    </td>
    <td style="text-align: center"><div align="center"><span class=""><?php echo $data[$i]["corporate_name"];?></span></div></td>
    <td style="text-align: center"><div align="center"><span class=""><?php echo $data[$i]["phone"];?></span></div></td>
    <td style="text-align: right"><div align="center"><span class=""><?php echo $data[$i]["address"];?></span></div></td>
    <td style="text-align:center"><div align="center"><span class=""><?php echo $data[$i]["email"];?></span></div></td>
  </tr>

  <?php
    }
  ?>
  </table>
</div>

<div style="font-size: 7pt">
  <table width="102%" class="change_order_items">
    <tr>
      <td colspan="5" style="font-size:15pt"><div align="center"><strong>PURCHASES - PRODUCTS LIST </strong></div></td>
    </tr>
    <tr>
      <th width="15%" bgcolor="#317eac"><span class="Estilo1">PRODUCT </span></th>
      <th width="10%" bgcolor="#317eac"><span class="Estilo11">PURCHASE PRIC</span></th>
      <th width="5%" bgcolor="#317eac"><span class="Estilo11">QUANTITY</span></th>
      <th width="10%" bgcolor="#317eac"><span class="Estilo11">QUANTITY * PURCHASE PRICE</span>
      <th width="10%" bgcolor="#317eac"><span class="Estilo11">PURCHASE DATE </span></th>

      <?php
         if(is_array($orders)==true and count($orders)==0){
             echo "<span style='font-size:20px; color:red'>THE SUPPLIER DOESN'T HAVE ASSOCIATED PRODUCTS IN THE SELECTED DATE</span>";
         }
      ?>
      </tr>
        <?php
        $paymentTotal=0;
        for($j=0;$j<count($orders);$j++){
           $choice=$orders[$j]["buying_price"] * $orders[$j]["purchase_quantity"];
          $paymentTotal= $paymentTotal + $choice;
         ?>
        <tr class="even_row" style="font-size:10pt">
          <td style="text-align: center"><span><?php echo $orders[$j]["product"];?></span></td>
          <td style="text-align: center"><span><?php echo $orders[$j]["currency"]." ".$orders[$j]["buying_price"];?></span></td>
          <td style="text-align: center"><span><?php echo $orders[$j]["purchase_quantity"];?></span></td>
          <td style="text-align: center"><span class=""><?php echo $orders[$j]["currency"]." ".$orders[$j]["purchase_quantity"] * $orders[$j]["buying_price"];?></span></td>
          <td style="text-align: center"><span><?php echo $date=date("d-m-Y",strtotime($orders[$j]["purchase_date"])); ?></span></td>
        </tr>
      <?php } ?>

  <tr class="even_row">
    <td colspan="5" style="text-align: center"><table style="width: 100%; font-size: 8pt;">
  <tr>
    <td class="even_row" style="text-align: center">&nbsp;</td>
    <td class="odd_row" style="text-align: right; border-right-style: none;">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="84%" class="even_row" style="font-size:10pt; text-align: center">
      <div align="right"><strong><span style="text-align: right;">TOTAL PURCHASE:</span></strong></div>
    </td>
    <td width="16%" class="odd_row" style="font-size:12pt" text-align: right; border-right-style: none;">
      <div align="center">
      <strong>
      <?php 
        if($paymentTotal!=0){
          echo $orders[0]["currency"]." ".$paymentTotal;
        } else {
            echo "US$ ".$paymentTotal; 
        }
      //echo $paymentTotal;
      ?>
      </strong>
      </div>
    </td>
  </tr>
  <tr>
    <td class="even_row" style="font-size:10pt; text-align: center"><div align="right"><strong><span style="text-align:right;">TOTAL PRODUCTS:</span></strong></div></td>
    <td class="odd_row" style="font-size:12pt;text-align: right; border-right-style: none;"><div align="center"><strong>
      <?php 
      if($paymentTotal!=0){
        echo $total_products["total"];
       } else {
            echo "0";
       }
      ?>
      </strong></div>
    </td>
  </tr> 
  </td>
</tr>     
</table>


  <table style="border-top: 1px solid black; padding-top: 2em; margin-top: 2em;">
    <tr>
      <td style="padding-top: 0em"><span class="Estilo2"><strong>REVISITED BY :</strong></span></td>
      <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
    </tr>
    <tr>
      <td style="padding-top: 0em"><span class="Estilo3"><span id="result_box" lang="es" xml:lang="es">THIS REPORT IS NOT VALID WITHOUT A SIGNATURE </span></span></td>
      <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
    </tr>
    <tr>
      <td style="padding-top: 0em">&nbsp;</td>
      <td style="text-align: center; padding-top: 0em;">&nbsp;</td>
    </tr>
    <tr>
      <td style="padding-top: 0em"><span class="Estilo1">DATE: <?php echo date("d")?> - <?php echo Connect::transform_dates(date('m'))?> - <?php echo date("Y")?></span></td>
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

     header("Location:".Connect::route()."index.php");
  }
?>