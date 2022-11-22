<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
		}

	$title="Editar Factura | Sundac C.A.";
	
	/* Connect To Database */
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	if (isset($_GET['id_factura']))
	{
		$id_factura=intval($_GET['id_factura']);
		$campos="clientes.id_cliente, clientes.nombre_cliente, clientes.telefono_cliente, clientes.rif_cliente, facturas_sundac.id_vendedor,facturas_sundac.condiciones, facturas_sundac.fecha_factura, facturas_sundac.estado_factura, facturas_sundac.numero_factura, facturas_sundac.bs, facturas_sundac.moneda,facturas_sundac.comentario";
		$sql_factura=mysqli_query($con,"select $campos from facturas_sundac, clientes where facturas_sundac.id_cliente=clientes.id_cliente and id_factura='".$id_factura."'");
		$count=mysqli_num_rows($sql_factura);
		if ($count==1)
		{
			$rw_factura=mysqli_fetch_array($sql_factura);
			$id_cliente=$rw_factura['id_cliente'];
			$nombre_cliente=$rw_factura['nombre_cliente'];
			$telefono_cliente=$rw_factura['telefono_cliente'];
			$rif_cliente=$rw_factura['rif_cliente'];
			$id_vendedor_db=$rw_factura['id_vendedor'];
			$fecha_factura=date("d-m-Y", strtotime($rw_factura['fecha_factura']));
			$condiciones=$rw_factura['condiciones'];
			$bs=$rw_factura['bs'];
			$moneda=$rw_factura['moneda'];
			$comentario= $rw_factura['comentario'];
			$estado_factura=$rw_factura['estado_factura'];
			$numero_factura=$rw_factura['numero_factura'];
		
				$_SESSION['id_factura']=$id_factura;
				$_SESSION['numero_factura']=$numero_factura;
		}	
		else
		{
			header("location: facturas_sundac.php");
			exit;	
		}
	} 
	else 
	{
		header("location: facturas_sundac.php");
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
			<h4><i class='glyphicon glyphicon-edit'></i> Editar Factura Sundac C.A.</h4>
		</div>
		<div class="panel-body">
		<?php 
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");	
		?>
			<form class="form-horizontal" role="form" id="datos_factura_sundac">
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
									<option value="1"> Sundac Equipment C.A</option>
								</select>
							</div>
							<label for="tel2" class="col-md-1 control-label">Fecha</label>
							<div class="col-md-2">
								<input type="text" class="form-control input-sm" name="fecha_factura" value="<?php echo $fecha_factura;?>" id="fecha_factura">
								<input type="submit" value="Cambiar Fecha">															
							</div>

							<label for="bs" class="col-md-1 control-label">Tasa Diaria</label>
							<div class="col-md-2">
										<input type="text" class="form-control input-sm" name="bs" value="<?php echo $bs; ?>" id=bs>
										<input type="submit" value="Cambiar" name="submit">					
							</div>
						

							<label for="estado" class="col-sm-1 control-label">Estado</label>
							<div class="col-md-2">
								<select class='form-control input-sm' id="estado_factura" name="estado_factura">

								    <option value="4" <?php if ($estado_factura==4){echo "selected";}?>>Anulado</option>
									<option value="3" <?php if ($estado_factura==3){echo "selected";}?>>Abonado</option>
								    <option value="2" <?php if ($estado_factura==2){echo "selected";}?>>Pendiente</option>
									<option value="1" <?php if ($estado_factura==1){echo "selected";}?>>Pagado</option>

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
						<a href="./guardar_descontar2.php?id=<?php echo urlencode($id_factura);?>">
						<button type="button" class="btn btn-default" onclick="imprimir_factura('<?php echo $id_factura;?>');">
						  <span class="glyphicon glyphicon-print"></span> Guardar e Imprimir
						</button>
						</a>
					</div>	
				</div>
			</form>	
			<div class="clearfix"></div>
				<div class="editar_factura_sundac" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/editar_factura_sundac.js"></script>
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