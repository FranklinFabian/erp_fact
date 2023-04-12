<!-- Admin Home Start -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Plantillas') ?></small>
      <?php echo $this->breadcrumb->render() ?>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Alert Message -->
    <?php $message = $this->session->userdata('message');
    if (isset($message)) { ?>
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
              <h4><?php echo isset($plantilla) ? "Editar" : "Registrar"; ?> Plantilla</h4>
            </div>
          </div>

          <div class="panel-body">
            <div class="row">
              <div class="col-md-4">
                <label for="nombre"><strong>Nombre</strong></label>
                <input class="form-control" name="nombre" id="nombre" value="<?php echo isset($plantilla) ? $plantilla['nombre'] : '' ?>" placeholder="Nombre de la plantilla" required />
                <input type="text" id="id" value="<?php echo isset($plantilla) ? $plantilla['id'] : '' ?>" hidden>
              </div>
              <div class="col-md-7">
                <label for="descripcion"><strong>Descripción</strong></label>
                <input class="form-control" name="descripcion" id="descripcion" value="<?php echo isset($plantilla) ? $plantilla['descripcion'] : '' ?>" placeholder="Descripción de la plantilla" />
              </div>
              <div class="col-md-1">
                <label for=""><strong>&nbsp;</strong></label>
                <button class="col-md-12 btn btn-info btn-sm" onclick="agregar_cuenta()"><i class="fa fa-plus" aria-hidden="true"></i></button>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-6">
                <label for="cuenta_id"><strong>Cuenta</strong></label>
              </div>
            </div>
            <form action="#" id="formulario">
              <div class="row mt-2">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="tabla_plantilla" class="table table-responsive table-bordered table-hover table-sm table-striped text-center">
                      <thead>
                        <tr>
                          <th>Cuenta</th>
                          <th width="15%">Tipo</th>
                          <th>Referencia</th>
                          <th width="8%">Porcentaje</th>
                          <th width="8%">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- dinámico -->
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-12 text-right">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> <?php echo isset($plantilla) ? 'Actualizar' : 'Registrar' ?> </button>
                  <a href="<?php echo base_url('cofi/plantillas') ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Cancelar</a>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Admin Home end -->

<script>
  const cuentas_finales = <?php echo json_encode($cuentas_finales) ?>;
  const editar = Boolean('<?php echo isset($plantilla) ?>');
  const plantilla_data = <?php echo isset($plantilla_data) ? json_encode($plantilla_data) : '[]' ?>;

  $('#formulario').submit(function(e) {
    e.preventDefault();
    const plantilla = {
      nombre: $('#nombre').val(),
      descripcion: $('#descripcion').val(),
    };
    const plantilla_data = [];
    $('#tabla_plantilla tbody tr').each(function() {
      const row = {
        cuenta_id: $(this).find('select[name="cuenta_id"]').val(),
        tipo: $(this).find('select[name="tipo"]').val(),
        referencia: $(this).find('input[name="referencia"]').val(),
        porcentaje: $(this).find('input[name="porcentaje"]').val(),
      }
      plantilla_data.push(row);
    });

    swloading.start();
    $.ajax({
      type: "POST",
      url: BASE_URL + 'cofi/plantillas/' + (editar ? `actualizar/${$('#id').val()}` : 'registrar'),
      data: {
        plantilla,
        plantilla_data
      },
      dataType: "json",
      success: function (response) {
        swloading.stop();
        if (response) {
          return time_alert('success', editar ? 'Actualizado!':'Registrado!', `Plantilla ${editar ? 'actualizada':'registrada'} correctamente.`, 2000)
            .then(() => window.location = BASE_URL + 'cofi/plantillas')
        }
        ok_alert_error();
      },
      error: function (error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });
  });

  function agregar_cuenta(eliminar = true, data = false) {
    const html = `
			<tr>
				<td>
					<select class="form-control select2" name="cuenta_id" style="width: 100%;" required>
						<option value="">Seleccione una cuenta...</option>
            ${cuentas_finales.map(cf => `
							<option value="${cf.id}" ${(data && cf.id === data.cuenta_id) ? 'selected':'' }>
                ${cf.codigo_formato} | ${cf.nombre}
              </option>
              `).join('')}
					</select>
				</td>
				<td>
					<select class="form-control" name="tipo" required>
						<option value="DEBE" ${data && data.tipo === 'DEBE' ? 'selected':''}>DEBE</option>
						<option value="HABER" ${data && data.tipo === 'HABER' ? 'selected':''}>HABER</option>
					</select>
				</td>
				<td>
					<input type="text" class="form-control" name="referencia" value="${data && data.referencia ? data.referencia:''}">
				</td>
				<td>
					<input type="number" min="0.00" max="100" step="0.01" class="form-control" name="porcentaje" value="${data && data.porcentaje ? data.porcentaje:''}" required>
				</td>
				<td>
					${eliminar ? '<button class="btn btn-danger btn-xs eliminar"><i class="fa fa-trash"></i></button>' : '-'}
				</td>
			</tr>`
    $('#tabla_plantilla tbody').append(html);
    $('.select2').select2({
      placeholder: "Seleccione una cuenta..."
    });
    $('.eliminar').on('click', function() {
      $(this).parent().parent().remove();
    });
  }

  $(document).ready(function() {
    if (editar) {
      plantilla_data.forEach((row, index) => {
        agregar_cuenta(index!=0, row);
      });
    } else {
      agregar_cuenta(false);
    }
  });
</script>
