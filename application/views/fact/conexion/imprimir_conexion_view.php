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

	#contenedor3 {
		display: flex;
		flex-direction: row;
		flex-wrap: wrap;
	}

	#contenedor3 > div {
		width: 33%;
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
					NUEVA CONEXIÓN<br>
					ENERGÍA ELÉCTRICA<br>
				</strong>
			</td>
			<td align="right" width=33%>
				<strong>NRO.: <?php  echo $conexion['numero'];?></strong><br>
				<strong>FECHA:</strong> <?php echo ($orden['fecha']);?>
			</td>
			
		</tr>
	</table>
	<hr><!-- FIN CABECERA -->
	
<div class="redondo">
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=70%><strong>ABONADO:</strong> <?php echo $orden['idabonado'];?> &nbsp;&nbsp;&nbsp;&nbsp;<strong>CIRCUITO:</strong> <?php echo $centro['centro'];?> &nbsp;&nbsp;&nbsp;&nbsp;<strong>POSTE:</strong> <?php echo $poste['poste'];?> </td><td width=30%><strong>CATEGORIA:</strong> <?php echo $categoria['categoria'];?></td></tr>
		<tr><td width=70%><strong>RAZÓN:</strong> <?php echo $cliente['razon_social'];?> </td><td width=30%><strong>MEDIDOR:</strong> <?php echo $abonado['medidor'];?></td></tr>
		<tr><td width=70%><strong>DIRECCIÓN:</strong> <?php echo $cliente['direccion'];?> </td><td width=30%><strong>TELEFONO:</strong> <?php echo $cliente['telefono'];?></td></tr>
	</table>
</div>

<!--CENTRO-->

<div id="contenedor">
	<div class="redondo">
	<strong>INSPECCIÓN TÉCNICA</strong>
    <table width=100% cellpadding=3>
			<tr><td width=12%><strong>Número de inspección: </strong> <?php echo $orden['numero'];?> </td></tr>
			<tr><td width=12%><strong>Fecha hora solicitud:</strong>  <?php echo ($orden['fecha']);?> </td></tr>
			<tr><td width=12%><strong>Fecha fin inspección:</strong>  <?php echo ($orden['fecha_final']);?> </td></tr>
			<tr><td width=12%><strong>Tiempo tramite:</strong>  <?php echo $orden['tiempo_tramite'].' Días';?> </td></tr>
			<tr><td width=12%><strong>Nota:</strong>  <?php echo $conexion['nota'];?> </td></tr>
			<tr><td width=12%><strong>Costo del servicio:</strong>   </td></tr>
		</table>
    <table width=100% cellpadding=3>
			<tr><td width=12%><strong>DIRECCIÓN Y UBICACIÓN: </strong> </td></tr>
			<tr><td width=12%><strong>Circuito:</strong>  ................................................ </td></tr>
			<tr><td width=12%><strong>Zona:</strong>  ................................................ </td></tr>
			<tr><td width=12%><strong>Calle:</strong>  ................................................ </td></tr>
			<tr><td width=12%><strong>Poste:</strong>  ........................... FASE [ &nbsp; &nbsp; ] R [ &nbsp; &nbsp; ] S [ &nbsp; &nbsp; ]  T [ &nbsp; &nbsp; ]</td></tr>
		</table>
	</div>

  <div class="redondo">
	<strong>CONEXIÓN DEL SERVICIO</strong>
		<table width=100% cellpadding=3>
		<tr><td><strong>Fecha instalación: </strong>____________</td><td><strong>Hora:</strong>____________</td></tr>
		<tr><td><strong>Medidor: </strong><?php echo $abonado['medidor']?></td><td><strong>Nivel de tensión:</strong></td></tr>
		<tr><td><strong>Lectura inicial: </strong>____________</td><td>[ &nbsp;&nbsp;&nbsp; ] BAJA TENSIÓN</td></tr>
		<tr><td><strong>Potencia solicitada: </strong>____________</td><td>[ &nbsp;&nbsp;&nbsp; ] MEDIA TENSIÓN</td></tr>
		<tr><td><strong>Factor multiplicador: </strong>____________</td><td><strong>Tipo de conexión</strong></td></tr>
		<tr><td><strong>Obs.: </strong></td><td>[ &nbsp;&nbsp;&nbsp; ] MONOFASICO</td></tr>
		<tr><td> &nbsp; </td><td>[ &nbsp;&nbsp;&nbsp; ] TRIFASICO</td></tr>
		<tr><td> &nbsp; </td><td> </td></tr>
		<tr><td> &nbsp; </td><td> </td></tr>
		<tr><td align="center">_____________________________</td><td align="center">_____________________________</td></tr>
		<tr><td align="center">Técnico</td><td align="center">Ayudante</td></tr>
		</table>
  </div>
</div>
<!-- FIN CENTRO-->


<!-- firmas -->
<div id="contenedor3">
  <div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>FIRMA DE CONFORMIDAD</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="center"><?php echo $conexion['solicitante'];?></td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>JEFE TÉCNICO</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> &nbsp; </td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>PROCESO INFORMÁTICO</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> &nbsp; </td></tr>
		</table>
	</div>
</div>
<!-- Fin firmas -->

</body>
</html>