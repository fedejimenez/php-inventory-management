<?php  

  require_once("../config/connection.php");

  class Category extends Connect{
    
    public function get_categories(){
      $connect=parent::connection();
      parent::set_names();
      $sql="select * from category";
      // echo $sql; exit();
      $sql=$connect->prepare($sql);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_category_by_id($id_category){
      $connect=parent::connection();  
      parent::set_names();
      $sql="select * from category where id_category=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_category);
      $sql->execute();
      return $result=$sql->fetchAll();
    }

    // insert values into category 
    public function register_category($category, $status, $id_user){
      $connect=parent::connection();  
      parent::set_names();
      $sql="insert into category values(null, ?, ?, ?);";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $_POST["category"]);
      $sql->bindValue(2, $_POST["status"]);
      $sql->bindValue(3, $_POST["id_user"]);
      $sql->execute();
    }

    public function edit_category($id_category, $category, $status, $id_user){
      $connect=parent::connection();
      parent::set_names();
      $sql="update category set
            category=?,
            status=?,
            id_user=?
            where 
            id_category=?
           ";
      // echo $sql; exit();
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $_POST["category"]);
      $sql->bindValue(2, $_POST["status"]);
      $sql->bindValue(3, $_POST["id_user"]);
      $sql->bindValue(4, $_POST["id_category"]);
      $sql->execute();
      // print_r($sql)
    }

    public function change_status($id_category, $status){
       $connect=parent::connection();
        // param sent through ajax
        if ($_POST["status"]=="0") {
          $status = 1;
        } else {
          $status = 0;
        }
        $sql ="update category set
               status=?
               where 
               id_category=? 
              ";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $status);
      $sql->bindValue(2, $id_category);
      $sql->execute();
    }

    // check if category exists
    public function get_category_name($category){
      $connect=parent::connection();
      $sql="select * from category where category=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $category);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete_category($id_category){
       $connect=parent::connection();
       $sql="delete from category where id_category=?";
       $sql=$connect->prepare($sql);
       $sql->bindValue(1,$id_category);
       $sql->execute();
       return $result=$sql->fetch();
    }

    public function get_category_by_id_user($id_user){
      $connect= parent::connection();
       $sql="select * from category where id_user=?";
          $sql=$connect->prepare($sql);
          $sql->bindValue(1, $id_user);
          $sql->execute();
          return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_category_by_id_purchases($id_category){
      $connect=parent::connection();
      parent::set_names();
      $sql="select c.id_categoy, comp.id_category
           from category c 
            INNER JOIN purchases comp ON c.id_category = comp.id_category
            where c.id_category=?
            ";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$id_category);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_category_by_id_detail_purchases($id_category){
      $connect=parent::connection();
      parent::set_names();
      $sql="select c.id_category, d.id_category
            from category c 
            INNER JOIN purchases_details d ON c.id_category = d.id_category
            where c.id_category=?
            ";
           $sql=$connect->prepare($sql);
           $sql->bindValue(1,$id_category);
           $sql->execute();
           return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
     }
  }

?>