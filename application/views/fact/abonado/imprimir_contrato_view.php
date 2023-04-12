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
					<?php echo $this->config->item('razonSocial');?>
				</strong><br>
				Personería Jurídica Nro. <?php echo $this->config->item('nro_personaria_juridica');?> NIT <?php echo $this->config->item('nit');?>
			</td>			
		</tr>
	</table>
	<hr>
	<table width=100% border=0>
		<tr><td align="center" width=100%><strong>CONTRATO DE SUMINISTRO DE ELECTRICIDAD CON PERSONA NATURAL</strong></td></tr>
		<tr><td align="right" width=100%>Abonado: <?php echo $abonado['abonado'];?> Medidor: <?php echo $abonado['medidor'];?></td></tr>
	</table>
	<!-- FIN CABECERA -->
	
<table width=100% border=0>
	<tr><td>Conste por el presente <strong>CONTRATO DE SUMINISTRO DE ELECTRICIDAD ENTRE UNA PERSONA NATURAL Y OTRA JURÍDICA</strong>, que en su caso podrá ser elevado a instrumento público con el sólo reconocimiento de firmas y rúbricas, el mismo que se suscribe al tenor de las cláusulas y condiciones siguientes:</td></tr>
	
	<tr><td><br><strong>PRIMERA. (PARTES).-</strong> Constituyen partes de este contrato, las que se describen a continuación:</td></tr>
	<tr><td><strong>1.1	<?php echo $this->config->item('razonSocial').' "'.$this->config->item('siglas').'"' ;?>,</strong>  legalmente constituida, con personería jurídica Nro. <?php echo $this->config->item('nro_personaria_juridica');?>, NIT N°. <?php echo $this->config->item('nit');?>,  con domicilio legal de la Cooperativa en  <?php echo $this->config->item('direccion_contrato');?> , representada legalmente por el:   <?php echo $this->config->item('representante_legal');?>, hábil por derecho, con cédula de identidad Nº <?php echo $this->config->item('ci_representante_legal');?>, representación ejercido en mérito al Testimonio de Poder Especial N° 223/2022 de fecha 11 de julio de 2022; en lo sucesivo y para efectos del presente contrato se denominará <strong>DISTRIBUIDORA</strong>; y </td></tr>
	<tr><td><strong>1.2 </strong>	El Sr. (a) <?php $cliente=$this->cliente_model->get_cliente($abonado['idcliente']); echo $cliente['razon_social'];?>, con Cédula de Identidad Nº <?php echo $cliente['ci']?>, domiciliado en <?php echo $cliente['direccion']?>, con n° teléfono o Celular: <?php echo $cliente['telefono']?>, hábil por derecho; en lo sucesivo y para efectos del presente contrato se denominará <strong>"CONSUMIDOR"</strong>.</td></tr>
	<tr><td><br><strong>SEGUNDA. (OBJETO DEL CONTRATO).- </strong>	El presente contrato tiene por objeto el Suministro de Electricidad por parte de la DISTRIBUIDORA a favor del CONSUMIDOR en la dirección <?php $calle=$this->calles_model->get_calle($abonado['idcalle']); echo $calle['calle'];?>, a cambio de una remuneración monetaria, de acuerdo al régimen tarifario vigente. </td></tr>
	<tr><td><br><strong>TERCERA. (CARACTERÍSTICAS DEL SERVICIO).- </strong></td></tr>
	<tr><td><strong>3.1	NIVEL DE TENSIÓN: </strong>El voltaje con el que se atenderá el servicio es: 220 voltios.</td></tr>
	<tr><td><strong>3.2	POTENCIA INSTALADA (KW): 1KW</strong>  (Es la declarada y verificada por la Distribuidora, en caso de existir alguna contradicción se considerará la verificada en la inspección)</td></tr>
	<tr><td><strong>3.3	ACTIVIDAD:</strong>  De acuerdo a lo declarado por el <strong>CONSUMIDOR</strong>, la actividad que se desarrolla en el lugar donde se suministrará la electricidad es: vivienda, correspondiendo de acuerdo a lo dispuesto por la normativa en vigencia a la categoría: <?php $categoria=$this->categorias_model->get_categorias($abonado['idcategoria']); echo $categoria['categoria'];?><br> Si en el servicio existieran consumos claramente identificados que pertenezcan a diferentes actividades, al servicio se le asignará la categoría que corresponda a la actividad principal, la misma que será determinada por la <strong>DISTRIBUIDORA</strong>. </td></tr>
	<tr><td><strong>3.4	CATEGORÍA TARIFARIA:</strong>  De acuerdo a lo dispuesto en la normativa vigente y las características del servicio, la categoría tarifaria aplicable al CONSUMIDOR es: <?php echo $categoria['categoria'];?> </td></tr>
	<tr><td><strong>3.5	PUNTO DE MEDICIÓN Y PUNTO DE ENTREGA:</strong> El punto de medición es: <?php $medicion=$this->mediciones_model->get_medicion($abonado['idmedicion']); echo $medicion['medicion']?>. El punto de entrega es  (Baja Tensión (BT), Media Tensión (MT), Alta Tensión (AT): <?php $suministro=$this->suministros_model->get_suministro($abonado['idsuministro']); echo $suministro['suministro']?>.</td></tr>
	<tr><td><strong>3.6	CAMBIO DE CATEGORÍA:</strong> En los casos en que la <strong>DISTRIBUIDORA</strong> establezca que la categoría asignada al <strong>CONSUMIDOR</strong> no es correcta o sea procedente el cambio de categoría por modificaciones en las características del servicio, la <strong>DISTRIBUIDORA</strong> deberá informar al <strong>CONSUMIDOR</strong> la ejecución del cambio y las razones que lo motivan. <br>En los casos que el <strong>CONSUMIDOR</strong> cambie algunas de las características de su servicio, por ejemplo la actividad, deberá comunicar este hecho a la <strong>DISTRIBUIDORA</strong> de forma inmediata para la actualización de la categoría y su contrato.</td></tr>
	<tr><td><br><strong>CUARTA. (TARIFA APLICABLE Y CALIDAD DEL SERVICIO).- </strong></td></tr>
	<tr><td><strong>4.1 </strong>	La <strong>DISTRIBUIDORA</strong> cobrará al <strong>CONSUMIDOR</strong> la tarifa aprobada por la AETN, para la categoría tarifaria en la que le suministre el servicio, la misma que será indexada mensualmente aplicando las fórmulas de indexación, conforme a lo dispuesto por el Reglamento de Precios y Tarifas (RPT), aprobado mediante Decreto Supremo Nº 26094 de 2 de marzo de 2001.</td></tr>
	<tr><td><strong>4.2 </strong>	La <strong>DISTRIBUIDORA</strong> prestará el servicio con la calidad establecida en el Reglamento de Calidad de Distribución de la Ley de Electricidad, en el presente contrato y las disposiciones de la AETN.</td></tr>
	<tr><td><br><strong>QUINTA. (CONEXIÓN DEL SERVICIO).- </strong>	Para la conexión del servicio, el CONSUMIDOR previamente deberá proceder a la firma del contrato con la DISTRIBUIDORA y posteriormente se  efectuara el pago del Depósito de Garantía y del Cargo por Conexión, de acuerdo a lo siguiente:<br> Depósito de Garantía		Bs. <?php echo $categoria['garantia'];?> y cargo de Conexión de acuerdo a la tarifa aprobada.</td></tr>
	<tr><td>La DISTRIBUIDORA conectará el servicio en un plazo máximo de 5 días hábiles computables a partir de la suscripción del presente contrato.</td></tr>
	<tr><td>Si la DISTRIBUIDORA no conectara el servicio en el plazo establecido precedentemente, deberá pagar al CONSUMIDOR por cada día de atraso, la suma establecida por la Entidad Reguladora,   abonando su importe en la primera facturación.</td></tr>
	<tr><td>A la conclusión del contrato, la DISTRIBUIDORA devolverá al CONSUMIDOR el depósito de garantía con mantenimiento de valor respecto al dólar estadounidense, previa deducción de los importes que éste le adeudara, dentro de los dos (2) días hábiles siguientes a la rescisión del contrato.</td></tr>
	<tr><td>La DISTRIBUIDORA, es responsable de la Conexión desde la red eléctrica  hasta el lugar donde se encuentre el medidor del CONSUMIDOR para este efecto el CONSUMIDOR tendrá que tener todo listo para que se proceda a la conexión.</td></tr>
	<tr><td><br><strong>SEXTA. (FACTURACIÓN Y PAGO DEL SERVICIO).- </strong></td></tr>
	<tr><td><strong>6.1 </strong>	La DISTRIBUIDORA entregará al CONSUMIDOR el aviso de cobranza o factura dentro de los tres (3) días hábiles siguientes al vencimiento del plazo máximo establecido para su emisión. <br>Las facturas o avisos de cobranza podrán incluir los importes de las tasas de aseo, recojo de basura y alumbrado público, de conformidad a lo establecido en las disposiciones legales en vigencia.</td></tr>
	<tr><td><strong>6.2 </strong>	El CONSUMIDOR se obliga al pago mensual de las facturas por el servicio, hasta la fecha de vencimiento, aún en caso de no recibir la factura o aviso de cobranza correspondiente. En este caso debe acudir a las oficinas o agencias comerciales de la DISTRIBUIDORA, para el pago de las facturas pendientes. <br>Las facturas por el servicio de suministro de electricidad pueden ser canceladas mensualmente en las oficinas de la DISTRIBUIDORA y Entidades Financieras hasta la fecha de vencimiento indicada en cada factura, el incumplimiento en la cancelación de dos facturas, dará lugar al corte del suministro sin previo aviso, teniendo la DISTRIBUIDORA la facultad de iniciar la acción que corresponda para recuperar los montos adeudados sin necesidad de requerimiento de mora, aceptando el CONSUMIDOR que el monto de las facturas impagas constituye deuda líquida y exigible, reconociendo que dichas facturas son títulos con la suficiente fuerza de ejecución. </td></tr>
	<tr><td><br><br><br><br><strong>SÉPTIMA. (INTERRUPCIÓN, CORTE Y RECONEXIÓN DEL SERVICIO).-</strong></td></tr>
	<tr><td><strong>7.1 </strong>El suministro de electricidad por las características del mismo, puede interrumpirse debido a causas imprevistas, por lo tanto los CONSUMIDORES que desarrollen actividades delicadas o críticas como: hospitales, clínicas, procesos industriales, laboratorios, cines, centros de computación, hoteles, edificios con ascensores, etc., en las que la interrupción del suministro de electricidad pueda causar perjuicios deben instalar necesaria y obligatoriamente equipos de protección adecuados y sistemas alternativos  de respaldo, la DISTRIBUIDORA no asumirá responsabilidad alguna si el CONSUMIDOR no toma dichas previsiones. <br>La DISTRIBUIDORA en todos los casos que programe o planifique un corte de suministro, comunicará a sus clientes mediante prensa oral y/o escrita.</td></tr>
	<tr><td><strong>7.2 </strong>Conforme al Artículo 59 de la Ley de Electricidad y el Artículo 41 de Reglamento de Servicio Público de Suministro de Electricidad (RSPSE), aprobado mediante Decreto Supremo Nº 26302 de 1 de septiembre de 2001, la DISTRIBUIDORA se reserva el derecho de corte de suministro de electricidad sin necesidad de trámite o procedimiento previo alguno, en caso de existir infracciones o dos facturas pendientes de pago.</td></tr>
	<tr><td><strong>7.3 </strong>Para reconectar el servicio, la DISTRIBUIDORA podrá cobrar un cargo de reconexión aprobado por la AETN. <br>La DISTRIBUIDORA no podrá cobrar el cargo de reconexión si el servicio no hubiese sido efectivamente cortado. <br>La DISTRIBUIDORA reconectará el servicio dentro del plazo establecido en el Reglamento de Calidad de Distribución computable a partir de: </td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; a) </strong>El pago de todas las facturas en mora, mas sus intereses moratorios, y del cargo por reconexión, cuando el corte se motive por falta de pago de facturas; o</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; b) </strong>La fecha en la que la DISTRIBUIDORA otorgue al CONSUMIDOR plazos para el pago de sus facturas en mora; o</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; c) </strong>El cumplimiento de la resolución por la que se hubiese sancionado con corte del servicio y al pago del cargo por reconexión; o</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; d) </strong>La fecha en la que el CONSUMIDOR solicite la reconexión, cuando el corte se hubiese efectuado a su solicitud.</td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; La DISTRIBUIDORA podrá cobrar el cargo por reconexión en la próxima emisión de la factura del servicio.</td></tr>
	<tr><td><br><strong>OCTAVA. (RESPONSABILIDAD EN LOS DAÑOS A INSTALACIONES, EQUIPOS Y ARTEFACTOS DEL CONSUMIDOR O DE TERCEROS).-</strong> </td></tr>
	<tr><td><strong>8.1</strong> Los daños a instalaciones, equipos y artefactos del CONSUMIDOR, o de terceros, producidos por deficiencias en las instalaciones u operaciones de la DISTRIBUIDORA, en la conexión de la acometida o en el suministro, serán de responsabilidad de la DISTRIBUIDORA. </td></tr>
	<tr><td><strong>8.2</strong> Los daños a instalaciones, equipos y artefactos del CONSUMIDOR, o de terceros, producidos por deficiencias de las instalaciones internas del inmueble, serán de exclusiva responsabilidad del CONSUMIDOR. </td></tr>
	<tr><td>La instalación interna del CONSUMIDOR es de su total responsabilidad, debiendo instalar protecciones adecuadas en todos los circuitos que desea proteger, especialmente para motores y equipos electrónicos monofásicos y/o trifásicos. La DISTRIBUIDORA no asumirá responsabilidad sobre la instalación interna del CONSUMIDOR, si dicha instalación ocasionara bajas de voltaje, incendio o peligro de incendio, daños a las personas o bienes, el CONSUMIDOR deberá corregir o en su caso resarcir por su cuenta los daños causados a terceras personas o a las instalaciones de la DISTRIBUIDORA.</td></tr>
	<tr><td><br><strong>NOVENA. (RESPONSABILIDAD POR EL MEDIDOR).-</strong> El CONSUMIDOR se compromete a velar por la integridad del medidor, cualquier daño o alteración en dicho medidor será responsabilidad del CONSUMIDOR. Si la DISTRIBUIDORA establece que el medidor fue manipulado, alterado o sus precintos violados, el servicio será suspendido de forma inmediata. En este caso para reinstalar el servicio, el CONSUMIDOR deberá cubrir el monto por la energía no facturada y las multas establecidas en el Artículo 25 del Reglamento de Infracciones y Sanciones de la Ley de Electricidad. </td></tr>
	<tr><td><br>En caso de existir deudas pendientes de pago de un servicio suspendido en el inmueble en el que solicita un nuevo servicio, el solicitante deberá previamente gestionar ante el anterior usuario que estas sean canceladas o cancelarlas en su totalidad, antes de suscribir un nuevo contrato.</td></tr>
	<tr><td><br>En servicio General  e Industrial Menor, la facturación mínima mensual será igual al cargo por consumo mínimo. Para la categoría Industrial Mayor será igual al cargo por demanda por la máxima demanda registrada en los últimos doce meses.</td></tr>
	<tr><td><br><strong>DÉCIMA. (CONDICIONES Y USO DEL SERVICIO).-</strong></td></tr>
	<tr><td><strong>10.1</strong>	El CONSUMIDOR:</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; a) </strong>Limitará el uso del suministro a la potencia y condiciones técnicas convenidas;</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; b) </strong>No suministrará ni cederá total o parcialmente a terceros, la electricidad que le suministre la DISTRIBUIDORA;</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; c) </strong>Utilizará la energía suministrada por la DISTRIBUIDORA en forma tal de no provocar perturbaciones en sus instalaciones o en las de otros consumidores; y</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; d) </strong>Utilizará equipos y artefactos eléctricos adecuados a las características técnicas del servicio.</td></tr>
	<tr><td><strong>10.2 </strong>El CONSUMIDOR no podrá cambiar de ubicación el medidor u otros equipos o instalaciones de la DISTRIBUIDORA. Para el traslado de medidor o modificación de instalaciones y acometida solicitará a la DISTRIBUIDORA para que esta tome las acciones que correspondan.</td></tr>
	<tr><td><strong>10.3 TRASLADO Y CAMBIO DE NOMBRE.-</strong> Si el CONSUMIDOR se traslada a otro domicilio deberá solicitar en el área correspondiente de la DISTRIBUIDORA el traslado o la suspensión del servicio que deja; de lo contrario la responsabilidad por el consumo de energía y por el medidor continuarán a cargo del CONSUMIDOR. <br>Aceptada la solicitud de suspensión del servicio por la DISTRIBUIDORA (previa cancelación de deuda pendiente si existiera), el CONSUMIDOR podrá requerir la devolución del depósito de garantía con mantenimiento de valor. <br>El CONSUMIDOR puede solicitar el traslado del servicio o suscribir un nuevo contrato en el domicilio al cual se traslada y si existiese un servicio instalado a otro nombre en el nuevo domicilio deberá solicitar el cambio de nombre, a fin de obtener la titularidad del servicio que establece una relación contractual con la DISTRIBUIDORA. </td></tr>
	<tr><td><strong>10.4 CAMBIO EN EL USO DEL SERVICIO.- </strong>Si el CONSUMIDOR aumentara o disminuyera la potencia instalada o cambiara el uso del servicio, deberá informar a la DISTRIBUIDORA para la aplicación de la tarifa que corresponda, la DISTRIBUIDORA no se responsabilizará por las facturaciones anteriores por desconocimiento de las condiciones de uso del servicio, asimismo, la DISTRIBUIDORA se reserva el derecho de cambiar la tarifa correspondiente. </td></tr>
	<tr><td><strong>10.5 ACCESO DE EMPLEADOS DE LA DISTRIBUIDORA.- </strong>La dotación del servicio está condicionada a que el CONSUMIDOR permita y facilite el acceso al medidor y equipos auxiliares del servicio, al personal de la DISTRIBUIDORA para la lectura mensual de los medidores, inspecciones, mantenimientos, cambio de medidor o cualquier trabajo que la DISTRIBUIDORA considere conveniente efectuar. El negar el acceso al medidor para realizar los trabajos mencionados, está sancionado según el Artículo 57, inciso d) de la Ley de Electricidad.</td></tr>
	<tr><td><br><strong>DÉCIMA PRIMERA. (RESCISIÓN DEL CONTRATO).-</strong></td></tr>
	<tr><td><strong>11.1	</strong>La DISTRIBUIDORA podrá rescindir el contrato, mediante comunicación escrita al CONSUMIDOR, cuando se produjera cualquiera de las situaciones señaladas a continuación:</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; a)	</strong>Si el CONSUMIDOR, no hubiese pagado tres (3) facturas por el servicio.</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; b)	</strong>Si se comprobara que el CONSUMIDOR una vez cortado el suministro, se hubiera reconectado directamente al servicio a través del equipo de medición o en forma directa a la red de distribución.</td></tr>
	<tr><td><strong>11.2	</strong>11.2	El CONSUMIDOR podrá rescindir el contrato, mediante comunicación escrita a la DISTRIBUIDORA en las situaciones que se señalan a continuación:</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; a)	</strong>Con una anticipación de por lo menos diez (10) -para pequeñas demandas- o cuarenta (40) días hábiles administrativos -para medianas o grandes demandas-, previo cumplimiento de sus obligaciones, es decir que tenga todas sus facturas pagadas y no registre deudas con la DISTRIBUIDORA.</td></tr>
	<tr><td><strong>&nbsp;&nbsp;&nbsp;&nbsp; b)	</strong>Cuando cese su posesión o tenencia en el inmueble o lugar donde se presta el servicio, con una anticipación de por lo menos diez (10) días hábiles a producirse el evento y previo cumplimiento de sus obligaciones; en tanto el CONSUMIDOR no proceda a la rescisión del Contrato, será responsable de todas las obligaciones del nuevo poseedor o tenedor del inmueble.</td></tr>
	<tr><td><br><strong>DÉCIMA SEGUNDA. (VIGENCIA DEL CONTRATO).- </strong>La vigencia del presente contrato será indefinida, salvo requerimiento expreso del CONSUMIDOR. </td></tr>
	<tr><td>La vigencia del contrato podrá ser modificada mediante solicitud escrita o verbal efectuada por el CONSUMIDOR a la DISTRIBUIDORA, con una anticipación de veinte (20) días hábiles administrativos.</td></tr>
	<tr><td><br><strong>DÉCIMA TERCERA. (ACEPTACIÓN).- </strong>Las partes manifiestan su plena aceptación y conformidad con todas y cada una de las cláusulas y condiciones del presente contrato, obligándose a su fiel y estricto cumplimiento.</td></tr>
	<?php 
		$fecha = date('Y-m-d');
		$mes = substr($fecha,5,2);
		$mes_espaniol=null;
		switch ($mes) {
			case '01':$mes_espaniol='Enero';break;
			case '02':$mes_espaniol='Febrero';break;
			case '03':$mes_espaniol='Marzo';break;
			case '04':$mes_espaniol='Abril';break;
			case '05':$mes_espaniol='Mayo';break;
			case '06':$mes_espaniol='Junio';break;
			case '07':$mes_espaniol='Julio';break;
			case '08':$mes_espaniol='Agosto';break;
			case '09':$mes_espaniol='Septiembre';break;
			case '10':$mes_espaniol='Octubre';break;
			case '11':$mes_espaniol='Noviembre';break;
			case '12':$mes_espaniol='Diciembre';break;
			
		}
	?>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td><?php echo $this->config->item('municipio').', '.substr($fecha,8,2).' de '.$mes_espaniol.' de '.substr($fecha,0,4);?></td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
</table>

<table width=100% border=0 cellspacing=0 cellpadding=2>
	<tr>
		<td width="10%"></td>
		<td width="35%" align="center"><?php echo $this->config->item('representante_legal');?></td>
		<td width="10%"></td>
		<td width="35%" align="center"><?php echo $cliente['razon_social'];?></td>
		<td width="10%"></td>
	</tr>
	<tr>
		<td width="10%"></td>
		<td width="35%" align="center"><?php echo $this->config->item('cargo_representante_legal');?></td>
		<td width="10%"></td>
		<td width="35%" align="center"><?php echo 'CONSUMIDOR';?></td>
		<td width="10%"></td>
	</tr>
</table>

</body>
</html>