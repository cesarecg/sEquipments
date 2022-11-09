<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
	background:#2c3e50;
	padding: 4px 4px 4px;
	color:white;
	font-weight:bold;
	font-size:10px;
}
.silver{
	background:white;
	padding: 3px 4px 3px;
}
.clouds{
	background:#ecf0f1;
	padding: 3px 4px 3px;
}
.border-top{
	border-top: solid 1px #bdc3c7;
}
.border-left{
	border-left: solid 1px #bdc3c7;
}
.border-right{
	border-right: solid 1px #bdc3c7;
}
.border-bottom{
	border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}

-->
</style>
         
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
<?php include("encabezado_notas_sundac_inc.php"); ?>

<br>

<h4 align="center" style="position:absolute;top: 115px; ">NOTA DE ENTREGA </h4>
	<table cellspacing="5" align="right" style="position:absolute;top: 196px; width: 50%;">

        <tr> 
			<td style="width: 50%; text-align:center;">
            
             <strong> Fecha de Emisión:</strong> <br><br><?php echo  $fecha_notas;?><br>
             <br>
			 <strong> N/E Nro:  </strong>  <br><br> <?php echo $numero_notas;?>

			</td>
		
        </tr>
    </table>
 
    <table cellspacing="5" align="left" style="position:absolute;top: 190px; width: 100%; font-size: 14px;">
		<tr>
           <td style="width:50%;">
			<?php 
				$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
				$rw_cliente=mysqli_fetch_array($sql_cliente);
				echo "<br> <strong>CLIENTE</strong>: &nbsp; &nbsp;";
				echo $rw_cliente['nombre_cliente'];
				echo "<br> <strong>DOMICILIO FISCAL:</strong>&nbsp;&nbsp;";
				echo $rw_cliente['direccion_cliente'];
				echo "<br> <strong>TELÉFONO: &nbsp;&nbsp;</strong>";
				echo $rw_cliente['telefono_cliente'];
				echo "<br> <strong>RIF: &nbsp;&nbsp;</strong>";
				echo $rw_cliente['rif_cliente'];
				echo "<br>";
			?>
			
		   </td>
        </tr>
        
   
    </table>
    <br>
	<BR>
	<BR>
     
    <table cellspacing="8" style="width: 100%;  text-align: left; font-size: 12px;">
	<tr>
			<th style="width: 8%;text-align:center" class='midnight-blue'>COD</th>
            <th style="width: 50%;text-align:center	" class='midnight-blue'>DESCRIPCION</th>
			<th style="width: 8%;text-align:center" class='midnight-blue'>CANT</th>
            <th style="width: 15%;text-align: center" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 20%;text-align: center" class='midnight-blue'>PRECIO TOTAL</th>
            
            
        </tr>

	
<br>

<?php
$nums=1;
$sumador_total=0;
$sumador_iva=0;
$precio_total_i=0;
$sql=mysqli_query($con, "select * from products, detalle_notas_sundac_inc, notas_sundac_inc where products.id_producto=detalle_notas_sundac_inc.id_producto and detalle_notas_sundac_inc.numero_notas=notas_sundac_inc.numero_notas and notas_sundac_inc.id_notas='".$id_notas."'");

while ($row=mysqli_fetch_array($sql))
	{
	$id_producto=$row["id_producto"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad'];
	$nombre_producto=$row['nombre_producto'];
	$iva1=$row['iva1']; //iva del producto
	$bs=$row['bs'];
	$moneda=$row['moneda'];
	$comentario=$row['comentario'];
	$precio_venta=$row['precio_venta'];
	if ($moneda == 0){
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

	$sumador_iva+=$precio_total_i; // Sumador de Iva por producto
	$sumador_total+=$precio_total_r;//Sumador
	
	if ($nums%2==0){
		$clase="silver";
	} else {
		$clase="silver";
	}
}else{
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	
	
	if ($iva1 == 1) {
	$impuesto=get_row('perfil','impuesto','id_perfil', 1);
	$precio_total=($precio_venta_r * $cantidad); //Precio total en bs con la cantidad
	$precio_total_i= ($precio_total*$impuesto)/100; //Porcentaje de Impuesto
	//$precio_total+= $precio_total_i; // Sumatoria del porcentaje y el precio total #Borrado#
	}else{
		$precio_total=$precio_venta_r * $cantidad;
		$precio_total_i= 0;
	}
	$precio_unit= $precio_venta;
	$precio_unit_f= number_format($precio_unit,2);//Formateo variables
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas

	$sumador_iva+=$precio_total_i; // Sumador de Iva por producto
	$sumador_total+=$precio_total_r;//Sumador
	
	if ($nums%2==0){
		$clase="silver";
	} else {
		$clase="silver";
	}
}
	?>
  
 		<tr>
			<td class='<?php echo $clase;?>' style="width: 8%; text-align: center"><?php echo $codigo_producto;?></td>
			<td class='<?php echo $clase;?>' style="width: 50%; text-align: center"><?php
			
			if($iva1==0){
				echo $nombre_producto ." " . "(E)" ;
			}else{
				echo $nombre_producto;
			}
			
			?></td>
			<td class='<?php echo $clase;?>' style="width: 8%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: center"><?php echo $precio_unit_f;?></td>
            <td class='<?php echo $clase;?>' style="width: 20%; text-align: center"><?php echo $precio_total_f;?></td>
            
        </tr>
		<?php 

	
$nums++;
}
$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);

	$subtotal=number_format($sumador_total,2,'.','');	
	$total_iva=$precio_total_i;
	$total_iva=number_format($total_iva,2,'.','');	
	$total_iva=$sumador_iva;
	$total_notas=$subtotal+$total_iva;
?>
<table cellspacing="1" align="left" style="white-space: pre-wrap; position:absolute;top: 691px; left:10px; width: 100%; font-size:12px;">
<tr>
<td>
<?php 
 echo(nl2br($comentario));
?>
</td>
</tr>
</table>


</table>

<table cellspacing="5" align="right" style=" position:absolute;top: 741px; width: 90%; text-align: right; font-size:18px;">
	
		<tr>
            <td colspan="4" style="width: 65%; text-align: right;">TOTAL <?php if($moneda == 0){
													 echo $simbolo_moneda;
													}else
													 echo "$";										 
													 ?> </td>
            <td style="width: 21%; text-align: center;"> <?php echo number_format($total_notas,2);?></td>
        </tr>
</table>
<table cellspacing="4" align="left" style="position:absolute;top: 819px; width: 90%; text-align: right; font-size:11px;">
		<tr>
            <td colspan="1" style="width :50%; text-align: left;"><strong>Dirección:</strong></td>
						
        </tr>
		<tr>
            <td colspan="1" style="width :50%; text-align: left;">Avenida Francisco de Miranda,</td>
        </tr>
		<tr>
            <td colspan="1" style="width :50%; text-align: left;">Centro Empresarial Miranda, Piso 2,</td>
        </tr>
		<tr>
            <td colspan="1" style="width :50%; text-align: left;">Ofic. 2J. Urb. Los Ruices. Caracas.</td>
        </tr>
		<tr>
            <td colspan="1" style="width :50%; text-align: left;"><strong>Central:</strong> (0212) 232-4423</td>
        </tr>
		<tr>
            <td colspan="1" style="width :50%; text-align: left;"><strong>Email:</strong> info@sundacequipment.com<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	ventas@sundacequipment.com</td>
        </tr>
	
</table>
</page>

