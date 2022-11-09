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
	$id_presupuesto= intval($_GET['id_presupuesto']);
	$sql_count=mysqli_query($con,"select * from presupuesto_sundac_inc where id_presupuesto='".$id_presupuesto."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Presupuesto no encontrado')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_presupuesto=mysqli_query($con,"select * from presupuesto_sundac_inc where id_presupuesto='".$id_presupuesto."'");
	$rw_presupuesto=mysqli_fetch_array($sql_presupuesto);
	$numero_presupuesto=$rw_presupuesto['numero_presupuesto'];
	$id_cliente=$rw_presupuesto['id_cliente'];
	$id_vendedor=$rw_presupuesto['id_vendedor'];
	$fecha_presupuesto=date("d-m-Y", strtotime($rw_presupuesto['fecha_presupuesto']));
	$fecha_vencimiento= date("d-m-Y", strtotime($rw_presupuesto['fecha_vencimiento']));
	$condiciones=$rw_presupuesto['condiciones'];
	$simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_presupuesto_sundac_inc_html.php');
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
        $html2pdf->Output('presupuesto.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
