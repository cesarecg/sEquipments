<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$id_notas= $_SESSION['id_notas'];
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['id_cliente'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['id_vendedor'])) {
           $errors[] = "Selecciona el vendedor";
		} else if (empty($_POST['fecha_notas'])){
			$errors[] = "Introduzca una fecha";
		} else if ($_POST['estado_notas']==""){
			$errors[] = "Selecciona el estado de la Factura";	
		} else if ($_POST['moneda']==""){
			$errors[] = "Selecciona la moneda";		
		} else if ($_POST['bs']==""){
			$errors[] = "Introduzca la tasa del día";
		} else if (
			!empty($_POST['id_cliente']) &&
			!empty($_POST['id_vendedor']) &&
			!empty($_POST['fecha_notas']) &&
			!empty($_POST['bs']) &&
			
			$_POST['estado_notas']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$id_cliente=intval($_POST['id_cliente']);
		$id_vendedor=intval($_POST['id_vendedor']);
		$fecha_notas= $_POST['fecha_notas'];
		$estado_notas=intval($_POST['estado_notas']);
		$bs= $_POST['bs'];
		$moneda=intval($_POST['moneda']);
		$comentario= $_POST['comentario'];
		$comentario = mysqli_real_escape_string($con, $comentario);
	
		

		$fecha_notas = date('Y-m-d H:i:s', strtotime($fecha_notas)); 
		
		$sql="UPDATE notas_farma SET id_cliente='".$id_cliente."', id_vendedor='".$id_vendedor."', estado_notas='".$estado_notas."',fecha_notas='".$fecha_notas."', bs='".$bs."', moneda='".$moneda."', comentario='".$comentario."' WHERE id_notas='".$id_notas."'";
		$query_update = mysqli_query( $con, $sql );
			if ($query_update){
				$messages[] = "La Nota ha sido actualizada satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intente nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>