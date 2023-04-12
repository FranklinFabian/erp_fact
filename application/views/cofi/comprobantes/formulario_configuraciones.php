<!-- Admin Home Start -->
<div class="content-wrapper">

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="header-icon">
			<i class="pe-7s-world"></i>
		</div>
		<div class="header-title">
			<h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Comprobantes') ?></small>
      <?php echo $this->breadcrumb->render() ?>
		</div>
	</section>

	<section class="content">
		<!-- Alert Message -->
		<?php $message = $this->session->userdata('message');
		if (isset($message)){ ?>
			<div class="alert alert-info alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<?php echo $message ?>
			</div>
			<?php $this->session->unset_userdata('message');
		}
		$error_message = $this->session->userdata('error_message');
		if (isset($error_message)) { ?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<?php echo $error_message ?>
			</div>
			<?php $this->session->unset_userdata('error_message');
		}
		?>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-bd lobidrag">
				<div class="panel-heading">
					<div class="panel-title">
						<h4><?php echo "Configuración Parametros Comprobantes"; ?></h4>
					</div>
				</div>

				<div class="panel-body">
							<div class="row">
								<div id="primeraParteFormularioComprobante">
									<div class="col-md-8 col-md-offset-2">
										<div class="row">
											<div class="col-md-6" hidden>
												<label for="idCantidadDigitos"><strong>Cantidad de Digitos</strong></label>
												<input class="form-control" type="text" id="idCantidadDigitos" value="<?php echo comprobantes_parametros('cantidad_digitos') ?>" placeholder="Ingrese la cantidad de digitos...">
											</div>
										</div>
										<div class="row mt-2">
											<div class="col-md-6">
												<label for="idNumeroCampos"><strong>Número de Campos para Firmas</strong></label>
												<select class="form-control dont-select-me" id="idNumeroCampos">
													<option value="1" <?php echo comprobantes_parametros('numero_firmas') === '1' ? 'selected' : '' ?>>1</option>
													<option value="2" <?php echo comprobantes_parametros('numero_firmas') === '2' ? 'selected' : '' ?>>2</option>
													<option value="3" <?php echo comprobantes_parametros('numero_firmas') === '3' ? 'selected' : '' ?>>3</option>
													<option value="4" <?php echo comprobantes_parametros('numero_firmas') === '4' ? 'selected' : '' ?>>4</option>
													<option value="5" <?php echo comprobantes_parametros('numero_firmas') === '5' ? 'selected' : '' ?>>5</option>
													<option value="6" <?php echo comprobantes_parametros('numero_firmas') === '6' ? 'selected' : '' ?>>6</option>
												</select>
											</div>
										</div>
										<div class="row" id="campoFirmas">
											<!-- dinámico -->
										</div>
										<div class="row mt-3">
											<div class="col-md-12 text-center">
												<button type="button" class="btn btn-primary btn-sm" id="btnActualizarParametros"><i class="fa fa-refresh"></i> Actualizar Parametros</button>
											</div>
										</div>
									</div>
								</div>
							</div>
				</div>
				</div>
			</div>
		</div>

	</section>
	<!-- Admin Home end -->
</div>

<script>
	const paramComproJS		= <?php echo json_encode(comprobantes_parametros());?>;

	$(document).ready(function () {
		// Funcion que se encarga de mostrar el número  campos con sus datos respectivos
		function mostrarCampos(nc){
			$('#campoFirmas').empty();
			var nombresCargos 	= [paramComproJS.cargo_firma_uno, paramComproJS.cargo_firma_dos, paramComproJS.cargo_firma_tres, paramComproJS.cargo_firma_cuatro, paramComproJS.cargo_firma_cinco, paramComproJS.cargo_firma_seis];
			var nompersonas 	= [paramComproJS.nombre_firma_uno, paramComproJS.nombre_firma_dos, paramComproJS.nombre_firma_tres, paramComproJS.nombre_firma_cuatro, paramComproJS.nombre_firma_cinco, paramComproJS.nombre_firma_seis];
			for(var i=1;i<=nc;i++){
				var campoFirma = `
					<div class="col-md-6" style="margin-top: 10px;">
						<label for="idCampoCargo`+i+`"><strong>Nombre Cargo/puesto Firma `+i+`</strong></label>
						<input class="form-control" type="text" placeholder="Ingrese nombre cargo..." id="idCampoCargo`+i+`" value="`+nombresCargos[i-1]+`">
					</div>
					<div class="col-md-6" style="margin-top: 10px;">
						<label for="idCampoNombre`+i+`"><strong>Nombre Persona Firma `+i+`</strong></label>
						<input class="form-control" type="text" placeholder="Ingrese nombre persona..." id="idCampoNombre`+i+`" value="`+nompersonas[i-1]+`">
					</div>`;
					$('#campoFirmas').append(campoFirma);
			}
		}
		// Llamada a la funcion al cargar la página
		mostrarCampos(paramComproJS.numero_firmas);
		// Cuando se cambia el número de campos para las firmas
		$('#idNumeroCampos').on('change', function () {
			//console.log(paramComproJS.numero_firmas);
			var nc = $('#idNumeroCampos').val();
			mostrarCampos(nc);
		});
		// Cantidad de digitos solo numero, sin decimales
		$('#idCantidadDigitos').on('keyup', function() {
			var valor = $('#idCantidadDigitos').val();
			// se ACEPTA SOLO NUMEROS con 6 decimales
			this.value  = valor;
			var regex = /^\d+(\d{0,0})?$/g;
			if (!regex.test(this.value)) this.value = this.value.substring(0, this.value.length-1);
		});
		// Botón actualizar parametros conprobantes
		$('#btnActualizarParametros').on('click', function () {
			var nc = $('#idNumeroCampos').val();
			var cd = $('#idCantidadDigitos').val();
			// contruccion de la data a enviar (numero de campos)
			var dataParametrosComprobante = [];
			for(var i=0; i<nc; i++){
				cad1 = '#idCampoCargo'+(i+1);
				cad2 = '#idCampoNombre'+(i+1);
				var cargo 	= $(cad1).val();
				var nombre 	= $(cad2).val();
				var fila = { cargo, nombre };
				dataParametrosComprobante.push(fila);
			}
			//console.log(dataParametrosComprobante);
			if(cd == "") {
            time_alert('warning', 'Alerta!', 'Ingrese la Cantidad de Digitos.', 2000)
				.then(() => { return; });
			} else if(nc==null) {
            time_alert('warning', 'Alerta!', 'Debe seleccionar el Número de Campos.', 2000)
				.then(() => { return; });
			} else if(parseInt(nc) <= 0) {
            time_alert('warning', 'Alerta!', 'El número de Campos debe ser mayor que Cero.', 2000)
				.then(() => { return; });
			} else {
				swloading.start();
				$.ajax({
					type: "POST",
					url: BASE_URL + 'cofi/comprobantes/registrar_configuraciones',
					data: {nc: nc, cd: cd, dataPC : JSON.stringify(dataParametrosComprobante)},
					success: function (data) {
						swloading.stop();
						if(data == "SI") {
							time_alert('success', 'Actualizado!', 'Los Parametros de los Comprobantes fueron actualizados correctamente.', 2500)
								.then(() => window.location.reload());
						}
					},
					error: function (error) {
						swloading.stop();
						ok_alert_error(error);
					}
				});
			}
		});
	});
</script>
