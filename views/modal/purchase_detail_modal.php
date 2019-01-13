<div class="modal fade" id="purchase_detail">
  <div class="modal-dialog tamanoModal">
    <div class="bg-warning">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-user-circle" aria-hidden="true"></i> PURCHASE DETAIL</h4>
      </div>
        
      <div class="modal-body">
        <div class="container box">
          <div class="table-responsive">
            <div class="box-body">
              <table id="supplier_detail" class="table table-striped table-bordered table-condensed table-hover">
                <thead style="background-color:#A9D0F5">
                  <tr>
                    <th>Suplier</th>
                    <th>Purchase Number</th>
                    <th>Supplier Id Number</th>
                    <th>Address</th>
                    <th>Purchase Date</th>
                  </tr>
                </thead>
                  <tbody>
                    <td> <h4 id="supplier"></h4><input type="hidden" name="supplier" id="supplier"></td>
                    <td><h4 id="purchase_number"></h4><input type="hidden" name="purchase_number" id="purchase_number"></td>
                    <td><h4 id="idnumber_supplier"></h4><input type="hidden" name="idnumber_supplier" id="idnumber_supplier"></td>
                    <td><h4 id="address"></h4><input type="hidden" name="address" id="address"></td>
                    <td><h4 id="purchase_date"></h4><input type="hidden" name="purchase_date" id="purchase_date"></td>
                  </tbody>
                </table>

                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                  <table id="details" class="table table-striped table-bordered table-condensed table-hover">
                    <thead style="background-color:#A9D0F5">
                      <th>Quantity</th>
                      <th>Product</th>
                      <th>Buying Price</th>
                      <th>Discount</th>
                      <th>Ammount</th>
                    </thead>
                  </table>
                </div>
              </div>
              <!-- /.box-body -->

            <!--close modal-->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
            </div>
            <!--modal-footer-->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!--modal body-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

   

  

      
