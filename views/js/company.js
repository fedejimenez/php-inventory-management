function init(){
  $("#company_form").on("submit", function(e){
    edit_company(e);
  })
}

function show_company(id_user_company){
  $.post("../ajax/company.php?op=company",{id_user_company : id_user_company}, function(data, status){
    data = JSON.parse(data);
    $('#companyModal').modal('show');
    $('#idnumber_company').val(data.idnumber);
    $('#name_company').val(data.name);
    $('#phone_company').val(data.phone);
    $('#email_company').val(data.email);
    $('#address_company').val(data.address);
    $('.modal-title').text("Edit Company");
    $('#id_user_company').val(id_user_company);
  });
}

function edit_company(e){
  e.preventDefault(); 
  var formData = new FormData($("#company_form")[0]);
  $.ajax({
    url: "../ajax/company.php?op=edit_company",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function(data){                    
        console.log(data);
        $('#companyModal').modal('hide');
        $("#results_ajax").html(data);
      }
  });
}

init();