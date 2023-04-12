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
					echo $this->config->item('nombre_institucion').'<br>'.$this->config->item('localidad_institucion').'<br> USUARIO';
				?>
			</td>
			<td align="center" width=33%>
				<h3>
					INSPECCIÓN TÉCNICA<br>
					ENERGÍA ELÉCTRICA<br>
					NUEVA CONEXIÓN
				</h3>
			</td>
			<td align="right" width=33%>
				<h3>NRO.: <?php  echo $orden['numero'];?></h3>
				<strong>FECHA:</strong> <?php echo ($orden['fecha']);?>
			</td>
			
		</tr>
	</table>
	<!-- FIN CABECERA -->

<div class="redondo">
	<table width=100% border=0 cellspacing=0 cellpadding=3>
		<tr><td width=12%><strong>ABONADO:</strong></td><td width=38%> <?php echo $orden['idabonado'];?></td> <td width=12%><strong>CIRCUITO:</strong></td><td width=38%> <?php echo $centro['centro'];?></td></tr>
		<tr><td width=12%><strong>RAZÓN:</strong></td><td width=38%> <?php echo $cliente['razon_social'];?></td> <td width=12%><strong>POSTE:</strong></td><td width=38%> <?php echo $poste['poste'];?></td></tr>
		<tr><td width=12%><strong>TELÉFONO:</strong></td><td width=38%> <?php echo $cliente['telefono'];?></td> <td width=12%><strong>CATEGORIA:</strong></td><td width=38%> <?php echo $categoria['categoria'];?></td></tr>
		<tr><td width=12%><strong>DIRECCIÓN:</strong></td><td width=38%> <?php echo $cliente['direccion'];?></td> <td width=12%><strong>MEDIDOR:</strong></td><td width=38%> <?php echo $abonado['medidor'];?></td></tr>
		<tr><td width=12%><strong>DESCRIPCIÓN:</strong></td><td width=38%> <?php echo $abonado['descripcion'];?></td> <td></td><td></td></tr>
	</table>
</div>

<div id="contenedor">
  <div class="redondo">
    <table width=100%>
			<tr>
				<td align="center"><strong>SOLICITUD DE INSPECCIÓN</strong></td>
			</tr>
		</table>
  </div>
  <div class="redondo">
	<table width=100%>
			<tr>
			<td align="center"><strong>&nbsp;</strong></td>
			</tr>
		</table>
  </div>
</div>

<!--CENTRO-->
<div id="contenedor">
	<div class="redondo">
    <table width=100% cellpadding=3>
			<tr><td><strong> NOTA:</strong> <?php echo $orden['nota']?></td></tr>
			<tr><td>&nbsp;</td></tr>
		</table>

    <table width=100% cellpadding=3>
			<tr>
				<td align="center"><strong>INSPECCIÓN TÉCNICA</strong></td>
			</tr>
		</table>

    <table width=100% cellpadding=3>
			<tr>
				<td><strong>Fecha: </strong>____________________</td><td><strong>Hora: </strong>____________________</td>
			</tr>
			<tr>
				<td><strong>Requiere ampliación de red: </strong></td><td>__________________________</td>
			</tr>
			<tr>
				<td colspan="2"><strong>Nota: </strong>____________________________________________________</td>
			</tr>
			<tr>
				<td colspan="2">__________________________________________________________</td>
			</tr>
			<tr>
				<td colspan="2"><strong>Fecha límite: </strong>______________________________________________</td>
			</tr>
		</table>

  </div>
	
  <div class="redondo">
		<table width=100% cellpadding=5>
			<tr><td><strong>Circuito: </strong></td><td>_____________________________________</td></tr>
			<tr><td><strong>Zona: </strong></td><td>_____________________________________</td></tr>
			<tr><td><strong>Calle: </strong></td><td>_____________________________________</td></tr>
			<tr><td><strong>Poste: </strong></td><td>_____________________________________</td></tr>
			<tr><td><strong>Varios: </strong></td><td>_____________________________________</td></tr>
			<tr><td><strong>&nbsp; </strong></td><td>_____________________________________</td></tr>
			<tr><td><strong>&nbsp; </strong></td><td>&nbsp;</td></tr>
		</table>
  </div>
</div>
<!-- FIN CENTRO-->

<!-- firmas -->
<div id="contenedor4">
  <div class="redondo">
    <table width=100%>
			<tr><td align="center"><strong>SOLICITANTE</strong></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="center"><?php echo $orden['solicitante'];?></td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><strong>TÉCNICO</strong></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="center">&nbsp;</td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><strong>JEFE TÉCNICO</strong></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="center">&nbsp;</td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><strong>PROCESO INFORMÁTICO</strong></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="center">&nbsp;</td></tr>
		</table>
	</div>

</div>
<!-- Fin firmas -->

</body>
</html>