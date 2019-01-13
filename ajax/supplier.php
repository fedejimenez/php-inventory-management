<?php

   //llamo a la connection de la base de data 
  require_once("../config/connection.php");
  //llamo al modelo suppliers
  require_once("../models/Supplier.php");

  
  $suppliers = new Supplier();


  //declare variables
  $id_user=isset($_POST["id_user"]);
  $idnumber_supplier=isset($_POST["idnumber_supplier"]);
  $idnumber = isset($_POST["idnumber"]);
  $supplier=isset($_POST["corporate_name"]);
  $phone=isset($_POST["phone"]);
  $email=isset($_POST["email"]);
  $address=isset($_POST["address"]);
  $status=isset($_POST["status"]);

  switch($_GET["op"]){

    case "saveandedit":

      // check if supplier exists
      
      $data = $suppliers->get_data_supplier($_POST["idnumber"],$_POST["corporate_name"],$_POST["email"]);

      if(empty($_POST["idnumber_supplier"])){
        if(is_array($data)==true and count($data)==0){

          $suppliers->register_supplier($idnumber,$supplier,$phone,$email,$address,$status,$id_user);

          $messages[]="Supplier successfully created!";

        } //end validation 
          else {
            $errors[]="Supplier already exists";
          }
      }// end if empty
        else {
            $suppliers->edit_supplier($idnumber,$supplier,$phone,$email,$address,$status,$id_user);
            $messages[]="Supplier successfully edited!";
      }
      
      //message success
      if (isset($messages)){
        ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" array-dismiss="alert">&times;</button>
            <strong>Yay!</strong>
            <?php
              foreach ($messages as $message) {
                  echo $message;
                }
              ?>
        </div>
        <?php
      }
      //end success

      // error message 
      if (isset($errors)){
      ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" array-dismiss="alert">&times;</button>
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
    
    $data=$suppliers->get_supplier_by_idnumber($_POST["idnumber_supplier"]);

    if(is_array($data)==true and count($data)>0){
      foreach($data as $row){
        $output["idnumber_supplier"] = $row["idnumber"];
        $output["supplier"] = $row["corporate_name"];
        $output["phone"] = $row["phone"];
        $output["email"] = $row["email"];
        $output["address"] = $row["address"];
        $output["date"] = $row["date"];
        $output["status"] = $row["status"];
      }

      echo json_encode($output);
    } else {
          $errors[]="Supplier doesn't exist";
    }

    // error message
    if(isset($errors)){
  
      ?>
      <div class="alert alert-danger" role="alert">
        <button type="button" class="close" array-dismiss="alert">&times;</button>
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

  case "changestatus":
     
    $data=$suppliers->get_supplier_by_id($_POST["id_supplier"]);
      
      if(is_array($data)==true and count($data)>0){
        $suppliers->change_status_supplier($_POST["id_supplier"],$_POST["status"]);
      } 
    break;

  case "list":

    $data=$suppliers->get_suppliers();
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
      
      
      $sub_array[] = $row["idnumber"];
      $sub_array[] = $row["corporate_name"];
      $sub_array[] = $row["phone"];
      $sub_array[] = $row["email"];
      $sub_array[] = $row["address"];
      $sub_array[] = date("d-m-Y", strtotime($row["date"]));

      $sub_array[] = '<button type="button" onClick="changeSupplierStatus('.$row["id_supplier"].','.$row["status"].');" name="status" id="'.$row["id_supplier"].'" class="'.$attrib.'">'.$stat.'</button>';

      $sub_array[] = '<button type="button" onClick="showSupplier('.$row["idnumber"].');" id="'.$row["id_supplier"].'" class="btn btn-warning btn-md"><i class="glyphicon glyphicon-edit"></i> Edit</button>';

      $sub_array[] = '<button type="button" onClick="deleteSupplier('.$row["id_supplier"].');" id="'.$row["id_supplier"].'" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Delete</button>';
                
      $array[] = $sub_array;
    }

    $results = array(
    "sEcho"=>1, 
    "iTotalRecords"=>count($array), 
    "iTotalDisplayRecords"=>count($array), 
    "aaData"=>$array);
    echo json_encode($results);
    break;
     
  case "list_in_purchases":
    $data=$suppliers->get_suppliers();
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
        
      $sub_array[] = $row["idnumber"];
      $sub_array[] = $row["corporate_name"];
      $sub_array[] = date("d-m-Y", strtotime($row["date"]));
         
      $sub_array[] = '<button type="button" name="status" id="'.$row["id_supplier"].'" class="'.$attrib.'">'.$stat.'</button>';
                

      $sub_array[] = '<button type="button" onClick="add_supplier_register('.$row["id_supplier"].','.$row["status"].');" id="'.$row["id_supplier"].'" class="btn btn-primary btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>';
                
      $array[] = $sub_array;
    }

    $results = array(
    "sEcho"=>1, 
    "iTotalRecords"=>count($array), 
    "iTotalDisplayRecords"=>count($array),
    "aaData"=>$array);
    echo json_encode($results);

    break;

  case "search_supplier";

    $data=$suppliers->get_supplier_by_id_status($_POST["id_supplier"],$_POST["status"]);

    if(is_array($data)==true and count($data)>0){

      foreach($data as $row){
        $output["idnumber"] = $row["idnumber"];
        $output["corporate_name"] = $row["corporate_name"];
        $output["address"] = $row["address"];
        $output["date"] = $row["date"];
        $output["status"] = $row["status"];
          
      }
    } else {
          $output["error"]="This Supplier is INACTIVE, try a different one";
    }
    echo json_encode($output);
    break;
  }

?>