<?php

  require_once("../config/connection.php");

  if(isset($_SESSION["id_user"])){
    require_once("../models/Sale.php");
    $sale = new Sale();
    
?>

<?php 
  require_once("header.php");
?>

<!-- check if user has permission -->
<?php
  if ($_SESSION["sales"] == 1) {

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sales
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="btn-group text-center">
          <a href="show_sales.php" class="btn btn-primary btn-lg" ><i class="fa fa-search" aria-hidden="true"></i> Show Sales</a>
        </div>
      </div>
    </div>

    <?php require_once("modal/list_clients_modal.php");?>
    <?php require_once("modal/list_products_sales_modal.php");?>

    <section class="form-purchase">
      <form class="form-horizontal" id="form_purchase">
        <div class="row">
          <div class="col-lg-8">
            <div class="box">
              <div class="box-body">
                
                <div class="form-group">
                  <div class="col-lg-6 col-lg-offset-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalClient"><i class="fa fa-search" aria-hidden="true"></i>  Search Client
                    </button>
                  </div>
                </div>

                <div class="form-group">
                  <label for="" class="col-lg-3 control-label">Sale Number
                  </label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" id="sale_number" name="sale_number" value="<?php $code=$sale->sale_number();?>"  readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="" class="col-lg-3 control-label">Id Number</label>

                  <div class="col-lg-9">
                    <input type="text" class="form-control" id="idnumber" name="idnumber" placeholder="Id Number" required pattern="[0-9]{0,15}" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="" class="col-lg-3 control-label">Name</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="" class="col-lg-3 control-label">Lastname</label>
                  <div class="col-lg-9">
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$" readonly>
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
          <!--end col-lg-12-->
        </div>
        <!--end row-->

        <!--FILA- PRODUCTO-->
        <div class="row">
          <div class="col-sm-12">
            <div class="box">
              <div class="box-body">
                <div class="row">
                  <div class="col-lg-3">
                    <div class="col-lg-5 text-center">
                      <button type="button" id="#" class="btn btn-primary btn_product" data-toggle="modal" data-target="#list_products_sales_Modal"><i class="fa fa-plus" aria-hidden="true"></i>  Add Products
                      </button>
                    </div>
                  </div>
                  
                  <div class="col-lg-3">
                    <div class="col-lg-5">
                      <label for="">Seller: </label>
                      <h4 id="seller" name="seller"><?php echo $_SESSION["name"];?></h4>
                    </div>
                  </div>
                 
                  <div class="col-lg-3">
                    <div class="">
                      <h4 class="text-center"><strong>Payment Type</strong>
                      </h4>
                      <select name="payment_type" class="col-lg-offset-3 col-xs-offset-2" id="payment_type" class="select" maxlength="10" >
                        <option value="">Select Payment Type</option>
                        <option value="CHECK">Check</option>
                        <option value="CASH">Cash</option>
                        <option value="BANK TRANSFER">Bank Transfer</option>
                      </select>
                    </div>
                  </div>
                </div><!--end row-->
              </div>
            </div>
          </div>
          <!--end col-sm-6-->
        </div>
        <!--end row-->

        <div class="row">
          <div class="col-lg-12">
            <div class="table-responsive">
              <div class="box-header">
                <h3 class="box-title">Sales List</h3>
              </div>
              <div class="box-body">
                <table id="detalles" class="table table-striped">
                  <thead>
                    <tr class="bg-success">
                      <th class="all">Item</th>
                      <th class="all">Product</th>
                      <th class="all">Selling Price</th>
                      <th class="min-desktop">Stock</th>
                      <th class="min-desktop">Quantity</th>
                      <th class="min-desktop">Discount %</th>
                      <th class="min-desktop">Ammount</th>
                      <th class="min-desktop">Actions</th>
                    </tr>
                  </thead>
                  <div id="results_sales_ajax"></div>
                  <tbody id="listProdSales">
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!--TABLE SUBTOTAL - TOTAL -->
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                <table class="table table-striped">
                  <thead>
                    <tr class="bg-success">
                      <th class="col-lg-4">SUBTOTAL</th>
                      <th class="col-lg-4">TAX %</th>
                      <th class="col-lg-4">TOTAL</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="bg-gray">
                      <td class="col-lg-4"><h4 id="subtotal"> 0.00</h4><input type="hidden" name="subtotal_purchase" id="subtotal_purchase"></td>
                      <td class="col-lg-4"><h4>10%</h4><input type="hidden"></td>
                      <td class="col-lg-4"><h4 id="total" name="total"> 0.00</h4><input type="hidden" name="total_purchase" id="total_purchase"></td>
                    </tr>
                    <tr>
                      <input type="hidden" name="register" value="yes">
                      <input type="hidden" name="id_user" id="id_user" value="<?php echo $_SESSION["id_user"];?>"/>
                      <input type="hidden" name="id_client" id="id_client"/>
                    </tr>
                  </tbody>
                </table>

                <div class="boton_register">
                  <button type="button" onClick="registerSale()" class="btn btn-primary col-lg-offset-10 col-xs-offset-3" id="btn_send"><i class="fa fa-save" aria-hidden="true"></i>  Register Sale</button>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </form>
        <!--formulario-pedido-->
      </section>
      <!--section formulario - pedido -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- if user has no permission -->
<?php 
  } else {
    require("noaccess.php");
  }
?>  

<?php require_once("footer.php");?>

<script type="text/javascript" src="js/category.js"></script>
<script type="text/javascript" src="js/client.js"></script>
<script type="text/javascript" src="js/product.js"></script>
<script type="text/javascript" src="js/sale.js"></script>

<?php
   } else {
         header("Location:".Connect::route()."index.php");
     }
?>
