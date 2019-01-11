// after clicking submit save profile
$("#profile_form").on("submit", function(e){
  edit_profile(e);
});

// show user profile
function show_profile(id_user_profile){
  $.post("../ajax/profile.php?op=show_profile",{id_user_profile : id_user_profile}, function(data, status)
  {
    console.log(data);
    data = JSON.parse(data);
    $("#profileModal").modal("show");

    $("#idnumber_profile").val(data.idnumber);
    $("#name_profile").val(data.name);
    $("#lastname_profile").val(data.lastname);
    $("#user_profile").val(data.user_profile);
    $("#password_profile").val(data.password);
    $("#password2_profile").val(data.password2);
    $("#phone_profile").val(data.phone);
    $("#email_profile").val(data.email);
    $("#address_profile").val(data.address);

    $(".modal-title").text("Edit user");
    $("#id_user_profile").val(id_user_profile);
    $("#action").val("Edit");
    $("#operation").val("Edit");
  });
}

// save edit user profile after click
function edit_profile(e){
  e.preventDefault();
  var formData = new FormData($("#profile_form")[0]);
  
  // password validation
  var password = $("#password_profile").val();
  var password2 = $("#password2_profile").val();

  if (password == password2) {
    $.ajax({
       url: "../ajax/profile.php?op=edit_profile",
       type: "POST",
       data: formData,
       contentType: false, 
       processData: false,

       success: function(data){
        console.log(data);
        $("#profileModal").modal("hide");
        $("#results_ajax").html(data);
        
       }
    });

  }
}