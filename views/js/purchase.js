var table;
var table_in_purchases;
var table_purchases_montth;

function init(){
    listPurchases();
}

  
function listPurchases(){
  table=$('#purchases_data').dataTable({
    "aProcessing": true,//Activamos el procesamiento del datatables
      "aServerSide": true,//Paginación y filtrado realizados por el servidor
      dom: 'Bfrtip',//Definimos los elementos del control de table
      buttons: [              
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
    "ajax":
        {
          url: '../ajax/purchase.php?op=search_purchases',
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

// see details supplier - purchase
$(document).on('click', '.detail', function(){
  var purchase_number = $(this).attr("id");

  $.ajax({
    url:"../ajax/purchase.php?op=see_detail_supplier_purchase",
    method:"POST",
    data:{purchase_number:purchase_number},
    cache:false,
    dataType:"json",
    success:function(data)
    {
      // console.log(data);
      $("#supplier").html(data.supplier);
      $("#purchase_number").html(data.purchase_number);
      $("#idnumber_supplier").html(data.idnumber_supplier);
      $("#address").html(data.address);
      $("#purchase_date").html(data.purchase_date);
    },
    error:function(e){
      console.log(e);
    }
  })
});


// see detail purchase
$(document).on('click', '.detail', function(){
  var purchase_number = $(this).attr("id");

  $.ajax({
    url:"../ajax/purchase.php?op=see_detail_purchase",
    method:"POST",
    data:{purchase_number:purchase_number},
    cache:false,
    //dataType:"json",
    success:function(data)
    {
      // console.log(data);
      $("#details").html(data);
    }, 
    error:function(e){
      console.log(e);
    }
  })
});

function changePurchaseStatus(id_purchases, purchase_number, status){
  bootbox.confirm("¿Are you sure you want to change the status?", function(result){
    if(result){
      $.ajax({
        url:"../ajax/purchase.php?op=change_purchase_status",
        method:"POST",
        data:{id_purchases:id_purchases,purchase_number:purchase_number, status:status},
        cache: false,
        
        success:function(data){
          //alert(data);
           $('#purchases_data').DataTable().ajax.reload();
           $('#purchases_date_data').DataTable().ajax.reload();
           $('#purchases_date_month_data').DataTable().ajax.reload();
        }
      });
    } // end if
  });//bootbox
}

// show purchase by date
$(document).on("click","#btn_purchase_date", function(){
  var start_date= $("#datepicker").val();
  var end_date= $("#datepicker2").val();

  if(start_date!="" && end_date!=""){
    table_in_purchases= $('#purchases_date_data').DataTable({
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
              url:"../ajax/purchase.php?op=search_purchases_date",
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
          },//end language
          //"scrollX": true
    });
  }//end if dates
});

//****************************************************************
//  date purchase by month
$(document).on("click","#btn_purchase_date_month", function(){

  //var supplier= $("#supplier").val();
  var month= $("#month").val();
  var year= $("#year").val();
  //alert(month);
  //alert(year);
  if(month!="" && year!=""){

    // search purchases by date
    var table_purchases_montth= $('#purchases_date_month_data').DataTable({
          
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
              url:"../ajax/purchase.php?op=search_purchases_date_month",
              type : "post",
              //dataType : "json",
              data:{month:month,year:year},           
              error: function(e){
                console.log(e.responseText);
              },
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
          //"scrollX": true
      });
  }// end if data
});

init();