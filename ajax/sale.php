 <?php
  
  require_once("../config/connection.php");
  require_once("../models/Sale.php");

  $sales = new Sale();

  switch($_GET["op"]){
    case "search_sales":
      $data=$sales->get_sales();
      $array= Array();
      foreach($data as $row){
        $sub_array = array();
        $stat = '';
         $attrib = "btn btn-danger btn-md status";
        if($row["status"] == 1){
          $stat = 'PAYED';
          $attrib = "btn btn-success btn-md status";
        }
        else{
          if($row["status"] == 0){
            $stat = 'CANCELED';
          } 
        }

        $sub_array[] = '<button class="btn btn-warning detail" id="'.$row["sale_number"].'"  data-toggle="modal" data-target="#detail_sale"><i class="fa fa-eye"></i></button>';
        $sub_array[] = date("d-m-Y",strtotime($row["sale_date"]));
        $sub_array[] = $row["sale_number"];
        $sub_array[] = $row["client"];
        $sub_array[] = $row["idnumber_client"];
        $sub_array[] = $row["seller"];
        $sub_array[] = $row["payment_type"];
        $sub_array[] = $row["currency"]." ".$row["total"];
        
        $sub_array[] = '<button type="button" onClick="changeSaleStatus('.$row["id_sales"].',\''.$row["sale_number"].'\','.$row["status"].');" name="status" id="'.$row["id_sales"].'" class="'.$attrib.'">'.$stat.'</button>';
        $array[] = $sub_array;
      }

      $results = array(
      "sEcho"=>1, 
      "iTotalRecords"=>count($array),
      "iTotalDisplayRecords"=>count($array), 
      "aaData"=>$array);

      // print_r($results); exit();
      echo json_encode($results);
      break;

    case "see_detail_client_sale":

    $data= $sales->get_detail_client($_POST["sale_number"]);  
      if(is_array($data)==true and count($data)>0){
        foreach($data as $row){
          $output["client"] = $row["client"];
          $output["sale_number"] = $row["sale_number"];
          $output["idnumber_client"] = $row["idnumber_client"];
          $output["address"] = $row["address_client"];
          $output["sale_date"] = date("d-m-Y", strtotime($row["sale_date"]));
        }
        echo json_encode($output);
      } else {
          $errors[]="No data.";
      }

      if (isset($errors)){
        ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert">&timonth;</button>
            <strong>Error!</strong> 
            <?php
              foreach ($errors as $error) {
                  echo $error;
                }
              ?>
        </div>
        <?php
      }
      break;

    case "see_detail_sale":
      $data= $sales->get_detail_sales_client($_POST["sale_number"]); 
      break;

    case "search_quantity_sale":
      require_once("../models/Product.php");
      $product= new Product();


      $data=$product->get_product_by_id($_POST["id_product"]);
      
      // print_r($data); exit();

      if(is_array($data)==true and count($data)>0){
        foreach($data as $row){
          // $stock = $s["stock"] = $row["stock"];
          $stock = $row["stock"];
          $result = null;
          $sale_stock=$_POST["sale_quantity"];

          if($sale_stock>$stock and $sale_stock!=0){
            $result="<h4 class='text-danger'> The ammount selected is greater than the stock.</h4>";
          } else {
              if($sale_stock==0){
                $result="<h4 class='text-danger'>The field is empty.</h4>";
              }
          }
        }//cierre del foreach
        echo json_encode($result);
      } else {
            $errors[]="The product doesn't exist.";
      }

      if (isset($errors)){
        ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert">&timonth;</button>
            <strong>Error!</strong> 
            <?php
              foreach ($errors as $error) {
                  echo $error;
                }
              ?>
        </div>
        <?php
      }
      break;
      
    case "change_sale_status":
      $data=$sales->get_sales_by_id($_POST["id_sales"]);
      // print_r($data); exit();
      if(is_array($data)==true and count($data)>0){
        $sales->change_sale_status($_POST["id_sales"], $_POST["sale_number"], $_POST["status"]);
        } 
      break;

    case "search_sales_date":
      $data=$sales->list_search_registers_date($_POST["start_date"], $_POST["end_date"]);

      $array= Array();
      foreach($data as $row){
        $sub_array = array();
        $stat = '';
        $attrib = "btn btn-danger btn-md status";
        if($row["status"] == 1){
          $stat = 'PAYED';
          $attrib = "btn btn-success btn-md status";
        }
        else{
          if($row["status"] == 0){
            $stat = 'CANCELED';
           
          } 
        }
        
        $sub_array[] = '<button class="btn btn-warning detail" id="'.$row["sale_number"].'"  data-toggle="modal" data-target="#detail_sale"><i class="fa fa-eye"></i></button>';
        $sub_array[] = date("d-m-Y",strtotime($row["sale_date"]));
        $sub_array[] = $row["sale_number"];
        $sub_array[] = $row["client"];
        $sub_array[] = $row["idnumber_client"];
        $sub_array[] = $row["seller"];
        $sub_array[] = $row["payment_type"];
        $sub_array[] = $row["currency"]." ".$row["total"];

        $sub_array[] = '<button type="button" onClick="changeSaleStatus('.$row["id_sales"].',\''.$row["sale_number"].'\','.$row["status"].');" name="status" id="'.$row["id_sales"].'" class="'.$attrib.'">'.$stat.'</button>';
                
        $array[] = $sub_array;
      }

      $results = array(
      "sEcho"=>1, 
      "iTotalRecords"=>count($array), 
      "iTotalDisplayRecords"=>count($array), 
      "aaData"=>$array);
      echo json_encode($results);
      break;

    case "search_sales_date_month":
      $data= $sales->list_search_registers_date_month($_POST["month"],$_POST["year"]);
      $array= Array();
      foreach($data as $row){
        $sub_array = array();
        $stat = '';
         $attrib = "btn btn-danger btn-md status";
        if($row["status"] == 1){
          $stat = 'PAYED';
          $attrib = "btn btn-success btn-md status";
        }
        else{
          if($row["status"] == 0){
            $stat = 'CANCELED';
          } 
        }
         
        $sub_array[] = '<button class="btn btn-warning detail" id="'.$row["sale_number"].'"  data-toggle="modal" data-target="#detail_sale"><i class="fa fa-eye"></i></button>';
        $sub_array[] = date("d-m-Y", strtotime($row["sale_date"]));
        $sub_array[] = $row["sale_number"];
        $sub_array[] = $row["client"];
        $sub_array[] = $row["idnumber_client"];
        $sub_array[] = $row["seller"];
        $sub_array[] = $row["payment_type"];
        $sub_array[] = $row["total"];

        $sub_array[] = '<button type="button" onClick="changeSaleStatus('.$row["id_sales"].',\''.$row["sale_number"].'\','.$row["status"].');" name="status" id="'.$row["id_sales"].'" class="'.$attrib.'">'.$stat.'</button>';
                  
        $array[] = $sub_array;
      }

      $results = array(
      "sEcho"=>1, 
      "iTotalRecords"=>count($array), 
      "iTotalDisplayRecords"=>count($array),
      "aaData"=>$array);
      echo json_encode($results);
      break;

  }
?>  