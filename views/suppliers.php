<?php

  require_once("../config/connection.php");
  if(isset($_SESSION["id_user"])){
       
?>

<?php
  require_once("header.php");
?>

  <!-- check if user has permission -->
  <?php
    if ($_SESSION["suppliers"] == 1) {

   ?>
  <!--Content-->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">        
    <!-- Main content -->
    <section class="content">
      <div id="results_ajax"></div>

      <h2>Suppliers List</h2>

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h1 class="box-title">
                <button class="btn btn-primary btn-lg" id="add_button" onclick="clearSupplier()" data-toggle="modal" data-target="#supplierModal"><i class="fa fa-plus" aria-hidden="true"></i> New Supplier</button></h1>
                <div class="box-tools pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <!-- table -->
            <div class="panel-body table-responsive">
              <table id="supplier_data" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="10%">Id Number</th>
                    <th width="10%">Corporate NAme</th>
                    <th width="10%">Phone</th>
                    <th width="10%">Email</th>
                    <th width="20%">Address</th>
                    <th width="10%">Date</th>
                    <th width="10%">Status</th>
                    <th width="10%">Edit</th>
                    <th width="10%">Delete</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>  <!--end table -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->

  </div><!-- /.content-wrapper -->
  <!--end-Content-->
    
    <!--MODAL FORM-->
  <div id="supplierModal" class="modal fade">
    <div class="modal-dialog">
      <form class="form-horizontal" method="post" id="supplier_form">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">New Supplier</h4>
            <div class="modal-body">           
              
              <div class="form-group">
                <label for="inputText1" class="col-lg-1 control-label">Corporate Name</label>
                <div class="col-lg-9 col-lg-offset-1">
                  <input type="text" class="form-control" id="corporate_name" name="corporate_name" placeholder="Corporate Name" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
                </div>
              </div>

               <div class="form-group">
                  <label for="inputText3" class="col-lg-1 control-label">Id Number</label>

                  <div class="col-lg-9 col-lg-offset-1">
                    <input type="text" class="form-control" id="idnumber" name="idnumber" placeholder="Id Number" required pattern="[0-9]{0,15}">
                  </div>
              </div>

              <div class="form-group">
                <label for="inputText4" class="col-lg-1 control-label">Phone</label>

                <div class="col-lg-9 col-lg-offset-1">
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required pattern="[0-9]{0,15}">
                </div>
              </div>

              <div class="form-group">
                <label for="inputText4" class="col-lg-1 control-label">Email</label>

                <div class="col-lg-9 col-lg-offset-1">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="required">
                </div>
              </div>

              <div class="form-group">
                <label for="inputText5" class="col-lg-1 control-label">Address</label>
               
                <div class="col-lg-9 col-lg-offset-1">
                  <textarea class="form-control  col-lg-5" rows="3" id="address" name="address"  placeholder="Address ..." required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="inputText4" class="col-lg-1 control-label">Status</label>

                <div class="col-lg-9 col-lg-offset-1">
                  <select class="form-control" id="status" name="status" required>
                    <option value="">-- Select --</option>
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>
              </div>
            </div>
            <!--modal-body-->

            <div class="modal-footer">
              <input type="hidden" name="id_user" id="id_user" value="<?php echo $_SESSION["id_user"];?>"/>

              <input type="hidden" name="idnumber_supplier" id="idnumber_supplier"/>
              
              <button type="submit" name="action" id="#" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save </button>

              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--END MODAL FORM-->

<!-- if user has no permission -->
<?php 
 } else {
    require("noaccess.php");
 }
?>

<?php

  require_once("footer.php");
?>

<script type="text/javascript" src="js/supplier.js"></script>

<?php
   
  } else {

        header("Location:".Conenect::route()."index.php");

  }

  

?>

