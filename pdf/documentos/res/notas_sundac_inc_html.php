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
}
-->
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
<?php include("encabezado_notas_sundac_inc.php"); ?>
<br>

<h4 align="center" style="position:absolute;top: 110px; ">NOTA DE ENTREGA </h4>
	<table cellspacing="5" align="right" style="position:absolute;top: 196px; width: 50%;">

        <tr> 
			<td style="width: 50%; text-align:center;">
            
             <strong> Fecha de Emisión:</strong> <?php echo $date=date("d-m-Y");?><br>
             <br>
			 <strong> N/E Nro:  </strong> <?php echo $numero_notas;?>

			</td>
		
        </tr>
    </table>
	
    <table cellspacing="5" align="left" style="position:absolute;top: 190px; width: 100%; font-size: 14px;">
		<tr>
           <td style="width:50%;" >
			<?php 
				$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
				$rw_cliente=mysqli_fetch_array($sql_cliente);
				echo "<br> <strong>CLIENTE:</strong> &nbsp; &nbsp;";
				echo $rw_cliente['nombre_cliente'];
				echo "<br> <strong>DOMICILIO FISCAL:</strong> &nbsp;&nbsp;";
				echo $rw_cliente['direccion_cliente'];
				echo "<br> <strong>TELÉFONO:</strong>  &nbsp;&nbsp;";
				echo $rw_cliente['telefono_cliente'];
				echo "<br> <strong>RIF:</strong>  &nbsp;&nbsp;";
				echo $rw_cliente['rif_cliente'];
				echo "<br>";
			?>
			
		   </td>
        </tr>
        
   
    </table>
    
       <br>
	<br>
  
    <table cellspacing="5" style="width: 100%; text-align: left; font-size: 12px;">
        <tr>
			<th style="width: 8%;text-align:center" class='midnight-blue'>COD</th>
            <th style="width: 50%;text-align:center	" class='midnight-blue'>DESCRIPCION</th>
			<th style="width: 8%;text-align:center" class='midnight-blue'>CANT</th>
            <th style="width: 15%;text-align: center" class='midnight-blue'>PRECIO UNIT.</th>
            <th style="width: 20%;text-align: center" class='midnight-blue'>PRECIO TOTAL</th>
            
        </tr>

<?php
$nums=1;
$sumador_total=0;
$sumador_iva=0;
$precio_total_i=0;
$sql=mysqli_query($con, "select * from products, tmp_notas_sundac_inc where products.id_producto=tmp_notas_sundac_inc.id_producto and tmp_notas_sundac_inc.session_id='".$session_id."'");
while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["id_tmp"];
	$id_producto=$row["id_producto"];
	$codigo_producto=$row['codigo_producto'];
	$cantidad=$row['cantidad_tmp'];
	$iva1=$row['iva1']; //iva del producto
	$nombre_producto=$row['nombre_producto'];
	$precio_venta=$row['precio_tmp'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	if ($nums%2==0){
		$clase="silver";
	} else {
		$clase="silver";
	}
	?>

        <tr>
			<td class='<?php echo $clase;?>' style="width: 8%; text-align: center"><?php echo $codigo_producto;?></td>
            <td class='<?php echo $clase;?>' style="width: 50%; text-align: center"><?php echo $nombre_producto;?></td>
			<td class='<?php echo $clase;?>' style="width: 8%; text-align: center"><?php echo $cantidad; ?></td>
            <td class='<?php echo $clase;?>' style="width: 15%; text-align: center"><?php echo $precio_venta_f;?></td>
            <td class='<?php echo $clase;?>' style="width: 20%; text-align: center"><?php echo $precio_total_f;?></td>
            
        </tr>

	<?php 
	//Insert en la tabla detalle_cotizacion
	$insert_detail=mysqli_query($con, "INSERT INTO detalle_notas_sundac_inc VALUES ('','$numero_notas','$id_producto','$cantidad','$precio_venta_r')");
	
	$nums++;
	}
$impuesto=get_row('perfil','impuesto', 'id_perfil', 1);

	$subtotal=number_format($sumador_total,2,'.','');	
	$total_iva=$precio_total_i;
	$total_iva=number_format($total_iva,2,'.','');
	$total_iva=$sumador_iva;
	$total_notas=$subtotal+$total_iva;
?>
	</table>

	<table cellspacing="5" align="right" style=" position:absolute;top: 741px; width: 90%; font-size:18px;">
	<tr>
            <td colspan="4" style="width: 65%; text-align: right;">TOTAL <?php 
													 echo "$";										 
													 ?> </td>
            <td style="width: 21%; text-align: center;"> <?php echo number_format($total_notas,2);?></td>
        </tr>
</table>
<table cellspacing="4" align="left" style="position:absolute;top: 790px; width: 90%; text-align: right; font-size:14px;">
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

<?php
$date=date("Y-m-d H:i:s");
$iva=0;
$bs=1;
$moneda= 1;
$comentario= "";
$insert=mysqli_query($con,"INSERT INTO notas_sundac_inc VALUES (NULL,'$numero_notas','$date','$id_cliente','$id_vendedor','$condiciones','$total_notas','2','$bs','$moneda','$comentario')");
$delete=mysqli_query($con,"DELETE FROM tmp_notas_sundac_inc WHERE session_id='".$session_id."'");
?>