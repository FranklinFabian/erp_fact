<!-- Admin Home Start -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_module('Vacaciones') ?></small>
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
    <!-- <div class="row">
            <div class="col-sm-12 text-center">

            </div>
        </div> -->

    <!--Add Invoice -->
    <div class="row mt-10">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">

          <!-- Header -->
          <div class="panel-heading">
            <div class="panel-title">
              <h4><strong><?php echo "Vacaciones"; ?></strong></h4>
            </div>
          </div> <!-- Header End -->
          <!-- Body -->
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-4">
                <label for="empleado_vacaciones">Empleado</label>
                <select name="empleado_vacaciones" id="empleado_vacaciones" class="form-control" style="width:100%;">
                  <?php foreach ($data_empleados as $e) : ?>
                    <option value="<?php echo $e->empleado; ?>"><?php echo $e->paterno . ' ' . $e->materno . ' ' . $e->nombre1 . ' ' . $e->nombre2; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-sm-4">
                <label for="mes_asistencia">Mes</label>
                <input type="text" id="mes_asistencia" class="form-control" value="<?= date('d/m/Y', strtotime($data_mes_habilitado[0]->mes)) ?>" readonly>
              </div>
              <div class="col-sm-4 text-center">
                <label for="" class="d-block">&nbsp;</label><br>
                <div class="btn-group btn-group-sm">
                  <div id="contenedor_botones_vacaciones">
                    <button type="button" onclick="actualizar_datos_vacaciones()" class="btn btn-info btn-sm"><i class="fa fa-refresh" aria-hidden="true"></i> Actualizar Datos</button>
                    <button type="button" onclick="reporte_vacaciones_periodo()" class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true"></i> Reporte Periodo Activo</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-10">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table id="tabla_detalle_vacaciones_empleado" class="table table-bordered table-extrasmall">
                    <thead>
                      <tr>
                        <th rowspan="2">Saldo Gestión Anterior</th>
                        <th rowspan="2">Antiguedad</th>
                        <th rowspan="2">Vacación Gestión</th>
                        <th rowspan="2">Vacación a Favor</th>
                        <th rowspan="2">Gestión</th>
                        <th colspan="12">REGISTRO DE VACACIONES</th>
                        <th rowspan="2">Total Vacación</th>
                        <th rowspan="2">Saldo Vacaciones al <?= date('d/m/Y') ?></th>
                      </tr>
                      <tr>
                        <th><span id="nombres_mes_1" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_2" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_3" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_4" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_5" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_6" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_7" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_8" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_9" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_10" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_11" class="text-vertical"></span></th>
                        <th><span id="nombres_mes_12" class="text-vertical"></span></th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- dinámico -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="row mt-10" hidden>
              <div class="col-sm-12">
                <table id="tabla_asistencia_empleado" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                  <thead>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Control</th>
                    <th class="text-center">Descipción</th>
                    <th class="text-center">Nota</th>
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
          </div> <!-- Body End -->
        </div>
      </div>
    </div>

    <!-- Modal Registrar Vacaciones Empleado -->
    <div class="modal fade fs-12" id="modal_registrar_vacaciones_empleado" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Registrar Vacaciones
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_registrar_vacacion_empleado">
              <div class="row">
                <div class="col-md-12 text-center">
                  <strong>Empleado: </strong><span id="vacacion_empleado"></span><br />
                  <strong>Antiguedad: </strong><span id="vacacion_antiguedad"></span> años.<br />
                  <strong>Periodo Gestión: </strong><span id="vacacion_periodo_gestion"></span><br />
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12">
                  <label for="vacacion_dias_gestion_anterior">Días Gestión Anterior</label>
                  <input type="text" name="vacacion_dias_gestion_anterior" id="vacacion_dias_gestion_anterior" class="form-control" readonly required>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12">
                  <label for="vacacion_dias_gestion">Días Gestión</label>
                  <input type="text" name="vacacion_dias_gestion" id="vacacion_dias_gestion" class="form-control" readonly required>
                  <input type="text" id="vacacion_data_vacacion" hidden>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Aceptar</button>
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
  const data_mes_habilitado = <?php echo json_encode($data_mes_habilitado); ?>;
  const mes_habilitado = data_mes_habilitado[0].mes;
  let data_buscar_vacaciones = {
    registro_vacaciones_id: '',
    gestion_inicio: '',
    gestion_final: '',
    mes_inicio: '',
    mes_final: '',
  };

  async function getDataVacacionesEmpleado(empleado) {
    const res = await $.ajax({
      type: "post",
      url: "<?php echo base_url('rrhh/vacaciones/get_vacaciones_empleado'); ?>",
      data: {
        empleado
      },
      dataType: "json",
      success: function(response) {
        return response;
      }
    });
    return res;
  }
  async function getVacacionesEmpleadoPeriodo(empleado, fecha_inicial, fecha_final) {
    return await $.ajax({
      type: "post",
      url: "<?php echo base_url('rrhh/vacaciones/get_vacaciones_empleado_periodo'); ?>",
      data: {
        empleado,
        fecha_inicial,
        fecha_final
      },
      dataType: "json",
      success: function(response) {
        return response;
      }
    });
  }

  async function llenarDetalleVacacionesEmpleado(empleado) {
    // Limpiar REGISTRO DE VACACIONES
    for (let i = 0; i < 12; i++) {
      const identificador_mes = '#nombres_mes_' + (i + 1);
      $(identificador_mes).text(getMonthName(i).toUpperCase());
    }
    // Consultar información de vacaciones y datos del empleado
    const res = await getDataVacacionesEmpleado(empleado);
    // Calculo Antiguedad Empleado - años
    const fecha1 = moment(res.data_empleado.fecha_ingreso);
    const fecha2 = moment(mes_habilitado); // Al mes habilitado
    const antiguedad_anios = fecha2.diff(fecha1, 'years', true); // con decimales
    const mes_habilitado_formato = mes_habilitado.split('-').reverse().join('/'); // dd/mm/yyyy
    const gestion_habilitada = mes_habilitado.split('-')[0];
    const mes_ingreso = res.data_empleado.fecha_ingreso.split('-')[1];
    const fecha_ingreso_formato = res.data_empleado.fecha_ingreso.split('-').reverse().join('/'); // dd/mm/yyyy
    // Datos generales

    let contenido_vacaciones = '';
    let registro_vacaciones = '';
    // Verificar si tiene registro de vacaciones
    $('#contenedor_botones_vacaciones').hide();
    if (res.data_vacaciones.length !== 0) {
      // Data para buscar vacaciones en asistencia
      const registro_vacacion_activo = res.data_vacaciones.find(v => v.estado == 1); // ACTIVO
      data_buscar_vacaciones.registro_vacaciones_id = registro_vacacion_activo.id;
      data_buscar_vacaciones.gestion_inicio = registro_vacacion_activo.gestion_inicio;
      data_buscar_vacaciones.gestion_final = registro_vacacion_activo.gestion_final;

      // Mostrar detalle de vacaciones
      $('#contenedor_botones_vacaciones').show();
      data_buscar_vacaciones.mes_inicio = mes_ingreso; // Para buscar las vacaciones en asistencia
      let mes_inicio = getMonthName(parseInt(mes_ingreso) - 1);
      let mes_final = '';
      if (parseInt(mes_ingreso) === 1) {
        mes_final = getMonthName(12 - 1);
        data_buscar_vacaciones.mes_final = 12; // Para buscar las vacaciones en asistencia
      } else {
        mes_final = getMonthName(parseInt(mes_ingreso) - 1 - 1);
        data_buscar_vacaciones.mes_final = mes_ingreso - 1; // Para buscar las vacaciones en asistencia
      }

      // Cambiar nombres REGISTRO DE VACACIONES / empleado y contar numero de vacaciones en el mes
      for (let i = 0; i < 12; i++) {
        const identificador_mes = '#nombres_mes_' + (i + 1);
        const numero_mes = (parseInt(mes_ingreso) + i - 1) % 12;
        $(identificador_mes).text(getMonthName(numero_mes).toUpperCase());
      }
      let ultima_antiguedad = '';
      let ultimo_gestion_inicio = '';
      let ultimo_gestion_final = '';
      // LLenar Detalle Registros Vacación Empleado
      for (const item of res.data_vacaciones) {
        // Obtener vacaciones del periodo que se recorre
        const fecha_ini = item.gestion_inicio + '-' + data_buscar_vacaciones.mes_inicio + '-01';
        const fecha_fin = item.gestion_final + '-' + data_buscar_vacaciones.mes_final + '-31';
        const data_vacaciones_periodo = await getVacacionesEmpleadoPeriodo(item.empleado, fecha_ini, fecha_fin);
        let vacaciones_periodo = '';
        for (let i = 0; i < 12; i++) {
          const numero_mes = (parseInt(mes_ingreso) + i - 1) % 12;
          let dias_vacaciones_mes = data_vacaciones_periodo.VA.filter(vp => parseInt(vp.mes.split('-')[1]) == (numero_mes + 1)).length;
          dias_vacaciones_mes += data_vacaciones_periodo.L1.filter(vp => parseInt(vp.mes.split('-')[1]) == (numero_mes + 1)).length;
          dias_vacaciones_mes += (data_vacaciones_periodo.L2.filter(vp => parseInt(vp.mes.split('-')[1]) == (numero_mes + 1)).length) / 2;
          vacaciones_periodo += `<td>${dias_vacaciones_mes}</td>`;
        }
        // Armar template vacaciones periodo
        const total_vacacion_gestion = parseFloat(item.dias_gestion_anterior) + parseFloat(item.dias_gestion) - parseFloat(item.dias_gestion_saldo); // suma de las vacaciones de todo el año
        contenido_vacaciones += `
                    <tr>
                        <td>${item.dias_gestion_anterior}</td>
                        <td>${item.antiguedad}</td>
                        <td>${item.dias_gestion}</td>
                        <td>${(parseFloat(item.dias_gestion_anterior) + parseFloat(item.dias_gestion)).toFixed(2)}</td>
                        <td>${mes_inicio}/${item.gestion_inicio} a ${mes_final}/${item.gestion_final}</td>
                        ${vacaciones_periodo}
                        <td>${total_vacacion_gestion.toFixed(2)}</td>
                        <td>${item.dias_gestion_saldo}</td>
                    </tr>
                `;
        ultima_antiguedad = item.antiguedad;
        ultimo_dias_gestion_saldo = item.dias_gestion_saldo;
        ultimo_gestion_inicio = item.gestion_inicio;
        ultimo_gestion_final = item.gestion_final;
      }
      // Verificar si está disponible para crear 2do o superior registro de vacación
      //console.log(ultimo_gestion_inicio)
      //console.log(ultimo_gestion_final)
      if (ultimo_gestion_inicio == ultimo_gestion_final) {
        // El periodo abarca una gestión (ENERO a DICIEMBRE)
        // Verificar si cumple de acuerdo a la gestion_habilitada
        if (parseInt(gestion_habilitada) > parseInt(ultimo_gestion_final)) {
          // Habilitar para crear su siguiente registro de vacación
          registro_vacaciones = template_crear_registro_vacacion(empleado, mes_ingreso, gestion_habilitada, antiguedad_anios, mes_habilitado_formato, fecha_ingreso_formato, ultimo_dias_gestion_saldo);
        } else {
          registro_vacaciones = `
                        <tr>
                            <td colspan="19"><strong>Antiguedad: </strong>${antiguedad_anios.toFixed(4)} años al ${mes_habilitado_formato}<br /><strong>Fecha de ingreso: </strong>${fecha_ingreso_formato}<br />El empleado aún no está habilitado para crear el siguiente registro de vacación.</td>
                        </tr>`;
        }
      } else {
        // El periodo abarca dos gestiones (mesX a DICIEMBRE, ENERO a mesX-1)
        // Verificar si cumple de acuerdo a la gestion_habilitada
        if (parseInt(gestion_habilitada) >= parseInt(ultimo_gestion_final)) {
          // debe cumplir antiguedad_actual > (int)ultima_antiguedad + 1
          if (antiguedad_anios.toFixed(4) >= parseInt(ultima_antiguedad) + 1) {
            // Habilitar para crear su siguiente registro de vacación
            registro_vacaciones = template_crear_registro_vacacion(empleado, mes_ingreso, gestion_habilitada, antiguedad_anios, mes_habilitado_formato, fecha_ingreso_formato, ultimo_dias_gestion_saldo);
          }
        } else {
          // Aun no está habilitado para vacaciones
          registro_vacaciones = `
                        <tr>
                            <td colspan="19"><strong>Antiguedad: </strong>${antiguedad_anios.toFixed(4)} años al ${mes_habilitado_formato}<br /><strong>Fecha de ingreso: </strong>${fecha_ingreso_formato}<br />El empleado aún no está habilitado para crear el siguiente registro de vacación.</td>
                        </tr>`;
        }
      }

      /* registro_vacaciones = `
              <tr>
                  <td colspan="19"><strong>Antiguedad: </strong>${antiguedad_anios.toFixed(4)} años al ${mes_habilitado_formato}<br /><strong>Fecha de ingreso: </strong>${fecha_ingreso_formato}<br />El empleado aún no cuenta con 1 año de antiguedad.</td>
              </tr>`; */
    } else {
      // Verificar Antiguedad - para primer registro
      if (antiguedad_anios >= 1) {
        // Habilitar para su primer registro de vacaciones
        registro_vacaciones = template_crear_registro_vacacion(empleado, mes_ingreso, gestion_habilitada, antiguedad_anios, mes_habilitado_formato, fecha_ingreso_formato, 0);
      } else {
        // Aun no está habilitado para vacaciones
        registro_vacaciones = `
                    <tr>
                        <td colspan="19"><strong>Antiguedad: </strong>${antiguedad_anios.toFixed(4)} años al ${mes_habilitado_formato}<br /><strong>Fecha de ingreso: </strong>${fecha_ingreso_formato}<br />El empleado aún no cuenta con 1 año de antiguedad.</td>
                    </tr>`;
      }
    }
    $('#tabla_detalle_vacaciones_empleado tbody').append(contenido_vacaciones + registro_vacaciones);
  }
  $('#empleado_vacaciones').on('change', function() {
    $('#tabla_detalle_vacaciones_empleado tbody').empty();
    const empleado = $('#empleado_vacaciones').val();
    if (empleado == null) {
      $('#tabla_detalle_vacaciones_empleado tbody').append('<tr><td colspan="19">Seleccione un empleado</td><tr>');
    } else {
      llenarDetalleVacacionesEmpleado(empleado);
    }
  });
  // Template Crear Registro de Vacaciones Empleado
  function template_crear_registro_vacacion(empleado, mes_ingreso, gestion_habilitada, antiguedad_anios, mes_habilitado_formato, fecha_ingreso_formato, dias_gestion_anterior_saldo) {
    // Rango de vacaciones mes/año inicio y final
    let mes_inicio = getMonthName(parseInt(mes_ingreso) - 1);
    let gestion_inicio = gestion_habilitada;
    let mes_final = '';
    let gestion_final = '';

    if (parseInt(mes_ingreso) === 1) {
      mes_final = getMonthName(12 - 1);
      gestion_final = gestion_habilitada;
    } else {
      mes_final = getMonthName(parseInt(mes_ingreso) - 1 - 1);
      gestion_final = (parseInt(gestion_habilitada) + 1);
    }
    const mes_inicio_gestion = mes_inicio + '/' + gestion_inicio;
    const mes_final_gestion = mes_final + '/' + gestion_final;
    const template = `
      <tr>
        <td colspan="19">
          <strong>Antiguedad: </strong>${antiguedad_anios.toFixed(2)} años al ${mes_habilitado_formato}<br /><strong>Fecha de Ingreso: </strong>${fecha_ingreso_formato}<br />
          <button
            onclick="crear_registro_vacaciones('${empleado}', '${antiguedad_anios}', '${gestion_inicio}', '${gestion_final}', '${mes_inicio_gestion}', '${mes_final_gestion}', '${mes_habilitado_formato}', '${fecha_ingreso_formato}', '${dias_gestion_anterior_saldo}')"
            class="btn btn-info btn-xs mt-2 fs-10 mb-1">
            Crear Registro de Vacaciones (${mes_inicio_gestion} - ${mes_final_gestion})
          </button>
        </td>
      </tr>`;

    return template;
  }
  // Crear Registro de Vacaciones Empleado
  function crear_registro_vacaciones(empleado, antiguedad_anios, gestion_inicio, gestion_final, mes_inicio_gestion, mes_final_gestion, mes_habilitado_formato, fecha_ingreso_formato, dias_gestion_anterior_saldo) {
    const data_vacacion = {
      empleado: empleado,
      antiguedad: parseFloat(antiguedad_anios).toFixed(2),
      gestion_inicio: gestion_inicio,
      gestion_final: gestion_final,
      dias_gestion: 0,
      dias_gestion_anterior: parseFloat(dias_gestion_anterior_saldo).toFixed(2),
    }
    // Cálculo de los dias asignados
    if (parseInt(antiguedad_anios) <= 5) {
      data_vacacion.dias_gestion = 15;
    } else if (parseInt(antiguedad_anios) > 5 && parseInt(antiguedad_anios) <= 10) {
      data_vacacion.dias_gestion = 20;
    } else if (parseInt(antiguedad_anios) > 10) {
      data_vacacion.dias_gestion = 30;
    }
    // Preparar y Abrir Modal Crear Registro de Vacaciones
    $('#vacacion_empleado').text(data_vacacion.empleado);
    $('#vacacion_antiguedad').text(parseFloat(antiguedad_anios).toFixed(2));
    $('#vacacion_periodo_gestion').text(`${mes_inicio_gestion} a ${mes_final_gestion}`);
    $('#vacacion_dias_gestion_anterior').val(data_vacacion.dias_gestion_anterior);
    $('#vacacion_dias_gestion').val(data_vacacion.dias_gestion.toFixed(2));
    $('#vacacion_data_vacacion').val(JSON.stringify(data_vacacion));
    $('#modal_registrar_vacaciones_empleado').modal('show');
  }
  $('#form_registrar_vacacion_empleado').submit(function(e) {
    e.preventDefault();
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          swloading.start();
          const data_vacacion = JSON.parse($('#vacacion_data_vacacion').val());
          $.ajax({
            type: 'post',
            url: '<?php echo base_url('rrhh/vacaciones/registrar'); ?>',
            data: {
              data: data_vacacion
            },
            dataType: 'json',
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Registrado!', 'El registro se creó correctamente.', 2000)
                .then(() => {
                  $('#modal_registrar_vacaciones_empleado').modal('hide');
                  $('#empleado_vacaciones').change();
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

  // Actualizar datos de vacaciones empleado
  function actualizar_datos_vacaciones() {
    let empleado, fecha_inicial, fecha_final;
    [empleado, fecha_inicial, fecha_final] = preparar_datos_busqueda_vacaciones_registro_activo();

    swloading.start();
    $.ajax({
      type: "post",
      url: "<?= base_url('rrhh/vacaciones/actualizar') ?>",
      data: {
        empleado,
        fecha_inicial,
        fecha_final,
        empleado_vacaciones_id: data_buscar_vacaciones.registro_vacaciones_id
      },
      dataType: "json",
      success: function(response) {
        swloading.stop();
        time_alert('success', 'Datos actualizados.', 'Los datos se actualizaron correctamente.', 2000)
          .then(() => {
            $('#empleado_vacaciones').change();
          });
      },
      error: function(error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });
  }

  function preparar_datos_busqueda_vacaciones_registro_activo() {
    const empleado = $('#empleado_vacaciones').val();
    const fecha_inicial = data_buscar_vacaciones.gestion_inicio + '-' + data_buscar_vacaciones.mes_inicio + '-01';
    const dias_mes = new Date(data_buscar_vacaciones.gestion_final, data_buscar_vacaciones.mes_final, 0).getDate();
    const fecha_final = data_buscar_vacaciones.gestion_final + '-' + data_buscar_vacaciones.mes_final + '-' + dias_mes;
    return [empleado, fecha_inicial, fecha_final];
  }

  // Reporte de vacaciones periodo activo
  function reporte_vacaciones_periodo() {
    let empleado, fecha_inicial, fecha_final;
    [empleado, fecha_inicial, fecha_final] = preparar_datos_busqueda_vacaciones_registro_activo();
    const data = empleado + ' ' + fecha_inicial + ' ' + fecha_final;
    const url_rv = "<?php echo base_url('rrhh/asistencias/reporte_vacaciones'); ?>?data=" + btoa(data);
    window.open(url_rv);
  }

  /* Menu collapse */
  window.onload = function() {
    $('body').addClass("sidebar-mini sidebar-collapse");
  }
  $(document).ready(function() {
    $('#empleado_vacaciones').change();
    /*
    $("#printconfirmodal").on('keydown', function ( e ) {
        var key = e.which || e.keyCode;
        if (key == 13) {
            $('#yes').trigger('click');
        }
    });
    */
  });
</script>
