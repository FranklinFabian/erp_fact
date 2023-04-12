<!-- Admin Home Start -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_module('Sanciones') ?></small>
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
              <h4><strong><?php echo "Sanciones"; ?></strong></h4>
            </div>
          </div> <!-- Header End -->
          <!-- Body -->
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-4 col-sm-offset-2">
                <label for="registro_mensual_mes">Mes</label>
                <select name="registro_mensual_mes" id="registro_mensual_mes" class="form-control" style="width:100%;">
                  <?php foreach ($data_meses as $m) : ?>
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
                  <button type="button" id="btn_nueva_sancion" class="btn btn-info"><i class="fa fa-plus-square"></i> Nuevo</button>
                  <button type="button" id="btn_imprimir_registro_mensual" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                </div>
              </div>
              <div class="col-sm-12 mt-10">
                <table id="tabla_sanciones" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                  <thead>
                    <th class="text-center">Nro.</th>
                    <th class="text-center">Empleado</th>
                    <th class="text-center">Paterno</th>
                    <th class="text-center">Materno</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Mes</th>
                    <th class="text-center">Días</th>
                    <th class="text-center">Importe</th>
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

    <!-- Modal Registrar Nuevo Registro Mensual-->
    <div class="modal fade fs-12" id="modal_nuevo_actualizar_sancion" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="titulo_form_registro_mensual"></span> Sanción
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
              <input type="hidden" id="registro_suplencia_to_update">
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_registrar_actualizar_sancion">
              <div class="row">
                <div class="col-sm-12">
                  <label for="s_empleado">Empleado</label>
                  <select name="empleado" id="s_empleado" class="form-control" style="width:100%;" required>
                    <?php foreach ($data_empleados as $e) : ?>
                      <option value="<?php echo $e->empleado; ?>"><?php echo $e->paterno . ' ' . $e->materno . ' ' . $e->nombre1 . ' ' . $e->nombre2; ?></option>
                    <?php endforeach; ?>
                  </select>

                  <label class="mt-10" for="s_dias">Días</label>
                  <input type="number" name="dias" id="s_dias" step="0.01" class="form-control flotantes2decimales text-right" required>

                  <label class="mt-10" for="s_importe">Importe</label>
                  <input type="number" name="importe" id="s_importe" step="0.01" class="form-control flotantes2decimales text-right" required>

                  <label class="mt-10" for="s_nota">Nota</label>
                  <textarea name="nota" id="s_nota" class="form-control" rows="2" required></textarea>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn_form_sancion"></span></button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section> <!-- /.content -->

</div> <!-- /.content-wrapper -->

<script>
  const mes_habilitado = <?php echo json_encode($data_mes_habilitado[0]); ?>;
  const data_meses = <?php echo json_encode($data_meses); ?>;
  const data_empleados = <?php echo json_encode($data_empleados); ?>;
  let tabla_sanciones_mes, data_sanciones_mes;

  function llenarTablaRegistroMes() {
    tabla_sanciones_mes.clear().draw();
    let mtrmf1 = 0;
    data_sanciones_mes.forEach((fila, index) => {
      mtrmf1 += parseFloat(fila.importe);
      tabla_sanciones_mes.row.add([
        (index + 1),
        fila.empleado,
        fila.paterno,
        fila.materno,
        fila.nombre1 + ' ' + fila.nombre2,
        fila.mes.split('-').reverse().join('/'),
        fila.dias,
        fila.importe,
        fila.nota,
        (mes_habilitado.mes == fila.mes) ?
        `<button type="button" onclick="editarSancion(${fila.empleado}, ${fila.mes})" class="btn btn-primary btn-xs" title="Editar registro"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                <button type="button" onclick="eliminarSancion(${fila.empleado}, ${fila.mes})" class="btn btn-danger btn-xs" title="Eliminar registro"><i class="fa fa-close" aria-hidden="true"></i></button>` : '-'
      ]).draw(false);
    });
    $('#importe_total').val(mtrmf1.toFixed(2));
  }

  function obtenerDatosRegMensuales(mes) {
    swloading.start('Cargando.');
    $.ajax({
      type: "post",
      url: "<?php echo base_url('rrhh/sanciones/get_sanciones'); ?>",
      data: {
        mes: mes
      },
      dataType: "json",
      success: function(response) {
        swloading.stop();
        data_sanciones_mes = response;
        llenarTablaRegistroMes();
      },
      error: function(error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });
  }

  function iniciar_ventana() {
    obtenerDatosRegMensuales(data_meses[0].mes);
  }
  /* Cambio Mes Select */
  $('#registro_mensual_mes').on('change', function() {
    if ($('#registro_mensual_mes').val() == null)
      $('#registro_mensual_mes').val(data_meses[0].mes).change();
    obtenerDatosRegMensuales($('#registro_mensual_mes').val());
  });
  $('#s_dias').on('keyup change', function() {
    const dias = $('#s_dias').val();
    const emp = data_empleados.find(element => element.empleado == $('#s_empleado').val());
    const desc = (parseFloat(emp.basico) / 30) * dias;
    $('#s_importe').val(desc.toFixed(2));
  });
  $('#s_empleado').on('change', function() {
    $('#s_dias').change(); // Que calcule los valores correctos
  })
  /* Registrar Nueva Sancion */
  $('#btn_nueva_sancion').on('click', function() {
    const mes_form = $('#registro_mensual_mes').val();
    if (mes_form != mes_habilitado.mes) {
      time_alert('error', 'No permitido!', 'El mes seleccionado se encuentra cerrado.', 2000)
        .then(() => {
          return;
        })
    } else {
      // Iniciar form
      $('#s_empleado').prop('disabled', false); // Habilitar la seleccion del empleado
      $('#s_dias').val('0.00');
      $('#s_importe').val('0.00');
      $('#s_nota').val('');
      // Data Modal
      $('.titulo_form_registro_mensual').text('Registrar Nueva');
      $('.btn_form_sancion').text('Registrar');
      $('#modal_nuevo_actualizar_sancion').modal('show');
    }
  });
  $('#form_registrar_actualizar_sancion').submit(function(e) {
    e.preventDefault();
    const data_form_send = {
      empleado: $('#s_empleado').val(),
      dias: $('#s_dias').val(),
      importe: $('#s_importe').val(),
      nota: $('#s_nota').val(),
      mes: $('#registro_mensual_mes').val(),
    };
    // Validar días
    if (parseFloat(data_form_send.dias) <= 0) {
      time_alert('error', 'Error en los días!', 'Los días deben ser mayor a cero.', 2000)
      return;
    }
    // Validar si es Registro o Actualización
    const option = $('.btn_form_sancion').text();
    let msj_option = '',
      url_option = '',
      msj_alerta = '';
    if (option == 'Registrar') { // Registrar
      msj_option = 'Se registrará una nueva sanción.';
      url_option = '<?php echo base_url('rrhh/sanciones/registrar'); ?>';
      msj_alerta = 'Registrada';
      /* Solo se permite un registro por usuario en el mes*/
      const verificar = data_sanciones_mes.find(element => element.empleado === data_form_send.empleado)
      if (verificar) {
        time_alert('error', 'Existe sanción!', 'Ya existe una sanción registrada para el empleado seleccionado.', 2000);
        return;
      }
    } else { // Actualizar
      msj_option = 'Se actualizará los datos de la sanción.';
      url_option = '<?php echo base_url('rrhh/sanciones/actualizar'); ?>';
      msj_alerta = 'Actualizada';
    }
    msg_confirmation('warning', '¿Está seguro?', msj_option)
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "post",
            url: url_option,
            data: {
              data_form: data_form_send
            },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              time_alert('success', `${msj_alerta}!`, `La sanción fué ${msj_alerta.toLowerCase()} exitosamente.`, 2000)
                .then(() => {
                  obtenerDatosRegMensuales(data_form_send.mes);
                  $('#modal_nuevo_actualizar_sancion').modal('hide');
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

  function editarSancion(empleado, mes) {
    $('#s_empleado').prop('disabled', 'disabled'); // Deshabilitar la seleccion del empleado
    $('.titulo_form_registro_mensual').text('Editar');
    $('.btn_form_sancion').text('Actualizar');
    // llenar datos editar form
    const registro = data_sanciones_mes.find(element => element.empleado == empleado);
    $('#s_empleado').val(registro.empleado).change();
    $('#s_importe').val(registro.importe);
    $('#s_dias').val(registro.dias);
    $('#s_nota').val(registro.nota);
    // mostrar modal
    $('#modal_nuevo_actualizar_sancion').modal('show');
  }
  // autofocus sobre el importe
  $('#modal_nuevo_actualizar_sancion').on('shown.bs.modal', function(e) {
    $('#s_empleado').focus();
  })

  function eliminarSancion(empleado, mes) {
    const mes_r = $('#registro_mensual_mes').val();
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "post",
            url: "<?php echo base_url('rrhh/sanciones/eliminar'); ?>",
            data: {
              empleado: empleado,
              mes: mes_r
            },
            dataType: "text",
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Eliminado!', 'La sanción fué eliminada exitosamente.', 2000)
                .then(() => {
                  obtenerDatosRegMensuales(mes_r);
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
    const url_rm = "<?php echo base_url('rrhh/sanciones/reporte'); ?>?data=" + btoa(data);
    window.open(url_rm); // abre en otra pestaña
  });
  $(document).ready(function() {
    tabla_sanciones_mes = $('#tabla_sanciones').DataTable(DATA_TABLE);
    iniciar_ventana(); // carga de datos
  });
</script>