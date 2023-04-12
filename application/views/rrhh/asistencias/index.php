<!-- Admin Home Start -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_module('Ítems') ?></small>
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
      <div class="col-sm-12 text-center">
        <div class="btn-group btn-group-sm">
          <button type="button" id="btn_registrar_dias_mes_empleados" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Registrar Días Mes</button>
          <button type="button" id="btn_capturar_asistencias_empleados" class="btn btn-primary btn_"><i class="fa fa-check-square-o" aria-hidden="true"></i> Capturar Asistencias</button>
          <button type="button" id="btn_registrar_asistencias_empleados" class="btn btn-warning btn-sm"><i class="fa fa-plus-square"></i> Registrar Asistencias</button>
        </div>
      </div>
    </div>

    <!--Add Invoice -->
    <div class="row mt-10">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <!-- Header -->
          <div class="panel-heading">
            <div class="panel-title">
              <h4><strong><?php echo "Asistencias"; ?></strong></h4>
            </div>
          </div> <!-- Header End -->
          <!-- Body -->
          <div class="panel-body">
            <div class="row mt-10">
              <div class="col-sm-4">
                <label for="empleado_asistencia">Empleado</label>
                <select name="empleado_asistencia" id="empleado_asistencia" class="form-control" style="width:100%;">
                  <?php foreach ($data_empleados as $e) : ?>
                    <option value="<?php echo $e->empleado; ?>"><?php echo $e->paterno . ' ' . $e->materno . ' ' . $e->nombre1 . ' ' . $e->nombre2; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-sm-4">
                <label for="mes_asistencia">Mes</label>
                <input type="text" id="mes_asistencia" class="form-control" value="<?= date('d/m/Y', strtotime($data_mes_habilitado[0]->mes)); ?>" readonly>
              </div>
              <div class="col-sm-4 text-center mt-10">
                <div class="btn-group btn-group-sm mt-10">
                  <button type="button" id="btn_registrar_ausencias" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Registrar Asistencias</button>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-print" aria-hidden="true"></i> Reportes
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right">
                      <!-- pull-right alinear a la derecha -->
                      <li class="c-pointer"><a id="btn_reporte_simple_asistencia"><i class="fa fa-print" aria-hidden="true"></i> Reporte Simple de Asistencia</a></li>
                      <li class="c-pointer"><a id="btn_reporte_vacaciones"><i class="fa fa-print" aria-hidden="true"></i> Reporte Vacaciones</a></li>
                      <li class="c-pointer"><a id="btn_reporte_otros"><i class="fa fa-print" aria-hidden="true"></i> Reporte Otros</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-10">
              <div class="col-sm-12">
                <div class="table-responsive">
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
                  </table>
                </div>
              </div>
            </div>
          </div> <!-- Body End -->
        </div>
      </div>
    </div>
    <!-- Modal Registrar Días Mes -->
    <div class="modal fade fs-12" id="modal_registrar_dias_mes" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Registrar Días a Empleados
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_registrar_dias_mes">
              <div class="row">
                <div class="col-sm-12">
                  <label class="mt-10" for="mes_registrar_dias_mes">Mes</label>
                  <select name="mes_registrar_dias_mes" id="mes_registrar_dias_mes" class="form-control" style="width:100%;" required>
                    <?php foreach ($data_mes_habilitado as $m) : ?>
                      <option value="<?php echo $m->mes; ?>"><?php echo date('d/m/Y', strtotime($m->mes)); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <br>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Aceptar</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Capturar Asistencias -->
    <div class="modal fade fs-12" id="modal_capturar_asistencias" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Captura de Asistencia
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_capturar_asistencias">
              <div class="row">
                <div class="col-sm-12">
                  Capturar asistencia...
                </div>
              </div>
              <br>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Capturar</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Actualizar Asistencia -->
    <div class="modal fade fs-12" id="modal_registro_asistencia" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Registro de Asistencia
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
              <input type="hidden" id="nr_empleado">
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_registrar_asistencia">
              <div class="row">
                <div class="col-sm-12">
                  <label for="nr_fecha">Fecha</label>
                  <input type="text" id="nr_fecha" class="form-control" readonly />
                  <label for="nr_control">Control</label>
                  <select name="nr_control" id="nr_control" class="form-control" style="width:100%;" required>
                    <?php foreach ($data_control as $c) : ?>
                      <option value="<?php echo $c->control; ?>"><?php echo $c->descripcion; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label class="mt-10" for="nr_nota">Nota</label>
                  <textarea name="nr_nota" id="nr_nota" class="form-control" rows="3" required></textarea>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Registrar</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Registro Asistencias entre rango de Fechas EMPLEADO/EMPLEADOS -->
    <div class="modal fade fs-12" id="modal_registro_asistencias_empleado_empleados" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Registro de Asistencias
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
            <div class="text-center">
              <span id="titulo_registro_asistencias">Empleado</span>
            </div>
          </div>
          <div class="modal-body">
            <form action="#" id="form_registro_ausencias">
              <div class="row">
                <div class="col-sm-12">
                  <label for="reg_ausencias_control">Control</label>
                  <select name="reg_ausencias_control" id="reg_ausencias_control" class="form-control" style="width:100%;" required>
                    <?php foreach ($data_control as $c) : ?>
                      <option value="<?php echo $c->control; ?>"><?php echo $c->descripcion; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-sm-12">
                  <label class="mt-10" for="reg_ausencias_fecha_desde">Desde</label>
                  <input type="date" name="reg_ausencias_fecha_desde" id="reg_ausencias_fecha_desde" class="form-control" value="<?= date('Y-m', strtotime($data_mes_habilitado[0]->mes)) . '-01' ?>" min="<?= date('Y-m', strtotime($data_mes_habilitado[0]->mes)) . '-01' ?>" max="<?= date('Y-m-d', strtotime($data_mes_habilitado[0]->mes)) ?>" required>
                  <!-- <input type="time" name="reg_ausencias_hora_desde" id="reg_ausencias_hora_desde" class="form-control mt-5" value="08:00" required> -->

                  <label class="mt-10" for="reg_ausencias_fecha_hasta">Hasta</label>
                  <input type="date" name="reg_ausencias_fecha_hasta" id="reg_ausencias_fecha_hasta" class="form-control" value="<?= date('Y-m', strtotime($data_mes_habilitado[0]->mes)) . '-01' ?>" min="<?= date('Y-m', strtotime($data_mes_habilitado[0]->mes)) . '-01' ?>" max="<?= date('Y-m-d', strtotime($data_mes_habilitado[0]->mes)) ?>" required>
                  <!-- <input type="time" name="reg_ausencias_hora_hasta" id="reg_ausencias_hora_hasta" class="form-control mt-5" value="18:30" required> -->

                  <!-- <label class="mt-10" for="reg_ausencias_dias_habiles">Días Hábiles</label>
                                    <input type="number" name="reg_ausencias_dias_habiles" id="reg_ausencias_dias_habiles" class="form-control" value="0" min="1" readonly required> -->

                  <label class="mt-10" for="reg_ausencias_nota">Nota</label>
                  <textarea name="reg_ausencias_nota" id="reg_ausencias_nota" class="form-control" rows="3" required></textarea>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Registrar</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Reporte -->
    <div class="modal fade fs-12" id="modal_reporte_simple_asistencia" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Reporte Simple de Asistencia
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_reporte_simple_asistencia">
              <div class="row">
                <div class="col-sm-12">
                  <label for="rsa_fecha_inicio">Fecha inicio reporte</label>
                  <input type="date" name="rsa_fecha_inicio" id="rsa_fecha_inicio" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                  <label class="mt-10" for="rsa_fecha_final">Fecha final reporte</label>
                  <input type="date" name="rsa_fecha_final" id="rsa_fecha_final" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Generar</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Reporte Vacaciones -->
    <div class="modal fade fs-12" id="modal_reporte_vacaciones" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Reporte de Vacaciones - Licencias
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_reporte_vacaciones">
              <div class="row">
                <div class="col-sm-12">
                  <label for="rv_fecha_inicio">Fecha inicio reporte</label>
                  <input type="date" name="rv_fecha_inicio" id="rv_fecha_inicio" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                  <label class="mt-10" for="rv_fecha_final">Fecha final reporte</label>
                  <input type="date" name="rv_fecha_final" id="rv_fecha_final" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Generar</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Reporte Otros-->
    <div class="modal fade fs-12" id="modal_reporte_otros" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Reporte
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_reporte_otros">
              <div class="row">
                <div class="col-sm-12">
                  <label for="ro_control">Control</label>
                  <select name="ro_control" id="ro_control" class="form-control" style="width:100%;" required>
                    <?php foreach ($data_control as $c) : ?>
                      <option value="<?php echo $c->control; ?>"><?php echo $c->descripcion; ?></option>
                    <?php endforeach; ?>
                  </select>

                  <label class="mt-10" for="ro_fecha_inicio">Fecha inicio reporte</label>
                  <input type="date" name="ro_fecha_inicio" id="ro_fecha_inicio" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>

                  <label class="mt-10" for="ro_fecha_final">Fecha final reporte</label>
                  <input type="date" name="ro_fecha_final" id="ro_fecha_final" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Generar</button>
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
  let tabla_asistencias;
  const data_mes_habilitado = <?php echo json_encode($data_mes_habilitado); ?>;
  const mes_habilitado = data_mes_habilitado[0].mes;
  let data_asistencia_mes_emp;

  /* Registrar Días Mes */
  $('#btn_registrar_dias_mes_empleados').on('click', function() {
    $('#modal_registrar_dias_mes').modal('show');
  });
  $('#form_registrar_dias_mes').submit(function(e) {
    e.preventDefault();
    const mes_reg = $('#mes_registrar_dias_mes').val();
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          swloading.start('Creando registros, espere por favor.');
          $.ajax({
            type: 'post',
            url: '<?php echo base_url('rrhh/asistencias/registrar_dia_mes'); ?>',
            data: {
              mes: mes_reg
            },
            dataType: 'json',
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Registrado!', 'Los registros se crearon exitosamente.', 2000)
                .then(() => location.reload());
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  });
  /* Capturar Asistencias */
  $('#btn_capturar_asistencias_empleados').on('click', function() {
    $('#modal_capturar_asistencias').modal('show');
  });
  $('#form_capturar_asistencias').submit(function(e) {
    e.preventDefault();
    const mes_reg = $('#mes_registrar_dias_mes').val();
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          console.log('proceso pendiente de registro de asistencias...');
          $('#modal_capturar_asistencias').modal('hide');
        }
      });
  });
  /* Registrar Asistencias para todos los empleados */
  $('#btn_registrar_asistencias_empleados').on('click', function() {
    $('#titulo_registro_asistencias').text('EMPLEADOS');
    $('#modal_registro_asistencias_empleado_empleados').modal('show');
  });

  function registrar_asistencia_empleados(ra_ci_emp, data_asistencia) {
    // Registrar control desde fecha_desde hasta fecha_hasta para TODOS los empleados
    msg_confirmation('warning', '¿Está seguro?', `Registro para <b>TODOS</b> los <b>EMPLEADOS</b>.<br />Los registros son de Lunes a Viernes.<br /><b>NOTA: </b>Va a reemplazar la información actual de acuerdo al rango de fechas.`)
      .then(res => {
        if (res) {
          swloading.start();
          $.ajax({
            type: "post",
            url: "<?php echo base_url('rrhh/asistencias/actualizar_rango_fechas_all_empleados'); ?>",
            data: {
              data_asistencia,
              mes_habilitado
            },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Actualizado!', 'Asistencia actualizada correctamente', 1500)
                .then(() => {
                  llenarAsistenciaEmpleado(ra_ci_emp, mes_habilitado);
                  $('#modal_registro_asistencias_empleado_empleados').modal('hide');
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
  /* Tabla Asistencia */
  function editarAsistencia(nro_ci_emp, fecha) {
    const data_asis_fecha_empleado = data_asistencia_mes_emp.find((element) => element.fecha === fecha);
    $('#nr_fecha').val(fecha.split('-').reverse().join('/'));
    $('#nr_control').val(data_asis_fecha_empleado.control).change();
    $('#nr_nota').val(data_asis_fecha_empleado.nota);
    $('#nr_empleado').val(nro_ci_emp);
    $('#modal_registro_asistencia').modal('show');
  }
  $('#form_registrar_asistencia').submit(function(e) {
    e.preventDefault();
    const nro_ci_emp = $('#nr_empleado').val();
    const fecha = $('#nr_fecha').val().split('/').reverse().join('-');
    const data_asistencia = {
      control: $('#nr_control').val(),
      nota: $('#nr_nota').val()
    }
    swloading.start();
    $.ajax({
      type: "post",
      url: "<?php echo base_url('rrhh/asistencias/actualizar'); ?>",
      data: {
        ci_emp: nro_ci_emp,
        fecha: fecha,
        data_as: data_asistencia
      },
      dataType: "json",
      success: function(response) {
        swloading.stop();
        time_alert('success', 'Actualizado!', 'Asistencia actualizada correctamente', 1500)
          .then(() => {
            llenarAsistenciaEmpleado(nro_ci_emp, mes_habilitado);
            $('#modal_registro_asistencia').modal('hide');
          });
      },
      error: function(error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });
  });

  function llenarAsistenciaEmpleado(nro_ci_emp, mes) {
    $.ajax({
      type: "post",
      url: "<?php echo base_url('rrhh/asistencias/get_mes_empleado'); ?>",
      data: {
        ci_emp: nro_ci_emp,
        mes: mes
      },
      dataType: "json",
      success: function(response) {
        data_asistencia_mes_emp = response;
        //console.log(data_asistencia_mes_emp);
        tabla_asistencias.clear().draw();
        data_asistencia_mes_emp.forEach((asistencia, index) => {
          tabla_asistencias.row.add([
            asistencia.fecha.split('-').reverse().join('/'),
            asistencia.control,
            asistencia.descripcion,
            asistencia.nota,
            `<button onclick="editarAsistencia(${asistencia.empleado}, '${asistencia.fecha}')" class="btn btn-info btn-xs" title="Editar registro"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>`
          ]).draw(false);
        })
      }
    });
  }
  $('#empleado_asistencia').on('change', function() {
    const nro_ci_empleado = $('#empleado_asistencia').val();
    if (nro_ci_empleado == null) {
      tabla_asistencias.clear().draw();
      time_alert('error', 'Empleado no seleccionado', 'Debe seleccionar un empleado.', 1500);
    } else {
      llenarAsistenciaEmpleado(nro_ci_empleado, mes_habilitado);
    }
  });
  /* Registro ausencias -> Registrar Asistencias */
  /* TODO: "Registro Ausencias" -> "Registrar Asistencias" actualiza la asistencia entre rango de fechas (Lunes a Viernes)
      no se usa las horas ni los días hábiles, el control y la nota se repite en cada registro */
  $('#btn_registrar_ausencias').on('click', function() {
    $('#titulo_registro_asistencias').html('<b>Empleado: </b>' + $('#empleado_asistencia').val());
    $('#modal_registro_asistencias_empleado_empleados').modal('show');
  });
  $('#reg_ausencias_fecha_desde').on('change', function() {
    $('#reg_ausencias_fecha_hasta').attr("min", $('#reg_ausencias_fecha_desde').val());
  });

  function calcular_dias_habiles(dateFrom, dateTo) {
    /* No se considera sabado y domingo */
    const totalDays = moment(dateTo).diff(moment(dateFrom), 'days') + 1;
    const dayOfWeek = moment(dateFrom).isoWeekday();
    let totalWorkdays = 0;
    for (let i = dayOfWeek; i < totalDays + dayOfWeek; i++) {
      if (i % 7 !== 6 && i % 7 !== 0) {
        totalWorkdays++;
      }
    }
    return totalWorkdays;
  }
  /* // Calular días hábiles
  $('#reg_ausencias_fecha_desde, #reg_ausencias_fecha_hasta').on('change', function() {
      const dias_habiles = calcular_dias_habiles($('#reg_ausencias_fecha_desde').val(), $('#reg_ausencias_fecha_hasta').val());
      $('#reg_ausencias_dias_habiles').val(dias_habiles);
  }); */
  $('#reg_ausencias_fecha_hasta').change();

  function registrar_asistencia_empleado(ra_ci_emp, data_asistencia) {
    // Registrar ra_control desde ra_fe_ini hasta ra_fe_fin
    msg_confirmation('warning', '¿Está seguro?', `Los registros son de Lunes a Viernes.<br /><b>NOTA: </b>Va a reemplazar la información actual de acuerdo al rango de fechas.`)
      .then(res => {
        if (res) {
          swloading.start();
          $.ajax({
            type: "post",
            url: "<?php echo base_url('rrhh/asistencias/actualizar_rango_fechas'); ?>",
            data: {
              ra_ci_emp,
              data_asistencia
            },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Actualizado!', 'Asistencia actualizada correctamente', 1500)
                .then(() => {
                  llenarAsistenciaEmpleado(ra_ci_emp, mes_habilitado);
                  $('#modal_registro_asistencias_empleado_empleados').modal('hide');
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
  $('#form_registro_ausencias').submit(function(e) {
    e.preventDefault();
    const ra_ci_emp = $('#empleado_asistencia').val();
    /*const ra_control    = $('#reg_ausencias_control').val();
    const ra_fe_ini     = $('#reg_ausencias_fecha_desde').val();
    //const ra_hrs_ini    = $('#reg_ausencias_hora_desde').val();
    const ra_fe_fin     = $('#reg_ausencias_fecha_hasta').val();
    //const ra_hrs_fin    = $('#reg_ausencias_hora_hasta').val();
    //const ra_dias_hab   = $('#reg_ausencias_dias_habiles').val();
    const ra_nota       = $('#reg_ausencias_nota').val();*/
    const data_asistencia = {
      control: $('#reg_ausencias_control').val(),
      fecha_desde: $('#reg_ausencias_fecha_desde').val(),
      fecha_hasta: $('#reg_ausencias_fecha_hasta').val(),
      nota: $('#reg_ausencias_nota').val()
    }
    const titulo = $('#titulo_registro_asistencias').text();
    if (titulo == "EMPLEADOS") {
      registrar_asistencia_empleados(ra_ci_emp, data_asistencia);
    } else {
      registrar_asistencia_empleado(ra_ci_emp, data_asistencia);
    }
  });
  /* Reporte (Reporte Simple de Asistencia) */
  $('#btn_reporte_simple_asistencia').on('click', function() {
    $('#modal_reporte_simple_asistencia').modal('show');
  });
  $('#form_reporte_simple_asistencia').submit(function(e) {
    e.preventDefault();
    const data = $('#empleado_asistencia').val() + ' ' + $('#rsa_fecha_inicio').val() + ' ' + $('#rsa_fecha_final').val();
    const url_ras = "<?php echo base_url('rrhh/asistencias/reporte_simple'); ?>?data=" + btoa(data);
    window.open(url_ras); // abre en otra pestaña
    $('#modal_reporte_simple_asistencia').modal('hide');
  });
  /* Reporte Vacaciones Empleado */
  $('#btn_reporte_vacaciones').on('click', function() {
    $('#modal_reporte_vacaciones').modal('show');
  });
  $('#form_reporte_vacaciones').submit(function(e) {
    e.preventDefault();
    const data = $('#empleado_asistencia').val() + ' ' + $('#rv_fecha_inicio').val() + ' ' + $('#rv_fecha_final').val();
    const url_rv = "<?php echo base_url('rrhh/asistencias/reporte_vacaciones'); ?>?data=" + btoa(data);
    window.open(url_rv); // abre en otra pestaña
    $('#modal_reporte_vacaciones').modal('hide');
  });
  /* Reporte Vacaciones Empleado */
  $('#btn_reporte_otros').on('click', function() {
    $('#modal_reporte_otros').modal('show');
  });
  $('#form_reporte_otros').submit(function(e) {
    e.preventDefault();
    const data = $('#ro_control').val() + ' ' + $('#empleado_asistencia').val() + ' ' + $('#ro_fecha_inicio').val() + ' ' + $('#ro_fecha_final').val();
    const url_ro = "<?php echo base_url('rrhh/asistencias/reporte_otros'); ?>?data=" + btoa(data);
    window.open(url_ro); // abre en otra pestaña
    $('#modal_reporte_otros').modal('hide');
  });
  /* Menu collapse */
  /* window.onload = function () {
      $('body').addClass("sidebar-mini sidebar-collapse");
  } */
  $(document).ready(function() {
    /*
    $("#printconfirmodal").on('keydown', function ( e ) {
        var key = e.which || e.keyCode;
        if (key == 13) {
            $('#yes').trigger('click');
        }
    });
    */
    llenarAsistenciaEmpleado($('#empleado_asistencia').val(), mes_habilitado);
    tabla_asistencias = $('#tabla_asistencia_empleado').DataTable(DATA_TABLE);
  });
</script>
