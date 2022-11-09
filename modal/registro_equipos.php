<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoEquipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" id="clean1" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo equipo</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_equipo" name="guardar_equipo">
			<div id="resultados_ajax_equipos"></div>
			  <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Código</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del equipo" required>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="nombre" name="nombre" placeholder="Nombre del equipo" required maxlength="255" ></textarea>				  
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="stock" class="col-sm-3 control-label">Imagen del Equipo</label>
				<div class="col-sm-8">
				<input type="file" id="myFile" name="filename">
				</div>
			  </div>
			  <div class="form-group">
				<label for="precio" class="col-sm-3 control-label">Precio de Registro</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio de venta en Dólares" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">
				</div>
			  </div>
			  <div class="form-group">
				<label for="iva" class="col-sm-3 control-label">Carácteristicas</label>
				<div class="col-sm-8">
				 <select class="form-control" id="iva1" name="iva1" required>
					<option value="">-- Selecciona estado de IVA --</option>
					<option value="1">Si</option>
					<option value="0"selected>No</option>
				  </select>
				</div>
			  </div>
			  
			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" id="clean" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>

	<script>
	    $("#clean, #clean1 ").click(function(event) { //Limpiar modal
		$("#guardar_equipo")[0].reset();
                                      });
</script>
	<?php
		}
	?>