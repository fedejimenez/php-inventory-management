var table;
var table_sales;
var table_sales_month;

function init(){
  listSales();
}


function listSales(){
  table=$('#sales_data').dataTable({
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
          url: '../ajax/sale.php?op=search_sales',
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

// See details client-sale
$(document).on('click', '.detail', function(){
  //toma el valor del id
  var sale_number = $(this).attr("id");
  $.ajax({
    url:"../ajax/sale.php?op=see_detail_client_sale",
    method:"POST",
    data:{sale_number:sale_number},
    cache:false,
    dataType:"json",
    success:function(data)
    {
      $("#client").html(data.client);
      $("#sale_number").html(data.sale_number);
      $("#idnumber_client").html(data.idnumber_client);
      $("#address").html(data.address);
      $("#sale_date").html(data.sale_date);
    }, 
    error:function(e){
      console.log(e);
    }
  })
});

// See details sale
$(document).on('click', '.detail', function(){
  //toma el valor del id
  var sale_number = $(this).attr("id");
  $.ajax({
    url:"../ajax/sale.php?op=see_detail_sale",
    method:"POST",
    data:{sale_number:sale_number},
    cache:false,
    //dataType:"json",
    success:function(data){
      // console.log(data)
      $("#details").html(data);
    }, 
    error:function(e){
      console.log(e);
    }
  })
});

function changeSaleStatus(id_sales, sale_number, status){
  bootbox.confirm("Are you sur you want to change the status of this Sale?", function(result){
    if(result){
      $.ajax({
        url:"../ajax/sale.php?op=change_sale_status",
        method:"POST",
        data:{id_sales:id_sales,sale_number:sale_number, status:status},
        cache: false,
        
        success:function(data){
          // console.log(data);
          $('#sales_data').DataTable().ajax.reload();
          $('#sales_date_data').DataTable().ajax.reload();
          $('#sales_date_month_data').DataTable().ajax.reload();
        }
      });
    } 
  });//bootbox
}

     // search sale by date
$(document).on("click","#btn_sale_date", function(){
  var start_date= $("#datepicker").val();
  var end_date= $("#datepicker2").val();
  if(start_date!="" && end_date!=""){
    table_sales= $('#sales_date_data').DataTable({
      "aProcessing": true,
      "aServerSide": true,
      dom: 'Bfrtip',
      buttons: [              
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
              ],
      "ajax":{
              url:"../ajax/sale.php?op=search_sales_date",
              type : "post",
              //dataType : "json",
              data:{start_date:start_date,end_date:end_date},           
              error: function(e){
                console.log(e.responseText);
              },
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
      },//end language
    });
  }
});

// search sale by month
$(document).on("click","#btn_sale_date_month", function(){
  var month= $("#month").val();
  var year= $("#year").val();

  if(month!="" && year!=""){
    var table_sales_month= $('#sales_date_month_data').DataTable({
      "aProcessing": true,
      "aServerSide": true,
      dom: 'Bfrtip',
      buttons: [              
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'pdf'
          ],
      "ajax":{
            url:"../ajax/sale.php?op=search_sales_date_month",
            type : "post",
            data:{month:month,year:year},           
            error: function(e){
              console.log(e.responseText);
            },
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
      },//end language
    });
  }
});

init();