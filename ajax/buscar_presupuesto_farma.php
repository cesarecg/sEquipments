<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$numero_presupuesto=intval($_GET['id']);
		$del1="delete from presupuesto_farma where numero_presupuesto='".$numero_presupuesto."'";
		$del2="delete from detalle_presupuesto_farma where numero_presupuesto='".$numero_presupuesto."'";
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php
			
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		  $sTable = "presupuesto_farma, clientes, users";
		 $sWhere = "";
		 $sWhere.=" WHERE presupuesto_farma.id_cliente=clientes.id_cliente and presupuesto_farma.id_vendedor=users.user_id";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' or presupuesto_farma.numero_presupuesto like '%$q%')";
			
		}
		
		$sWhere.=" order by presupuesto_farma.numero_presupuesto desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './presupuesto_farma.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th class='text-center'>#</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Compa??ia</th>
					<th>Estado</th>
					<th class='text-right'>Total</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_presupuesto=$row['id_presupuesto'];
						$numero_presupuesto=$row['numero_presupuesto'];
						$fecha=date("d-m-Y", strtotime($row['fecha_presupuesto']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
						$rif_cliente=$row['rif_cliente'];
						$nombre_vendedor=$row['firstname']." ".$row['lastname'];
						$estado_presupuesto=$row['estado_presupuesto'];
						if ($estado_presupuesto==1){$text_estado="Pagada";$label_class='label-success';}
						elseif($estado_presupuesto==2){$text_estado="Pendiente";$label_class='label-warning';}
						elseif($estado_presupuesto==3){$text_estado="Abonado";$label_class='label-primary';}
						else{$text_estado="Anulado";$label_class='label-danger';}
						$total_venta=$row['total_venta'];
					?>
					<tr>
						<td><?php echo $numero_presupuesto; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><a href="editar_presupuesto_farma.php?id_presupuesto=<?php echo $id_presupuesto;?>" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente;?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $rif_cliente;?>" ><?php echo $nombre_cliente;?></a></td>
						<td><?php echo $nombre_vendedor; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'><?php echo number_format ($total_venta,2); ?></td>					
					<td class="text-right">
						<a href="editar_presupuesto_farma.php?id_presupuesto=<?php echo $id_presupuesto;?>" class='btn btn-default' title='Editar presupuesto' ><i class="glyphicon glyphicon-edit"></i></a> 
						<a href="#" class='btn btn-default' title='Descargar presupuesto' onclick="imprimir_presupuesto('<?php echo $id_presupuesto;?>');"><i class="glyphicon glyphicon-download"></i></a> 
						<a href="#" class='btn btn-default' title='Borrar presupuesto' onclick="eliminar('<?php echo $numero_presupuesto; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>