<?php

include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$id_notas= $_SESSION['id_notas'];
$numero_notas= $_SESSION['numero_notas'];
if (isset($_POST['id'])){$id=intval($_POST['id']);}
if (isset($_POST['cantidad'])){$cantidad=intval($_POST['cantidad']);}
if (isset($_POST['precio_venta'])){$precio_venta=floatval($_POST['precio_venta']);}

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
if (!empty($id) and !empty($cantidad) and !empty($precio_venta))
{
$insert_tmp=mysqli_query($con, "INSERT INTO detalle_notas_sundac_inc (numero_notas, id_producto,cantidad,precio_venta) VALUES ('$numero_notas','$id','$cantidad','$precio_venta')");

}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_detalle=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM detalle_notas_sundac_inc WHERE id_detalle='".$id_detalle."'");
}
$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
?>
<table class="table">
<tr>
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>DESCRIPCION</th>
	<th class='text-center'>CANT.</th>
	<th class='text-right'>PRECIO UNIT.$</th>
	<th class='text-right'>BOLIVARES</th>
	<th class='text-right'>PRECIO UNIT </th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
<?php
	$moneda= 0;
	$sumador_total=0;
	$sumador_iva=0;
	$precio_total_i=0;
	$sql=mysqli_query($con, "select * from products, notas_sundac_inc, detalle_notas_sundac_inc where notas_sundac_inc.numero_notas=detalle_notas_sundac_inc.numero_notas and notas_sundac_inc.id_notas='$id_notas' and products.id_producto=detalle_notas_sundac_inc.id_producto");
	while ($row=mysqli_fetch_array($sql))
	{
	$id_detalle=$row["id_detalle"];
	$codigo_producto=$row['codigo_producto'];
	$nombre_producto=$row['nombre_producto']; 
	$cantidad=$row['cantidad'];
	$iva1=$row['iva1']; //iva del producto
	$bs=$row['bs'];
	$moneda=$row['moneda'];
	$precio_venta=$row['precio_venta'];

	if($moneda == 0){
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	
	if ($iva1 == 1) {
	$impuesto=get_row('perfil','impuesto','id_perfil', 1);
	$precio_total=($precio_venta_r * $cantidad) * $bs; //Precio total en bs con la cantidad
	$precio_total_i= ($precio_total*$impuesto)/100; //Porcentaje de Impuesto
	
	}else{
		$precio_total=$precio_venta_r * $cantidad * $bs;
		$precio_total_i= 0;
	}
	$precio_unit= $precio_venta * $bs;
	$precio_unit_f= number_format($precio_unit,2);//Formateo variables
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas

	$sumador_iva+=$precio_total_i; // Sumador de Iva por producto
	$sumador_total+=$precio_total_r;//Sumador

		?>
	<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td><?php 
						if($iva1 == 0){
							echo $nombre_producto ." " . "(E)" ; // Especifica si esta Exento de Iva o no
						}else{
							echo $nombre_producto;
						}
			?></td>
			<td class='text-center'><?php echo $cantidad;?></td>
			<td class='text-right'><?php echo $precio_venta_f;?></td> <!--Precio venta -->
			<td class='text-right'><?php echo $bs;?></td>   <!--tasa del dia -->
			<td class='text-right'><?php echo $precio_unit_f;?></td> <!-- Precio Unitario -->
			<td class='text-right'><?php echo $precio_total_f;?></td>  <!--Precio total -->
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_detalle ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php
	} else{

	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	
	if ($iva1 == 1) {
	$impuesto=get_row('perfil','impuesto','id_perfil', 1);
	$precio_total=($precio_venta_r * $cantidad) * $bs; //Precio total en bs con la cantidad
	$precio_total_i= ($precio_total*$impuesto)/100; //Porcentaje de Impuesto
	//$precio_total+= $precio_total_i; // Sumatoria del porcentaje y el precio total #Borrado#
	}else{
		$precio_total=$precio_venta_r * $cantidad;
		$precio_total_i= 0;
	}

	$precio_unit= $precio_venta;
	$precio_unit_f= number_format($precio_unit,1);//Formateo variables
	$precio_total_f=number_format($precio_total,1);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas

	$sumador_iva+=$precio_total_i; // Sumador de Iva por producto
	$sumador_total+=$precio_total_r;//Sumador

		?>
	<tr>
			<td class='text-center'><?php echo $codigo_producto;?></td>
			<td><?php 
						if($iva1==0){
							echo $nombre_producto ." " . "(E)" ; // Especifica si esta Exento de Iva o no
						}else{
							echo $nombre_producto;
						}
			?></td>
			<td class='text-center'><?php echo $cantidad;?></td>
			<td class='text-right'><?php echo $precio_venta_f;?></td> <!--Precio venta -->
			<td class='text-right'><?php echo "no aplica";?></td>   <!--tasa del dia -->
			<td class='text-right'><?php echo $precio_unit_f;?></td> <!-- Precio Unitario -->
			<td class='text-right'><?php echo $precio_total_f;?></td>  <!--Precio total -->
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_detalle ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>		
		<?php

	}
	}
	
	$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);

	$subtotal=number_format($sumador_total,1,'.','');

	
	$total_iva=$precio_total_i;
	$total_iva=number_format($total_iva,1,'.','');

	
	$total_iva=$sumador_iva;
	$total_notas=$subtotal+$total_iva;
	
	$update=mysqli_query($con,"update notas_sundac_inc set total_venta='$total_notas' where id_notas='$id_notas'");
?>
<tr>
	<td class='text-right' colspan=6>SUBTOTAL <?php if($moneda == 0){
													 echo $simbolo_moneda;
													}else
													 echo "$";										 
													 ?></td>
	<td class='text-right'><?php echo number_format($subtotal,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=6>IVA (<?php echo $impuesto;?>)% <?php if($moneda == 0){
													 echo $simbolo_moneda;
													}else
													 echo "$";										 
													 ?></td>
	<td class='text-right'><?php echo number_format($total_iva,2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=6>TOTAL <?php if($moneda == 0){
													 echo $simbolo_moneda;
													}else
													 echo "$";										 
													 ?></td>
	<td class='text-right'><?php echo number_format($total_notas,2);?></td>
	<td></td>
</tr>

</table>