<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Plan de Cuentas') ?></small>
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
              <h4>Plan de Cuentas</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-12 text-center">
                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_agregar_cuenta"><i class="fa fa-plus"></i> Nueva Cuenta</button>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="table_data" class="table table-bordered table-hover table-main" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Moneda</th>
                        <th>Nivel (Tipo)</th>
                        <!-- <th>Actz/UFV</th> -->
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($plan_cuentas as $pc) : ?>
                        <tr>
                          <td><?php echo '&nbsp;' . $pc->codigo_formato; ?></td>
                          <td><?php echo str_repeat("&nbsp;&nbsp;", $pc->cuenta_tipo_sangria) . $pc->nombre; ?></td>
                          <td class="center"><?php echo $pc->moneda_codigo; ?></td>
                          <td class="center"><?php echo $pc->cuenta_tipo_nombre; ?></td>
                          <!--td><?php echo $pc->actzUFV;       ?></td-->
                          <td class="center">
                            <button class="btn btn-primary btn-xs" title="Editar Cuenta" onclick="editar_cuenta('<?php echo $pc->id; ?>')"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                            <button class="btn btn-danger btn-xs" title="Eliminar Cuenta" onclick="eliminar_cuenta('<?php echo $pc->id; ?>')"><i class="fa fa-close" aria-hidden="true"></i></button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Main content end -->
</div>
<!-- Admin Home end -->

<!-- MODAL REGISTRAR CUENTA -->
<div class="modal fade" id="modal_agregar_cuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title" id="myModalLabel">Agregar Nueva Cuenta
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </h4>
      </div>
      <form action="#" id="formulario">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <label for="cuenta_grupo_id">Grupo Cuenta</label>
              <select class="form-control dont-select-me" id="cuenta_grupo_id" required>
                <?php foreach ($cuentas_grupos as $cg) : ?>
                  <option value="<?php echo $cg->id; ?>"><?php echo "{$cg->nombre} ($cg->id)"; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="cuenta_tipo_id">Tipo Cuenta</label>
              <select class="form-control dont-select-me" id="cuenta_tipo_id" required>
                <?php foreach ($cuentas_tipos as $ct) : ?>
                  <option value="<?php echo $ct->id; ?>"><?php echo $ct->nombre; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="moneda_id">Moneda</label>
              <select class="form-control dont-select-me" id="moneda_id" required>
                <?php foreach ($monedas as $lm) : ?>
                  <option value="<?php echo $lm->id; ?>"><?php echo $lm->codigo; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-5">
              <label for="codigo_cuenta">Código Cuenta</label>
              <input type="text" class="form-control" id="codigo_cuenta" value="<?php echo $cuentas_grupos[0]->id ?>" required>
              <div id="codigo_cuenta_comentario"></div>
              <small>Ejemplo de formato: <strong><span id="example_account_code"></span></strong></small>
            </div>
            <div class="col-md-7">
              <label for="nombre_cuenta">Nombre</label>
              <input type="text" class="form-control uppercase" id="nombre_cuenta" placeholder="Nombre de la cuenta" autocapitalize="words" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Registrar</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDITAR CUENTA -->
<div class="modal fade" id="modalFormCuentaEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title" id="myModalLabel">Editar Cuenta <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
      </div>
      <form action="#" id="formulario_editar">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="md-form">
                <label for="">Grupo Cuenta:</label>
                <input type="text" class="form-control" id="mostrarGrupoCuenta" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="md-form">
                <label for="">Tipo Cuenta:</label>
                <input type="text" class="form-control" id="mostrarTipoCuenta" readonly>
              </div>
            </div>
            <div class="col-md-5">
              <div class="md-form">
                <label for="">Código Cuenta:</label>
                <input type="text" class="form-control" id="mostrarCodigoCuenta" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="md-form">
                <label for="idmNombreCuentaEditar">Nombre Cuenta:</label>
                <input type="text" class="form-control uppercase" id="idmNombreCuentaEditar" placeholder="Nombre de la cuenta" required>
                <input id="idmCuentaEditar" hidden>
              </div>
            </div>
            <div class="col-md-4">
              <div class="md-form">
                <label for="idmMonedaEditar">Moneda:</label>
                <select class="form-control  dont-select-me" id="idmMonedaEditar" disabled>
                  <?php foreach ($monedas as $lm) : ?>
                    <option value="<?php echo $lm->id; ?>"><?php echo $lm->codigo; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Actualizar</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const plan_cuentas = <?php echo json_encode($plan_cuentas); ?>;
  const cuentas_tipos = <?php echo json_encode($cuentas_tipos); ?>;
  let regex;

  function editar_cuenta(cuenta_id) {
    const cuenta = plan_cuentas.find(c => c.id == cuenta_id);
    $('#mostrarGrupoCuenta').val(cuenta.cuenta_grupo_nombre);
    $('#mostrarTipoCuenta').val(cuenta.cuenta_tipo_nombre);
    $('#mostrarCodigoCuenta').val(cuenta.codigo_formato);
    $('#idmNombreCuentaEditar').val(cuenta.nombre);
    $("#idmMonedaEditar").val(cuenta.moneda_id);
    $('#idmCuentaEditar').val(cuenta_id);
    $('#modalFormCuentaEditar').modal('show');
  }

  function eliminar_cuenta(cuenta_id) {
    msg_confirmation('warning', '¿Está seguro?', 'Va a eliminar la cuenta, no podrá<br>revertir los cambios.')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "POST",
            url: BASE_URL + 'cofi/planDeCuentas/eliminar/' + cuenta_id,
            dataType: 'json',
            success: function(response) {
              swloading.stop();
              if (response.status) {
                return time_alert('success', 'Eliminado!', response.message, 2500)
                  .then(() => window.location.reload());
              }
              return ok_alert('error', 'Error!', response.message);
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  }

  // REGISTRAR CUENTA
  $('#formulario').submit(function (e) {
    e.preventDefault();
    const data = {
      cuenta_grupo_id: $('#cuenta_grupo_id').val(),
      cuenta_tipo_id: $('#cuenta_tipo_id').val(),
      codigo_formato: $('#codigo_cuenta').val(),
      codigo: $('#codigo_cuenta').val().split('.').join(''),
      nombre: $('#nombre_cuenta').val().toUpperCase().trim(),
      moneda_id: $('#moneda_id').val(),
    };

    msg_confirmation('warning', '¿Está seguro?', 'Va a registrar una nueva cuenta.')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "POST",
            url: BASE_URL + 'cofi/planDeCuentas/registrar',
            data: { data, regex },
            dataType: 'json',
            success: function(response) {
              swloading.stop();
              if (response.status) {
                return time_alert('success', 'Registrado!', 'Cuenta registrada correctamente.', 2500)
                  .then(() => window.location.reload());
              }
              ok_alert('error', 'Error!', response.message);
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  });

  // ACTUALIZAR CUENTA
  $('#formulario_editar').submit(function (e) {
    e.preventDefault();
    const data = {
      nombre: $('#idmNombreCuentaEditar').val().toUpperCase(),
      moneda_id: $('#idmMonedaEditar').val(),
    };
    const cuenta_id = $('#idmCuentaEditar').val();

    swloading.start();
    $.ajax({
      type: "POST",
      url: BASE_URL + 'cofi/planDeCuentas/actualizar/' + cuenta_id,
      data: { data },
      dataType: 'json',
      success: function(response) {
        swloading.stop();
        time_alert('success', 'Actualizado!', 'Cuenta actualizada correctamente.', 2500)
          .then(() => window.location.reload());
      },
      error: function(error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });
  });

  function generate_example_account_code_and_buil_regex() {
    // Base Logic: /^(\d{1}\.\d{2}\.\d{1})$/ -> X.XX.X
    let base_regex = '^(';
    const number = (digitos) => '\\d{'+ digitos +'}';
    const dot = `\\.`;

    const example_account_code = [];
    const cuenta_tipo_id = $('#cuenta_tipo_id').val();
    const ctipos = cuentas_tipos.filter(ct => ct.id <= cuenta_tipo_id);

    ctipos.forEach(({ cantidad_digitos }, index) => {
      base_regex += number(cantidad_digitos);
      if (ctipos.length > index + 1) {
        base_regex += dot;
      }

      const aux = "".padStart(cantidad_digitos, String.fromCharCode(65 + index)); // 97
      example_account_code.push(aux);
    });
    $('#example_account_code').text(example_account_code.join('.'));

    base_regex += ')+$';
    regex = new RegExp(base_regex, '');
  }
  $('#cuenta_tipo_id').on('change', async function() {
    generate_example_account_code_and_buil_regex();
    $('#codigo_cuenta').keyup();
  }).change();
  $('#codigo_cuenta').on('keyup', function() {
    const codigo_cuenta = $('#codigo_cuenta').val();

    const validate_length = $('#example_account_code').text().length < codigo_cuenta.length;
    const validate_current_code = /([^0-9^.])$|(\.{2,})$/;
    if ((validate_current_code.exec(codigo_cuenta)) !== null || validate_length) {
      const nuevo_codigo_cuenta = codigo_cuenta.substring(0, codigo_cuenta.length - 1);
      return $('#codigo_cuenta').val(nuevo_codigo_cuenta.trim());
    }

    const validation = regex.test(codigo_cuenta);
    if (validation) {
      $('#codigo_cuenta_comentario').text('').attr('class', 'valid-feedback');
      $('#codigo_cuenta').attr('class', 'form-control is-valid');
    } else {
      $('#codigo_cuenta_comentario').text('Verifique el formato del código de cuenta.').attr('class', 'invalid-feedback');
      $('#codigo_cuenta').attr('class', 'form-control is-invalid');
    }
  });
  $('#cuenta_grupo_id').on('change', function() {
    $('#codigo_cuenta').val($('#cuenta_grupo_id').val());
  });

  $(document).ready(function() {
    $('#table_data').DataTable(DATA_TABLE_BUTTONS('Plan de Cuentas', [0, 1, 2, 3]));
  });
</script>
