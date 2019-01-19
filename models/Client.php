<?php

  require_once("../config/connection.php");

  class Client extends Connect{

    public function get_clients(){
      $connect=parent::connection();
      parent::set_names();
      $sql="select * from clients";
      $sql=$connect->prepare($sql);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
     }


    public function register_client($idnumber,$name,$lastname,$phone,$email,$address,$status,$id_user){
      $connect= parent::connection();
      parent::set_names();
      $sql="insert into clients
      values(null,?,?,?,?,?,?,now(),?,?);";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $_POST["idnumber"]);
      $sql->bindValue(2, $_POST["name"]);
      $sql->bindValue(3, $_POST["lastname"]);
      $sql->bindValue(4, $_POST["phone"]);
      $sql->bindValue(5, $_POST["email"]);
      $sql->bindValue(6, $_POST["address"]);
      $sql->bindValue(7, $_POST["status"]);
      $sql->bindValue(8, $_POST["id_user"]);
      // print_r($_POST); exit();
      $sql->execute();
    }


    public function get_client_by_idnumber($idnumber){
      $connect= parent::connection();
      parent::set_names();
      $sql="select * from clients where idnumber_client=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $idnumber);
      $sql->execute();
      return $result=$sql->fetchAll();
    }

    public function get_client_by_id($id_client){
      $connect= parent::connection();
      //$output = array();
      $sql="select * from clients where id_client=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_client);
      $sql->execute();
      // echo $sql; exit();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

       
    public function edit_client($idnumber,$name,$lastname,$phone,$email,$address,$status,$id_user){
      $connect=parent::connection();
      parent::set_names();
      $sql="update clients set 
             idnumber_client=?,
             name_client=?,
             lastname_client=?,
             phone_client=?,
             email_client=?,
             address_client=?,
             status=?,
             id_user=?
             where 
             idnumber_client=?
            ";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $_POST["idnumber"]);
      $sql->bindValue(2, $_POST["name"]);
      $sql->bindValue(3, $_POST["lastname"]);
      $sql->bindValue(4, $_POST["phone"]);
      $sql->bindValue(5, $_POST["email"]);
      $sql->bindValue(6, $_POST["address"]);
      $sql->bindValue(7, $_POST["status"]);
      $sql->bindValue(8, $_POST["id_user"]);
      $sql->bindValue(9, $_POST["idnumber_client"]);
      // print_r($_POST); exit();
      $sql->execute();
    }

    public function get_client_by_id_status($id_client,$status){
      $connect= parent::connection();
      $status=1; // active clients
      $sql="select * from clients where id_client=? and status=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_client);
      $sql->bindValue(2, $status);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function change_client_status($id_client,$status){
       $connect=parent::connection();
       if($_POST["status"]=="0"){
         $status=1;
       } else {
         $status=0;
       }
       $sql="update clients set 
              status=?
              where 
              id_client=?
            ";
       $sql=$connect->prepare($sql);
       $sql->bindValue(1,$status);
       $sql->bindValue(2,$id_client);
       $sql->execute();
    }

    public function get_data_client($idnumber,$client,$email){
      $connect=parent::connection();
      $sql= "select * from clients where idnumber_client=? or name_client=? or email_client=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $idnumber);
      $sql->bindValue(2, $client);
      $sql->bindValue(3, $email);
      $sql->execute();
       //print_r($email); exit();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete_client($id_client){
      $connect=parent::connection();
      $sql="delete from clients where id_client=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_client);
      $sql->execute();
      return $result=$sql->fetch(PDO::FETCH_ASSOC);
    }

    public function get_client_by_id_user($id_user){
      $connect= parent::connection();
      $sql="select * from clients where id_user=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_user);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_client_by_idnumber_sales($idnumber_client){
      $connect=parent::connection();
      parent::set_names();
      $sql="select c.idnumber_client, v.idnumber_client
            from clients c 
            INNER JOIN sales v ON c.idnumber_client = v.idnumber_client
            where c.idnumber_client=?
            ";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$idnumber_client);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_client_by_idnumber_detaail_sales($idnumber_client){
      $connect=parent::connection();
      parent::set_names();
      $sql="select c.idnumber_client,d.idnumber_client
          from clients c 
          INNER JOIN sales_details d ON c.idnumber_client=d.idnumber_client
          where c.idnumber_client=?
          ";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$idnumber_client);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
   }
  }
?>