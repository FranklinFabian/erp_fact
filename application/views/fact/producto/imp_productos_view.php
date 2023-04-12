<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title;?></title>
	<link rel="stylesheet" href="<?php echo base_url()?>public/css/reportes.css">
</head>
<body>
    <!-- Cabecera -->
    <table width=100% border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td width=100%>
                <table width=100% border=0 cellspacing=0 cellpadding=0>
                    <tr>
                        <td align=center> <img src="<?php echo base_url()?>public/img/logo.png" alt="" height="80"> </td>
                    </tr>
                    <tr>
                        <td align=center><strong><?php echo $this->config->item('pie_logo_reporte');?></strong></td>
                    </tr>
                    <tr>
                        <td align=center><small><?php echo $direccion_telefono;?></small></td>
                    </tr>
                </table>
            </td>
        </tr>    
    </table>
	<hr>
    <!-- fin cabecera -->

	<h2 style="text-align:center">LISTA DE PRODUCTOS REGISTRADOS EN EL SISTEMA</h2>
	<p></p>
	<table width="100%" border=1 cellpadding="2">
		<tr style="background-color: #ccc; font-weight:bold;">
			<td>NRO.</td>
			<td>PRODUCTO</td>
			<td>COD. BARRAS</td>
			<td>UNIDAD</td>
			<td>P. VENTA</td>
			<td>ESTADO</td>
			<td>CATEGORÍA</td>
		</tr>
		<?php
		$html='';
		$i=1;
			foreach ($productos as $key => $value) {
				$html.='
				<tr>
					<td>'.($i++).'</td>
					<td>'.($value['nombre_producto']).'</td>
					<td>'.($value['cod_producto']).'</td>
					<td>'.($value['unidad_medida']).'</td>
					<td style="text-align:right">'.(number_format($value['precio_venta'],'2',',','.')).'</td>
					<td>'.($value['estado_producto']==1?'ACTIVO':'INACTIVO').'</td>
					<td>'.($value['nombre_categoria']).'</td>
				</tr>
				';
			}
		echo $html;
		?>
	</table>
</body>
</html>