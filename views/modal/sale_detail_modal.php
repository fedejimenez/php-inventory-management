<div class="modal fade" id="sale_detail">
  <div class="modal-dialog sizeModal">
    <div class="bg-warning">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><i class="fa fa-user-circle" aria-hidden="true"></i> SALE DETAILS</h4>
      </div>
      <div class="modal-body">
        <div class="container box">
          <div class="table-responsive">
            <div class="box-body">
              <table id="detail_client" class="table table-striped table-bordered table-condensed table-hover">
                <thead style="background-color:#A9D0F5">
                  <tr>
                    <th>Client</th>
                    <th>Sale Number</th>
                    <th>Client Id Number</th>
                    <th>Address</th>
                    <th>Sale Date</th>
                  </tr>
                </thead>
                <tbody>
                  <td> <h4 id="client"></h4><input type="hidden" name="client" id="client"></td>
                  <td><h4 id="sale_number"></h4><input type="hidden" name="sale_number" id="sale_number"></td>
                  <td><h4 id="idnumber_client"></h4><input type="hidden" name="idnumber_client" id="idnumber_client"></td>
                  <td><h4 id="address"></h4><input type="hidden" name="address" id="address"></td>
                  <td><h4 id="sale_date"></h4><input type="hidden" name="sale_date" id="sale_date"></td>
                </tbody>
              </table>
              
              <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                  <thead style="background-color:#A9D0F5">
                    <th>Quantity</th>
                    <th>Product</th>
                    <th>Saling Price</th>
                    <th>Discount</th>
                    <th>Ammount</th>
                  </thead>
                </table>
              </div>
              </div>
             
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close
                </button>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

     

    

        
  