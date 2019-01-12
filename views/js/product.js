
var table;

function init(){
  listProducts();

  // when clicking submit;
  $("#product_form").on("submit",function(e){
    saveProduct(e);  
  })
    
  // change modal title
  $("#add_button").click(function(){
    $(".modal-title").text("Add Product");
  });
}

function clearProduct(){
  $("#id_product").val("");
  $("#category").val("");
  $('#product').val("");
  $('#package').val("");
  $('#unit').val("");
  $('#currency').val("");
  $('#buying_price').val("");
  $('#sale_price').val("");
  $('#stock').val("");
  $('#status').val("");
  $('#datepicker').val("");
  $('#product_image').val("");
}

function listProducts(){
  table=$('#product_data').dataTable(
  {
    "aProcessing": true,
      "aServerSide": true,
      dom: 'Bfrtip',
      buttons: [              
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
    "ajax":
        {
          url: '../ajax/product.php?op=list',
          type : "get",
          dataType : "json",            
          error: function(e){
            console.log(e.responseText);  
          }
        },
    "bDestroy": true,
    "responsive": true,
    "bInfo":true,
    "iDisplayLength": 10,
      "order": [[ 0, "desc" ]],
      "language": {
          "sProcessing":     "Loading...",
          "sLengthMenu":     "Show _MENU_ registers",
          "sZeroRecords":    "No results found",
          "sEmptyTable":     "No data available",
          "sInfo":           "Showing a total of _TOTAL_ registers",
          "sInfoEmpty":      "Showing a total ff 0 registers",
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
              "sSortAscending":  ": Sort by ascendending order",
              "sSortDescending": ": Sort by descending order"
          }
         }//end language
  }).DataTable();
}

function showProduct(id_product){
  $.post("../ajax/product.php?op=show",{id_product : id_product}, function(data, status){
    data = JSON.parse(data);
    $('#productModal').modal('show');
    $('#category').val(data.category);
    $('#product').val(data.product);
    $('#package').val(data.package);
    $('#unit').val(data.unit);
    $('#currency').val(data.currency);
    $('#buying_price').val(data.buying_price);
    $('#sale_price').val(data.sale_price);
    $('#stock').val(data.stock);
    $('#status').val(data.status);
    $('#datepicker').val(data.expiration_date);
    $('.modal-title').text("Edit Product");
    $('#id_product').val(id_product);
    $('#product_uploaded_image').html(data.product_image);
    $('#results_ajax').html(data);
    $("#product_data").DataTable().ajax.reload();
  });
}

function saveProduct(e){
  e.preventDefault(); 
  var formData = new FormData($("#product_form")[0]);
  $.ajax({
    url: "../ajax/product.php?op=saveandedit",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function(data){                    
        console.log(data);
        $('#product_form')[0].reset();
        $('#productModal').modal('hide');
        $('#results_ajax').html(data);
        $('#product_data').DataTable().ajax.reload();
        
        clearProduct();
      }
    });
}

function changeProductStatus(id_category, id_product, status){
  bootbox.confirm("Are you sure?", function(result){
    if(result){
      $.ajax({
        url:"../ajax/product.php?op=changestatus",
        method:"POST",
        data:{id_category:id_category,id_product:id_product, status:status},
        success: function(data){
          $('#product_data').DataTable().ajax.reload();
        }
      });
    }
  });// endbootbox
}

init();