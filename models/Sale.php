  
<?php

  require_once("../config/connection.php");

  class Sale extends Connect{
    public function get_sales(){
      $connect= parent::connection();
      $sql="select * from sales";
      $sql=$connect->prepare($sql);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_detail_client($sale_number){
      $connect=parent::connection();
      parent::set_names();
      $sql="select v.sale_date,v.sale_number, v.client, v.idnumber_client, v.total, c.id_client, c.idnumber_client, c.name_client, c.lastname_client, c.phone_client, c.email_client, c.address_client, c.start_date, c.status
        from sales as v, clients as c
        where 
          
        v.idnumber_client=c.idnumber_client
        and
        v.sale_number=?
          
        ;";
      //echo $sql; exit();
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$sale_number);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_detail_sales_client($sale_number){
      $connect=parent::connection();
      parent::set_names();

      $sql="select d.sale_number,d.idnumber_client,d.product, d.currency, d.sale_price, d.sale_quantity, d.discount, d.ammount, d.sale_date, v.sale_number, v.currency, v.subtotal, v.total_tax, v.total, c.id_client, c.idnumber_client, c.name_client, c.lastname_client, c.phone_client, c.email_client, c.address_client, c.start_date, c.status
        from sales_details as d, sales as v, clients as c
        where 
          
        d.sale_number = v.sale_number
        and 
        d.idnumber_client = c.idnumber_client
        and
        d.sale_number=?
      ;";
      //echo $sql; exit();

      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$sale_number);
      $sql->execute();
      $result=$sql->fetchAll(PDO::FETCH_ASSOC);
      $html= "
            <thead style='background-color:#A9D0F5'>
              <th>Quantity</th>
              <th>Product</th>
              <th>Saling Price</th>
              <th>Discount (%)</th>
              <th>Ammount</th>
            </thead>
            ";

      foreach($result as $row){
        $html.="<tr class='rows'><td>".$row['sale_quantity']."</td><td>".$row['product']."</td> <td>".$row["currency"]." ".$row['sale_price']."</td> <td>".$row['discount']."</td> <td>".$row["currency"]." ".$row['ammount']."</td></tr>";
        $subtotal= $row["currency"]." ".$row["subtotal"];
        $subtotal_tax= $row["currency"]." ".$row["total_tax"];
        $total= $row["currency"]." ".$row["total"];
      }

      $html .= "<tfoot>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>
                    <p>SUB-TOTAL</p>
                    <p>IVA(10%)</p>
                    <p class='margen_total'>TOTAL</p>
                  </th>
                  <th>
                    <p><strong>".$subtotal."</strong></p>
                    <p><strong>".$subtotal_tax."</strong></p>
                    <p><strong>".$total."</strong></p>
                  </th> 
                </tfoot>";
      echo $html;
    }

    public function sale_number(){
      $connect=parent::connection();
      parent::set_names();
   
      $sql="select sale_number from sales_details;";
      $sql=$connect->prepare($sql);
      $sql->execute();
      $result=$sql->fetchAll(PDO::FETCH_ASSOC);

      foreach($result as $k=>$v){
        $sale_number["number"]=$v["sale_number"];
      }

      if(empty($sale_number["number"])){ 
          echo 'F000001';
      }else{
          $num     = substr($sale_number["number"] , 1);
          $dig     = $num + 1;
          $fact = str_pad($dig, 6, "0", STR_PAD_LEFT);
          echo 'F'.$fact;
      } 
           //return $data;
    }

    public function add_details_sales(){
      $str = '';
      $details = array();

      // print_r($_POST); exit();

      $details = json_decode($_POST['arraySales']);

      // print_r($details); exit();
   
      $connect=parent::connection();

      foreach ($details as $k => $v) {
        //echo $v->codProd;
        $sale_quantity = $v->quantity;
        $id_product = $v->id_product;
        $product = $v->product;
        $currency = $v->currency;
        $sale_price = $v->price; 
        $discount = $v->discount;
        $ammount = $v->ammount;
        //$total = $v->total;
        $status = $v->status;

        $sale_number = $_POST["sale_number"];
        $idnumber_client = $_POST["idnumber"];
        $client = $_POST["name"];
        $client_lastname = $_POST["lastname"];
        $address = $_POST["address"];
        $total = $_POST["total"];
        $seller = $_POST["seller"];
        $payment_type = $_POST["payment_type"];
        $id_user = $_POST["id_user"];
        $id_client = $_POST["id_client"];

        // print_r($_POST); exit();

        $sql="insert into sales_details
        values(null,?,?,?,?,?,?,?,?,?,now(),?,?,?);";

        $sql=$connect->prepare($sql);
        //echo $sql;
        $sql->bindValue(1,$sale_number);
        $sql->bindValue(2,$idnumber_client);
        $sql->bindValue(3,$id_product);
        $sql->bindValue(4,$product);
        $sql->bindValue(5,$currency);
        $sql->bindValue(6,$sale_price);
        $sql->bindValue(7,$sale_quantity);
        $sql->bindValue(8,$discount);
        $sql->bindValue(9,$ammount);
        $sql->bindValue(10,$id_user);
        $sql->bindValue(11,$id_client);
        $sql->bindValue(12,$status);
       
        $sql->execute();

        $sql3="select * from product where id_product=?;";
         //echo $sql3;
        $sql3=$connect->prepare($sql3);

        $sql3->bindValue(1,$id_product);
        $sql3->execute();

        $result = $sql3->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $b=>$row){
          $re["existencia"] = $row["stock"];
        }

        $quantity_total = $row["stock"] - $sale_quantity;
              
        if(is_array($result)==true and count($result)>0) {
          $sql4 = "update product set 
                      stock=?
                      where 
                      id_product=?
                  ";

          $sql4 = $connect->prepare($sql4);
          $sql4->bindValue(1,$quantity_total);
          $sql4->bindValue(2,$id_product);
          $sql4->execute();
        } 
      }

      $sql5="select sum(ammount) as total from sales_details where sale_number=?";
      
      $sql5=$connect->prepare($sql5);
      $sql5->bindValue(1,$sale_number);
      $sql5->execute();
      $result2 = $sql5->fetchAll();
     
       foreach($result2 as $c=>$d){
        $row["total"]=$d["total"];
      }
      $subtotal=$d["total"];
        
      $tax= 10/100;
      $total_iv=$subtotal*$tax;
      $total_tax=round($total_iv);
      $tot=$subtotal+$total_tax;
      $total=round($tot);

      $sql2="insert into sales 
              values(null,now(),?,?,?,?,?,?,?,?,?,?,?,?);
            ";

      $sql2=$connect->prepare($sql2);
      
      $sql2->bindValue(1,$sale_number);
      $sql2->bindValue(2,$client);
      $sql2->bindValue(3,$idnumber_client);
      $sql2->bindValue(4,$seller);
      $sql2->bindValue(5,$currency);
      $sql2->bindValue(6,$subtotal);
      $sql2->bindValue(7,$total_tax);
      $sql2->bindValue(8,$total);
      $sql2->bindValue(9,$payment_type);
      $sql2->bindValue(10,$status);
      $sql2->bindValue(11,$id_user);
      $sql2->bindValue(12,$id_client);
      $sql2->execute();

    }

    public function get_sales_by_id($id_sales){
      $connect= parent::connection();
      $id_sales=$_POST["id_sales"];
      $sql="select * from sales where id_sales=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$id_sales);
      $sql->execute();
      // echo $sql ; exit();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function change_sale_status(){
      $connect=parent::connection();
      parent::set_names();
      $status = 0;
      if($_POST["status"] == 0){
        $status = 1;
        $sale_number=$_POST["sale_number"];
        $sql="update sales set 
              status=?
              where 
              id_sales=?
              ";
            // echo $sql; 

        $sql=$connect->prepare($sql);

        $sql->bindValue(1,$status);
        $sql->bindValue(2,$_POST["id_sales"]);
        $sql->execute();

        $result= $sql->fetch(PDO::FETCH_ASSOC);

        $sql_detail= "update sales_details set
                      status=?
                      where 
                      sale_number=?
                     ";

        $sql_detail=$connect->prepare($sql_detail);

        $sql_detail->bindValue(1,$status);
        $sql_detail->bindValue(2,$sale_number);
        $sql_detail->execute();

        $result= $sql_detail->fetch(PDO::FETCH_ASSOC);

        $sql2="select * from sales_details where sale_number=?";

        $sql2=$connect->prepare($sql2);
         
        $sql2->bindValue(1,$sale_number);
        $sql2->execute();

        $result=$sql2->fetchAll();

        foreach($result as $row){
          $id_product=$output["id_product"]=$row["id_product"];
          $sale_quantity=$output["sale_quantity"]=$row["sale_quantity"];
          if(isset($id_product)==true and count($id_product)>0){
            $sql3="select * from product where id_product=?";

            $sql3=$connect->prepare($sql3);

            $sql3->bindValue(1, $id_product);
            $sql3->execute();

            $result=$sql3->fetchAll();
            foreach($result as $row2){
              $stock=$output2["stock"]=$row2["stock"];
              $current_quantity= $stock - $sale_quantity;
            }
          }

          $sql6="update product set 
                 stock=?
                 where

                 id_product=?
                ";
           
          $sql6=$connect->prepare($sql6);   
           
          $sql6->bindValue(1,$current_quantity);
          $sql6->bindValue(2,$id_product);

          $sql6->execute();
        }
      } else {
          if($_POST["status"] == 1){
            $status = 0;
            $sale_number=$_POST["sale_number"];
      
            $sql="update sales set 
                  status=?
                  where 
                  id_sales=?
                ";
            // echo $sql; 
            $sql=$connect->prepare($sql);

            $sql->bindValue(1,$status);
            $sql->bindValue(2,$_POST["id_sales"]);
            $sql->execute();

            $result= $sql->fetch(PDO::FETCH_ASSOC);

            $sql_detail= "update sales_details set
                          status=?
                          where 
                          sale_number=?
                          ";

            $sql_detail=$connect->prepare($sql_detail);

            $sql_detail->bindValue(1,$status);
            $sql_detail->bindValue(2,$sale_number);
            $sql_detail->execute();

            $result= $sql_detail->fetch(PDO::FETCH_ASSOC);

            $sql2="select * from sales_details where sale_number=?";
            $sql2=$connect->prepare($sql2);
         
            $sql2->bindValue(1,$sale_number);
            $sql2->execute();

            $result=$sql2->fetchAll();
              foreach($result as $row){
                $id_product=$output["id_product"]=$row["id_product"];
                $sale_quantity=$output["sale_quantity"]=$row["sale_quantity"];
                if(isset($id_product)==true and count($id_product)>0){
                  $sql3="select * from product where id_product=?";
                  $sql3=$connect->prepare($sql3);
                  $sql3->bindValue(1, $id_product);
                  $sql3->execute();

                  $result=$sql3->fetchAll();
                    foreach($result as $row2){
                      $stock=$output2["stock"]=$row2["stock"];
                      $current_quantity= $stock + $sale_quantity;
                    }
                }

                $sql6="update product set 
                       stock=?
                       where

                       id_product=?
                       ";
               
                $sql6=$connect->prepare($sql6);   
               
                $sql6->bindValue(1,$current_quantity);
                $sql6->bindValue(2,$id_product);

                $sql6->execute();
              }
            }
      }
    }

    public function list_search_registers_date($start_date, $end_date){
      $connect= parent::connection();

      $start_date = $_POST["start_date"];
      $date = str_replace('/', '-', $start_date);
      $start_date = date("Y-m-d", strtotime($date));

      $end_date = $_POST["end_date"];
      $date = str_replace('/', '-', $end_date);
      $end_date = date("Y-m-d", strtotime($date));
   
      $sql= "SELECT * FROM sales WHERE sale_date>=? and sale_date<=? ";
      $sql = $connect->prepare($sql);
      $sql->bindValue(1,$start_date);
      $sql->bindValue(2,$end_date);
      $sql->execute();
      return $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function list_search_registers_date_month($month, $year){
      $connect= parent::connection();
      $month=$_POST["month"];
      $year=$_POST["year"];
      $date= ($year."-".$month."%");
          
      $sql= "SELECT * FROM sales WHERE sale_date like ? ";
      $sql = $connect->prepare($sql);
      $sql->bindValue(1,$date);
      $sql->execute();
      return $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_sales_by_id_client($id_client){
      $connect= parent::connection();
      $sql="select * from sales where id_client=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_client);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_detail_sales_by_id_client($id_client){
      $connect= parent::connection();
      $sql="select * from sales_details where id_client=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_client);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_sales_by_id_user($id_user){
      $connect= parent::connection();
      $sql="select * from sales where id_user=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_user);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_detail_sales_by_id_user($id_user){
      $connect= parent::connection();
      $sql="select * from sales_details where id_user=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1, $id_user);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }
  }