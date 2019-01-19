
var table;

function init(){
  
  list();
  // whrn clicking submit;
  $("#category_form").on("submit",function(e)
  {
    saveCategory(e);  
  })
    
  // change modal title
  $("#add_button").click(function(){
    $(".modal-title").text("Add Category");
  });
}

// clear fields
function clearCategory()
{
  console.log("in");
  $('#category').val("");
  $('#status').val("");
  $('#id_category').val("");
}

// list categories
function list(){
  table=$('#category_data').dataTable(
  {
    "aProcessing": true,// activate datatables
      "aServerSide": true,// paging and filtering
      dom: 'Bfrtip',// define elements
      buttons: [              
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
    "ajax":
        {
          url: '../ajax/category.php?op=list',
          type : "get",
          dataType : "json",            
          error: function(e){
            console.log(e.responseText);  
          }
        },
    "bDestroy": true,
    "responsive": true,
    "bInfo":true,
    "iDisplayLength": 10,// 10 registers per page
      "order": [[ 0, "desc" ]],//order 
      
      "language": {
 
          "sProcessing":     "Loading...",
          "sLengthMenu":     "Show _MENU_ registers",
          "sZeroRecords":    "No results found",
          "sEmptyTable":     "No data available",
          "sInfo":           "Showing a total of _TOTAL_ registers",
          "sInfoEmpty":      "Showing a total of 0 registers",
          "sInfoFiltered":   "(filtered from a total of _MAX_ registers)",
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
              "sSortAscending":  ": Sort column in ascending order",
              "sSortDescending": ": Sort column in descending order"
          }

         }//close language 
         
  }).DataTable();
}

 // show category data in modal
function showCategory(id_category){
  $.post("../ajax/category.php?op=show",{id_category : id_category}, function(data, status)
  {
    data = JSON.parse(data);
    $('#categoryModal').modal('show');
    $('#category').val(data.category);
    $('#status').val(data.status);
    $('.modal-title').text("Edit Category");
    $('#id_category').val(id_category);
    $('#action').val("Edit");

  });
}

// when clicking submitt
function saveCategory(e){
  e.preventDefault(); 
  var formData = new FormData($("#category_form")[0]);
    $.ajax({
      url: "../ajax/category.php?op=saveandedit",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data)
        {                    
          console.log(data);
          $('#category_form')[0].reset();
          $('#categoryModal').modal('hide');
          $('#results_ajax').html(data);
          $('#category_data').DataTable().ajax.reload();

          clearCategory();
        }
    });
}

function changeStatusCategory(id_category, status){
  bootbox.confirm("Are you sure?", function(result){
    if(result){
      $.ajax({
        url:"../ajax/category.php?op=changestatus",
        method:"POST",
        data:{id_category:id_category, status:status},
        success: function(data){
          $('#category_data').DataTable().ajax.reload();
        }
      });
    }
  });//bootbox
}

function deleteCategory(id_category){
  bootbox.confirm("Are you sure you want to delete this Category?", function(result){
    if(result){
      $.ajax({
        url:"../ajax/category.php?op=delete",
        method:"POST",
        data:{id_category:id_category},

        success:function(data){
          console.log(data);
          $("#results_ajax").html(data);
          $("#category_data").DataTable().ajax.reload();
        }
      });
    }
  });//bootbox
}

init();