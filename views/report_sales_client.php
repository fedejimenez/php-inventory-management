<?php
  require_once("../config/connection.php");
  if(isset($_SESSION["id_user"])){
    require_once("../models/Client.php");
    $client= new Client();
    $clients= $client->get_clients();
?>

<?php require_once("header.php");?>
<div class="content-wrapper">
  <h2 class="report_sales_general container-fluid bg-red text-white col-lg-12 text-center mh-50">
    REPORT - SALES BY CLIENTS
  </h2><br>
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row  col-sm-5 col-sm-offset-3">
        <div class=""><br>
          <form action="report_sales_client_pdf.php" method="post" target="_blank">
            <div class="form-group">
              <label for="staticEmail">Start Date</label>
                <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Start Date" required>
            </div>
            <div class="form-group">
              <label for="inputPassword">End Date</label>
                <input type="text" class="form-control" id="datepicker2" name="datepicker2" placeholder="End Date" required>
            </div>
            <div class="form-group">
             <label for="inputPassword" class="col-sm-2 col-form-label">Client</label>
                <select name="idnumber" class="form-control" required>
                  <option value="">SELECT</option>
                  <?php
                    for($i=0;$i<sizeof($clients);$i++){
                      ?>
                        <option value="<?php echo $clients[$i]["idnumber_client"]?>"><?php echo $clients[$i]["name_client"]?>
                        </option>
                     <?php
                    }
                  ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">SEARCH</button>
         </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once("footer.php");?>

<?php
   }
?>