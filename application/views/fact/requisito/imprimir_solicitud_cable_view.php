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
					SOLICITUD DE TV CABLE
				</h3>
			</td>
			<td align="right" width=33%>
				<strong>REQUISITO NRO.:</strong> <?php  echo $requisito['correlativo'];?><br>
				<strong>FECHA.:</strong> <?php  echo ($requisito['fecha']);?><br>
				<strong>USUARIO.:</strong>
				<?php
					//$usuario = $this->empleado_model->get_empleado($requisito['fecha']);
					echo $requisito['usuario'];
				?>
			</td>
			
		</tr>
	</table>
	<hr><!-- FIN CABECERA -->

<?php
	$cliente = $this->cliente_model->get_cliente($requisito['idcliente']);
	?>
	
<div class="redondo">
	<strong>DATOS DEL SOLICITANTE</strong>
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=70%><strong>RAZÓN SOCIAL:</strong> <?php echo $cliente['razon_social'];?></td> <td width=20%><strong>NIT:</strong> <?php echo $cliente['nit'];?> </td></tr>
		<tr><td width=70%><strong>DOC. IDENTIDAD:</strong> <?php echo $cliente['ci'];?></td> <td width=20%><strong>TELEFONO:</strong> <?php echo $cliente['telefono'];?> </td></tr>
		<tr><td width=70%><strong>DIRECCIÓN:</strong> <?php echo $cliente['direccion'];?></td> <td width=20%> </td></tr>
		<tr><td width=70%><strong>REFERENCIAS:</strong> <?php echo $requisito['referencias'];?></td> <td width=20%> </td></tr>
	</table>
</div>
<br>
	
<div class="redondo">
	<strong>DOCUMENTACIÓN PRESENTADA POR EL USUARIO (Fotocopia)</strong>
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Cédula de identidad</td> <td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] NIT (Nro. de Identificación Tributaria)</td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Plano de lote o croquis de ubicación</td> <td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Folio Real</td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Testimonio de propiedad</td> <td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Otros</td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Documento de compra y venta</td> <td width=50%></td></tr>
	</table>
</div>
<br>
	
<div class="redondo">
	<strong>PERSONA JURIDICA ADEMAS DE LO ANTERIOR ADJUDICA</strong>
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Cédula de identidad</td> <td width=50%></td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Personería Jurídica o A de Constitución</td> <td width=50%></td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Poder notarial del representante legal</td> <td width=50%></td></tr>
	</table>
</div>
<br>
	
<div class="redondo">
	<strong>REQUISITOS TÉCNICOS SOLICITADOS AL CLIENTE</strong>
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Acometida instalada fachada de vivienda</td> <td width=50%></td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Pilote para acometida</td> <td width=50%></td></tr>
	</table>
</div>
<br>
	
<div class="redondo">
	<strong>VERIFICACIÓN</strong>
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Tiene sanciones u observaciones (Plataforma): </td> <td width=50%></td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Tiene deudas pendientess (Plataforma): </td> <td width=50%></td></tr>
	</table>
</div>
<br>
	
<div class="redondo">
	<strong>NOTA.- </strong>
	<table width=100% border=0 cellspacing=0 cellpadding=2>
	<tr><td width=100%>
		El solicitante indica que toda la documentación presentada es copia fiel del original y que no existe adulteración o falsificación, donde se encuentra en tenencia legal del inmueble; siendo la presenta una Declaración Jurada (Decreto Supremo Nro. 26302 art. 6 y siguientes) y en caso de existir alguna falsedad en los documentos y datos brindados COOPELECT R.L. se reserva el derecho de iniciar acciones Administrativas y/o Juridicas por Ley.
		</td></tr>
		<tr><td width=100%> <strong>Fecha de atención: </strong> ______________ de  ______________ de  ______________ Hrs:  ______________ :  ______________</td></tr>
		<tr><td width=100%> <strong>Técnico: </strong> ________________________________________________________</td></tr>
	</table>
</div>
<br>
<!-- Firmas -->
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td width=33% align="center"> <strong>Técnico</strong></td>
			<td width=33% align="center"> <strong>Plataforma</strong></td>
			<td width=33% align="center"> <strong>Cliente</strong></td>
		</tr>
	</table>
<!-- Firmas -->
<br>
<hr>
<table width=100% border=0>
		<tr>
			<td align="center" width=33%>
				<?php 
					echo $this->config->item('nombre_institucion').'<br>'.$this->config->item('localidad_institucion');
				?>
			</td>
			<td align="center" width=33%>
				<h3>
					SOLICITUD DE TV CABLE
				</h3>
			</td>
			<td align="right" width=33%>
				<strong>REQUISITO NRO.:</strong> <?php  echo $requisito['correlativo'];?><br>
				<strong>FECHA.:</strong> <?php  echo ($requisito['fecha']);?><br>
				<strong>USUARIO.:</strong>
				<?php
					//$usuario = $this->empleado_model->get_empleado($requisito['fecha']);
					echo $requisito['usuario'];
				?>
			</td>
			
		</tr>
	</table>

	<div class="redondo">
	<strong>DATOS DEL SOLICITANTE</strong>
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=70%><strong>RAZÓN SOCIAL:</strong> <?php echo $cliente['razon_social'];?></td> <td width=20%><strong>NIT:</strong> <?php echo $cliente['nit'];?> </td></tr>
		<tr><td width=70%><strong>DOC. IDENTIDAD:</strong> <?php echo $cliente['ci'];?></td> <td width=20%><strong>TELEFONO:</strong> <?php echo $cliente['telefono'];?> </td></tr>
		<tr><td width=70%><strong>DIRECCIÓN:</strong> <?php echo $cliente['direccion'];?></td> <td width=20%> </td></tr>
		<tr><td width=70%><strong>REFERENCIAS:</strong> <?php echo $requisito['referencias'];?></td> <td width=20%> </td></tr>
	</table>
</div>
<br>
	
<div class="redondo">
	<strong>DOCUMENTACIÓN PRESENTADA POR EL USUARIO (Fotocopia)</strong>
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Cédula de identidad</td> <td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] NIT (Nro. de Identificación Tributaria)</td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Plano de lote o croquis de ubicación</td> <td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Folio Real</td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Testimonio de propiedad</td> <td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Otros</td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Documento de compra y venta</td> <td width=50%></td></tr>
	</table>
</div>
<br>
<div class="redondo">
	<strong>PERSONA JURIDICA ADEMAS DE LO ANTERIOR ADJUDICA</strong>
	<table width=100% border=0 cellspacing=0 cellpadding=2>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Cédula de identidad</td> <td width=50%></td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Personería Jurídica o A de Constitución</td> <td width=50%></td></tr>
		<tr><td width=50%>[&nbsp;&nbsp;&nbsp;&nbsp;] Poder notarial del representante legal</td> <td width=50%></td></tr>
	</table>
</div>


</body>
</html>