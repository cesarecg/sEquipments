<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="infoClient" tabindex="-1" role="dialog" aria-labelledby="myInfoLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myInfoLabel"><i class='glyphicon glyphicon-edit'></i> Editar Informacion de Cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_info" name="editar_info">
			<div id="resultados_ajax3"></div>
			  <div class="form-group">
				<label for="mod_contacto" class="col-sm-3 control-label">Persona de contacto</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_contacto" name="mod_contacto" required>
					<input type="hidden" name="info_id" id="info_id">
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_telefonoc" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_telefonoc" name="mod_telefonoc">
				</div>
			  </div>	  
			  <div class="form-group">
				<label for="mod_com" class="col-sm-3 control-label">Comentarios</label>
				<div class="col-sm-8">
				 <textarea class="form-control" id="mod_com" name="mod_com"></textarea>
				</div>
			  </div>
			  
					 		 		 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_info">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>