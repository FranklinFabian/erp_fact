<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"><meta content="<?php echo $this->config->item('producto');?>" name="author" />
  <title><?php echo $title;?></title>
</head>
<style>
    body {
        font-size: 10px;
        font-family: "Tahoma", "Verdana", "Segoe", "sans-serif";
    }
    .redondo table {
    border-collapse:separate;
    border:solid black 1px;
    border-radius:6px;
    -moz-border-radius:6px;
    }

    .redondo-rayas table {
    border-collapse:separate;
    border:solid black 1px;
    border-radius:6px;
    -moz-border-radius:6px;
    }

    .redondo-rayas td, th {
        border:solid #fff 1px;
        
    }
		
	#contenedor {
		display: flex;
		flex-direction: row;
		flex-wrap: wrap;
	}

	#contenedor > div {
		width: 50%;
	}

	#contenedor4 {
		display: flex;
		flex-direction: row;
		flex-wrap: wrap;
	}

	#contenedor4 > div {
		width: 25%;
	}

</style>
<body>
	<!-- CABECERA -->
	<table width=100% border=0>
		<tr>
			<td align="center" width=33%>
				<?php 
					echo $this->config->item('nombre_institucion').'<br>'.$this->config->item('localidad_institucion');
				?>
			</td>
			<td align="center" width=33%>
				<h3>
					ORDEN DE SERVICIO<br>
					ENERGÍA ELÉCTRICA<br>
				</h3>
			</td>
			<td align="right" width=33%>
				<h3>NRO.: <?php  echo $orden['numero'];?></h3>
				<strong>FECHA:</strong> <?php echo ($orden['fecha']);?>
			</td>
			
		</tr>
	</table>
	<hr><!-- FIN CABECERA -->
	
<div class="redondo">
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=12%><strong>CLIENTE:</strong></td><td width=38%> <?php echo $cliente['ci'];?></td> <td width=12%><strong>MEDIDOR:</strong></td><td width=38%> <?php echo $abonado['medidor'];?></td></tr>
		<tr><td width=12%><strong>ABONADO:</strong></td><td width=38%> <?php echo $orden['idabonado'];?></td> <td width=12%><strong>CIRCUITO:</strong></td><td width=38%> <?php echo $centro['centro'];?></td></tr>
		<tr><td width=12%><strong>RAZÓN:</strong></td><td width=38%> <?php echo $cliente['razon_social'];?></td> <td width=12%><strong>POSTE:</strong></td><td width=38%> <?php echo $poste['poste'];?></td></tr>
		<tr><td width=12%><strong>TELÉFONO:</strong></td><td width=38%> <?php echo $cliente['telefono'];?></td> <td width=12%><strong>CATEGORIA:</strong></td><td width=38%> <?php echo $categoria['categoria'];?></td></tr>
		<tr><td width=12%><strong>ZONA:</strong></td><td width=38%> <?php echo $direccion['zona'];?></td> <td width=12%><strong>MEDIDOR:</strong></td><td width=38%> <?php echo $abonado['medidor'];?></td></tr>
		<tr><td width=12%><strong>DIRECCIÓN:</strong></td><td width=38%> <?php echo $cliente['direccion'];?></td> <td width=12%></td></tr>
		<tr><td width=12%><strong>DESCRIPCIÓN:</strong></td><td width=38%> <?php echo $abonado['descripcion'];?></td> <td></td><td></td></tr>
	</table>
</div>

<div class="redondo"><br>
	<table width=100% border=0 cellspacing=0 cellpadding=5>
		<tr><td width=12%><strong>SERVICIO:</strong></td><td width=38%> <?php echo $servicio['descripcion'];?></td> <td width=12%><strong>COSTO:</strong></td><td width=38%> <?php echo $costo['importe'];?></td></tr>
		<tr><td width=12%><strong>NOTA:</strong></td><td width=38%> <?php echo $orden['nota']?></td> <td width=12%><strong>Firma:</strong></td><td width=38%>________________________</td></tr>
		<tr><td width=12%>&nbsp;</td><td width=38%> &nbsp;</td> <td width=12%><strong>Nombre:</strong></td><td width=38%><?php echo $cliente['razon_social']?></td></tr>
		<tr><td width=12%>&nbsp;</td><td width=38%> &nbsp;</td> <td width=12%><strong>Teléfono:</strong></td><td width=38%><?php echo $cliente['telefono']?></td></tr>
	</table>
</div>

<br>

<!--CENTRO-->
<div id="contenedor">
	<div class="redondo">
    <table width=100% cellpadding=5>
			<tr><td width=12%><strong>FECHA 1° RA. VISITA: </strong> _________ _________ _________ <strong>Hrs.:</strong>	_________ _________ </td></tr>
			<tr><td width=12%><strong>FECHA CONCLUSIÓN:</strong> _________ _________ _________ <strong>Hrs.:</strong>	_________ _________ </td></tr>
			<tr><td width=12%><strong>Lectura medidor:</strong> __________________ <strong>Nro. medidor:</strong>	__________________ </td></tr>
			<tr><td width=12%><strong>Nota:</strong> .............................................................<br> </td></tr>
		</table>
  </div>
	
  <div class="redondo">
		<table width=100% cellpadding=5>
			<tr><td><strong>&nbsp; </strong></td><td>&nbsp;</td></tr>
			<tr><td><strong>Código del poste: </strong></td><td>_____________________________________</td></tr>
			<tr><td><strong>Fase: </strong></td><td>_____________________________________</td></tr>
			<tr><td><strong>Distancia: </strong></td><td>_____________________________________</td></tr>
			<tr><td><strong>&nbsp; </strong></td><td>_____________________________________</td></tr>
		</table>
  </div>
</div>
<!-- FIN CENTRO-->




<!-- firmas -->
<div id="contenedor4">
  <div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>Elaborado por</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="center"><?php echo $this->session->userdata('usuario');?></td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>Jefe de Red</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> Nombre:</td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>Técnico</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> Nombre:</td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>Usuario</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> Nombre:</td></tr>
		</table>
	</div>

</div>
<!-- Fin firmas -->

</body>
</html>