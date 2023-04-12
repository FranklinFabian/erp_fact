<!-- Admin Home Start -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_module('Suplencias') ?></small>
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
    <div class="row">
      <div class="col-sm-12">
      </div>
    </div>

    <!--Add Invoice -->
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">

          <!-- Header -->
          <div class="panel-heading">
            <div class="panel-title">
              <h4><strong><?php echo 'Horas Extras'; ?></strong></h4>
            </div>
          </div> <!-- Header End -->
          <!-- Body -->
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-4 col-sm-offset-4">
                <label for="registro_mensual_horas_extras_mes">Mes</label>
                <select name="registro_mensual_horas_extras_mes" id="registro_mensual_horas_extras_mes" class="form-control" style="width:100%;">
                  <?php foreach ($data_meses as $m) : ?>
                    <option value="<?php echo $m->mes; ?>"><?php echo date('d/m/Y', strtotime($m->mes)); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="row mt-10">
              <div class="col-sm-12 text-center">
                <div class="btn-group btn-group-sm">
                  <button type="button" id="btn_nuevo_registro_mensual_horas_extras" class="btn btn-info"><i class="fa fa-plus-square"></i> Nuevo</button>
                  <button type="button" id="btn_imprimir_resumen_mensual" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Resumen</button>
                </div>
              </div>
              <div class="col-sm-12 mt-10">
                <table id="tabla_horas_extras_totales" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                  <thead>
                    <th class="text-center">Nro.</th>
                    <th class="text-center">Empleado</th>
                    <th class="text-center">Paterno</th>
                    <th class="text-center">Materno</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Sencillas</th>
                    <th class="text-center">Dobles</th>
                    <th class="text-center">Nocturnas</th>
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
          </div> <!-- Body End -->

        </div>
      </div>
    </div>

    <!-- Modal Registrar Nuevo Registro Mensual Horas Extras -->
    <div class="modal fade fs-12" id="modal_nuevo_actualizar_registro_mensual_horas_extras" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Horas Extras
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="ir_form_registrar_horas_extras">
              <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                  <label for="horas_extras_empleado">Empleado</label>
                  <select name="empleado" id="horas_extras_empleado" class="form-control" style="width:100%;" required>
                    <?php foreach ($data_empleados as $e) : ?>
                      <option value="<?php echo $e->empleado; ?>"><?php echo $e->paterno . ' ' . $e->materno . ' ' . $e->nombre1 . ' ' . $e->nombre2; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="row mt-10">
                <div class="col-sm-12 table-responsive">
                  <table id="tabla_horas_extras_empleado" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                    <thead>
                      <th class="text-center">Nro.</th>
                      <th class="text-center">Empleado</th>
                      <th class="text-center">Mes</th>
                      <th class="text-center">Motivo</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Desde</th>
                      <th class="text-center">Hasta</th>

                      <th class="text-center">Sencillas</th>
                      <th class="text-center">Dobles</th>
                      <th class="text-center">Nocturnas</th>
                      <th class="text-center">Jefe Tec</th>
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
              <div class="row mt-10">
                <div class="col-sm-3">
                  <label for="totalHorasDobles">Horas Dobles</label>
                  <input type="number" step="0.01" id="totalHorasDobles" class="form-control text-right" value="0.00" readonly>
                </div>
                <div class="col-sm-3">
                  <label for="totalHorasNocturnas">Horas Nocturnas</label>
                  <input type="number" step="0.01" id="totalHorasNocturnas" class="form-control text-right" value="0.00" readonly>
                </div>
                <div class="col-sm-3">
                  <label for="totalRecargo30p">Recargo 30%</label>
                  <input type="number" step="0.01" id="totalRecargo30p" class="form-control text-right" value="0.00" readonly>
                </div>
                <div class="col-sm-3">
                  <label for="totalHorasExtras">Total Horas Extras</label>
                  <input type="number" step="0.01" id="totalHorasExtras" class="form-control text-right" value="0.00" readonly>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-plus-square" aria-hidden="true"></i> Nuevo</button>
                <button type="button" id="btn_imprimir_horas_extras_por_empleado" class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Registrar Horas Extras-->
    <div class="modal fade fs-12" id="modal_nuevo_actualizar_horas_extras" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="titulo_form_registro_mensual_horas_extras"></span> Horas Extras
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
              <input type="hidden" id="horas_extras_id_to_update">
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_registrar_horas_extras">
              <div class="row">
                <div class="col-sm-12">
                  <label for="he_motivo">Motivo</label>
                  <input type="text" name="motivo" id="he_motivo" class="form-control" placeholder="Ingrese el motivo de las horas extras." required>
                </div>
                <div class="col-sm-4">
                  <label class="mt-10" for="he_fecha">Fecha</label>
                  <input type="date" name="fecha" id="he_fecha" class="form-control" required>
                </div>
                <div class="col-sm-4">
                  <label class="mt-10" for="he_desde">Desde</label>
                  <input type="time" name="desde" id="he_desde" class="form-control" value="18:30" required>
                </div>
                <div class="col-sm-4">
                  <label class="mt-10" for="he_hasta">Hasta</label>
                  <input type="time" name="hasta" id="he_hasta" class="form-control" value="21:00" required>
                </div>
                <div class="col-sm-6">
                  <label class="mt-10" for="he_horas_sencillas">Horas Sencillas</label>
                  <input type="number" id="he_horas_sencillas" step="0.01" class="form-control" value="2.50" readonly />
                </div>
                <div class="col-sm-6">
                  <label class="mt-10" for="he_horas_dobles">Horas Dobles</label>
                  <input type="number" id="he_horas_dobles" step="0.01" class="form-control" value="5.00" readonly />
                </div>
                <div class="col-sm-6">
                  <label for="he_horas_nocturnas">Horas Nocturnas</label>
                  <input type="number" id="he_horas_nocturnas" step="0.01" class="form-control" value="1.00" readonly />
                </div>
                <div class="col-sm-6">
                  <label for="he_jefe_tecnico">Jefe Técnico</label>
                  <input type="text" name="jefe_tecnico" id="he_jefe_tecnico" class="form-control" placeholder="Jefe Técnico." required>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn_form_registro_mensual_horas_extras"></span></button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section> <!-- /.content -->

</div> <!-- /.content-wrapper -->

<script type="text/javascript">
  const mes_habilitado = <?php echo json_encode($data_mes_habilitado[0]); ?>;
  const data_meses = <?php echo json_encode($data_meses); ?>;
  let data_horas_extras_empleado, data_horas_extras_totales_mes = [],
    tabla_horas_extras_totales_js;

  // Funciones a 2do nivel, listado por emplados de sus horas extras en el mes
  // Calculo de horas sencillas, dobles, nocturnas
  $('#he_desde, #he_hasta').on('change', function() {
    const lim_hora_nocturna = 20.0; // 20:00
    const hd = $('#he_desde').val().split(':');
    const hrs_desde = (parseFloat(hd[0]) + parseFloat(hd[1]) / 60).toFixed(2);
    const ha = $('#he_hasta').val().split(':');
    const hrs_hasta = (parseFloat(ha[0]) + parseFloat(ha[1]) / 60).toFixed(2);
    const hrs_sencillas = (hrs_hasta - hrs_desde).toFixed(2);
    const hrs_dobles = (hrs_sencillas * 2).toFixed(2);
    let hrs_nocturnas = 0;
    if (hrs_hasta > lim_hora_nocturna) {
      hrs_nocturnas = (hrs_hasta - lim_hora_nocturna).toFixed(2);
      if (hrs_desde > lim_hora_nocturna) {
        hrs_nocturnas = (hrs_nocturnas - (hrs_desde - lim_hora_nocturna)).toFixed(2);
      }
    }
    $('#he_horas_sencillas').val(hrs_sencillas);
    $('#he_horas_dobles').val(hrs_dobles);
    $('#he_horas_nocturnas').val(hrs_nocturnas);
  });
  //Formulario de registro de horas extras x empleado
  $('#form_registrar_horas_extras').submit(function(e) {
    e.preventDefault();
    const data_form_send = {
      empleado: $('#horas_extras_empleado').val(),
      mes: $('#registro_mensual_horas_extras_mes').val(),
      motivo: $('#he_motivo').val(),
      fecha: $('#he_fecha').val(),
      desde: $('#he_desde').val(),
      hasta: $('#he_hasta').val(),
      sencillas: $('#he_horas_sencillas').val(),
      dobles: $('#he_horas_dobles').val(),
      nocturnas: $('#he_horas_nocturnas').val(),
      jefe_tec: $('#he_jefe_tecnico').val()
    }
    if (parseFloat(data_form_send.sencillas) <= 0) {
      time_alert('error', 'Horas!', 'La hora \'Hasta\' debe ser mayor a la hora \'Desde\'.', 2000)
        .then(() => {
          return;
        })
    } else {
      // Validar si es Registro o Actualización
      const option = $('.btn_form_registro_mensual_horas_extras').text();
      let msj_option = '',
        url_option = '',
        msj_alerta = '',
        id_hora_extra;
      if (option == 'Registrar') { // Registrar
        msj_option = 'Se registrará las horas extras.';
        url_option = '<?php echo base_url('rrhh/horasExtras/registrar'); ?>';
        msj_alerta = 'Registrado';
        id_hora_extra = 0;
      } else { // Actualizar
        msj_option = 'Se actualizará los datos del registro.';
        url_option = '<?php echo base_url('rrhh/horasExtras/actualizar'); ?>';
        msj_alerta = 'Actualizado';
        id_hora_extra = $('#horas_extras_id_to_update').val();
      }
      msg_confirmation('warning', '¿Está seguro?', msj_option)
        .then((response) => {
          if (response) {
            swloading.start();
            $.ajax({
              type: "post",
              url: url_option,
              data: {
                data_form: data_form_send,
                id_hora_extra: id_hora_extra
              },
              dataType: "json",
              success: function(response) {
                swloading.stop();
                time_alert('success', `${msj_alerta}!`, `Los datos del registro de horas extras fueron ${msj_alerta.toLowerCase()} exitosamente.`, 2000)
                  .then(() => {
                    obtenerHorasExtrasEmpleado(data_form_send.empleado);
                    $('#modal_nuevo_actualizar_horas_extras').modal('hide');
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
  });
  // Boton nuevo del modal para ir al modal de registro de horas extras
  $('#ir_form_registrar_horas_extras').submit(function(e) {
    e.preventDefault();
    const mes_form = $('#registro_mensual_horas_extras_mes').val();
    if (mes_form != mes_habilitado.mes) {
      time_alert('error', 'No permitido!', 'El mes seleccionado se encuentra cerrado.', 2000)
        .then(() => {
          return;
        })
    } else {
      // Limpiar form
      $('#he_motivo').val('');
      $('#he_jefe_tecnico').val('');
      // Parametros modal
      $('.titulo_form_registro_mensual_horas_extras').text('Registrar');
      $('.btn_form_registro_mensual_horas_extras').text('Registrar');
      $('#modal_nuevo_actualizar_horas_extras').modal('show');
    }
  });

  function llenarTablaHorasExtrasEmpleado() {
    let thrsdob = 0,
      thrsnoc = 0,
      thrs30p = 0,
      thrs = 0;
    let fila_in = '';
    $('#tabla_horas_extras_empleado tbody').empty();
    data_horas_extras_empleado.forEach((fila, index) => {
      thrsdob += parseFloat(fila.dobles);
      thrsnoc += parseFloat(fila.nocturnas);
      thrs30p += parseFloat(fila.nocturnas) * 0.3;
      fila_in += `
                <tr>
                    <td>${index+1}</td>
                    <td>${fila.empleado}</td>
                    <td>${fila.mes.split('-').reverse().join('/')}</td>
                    <td>${fila.motivo}</td>
                    <td>${fila.fecha.split('-').reverse().join('/')}</td>
                    <td>${fila.desde}</td>
                    <td>${fila.hasta}</td>
                    <td>${fila.sencillas}</td>
                    <td>${fila.dobles}</td>
                    <td>${fila.nocturnas}</td>
                    <td>${fila.jefe_tec}</td>
                    <td>
                        ${(mes_habilitado.mes == fila.mes) ?
                        `<button type="button" onclick="editarHoraExtra(${fila.id})" class="btn btn-primary btn-xs" title="Editar registro"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                        <button type="button" onclick="eliminarHoraExtra(${fila.id}, ${fila.empleado})" class="btn btn-danger btn-xs" title="Eliminar registro"><i class="fa fa-close" aria-hidden="true"></i></button>`:`-`}
                    </td>
                </tr>
            `;
    });
    thrs = thrs30p + thrsdob;
    $('#tabla_horas_extras_empleado tbody').append(fila_in);
    $('#totalHorasDobles').val(thrsdob.toFixed(2));
    $('#totalHorasNocturnas').val(thrsnoc.toFixed(2));
    $('#totalRecargo30p').val(thrs30p.toFixed(2));
    $('#totalHorasExtras').val(thrs.toFixed(2));
    if (data_horas_extras_empleado.length == 0) {
      $('#tabla_horas_extras_empleado tbody').append(`<tr><td colspan="12">No existen horas extras registradas para el empleado seleccionado</td></tr>`);
    }
  }

  function obtenerHorasExtrasEmpleado(empleado) {
    const mes = $('#registro_mensual_horas_extras_mes').val();
    swloading.start('Cargando.');
    $.ajax({
      type: "post",
      url: "<?php echo base_url('rrhh/horasExtras/get_horas_extras'); ?>",
      data: {
        emp: empleado,
        mes: mes
      },
      dataType: "json",
      success: function(response) {
        swloading.stop();
        data_horas_extras_empleado = response;
        llenarTablaHorasExtrasEmpleado();
      },
      error: function(error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });
  }
  $('#horas_extras_empleado').on('change', function() {
    const empleado = $('#horas_extras_empleado').val();
    if (empleado != null) {
      obtenerHorasExtrasEmpleado(empleado);
    } else {
      $('#tabla_horas_extras_empleado tbody').empty();
      $('#tabla_horas_extras_empleado tbody').append(`<tr><td colspan="12">Seleccione un empleado</td></tr>`);
    }
  });
  /* Registrar Nuevo Registro Mensual - Horas Extras */
  $('#btn_nuevo_registro_mensual_horas_extras').on('click', function() {
    // Abre el modal, se listan horas extras por empleados
    // Reiniciar Modal
    $('#horas_extras_empleado').val('').change();
    $('#tabla_horas_extras_empleado tbody').empty();
    $('#tabla_horas_extras_empleado tbody').append(`<tr><td colspan="12">Seleccione un empleado</td></tr>`);
    // Contadores modal
    $('#totalHorasDobles').val('0.00');
    $('#totalHorasNocturnas').val('0.00');
    $('#totalRecargo30p').val('0.00');
    $('#totalHorasExtras').val('0.00');
    // add minimo maximo fecha (Es para el siguiente modal, para registro de horas extras)
    const fecha = $('#registro_mensual_horas_extras_mes').val().split('-');
    $('#he_fecha').val(fecha.join('-'));
    $('#he_fecha').prop('min', fecha[0] + '-' + fecha[1] + '-01');
    $('#he_fecha').prop('max', fecha.join('-'));
    // Mostrar Modal
    $('#modal_nuevo_actualizar_registro_mensual_horas_extras').modal('show');
  });

  function editarHoraExtra(id_hora_extra) {
    // preparamos el formulario - modal
    $('#horas_extras_id_to_update').val(id_hora_extra); // asigno el registro a editar en el form
    $('.titulo_form_registro_mensual_horas_extras').text('Editar');
    $('.btn_form_registro_mensual_horas_extras').text('Actualizar');
    // hora extra a editar
    const hora_extra_editar = data_horas_extras_empleado.find(element => element.id == id_hora_extra);
    // llenado del form con los datos de la hora extra a editar
    $('#he_motivo').val(hora_extra_editar.motivo);
    $('#he_fecha').val(hora_extra_editar.fecha);
    $('#he_desde').val(hora_extra_editar.desde);
    $('#he_hasta').val(hora_extra_editar.hasta);
    $('#he_horas_sencillas').val(hora_extra_editar.sencillas);
    $('#he_horas_dobles').val(hora_extra_editar.dobles);
    $('#he_horas_nocturnas').val(hora_extra_editar.nocturnas);
    $('#he_jefe_tecnico').val(hora_extra_editar.jefe_tec);
    // Abrimos formulario - modal
    $('#modal_nuevo_actualizar_horas_extras').modal('show');
  }
  // autofocus sobre el importe
  $('#modal_nuevo_actualizar_horas_extras').on('shown.bs.modal', function(e) {
    $('#he_motivo').focus();
  });

  function eliminarHoraExtra(id_hora_extra, empleado) {
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "post",
            url: "<?php echo base_url('rrhh/horasExtras/eliminar'); ?>",
            data: {
              id_hora_extra: id_hora_extra
            },
            dataType: "text",
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Eliminado!', 'El registro de horas extras fué eliminado exitosamente.', 2000)
                .then(() => {
                  obtenerHorasExtrasEmpleado(empleado);
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
  $('#btn_imprimir_horas_extras_por_empleado').on('click', function() {
    if ($('#horas_extras_empleado').val() == null) {
      $('#horas_extras_empleado').focus(); // enfocar para mostrar el error
      return;
    }
    const data = $('#registro_mensual_horas_extras_mes').val() + ' ' + $('#horas_extras_empleado').val();
    const url_re = "<?php echo base_url('rrhh/horasExtras/reporte_empleado'); ?>?data=" + btoa(data);
    window.open(url_re); // abre en otra pestaña
  });

  // Funciones a 1er nivel, listado de emplados con horas extras totales
  function llenarTablaHorasExtrasTotalesMes() {
    tabla_horas_extras_totales_js.clear().draw();
    data_horas_extras_totales_mes.forEach((fila, index) => {
      tabla_horas_extras_totales_js.row.add([
        (index + 1),
        fila.empleado,
        fila.paterno,
        fila.materno,
        fila.nombre1 + ' ' + fila.nombre2,
        fila.total_sencillas,
        fila.total_dobles,
        fila.total_nocturnas,
      ]).draw(false);
    });
  }

  function obtenerDatosRegMensuales(mes) {
    swloading.start('Cargando.');
    $.ajax({
      type: "post",
      url: "<?php echo base_url('rrhh/horasExtras/get_horas_extras_totales'); ?>",
      data: {
        mes: mes
      },
      dataType: "json",
      success: function(response) {
        swloading.stop();
        const data_empleados = response.data_empleados;
        const data_horas_extras = response.data_horas_extras;
        data_horas_extras_totales_mes = []; // reset array
        data_empleados.forEach((emp) => {
          let sum_sencillas = 0,
            sum_dobles = 0,
            sum_nocturnas = 0,
            sw = false;
          data_horas_extras.forEach((he) => {
            if (he.empleado == emp.empleado) {
              sw = true;
              sum_sencillas += parseFloat(he.sencillas);
              sum_dobles += parseFloat(he.dobles);
              sum_nocturnas += parseFloat(he.nocturnas);
            }
          });
          if (sw) {
            let data_aux = emp;
            data_aux['total_sencillas'] = sum_sencillas.toFixed(2);
            data_aux['total_dobles'] = sum_dobles.toFixed(2);
            data_aux['total_nocturnas'] = sum_nocturnas.toFixed(2);
            data_horas_extras_totales_mes.push(data_aux);
          }
        });
        llenarTablaHorasExtrasTotalesMes();
      },
      error: function(error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });
  }

  function iniciar_ventana() {
    obtenerDatosRegMensuales(data_meses[0].mes); // Tabla principal, totales horas extras
  }
  /* Cambio Mes Select */
  $('#registro_mensual_horas_extras_mes').on('change', function() {
    if ($('#registro_mensual_horas_extras_mes').val() == null)
      $('#registro_mensual_horas_extras_mes').val(data_meses[0].mes).change();
    obtenerDatosRegMensuales($('#registro_mensual_horas_extras_mes').val());
  });
  $('#btn_imprimir_resumen_mensual').on('click', function() {
    const data = $('#registro_mensual_horas_extras_mes').val();
    const url_rm = "<?php echo base_url('rrhh/horasExtras/reporte'); ?>?data=" + btoa(data);
    window.open(url_rm); // abre en otra pestaña
  });
  // Para actualizar la tabla principal con datos oficial, al cerrar modal
  $("#modal_nuevo_actualizar_registro_mensual_horas_extras").on("hidden.bs.modal", function() {
    const mes_form = $('#registro_mensual_horas_extras_mes').val();
    obtenerDatosRegMensuales(mes_form); // Tabla principal, totales horas extras
  });
  $(document).ready(function() {
    tabla_horas_extras_totales_js = $('#tabla_horas_extras_totales').DataTable(DATA_TABLE);
    iniciar_ventana(); // carga de datos
  });
</script>