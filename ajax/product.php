<?php

  require_once("../config/connection.php");
  require_once("../models/Product.php");

  $products = new Product();

  //declare variables, values from name attribute in form
   
  $id_product=isset($_POST["id_product"]);
  $id_category=isset($_POST["category"]);
  $id_user=isset($_POST["id_user"]);
  $product=isset($_POST["product"]);
  $package=isset($_POST["package"]);
  $unit=isset($_POST["unit"]);
  $currency=isset($_POST["currency"]);
  $buying_price=isset($_POST["buying_price"]);
  $sale_price=isset($_POST["sale_price"]);
  $stock = isset($_POST["stock"]);
  $status = isset($_POST["status"]);
  $image = isset($_POST["hidden_product_image"]);

  switch($_GET["op"]){

    case "saveandedit":
      // check if product existts
      $data = $products->get_product_name($_POST["product"]);
      
      if(empty($_POST["id_product"])){
        if(is_array($data)==true and count($data)==0){
          $products->register_product($id_category,$product,$package,$unit,$currency,$buying_price,$sale_price,$stock,$status,$image,$id_user);

          $messages[]="Product successfuly added!";

        } // close validation 
          else {
                  $errors[]="This product already exists";
                }
      }//end if empty
        else {
          $products->edit_product($id_product,$id_category,$product,$package,$unit,$currency,$buying_price,$sale_price,$stock,$status,$image,$id_user);

          $messages[]="Product successfuly edited!";
      }
      
      //message success
      if (isset($messages)){
        ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Yay!</strong>
            <?php
              foreach ($messages as $message) {
                  echo $message;
                }
              ?>
        </div>
        <?php
      }
      //end success

      //messahe error
      if (isset($errors)){
        ?>
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Error!</strong> 
              <?php
                foreach ($errors as $error) {
                    echo $error;
                  }
                ?>
          </div>
        <?php
      }

      //end error message
      break;

    case 'show':
      $data=$products->get_product_by_id($_POST["id_product"]);
      if(is_array($data)==true and count($data)>0){
        foreach($data as $row){
          $output["id_product"] = $row["id_product"];
          $output["category"] = $row["id_category"];
          $output["product"] = $row["product"];
          $output["package"] = $row["package"];
          $output["unit"] = $row["unit"];
          $output["currency"] = $row["currency"];
          $output["buying_price"] = $row["buying_price"];
          $output["sale_price"] = $row["sale_price"];
          $output["stock"] = $row["stock"];
          $output["status"] = $row["status"];

        if($row["image"] != ''){
          $output['product_image'] = '<img src="upload/'.$row["image"].'" class="img-thumbnail" width="300" height="50" /><input type="hidden" name="hidden_product_image" value="'.$row["image"].'" />';
        }else{
          $output['product_image'] = '<input type="hidden" name="hidden_product_image" value="" />';
        }

        $output["expiration_date"] = date("d-m-Y",strtotime($row["expiration_date"]));
      }
        echo json_encode($output);
      } else {
            $errors[]="This product doesn't exist";
      }

      //error message
      if(isset($errors)){
    
        ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong> 
            <?php
              foreach ($errors as $error) {
                  echo $error;
                }
              ?>
        </div>
        <?php
      }//end error message
      break;

    case "changestatus":
      $data=$products->get_product_by_id($_POST["id_product"]);
        if(is_array($data)==true and count($data)>0){
          $products->change_product_status($_POST["id_product"],$_POST["status"]);

          $products->edit_status_by_product($_POST["id_category"],$_POST["status"]);
        } 
      break;

    case "list":
      $data=$products->get_products();

      $array= Array();

      foreach($data as $row){
        $sub_array = array();
        $stat = '';
         $attrib = "btn btn-success btn-md status";
        if($row["status"] == 0){
          $stat = 'INACTIVE';
          $attrib = "btn btn-warning btn-md status";
        }
        else{
          if($row["status"] == 1){
            $stat = 'ACTIVE';
          } 
        }

        //STOCK, less than 5 will turn to red, else green
        $stock=""; 

        if($row["stock"]<=10){
          $stock = $row["stock"];
          $attribute = "badge bg-red-active";
        } else {
          $stock = $row["stock"];
          $attribute = "badge bg-green";
        }

        //currency
        $currency = $row["currency"];
          
        // $sub_array = array();
        $sub_array[] = $row["category"];
        $sub_array[] = $row["product"];
        $sub_array[] = $row["package"];
        $sub_array[] = $row["unit"];
        $sub_array[] = $currency." ".$row["buying_price"];
        $sub_array[] = $currency." ".$row["sale_price"];

        $sub_array[] = '<span class="'.$attribute.'">'.$row["stock"].'
                  </span>';

        $sub_array[] = '<button type="button" onClick="changeProductStatus('.$row["id_category"].','.$row["id_product"].','.$row["status"].');" name="status" id="'.$row["id_product"].'" class="'.$attrib.'">'.$stat.'</button>';

        $sub_array[] = '<button type="button" onClick="showProduct('.$row["id_product"].');" id="'.$row["id_product"].'" class="btn btn-warning btn-md"><i class="glyphicon glyphicon-edit"></i> Edit</button>';

          
        $sub_array[] = '<button type="button" onClick="deleteProduct('.$row["id_product"].');" id="'.$row["id_product"].'" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Delete</button>';

        $date= date("d-m-Y", strtotime($row["expiration_date"]));        
        
        if($row["image"] != ''){
          $sub_array[] = '
                  
                  <img src="upload/'.$row["image"].'" class="img-thumbnail" width="200" height="50" /><input type="hidden" name="hidden_product_image" value="'.$row["image"].'" />

                  <span><i class="fa fa-calendar" aria-hidden="true"></i>  '.$date.' <br/><strong>(expiration)</strong></span> 
              ';
        }else {
          $sub_array[] = '<button type="button" id="" class="btn btn-primary btn-md"><i class="fa fa-picture-o" aria-hidden="true"></i> No image</button>';
        }
                
        $array[] = $sub_array;


      }


      $results = array(
      "sEcho"=>1, //Info for datatables
      "iTotalRecords"=>count($array), 
      "iTotalDisplayRecords"=>count($array), 
      "aaData"=>$array
      );
      
      echo json_encode($results);
      break;
    
    case "list_in_purchases":
      $data=$products->get_products();
      $array= Array();

      foreach($data as $row){
        $sub_array = array();
        $stat = '';
        $attrib = "btn btn-success btn-md status";
        
        if($row["status"] == 0){
          $stat = 'INACTIVE';
          $attrib = "btn btn-warning btn-md status";
        }
        else{
          if($row["status"] == 1){
            $stat = 'ACTIVE';
          } 
        }

        // Red if less than 10 units
        $stock=""; 

        if($row["stock"]<=10){
          $stock = $row["stock"];
          $atribute = "badge bg-red-active";
        } else {
            $stock = $row["stock"];
            $atribute = "badge bg-green";
        }
                 
        $currency = $row["currency"];

        
        //$sub_array = array();
        $sub_array[] = $row["category"];
        $sub_array[] = $row["product"];
        $sub_array[] = $row["package"];
        $sub_array[] = $row["unit"];
        $sub_array[] = $currency." ".$row["buying_price"];
        $sub_array[] = $currency." ".$row["sale_price"];

        $sub_array[] = '<span class="'.$atribute.'">'.$row["stock"].'
                  </span>';

        $sub_array[] = '<button type="button"  name="status" id="'.$row["id_product"].'" class="'.$attrib.'">'.$stat.'</button>';
          
        $date= date("d-m-Y", strtotime($row["expiration_date"]));       
        if($row["image"] != ''){
            $sub_array[] = '<img src="upload/'.$row["image"].'" class="img-thumbnail" width="100" height="100" /><input type="hidden" name="hidden_product_image" value="'.$row["image"].'" />
              <span><i class="fa fa-calendar" aria-hidden="true"></i>  '.$date.' <br/><strong>(expiration)</strong></span> 
            ';
        }
          else{
            $sub_array[] = '<button type="button" id="" class="btn btn-primary btn-md"><i class="fa fa-picture-o" aria-hidden="true"></i> No image</button>';
        }

        $sub_array[] = '<button type="button" name="" id="'.$row["id_product"].'" class="btn btn-primary btn-md " onClick="addDetails('.$row["id_product"].',\''.$row["product"].'\','.$row["status"].')"><i class="fa fa-plus"></i> Add</button>';
                
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

    case "search_product";
      // returns product details in purchases section    
      $data=$products->get_product_by_id_status($_POST["id_product"], $_POST["status"]);

      // check if product is active
      if(is_array($data)==true and count($data)>0){
        foreach($data as $row){
          $output["id_product"] = $row["id_product"];
          $output["id_category"] = $row["id_category"];
          $output["product"] = $row["product"];
          $output["currency"] = $row["currency"];
          $output["buying_price"] = $row["buying_price"];
          $output["stock"] = $row["stock"];
          $output["status"] = $row["status"];
        }
              //echo json_encode($output);
          } else {
                 $output["error"]="This product is inactive, try aother one.";
          }
          echo json_encode($output);
      break;

    case "register_purchase";

      require_once('../models/Purchase.php');

      $purchase = new Purchase();
      $purchase->add_purchase_details();

      break; 
    

    /****************    SALES      *******************************/

    case "list_in_sales":

      $data=$products->get_products_in_sales();

      $array= Array();

      foreach($data as $row){
        $sub_array = array();
        $stat = '';
         $attrib = "btn btn-success btn-md status";
        if($row["status"] == 0){
          $stat = 'INACTIVE';
          $attrib = "btn btn-warning btn-md status";
        }
        else{
          if($row["status"] == 1){
            $stat = 'ACTIVE';
          } 
        }
        $stock=""; 
        
        if($row["stock"]<=10){
                $stock = $row["stock"];
                $attribute = "badge bg-red-active";
        } else {
            $stock = $row["stock"];
            $attribute = "badge bg-green";
        }

        $currency = $row["currency"];
        $sub_array[] = $row["category"];
        $sub_array[] = $row["product"];
        $sub_array[] = $row["package"];
        $sub_array[] = $row["unit"];
        $sub_array[] = $currency." ".$row["buying_price"];
        $sub_array[] = $currency." ".$row["sale_price"];

        $sub_array[] = '<span class="'.$attribute.'">'.$row["stock"].'
                  </span>';

        $sub_array[] = '<button type="button" onClick="changeSalesStatus('.$row["id_product"].','.$row["status"].');" name="status" id="'.$row["id_product"].'" class="'.$attrib.'">'.$stat.'</button>';

        $date= date("d-m-Y", strtotime($row["expiration_date"]));       


        if($row["image"] != ''){
            $sub_array[] = '<img src="upload/'.$row["image"].'" class="img-thumbnail" width="100" height="100" /><input type="hidden" name="hidden_product_image" value="'.$row["image"].'" /><span><i class="fa fa-calendar" aria-hidden="true"></i>  '.$date.' <br/><strong>(expiration)</strong></span> 
                            ';
        }
          else{
          $sub_array[] = '<button type="button" id="" class="btn btn-primary btn-md"><i class="fa fa-picture-o" aria-hidden="true"></i> Sin image</button>';
        }

        $sub_array[] = '<button type="button" name="" id="'.$row["id_product"].'" class="btn btn-primary btn-md " onClick="addDetailsSales('.$row["id_product"].',\''.$row["product"].'\','.$row["status"].')"><i class="fa fa-plus"></i> Add</button>';

        $array[] = $sub_array;

      }


      $results = array(
      "sEcho"=>1, 
      "iTotalRecords"=>count($array), 
      "iTotalDisplayRecords"=>count($array), 
      "aaData"=>$array);
      echo json_encode($results);
      break;

    case "search_product_in_sales":
          
      $data=$products->get_product_by_id_status($_POST["id_product"], $_POST["status"]);
      if(is_array($data)==true and count($data)>0){

        foreach($data as $row){
          $output["id_product"] = $row["id_product"];
          $output["product"] = $row["product"];
          $output["currency"] = $row["currency"];
          $output["sale_price"] = $row["sale_price"];
          $output["stock"] = $row["stock"];
          $output["status"] = $row["status"];
        }
      } else {
          $output["error"]="The selected product is inactive, please select another one.";
      }
      echo json_encode($output);
      break;

    case "register_sale";
      require_once('../models/Sale.php');
      $sale = new Sale();

      $sale->add_details_sales();
      break;
  }

?> 