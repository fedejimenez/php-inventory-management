<?php
  require_once('../config/connection.php');
  require_once('../models/Company.php');

  $company= new Company();
  
  $id_user=isset($_POST["id_user_company"]);
  $name=isset($_POST["name_company"]);
  $idnumber=isset($_POST["idnumber_company"]);
  $phone=isset($_POST["phone_company"]);
  $email=isset($_POST["email_company"]);
  $address=isset($_POST["address_company"]);

  switch($_GET["op"]){
    case 'company':
      $data=$company->get_company_by_id_user($_POST["id_user_company"]);
      if(is_array($data)==true and count($data)>0){
        foreach($data as $row){
          $output["idnumber"] = $row["idnumber_company"];
          $output["name"] = $row["name_company"];
          $output["phone"] = $row["phone_company"];
          $output["email"] = $row["email_company"];
          $output["address"] = $row["address_company"];
        }
      } 
      echo json_encode($output);
      break;

    case 'edit_company':
      $data= $company->get_data_company($_POST["idnumber_company"],$_POST["name_company"],$_POST["email_company"]);
      if(is_array($data)==true and count($data)>0){
        $company->edit_company($_POST["id_user_company"],$_POST["name_company"],$_POST["idnumber_company"],$_POST["phone_company"],$_POST["email_company"],$_POST["address_company"]);

        $messages[]="Company successfuly edited!";
      }
        else {
          $errors[]="Company not found.";
      }
            
      if (isset($messages)){
          ?>
          <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Yay!</strong>
              <?php
                foreach ($messages as $message) {
                    echo $message;
                  }
                ?>
          </div>
          <?php
      }
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
      break;

    }
?>