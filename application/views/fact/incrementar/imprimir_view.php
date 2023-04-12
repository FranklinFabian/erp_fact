<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title;?></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<table width="100%" border="0">
		<tr><td align="center"><img src="<?php echo base_url();?>public/img/logo.jpg" width="50"></td></tr>
		<tr><td align="center"><span style="font-style: italic;">Asamblea Legislativa Departamental de Oruro</span></td></tr>
	</table>
	<p></p>
	<table width="100%">
		<tr>
			<td width="33%"></td>
			<td width="33%"></td>
			<td width="33%">
				<table border="1" cellpadding="4" cellspacing="0">
					<tr><td align="center">FORM. SABS - 01</td></tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="33%"></td>
			<td width="33%"></td>
			<td width="33%"></td>			
		</tr>
		<tr>
			<td width="33%"></td>
			<td width="33%"></td>
			<td width="33%">
				<table border="1" cellpadding="4" cellspacing="0">
					<tr><td>N° CORRELATIVO: <strong> <?php echo $orden['id_orden'];?> </strong></td></tr>
				</table>
			</td>
		</tr>
	</table>
	<p></p>		

	<h1 align="center">PEDIDO Y ENTREGA DE MATERIALES</h1>

	<table width="100%" border="1" cellspacing="0" cellpadding="2">
		<tr>
			<td align="center" bgcolor="#cccccc"><strong>N° SOLICITUD</strong></td>
			<td align="center" bgcolor="#cccccc"><strong>FECHA</strong></td>
			<td align="center" bgcolor="#cccccc"><strong>HORA</strong></td>
		</tr>
		<tr>
			<td align="center"><?php echo $orden['contador_sab_1'];?></td>
			<td align="center"><?php echo (substr($orden['fecha_orden'], 0,10));?></td>
			<td align="center"><?php echo substr($orden['fecha_orden'], 10);?></td>
		</tr>
		<tr>
			<td align="center" colspan="4" bgcolor="#cccccc"><strong>ÁREA SOLICITANTE</strong></td>
		</tr>
		<tr>
			<td colspan="4">
				<?php 
					$solicitante = $this->sub_area_model->get_area_sub_area($orden['id_sub_area']);
					echo $solicitante['nombre_area'].' - '.$solicitante['nombre_sub_area'];
				?>
			</td>
		</tr>
	</table>

	<table width="100%" border="1" cellspacing="0" cellpadding="2">
		<tr>
			<td width="10%" rowspan="2" align="center" bgcolor="#cccccc"><strong>ITEM</strong></td>
			<td width="20%" colspan="2" align="center" bgcolor="#cccccc"><strong>CANTIDAD</strong></td>
			<td width="10%" rowspan="2" align="center" bgcolor="#cccccc"><strong>UNIDAD<br>MANEJO</strong></td>
			<td width="60%" rowspan="2" align="center" bgcolor="#cccccc"><strong>DESCRIPCIÓN</strong></td>
		</tr>
		<tr>
			<td align="center" bgcolor="#cccccc"><strong>PEDIDO</strong></td>
			<td align="center" bgcolor="#cccccc"><strong>ENTREGA</strong></td>
		</tr>
		<?php
			$i=1;
			foreach ($items_orden as $key => $value)
			{
				$producto = $this->producto_model->get_producto($value['id_producto']);
				echo '
						<tr>
							<td>'.($i++).'</td>
							<td>'.$value['cantidad'].'</td>
							<td></td>
							<td>'.$producto['unidad_medida'].'</td>
							<td>'.$producto['nombre_producto'].'</td>
						</tr>				
				';
			}
		?>
	</table>

	<table width="100%" border="1" cellspacing="0" cellpadding="2">
		<tr>
			<td align="center" bgcolor="#cccccc"><strong>JUSTIFICACIÓN DEL REQUERIMIENTO</strong></td>
		</tr>
		<tr>
			<td> <?php echo $orden['justificacion']; ?> </td>
		</tr>
	</table>

	<table width="100%" border="1" cellspacing="0" cellpadding="2">
		<tr>
			<td width="33%" align="center" bgcolor="#cccccc"><strong>FIRMA DEL ÁREA SOLICITANTE</strong></td>
			<td width="34%" align="center" bgcolor="#cccccc"><strong>ALMACENES</strong></td>
			<td width="33%" align="center" bgcolor="#cccccc"><strong>AUTORIZACIÓN</strong></td>
		</tr>
		<tr>
			<td height="70" align="center">
				<small>
					Elaborado por: <?php $empleado = $this->empleado_model->get_empleado($orden['id_empleado']); echo $empleado['nombre'].' '.$empleado['apellido']; ?>
				</small>
			</td>
			<td height="70" align="center"></td>
			<td height="70" align="center">
				<p></p>
				<br>
				<p></p>
				<br>
				<p></p>
				<p></p>
				<br>
				<p></p>
				<small>Jefe inmediato superior</small>
			</td>
		</tr>
	</table>
	<table width="100%" border="1" cellspacing="0" cellpadding="2">
		<tr>
			<td><strong>OBSERVACIÓN DE ALMACENES:</strong></td>
		</tr>
	</table>
	<table width="100%" border="1" cellspacing="0" cellpadding="2">
		<tr>
			<td width="50%" align="center" bgcolor="#cccccc"><strong>ALMACENES</strong></td>
			<td width="50%" align="center" bgcolor="#cccccc"><strong>ÁREA SOLICITANTE</strong></td>
		</tr>
		<tr>
			<td height="70"><small>Entregado por:</small></td>
			<td height="70">
				<p><small>Recibido por:</small></p>
				<p><small>Nombre:</small></p>
				<p><small>N° ítem:</small></p>
				<p><small>Firma:</small></p>
			</td>
		</tr>
	</table>
	<p>
		Original: Almacenes <br>
		Copia 1: Unidad solicitante
	</p>

	
</body>
</html>