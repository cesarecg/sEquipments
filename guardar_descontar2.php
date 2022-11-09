<?php
//Guardar descontar para Sundac CA

//retirar productos de la base de datos al agregar invoice

		/* Connect To Database */
	
	require_once ("./config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("./config/conexion.php");//Contiene funcion que conecta a la base de datos
	$id_factura=($_GET['id']);
	
	$sql_1=mysqli_query($con, "select * from products, facturas_sundac, detalle_factura_sundac where facturas_sundac.numero_factura=detalle_factura_sundac.numero_factura and facturas_sundac.id_factura='$id_factura' and products.id_producto=detalle_factura_sundac.id_producto");
	while ($row=mysqli_fetch_array($sql_1))
	
	{
	$id_detalle=$row["id_detalle"];
	$id_producto=$row["id_producto"];
	$numero_factura=$row["numero_factura"];
	$cantidad=$row['cantidad'];
	$status=$row['status_producto'];
	$estado_factura=$row['estado_factura'];
	$stock = $row['stock'];
	
	
	if($estado_factura == 1){
	
		$f_stock = $stock - $cantidad;
	
		if ( $f_stock <= 0 ) {
		$stock = 0;
		$status = 0;
		$sql="UPDATE products SET stock ='".$stock."',status_producto= '".$status."' WHERE id_producto='".$id_producto."'";
		$query_update = mysqli_query( $con, $sql );	
		} else {
	
		$status = 1;
		$sql="UPDATE products SET stock ='".$f_stock."',status_producto= '".$status."' WHERE id_producto='".$id_producto."'";
		$query_update = mysqli_query( $con, $sql );
		}
	}
	
	if($estado_factura == 3){
	
		$f_stock = $stock + $cantidad;
		$sql="UPDATE products SET stock ='".$f_stock."',status_producto= '".$status."' WHERE id_producto='".$id_producto."'";
		$query_update = mysqli_query( $con, $sql );
	
	}

	}
	header("location: facturas_sundac.php");
	exit;
		
?>