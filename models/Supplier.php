<?php

  require_once("../config/connection.php");

  class Supplier extends Connect{

    public function get_suppliers(){
      $connect=parent::connection();
      parent::set_names();

      $sql="select * from supplier";

      $sql=$connect->prepare($sql);
      $sql->execute();

      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function register_supplier($idnumber,$supplier,$phone,$email,$address,$status,$id_user){

      $connect= parent::connection();
      parent::set_names();

      $sql="insert into supplier
      values(null,?,?,?,?,?,now(),?,?);";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $_POST["idnumber"]);
      $sql->bindValue(2, $_POST["corporate_name"]);
      $sql->bindValue(3, $_POST["phone"]);
      $sql->bindValue(4, $_POST["email"]);
      $sql->bindValue(5, $_POST["address"]);
      $sql->bindValue(6, $_POST["status"]);
      $sql->bindValue(7, $_POST["id_user"]);
      $sql->execute();
    }

    public function get_supplier_by_idnumber($idnumber){

      $connect= parent::connection();
      parent::set_names();

      $sql="select * from supplier where idnumber=?";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $idnumber);
      $sql->execute();
      return $result=$sql->fetchAll();
    }

    public function get_supplier_by_id($id_supplier){

      $connect= parent::connection();

      $sql="select * from supplier where id_supplier=?";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $id_supplier);
      $sql->execute();

      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

        
    public function get_supplier_by_id_status($id_supplier,$status){

      $connect= parent::connection();

      $status=1; // Active

      $sql="select * from supplier where id_supplier=? and status=?";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $id_supplier);
      $sql->bindValue(2, $status);
      $sql->execute();

      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    public function edit_supplier($idnumber,$supplier,$phone,$email,$address,$status,$id_user){

      $connect=parent::connection();
      parent::set_names();

      $sql="update supplier set 

         idnumber=?,
         corporate_name=?,
         phone=?,
         email=?,
         address=?,
         status=?,
         id_user=?
         where 
         idnumber=?

      ";
        
       //echo $sql; exit();

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $_POST["idnumber"]);
      $sql->bindValue(2, $_POST["corporate_name"]);
      $sql->bindValue(3, $_POST["phone"]);
      $sql->bindValue(4, $_POST["email"]);
      $sql->bindValue(5, $_POST["address"]);
      $sql->bindValue(6, $_POST["status"]);
      $sql->bindValue(7, $_POST["id_user"]);
      $sql->bindValue(8, $_POST["idnumber_supplier"]);
      $sql->execute();

    }


    // check if supplier exists
    public function get_data_supplier($idnumber,$supplier, $email){

      $connect=parent::connection();

      $sql="select * from supplier where idnumber=? or corporate_name=? or email=?";

      //echo $sql; exit();

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $idnumber);
      $sql->bindValue(2, $supplier);
      $sql->bindValue(3, $email);
      $sql->execute();

     //print_r($email); exit();

     return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }


    public function change_status_supplier($id_supplier,$status){

      $connect=parent::connection();

      if($_POST["status"]=="0"){
        $status=1; // active
      } else {
        $status=0; //inactive
      }

      $sql="update supplier set 
         
        status=?
        where 
        id_supplier=?

      ";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1,$status);
      $sql->bindValue(2,$id_supplier);
      $sql->execute();
    }
   
}


?>