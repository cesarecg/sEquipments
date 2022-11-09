$(document).ready(function(){
    load(1);
    
});

function load(page){
    var q= $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'./ajax/buscar_notas_farma.php?action=ajax&page='+page+'&q='+q,
         beforeSend: function(objeto){
         $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
            $('[data-toggle="tooltip"]').tooltip({html:true}); 
            
        }
    })
}



    function eliminar (id)
{
    var q= $("#q").val();
if (confirm("Realmente deseas eliminar la nota?")){	
$.ajax({
type: "GET",
url: "./ajax/buscar_notas_farma.php",
data: "id="+id,"q":q,
 beforeSend: function(objeto){
    $("#resultados").html("Mensaje: Cargando....");
  },
success: function(datos){
$("#resultados").html(datos);
load(1);
}
    });
}
}

function imprimir_notas(id_notas){
    VentanaCentrada('./pdf/documentos/ver_notas_farma.php?id_notas='+id_notas,'notas','','1024','768','true');
}
