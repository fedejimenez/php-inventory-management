<?php
  require_once("../config/connection.php");
    
  class Company extends Connect{
       
    public function get_company(){
      $connect=parent::connection();
      parent::set_names();
      $sql="select * from company;";
      $sql=$connect->prepare($sql);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_company_by_id_user($id_user_company){
      $connect= parent::connection();
      $sql="select * from company where id_user_company=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_user_company);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_data_company($idnumber,$client, $email){
      $connect=parent::connection();
      $sql= "select * from company where idnumber_company=? or name_company=? or email_company=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $idnumber);
      $sql->bindValue(2, $client);
      $sql->bindValue(3, $email);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function edit_company($id_user_company,$name,$idnumber,$phone,$email,$address){
      $connect=parent::connection();
      $sql="update company set 
            idnumber_company=?,
            name_company=?,
            address_company=?,
            email_company=?,
            phone_company=?
            where 
            id_user=?
            ";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$_POST["idnumber_company"]);
      $sql->bindValue(2,$_POST["name_company"]);
      $sql->bindValue(3,$_POST["address_company"]);
      $sql->bindValue(4,$_POST["email_company"]);
      $sql->bindValue(5,$_POST["phone_company"]);
      $sql->bindValue(6,$_POST["id_user_company"]);
      $sql->execute();
      $result=$sql->fetch(PDO::FETCH_ASSOC);
    }
  }

?>