<?php

  require_once("../config/connection.php");
  require_once("../models/Client.php");

  $clients = new Client();

  // declare variables
  $id_user=isset($_POST["id_user"]);
  $idnumber_client=isset($_POST["idnumber_client"]);
  $idnumber = isset($_POST["idnumber"]);
  $name=isset($_POST["name"]);
  $lastname=isset($_POST["lastname"]);
  $phone=isset($_POST["phone"]);
  $email=isset($_POST["email"]);
  $address=isset($_POST["address"]);
  $status=isset($_POST["status"]);


  switch($_GET["op"]){
    case "saveandedit":
      // check if client exists
      $data = $clients->get_data_client($_POST["idnumber"],$_POST["name"],$_POST["email"]);

      if(empty($_POST["idnumber_client"])){
        if(is_array($data)==true and count($data)==0){

          $clients->register_client($idnumber,$name,$lastname,$phone,$email,$address,$status,$id_user);
          $messages[]="Client succesfully registered!";
        } 
          else {
              $errors[]="The Client exists already.";
        }
      }// end if empty
        else {
            $clients->edit_client($idnumber,$name,$lastname,$phone,$email,$address,$status,$id_user);
            $messages[]="Client succesfully edited!";
      }
      //mensaje success
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
      }// end success

      //message error
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
      $data=$clients->get_client_by_idnumber($_POST["idnumber_client"]);
      if(is_array($data)==true and count($data)>0){
        
        foreach($data as $row){
          $output["idnumber_client"] = $row["idnumber_client"];
          $output["name"] = $row["name_client"];
          $output["lastname"] = $row["lastname_client"];
          $output["phone"] = $row["phone_client"];
          $output["email"] = $row["email_client"];
          $output["address"] = $row["address_client"];
          $output["fecha"] = $row["start_date"];
          $output["status"] = $row["status"];
        }
        echo json_encode($output);
      } else {
          $errors[]="No Client found.";
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
      $data=$clients->get_client_by_id($_POST["id_client"]);
          echo $data;
        if(is_array($data)==true and count($data)>0){

          print_r($data);
          
          $clients->change_client_status($_POST["id_client"],$_POST["status"]);
          } 
      break;

    case "list":

      $data=$clients->get_clients();
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
      
        $sub_array[] = $row["idnumber_client"];
        $sub_array[] = $row["name_client"];
        $sub_array[] = $row["lastname_client"];
        $sub_array[] = $row["phone_client"];
        $sub_array[] = $row["email_client"];
        $sub_array[] = $row["address_client"];
        $sub_array[] = date("d-m-Y",strtotime($row["start_date"]));

        $sub_array[] = '<button type="button" onClick="changeClientStatus('.$row["id_client"].','.$row["status"].');" name="status" id="'.$row["id_client"].'" class="'.$attrib.'">'.$stat.'</button>';

        $sub_array[] = '<button type="button" onClick="showClient('.$row["idnumber_client"].');" id="'.$row["id_client"].'" class="btn btn-warning btn-md"><i class="glyphicon glyphicon-edit"></i> Edit</button>';
       

        $sub_array[] = '<button type="button" onClick="deleteClient('.$row["id_client"].');" id="'.$row["id_client"].'" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Delete</button>';
                
        $array[] = $sub_array;
      }

      $results = array(
      "sEcho"=>1, //Info for Datatables
      "iTotalRecords"=>count($array), //
      "iTotalDisplayRecords"=>count($array), 
      "aaData"=>$array);
      echo json_encode($results);

      break;
    
    case "list_in_sales":

      $data=$clients->get_clients();
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
        
        $sub_array[] = $row["idnumber_client"];
        $sub_array[] = $row["name_client"];
        $sub_array[] = $row["lastname_client"];
         
        $sub_array[] = '<button type="button"  name="status" id="'.$row["id_client"].'" class="'.$attrib.'">'.$stat.'</button>';

        $sub_array[] = '<button type="button" onClick="addclientRegister('.$row["id_client"].','.$row["status"].');" id="'.$row["id_client"].'" class="btn btn-primary btn-md"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>';
        
        $array[] = $sub_array;
      }

      $results = array(
      "sEcho"=>1, 
      "iTotalRecords"=>count($array), 
      "iTotalDisplayRecords"=>count($array),
      "aaData"=>$array);
      
      echo json_encode($results);
      break;

    case "search_client":

      $data=$clients->get_client_by_id_status($_POST["id_client"],$_POST["status"]);

      if(is_array($data)==true and count($data)>0){

        foreach($data as $row){
          $output["idnumber_client"] = $row["idnumber_client"];
          $output["name"] = $row["name_client"];
          $output["lastname"] = $row["lastname_client"];
          $output["address"] = $row["address_client"];
          $output["status"] = $row["status"];
        }
      } else {
        $output["error"]="The selected Client is inactive, try a different one";
      }
      echo json_encode($output);
      break;
   }
  
?>