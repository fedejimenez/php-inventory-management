<?php
  require_once("../config/connection.php");
      
  class Purchase extends Connect{
    public function get_purchases(){

      $connect= parent::connection();
      $sql="select * from purchases";
      $sql=$connect->prepare($sql);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_purchases_by_id($id_purchases){

      $connect= parent::connection();
      $sql="select * from purchases where id_purchases=?";
      $sql=$connect->prepare($sql);
      $sql->bindValue(1,$id_purchases);
      $sql->execute();
      return $result= $sql->fetchAll(PDO::FETCH_ASSOC);
    }
             
    public function purchase_number(){

      $connect=parent::connection();
      parent::set_namonth();
        
      $sql="select purchase_number from purchases_details;";
      $sql=$connect->prepare($sql);

      $sql->execute();
      $result=$sql->fetchAll(PDO::FETCH_ASSOC);

      foreach($result as $k=>$v){
        $purchase_number["number"]=$v["purchase_number"];
      }

      if(empty($purchase_number["number"])){
        echo 'F000001';
      }else{
        $num     = substr($purchase_number["number"] , 1);
        $dig     = $num + 1;
        $fact = str_pad($dig, 6, "0", STR_PAD_LEFT);
        echo 'F'.$fact;
      } 
    }

    public function add_purchase_detail(){
      //echo json_encode($_POST['arrayPurchase']);
      $str = '';
      $details = array();
      $details = json_decode($_POST['arrayPurchase']);
   
      $connect=parent::connection();

      foreach ($details as $k => $v) {
        // variables from array details  
        $quantity = $v->quantity;
        $codProd = $v->codProd;
        $codCat = $v->codCat;
        $product = $v->product;
        $currency = $v->currency;
        $price = $v->price; 
        $discount = $v->discount;
        $ammount = $v->ammount;
        //$total = $v->total;
        $status = $v->status;

        //echo "***************";
        //echo "Cant: ".$quantity." codProd: ".$codProd. " Producto: ". $product. " currency: ".$currency. " price: ".$price. " discount: ".$discount. " status: ".$status;

       $purchase_number = $_POST["purchase_number"];
       $idnumber_supplier = $_POST["idnumber"];
       $supplier = $_POST["corporate_name"];
       $address = $_POST["address"];
       $total = $_POST["total"];
       $purchaser = $_POST["purchaser"];
       $payment_type = $_POST["payment_type"];
       $id_user = $_POST["id_user"];
       $id_supplier = $_POST["id_supplier"];

        /*$sql="insert into detalle_compra
        values(null,'".$purchase_number."','".$product."','".$price."','".$quantity."','".$discount."','".$idnumber_supplier."','".$purchase_date."','".$status."');";

        echo $sql;*/

        $sql="insert into purchases_details
        values(null,?,?,?,?,?,?,?,?,?,now(),?,?,?,?);";

        $sql=$connect->prepare($sql);

        //echo $sql;

        $sql->bindValue(1,$purchase_number);
        $sql->bindValue(2,$idnumber_supplier);
        $sql->bindValue(3,$codProd);
        $sql->bindValue(4,$product);
        $sql->bindValue(5,$currency);
        $sql->bindValue(6,$price);
        $sql->bindValue(7,$quantity);
        $sql->bindValue(8,$discount);
        $sql->bindValue(9,$ammount);
        $sql->bindValue(10,$id_user);
        $sql->bindValue(11,$id_supplier);
        $sql->bindValue(12,$status);
        $sql->bindValue(13,$codCat);
       
        $sql->execute();

        //print_r($_POST);

        // if product exists, update quantity

        $sql3="select * from product where id_product=?;";

        //echo $sql3;
       
        $sql3=$connect->prepare($sql3);

        $sql3->bindValue(1,$codProd);
        $sql3->execute();

        $result = $sql3->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $b=>$row){
          $re["existencia"] = $row["stock"];
        }

        $quantity_total = $quantity + $row["stock"];

        // udate stock
        if(is_array($result)==true and count($result)>0) {
                     
          $sql4 = "update product set 
                      stock=?
                      where 
                      id_product=?
                 ";
          $sql4 = $connect->prepare($sql4);
          $sql4->bindValue(1,$quantity_total);
          $sql4->bindValue(2,$codProd);
          $sql4->execute();

        } 
      }//end foreach

      //  CALCULATE TOTAL

      $sql5="select sum(ammount) as total from purchases_details where purchase_number=?";
      
      $sql5=$connect->prepare($sql5);
      $sql5->bindValue(1,$purchase_number);
      $sql5->execute();
      $result2 = $sql5->fetchAll();
        foreach($result2 as $c=>$d){
          $row["total"]=$d["total"];
        }
        $subtotal=$d["total"];

      $tax= 20/100;
      $total_iv=$subtotal*$tax;
      $total_tax=round($total_iv);
      $tot=$subtotal+$total_tax;
      $total=round($tot);

      $sql2="insert into purchases 
           values(null,now(),?,?,?,?,?,?,?,?,?,?,?,?);";

      $sql2=$connect->prepare($sql2);
  
      $sql2->bindValue(1,$purchase_number);
      $sql2->bindValue(2,$supplier);
      $sql2->bindValue(3,$idnumber_supplier);
      $sql2->bindValue(4,$purchaser);
      $sql2->bindValue(5,$currency);
      $sql2->bindValue(6,$subtotal);
      $sql2->bindValue(7,$total_tax);
      $sql2->bindValue(8,$total);
      $sql2->bindValue(9,$payment_type);
      $sql2->bindValue(10,$status);
      $sql2->bindValue(11,$id_user);
      $sql2->bindValue(12,$id_supplier);
      
      $sql2->execute();
    }

    public function get_supplier_detail($purchase_number){

      $connect=parent::connection();
      parent::set_namonth();

      $sql="select c.purchase_date,c.purchase_number, c.supplier,  c.idnumber_supplier,c.total,p.id_supplier,p.idnumber,p.corporate_name,p.phone,p.email,p.address,p.date,p.status
        from purchases as c, supplier as p
        where 
        
        c.idnumber_supplier=p.idnumber
        and
        c.purchase_number=?
        
        ;";
      //echo $sql; exit();

      $sql=$connect->prepare($sql);

      $sql->bindValue(1,$purchase_number);
      $sql->execute();
      return $result=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_purchases_details_supplier($purchase_number){

      $connect=parent::connection();
      parent::set_namonth();

      $sql="select d.purchase_number,d.idnumber_supplier,d.product, d.currency, d.buying_price, d.purchase_quantity, d.discount, d.ammount, d.purchase_date, c.purchase_number, c.currency, c.subtotal, c.total_tax, c.total, p.id_supplier, p.idnumber, p.corporate_name, p.phone, p.email, p.address, p.date, p.status
          from purchases_details as d, purchases as c, supplier as p
          where 
          
          d.purchase_number=c.purchase_number
          and 
          d.idnumber_supplier=p.idnumber
          and
          d.purchase_number=?
          ;";

      //echo $sql; exit();

      $sql=$connect->prepare($sql);

      $sql->bindValue(1,$purchase_number);
      $sql->execute();
      $result=$sql->fetchAll(PDO::FETCH_ASSOC);

      $html= "
              <thead style='background-color:#A9D0F5'>
                <th>Quantity</th>
                <th>Product</th>
                <th>Buying Price</th>
                <th>Discount (%)</th>
                <th>Ammount</th>
              </thead>
            ";
      
      foreach($result as $row){
        $html.="<tr class='filas'><td>".$row['purchase_quantity']."</td><td>".$row['product']."</td> <td>".$row["currency"]." ".$row['buying_price']."</td> <td>".$row['discount']."</td> <td>".$row["currency"]." ".$row['ammount']."</td></tr>";
                   
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
                    <p>TAX(20%)</p>
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

    public function change_purchase_status($id_purchases, $purchase_number, $status){

      $connect=parent::connection();
      parent::set_namonth();
            
      $status = 0;
      
      if($_POST["status"] == 0){
        $status = 1;
        $purchase_number=$_POST["purchase_number"];
      
        $sql="update purchases set 
              status=?
              where 
              id_purchases=?
              ";

        // echo $sql; 

        $sql=$connect->prepare($sql);

        $sql->bindValue(1,$status);
        $sql->bindValue(2,$_POST["id_purchases"]);
        $sql->execute();

        $result= $sql->fetch(PDO::FETCH_ASSOC);

        $sql_detail= "update purchases_details set
                      status=?
                      where 
                      purchase_number=?
                      ";

        $sql_detail=$connect->prepare($sql_detail);

        $sql_detail->bindValue(1,$status);
        $sql_detail->bindValue(2,$purchase_number);
        $sql_detail->execute();

        $result= $sql_detail->fetch(PDO::FETCH_ASSOC);


        // PURCHASE DETAILS

        $sql2="select * from purchases_details where purchase_number=?";
        $sql2=$connect->prepare($sql2);
         
        $sql2->bindValue(1,$purchase_number);
        $sql2->execute();

        $result=$sql2->fetchAll();

        foreach($result as $row){
          $id_product=$output["id_product"]=$row["id_product"];
          $purchase_quantity=$output["purchase_quantity"]=$row["purchase_quantity"];
                
        if(isset($id_product)==true and count($id_product)>0){
            
            $sql3="select * from product where id_product=?";

            $sql3=$connect->prepare($sql3);

            $sql3->bindValue(1, $id_product);
            $sql3->execute();

            $result=$sql3->fetchAll();

            foreach($result as $row2){
              $stock=$output2["stock"]=$row2["stock"];
              $quantity_current= $stock + $purchase_quantity;
           }
        }

        $sql6="update product set 
                stock=?
                where
                id_product=?
              ";
         
         $sql6=$connect->prepare($sql6);   
         
         $sql6->bindValue(1,$quantity_current);
         $sql6->bindValue(2,$id_product);

         $sql6->execute();
        }//end foreach
      }//end if status
        else {
          if($_POST["status"] == 1){
            $status = 0;
            $purchase_number=$_POST["purchase_number"];
            $sql="update purchases set 
                  status=?
                  where 
                  id_purchases=?
                  ";
            // echo $sql; 
            $sql=$connect->prepare($sql);
            $sql->bindValue(1,$status);
            $sql->bindValue(2,$_POST["id_purchases"]);
            $sql->execute();
            $result= $sql->fetch(PDO::FETCH_ASSOC);

            $sql_detail= "update purchases_details set
                          status=?
                          where 
                          purchase_number=?
                          ";

            $sql_detail=$connect->prepare($sql_detail);

            $sql_detail->bindValue(1,$status);
            $sql_detail->bindValue(2,$purchase_number);
            $sql_detail->execute();

            $result= $sql_detail->fetch(PDO::FETCH_ASSOC);

            $sql2="select * from purchases_details where purchase_number=?";

            $sql2=$connect->prepare($sql2);

            $sql2->bindValue(1,$purchase_number);
            $sql2->execute();

            $result=$sql2->fetchAll();

            foreach($result as $row){
              $id_product=$output["id_product"]=$row["id_product"];
              $purchase_quantity=$output["purchase_quantity"]=$row["purchase_quantity"];
                
                if(isset($id_product)==true and count($id_product)>0){
                  $sql3="select * from product where id_product=?";
                  $sql3=$connect->prepare($sql3);

                  $sql3->bindValue(1, $id_product);
                  $sql3->execute();

                  $result=$sql3->fetchAll();

                  foreach($result as $row2){
                    $stock=$output2["stock"]=$row2["stock"];
                    $quantity_current= $stock - $purchase_quantity;
                  }
                }

               $sql6="update product set 
                      stock=?
                      where
                      id_product=?
                      ";
               
               $sql6=$connect->prepare($sql6);   
               
               $sql6->bindValue(1,$quantity_current);
               $sql6->bindValue(2,$id_product);

               $sql6->execute();
            }//end foreach
          }//end if status from else
      }
    }// END function

    public function list_search_registers_date($start_date, $end_date){

      $connect= parent::connection();
      
      $start_date = $_POST["start_date"];
      $date = str_replace('/', '-', $start_date);
      $start_date = date("Y-m-d", strtotime($date));
   
      $end_date = $_POST["end_date"];
      $date = str_replace('/', '-', $end_date);
      $end_date = date("Y-m-d", strtotime($date));

      $sql= "SELECT * FROM purchases WHERE purchase_date>=? and purchase_date<=? ";

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
      
      $sql= "SELECT * FROM purchases WHERE purchase_date like ? ";
      $sql = $connect->prepare($sql);
      $sql->bindValue(1,$date);
      $sql->execute();
      return $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
  }

?>