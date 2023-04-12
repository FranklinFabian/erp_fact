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
	<?php //var_dump($abonado)?>

	<!-- CABECERA -->
	<table width=100% border=0>
		<tr>
			<td align="center" width=100%>
				<strong>
					<?php echo $this->config->item('razonSocial');?><br>
					RESUMEN DE VENTA ENERGIA ELECTRICA
				</strong>
				
			</td>			
		</tr>
	</table>
	<hr>

	<table width=100% border=1 cellspacing=0 cellpadding=0>
		<tr>
		<td><strong>CATEGORIA</strong></td>
		<td><strong>NRO</strong></td>
		<td><strong>CONSUMO</strong></td>
		<td><strong>NETO</strong></td>
		<td><strong>IMPORTE</strong></td>
		<td><strong>DEMANDA</strong></td>
		<td><strong>CONEXIÓN</strong></td>
		<td><strong>RECONEX</strong></td>
		<td><strong>RECARGO</strong></td>
		<td><strong>ASEO</strong></td>
		<td><strong>ALUMB</strong></td>
		<td><strong>AFCOOP</strong></td>
		<td><strong>DEVOLUC</strong></td>
		<td><strong>DIGNIDAD</strong></td>
		<td><strong>LEY1886</strong></td>
		<td><strong>TOTAL</strong></td>
		</tr>
		<tr>
			<td colspan="16" style="font-weight: bold;">1 RESIDENCIAL</td>
		</tr>
		<tr><!--RESIDENCIAL 000_020-->
			<td>De 000 - 020 kwh</td>
			<td align="right">
				<?php
					$res_000_020 = $this->reporte_model->get_000_020($periodo['idperiodo']);
					echo number_format(count($res_000_020),2,',','.');
				?>
			</td>
			<td align="right">
				<?php
				$consumo_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$consumo_0_020+= $value['kwh'];
				echo number_format($consumo_0_020, 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$importe_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$importe_0_020+= $value['imp_total'];
				echo number_format(($importe_0_020*0.87), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				echo number_format($importe_0_020, 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php echo number_format(0, 2, ',', '.');?>
			</td>
			<td align="right">
				<?php
				$conexion_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$conexion_0_020+= $value['conexion'];
				echo number_format(($conexion_0_020), 2, ',', '.');
				?>
			<td align="right">
				<?php
				$re_conexion_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$re_conexion_0_020+= $value['reposicion'];
				echo number_format(($re_conexion_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$recargo_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$recargo_0_020+= $value['recargo'];
				echo number_format(($recargo_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$aseo_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$aseo_0_020+= $value['aseo'];
				echo number_format(($aseo_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$alumbrado_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$alumbrado_0_020+= $value['alumbrado'];
				echo number_format(($alumbrado_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$afcoop_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$afcoop_0_020+= $value['afcoop'];
				echo number_format(($afcoop_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$devolucion_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$devolucion_0_020+= $value['devolucion'];
				echo number_format(($devolucion_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$dignidad_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$dignidad_0_020+= $value['dignidad'];
				echo number_format(($dignidad_0_020), 2, ',', '.');
				?>
			<td align="right">
				<?php
				$ley1886_0_020=0;
				foreach ($res_000_020 as $key => $value)
					$ley1886_0_020+= $value['ley1886'];
				echo number_format(($ley1886_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$total_0_020=($importe_0_020+$conexion_0_020+$re_conexion_0_020+$recargo_0_020+$alumbrado_0_020+$aseo_0_020+$afcoop_0_020 - $devolucion_0_020);
				echo number_format(($total_0_020), 2, ',', '.');
				?>
			</td>
		</tr><!-- FIN RESIDENCIAL 000_020-->

		<tr><!--RESIDENCIAL 021_100-->
<td>De 021 - 100 kwh</td>
<td align="right">
  <?php
    $res_021_100 = $this->reporte_model->get_021_100($periodo['idperiodo']);
    echo number_format(count($res_021_100),2,',','.');
  ?>
</td>
<td align="right">
  <?php
  $consumo_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $consumo_21_100+= $value['kwh'];
  echo number_format($consumo_21_100, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $importe_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $importe_21_100+= $value['imp_total'];
  echo number_format(($importe_21_100*0.87), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  echo number_format($importe_21_100, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right">
  <?php
  $conexion_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $conexion_21_100+= $value['conexion'];
  echo number_format(($conexion_21_100), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $re_conexion_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $re_conexion_21_100+= $value['reposicion'];
  echo number_format(($re_conexion_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $recargo_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $recargo_21_100+= $value['recargo'];
  echo number_format(($recargo_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $aseo_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $aseo_21_100+= $value['aseo'];
  echo number_format(($aseo_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $alumbrado_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $alumbrado_21_100+= $value['alumbrado'];
  echo number_format(($alumbrado_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $afcoop_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $afcoop_21_100+= $value['afcoop'];
  echo number_format(($afcoop_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $devolucion_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $devolucion_21_100+= $value['devolucion'];
  echo number_format(($devolucion_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $dignidad_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $dignidad_21_100+= $value['dignidad'];
  echo number_format(($dignidad_21_100), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $ley1886_21_100=0;
  foreach ($res_021_100 as $key => $value)
    $ley1886_21_100+= $value['ley1886'];
  echo number_format(($ley1886_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $total_21_100=($importe_21_100+$conexion_21_100+$re_conexion_21_100+$recargo_21_100+$alumbrado_21_100+$aseo_21_100+$afcoop_21_100 - $devolucion_21_100);
  echo number_format(($total_21_100), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN RESIDENCIAL 021_100-->

<tr><!--RESIDENCIAL 101_ade-->
<td>De 100 kwh adelante</td>
<td align="right">
  <?php
    $res_101_ade = $this->reporte_model->get_101_ade($periodo['idperiodo']);
    echo number_format(count($res_101_ade),2,',','.');
  ?>
</td>
<td align="right">
  <?php
  $consumo_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $consumo_101_ade+= $value['kwh'];
  echo number_format($consumo_101_ade, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $importe_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $importe_101_ade+= $value['imp_total'];
  echo number_format(($importe_101_ade*0.87), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  echo number_format($importe_101_ade, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right">
  <?php
  $conexion_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $conexion_101_ade+= $value['conexion'];
  echo number_format(($conexion_101_ade), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $re_conexion_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $re_conexion_101_ade+= $value['reposicion'];
  echo number_format(($re_conexion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $recargo_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $recargo_101_ade+= $value['recargo'];
  echo number_format(($recargo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $aseo_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $aseo_101_ade+= $value['aseo'];
  echo number_format(($aseo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $alumbrado_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $alumbrado_101_ade+= $value['alumbrado'];
  echo number_format(($alumbrado_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $afcoop_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $afcoop_101_ade+= $value['afcoop'];
  echo number_format(($afcoop_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $devolucion_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $devolucion_101_ade+= $value['devolucion'];
  echo number_format(($devolucion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $dignidad_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $dignidad_101_ade+= $value['dignidad'];
  echo number_format(($dignidad_101_ade), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $ley1886_101_ade=0;
  foreach ($res_101_ade as $key => $value)
    $ley1886_101_ade+= $value['ley1886'];
  echo number_format(($ley1886_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $total_101_ade=($importe_101_ade+$conexion_101_ade+$re_conexion_101_ade+$recargo_101_ade+$alumbrado_101_ade+$aseo_101_ade+$afcoop_101_ade - $devolucion_101_ade);
  echo number_format(($total_101_ade), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN RESIDENCIAL 101_ade-->

<tr><!--SUMATORIA RESIDENCIAL-->
<td></td>
<td align="right" style="font-weight: bold;">
  <?php
    echo number_format((count($res_000_020)+count($res_021_100)+count($res_101_ade)),2,',','.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($consumo_0_020 + $consumo_21_100 + $consumo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(( ($importe_0_020*0.87)+($importe_21_100*0.87)+($importe_101_ade*0.87) ), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($importe_0_020 + $importe_21_100 + $importe_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($conexion_0_020 + $conexion_21_100 + $conexion_101_ade), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($re_conexion_0_020 + $re_conexion_21_100 + $re_conexion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($recargo_0_020 + $recargo_21_100 + $recargo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($aseo_0_020 + $aseo_21_100 + $aseo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alumbrado_0_020 + $alumbrado_21_100 + $alumbrado_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($afcoop_0_020 + $afcoop_21_100 + $afcoop_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($devolucion_0_020 + $devolucion_21_100 + $devolucion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($dignidad_0_020 + $dignidad_21_100 + $dignidad_101_ade), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_0_020 + $ley1886_21_100 + $ley1886_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($total_0_020 + $total_21_100 + $total_101_ade), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN SUMATORIA RESIDENCIAL-->

<tr>
			<td colspan="16" style="font-weight: bold;">2 GENERAL</td>
		</tr>
    <tr><!--GENERAL 000_020-->
			<td>De 000 - 020 kwh</td>
			<td align="right">
				<?php
					$gen_000_020 = $this->reporte_model->get_gen_000_020($periodo['idperiodo']);
					echo number_format(count($gen_000_020),2,',','.');
				?>
			</td>
			<td align="right">
				<?php
				$gen_consumo_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_consumo_0_020+= $value['kwh'];
				echo number_format($gen_consumo_0_020, 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$gen_importe_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_importe_0_020+= $value['imp_total'];
				echo number_format(($gen_importe_0_020*0.87), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				echo number_format($gen_importe_0_020, 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php echo number_format(0, 2, ',', '.');?>
			</td>
			<td align="right">
				<?php
				$gen_conexion_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_conexion_0_020+= $value['conexion'];
				echo number_format(($gen_conexion_0_020), 2, ',', '.');
				?>
			<td align="right">
				<?php
				$gen_re_conexion_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_re_conexion_0_020+= $value['reposicion'];
				echo number_format(($gen_re_conexion_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$gen_recargo_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_recargo_0_020+= $value['recargo'];
				echo number_format(($gen_recargo_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$gen_aseo_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_aseo_0_020+= $value['aseo'];
				echo number_format(($gen_aseo_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$gen_alumbrado_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_alumbrado_0_020+= $value['alumbrado'];
				echo number_format(($gen_alumbrado_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$gen_afcoop_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_afcoop_0_020+= $value['afcoop'];
				echo number_format(($gen_afcoop_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$gen_devolucion_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_devolucion_0_020+= $value['devolucion'];
				echo number_format(($gen_devolucion_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$gen_dignidad_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_dignidad_0_020+= $value['dignidad'];
				echo number_format(($gen_dignidad_0_020), 2, ',', '.');
				?>
			<td align="right">
				<?php
				$gen_ley1886_0_020=0;
				foreach ($gen_000_020 as $key => $value)
					$gen_ley1886_0_020+= $value['ley1886'];
				echo number_format(($gen_ley1886_0_020), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$gen_total_0_020=($gen_importe_0_020+$gen_conexion_0_020+$gen_re_conexion_0_020+$gen_recargo_0_020+$gen_alumbrado_0_020+$gen_aseo_0_020+$gen_afcoop_0_020 - $gen_devolucion_0_020);
				echo number_format(($gen_total_0_020), 2, ',', '.');
				?>
			</td>
		</tr><!-- FIN GENERAL 000_020-->

		<tr><!--GENERAL 021_100-->
<td>De 021 - 100 kwh</td>
<td align="right">
  <?php
    $gen_021_100 = $this->reporte_model->get_gen_021_100($periodo['idperiodo']);
    echo number_format(count($gen_021_100),2,',','.');
  ?>
</td>
<td align="right">
  <?php
  $gen_consumo_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_consumo_21_100+= $value['kwh'];
  echo number_format($gen_consumo_21_100, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_importe_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_importe_21_100+= $value['imp_total'];
  echo number_format(($gen_importe_21_100*0.87), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  echo number_format($gen_importe_21_100, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right">
  <?php
  $gen_conexion_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_conexion_21_100+= $value['conexion'];
  echo number_format(($gen_conexion_21_100), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $gen_re_conexion_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_re_conexion_21_100+= $value['reposicion'];
  echo number_format(($gen_re_conexion_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_recargo_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_recargo_21_100+= $value['recargo'];
  echo number_format(($gen_recargo_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_aseo_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_aseo_21_100+= $value['aseo'];
  echo number_format(($gen_aseo_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_alumbrado_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_alumbrado_21_100+= $value['alumbrado'];
  echo number_format(($gen_alumbrado_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_afcoop_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_afcoop_21_100+= $value['afcoop'];
  echo number_format(($gen_afcoop_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_devolucion_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_devolucion_21_100+= $value['devolucion'];
  echo number_format(($gen_devolucion_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_dignidad_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_dignidad_21_100+= $value['dignidad'];
  echo number_format(($gen_dignidad_21_100), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $gen_ley1886_21_100=0;
  foreach ($gen_021_100 as $key => $value)
    $gen_ley1886_21_100+= $value['ley1886'];
  echo number_format(($gen_ley1886_21_100), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_total_21_100=($gen_importe_21_100+$gen_conexion_21_100+$gen_re_conexion_21_100+$gen_recargo_21_100+$gen_alumbrado_21_100+$gen_aseo_21_100+$gen_afcoop_21_100 - $gen_devolucion_21_100);
  echo number_format(($gen_total_21_100), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN GENERAL 021_100-->

<tr><!--GENERAL 101_ade-->
<td>De 100 kwh adelante</td>
<td align="right">
  <?php
    $gen_101_ade = $this->reporte_model->get_gen_101_ade($periodo['idperiodo']);
    echo number_format(count($gen_101_ade),2,',','.');
  ?>
</td>
<td align="right">
  <?php
  $gen_consumo_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_consumo_101_ade+= $value['kwh'];
  echo number_format($gen_consumo_101_ade, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_importe_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_importe_101_ade+= $value['imp_total'];
  echo number_format(($gen_importe_101_ade*0.87), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  echo number_format($gen_importe_101_ade, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right">
  <?php
  $gen_conexion_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_conexion_101_ade+= $value['conexion'];
  echo number_format(($gen_conexion_101_ade), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $gen_re_conexion_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_re_conexion_101_ade+= $value['reposicion'];
  echo number_format(($gen_re_conexion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_recargo_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_recargo_101_ade+= $value['recargo'];
  echo number_format(($gen_recargo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_aseo_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_aseo_101_ade+= $value['aseo'];
  echo number_format(($gen_aseo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_alumbrado_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_alumbrado_101_ade+= $value['alumbrado'];
  echo number_format(($gen_alumbrado_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_afcoop_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_afcoop_101_ade+= $value['afcoop'];
  echo number_format(($gen_afcoop_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_devolucion_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_devolucion_101_ade+= $value['devolucion'];
  echo number_format(($gen_devolucion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_dignidad_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_dignidad_101_ade+= $value['dignidad'];
  echo number_format(($gen_dignidad_101_ade), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $gen_ley1886_101_ade=0;
  foreach ($gen_101_ade as $key => $value)
    $gen_ley1886_101_ade+= $value['ley1886'];
  echo number_format(($gen_ley1886_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $gen_total_101_ade=($gen_importe_101_ade+$gen_conexion_101_ade+$gen_re_conexion_101_ade+$gen_recargo_101_ade+$gen_alumbrado_101_ade+$gen_aseo_101_ade+$gen_afcoop_101_ade - $gen_devolucion_101_ade);
  echo number_format(($gen_total_101_ade), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN GENERAL 101_ade-->

<tr><!--SUMATORIA GENERAL-->
<td></td>
<td align="right" style="font-weight: bold;">
  <?php
    echo number_format((count($gen_000_020)+count($gen_021_100)+count($gen_101_ade)),2,',','.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_consumo_0_020 + $gen_consumo_21_100 + $gen_consumo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(( ($gen_importe_0_020*0.87)+($gen_importe_21_100*0.87)+($gen_importe_101_ade*0.87) ), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_importe_0_020 + $gen_importe_21_100 + $gen_importe_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_conexion_0_020 + $gen_conexion_21_100 + $gen_conexion_101_ade), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_re_conexion_0_020 + $gen_re_conexion_21_100 + $gen_re_conexion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_recargo_0_020 + $gen_recargo_21_100 + $gen_recargo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_aseo_0_020 + $gen_aseo_21_100 + $gen_aseo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_alumbrado_0_020 + $gen_alumbrado_21_100 + $gen_alumbrado_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_afcoop_0_020 + $gen_afcoop_21_100 + $gen_afcoop_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_devolucion_0_020 + $gen_devolucion_21_100 + $gen_devolucion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_dignidad_0_020 + $gen_dignidad_21_100 + $gen_dignidad_101_ade), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_ley1886_0_020 + $gen_ley1886_21_100 + $gen_ley1886_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($gen_total_0_020 + $gen_total_21_100 + $gen_total_101_ade), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN SUMATORIA GENERAL-->

<tr>
			<td colspan="16" style="font-weight: bold;">3 INDUSTRIAL MENOR</td>
		</tr>
    <tr><!--INDUSTRIAL MENOR 000_050-->
			<td>De 000 - 050 kwh</td>
			<td align="right">
				<?php
					$ind_menor_000_050 = $this->reporte_model->get_ind_menor_000_050($periodo['idperiodo']);
					echo number_format(count($ind_menor_000_050),2,',','.');
				?>
			</td>
			<td align="right">
				<?php
				$ind_menor_consumo_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_consumo_0_050+= $value['kwh'];
				echo number_format($ind_menor_consumo_0_050, 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$ind_menor_importe_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_importe_0_050+= $value['imp_total'];
				echo number_format(($ind_menor_importe_0_050*0.87), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				echo number_format($ind_menor_importe_0_050, 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php echo number_format(0, 2, ',', '.');?>
			</td>
			<td align="right">
				<?php
				$ind_menor_conexion_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_conexion_0_050+= $value['conexion'];
				echo number_format(($ind_menor_conexion_0_050), 2, ',', '.');
				?>
			<td align="right">
				<?php
				$ind_menor_re_conexion_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_re_conexion_0_050+= $value['reposicion'];
				echo number_format(($ind_menor_re_conexion_0_050), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$ind_menor_recargo_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_recargo_0_050+= $value['recargo'];
				echo number_format(($ind_menor_recargo_0_050), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$ind_menor_aseo_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_aseo_0_050+= $value['aseo'];
				echo number_format(($ind_menor_aseo_0_050), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$ind_menor_alumbrado_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_alumbrado_0_050+= $value['alumbrado'];
				echo number_format(($ind_menor_alumbrado_0_050), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$ind_menor_afcoop_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_afcoop_0_050+= $value['afcoop'];
				echo number_format(($ind_menor_afcoop_0_050), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$ind_menor_devolucion_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_devolucion_0_050+= $value['devolucion'];
				echo number_format(($ind_menor_devolucion_0_050), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$ind_menor_dignidad_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_dignidad_0_050+= $value['dignidad'];
				echo number_format(($ind_menor_dignidad_0_050), 2, ',', '.');
				?>
			<td align="right">
				<?php
				$ind_menor_ley1886_0_050=0;
				foreach ($ind_menor_000_050 as $key => $value)
					$ind_menor_ley1886_0_050+= $value['ley1886'];
				echo number_format(($ind_menor_ley1886_0_050), 2, ',', '.');
				?>
			</td>
			<td align="right">
				<?php
				$ind_menor_total_0_050=($ind_menor_importe_0_050+$ind_menor_conexion_0_050+$ind_menor_re_conexion_0_050+$ind_menor_recargo_0_050+$ind_menor_alumbrado_0_050+$ind_menor_aseo_0_050+$ind_menor_afcoop_0_050 - $ind_menor_devolucion_0_050);
				echo number_format(($ind_menor_total_0_050), 2, ',', '.');
				?>
			</td>
		</tr><!-- FIN INDUSTRIAL MENOR 000_050-->

<tr><!--INDUSTRIAL MENOR 101_ade-->
<td>De 51 kwh adelante</td>
<td align="right">
  <?php
    $ind_menor_101_ade = $this->reporte_model->get_ind_menor_51_ade($periodo['idperiodo']);
    echo number_format(count($ind_menor_101_ade),2,',','.');
  ?>
</td>
<td align="right">
  <?php
  $ind_menor_consumo_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_consumo_101_ade+= $value['kwh'];
  echo number_format($ind_menor_consumo_101_ade, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_menor_importe_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_importe_101_ade+= $value['imp_total'];
  echo number_format(($ind_menor_importe_101_ade*0.87), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  echo number_format($ind_menor_importe_101_ade, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right">
  <?php
  $ind_menor_conexion_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_conexion_101_ade+= $value['conexion'];
  echo number_format(($ind_menor_conexion_101_ade), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $ind_menor_re_conexion_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_re_conexion_101_ade+= $value['reposicion'];
  echo number_format(($ind_menor_re_conexion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_menor_recargo_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_recargo_101_ade+= $value['recargo'];
  echo number_format(($ind_menor_recargo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_menor_aseo_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_aseo_101_ade+= $value['aseo'];
  echo number_format(($ind_menor_aseo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_menor_alumbrado_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_alumbrado_101_ade+= $value['alumbrado'];
  echo number_format(($ind_menor_alumbrado_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_menor_afcoop_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_afcoop_101_ade+= $value['afcoop'];
  echo number_format(($ind_menor_afcoop_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_menor_devolucion_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_devolucion_101_ade+= $value['devolucion'];
  echo number_format(($ind_menor_devolucion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_menor_dignidad_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_dignidad_101_ade+= $value['dignidad'];
  echo number_format(($ind_menor_dignidad_101_ade), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $ind_menor_ley1886_101_ade=0;
  foreach ($ind_menor_101_ade as $key => $value)
    $ind_menor_ley1886_101_ade+= $value['ley1886'];
  echo number_format(($ind_menor_ley1886_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_menor_total_101_ade=($ind_menor_importe_101_ade+$ind_menor_conexion_101_ade+$ind_menor_re_conexion_101_ade+$ind_menor_recargo_101_ade+$ind_menor_alumbrado_101_ade+$ind_menor_aseo_101_ade+$ind_menor_afcoop_101_ade - $ind_menor_devolucion_101_ade);
  echo number_format(($ind_menor_total_101_ade), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN INDUSTRIAL MENOR 101_ade-->

<tr><!--SUMATORIA INDUSTRIAL MENOR-->
<td></td>
<td align="right" style="font-weight: bold;">
  <?php
    echo number_format((count($ind_menor_000_050)+count($ind_menor_101_ade)),2,',','.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_consumo_0_050 + $ind_menor_consumo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(( ($ind_menor_importe_0_050*0.87)+($ind_menor_importe_101_ade*0.87) ), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_importe_0_050 + $ind_menor_importe_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_conexion_0_050 + $ind_menor_conexion_101_ade), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_re_conexion_0_050 + $ind_menor_re_conexion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_recargo_0_050 + $ind_menor_recargo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_aseo_0_050 + $ind_menor_aseo_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_alumbrado_0_050 + $ind_menor_alumbrado_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_afcoop_0_050 + $ind_menor_afcoop_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_devolucion_0_050 + $ind_menor_devolucion_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_dignidad_0_050 + $ind_menor_dignidad_101_ade), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_ley1886_0_050 + $ind_menor_ley1886_101_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_menor_total_0_050 + $ind_menor_total_101_ade), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN SUMATORIA INDUSTRIAL MENOR-->

<tr>
			<td colspan="16" style="font-weight: bold;">4 INDUSTRIAL MAYOR</td>
		</tr>

<tr><!--INDUSTRIAL mayor 000_ade-->
<td>De 000 kwh adelante</td>
<td align="right">
  <?php
    $ind_mayor_000_ade = $this->reporte_model->get_ind_mayor_000_ade($periodo['idperiodo']);
    echo number_format(count($ind_mayor_000_ade),2,',','.');
  ?>
</td>
<td align="right">
  <?php
  $ind_mayor_consumo_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_consumo_000_ade+= $value['kwh'];
  echo number_format($ind_mayor_consumo_000_ade, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_mayor_importe_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_importe_000_ade+= $value['imp_total'];
  echo number_format(($ind_mayor_importe_000_ade*0.87), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  echo number_format($ind_mayor_importe_000_ade, 2, ',', '.');
  ?>
</td>
<td align="right">
	<?php
  $ind_mayor_demanda_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_demanda_000_ade+= $value['imp_poten'];
  echo number_format(($ind_mayor_demanda_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_mayor_conexion_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_conexion_000_ade+= $value['conexion'];
  echo number_format(($ind_mayor_conexion_000_ade), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $ind_mayor_re_conexion_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_re_conexion_000_ade+= $value['reposicion'];
  echo number_format(($ind_mayor_re_conexion_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_mayor_recargo_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_recargo_000_ade+= $value['recargo'];
  echo number_format(($ind_mayor_recargo_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_mayor_aseo_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_aseo_000_ade+= $value['aseo'];
  echo number_format(($ind_mayor_aseo_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_mayor_alumbrado_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_alumbrado_000_ade+= $value['alumbrado'];
  echo number_format(($ind_mayor_alumbrado_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_mayor_afcoop_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_afcoop_000_ade+= $value['afcoop'];
  echo number_format(($ind_mayor_afcoop_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_mayor_devolucion_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_devolucion_000_ade+= $value['devolucion'];
  echo number_format(($ind_mayor_devolucion_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_mayor_dignidad_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_dignidad_000_ade+= $value['dignidad'];
  echo number_format(($ind_mayor_dignidad_000_ade), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $ind_mayor_ley1886_000_ade=0;
  foreach ($ind_mayor_000_ade as $key => $value)
    $ind_mayor_ley1886_000_ade+= $value['ley1886'];
  echo number_format(($ind_mayor_ley1886_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ind_mayor_total_000_ade=($ind_mayor_importe_000_ade+$ind_mayor_conexion_000_ade+$ind_mayor_re_conexion_000_ade+$ind_mayor_recargo_000_ade+$ind_mayor_alumbrado_000_ade+$ind_mayor_aseo_000_ade+$ind_mayor_afcoop_000_ade - $ind_mayor_devolucion_000_ade);
  echo number_format(($ind_mayor_total_000_ade), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN INDUSTRIAL mayor 101_ade-->

<tr><!--SUMATORIA INDUSTRIAL mayor-->
<td></td>
<td align="right" style="font-weight: bold;">
  <?php
    echo number_format((count($ind_mayor_000_ade)),2,',','.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_consumo_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format((($ind_mayor_importe_000_ade*0.87) ), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_importe_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php echo number_format($ind_mayor_demanda_000_ade, 2, ',', '.');?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_conexion_000_ade), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_re_conexion_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_recargo_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_aseo_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_alumbrado_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_afcoop_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_devolucion_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_dignidad_000_ade), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_ley1886_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ind_mayor_total_000_ade), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN SUMATORIA INDUSTRIAL mayor-->

<tr>
	<td colspan="16" style="font-weight: bold;">5 ALUMBRADO PÚBLICO</td>
</tr>

<tr><!--ALUMBRADO PUBLICO-->
<td>De 000 kwh adelante</td>
<td align="right">
  <?php
    $alum_publi_000_ade = $this->reporte_model->get_alum_publi_000_ade($periodo['idperiodo']);
    echo number_format(count($alum_publi_000_ade),2,',','.');
  ?>
</td>
<td align="right">
  <?php
  $alum_publi_consumo_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_consumo_000_ade+= $value['kwh'];
  echo number_format($alum_publi_consumo_000_ade, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $alum_publi_importe_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_importe_000_ade+= $value['imp_total'];
  echo number_format(($alum_publi_importe_000_ade*0.87), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  echo number_format($alum_publi_importe_000_ade, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right">
  <?php
  $alum_publi_conexion_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_conexion_000_ade+= $value['conexion'];
  echo number_format(($alum_publi_conexion_000_ade), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $alum_publi_re_conexion_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_re_conexion_000_ade+= $value['reposicion'];
  echo number_format(($alum_publi_re_conexion_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $alum_publi_recargo_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_recargo_000_ade+= $value['recargo'];
  echo number_format(($alum_publi_recargo_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $alum_publi_aseo_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_aseo_000_ade+= $value['aseo'];
  echo number_format(($alum_publi_aseo_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $alum_publi_alumbrado_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_alumbrado_000_ade+= $value['alumbrado'];
  echo number_format(($alum_publi_alumbrado_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $alum_publi_afcoop_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_afcoop_000_ade+= $value['afcoop'];
  echo number_format(($alum_publi_afcoop_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $alum_publi_devolucion_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_devolucion_000_ade+= $value['devolucion'];
  echo number_format(($alum_publi_devolucion_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $alum_publi_dignidad_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_dignidad_000_ade+= $value['dignidad'];
  echo number_format(($alum_publi_dignidad_000_ade), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $alum_publi_ley1886_000_ade=0;
  foreach ($alum_publi_000_ade as $key => $value)
    $alum_publi_ley1886_000_ade+= $value['ley1886'];
  echo number_format(($alum_publi_ley1886_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $alum_publi_total_000_ade=($alum_publi_importe_000_ade+$alum_publi_conexion_000_ade+$alum_publi_re_conexion_000_ade+$alum_publi_recargo_000_ade+$alum_publi_alumbrado_000_ade+$alum_publi_aseo_000_ade+$alum_publi_afcoop_000_ade - $alum_publi_devolucion_000_ade);
  echo number_format(($alum_publi_total_000_ade), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN INDUSTRIAL mayor 101_ade-->

<tr><!--SUMATORIA INDUSTRIAL mayor-->
<td></td>
<td align="right" style="font-weight: bold;">
  <?php
    echo number_format((count($alum_publi_000_ade)),2,',','.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_consumo_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format((($alum_publi_importe_000_ade*0.87) ), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_importe_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_conexion_000_ade), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_re_conexion_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_recargo_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_aseo_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_alumbrado_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_afcoop_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_devolucion_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_dignidad_000_ade), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_ley1886_000_ade), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($alum_publi_total_000_ade), 2, ',', '.');
  ?>
</td>
</tr><!-- ALUMBRADO PUBLICO-->

<tr>
	<td colspan="16" style="font-weight: bold;">6 LEY 1886</td>
</tr>

<tr><!--ALUMBRADO PUBLICO-->
<td>Descuento Ley 1886</td>
<td align="right">
  <?php
    $ley1886 = $this->reporte_model->get_ley1886($periodo['idperiodo']);
    echo number_format(count($ley1886),2,',','.');
  ?>
</td>
<td align="right">
  <?php
  $ley1886_consumo=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_consumo+= $value['kwh'];
  echo number_format($ley1886_consumo, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ley1886_importe=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_importe+= $value['imp_total'];
  echo number_format(($ley1886_importe*0.87), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  echo number_format($ley1886_importe, 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right">
  <?php
  $ley1886_conexion=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_conexion+= $value['conexion'];
  echo number_format(($ley1886_conexion), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $ley1886_re_conexion=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_re_conexion+= $value['reposicion'];
  echo number_format(($ley1886_re_conexion), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ley1886_recargo=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_recargo+= $value['recargo'];
  echo number_format(($ley1886_recargo), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ley1886_aseo=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_aseo+= $value['aseo'];
  echo number_format(($ley1886_aseo), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ley1886_alumbrado=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_alumbrado+= $value['alumbrado'];
  echo number_format(($ley1886_alumbrado), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ley1886_afcoop=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_afcoop+= $value['afcoop'];
  echo number_format(($ley1886_afcoop), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ley1886_devolucion=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_devolucion+= $value['devolucion'];
  echo number_format(($ley1886_devolucion), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ley1886_dignidad=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_dignidad+= $value['dignidad'];
  echo number_format(($ley1886_dignidad), 2, ',', '.');
  ?>
<td align="right">
  <?php
  $ley1886_ley1886=0;
  foreach ($ley1886 as $key => $value)
    $ley1886_ley1886+= $value['ley1886'];
  echo number_format(($ley1886_ley1886), 2, ',', '.');
  ?>
</td>
<td align="right">
  <?php
  $ley1886_total=($ley1886_importe+$ley1886_conexion+$ley1886_re_conexion+$ley1886_recargo+$ley1886_alumbrado+$ley1886_aseo+$ley1886_afcoop - $ley1886_devolucion);
  echo number_format(($ley1886_total), 2, ',', '.');
  ?>
</td>
</tr><!-- FIN INDUSTRIAL mayor 101_ade-->

<tr><!--SUMATORIA INDUSTRIAL mayor-->
<td></td>
<td align="right" style="font-weight: bold;">
  <?php
    echo number_format((count($ley1886)),2,',','.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_consumo), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format((($ley1886_importe*0.87) ), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_importe), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php echo number_format(0, 2, ',', '.');?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_conexion), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_re_conexion), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_recargo), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_aseo), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_alumbrado), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_afcoop), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_devolucion), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_dignidad), 2, ',', '.');
  ?>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_ley1886), 2, ',', '.');
  ?>
</td>
<td align="right" style="font-weight: bold;">
  <?php
  echo number_format(($ley1886_total), 2, ',', '.');
  ?>
</td>
</tr><!-- ALUMBRADO PUBLICO-->

	</table>

</body>
</html>