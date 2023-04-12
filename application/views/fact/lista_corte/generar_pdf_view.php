<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"><meta content="<?php echo $this->config->item('producto');?>" name="author" />
  <title><?php echo $title;?></title>
</head>
<style>
    body {
        font-size: 5px;
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
			<td align="center" width="6%"><strong>ABONADO</strong></td>
			<td align="center" width="32%"><strong>RAZÓN SOCIAL</strong></td>
			<td align="center" width="6%"><strong>N° CORTE</strong></td>
			<td align="center" width="6%"><strong>POSTE</strong></td>
			<td align="center" width="7%"><strong>MEDIDOR</strong></td>
			<td align="center" width="5%"><strong>MES DEU</strong></td>
			<td align="center" width="8%"><strong>FECHA</strong></td>
			<td align="center" width="8%"><strong>HORA</strong></td>
			<td align="center" width="8%"><strong>LECTURA</strong></td>
			<td align="center" width="13%"><strong>NOTA</strong></td>
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
							$corte['razon_social']
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

<br pagebreak="true" /> 
</body>
</html>