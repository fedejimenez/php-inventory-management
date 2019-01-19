<div id="companyModal" class="modal fade">
  <div class="modal-dialog">
    <form action="" class="form-horizontal" method="post" id="company_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Company Information</h4>
        </div>
        <div class="modal-body">

        <div class="form-group">
          <label for="inputText3" class="col-lg-1 control-label">Id Number
          </label>
          <div class="col-lg-9 col-lg-offset-1">
            <input type="text" class="form-control" id="idnumber_company" name="idnumber_company" placeholder="Id Number" required pattern="[0-9]{0,15}">
          </div>
        </div>

        <div class="form-group">
          <label for="inputText1" class="col-lg-1 control-label"> Name
          </label>
          <div class="col-lg-9 col-lg-offset-1">
            <input type="text" class="form-control" id="name_company" name="name_company" placeholder="Name" required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
          </div>
        </div>

        <div class="form-group">
          <label for="inputText4" class="col-lg-1 control-label">Phone</label>
            <div class="col-lg-9 col-lg-offset-1">
              <input type="text" class="form-control" id="phone_company" name="phone_company" placeholder="Phone" required pattern="[0-9]{0,15}">
            </div>
          </div>

          <div class="form-group">
            <label for="inputText4" class="col-lg-1 control-label">Email</label>
            <div class="col-lg-9 col-lg-offset-1">
              <input type="email" class="form-control" id="email_company" name="email_company" placeholder="Email" required="required">
            </div>
          </div>

          <div class="form-group">
            <label for="inputText5" class="col-lg-1 control-label">Address
            </label>
            <div class="col-lg-9 col-lg-offset-1">
              <textarea class="form-control  col-lg-5" rows="3" id="address_company" name="address_company"  placeholder="Address ..." required pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
              </textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <input type="hidden" name="id_user_company" id="id_user_company"/>
          <button type="submit" name="action" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

