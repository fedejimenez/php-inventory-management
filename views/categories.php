<?php
 
  require_once("../config/connection.php");

  if (isset($_SESSION["id_user"])) {

?>

<?php
 
  require_once("header.php");

?>
  <!--Container-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
          <div id="results_ajax"></div>
          <h2> Categories list </h2>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">
                          <button class="btn btn-primary btn-lg" id="add_button" onclick="clear()" data-toggle="modal" data-target="#categoryModal"><i class="fa fa-plus" aria-hidden="true"></i> New Category</button>
                        </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- center -->
                    <div class="panel-body table-responsive"> 
                      <table id="category_data" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="8%">Category</th>
                            <th width="5%">Status</th>
                            <th width="5%"> Edit </th>
                            <th width="5%"> Delete </th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                    </div>
                  
                    <!--End center -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--End-Container-->

  <!-- FORM MODAL -->
  <div id="categoryModal" class="modal fade">
    <div class="modal-dialog">
      <form method="post" id="category_form">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Category</h4> 
          </div>
          <div class="modal-body">
            <label>Category</label>
            <input type="text" name="category" id="category" class="form-control" placeholder="Category" required pattern="^[a-zA-Z_áéíóúñ\s]{0,15}$">
            <br>

            <label>Status</label>
            <select class="form-control" name="status" id="status" required>
              <option value="">-- Select Status --</option>
              <option value="1" selected>Active</option>
              <option value="0">Inactive</option>
            </select>
            <br>

          </div>

          <div class="modal-footer">
            <input type="hidden" name="id_user" id="id_user" value="<?php echo $_SESSION["id_user"];?>">

            <input type="hidden" name="id_category" id="id_category">
            
            <button type="submit" name="action" id="btnSave" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>

            <button type="button" onclick="clear()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>Close</button>
          
          </div>

        </div>
      </form>
    </div>
  </div>
<?php

  require_once("footer.php");
?>

<script type="text/javascript" src="js/category.js"></script>

<?php 

  } else {
    //   if not logged in
    header("Location:".Connect::route()."views/index.php");
  }

?> 