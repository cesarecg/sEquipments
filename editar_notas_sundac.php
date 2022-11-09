<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
		}
	$title="Editar Notas | Sundac C.A.";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	if (isset($_GET['id_notas']))
	{
		$id_notas=intval($_GET['id_notas']);
		$campos="clientes.id_cliente, clientes.nombre_cliente, clientes.telefono_cliente, clientes.rif_cliente, notas_sundac.id_vendedor,notas_sundac.condiciones, notas_sundac.fecha_notas, notas_sundac.estado_notas, notas_sundac.numero_notas, notas_sundac.bs, notas_sundac.moneda,notas_sundac.comentario";
		$sql_notas=mysqli_query($con,"select $campos from notas_sundac, clientes where notas_sundac.id_cliente=clientes.id_cliente and id_notas='".$id_notas."'");
		$count=mysqli_num_rows($sql_notas);
		if ($count==1)
		{
			$rw_notas=mysqli_fetch_array($sql_notas);
			$id_cliente=$rw_notas['id_cliente'];
			$nombre_cliente=$rw_notas['nombre_cliente'];
			$telefono_cliente=$rw_notas['telefono_cliente'];
			$rif_cliente=$rw_notas['rif_cliente'];
			$id_vendedor_db=$rw_notas['id_vendedor'];
			$fecha_notas=date("d-m-Y", strtotime($rw_notas['fecha_notas']));
			$condiciones=$rw_notas['condiciones'];
			$bs=$rw_notas['bs'];
			$moneda=$rw_notas['moneda'];
			$comentario= $rw_notas['comentario'];
			$estado_notas=$rw_notas['estado_notas'];
			$numero_notas=$rw_notas['numero_notas'];
		
				$_SESSION['id_notas']=$id_notas;
				$_SESSION['numero_notas']=$numero_notas;
		}	
		else
		{
			header("location: notas_sundac.php");
			exit;	
		}
	} 
	else 
	{
		header("location: notas_sundac.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Notas </h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
			<form class="form-horizontal" role="form" id="datos_notas_sundac">
				<div class="form-group row">
				  <label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
				  <div class="col-md-2">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required value="<?php echo $nombre_cliente;?>">
					  <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>">	
				  </div>
				  <label for="tel1" class="col-md-1 control-label">Teléfono</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" value="<?php echo $telefono_cliente;?>" readonly>
							</div>

				 
					<label for="rif" class="col-sm-1 control-label">RIF</label>
							<div class="col-sm-2">
								<input type="text" class="form-control input-sm" id="rif" placeholder="Rif" readonly value="<?php echo $rif_cliente;?>">
							</div>

					<label for="moneda" class="col-md-1 control-label">Moneda</label>
							<div class="col-md-2">
								<select class='form-control input-sm' id="moneda" name="moneda">
									<option value="1" <?php if ($moneda==1){echo "selected";}?>>Dólar</option>
									<option value="0" <?php if ($moneda==0){echo "selected";}?>>Bólivar</option>
									</select>
							</div> 
					
				 </div>
						<div class="form-group row">
							<label for="empresa" class="col-md-1 control-label">Compañia</label>
							<div class="col-md-2">
							<select class="form-control input-sm" id="id_vendedor" name="id_vendedor">
									<option value="1"> Sundac Equipment C.A.</option>
								</select>
							</div>
							<label for="tel2" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="fecha_notas" value="<?php echo $fecha_notas;?>" id="fecha_notas">
								<input type="submit" value="Cambiar Fecha">															
							</div>

							<label for="bs" class="col-md-1 control-label">Tasa Diaria</label>
							<div class="col-md-2">
										<input type="text" class="form-control input-sm" name="bs" value="<?php echo $bs; ?>" id=bs>
										<input type="submit" value="Cambiar" name="submit">					
							</div>
						

							<label for="estado" class="col-sm-1 control-label">Estado</label>
							<div class="col-md-2">
								<select class='form-control input-sm' id="estado_notas" name="estado_notas">
								    <option value="3" <?php if ($estado_notas==3){echo "selected";}?>>Anulado</option>
								    <option value="2" <?php if ($estado_notas==2){echo "selected";}?>>Pendiente</option>
									<option value="1" <?php if ($estado_notas==1){echo "selected";}?>>Pagado</option>
								</select>
						<label for="comentario" id="comentario-name" class="col-md-3 control-label">Comentario</label>
							<div class="col-xl-8">
							<textarea id="comentario" class="form-control input-sm" name="comentario" rows="3" ><?php echo $comentario; ?></textarea>
																					
							</div>
							<style>
							#comentario, #comentario-name{
								display:none;
							}
							</style>
						<script>
						$(document).ready(function(){							
							// Set div display to block
							$(".comentario").click(function(){
								$("#comentario").css("display", "block");
								$("#comentario-name").css("display", "block");
							});
						});
						</script>
							</div>				
						</div>				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="submit" class="btn btn-default">
						  <span class="glyphicon glyphicon-refresh"></span> Actualizar datos
						</button>
						<button type="button" class="btn btn-default comentario" >
						 <span class="glyphicon glyphicon-plus"></span> Agregar Comentario
						</button>  
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoCliente">
						 <span class="glyphicon glyphicon-user"></span> Nuevo cliente
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar productos
						</button>
						<button type="button" class="btn btn-default" onclick="imprimir_notas('<?php echo $id_notas;?>')">
						  <span class="glyphicon glyphicon-print"></span> Guardar e Imprimir
						</button>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>
				<div class="editar_notas_sundac" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/editar_notas_sundac.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$(function() {
						$("#nombre_cliente").autocomplete({
							source: "./ajax/autocomplete/clientes.php",
							minLength: 2,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_cliente').val(ui.item.id_cliente);
								$('#nombre_cliente').val(ui.item.nombre_cliente);
								$('#tel1').val(ui.item.telefono_cliente);
								$('#rif').val(ui.item.rif_cliente);
																
								
							 }
						});
						 
						
					});
					
	$("#nombre_cliente" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#rif" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_cliente" ).val("");
							$("#id_cliente" ).val("");
							$("#tel1" ).val("");
							$("#rif" ).val("");
						}
			});	
	</script>

  </body>
</html>