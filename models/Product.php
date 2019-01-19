<?php
  
  require_once("../config/connection.php");

  class Product extends Connect{
    
    public function get_rows_products(){
      $connect= parent::connection();
      $sql="select * from product";
      $sql=$connect->prepare($sql);
      $sql->execute();
      $result= $sql->fetchAll(PDO::FETCH_ASSOC);
      return $sql->rowCount();
    }

    public function get_products(){
      $connect= parent::connection();
      $sql= "select 
              p.id_product, p.id_category, p.product, p.package, p.unit,p.currency, p.buying_price, p.sale_price, p.stock, p.status, p.image, p.expiration_date as expiration_date,c.id_category, c.category as category
              from product p 
              INNER JOIN category c ON p.id_category=c.id_category
             ";
      $sql=$connect->prepare($sql);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_products_in_sales(){
      $connect= parent::connection();
      $sql= "select p.id_product, p.id_category, p.product, p.package, p.unit, p.currency, p.buying_price, p.sale_price, p.stock, p.status, p.image, p.expiration_date as expiration_date, c.id_category, c.category as category
        from product p 
        INNER JOIN category c ON p.id_category=c.id_category
        where p.stock > 0 and p.status='1'
        ";
      $sql=$connect->prepare($sql);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /* route views/upload*/
    public function upload_image() {
      if(isset($_FILES["product_image"])){
        $extension = explode('.', $_FILES['product_image']['name']);
        $new_name = rand() . '.' . $extension[1];
        $destination = '../views/upload/' . $new_name;
        move_uploaded_file($_FILES['product_image']['tmp_name'], $destination);
        return $new_name;
      }
    }


    public function register_product($id_category,$product,$package,$unit,$currency,$buying_price,$sale_price,$stock,$status,$image,$id_user){
      $connect=parent::connection();
      parent::set_names();
      // stock empty -> 0 
      $stock = "";
      if($stock==""){
        $stocker=0;
      } else {
        $stocker = $_POST["stock"];
      }
      // call function upload_image()
      require_once("Product.php");
      $image_product = new Product();
      $image = '';
      if($_FILES["product_image"]["name"] != '')
      {
        $image = $image_product->upload_image();
      }

      // date 
      $date = $_POST["datepicker"];
      $date_start = str_replace('/', '-', $date);
      $date = date("Y-m-d",strtotime($date_start));


      $sql="insert into product
      values(null,?,?,?,?,?,?,?,?,?,?,?,?);";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $_POST["category"]);
      $sql->bindValue(2, $_POST["product"]);
      $sql->bindValue(3, $_POST["package"]);
      $sql->bindValue(4, $_POST["unit"]);
      $sql->bindValue(5, $_POST["currency"]);
      $sql->bindValue(6, $_POST["buying_price"]);
      $sql->bindValue(7, $_POST["sale_price"]);
      $sql->bindValue(8, $stocker);
      $sql->bindValue(9, $_POST["status"]);
      $sql->bindValue(10, $image);
      $sql->bindValue(11, $date);
      $sql->bindValue(12, $_POST["id_user"]);
      $sql->execute();
    }

    // called after editing
    public function get_product_by_id($id_product){
      $connect= parent::connection();
      //$output = array();
      $sql="select * from product where id_product=?";
      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $id_product);
      $sql->execute();

      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // checks if there are active registers
    public function get_product_by_id_status($id_product,$status){
      // called from ajax -> search_product case
      $connect= parent::connection();

      $status=1; // only active records

      $sql="select * from product where id_product=? and status=?";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $id_product);
      $sql->bindValue(2, $status);
      $sql->execute();

      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function edit_product($id_product,$id_category,$product,$package,$unit,$currency,$buying_price,$sale_price,$stock,$status,$image,$id_user){

      $connect=parent::connection();
      parent::set_names();

      // stock empty -> 0 

      $stock = "";
      if($stock==""){
        $stocker=0;
      } else {
        $stocker = $_POST["stock"];
      }

      // callfunction upload_image()
      require_once("Product.php");
      $image_product = new Product();
      $image = '';

      if($_FILES["product_image"]["name"] != ''){
        $image = $image_product->upload_image();
      }else{
        $image = $_POST["hidden_product_image"];
      }

      // date 
      $date = $_POST["datepicker"];

      $date_start = str_replace('/', '-', $date);
      $date = date("Y-m-d",strtotime($date_start));
              
      $sql="update product set 
             id_category=?,
             product=?,
             package=?,
             unit=?,
             currency=?,
             buying_price=?,
             sale_price=?,
             stock=?,
             status=?,
             image=?,
             expiration_date=?,
             id_user=?
             where 
             id_product=?
            ";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $_POST["category"]);
      $sql->bindValue(2, $_POST["product"]);
      $sql->bindValue(3, $_POST["package"]);
      $sql->bindValue(4, $_POST["unit"]);
      $sql->bindValue(5, $_POST["currency"]);
      $sql->bindValue(6, $_POST["buying_price"]);
      $sql->bindValue(7, $_POST["sale_price"]);
      $sql->bindValue(8, $stocker);
      $sql->bindValue(9, $_POST["status"]);
      $sql->bindValue(10, $image);
      $sql->bindValue(11, $date);
      $sql->bindValue(12, $_POST["id_user"]);
      $sql->bindValue(13, $_POST["id_product"]);
      $sql->execute();
    }

    public function change_product_status($id_product,$status){

      $connect=parent::connection();
      parent::set_names();
            
      $status = 0;
      if($_POST["status"] == 0){
        $status = 1;
      }

      $sql="update product set 
            status=?
            where 
            id_product=?
            ";
      $sql=$connect->prepare($sql);
                
      $sql->bindValue(1, $status);
      $sql->bindValue(2, $id_product);
      $sql->execute();
    }

    public function get_product_name($product){
      $connect=parent::connection();

      $sql= "select * from product where product=?";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $product);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function edit_status_by_category($id_category,$status){

      $connect=parent::connection();
      parent::set_names();
            
      $status = 0;
      // param sent through ajax
      if($_POST["status"] == 0){
        $status = 1;
      }

      $sql="update product set 
            status=?
            where 
            id_category=?
            ";

      $sql=$connect->prepare($sql);

      $sql->bindValue(1, $status);
      $sql->bindValue(2, $id_category);
      $sql->execute();
    }


    public function edit_status_by_product($id_category,$status){

      $connect=parent::connection();
      parent::set_names();

      if($_POST["status"] == 0){
        $sql="update category set 
              status=?
              where 
              id_category=?
              ";

        $sql=$connect->prepare($sql);

        $sql->bindValue(1, 1);
        $sql->bindValue(2, $id_category);
        $sql->execute();
       }
    }

    public function get_product_by_id_cat($id_category){
      $connect= parent::connection();
      $sql="select * from product where id_category=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_category);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_product_by_id_detail_purchase($id_product){
      $connect=parent::connection();
      parent::set_names();
      $sql="select p.id_product, p.product, c.id_product, c.product as product_purchases
            from product p 
            INNER JOIN purchases_details c ON p.id_product = c.id_product
              where p.id_product=?
            ";
       $sql=$connect->prepare($sql);
       $sql->bindValue(1,$id_product);
       $sql->execute();
       return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_product_by_id_detail_sale($id_product){
      $connect=parent::connection();
      parent::set_names();
      $sql="select p.id_product, p.product, v.id_product, v.product as product_sales
            from product p 
            INNER JOIN sales_details v ON p.id_product = v.id_product
            where p.id_product=?
            ";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$id_product);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete_product($id_product){
      $connect=parent::connection();
      $sql="delete from product where id_product=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_product);
      $sql->execute();
      return $result=$sql->fetch(PDO::FETCH_ASSOC);
    }
      
    public function get_product_by_id_user($id_user){
      $connect= parent::connection();
      $sql="select * from product where id_user=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_user);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }
  }
?>