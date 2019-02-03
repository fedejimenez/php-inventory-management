<?php

  require_once("../config/connection.php");

  if(isset($_SESSION["id_user"])){
       
?>

<?php
  require_once("header.php");
?>

<!-- check if user has permission -->
<?php
  if ($_SESSION["clients"] == 1) {

 ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">        
  <!-- Main content -->
  <section class="content">
    <div id="resultados_ajax"></div>
    <h2>Clients</h2>
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title">
              <button class="btn btn-primary btn-lg" id="add_button" onclick="clearClient()" data-toggle="modal" data-target="#clientModal"><i class="fa fa-plus" aria-hidden="true"></i> New Client</button></h1>
              <div class="box-tools pull-right">
              </div>
          </div>
          <!-- center -->
          <div class="panel-body table-responsive">
            <table id="client_data" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Id Number</th>
                  <th>Name</th>
                  <th>Lastname</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th width="10%">Edit</th>
                  <th width="10%">Delete</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div><!--end centro -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
    
<!--MODAL FORM-->
<div id="clientModal" class="modal fade">
  <div class="modal-dialog">
    <form class="form-horizontal" method="post" id="client_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Client</h4>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label for="inputText3" class="col-lg-1 control-label">Id Number</label>
            <div class="col-lg-9 col-lg-offset-1">
              <input type="text" class="form-control" id="idnumber" name="idnumber" placeholder="Id Number" required pattern="[0-9]{0,15}">
            </div>
          </div>

          <div class="form-group">
            <label for="inputText1" class="col-lg-1 control-label">Name</label>
            <div class="col-lg-9 col-lg-offset-1">
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
            </div>
          </div>

          <div class="form-group">
            <label for="inputText1" class="col-lg-1 control-label">Lastname</label>
            <div class="col-lg-9 col-lg-offset-1">
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
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
                <option value="">-- Select status --</option>
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
          </div>
          
        </div> <!--modal-body-->

        <div class="modal-footer">
          <input type="hidden" name="id_user" id="id_user" value="<?php echo $_SESSION["id_user"];?>"/>
          <input type="hidden" name="id_client" id="id_client"/>
          <input type="hidden" name="idnumber_client" id="idnumber_client"/>

          <button type="submit" name="action" id="#" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save </button>

          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
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

<script type="text/javascript" src="js/client.js"></script>

<?php
  } else {
        header("Location:".Connect::route()."index.php");
  }

?>

