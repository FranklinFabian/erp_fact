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
		<tr><td align="center" width=100%><strong>CONTRATO DE SUMINISTRO DE SERVICIO DE TELEVISIÓN POR CABLE CON PERSONA NATURAL</strong></td></tr>
		<tr><td align="right" width=100%>Abonado: <?php echo $abonado['abonado'];?></td></tr>
	</table>
	<!-- FIN CABECERA -->
	<?php
	$cliente=$this->cliente_model->get_cliente($abonado['idcliente']);
	$calle=$this->calles_model->get_calle($abonado['idcalle']);
	$categoria=$this->categorias_model->get_categorias($abonado['idcategoria']);
	$suministro=$this->suministros_model->get_suministro($abonado['idsuministro']);
	$medicion=$this->mediciones_model->get_medicion($abonado['idmedicion']);

	?>
<table width=100% border=0>
	<tr><td>Conste por el presente Documento Privado, que los suscribientes acuerdan celebrar un Contrato de PROVISIÓN DE SERVICIO DE TELEVISIÓN POR CABLE ENTRE UNA PERSONA NATURAL Y OTRA JURÍDICA,  que con el reconocimiento de firmas y rubricas surtirá los mismos efectos de documento público, sujeto a las siguientes cláusulas:</td></tr>
	<tr><td><br><strong>PRIMERA.- (PARTES CONTRATANTES).- </strong>Intervienen en la suscripción del presente contrato:</td></tr>
	<tr><td><strong>1.1	<?php echo $this->config->item('razonSocial').' "'.$this->config->item('siglas').'"' ;?>,</strong> legalmente constituida, con personería jurídica Nro. <?php echo $this->config->item('nro_personaria_juridica');?>, NIT N°. <?php echo $this->config->item('nit');?>,  con domicilio legal de la Cooperativa en  <?php echo $this->config->item('direccion_contrato');?> , representada legalmente por el:   <?php echo $this->config->item('representante_legal');?>, hábil por derecho, con cédula de identidad Nº <?php echo $this->config->item('ci_representante_legal');?>, representación ejercido en mérito al Testimonio de Poder Especial N° 223/2022 de fecha 11 de julio de 2022; en lo sucesivo y para efectos del presente contrato se denominará <strong>OPERADOR</strong>; y </td></tr>
	<tr><td><strong>1.2 </strong>	El Sr. (a) <?php  echo $cliente['razon_social'];?>, con Cédula de Identidad Nº <?php echo $cliente['ci']?>, domiciliado en <?php echo $cliente['direccion']?>, con n° teléfono o Celular: <?php echo $cliente['telefono']?>, hábil por derecho; en lo sucesivo y para efectos del presente contrato se denominará <strong>"USUARIO"</strong>.</td></tr>
	<tr><td><br><strong>SEGUNDA.-  (ANTECEDENTES). - </strong>	La Cooperativa de Servicios Públicos de Electricidad Tupiza RL. COOPELECT R.L., con la finalidad de cumplir con sus objetivos que están descritos en el Estatuto Orgánico ofrece y está dispuesto el brindar a sus asociados (as), usuarios (as), el servicio de TELEVISIÓN POR CABLE con canales de carácter local, nacional e internacional.</td></tr>
	<tr><td><br><strong>TERCERA.-  (OBJETO DEL CONTRATO).- </strong> El objeto del presente contrato es la prestación de servicio de varios canales por el sistema de televisión por cable que ofrece el OPERADOR a sus asociados (a), usuarios (a). </td></tr>
	<tr><td><br><strong>CUARTA. - (TÉRMINOS Y CONDICIONES). - </strong>El Asociado (a), Usuario (a), al momento de contratar el presente servicio de televisión por cable se someterá a los términos y condiciones del presente contrato.</td></tr>
	<tr><td><br><strong>QUINTA. - (PLAZO DEL CONTRATO, VIGENCIA RESOLUCIÓN Y RECISIÓN DEL CONTRATO). - </strong>El presente contrato tiene un plazo indefinido y su vigencia dependerá de la cancelación puntual de la mensualidad del Servicio de Televisión por Cable y la ruptura del presente contrato se realiza de forma inmediata cuando cumpla 6 meses de corte ya sea por mora o solicitud, debiendo presentar nuevamente los requisitos para instalación en caso de solicitar la  reconexión .También se procederá a la RECISIÓN cuando alguna de las dos partes no cumplan alguna de las cláusulas del presente documento.</td></tr>
	<tr><td><br><strong>SEXTA.- (PLAZOS PARA INSTALACIÓN, HABILITACIÓN, DESHABILITACIÓN, REHABILITACIÓN DEL SERVICIO).- </strong>Una vez que el asociado (a) o usuario (a)  presente toda la documentación requerida el OPERADOR procederá a la Instalación, habilitación, deshabilitación, rehabilitación del servicio en los plazos previstos por la ATT, Ley General de Telecomunicaciones, Tecnología de Información y Comunicación y su Reglamento u otra disposición vigente, bajo el siguiente procedimiento:</td></tr>
	<tr><td><br>INSPECCIONES.- Una vez  que el usuario presente toda la documentación exigida el OPERADOR  procederá a la realizar la verificación  técnica para la buena factibilidad y accesibilidad a nuestras señales en el domicilio del Cliente.</td></tr>
	<tr><td><br>INSTALACIÓN PARTICULAR: La COOPERATIVA realizará la instalación de la acometida al televisor central del abonado como asimismo a los puntos solicitados por el abonado (2 como máximo). El costo del material de la instalación y de los puntos, correrán por cuenta del abonado.</td></tr>
	<tr><td><br>INSTALACIÓN COMERCIAL: La COOPERATIVA realizara la instalación de la acometida al televisor central del usuario y al número de puntos en el edificio  a requerimiento y/o solicitud escrita por parte del usuario. El costo del material de la instalación y cada uno de los puntos, correrán a cuenta del abonado.</td></tr>
	<tr><td><br>RETIRO: El retiro y/o eliminación de puntos se efectuará previo aviso a la COOPERATIVA por parte del usuario, la solicitud de retiro y/o suspensión del servicio será tomado en cuenta, hasta el día (5) de cada mes, pasada esta fecha la Cooperativa, cobrará el servicio por todo el mes sin reclamo alguno.</td></tr>
	<tr><td><br>SUSPENSIÓN TEMPORAL: La suspensión temporal se la efectuará previa solicitud del usuario, misma será tomada en cuenta hasta el día (5) de cada mes, pasada la fecha, la Cooperativa cobrará el servicio por todo el mes sin reclamo. La suspensión temporal tiene un plazo de 6 meses para la reconexión, pasado el plazo se rescinde el presente. </td></tr>
	<tr><td><br>INSPECCIÓN DE RUTINA. - El usuario está en la obligación de permitir el acceso a los técnicos de la Cooperativa para la inspección y revisión técnico de las conexiones realizadas al o los televisores. Los técnicos responsables portaran una credencial de la COOPERATIVA que los habilitará para este efecto.  La negativa al ingreso de los técnicos sin causa justificada dará lugar al corte del servicio y pago de sanción de acuerdo a la cláusula novena inciso 3. <br>La Cooperativa realizara una inspección inicial en el momento de la instalación a los abonados nuevos y a los que cuentan ya con estos servicios  la COOPERATIVA tiene el derecho de ir a realizar inspecciones en el momento que  creyere necesario con la finalidad de verificar las instalaciones realizadas y verificar que no exista instalaciones clandestinas.</td></tr>	
	<tr><td><br><strong>SÉPTIMA (TITULARIDAD).- </strong>OPERADOR  declara que por intermedio de su sección de Televisión por Cable tiene la titularidad del Servicio y la autorización por parte de la ATT.</td></tr>
	<tr><td><br><strong>OCTAVA (ESTRUCTURA TARIFARIA).- </strong>Las Categorías establecidas por la Cooperativa son:</td></tr>

	<tr><td><br>CATEGORIA ASOCIADO: El Asociado (a) deberá hacer un pago de Bs. 70 (Setenta 00/100 bolivianos) que significa su derecho de instalación.</td></tr>
	<tr><td><br>CATEGORIA PARTICULAR: Los usuarios particulares (incluidos inquilinos) pagaran Bs. 105.- (Ciento cinco 00/100 bolivianos) por derecho de instalación.</td></tr>
	<tr><td><br>CATEGORIA COMERCIAL: (Hoteles, Hostales, Residencias, Alojamiento, Bares, Pensiones, Restaurantes, Pizzería y similares) El usuario deberá realizar un pago de Bs. 140.- (Ciento Cuarenta 00/100 bolivianos) por derecho de instalación.</td></tr>
	<tr><td>El usuario deberá cancelar la siguiente mensualidad:</td></tr>
	<tr><td><strong><br>COSTO DE LA MENSUALIDAD</strong></td></tr>
	<tr>
		<td>
			<table border=1 cellspacing=0>
				<tr><td>CATEGORIAS</td><td>COSTO PUNTO ÚNICO</td><td>COSTO POR PUNTO ADICIONAL</td></tr>
				<tr><td>Residencial Asociado</td><td>70.-</td><td>No aplica</td></tr>
				<tr><td>Residencial Particular</td><td>80.-</td><td>No aplica</td></tr>
				<tr><td>Hoteles, Hostales y similares</td><td>120.-</td><td>25.-</td></tr>
				<tr><td>Alojamiento, Residencial y similares</td><td>100.-</td><td>20.-</td></tr>
				<tr><td>Bares, pensiones, restaurantes, pizzerías y similares</td><td>100.-</td><td>20.-</td></tr>
			</table>
		</td>
	</tr>
	<tr><td><br>La estructura actual de precios del contrato puede ser modificado de acuerdo a un estudio que realice la Cooperativa y de acuerdo a las normas legales del Estado Plurinacional de Bolivia.</td></tr>
	<tr><td>DERIVADOS. - Los usuarios en la Categoría Residencial tendrán el derecho a solicitar la conexión de dos derivados, por lo que debe cancelar la suma de Bs. 30 (treinta 00/100 bolivianos) por cada uno. - para uso personal, en los predios de la vivienda, “excluyendo a inquilinos, anticresistas o terceras personas”, el trabajo para esta instalación debe  ser realizado  por el personal de la Cooperativa, de lo contrario se denominara conexión clandestina.</td></tr>
	<tr><td><br><strong>NOVENA  (FACTURACIÓN, COBRANZA PAGO Y CORTE): </strong>El abonado tendrá la obligación  cumplir el presente contrato y la   cancelación  por el servicio hasta  5 de cada mes, el incumplimiento dará lugar:</td></tr>

	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; 1)	El usuario tendrá disponible la factura del servicio del mes vencido a partir del (5) de cada mes.</td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; 2)	La NO cancelación de dos facturas  continuas mensuales, dará lugar al corte del servicio sin previo tramite, debiendo cancelar Bs. 30 (treinta 00/100 bolivianos) para la reconexión y en caso de pasar 6 meses del corte por deuda, deberá cancelar la tarifa de instalación que corresponda. </td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; 3)	Las listas de corte del servicio se emiten a partir del 10 de cada mes, por lo que el usuario deberá cancelar previamente a la fecha indicada para evitar el corte. </td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; 4)	Por conexión clandestina a la red de Televisión por Cable, el corte será inmediato dando lugar a pagar una sanción de acuerdo al inciso 5 y cobro por daños y perjuicios si hubiera. </td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; 5)	Cuando el usuario proceda a la implementación de más puntos de los solicitados, sin conocimiento de la COOPERATIVA, podrá efectuar las siguientes acciones:</td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; a)	Al cobro de la sanción equivalente a $us. 50.- (Cincuenta 00/100 Dólares Americanos), cuando se evidencie conexión clandestina.</td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; b)	Cobro de la sanción equivalente a $us. 30.- (Treinta 00/100 Dólares Americanos), por punto implementado sin conocimiento de la COOPERATIVA.</td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; c)	Al inicio de las acciones legales pertinentes.</td></tr>
	<tr><td>La reposición del servicio será previa cancelación de lo adeudado.</td></tr>
	
	<tr><td><br><strong>DÉCIMA (CALIDAD DEL SERVICIO).- </strong>EL OPERADOR se compromete a brindar el Servicio de Televisión por cable de manera: continua, calidad, protección, información oportuna y clara, prestación efectiva, secreto de las  comunicaciones.</td></tr>
	
	<tr><td><br><strong>DÉCIMA PRIMERA (DERECHOS Y OBLIGACIONES).- </strong>Las partes intervinientes en el presente contrato tienen los siguientes Derechos y Obligaciones:</td></tr>
	
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; -	ASOCIADOS (AS) y USUARIOS (AS): Recibir su factura por la cancelación realizada, asistencia Técnica por fallas en la recepción de la señal de Televisión por Cable, estar informado en el cambio en la grilla de los canales, recibir la señal de manera clara y nítida.</td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; -	LA COOPERATIVA: Recibir la cancelación por el servicio prestado de manera oportuna, realizar  corte del servicio  por instalaciones clandestinas, solicitar documentación necesaria al  usuario, comunicar el cambio de la grilla de los canales cuando exista.</td></tr>
	
	<tr><td><br><strong>DÉCIMA SEGUNDA (RESPONSABILIDAD).- </strong>El usuario y Proveedor son responsables: Administrativamente, Civil y Penal por  infracción  incumplimiento del presente contrato.</td></tr>
	<tr><td><br><strong>DÉCIMA TERCERA (ATENCIÓN DE RECLAMOS).- </strong>El usuario podrá presentar sus reclamos en  COOPELECT en oficinas de TV - CABLE ubicada en Plaza Independencia N°. 327 Acera Sur de la ciudad de Tupiza-Sud Chichas-Potosí, Teléf. 6942434. Los reclamos serán tomados en cuenta a partir de su notificación y registro.</td></tr>
	<tr><td><br><strong>DÉCIMA CUARTA (SERVICIO DE INFORMACIÓN Y ASISTENCIA).- </strong>El usuario podrá solicitar información y asistencia en la Sección de Televisión por Cable de COOPELECT en Plaza Independencia N°. 327 Acera Sur  de la ciudad de Tupiza-Sud Chichas-Potosí, Teléf. 6942434. Bajo el siguiente horario: 8:00 a 12:00 a.m. y 14:00 a 18:00 p.m. de lunes a viernes. (Horario que puede ser modificado de acuerdo a normativa nacional, departamental, municipal o por disposición interna de la Cooperativa.)</td></tr>
	<tr><td><br><strong>DÉCIMA QUINTA (DECLARACIÓN EXPRESA).- </strong>Partes intervinientes en el presente contrato: USUARIO Y PROVEEDOR, manifiestan su voluntad y que no existió ningún vicio en el consentimiento como ser: ERROR, DOLO Y VIOLENCIA en el presente documento.</td></tr>
	<tr><td><br><strong>DÉCIMA SEXTA (INVIOLABILIDAD Y PROTECCIÓN DE LA INFORMACIÓN DE LA USUARIA O USUARIO).- </strong>La Cooperativa declara mantener la confidencialidad de los datos otorgados y la documentación presentada por el Usuario.</td></tr>
	<tr><td><br><strong>DÉCIMA SÉPTIMA (RESOLUCIÓN Y RESCISIÓN DEL CONTRATO).- </strong>Resolución del Contrato se dará cuando las partes convienen en que este Contrato podrá  ser resuelto en cualquier momento por mutuo acuerdo, no debiendo existir deudas pendientes de parte del Usuario. Dicho acurdo deberá constar expresamente y por escrito (Form. Corte Servicio Tv Cable).</td></tr>
	<tr><td>Rescisión se deja expresa constancia de que, de acuerdo a lo estipulado en el presente contrato, las partes de común  acuerdo establecen que tanto la Cooperativa como el Cliente pueden rescindir de manera unilateral este Contrato. En tal caso, si el Usuario decide efectivizar la recisión deberá notificar esta situación a la Cooperativa.</td></tr>
	<tr><td>En ambos casos también se procederá a la Resolución y Rescisión del Contrato por incumplimiento de las partes a cualquier cláusula del presente documento. </td></tr>
	<tr><td><br><strong>DÉCIMA OCTAVA (INTEGRIDAD DEL CONTRATO).- </strong>Son partes del presente documentos:</td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; -      Solicitud de conexión de televisión por cable. (Form. Inspección Técnica Tv-Cable). – Ultima Factura de luz.</td></tr>
	<tr><td>&nbsp;&nbsp;&nbsp;&nbsp; -	Fotocopia de su Cédula de identidad.         – Fot. Plano Inmueble u otros documentos que sirva para conexión Tv Cable.</td></tr>
	<tr><td><br><strong>DÉCIMA NOVENA (CLÁUSULA DE INTERPRETACIÓN).- </strong>El presente contrato es transcrito en castellano y para efectos legales el mismo se podrá traducir al idioma del usuario.</td></tr>
	<tr><td><br><strong>VIGÉSIMA  (DECLARACIÓN JURADA).- </strong>El Usuario, Asociado, Cliente, declaran que todos los datos brindados y la documentación presentada son verídicos y responden a la verdad, en caso de constatar que estos no corresponden a la verdad de los hechos la Cooperativa podrá rescindir el presente contrato y tomar las medidas del caso que corresponda como así a iniciar las acciones legales que crea conveniente.</td></tr>
	<tr><td><br><strong>VIGÉSIMA PRIMERA (ACEPTACIÓN).- </strong>El usuario y el Proveedor declaran su conformidad con todas y cada una de las cláusulas del presente documento.</td></tr>
	
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