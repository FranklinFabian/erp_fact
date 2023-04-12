<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"><meta content="<?php echo $this->config->item('producto');?>" name="author" />
  <title><?php echo $title;?></title>
</head>
<style>
    body {
        font-size: 6px;
        font-family: "Tahoma", "Verdana", "Segoe", "sans-serif";
    }
</style>
<body>

<?php
	$tamanio = count($array_cortes);
	for($i=0;$i<$tamanio;$i++):
?>
<?php $cortes = $array_cortes[$i];?>
	<!-- CABECERA -->
	<table width="100%" border="0">
		<tr>
			<td width="33%">
				<?php 
					echo $this->config->item('nombre_institucion').'<br>'.$this->config->item('localidad_institucion').'<br>'.date('Y-m-d H:i:s');
				?>
				
			</td>
			<td align="center" width="33%">
				<h3>
					LISTA DE CORTE<br>
					<?php
					if($idservicio==1)
						echo 'ENERGÍA ELÉCTRICA';
					else 
						echo 'TV CABLE';
					?>
				</h3>
			</td>
			<td align="right" width="33%">
				<h2>CIRCUITO.: <?php  echo $circuito;?></h2>
				<strong>LISTA:</strong> <?php echo $lista;?> 
			</td>
			
		</tr>
	</table>
	<!-- FIN CABECERA -->
	
	<table width="100%" border="1" cellspacing="0" cellpadding="2">
		<tr bgcolor="#ddd">
			<td align="center" width="7%"><strong>ABONADO</strong></td>
			<td align="center" width="32%"><strong>RAZÓN SOCIAL</strong></td>
			<td align="center" width="7%"><strong>N° CORTE</strong></td>
			<td align="center" width="6%"><strong>POSTE</strong></td>
			<td align="center" width="7%"><strong>MEDIDOR</strong></td>
			<td align="center" width="7%"><strong>MES DEU</strong></td>
			<td align="center" width="8%"><strong>FECHA</strong></td>
			<td align="center" width="7%"><strong>HORA</strong></td>
			<td align="center" width="8%"><strong>LECTURA</strong></td>
			<td align="center" width="11%"><strong>NOTA</strong></td>
		</tr>
		<?php
			$salida='';
			foreach ($cortes as $key => $corte) {
				$direccion = $this->calles_model->get_all_all($corte['idcalle']);
				$salida.='
					<tr>
						<td>'.$corte['abonado'].'</td>
						<td>'.(
							'ZONA: '.$direccion['zona'].'<br>'.
							'CALLE: '.$direccion['calle'].'<br>'.
							'<strong>'.$corte['razon_social'].'</strong>'
							).'</td>
						<td align="right">'.$corte['numero'].'</td>
						<td align="center">'.$corte['poste'].'</td>
						<td align="right">'.$corte['medidor'].'</td>
						<td align="center">'.$corte['meses'].'</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				';
			}
			echo $salida;
		?>
	</table>

	<!-- firmas -->
	<table width="100%" border="1" cellspacing="0" cellpadding="2">
		<tr>
			<td whidth="25%"><p><p></p></p>Gerente gral.</td>
			<td whidth="25%"><p><p></p></p>Jefe técnico</td>
			<td whidth="25%"><p><p></p></p>Técnico.</td>
			<td whidth="25%"><p><p></p></p>Procesado</td>

		</tr>
	</table>	
	<!-- fin firmas -->
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr><td align="right">Pag. <?php echo ($i+1).' de '.$tamanio?></td></tr>
	</table>

	<?php if($i<$tamanio-1):?>
		<br pagebreak="true" />
		<?php endif;?>
<?php endfor;?>
</body>
</html>