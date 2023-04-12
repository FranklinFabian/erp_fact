<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>&nbsp;</title>
</head>
<body>

	<table width="100%" border="0">
		<tr>
			<td align="center" width="60%"><h2>COMPROBANTE DE INGRESO: <?php //echo $configuracion['nombre_almacen'];?></h2></td>
			<td align="right" width="40%"><table border="1"><tr><td align="center"><h4>N°: <?php echo $detalle['id_nro_adquisicion'];?></h4></td></tr></table></td>
		</tr>		
	</table>
	<br>
	<br>

	<table width="100%" border="0" cellpadding="2">
		<tr>
			<td><strong>Fecha: </strong><?php echo ($detalle['fecha_adquisicion']);?></td>
			<td><strong>Doc. Respaldo: </strong><?php echo $detalle['doc_respaldo'];?></td>
		</tr>
		<tr>
			<td><strong>Proveedor: </strong><?php echo $detalle['proveedor'];?></td>
			<td><strong>N° Doc. Respaldo: </strong><?php echo $detalle['nro_doc_respaldo'];?></td>
		</tr>
		<tr>
			<td><strong>Observaciones: </strong><?php echo $detalle['observacion_general'];?></td>
			<td></td>
		</tr>
	</table>

	<h4 align="center">DETALLE</h4>

	<table width="100%" border="1" cellpadding="2">
		<tr>
			<td width="8%"><strong>N°</strong></td>
			<td width="42%"><strong>PRODUCTO</strong></td>
			<td width="20%"><strong>UNIDAD</strong></td>
			<td width="8%"><strong>CANT.</strong></td>
			<td width="10%"><strong>P/Unid.</strong></td>
			<td width="12%"><strong>Sub Total</strong></td>
		</tr>
		<?php 
		$adquisicion_producto = array();
		$adquisicion_producto = $this->adquisicion_producto_model->get_all_id_nro_adquisicion($detalle['id_nro_adquisicion']);
		$salida='';
		$i=1;
		$sub_total=0;
		$total = 0;
		foreach ($adquisicion_producto as $key => $value) {
			$sub_total=$value['cantidad_ingreso']*$value['precio_adquisicion'];
			$total+=($value['cantidad_ingreso']*$value['precio_adquisicion']);
			$salida.='<tr>
							<td width="8%" align="right">'.$i.'</td>
							<td width="42%">'.($value['nombre_categoria'].'-'.$value['nombre_producto']).'</td>
							<td width="20%">'.$value['unidad_medida'].'</td>
							<td width="8%" align="right">'.((int)$value['cantidad_ingreso']).'</td>
							<td width="10%" align="right">'.(number_format($value['precio_adquisicion'], 2,',','.')).'</td>
							<td width="12%" align="right">'.(number_format($sub_total, 2,',','.')).'</td>
					</tr>';
			$i++;
		}
		$salida.='<tr><td colspan="5" align="right"><strong>TOTAL:</strong></td><td align="right"><strong>'.(number_format($total, 2,',','.')).'</strong></td></tr>';
		echo $salida;
		?>
  	</table>
  	<p></p>
  	<?php 
		$V = new NumeroALetras();
		$con_letra= $V->convertir(floor($total));

		$aux = number_format($total,2);
		$decimal = substr( $aux, strpos($aux, ".")+1 );
		echo '<strong>SON: </strong>'.$con_letra.$decimal.'/100 BOLIVIANO(S)';
  	 ?>
  	 <p></p>
  	 <br>
  	 <p></p>
  	 <br>
  	<table width="100%" border="0">
  		<tr>
  			<td align="center">______________________________</td>
  			<td align="center">______________________________</td>
  		</tr>
  		<tr>
  			<td align="center"><strong>RECIBÍ CONFORME</strong></td>
  			<td align="center"><strong>ENTREGUE CONFORME</strong></td>
  		</tr>
  		<tr>
  			<td align="center"><?php 
  			//$empleado = ;
  			$empleado = $this->empleado_model->get_empleado($detalle['id_empleado']);
  			echo $empleado['nombre'].' '.$empleado['apellido'];
  			?></td>
  			<td align="center"></td>
  		</tr>
  	</table>
</body>
</html>