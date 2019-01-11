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
          <h2> User's list </h2>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">
                          <button class="btn btn-primary btn-lg" id="add_button" onclick="clear()" data-toggle="modal" data-target="#userModal"><i class="fa fa-plus" aria-hidden="true"></i> New User</button>
                        </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- center -->
                    <div class="panel-body table-responsive"> 
                      <table id="user_data" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Id Number</th>
                            <th>Name</th>
                            <th>Lastame</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Start date</th>
                            <th>Status</th>
                            <th width="10%"> Edit </th>
                            <th width="10%"> Delete </th>
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
  <div id="userModal" class="modal fade">
    <div class="modal-dialog">
      <form method="post" id="user_form">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add User</h4> 
          </div>
          <div class="modal-body">
            <label>Id Number</label>
            <input type="text" name="idnumber" id="idnumber" class="form-control" placeholder="Id Number" required pattern="[0-9]{0,10}">
            <br>

            <label>Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
            <br>

            <label>Lastname</label>
            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
            <br>

            <label>Role</label>
            <select class="form-control" name="role" id="role" required>
              <option value="">-- Select Role --</option>
              <option value="1" selected>Administrator</option>
              <option value="0">Employee</option>
            </select> 
            <br>

            <label>User</label>
            <input type="text" name="user" id="user" class="form-control" placeholder="User" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
            <br>

            <label>Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required ">
            <br>

            <label>Password Confirmation</label>
            <input type="password" name="password2" id="password2" class="form-control" placeholder="Password Confirmation" required ">
            <br>

            <label>Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" required pattern="^[0-9]{0,15}$">
            <br>

            <label>Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required ">
            <br>

            <label>Address</label>
            <textarea cols="90" rows="3" name="address" id="address" class="form-control" placeholder="Address" required pattern="^[a-zA-Z0-9_áéíóúñ\s]{0,200}$">
            </textarea>
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
            <input type="hidden" name="id_user" id="id_user">

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

<script type="text/javascript" src="js/user.js"></script>

<?php 

  } else {
    header("Location:".Connect::route()."views/index.php");
    exit();
  }

?>