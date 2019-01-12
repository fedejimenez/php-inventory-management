
<?php

   require_once("../config/connection.php");

    if(isset($_SESSION["id_user"])){

       require_once("../models/Category.php");

       $category = new Category();
       $cat = $category->get_categories();
?>

<?php
  require_once("header.php");
?>
  <!--Content-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
             
          <div id="resultados_ajax"></div>

            <h2>Products List</h2>

            <div class="row">
              <div class="col-md-12">
                <div class="box">
                  <div class="box-header with-border">
                    <h1 class="box-title">
                    <button class="btn btn-primary btn-lg" id="add_button" onclick="clearProduct()" data-toggle="modal" data-target="#productModal"><i class="fa fa-plus" aria-hidden="true"></i> New Product</button></h1>
                      <div class="box-tools pull-right">
                        </div>
                  </div>
                  <!-- /.box-header -->
                  <!-- table -->
                  <div class="panel-body table-responsive">
                    <table id="product_data" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width="10%">Category</th>
                          <th width="12%">Product</th>
                          <th width="10%">Package</th>
                          <th width="5%">Meas. Unit</th>
                          <th width="10%">Buying Price</th>
                          <th width="10%">Saling Price</th>
                          <th width="5%">Stock</th>
                          <th width="10%">Status</th>
                          <th width="10%">Edit</th>
                          <th width="10%">Delete</th>
                          <th>Image </th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                     
                  </div>
                  <!--End table -->
                </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--End-Content-->
    
 <!--MODAL FORM-->
  
<div id="productModal" class="modal fade">
  <div class="modal-dialog sizeModal">
    <form class="form-horizontal" method="post" id="product_form" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Product</h4>
        </div>
        <div class="modal-body">
          <section class="form-add_product">
            <div class="row">
            <!--FIRST COLUMN-->
            <!--column-12 -->
            <div class="col-lg-6">
              <!-- Horizontal Form -->
              <div class="box">
                <div class="box-body">

                  <div class="form-group">
                    <label for="" class="col-lg-1 control-label">Category</label>
                    <div class="col-lg-9 col-lg-offset-1">
                      <select class="form-control" name="category" id="category">
                        <option  value="0">Select</option>
                        <?php
                          for($i=0; $i<sizeof($cat);$i++){
                            ?>
                            <option value="<?php echo $cat[$i]["id_category"]?>"><?php echo $cat[$i]["category"];?></option>
                             <?php
                           }
                        ?>
                      
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-1 control-label">Product</label>
                    <div class="col-lg-9 col-lg-offset-1">
                      <input type="text" class="form-control" id="product" name="product" placeholder="Product Detail" required pattern="^[a-zA-Z0-9_áéíóúñ\s]{0,70}$">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-1 control-label">Package</label>
                    <div class="col-lg-9 col-lg-offset-1">
                      <select class="form-control" name="package" id="package">
                        <option value="0">Select</option>
                          <option value="Bag">Bag</option>
                          <option value="Box">Box</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-1 control-label">Meas. Unit</label>
                    <div class="col-lg-9 col-lg-offset-1">
                      <select class="selectpicker form-control" id="unit" name="unit" required>
                        <option value="">-- Select Unit --</option>
                        <option value="kilo">Kilo</option>
                        <option value="Gram">Gram</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-1 control-label">Buying Price</label>
                    <div class="col-lg-9 col-lg-offset-1">
                      <select class="selectpicker form-control" id="currency" name="currency" required>
                        <option value="">-- Select Currency --</option>
                        <option value="USD$">USD$</option>
                        <option value="EUR">EUR€</option>
                      </select>
                      <input type="text" class="form-control" id="buying_price" name="buying_price" placeholder="Buying Price" required pattern="[0-9]{0,15}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-1 control-label">Saling Price</label>
                    <div class="col-lg-9 col-lg-offset-1">
                      <input type="text" class="form-control" id="sale_price" name="sale_price" placeholder="Saling Price" required pattern="[0-9]{0,15}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-1 control-label">Stock</label>
                    <div class="col-lg-9 col-lg-offset-1">
                      <input type="text" class="form-control" id="stock" name="stock"  disabled>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="" class="col-lg-1 control-label">Status</label>
                    <div class="col-lg-9 col-lg-offset-1">
                      <select class="form-control" id="status" name="status" required>
                        <option value="">-- Selecciona status --</option>
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                      <label for="" class="col-lg-1 control-label">Expiration Date</label>
                      <div class="col-lg-9 col-lg-offset-1">
                        <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Expiration Date">
                      </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!--/box-->
            </div>
            <!--/.col (6) -->

            <!--SECOND COLUMN-->
            <!--column-12 -->
            <div class="col-lg-4">
              <div class="form-group">
                <div class="col-sm-7 col-lg-offset-3 col-sm-offset-3">
                <!--product_image-->
                  <input type="file" id="product_image" name="product_image">
                  <span id="product_uploaded_image"></span>
                </div>
              </div>
              <!--/form-group-->
            </div>
            <!--/.col (4) -->
          </div>
          <!-- /.row -->
          </section>
          <!--section - add- product -->
        </div>
 
        <!--modal-body-->
        <div class="row">
          <div class="col-lg-4 col-lg-offset-3 col-sm-8"> 
            <div class="modal-footer">
              <input type="hidden" name="id_user" id="id_user" value="<?php echo $_SESSION["id_user"];?>"/>
              <input type="hidden" name="id_product" id="id_product"/>
              <button type="submit" name="action" id="#" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save </button>

              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
            </div><!--modal-footer-->

          </div>
        </div><!--row-->
      </div>
    </form> <!-- END FORM -->
  </div>
</div>
 <!--END MODAL FORM-->

<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/product.js"></script>

<?php
  } else {
    header("Location:".Connect::ruta()."views/index.php");
  }

?>

