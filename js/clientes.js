		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_clientes.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el cliente")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_clientes.php",
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
		
		
	
$( "#guardar_cliente" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_cliente.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando....");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$("#editar_cliente" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_cliente.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$("#editar_info" ).submit(function( event ) {
$('#actualizar_info').attr("disabled", true);
			
	var parametros = $(this).serialize();
	$.ajax({
					type: "POST",
					url: "ajax/editar_info.php",
					data: parametros,
					beforeSend: function(objeto){
						$("#resultados_ajax3").html("...");
					},
					success: function(datos){
					$("#resultados_ajax3").html(datos);
					$('#actualizar_info').attr("disabled", false);
					load(1);
					}
			  });
			event.preventDefault();
		  })

	function obtener_datos(id){
		
			var nombre_cliente = $("#nombre_cliente"+id).val();
			var telefono_cliente = $("#telefono_cliente"+id).val();
			var rif_cliente = $("#rif_cliente"+id).val();
			var direccion_cliente = $("#direccion_cliente"+id).val();
			var status_cliente = $("#status_cliente"+id).val();
	
			$("#mod_nombre").val(nombre_cliente);	
			$("#mod_telefono").val(telefono_cliente);
			$("#mod_rif").val(rif_cliente);
			$("#mod_direccion").val(direccion_cliente);
			$("#mod_estado").val(status_cliente);
			$("#mod_id").val(id);
		
		}

		function infoCliente(id){
            
			var nombre_contacto = $("#nombre_contacto"+id).val();
			var telefono_contacto = $("#telefono_contacto"+id).val();
			var comentario = $("#comentario"+id).val();
		  

			$("#mod_contacto").val(nombre_contacto);
			$("#mod_telefonoc").val(telefono_contacto);
			$("#mod_com").val(comentario);
			$("#info_id").val(id);
			
		}
		
		

