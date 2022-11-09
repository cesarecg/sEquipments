<?php
		if (isset($title))
		{
	?>
<!-- Example single danger button -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Sundac Equipment</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Facturas<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="facturas_sundac.php">Facturas Sundac C.A. </a></li>
            <li><a href="facturas_sundac_inc.php">Facturas Sundac INC </a></li>
            <li><a href="facturas_farma.php">Facturas FarmaSmart </a></li>
          </ul>
       </li>
       <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Presupuestos<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="presupuesto_sundac.php">Presupuestos Sundac C.A. </a></li>
            <li><a href="presupuesto_sundac_inc.php">Presupuestos  Sundac INC </a></li>
            <li><a href="presupuesto_farma.php">Presupuestos FarmaSmart </a></li>
          </ul>
       </li>
       <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Notas de Entrega<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="notas_sundac.php">Notas de Entrega Sundac C.A. </a></li>
            <li><a href="notas_sundac_inc.php">Notas de Entrega Sundac INC </a></li>
            <li><a href="notas_farma.php">Notas de Entrega FarmaSmart </a></li>
          </ul>
       </li>
       <li><a href="productos.php">Productos</a></li>
       <li><a href="equipos.php">Equipos</a></li>
       <li><a href="clientes.php">Clientes</a></li>
       <li><a href="perfil.php">Configuración</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
      <li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Cerrar Sesión</a></li>
     
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>