<?php  

  require_once("../config/connection.php");

  require_once("../models/Category.php");

  // require_once("../models/Product.php")


  // $products = new Product();
  $categories = new Category();

  // declare variables, attrib "name" from the form fields

  $id_category = isset($_POST["id_category"]);
  $id_user = isset($_POST["id_user"]);
  $category = isset($_POST["category"]);
  $status = isset($_POST["status"]);

  switch ($_GET["op"]) {
     case "saveandedit":

      // check if categor exists in the DB
      
      $data = $categories->get_category_name($_POST["category"]);

        if(empty($_POST["id_category"])){
          if(is_array($data)==true and count($data)==0){
            $categories->register_category($category,$status,$id_user);
              $messages[]="Category successfuly created!";
            } //close data validation 
              else {
                      $errors[]="The Category already exists";
                    }
        } // close if empty
          else {/*edit category if it exists*/
               $categories->edit_category($id_category,$category,$status,$id_user);
               $messages[]="Category successfuly edited!";
              }

     //message: success
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
   //end success

   // error message
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

   //end  error message
     break;

    case 'show':
      // select category id
      //param id_category is sent through AJAX from edit form
      $data=$categories->get_category_by_id($_POST["id_category"]);
      if(is_array($data)==true and count($data)>0){
        foreach($data as $row)
          {
            $output["category"] = $row["category"];
            $output["status"] = $row["status"];
            $output["id_user"] = $row["id_user"];
          }
          echo json_encode($output);
        } else {
          $errors[]="Category not found";
        }

      // error message
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
      // parameters sent through ajax
      $data=$categories->get_category_by_id($_POST["id_category"]);
      if(is_array($data)==true and count($data)>0){
        $categories->change_status($_POST["id_category"],$_POST["status"]);
      } 
      break;

    case "list":
      $data=$categories->get_categories();
      $array= Array();

     foreach($data as $row)
      {
        $sub_array = array();
        //STATUS
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

      $sub_array[] = $row["category"];

      $sub_array[] = '<button type="button" onClick="changeStatusCategory('.$row["id_category"].','.$row["status"].');" name="status" id="'.$row["id_category"].'" class="'.$attrib.'">'.$stat.'</button>';
                
      $sub_array[] = '<button type="button" onClick="showCategory('.$row["id_category"].');"  id="'.$row["id_category"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> Edit</button>';

      $sub_array[] = '<button type="button" onClick="delete('.$row["id_category"].');"  id="'.$row["id_category"].'" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Delete</button>';
      
      $array[] = $sub_array;

      }

      $results = array(
        "sEcho"=>1, //Info for Datatables
        "iTotalRecords"=>count($array), //send total 
        "iTotalDisplayRecords"=>count($array), 
        "aaData"=>$array
      );
    echo json_encode($results);
    break;
  }

?>