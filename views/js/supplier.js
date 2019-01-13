

var table;
var table_en_purchases;

function init(){
  
  listSuppliers();
  listSuppliersInPurchases();

  // when submit form
  $("#supplier_form").on("submit",function(e){
    saveSupplier(e);  
  })
    
  $("#add_button").click(function(){
      // Change modal title
      $(".modal-title").text("Add Supplier");
    });
}

function clearSupplier(){
  
  $('#idnumber').val("");
  $('#corporate_name').val("");
  $('#phone').val("");
  $('#email').val("");
  $('#address').val("");
  $('#datepicker').val("");
  $('#status').val("");
  $('#idnumber_supplier').val("");
}

function listSuppliers(){
  table=$('#supplier_data').dataTable({
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
          url: '../ajax/supplier.php?op=list',
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
      "order": [[ 0, "desc" ]],//Order
      
      "language": {
          "sProcessing":     "Loading...",
          "sLengthMenu":     "Show _MENU_ registers",
          "sZeroRecords":    "No results found",
          "sEmptyTable":     "No data available",
          "sInfo":           "Showing a total of _TOTAL_ registers",
          "sInfoEmpty":      "Showing a total of 0 registers",
          "sInfoFiltered":   "(filtered from a total of de _MAX_ registers)",
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
              "sSortAscending":  ": Sort by ascending order",
              "sSortDescending": ": Sort by descending order"
          }
      }
         
  }).DataTable();
}

function showSupplier(idnumber_supplier){
  $.post("../ajax/supplier.php?op=show",{idnumber_supplier : idnumber_supplier}, function(data, status){
    data = JSON.parse(data);
    //alert(data.idnumber);
    console.log(data);
    
    $('#supplierModal').modal('show');
    $('#idnumber').val(idnumber_supplier);
    $('#corporate_name').val(data.supplier);
    $('#phone').val(data.phone);
    $('#email').val(data.email);
    $('#address').val(data.address);
    $('#datepicker').val(data.fecha);
    $('#status').val(data.status);
    $('.modal-title').text("Edit Supplier");
    $('#idnumber_supplier').val(idnumber_supplier);
  });
}


function saveSupplier(e){
  e.preventDefault(); 
  var formData = new FormData($("#supplier_form")[0]);

  $.ajax({
    url: "../ajax/supplier.php?op=saveandedit",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function(data){                    
      console.log(data);
      $('#supplier_form')[0].reset();
      $('#supplierModal').modal('hide');
      $('#results_ajax').html(data);
      $('#supplier_data').DataTable().ajax.reload();
        
      clearSupplier();
    }
  });
}

function changeSupplierStatus(id_supplier, status){

  bootbox.confirm("¿Are you sure?", function(result){
    if(result){
      $.ajax({
        url:"../ajax/supplier.php?op=changestatus",
        method:"POST",
        data:{id_supplier:id_supplier, status:status},
        success: function(data){
          $('#supplier_data').DataTable().ajax.reload();
        }
      });
    }
  });//bootbox
}

function listSuppliersInPurchases(){
  table_en_purchases=$('#list_suppliers_data').dataTable({
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
        url: '../ajax/supplier.php?op=list_in_purchases',
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
      "order": [[ 0, "desc" ]],//Order
      
      "language": {
          "sProcessing":     "Loading...",
          "sLengthMenu":     "Show _MENU_ registers",
          "sZeroRecords":    "No results found",
          "sEmptyTable":     "No data available",
          "sInfo":           "Showing a total of _TOTAL_ registers",
          "sInfoEmpty":      "Showing a total of 0 registers",
          "sInfoFiltered":   "(filtered from a total of de _MAX_ registers)",
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
              "sSortAscending":  ": Sort by ascending order",
              "sSortDescending": ": Sort by descending order"
          }
      }
         
  }).DataTable();
}

 
// Autocomplete supplier data in purchases
function add_supplier_register(id_supplier,status){
  $.ajax({
    url:"../ajax/supplier.php?op=search_supplier",
    method:"POST",
    data:{id_supplier:id_supplier,status:status},
    dataType:"json",
    success:function(data){
      if(data.status){

        $('#supplierModal').modal('hide');
        $('#idnumber').val(data.idnumber);
        $('#corporate_name').val(data.corporate_name);
        $('#address').val(data.address);
        $('#datepicker').val(data.fecha);
        $('#id_supplier').val(id_supplier);

      } else{
            bootbox.alert(data.error);
      } 
    }
  })
}

init();