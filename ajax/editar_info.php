<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['info_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_contacto'])) {
           $errors[] = "Nombre vacío";
		}  else if (
			!empty($_POST['info_id']) &&
			$_POST['mod_contacto']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_contacto"],ENT_QUOTES)));
		$telefonoc=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telefonoc"],ENT_QUOTES)));
		$comentario=mysqli_real_escape_string($con,(strip_tags($_POST["mod_com"],ENT_QUOTES)));
	
		
		$id_cliente=intval($_POST['info_id']);
		$sql="UPDATE clientes SET nombre_contacto='".$nombre."', telefono_contacto='".$telefonoc."', comentario='".$comentario."' WHERE id_cliente='".$id_cliente."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Cliente ha sido actualizado satisfactoriamente.";
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