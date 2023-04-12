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
					CONEXIÓN PARTICULAR<br>
					TV CABLE<br>
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
	<table width=100% border=0 cellspacing=0 cellpadding=1>
		<tr>
			<td width=9%><strong>ABONADO:</strong></td><td width=16%> <?php echo $orden['idabonado'];?></td>
			<td width=9%><strong>CIRCUITO:</strong></td><td width=16%> <?php echo $centro['centro'];?></td>
			<td width=9%><strong>POSTE:</strong></td><td width=16%> <?php echo $poste['poste'];?></td>
			<td width=9%><strong>CATEGORIA:</strong></td><td width=16%> <?php echo $categoria['categoria'];?></td>
		</tr>
		<tr>
			<td width=9%><strong>RAZÓN:</strong></td><td width=16%> <?php echo $cliente['razon_social'];?></td>
			<td width=9%><strong>DIRECCIÓN:</strong></td><td width=16%> <?php echo $cliente['direccion'];?></td>
			<td width=9%><strong>MEDIDOR:</strong></td><td width=16%> <?php echo $abonado['medidor'];?></td>
			<td width=9%><strong>TELÉFONO:</strong></td><td width=16%> <?php echo $cliente['telefono'];?></td>
		</tr>
	</table>
</div>

<div id="contenedor">
  <div class="redondo">
    <table width=100%>
			<tr>
				<td align="center"><h3>INSPECCIÓN TÉCNICA</h3></td>
			</tr>
		</table>
  </div>
  <div class="redondo">
	<table width=100%>
			<tr>
			<td align="center"><h3>CONEXIÓN DEL SERVICIO</h3></td>
			</tr>
		</table>
  </div>
</div>

<!--CENTRO-->
<div id="contenedor">
	<div class="redondo">
    <table width=100% cellpadding=1>
			<tr>
				<td><strong>N° de inspección</strong></td><td>__________________________</td>
			</tr>
			<tr>
				<td><strong>Fecha hora solicitud</strong></td><td>____________ ______________</td>
			</tr>
			<tr>
				<td><strong>Fecha Fin inspección</strong></td><td>____________ ______________</td>
			</tr>
			<tr>
				<td><strong>Tiempo tramite</strong></td><td>__________________________</td>
			</tr>
			<tr>
				<td><strong>Requiere ampliación</strong></td><td>__________________________</td>
			</tr>
			<tr>
				<td><strong>Nota</strong></td><td>__________________________</td>
			</tr>
			<tr>
				<td><strong>Costo del servicio</strong></td><td>__________________________</td>
			</tr>
		</table>
    <table width=100% cellpadding=1>
			<tr>
				<td><strong>DIRECCIÓN Y UBICACIÓN</strong></td><td>__________________________</td>
			</tr>
			<tr>
				<td><strong>Circuito</strong></td><td>__________________________</td>
			</tr>
			<tr>
				<td><strong>Zona</strong></td><td>__________________________</td>
			</tr>
			<tr>
				<td><strong>Calle</strong></td><td>__________________________</td>
			</tr>
			<tr>
				<td><strong>Poste</strong></td><td>__________________________</td>
			</tr>
		</table>

  </div>
	
  <div class="redondo">
	<table width=100% cellpadding=1>
			<tr>
				<td><strong>Fecha instalación</strong></td><td>___________<strong>Hora: </strong> ___________</td>
			</tr>
			<tr>
				<td><strong>Nro. de puntos instalados</strong></td><td>__________________________</td>
			</tr>
			<tr>
				<td><strong>Obs.</strong></td><td>____________________________________________</td>
			</tr>
			<tr>
				<td>&nbsp;</td><td>____________________________________________</td>
			</tr>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center">___________________</td><td align="center">___________________</td>
			</tr>
			<tr>
				<td align="center"><strong>Técnico</strong></td><td align="center"><strong>Ayudante</strong></td>
			</tr>
		</table>
  </div>
</div>
<!-- FIN CENTRO-->

<div id="contenedor">
  <div class="redondo">
    <table width=100%>
			<tr>
				<td align="center"><strong>FIRMA DE CONFORMIDAD</strong></td>
			</tr>
		</table>
    <table width=100% cellpadding=1>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong>Solicitante</strong></td><td><?php echo $cliente['razon_social'];?></td>
			</tr>
			<tr>
				<td><strong>Télefono</strong></td><td><?php echo $cliente['telefono'];?></td>
			</tr>
		</table>
  </div>
  <div class="redondo">
		<table width=100%>
			<tr>
				<td align="center"><strong>CONTROL DE EJECUCIÓN</strong></td>
			</tr>
		</table>
		
		<div id="contenedor">
			<div class="redondo">
				<table width=100% cellpadding=1>
					<tr>
						<td align="center"><strong>GERENTE TÉCNICO</strong></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</div>		
			<div class="redondo">
				<table width=100% cellpadding=1>
					<tr>
						<td align="center"><strong>PROCESO INFORMÁTICO</strong></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</div>		
  	</div>		

  </div>
	
</div>


</body>
</html>