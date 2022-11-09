<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	/* Connect To Database*/
	include("../../config/db.php");
	include("../../config/conexion.php");
	//Archivo de funciones PHP
	include("../../funciones.php");
	$id_notas= intval($_GET['id_notas']);
	$sql_count=mysqli_query($con,"select * from notas_farma where id_notas='".$id_notas."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Factura no encontrada')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_notas=mysqli_query($con,"select * from notas_farma where id_notas='".$id_notas."'");
	$rw_notas=mysqli_fetch_array($sql_notas);
	$numero_notas=$rw_notas['numero_notas'];
	$id_cliente=$rw_notas['id_cliente'];
	$id_vendedor=$rw_notas['id_vendedor'];
	$fecha_notas=date("d-m-Y", strtotime($rw_notas['fecha_notas']));
	$condiciones=$rw_notas['condiciones'];
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_notas_farma_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output('Notas.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
