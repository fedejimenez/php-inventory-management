<?php
  
  require_once("../config/connection.php");
  require_once("../models/Purchase.php");

  $purchases = new Purchase();

  switch($_GET["op"]){
    case "see_detail_supplier_purchase":
      $data= $purchases->get_detail_supplier($_POST["purchase_number"]);  

        if(is_array($data)==true and count($data)>0){

          foreach($data as $row){
            $output["supplier"] = $row["supplier"];
            $output["purchase_number"] = $row["purchase_number"];
            $output["idnumber_supplier"] = $row["idnumber_supplier"];
            $output["address"] = $row["address"];
            $output["purchase_date"] = date("d-m-Y", strtotime($row["purchase_date"]));
          }
          echo json_encode($output);
        } else {
              //si no existe el registro entonces no recorre el array
              $errors[]="No data found.";
        }
           
        // error monthasge
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

    case "see_detail_purchase":
      $data= $purchases->get_purchase_details_supplier($_POST["purchase_number"]);  
      break;
     
    case "search_purchases":

      $data=$purchases->get_purchases();
      $array= Array();

      foreach($data as $row){
        $sub_array = array();
        $stat = '';
        
         $atrib = "btn btn-danger btn-md status";
        if($row["status"] == 1){
          $stat = 'PAYED';
          $atrib = "btn btn-success btn-md status";
        }
        else{
          if($row["status"] == 0){
            $stat = 'CANCELED';
          } 
        }

        $sub_array[] = '<button class="btn btn-warning detail"  id="'.$row["purchase_number"].'"  data-toggle="modal" data-target="#purchase_detail"><i class="fa fa-eye"></i></button>';
        $sub_array[] = date("d-m-Y", strtotime($row["purchase_date"]));
        $sub_array[] = $row["purchase_number"];
        $sub_array[] = $row["supplier"];
        $sub_array[] = $row["idnumber_supplier"];
        $sub_array[] = $row["purchaser"];
        $sub_array[] = $row["payment_type"];
        $sub_array[] = $row["currency"]." ".$row["total"];

        $sub_array[] = '<button type="button" onClick="changePurchaseStatus('.$row["id_purchases"].',\''.$row["purchase_number"].'\','.$row["status"].');" name="status" id="'.$row["id_purchases"].'" class="'.$atrib.'">'.$stat.'</button>';
                
        $array[] = $sub_array;
      }

      $results = array(
      "sEcho"=>1, 
      "iTotalRecords"=>count($array), 
      "iTotalDisplayRecords"=>count($array), 
      "aaData"=>$array);
      echo json_encode($results);
      break;

    case "change_purchase_status":
      $data=$purchases->get_purchases_by_id($_POST["id_purchases"]);
        if(is_array($data)==true and count($data)>0){
          $purchases->change_purchase_status($_POST["id_purchases"], $_POST["purchase_number"], $_POST["status"]);
        } 
      break;

    case "search_purchases_date":
      $data=$purchases->list_search_registers_date($_POST["start_date"], $_POST["end_date"]);
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

        $sub_array[] = '<button class="btn btn-warning detail" id="'.$row["purchase_number"].'"  data-toggle="modal" data-target="#purchase_detail"><i class="fa fa-eye"></i></button>';

        $sub_array[] = date("d-m-Y", strtotime($row["purchase_date"]));
        $sub_array[] = $row["purchase_number"];
        $sub_array[] = $row["supplier"];
        $sub_array[] = $row["idnumber_supplier"];
        $sub_array[] = $row["purchaser"];
        $sub_array[] = $row["payment_type"];
        $sub_array[] = $row["currency"]." ".$row["total"];

        $sub_array[] = '<button type="button" onClick="changePurchaseStatus('.$row["id_purchases"].',\''.$row["purchase_number"].'\','.$row["status"].');" name="status" id="'.$row["id_purchases"].'" class="'.$attrib.'">'.$stat.'</button>';
                
        $array[] = $sub_array;
      }


      $results = array(
        "sEcho"=>1, 
        "iTotalRecords"=>count($array), 
        "iTotalDisplayRecords"=>count($array), 
        "aaData"=>$array
      );
      echo json_encode($results);

      break;

    case "search_purchases_date_month":
      
      $data= $purchases->list_search_registers_date_month($_POST["month"],$_POST["year"]);

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

        $sub_array[] = '<button class="btn btn-warning detail" id="'.$row["purchase_number"].'"  data-toggle="modal" data-target="#purchase_detail"><i class="fa fa-eye"></i></button>';
        
        $sub_array[] = date("d-m-Y", strtotime($row["purchase_date"]));

        $sub_array[] = $row["purchase_number"];
        $sub_array[] = $row["supplier"];
        $sub_array[] = $row["idnumber_supplier"];
        $sub_array[] = $row["purchaser"];
        $sub_array[] = $row["payment_type"];
        $sub_array[] = $row["currency"]." ".$row["total"];
        
        $sub_array[] = '<button type="button" onClick="changePurchaseStatus('.$row["id_purchases"].',\''.$row["purchase_number"].'\','.$row["status"].');" name="status" id="'.$row["id_purchases"].'" class="'.$attrib.'">'.$stat.'</button>';
                
        $array[] = $sub_array;
      }

      $results = array(
        "sEcho"=>1, 
        "iTotalRecords"=>count($array),
        "iTotalDisplayRecords"=>count($array), 
        "aaData"=>$array
      );
      echo json_encode($results);
      break;
  }

  ?>