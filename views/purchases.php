

<?php

  require_once("../config/connection.php");
  if(isset($_SESSION["id_user"])){
    require_once("../models/Purchase.php");
    $purchase = new Purchase();
    
?>


<?php require_once("header.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Purchases 
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="panel panel-default">
        <div class="panel-body">
         <div class="btn-group text-center">
          <a href="search_purchases.php" class="btn btn-primary btn-lg" ><i class="fa fa-search" aria-hidden="true"></i> Search Purchase</a>
         </div>
       </div>
      </div>

      <section class="form-purchase">
        <form class="form-horizontal" id="form_purchase">
          <!--SUPPLIER - PAYSLIP-->
          <div class="row">
            <div class="col-lg-8">
              <div class="box">
                <div class="box-body">
                  
                  <div class="form-group">
                    <div class="col-lg-6 col-lg-offset-3">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#supplierModal"><i class="fa fa-search" aria-hidden="true"></i>  Search Supplier</button>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-3 control-label">Purchase Number</label>
                    <div class="col-lg-9">
                      <input type="text" class="form-control" id="purchase_number" name="purchase_number" value="<?php //$code=$purchase->purchase_number();?>"  readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-3 control-label">Id Number</label>
                    <div class="col-lg-9">
                      <input type="text" class="form-control" id="idnumber" name="idnumber" placeholder="Id Number" required pattern="[0-9]{0,15}" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-3 control-label">Corporate Name</label>
                    <div class="col-lg-9">
                      <input type="text" class="form-control" id="corporate_name" name="corporate_name" placeholder="Corporate Name" required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,50}$" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-3 control-label">Address</label>
                    <div class="col-lg-9">
                      <input type="text" class="form-control" id="address" name="address" placeholder="Address" required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$" readonly>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!--fin col-lg-12-->
          </div>
          <!--fin row-->

          <!--CTEGORY  - PRODUCT-->
          <div class="row">
            <div class="col-sm-12">
              <div class="box">
                <div class="box-body">
                  <div class="row">
                    
                    <div class="col-lg-3">
                      <div class="col-lg-5 text-center">
                        <button type="button" id="#" class="btn btn-primary" data-toggle="modal" data-target="#products_listModal"><i class="fa fa-plus" aria-hidden="true"></i>Add Product</button>
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="col-lg-5">
                        <label for="">Purchaser: </label>
                        <h4 id="purchaser" name="purchaser"><?php echo $_SESSION["name"];?></h4>
                      </div>
                    </div>
                   
                    <div class="col-lg-3">
                      <div class="">
                        <h4 class="text-center"><strong>Payment Type</strong></h4>
                        <select name="tipo_pago" class="col-lg-offset-3 col-xs-offset-2" id="payment_type" class="select" maxlength="10" >
                          <option value="">SELECT THE PAYMENT TYPE</option>
                          <option value="CHECK">CHECK</option>
                          <option value="CASH">CASH</option>
                          <option value="TRANSFER">BANK TRANSFER</option>
                        </select>
                      </div>
                    </div>
                  </div><!--end row-->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!--end col-sm-6-->
          </div>
          <!--end row-->

          <div class="container box">
            <div class="row">
              <div class="col-lg-12">
                <div class="table-responsive">
                  
                  <div class="box-header">
                    <h3 class="box-title">Purchases</h3>
                  </div>
                  <!-- /.box-header -->
                
                  <div class="box-body">
                    <table id="details" class="table table-striped">
                      <thead>
                        <tr class="bg-success">
                          <th class="all">Item</th>
                          <th class="all">Product</th>
                          <th class="all">Buying Price</th>
                          <th class="min-desktop">Stock</th>
                          <th class="min-desktop">Quantity</th>
                          <th class="min-desktop">Discount %</th>
                          <th class="min-desktop">Ammount</th>
                          <th class="min-desktop">Actions</th>
                        </tr>
                      </thead>
                      <tbody id="listProdPurchase">
                      </tbody>
                    </table>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.table responsive -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /row -->
          </div>
          <!-- /container -->

          <!-- SUBTOTAL - TOTAL -->
          <div class="row">
            <div class="col-xs-12">
              <div class="table-responsive">
                <div class="box-body">
                  <table id="results_footer" class="table table-striped">
                    <thead>
                      <tr class="row bg-success">
                        <th class="col-lg-4">SUBTOTAL</th>
                        <th class="col-lg-4">TAX %</th>
                        <th class="col-lg-4">TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="row bg-gray">
                        <td class="col-lg-4"><h4 id="subtotal"> 0.00</h4><input type="hidden" name="subtotal_purchase" id="subtotal_purchase"></td>
                        <td class="col-lg-4"><h4>10%</h4><input type="hidden"></td>
                        <td class="col-lg-4"><h4 id="total" name="total"> 0.00</h4><input type="hidden" name="total_purchase" id="total_purchase"></td>
                      </tr>
                      <tr class="">
                        <input type="hidden" name="record" value="yes">
                        <input type="hidden" name="id_user" id="id_user" value="<?php echo $_SESSION["id_user"];?>"/>
                         <input type="hidden" name="id_supplier" id="id_supplier"/>
                      </tr>
                    </tbody>
                  </table>

                  <div class="button_register">
                    <button type="button" onClick="registerPurchase()" class="btn btn-primary col-lg-offset-10 col-xs-offset-3" id="btn"><i class="fa fa-save" aria-hidden="true"></i>  Register Purchase</button>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </form>
        <!--form-->
      </section>
      <!--section form -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!--END CONTENT-->

  <?php require_once("modal/suppliers_list_modal.php");?>
  <?php require_once("modal/products_list_modal.php");?>
  <?php require_once("footer.php");?>

  <!--AJAX SUPPLIERS-->
  <script type="text/javascript" src="js/supplier.js"></script>

  <!--AJAX PRODUCTO-->
  <script type="text/javascript" src="js/product.js"></script>

<?php
   
  } else {
      header("Location:".Connect::route()."views/index.php");
  }

?>

