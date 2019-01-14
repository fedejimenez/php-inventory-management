var table;
var table_in_sales;

function init(){
  
  listClient();
  listInSales();

  $("#client_form").on("submit",function(e){
    saveClient(e);  
  })
    
  $("#add_button").click(function(){
      $(".modal-title").text("Add Client");
  });
}

function clearClient(){
  $('#idnumber').val("");
  $('#name').val("");
  $('#lastname').val("");
  $('#phone').val("");
  $('#email').val("");
  $('#address').val("");
  $('#status').val("");
  $('#idnumber_client').val("");
}

function listClient(){
  table=$('#client_data').dataTable({
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
          url: '../ajax/client.php?op=list',
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

function showClient(idnumber_client){
  $.post("../ajax/client.php?op=show",{idnumber_client : idnumber_client}, function(data, status){
    data = JSON.parse(data);
    //alert(data.idnumber);
    console.log(data);
    
    $('#clientModal').modal('show');
    $('#idnumber').val(idnumber_client);
    $('#name').val(data.name);
    $('#lastname').val(data.lastname);
    $('#phone').val(data.phone);
    $('#email').val(data.email);
    $('#address').val(data.address);
    $('#status').val(data.status);
    $('.modal-title').text("Edit Client");
    $('#idnumber_client').val(idnumber_client);
  
  });
}


function saveClient(e){
  e.preventDefault(); 
  var formData = new FormData($("#client_form")[0]);

  $.ajax({
      url: "../ajax/client.php?op=savaandedit",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function(datos){                    
          console.log(datos);
          $('#client_form')[0].reset();
          $('#clientModal').modal('hide');
          $('#results_ajax').html(datos);
          $('#client_data').DataTable().ajax.reload();
      
          clearClient();
      }
  });
}

function changeClientStatus(id_client, status){
  bootbox.confirm("Are you sure you want to change the status?", function(result){
    if(result){
      $.ajax({
        url:"../ajax/client.php?op=changestatus",
        method:"POST",
        data:{id_client:id_client, status:status},
        success: function(data){
          $('#client_data').DataTable().ajax.reload();
        }
      });
    }
  });//bootbox
}


    //Función Listar
function listInSales(){

  table_in_sales=$('#lista_clients_data').dataTable(
  {
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
          url: '../ajax/client.php?op=listar_en_ventas',
          type : "get",
          dataType : "json",            
          error: function(e){
            console.log(e.responseText);  
          }
        },
    "bDestroy": true,
    "responsive": true,
    "bInfo":true,
    "iDisplayLength": 10,//Por cada 10 registros hace una paginación
      "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
      
         
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


//AUTOCOMPLETAR DATOS DEL CLIENTE EN VENTAS
  

    function agregar_registro(id_client,est){

      
    $.ajax({
      url:"../ajax/client.php?op=buscar_client",
      method:"POST",
      data:{id_client:id_client,est:est},
      dataType:"json",
      success:function(data)
      {
               
             
            /*si el client esta activo entonces se ejecuta, de lo contrario 
            el formulario no se envia y aparecerá un mensaje */
            if(data.status){

        $('#modalClient').modal('hide');
        $('#idnumber').val(data.idnumber_client);
        $('#name').val(data.name);
        $('#lastname').val(data.lastname);
        $('#address').val(data.address);
        $('#id_client').val(id_client);
        

            } else{
                
                bootbox.alert(data.error);
                


             } //cierre condicional error

                        
        
      }
    })
  
    }



init();