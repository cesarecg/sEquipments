<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$id_presupuesto= $_SESSION['id_presupuesto'];
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['id_cliente'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['id_vendedor'])) {
           $errors[] = "Selecciona el vendedor";
        } else if (empty($_POST['condiciones'])){
			$errors[] = "Selecciona forma de pago";
		} else if (empty($_POST['fecha_vencimiento'])){
			$errors[] = "Introduzca una fecha";
		} else if ($_POST['estado_presupuesto']==""){
			$errors[] = "Selecciona el estado del Presupuesto";
		} else if ($_POST['moneda']==""){
			$errors[] = "Selecciona la moneda";
		} else if ($_POST['bs']==""){
			$errors[] = "Introduzca la tasa del dia";
		} else if (
			!empty($_POST['id_cliente']) &&
			!empty($_POST['id_vendedor']) &&
			!empty($_POST['condiciones']) &&
			!empty($_POST['bs']) &&
			!empty($_POST['fecha_vencimiento']) &&
			$_POST['estado_presupuesto']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$id_cliente=intval($_POST['id_cliente']);
		$id_vendedor=intval($_POST['id_vendedor']);
		$condiciones=intval($_POST['condiciones']);
		$fecha_vencimiento = $_POST['fecha_vencimiento'];
		$estado_presupuesto=intval($_POST['estado_presupuesto']);
		$bs=$_POST['bs'];
		$moneda=intval($_POST['moneda']);
		$comentario= $_POST['comentario'];
		$comentario = mysqli_real_escape_string($con, $comentario);
		$fecha_vencimiento = date('Y-m-d H:i:s', strtotime($fecha_vencimiento));

		$sql="UPDATE presupuesto_sundac_inc SET id_cliente='".$id_cliente."', id_vendedor='".$id_vendedor."', condiciones='".$condiciones."', estado_presupuesto='".$estado_presupuesto."',fecha_vencimiento='".$fecha_vencimiento."',bs='".$bs."',moneda='".$moneda."', comentario='".$comentario."' WHERE id_presupuesto='".$id_presupuesto."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Presupuesto ha sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
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