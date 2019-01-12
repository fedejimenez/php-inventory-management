var table;
//execute at start
function init(){
  list();

  // when clicking submit, save
  $("#user_form").on("submit", function(e){
    saveandedit(e);
  })

  // change title from modal when click button "add user"
  $("#add_button").click(function(){
    $(".modal-title").text("Add User");
  });
}

//clear from fields
function clearUser(){
  $("#idnumber").val("");
  $('#name').val("");
  $('#lastname').val("");
  $('#role').val("");
  $('#user').val("");
  $('#password').val("");
  $('#password2').val("");
  $('#phone').val("");
  $('#email').val("");
  $('#address').val("");
  $('#status').val("");
  $('#id_user').val("");
}

// list users
function list(){
  table=$('#user_data').dataTable({

  "aProcessing": true,//Activate datatables
  "aServerSide": true,//Pagination y filtering on the servidor
  dom: 'Bfrtip',//Define control elements
  buttons: [              
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],

  "ajax":
     {
        url: '../ajax/user.php?op=listusers',
        type : "get",
        dataType : "json",            
        error: function(e){
          console.log(e.responseText);  
        }
      },

  "bDestroy": true,
  "responsive": true,
  "bInfo":true,
  "iDisplayLength": 10,// 10 items per page
    "order": [[ 0, "desc" ]],//Order (column,order)
    "language": {
        "sProcessing":     "Loading...",
        "sLengthMenu":     "Show _MENU_ registers",
        "sZeroRecords":    "No results found",
        "sEmptyTable":     "No data available",
        "sInfo":           "Showing a total of _TOTAL_ registers",
        "sInfoEmpty":      "Showing a total of 0 registers",
        "sInfoFiltered":   "(fitering from a total of _MAX_ registers)",
        "sInfoPostFix":    "",
        "sSearch":         "Search:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Loading...",
        "oPaginate": {
            "sFirst":    "First",
            "sLast":     "Last",
            "sNext":     "Next",
            "sPrevious": "Previous"
     
        },
     
        "oAria": {
            "sSortAscending":  ": Ascending order",
            "sSortDescending": ": Descending order"
     
        }

    }

  }).DataTable();
}

// show user data in form modal
function showUser(id_user){
  $.post("../ajax/user.php?op=show",{id_user : id_user}, function(data, status)
  {
    data = JSON.parse(data);
    $("#userModal").modal("show");
    $("#idnumber").val(data.idnumber);
    $("#name").val(data.name);
    $("#lastname").val(data.lastname);
    $("#role").val(data.role);
    $("#user").val(data.user);
    $("#password").val(data.password);
    $("#password2").val(data.password2);
    $("#phone").val(data.phone);
    $("#email").val(data.email);
    $("#address").val(data.address);
    $("#status").val(data.status);
    $(".modal-title").text("Edit user");
    $("#id_user").val(id_user);
    $("#action").val("Edit");
  });
}

// save and edit, called when click in submit or save
function saveandedit(e){
  e.preventDefault();
  var formData = new FormData($("#user_form")[0]);
  
  // password validation
  var password = $("#password").val();
  var password2 = $("#password2").val();

  if (password == password2) {
    $.ajax({
       url: "../ajax/user.php?op=saveandedit",
       type: "POST",
       data: formData,
       contentType: false, 
       processData: false,

       success: function(data){
        // console.log(data);
        $("#user_form")[0].reset();
        $("#userModal").modal("hide");
        $("#results_ajax").html(data);
        $("#user_data").DataTable().ajax.reload();
        
        clearUser(); // clear fields in the form
       }
    });

  } else {
    bootbox.alert("Passwords doesn't match");
  }
}

// change user status (active / inactive)
function changeStatus(id_user, status){
  bootbox.confirm("Are you sure you want to change your status?", function(result){
    if (result) {
      $.ajax({
        url: "../ajax/user.php?op=changestatus",
        method: "POST",
        data:{id_user:id_user, status:status},
        success: function(data){
          $("#user_data").DataTable().ajax.reload();
        }
      });

    }
  });
}

init();
