<!-- Admin Home Start -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_module('Anticipos') ?></small>
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
    <?php
      $this->session->unset_userdata('error_message');
    } ?>

    <!--Add Invoice -->
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <!-- Header -->
          <div class="panel-heading">
            <div class="panel-title">
              <h4><strong>Anticipos</strong></h4>
            </div>
          </div>
          <!-- Body -->
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-4 col-sm-offset-2">
                <label for="registro_mensual_mes">Mes</label>
                <select name="registro_mensual_mes" id="registro_mensual_mes" class="form-control" style="width:100%;">
                  <?php foreach ($meses as $m) : ?>
                    <option value="<?php echo $m->mes; ?>"><?php echo date('d/m/Y', strtotime($m->mes)); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-sm-4">
                <label for="mes_asistencia">Total Bs.</label>
                <input type="number" id="importe_total" class="form-control text-right" value="0.00" readonly />
              </div>
              <div class="col-sm-12 text-center mt-3">
                <div class="btn-group btn-group-sm">
                  <button type="button" id="btn_nuevo_registro_mensual" class="btn btn-info"><i class="fa fa-plus-square"></i> Nuevo</button>
                  <button type="button" id="btn_imprimir_registro_mensual" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                </div>
              </div>
              <div class="col-sm-12 mt-10">
                <table id="tabla_registros_mensuales" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                  <thead>
                    <th class="text-center">Nro.</th>
                    <th class="text-center">Empleado</th>
                    <th class="text-center">Paterno</th>
                    <th class="text-center">Materno</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Importe</th>
                    <th class="text-center">Acciones</th>
                  </thead>
                  <tbody>
                    <!-- dinámico - js -->
                  </tbody>
                  <tfoot>
                    <tr></tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Registrar Nuevo Registro Mensual-->
    <div class="modal fade fs-12" id="modal_nuevo_actualizar_registro_mensual" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="titulo_form_registro_mensual"></span> Anticipo
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
              <input type="hidden" id="registro_mensual_empleado_to_update">
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_registrar_actualizar_registro_mensual">
              <div class="row">
                <div class="col-sm-12">
                  <label for="rm_empleado">Empleado</label>
                  <select name="empleado" id="rm_empleado" class="form-control" style="width:100%;" required>
                    <?php foreach ($empleados as $e) : ?>
                      <option value="<?php echo $e->empleado; ?>"><?php echo $e->paterno . ' ' . $e->materno . ' ' . $e->nombre1 . ' ' . $e->nombre2; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-sm-12 mt-10">
                  <label for="rm_importe">Importe</label>
                  <input type="number" name="importe" id="rm_importe" class="form-control" step="0.01" min="0.01" placeholder="0.00" required />
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn_form_registro_mensual"></span></button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  const mes_habilitado = <?php echo json_encode($mes_habilitado[0]); ?>;
  const meses = <?php echo json_encode($meses); ?>;
  let tabla_registro_mes, data_registro_mes;

  function llenarTablaRegistroMes() {
    tabla_registro_mes.clear().draw();
    let mtrmf1 = 0;
    data_registro_mes.forEach((fila, index) => {
      mtrmf1 += parseFloat(fila.importe);
      tabla_registro_mes.row.add([
        (index + 1),
        fila.empleado,
        fila.paterno,
        fila.materno,
        fila.nombre1 + ' ' + fila.nombre2,
        fila.importe,
        (mes_habilitado.mes == fila.mes) ?
        `<button onclick="editarRegistroMensual(${fila.empleado})" class="btn btn-primary btn-xs" title="Editar registro"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                <button onclick="eliminarRegistroMensual(${fila.empleado})" class="btn btn-danger btn-xs" title="Eliminar registro"><i class="fa fa-close" aria-hidden="true"></i></button>` : '-'
      ]).draw(false);
    });
    $('#importe_total').val(mtrmf1.toFixed(2));
  }

  function cargar_datos_mensuales(mes) {
    swloading.start('Cargando.');
    $.ajax({
      type: "post",
      url: "<?php echo base_url('rrhh/anticipos/get_data'); ?>",
      data: { mes },
      dataType: "json",
      success: function(response) {
        swloading.stop();
        data_registro_mes = response.data_reg_mes;
        llenarTablaRegistroMes();
      },
      error: function(error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });
  }

  $('#registro_mensual_mes').on('change', function() {
    if ($('#registro_mensual_mes').val() == null) {
      return $('#registro_mensual_mes').val(meses[0].mes).change();
    }

    cargar_datos_mensuales($('#registro_mensual_mes').val());
  });

  $('#btn_nuevo_registro_mensual').on('click', function() {
    const mes_form = $('#registro_mensual_mes').val();
    if (mes_form != mes_habilitado.mes) {
      time_alert('error', 'No permitido!', 'El mes seleccionado se encuentra cerrado.', 2000)
        .then(() => {
          return;
        })
    } else {
      // Reiniciar form
      $('#rm_empleado').prop('disabled', false); // Habilitar la seleccion del empleado
      $('#rm_importe').val('');
      // Data Modal
      $('.titulo_form_registro_mensual').text('Registrar Nuevo');
      $('.btn_form_registro_mensual').text('Registrar');
      $('#modal_nuevo_actualizar_registro_mensual').modal('show');
    }
  });

  $('#form_registrar_actualizar_registro_mensual').submit(function(e) {
    e.preventDefault();
    const data_form_send = {
      empleado: $('#rm_empleado').val(),
      mes: $('#registro_mensual_mes').val(),
      importe: $('#rm_importe').val()
    };

    const option = $('.btn_form_registro_mensual').text();
    let msj_option = '',
      url_option = '',
      msj_alerta = '';
    if (option == 'Registrar') { // Registrar
      msj_option = 'Se registrará un nuevo anticipo.';
      url_option = '<?php echo base_url('rrhh/anticipos/registrar'); ?>';
      msj_alerta = 'Registrado';
      /* Solo se permite un registro por usuario */
      const verificar = data_registro_mes.find(element => element.empleado === data_form_send.empleado)
      if (verificar) {
        time_alert('error', 'Error!', 'Ya existe un anticipo registrado para el empleado seleccionado.', 2000);
        return;
      }
    } else { // Actualizar
      msj_option = 'Se actualizará los datos del anticipo.';
      url_option = '<?php echo base_url('rrhh/anticipos/actualizar'); ?>';
      msj_alerta = 'Actualizado';
    }
    msg_confirmation('warning', '¿Está seguro?', msj_option)
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "post",
            url: url_option,
            data: { data_form: data_form_send },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              time_alert('success', `${msj_alerta}!`, `Anticipo ${msj_alerta.toLowerCase()} correctamente.`, 2000)
                .then(() => {
                  cargar_datos_mensuales(data_form_send.mes);
                  $('#modal_nuevo_actualizar_registro_mensual').modal('hide');
                });
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  });
  function editarRegistroMensual(empleado) {
    $('#registro_mensual_empleado_to_update').val(empleado);
    $('.titulo_form_registro_mensual').text('Editar');
    $('.btn_form_registro_mensual').text('Actualizar');
    const registro = data_registro_mes.find(element => element.empleado == empleado);
    $('#rm_empleado').val(registro.empleado).change();
    $('#rm_empleado').prop('disabled', 'disabled');
    $('#rm_importe').val(registro.importe);
    $('#modal_nuevo_actualizar_registro_mensual').modal('show');
  }
  function eliminarRegistroMensual(empleado) {
    const mes = $('#registro_mensual_mes').val();
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "post",
            url: "<?php echo base_url('rrhh/anticipos/eliminar'); ?>",
            data: { empleado, mes },
            dataType: "text",
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Eliminado!', 'Registro eliminado correctamente.', 2000)
                .then(() => {
                  cargar_datos_mensuales(mes);
                });
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  }
  $('#btn_imprimir_registro_mensual').on('click', function() {
    const data = $('#registro_mensual_mes').val();
    const url_rm = "<?php echo base_url('rrhh/anticipos/reporte'); ?>?data=" + btoa(data);
    window.open(url_rm);
  });
  $('#modal_nuevo_actualizar_registro_mensual').on('shown.bs.modal', function(e) {
    $('#rm_importe').focus();
  })
  $(document).ready(function() {
    tabla_registro_mes = $('#tabla_registros_mensuales').DataTable(DATA_TABLE);
    cargar_datos_mensuales(meses[0].mes);
  });
</script>
