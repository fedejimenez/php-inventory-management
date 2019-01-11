<?php  
  
  // call connection to DB
  require_once("../config/connection.php");

  // call profile model
  require_once("../models/Profile.php");

  $profile = new Profile();

  // declare variables (get values from POST request)

  $id_user_profile = isset($_POST["id_user_profile"]);
  $name_profile = isset($_POST["name_profile"]);
  $lastname_profile = isset($_POST["lastname_profile"]);
  $idnumber_profile = isset($_POST["idnumber_profile"]);
  $phone_profile = isset($_POST["phone_profile"]);
  $email_profile = isset($_POST["email_profile"]);
  $address_profile = isset($_POST["address_profile"]);
  $user_profile = isset($_POST["user_profile"]);
  $password_profile = isset($_POST["password_profile"]);
  $password2_profile = isset($_POST["password2_profile"]);

  switch ($_GET["op"]) {

    case 'show_profile':
      $data=$profile->get_user_by_id($_POST["id_user_profile"]);

      if (is_array($data)==true and count($data)>0) {
        foreach ($data as $row) {
          $output["idnumber"] = $row["idnumber"];
          $output["name"] = $row["name"];
          $output["lastname"] = $row["lastname"];

          $output["user_profile"] = $row["user"];
          $output["password"] = $row["password"];
          $output["password2"] = $row["password2"];
          $output["phone"] = $row["phone"];
          $output["email"] = $row["email"];
          $output["address"] = $row["address"];
        }

        echo json_encode($output);
      } else {
        $errors[] = "User doesn't exist.";
      }

      // show error message
      if (isset($errors)) {
        ?>
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button> 
            <strong>Error!</strong>
            <?php  
              foreach ($$errors as $error) {
                echo $error;
              }
            ?>
          </div>
        <?php
      }
      break;
    
    case 'edit_profile':
    // validation idnumber and email uniques
      $data = $profile->get_user_name($_POST["idnumber_profile"], $_POST["email_profile"]);

      // validation password matching
      if($_POST["password_profile"] == $_POST["password2_profile"]) {
        if(is_array($data)==true and count($data)>0){
          $profile->edit_profile($id_user_profile, $name_profile, $lastname_profile, $idnumber_profile, $phone_profile, $email_profile, $address_profile, $user_profile, $password_profile, $password2_profile);

          $messages[] = "User succsessfully updated!";
        }
      } else {
        $errors[] = "Passwords doesn't match.";
      }

      // custom success message
     if(isset($messages)){
        ?>
          <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Yay!</strong>
            <?php
              foreach($messages as $message) {
                  echo $message;
                }
              ?>
          </div>
        <?php
      }

      // custom error message
      if(isset($errors)){
        ?>
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Ooops!</strong> 
              <?php
                foreach($errors as $error) {
                    echo $error;
                  }
                ?>
          </div>
        <?php
      }

    break;
  }

?>