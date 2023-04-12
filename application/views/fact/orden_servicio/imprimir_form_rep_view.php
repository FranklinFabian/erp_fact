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
				<strong>
					REPOSICIÓN SERVICIO<br>
					<?php
					if($corte['idservicio']==1)
						echo 'ENERGÍA ELÉCTRICA';
					else
						echo 'TV CABLE';
					?>
				</strong>
			</td>
			<td align="right" width=33%>
				<strong>NRO.: <?php  echo $reposicion['numero'];?></strong><br>
				<strong>FECHA:</strong> <?php echo ($reposicion['fecha_pago']);?><br>
				<strong>ELEB.:</strong> <?php echo $reposicion['usuario'];?>
			</td>
			
		</tr>
	</table>
	<!-- FIN CABECERA -->
	
<div class="redondo">
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=12%><strong>CLIENTE:</strong></td><td width=38%> <?php echo $cliente['ci'];?></td> <td width=12%><strong>MEDIDOR:</strong></td><td width=38%> <?php echo $abonado['medidor'];?></td></tr>
		<tr><td width=12%><strong>ABONADO:</strong></td><td width=38%> <?php echo $corte['idabonado'];?></td> <td width=12%><strong>CIRCUITO:</strong></td><td width=38%> <?php echo $centro['centro'];?></td></tr>
		<tr><td width=12%><strong>RAZÓN:</strong></td><td width=38%> <?php echo $cliente['razon_social'];?></td> <td width=12%><strong>POSTE:</strong></td><td width=38%> <?php echo $poste['poste'];?></td></tr>
		<tr><td width=12%><strong>TELÉFONO:</strong></td><td width=38%> <?php echo $cliente['telefono'];?></td> <td width=12%><strong>CATEGORIA:</strong></td><td width=38%> <?php echo $categoria['categoria'];?></td></tr>
		<tr><td width=12%><strong>ZONA:</strong></td><td width=38%> <?php echo $direccion['zona'];?></td> <td width=12%><strong>MEDIDOR:</strong></td><td width=38%> <?php echo $abonado['medidor'];?></td></tr>
		<tr><td width=12%><strong>DIRECCIÓN:</strong></td><td width=38%> <?php echo $cliente['direccion'];?></td> <td width=12%><strong>DESCRIPCIÓN:</strong></td><td width=38%> <?php echo $abonado['descripcion'];?></td></tr>
	</table>
</div>

<div class="redondo">
	<table width=100% border=0 cellspacing=0 cellpadding=4>
		<tr>
			<td width=20%><strong>N° DE CORTE: </strong> <?php echo $reposicion['numero'];?></td>
			<td width=40%><strong>FECHA DE EMISIÓN: </strong><?php echo ($corte['fecha']);?></td>
			<td width=40%><strong>FECHA DE CORTE: </strong><?php echo ($corte['fecha_final']);?></td>
		</tr>
	</table>
</div>

<div class="redondo">
	<table width=100% border=0 cellspacing=0 cellpadding=4>
		<tr><td width=60%><strong>COSTO: </strong> <?php echo $reposicion['costo'];?></td> 																								 <td><br><strong>Firma:</strong>___________________</td></tr>
		<tr><td width=60%><strong>FECHA REPOSICIÓN:</strong> _________ _________ _________ <strong>Hrs.:</strong>	_________ _________ </td><td><strong>Solic.: </strong><?php echo $reposicion['solicitante']?></td></tr>
		<tr><td width=60%><strong>LECTURA MEDIDOR:</strong> ___________________________ </td><td><strong>C.I. : </strong><?php echo $reposicion['ci']?></td></tr>
		<tr><td width=60%><strong>NOTA:</strong> </td><td><strong>Telf.: </strong><?php echo $reposicion['telefono']?></td></tr>
	</table>
</div>

<!-- firmas -->
<div id="contenedor4">
	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><strong>Jefe de Red</strong></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> Nombre:</td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><strong>Técnico</strong></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> Nombre:</td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><strong>Ayudante</strong></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> Nombre:</td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><strong>Procesado</strong></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> Nombre:</td></tr>
		</table>
	</div>

</div>
<!-- Fin firmas -->

</body>
</html>