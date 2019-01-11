<?php  

  require_once("../config/connection.php");

  /**
   * 
   */
  class Profile extends Connect{
    
    // show data from register
    public function get_user_by_id($id_user){
      $connect = parent::connection();
      parent::set_names();

      $sql="select * from users where id_user=?";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $id_user);
      $sql->execute();

      return $result=$sql->fetchAll();
    }

    public function get_user_name($idnumber, $email){
      $connect = parent::connection();
      parent::set_names();

      $sql="select * from users where idnumber=? or email=?";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $idnumber);
      $sql->bindValue(2, $email);
      $sql->execute();

      // print_r($idnumber); exit();

      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function edit_profile($id_user_profile, $name_profile, $lastname_profile, $idnumber_profile, $phone_profile, $email_profile, $address_profile, $user_profile, $password_profile, $password2_profile){

      $connect = parent::connection();
      parent::set_names();

      $sql="update users set 
            name=?, 
            lastname=?, 
            idnumber=?, 
            phone=?, 
            email=?, 
            address=?, 
            user=?, 
            password=?, 
            password2=?

            where
            id_user=?
            ";

      //  echo $sql;

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $_POST["name_profile"]);
      $sql->bindValue(2, $_POST["lastname_profile"]);
      $sql->bindValue(3, $_POST["idnumber_profile"]);
      $sql->bindValue(4, $_POST["phone_profile"]);
      $sql->bindValue(5, $_POST["email_profile"]);
      $sql->bindValue(6, $_POST["address_profile"]);
      $sql->bindValue(7, $_POST["user_profile"]);
      $sql->bindValue(8, $_POST["password_profile"]);
      $sql->bindValue(9, $_POST["password2_profile"]);
      
      $sql->bindValue(10, $_POST["id_user_profile"]); //hidden field
      $sql->execute();

    }
  
   }

?>