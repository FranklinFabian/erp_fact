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
			<td width=9%><strong>CLIENTE:</strong></td><td width=16%> <?php echo $cliente['nit'];?></td>
			<td width=9%><strong>ABONADO:</strong></td><td width=16%> <?php echo $abonado['idabonado'];?></td>
			<td width=9%><strong>TELÉFONO:</strong></td><td width=16%> <?php echo $cliente['telefono'];?></td>
			<td width=9%><strong>MEDIDOR:</strong></td><td width=16%> <?php echo $abonado['medidor'];?></td>
		</tr>
		<tr>
			<td width=9%><strong>RAZÓN:</strong></td><td width=16%> <?php echo $cliente['razon_social'];?></td>
			<td width=9%><strong>CIRCUITO:</strong></td><td width=16%> <?php echo $centro['centro'];?></td>
			<td width=9%><strong>POSTE:</strong></td><td width=16%> <?php echo $poste['poste'];?></td>
			<td width=9%><strong>CATEGORIA:</strong></td><td width=16%> <?php echo $categoria['categoria'];?></td>
		</tr>
		<tr>
			<td width=9%><strong>ZONA:</strong></td><td width=16%> <?php echo $direccion['zona'];?></td>
			<td width=9%><strong>CALLE:</strong></td><td width=16%> <?php echo $direccion['calle'];?></td>
			<td width=9%><strong>NRO.:</strong></td><td width=16%> <?php echo $abonado['numero'];?></td>
			<td width=9%><strong>DESCRIPCIÓN:</strong></td><td width=16%> <?php echo $abonado['descripcion'];?></td>
		</tr>
	</table>
</div>

<!--CENTRO-->
<br>
	<div class="redondo">
    <table width=100% cellpadding=1>
			<tr>
				<td width=12%><strong>SERVICIO</strong></td><td width=38%><?php echo $servicio['descripcion'];?></td>
				<td width=12%><strong>COSTO</strong></td><td width=38%><?php echo $costo['importe'];?></td>
			</tr>
			<tr>
				<td width=12%><strong>NOTA</strong></td><td width=38%><?php echo $orden['nota'];?></td>
				<td width=12%><strong>FIRMA</strong></td><td width=38%>__________________________</td>
			</tr>
			<tr>
				<td width=12%>&nbsp;</td><td width=38%></td>
				<td width=12%><strong>NOMBRE</strong></td><td width=38%>__________________________</td>
			</tr>
			<tr>
				<td width=12%>&nbsp;</td><td width=38%></td>
				<td width=12%><strong>TELÉFONO</strong></td><td width=38%>__________________________</td>
			</tr>
		</table>
		<br>
    <table width=100% cellpadding=6>
		<tr>
				<td width=12%><strong>FECHA 1RA VISITA</strong></td><td>_____________ &nbsp;&nbsp;&nbsp; _____________ &nbsp;&nbsp;&nbsp; _____________ <strong>Hrs.</strong> _____________ &nbsp;&nbsp;&nbsp; _____________</td>
			</tr>
			<tr>
				<td width=12%><strong>FECHA CONCLUSIÓN</strong></td><td>_____________ &nbsp;&nbsp;&nbsp; _____________ &nbsp;&nbsp;&nbsp; _____________ <strong>Hrs.</strong> _____________ &nbsp;&nbsp;&nbsp; _____________</td>
			</tr>
			<tr>
				<td width=12%><strong>NRO. CLIENTE: </strong></td><td><?php echo $ncliente['nit'];?></td>
			</tr>
			<tr>
				<td width=12%><strong>RAZÓN SOCIAL: </strong></td><td><?php echo $ncliente['razon_social'];?></td>
			</tr>
		</table>

  </div>
<!-- FIN CENTRO-->

<!-- firmas -->
<div id="contenedor4">
  <div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>ELABORADO POR</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="center"><?php echo $this->session->userdata('usuario');?></td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>JEFE DE RED</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> Nombre:</td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>TÉCNICO</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> Nombre:</td></tr>
		</table>
	</div>

	<div class="redondo">
    <table width=100%>
			<tr><td align="center"><h4>USUARIO</h4></td></tr>
			<tr><td align="center">&nbsp;</td></tr>
			<tr><td align="center">.......................................</td></tr>
			<tr><td align="left"> Nombre:</td></tr>
		</table>
	</div>

</div>
<!-- Fin firmas -->



</body>
</html>