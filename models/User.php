<?php 
  
  // connection to DB 
  // require_once("../config/connection.php");

  class User extends Connect {

    public function get_rows_users(){
      $connect= parent::connection();
      $sql="select * from users";
      $sql=$connect->prepare($sql);
      $sql->execute();
      $result= $sql->fetchAll(PDO::FETCH_ASSOC);
      return $sql->rowCount();
    }

    public function login(){
      $connect = parent::connection();
      parent::set_names();
      if(isset($_POST["send"])) {
        // validations
        $password = $_POST["password"];
        $email = $_POST["email"];
        $status = 1;
        if(empty($email) and empty($password)) {
          header("Location:".Connect::route()."index.php?m=2");
          exit();
        } else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/", $password)) {
          // login failed
          header("Location:".Connect::route()."index.php?m=1");
          exit();
        } else {
          // login successful
          $sql="select * from users where email=? and password=? and status=?";
          $sql=$connect->prepare($sql);
          $sql->bindValue(1, $email);  
          $sql->bindValue(2, $password);  
          $sql->bindValue(3, $status);  
          $sql->execute();
          $result=$sql->fetch();
          // If user exists and password matches, then create session
          if(is_array($result) and count($result)>0) {
            $_SESSION["id_user"] = $result["id_user"];
            $_SESSION["email"] = $result["email"];
            $_SESSION["idnumber"] = $result["idnumber"];
            $_SESSION["name"] = $result["name"];
            $_SESSION["lastname"] = $result["lastname"];
            $_SESSION["user"] = $result["user"];
            
            // access and go to home
            header("Location:".Connect::route()."views/home.php");
            exit();
          } else { // login failed, retry
            header("Location:".Connect::route()."index.php?m=1");
            exit();
          }
        } // close else
      } // close if send
    }

    // list users from DB
    public function get_users(){
      $connect = parent::connection();
      // set utf8
      parent::set_names();

      $sql="select * from users";


      $sql=$connect->prepare($sql);
      $sql->execute();

      return $result=$sql->fetchAll();
    }

    public function create_user($name, $lastname, $idnumber, $phone, $email, $address, $role, $user, $password, $password2, $status){

      $connect = parent::connection();
      parent::set_names();

      $sql="insert into users 
      values(null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?);";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $_POST["name"]);  
      $sql->bindValue(2, $_POST["lastname"]);  
      $sql->bindValue(3, $_POST["idnumber"]);  
      $sql->bindValue(4, $_POST["phone"]);  
      $sql->bindValue(5, $_POST["email"]);  
      $sql->bindValue(6, $_POST["address"]);  
      $sql->bindValue(7, $_POST["role"]);  
      $sql->bindValue(8, $_POST["user"]);  
      $sql->bindValue(9, $_POST["password"]);  
      $sql->bindValue(10, $_POST["password2"]);  
      $sql->bindValue(11, $_POST["status"]);  
      
      $sql->execute();

      // print_r($_POST);
    }   

    // edit user
    public function edit_user($id_user, $name, $lastname, $idnumber, $phone, $email, $address, $role, $user, $password, $password2, $status){
      
      $connect = parent::connection();
      parent::set_names();
      
      $sql="update users set
            name = ?,
            lastname = ?,
            idnumber = ?,
            phone = ?,
            email = ?,
            address = ?,
            role = ?,
            user = ?,
            password = ?,
            password2 = ?,
            status = ?
            
            where id_user = ?
           ";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $_POST["name"]);  
      $sql->bindValue(2, $_POST["lastname"]);  
      $sql->bindValue(3, $_POST["idnumber"]);  
      $sql->bindValue(4, $_POST["phone"]);  
      $sql->bindValue(5, $_POST["email"]);  
      $sql->bindValue(6, $_POST["address"]);  
      $sql->bindValue(7, $_POST["role"]);  
      $sql->bindValue(8, $_POST["user"]);  
      $sql->bindValue(9, $_POST["password"]);  
      $sql->bindValue(10, $_POST["password2"]);  
      $sql->bindValue(11, $_POST["status"]);  
      $sql->bindValue(12, $_POST["id_user"]);  
      
      $sql->execute();

      // print_r($_POST);
      
    }

    // get user details
    public function get_user_by_id($id_user){
      
      $connect = parent::connection();
      parent::set_names();

      $sql="select * from users where id_user=?";

      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_user);  
      $sql->execute();

      return $result=$sql->fetchAll(); 
    }

    // edit user state 
    public function change_status($id_user, $status){
      $connect = parent::connection();
      parent::set_names();

      // param status sent via ajax        
      if ($_POST["status"]=="0") {
        $status = 1;
      } else {
        $status = 0;
      }

      $sql="update users set status=? where id_user=? ";
      
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $status);  
      $sql->bindValue(2, $id_user);  
      $sql->execute();
    }

    // validate user id and email (unique)
    public function get_id_email_user($idnumber, $email){
      $connect = parent::connection();
      parent::set_names();
      
      $sql="select * from users where idnumber=? or email=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $idnumber);  
      $sql->bindValue(2, $email);  
      $sql->execute();

      return $result=$sql->fetchAll();
    }

    public function delete_user($id_user){
      $connect=parent::connection();
      $sql="delete from users where id_user=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$id_user);
      $sql->execute();
      return $result=$sql->fetch();
    }
 
    public function get_user_by_id_purchases($id_user){
      $connect=parent::connection();
      parent::set_names();
      $sql="select u.id_user,c.id_user
            from users u 
            INNER JOIN purchases c ON u.id_user=c.id_user
            where u.id_user=?
            ";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$id_user);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_user_by_id_sales($id_user){
      $connect=parent::connection();
      parent::set_names();
      $sql="select u.id_user,v.id_user
            from users u 
            INNER JOIN sales v ON u.id_user=v.id_user
            where u.id_user=?
            ";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$id_user);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
  } 

?>