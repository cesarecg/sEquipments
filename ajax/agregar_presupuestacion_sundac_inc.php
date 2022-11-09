<?php

include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}

	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
if (!empty($id) and !empty($cantidad) and !empty($precio_venta))
{
$insert_tmp=mysqli_query($con, "INSERT INTO tmp_presupuesto_sundac_inc (id_producto,cantidad_tmp,precio_tmp,session_id) VALUES ('$id','$cantidad','$precio_venta','$session_id')");

}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM tmp_presupuesto_sundac_inc WHERE id_tmp='".$id_tmp."'");
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
	$sumador_total=0;
	$iva1=0;
	$sql=mysqli_query($con, "select * from tmp_presupuesto_sundac_inc, products where products.id_producto=tmp_presupuesto_sundac_inc.id_producto and tmp_presupuesto_sundac_inc.session_id='".$session_id."'");
	while ($row=mysqli_fetch_array($sql))
	{
		$id_tmp=$row["id_tmp"];
		$codigo_producto=$row['codigo_producto'];
		$cantidad=$row['cantidad_tmp'];
		$bs=1;
		$iva1=$row['iva1'];
		$nombre_producto=$row['nombre_producto'];
		
		
		$precio_venta=$row['precio_tmp'];
		$precio_venta_f=number_format($precio_venta,2);//Formateo variables
		$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
		
		if ($iva1 == 1) {
		$impuesto=get_row('perfil','impuesto','id_perfil', 1);
		$precio_total=($precio_venta_r * $cantidad) * $bs; //Precio total en bs con la cantidad
		$precio_total_i= ($precio_total*$impuesto)/100; //Porcentaje de Impuesto
		//$precio_total+= $precio_total_i; // Sumatoria del porcentaje y el precio total #Borrado#
		}else{
			$precio_total=$precio_venta_r * $cantidad * $bs;
			$precio_total_i= 0;
		}
		$precio_unit= $precio_venta * $bs;
		$precio_unit_f= number_format($precio_unit,2);//Formateo variables
		$precio_total_f=number_format($precio_total,2);//Precio total formateado
		$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
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
				<td class='text-center'><?php echo$cantidad;?></td>
				<td class='text-right'><?php echo $precio_venta_f;?></td> <!--Precio venta -->
				<td class='text-right'><?php echo $bs;?></td>   <!--tasa del dia -->
				<td class='text-right'><?php echo $precio_unit_f;?></td> <!-- Precio Unitario -->
				<td class='text-right'><?php echo $precio_total_f;?></td>  <!--Precio total -->
				<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
			</tr>		
			<?php
		}
		$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
		$subtotal=number_format($sumador_total,2,'.','');
		if( $iva1 == 1 ){
			$total_iva=$precio_total_i;
		}else{
			$total_iva= 0;
			$precio_total_i=0;
		}
		
		$total_iva=number_format($total_iva,2,'.','');
		
		$total_presupuesto=$subtotal+$total_iva;
	?>
	<tr>
		<td class='text-right' colspan=6>SUBTOTAL <?php echo "$" ;?></td>
		<td class='text-right'><?php echo number_format($subtotal,2);?></td>
		<td></td>
	</tr>
	<tr>
		<td class='text-right' colspan=6>IVA (<?php echo $impuesto;?>)% <?php echo "$";?></td>
		<td class='text-right'><?php echo number_format($total_iva,2);?></td>
		<td></td>
	</tr>
	<tr>
		<td class='text-right' colspan=6>TOTAL <?php echo "$";?></td>
		<td class='text-right'><?php echo number_format($total_presupuesto,2);?></td>
		<td></td>
	</tr>
	
	</table>
	