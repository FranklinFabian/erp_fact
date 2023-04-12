<!-- Admin Home Start -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_module('Control') ?></small>
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
              <h4><strong><?php echo "Planillas"; ?></strong><span class="tipo_cobro"></span></h4>
            </div>
          </div> <!-- Header End -->
          <!-- Body -->
          <div class="panel-body">
            <div class="row text-center">
              <div class="col-md-3 col-sm-4 col-xs-6 mt-10">
                <button type="button" class="btn btn-primary btn-block" id="btn_planilla_salarial"><i class="fa fa-print"></i> Planilla Salarial</button>
              </div>
              <div class="col-md-3 col-sm-4 col-xs-6 mt-10">
                <button type="button" class="btn btn-primary btn-block" id="btn_planilla_tributaria"><i class="fa fa-print"></i> Planilla Tributaria</button>
              </div>
              <div class="col-md-3 col-sm-4 col-xs-6 mt-10">
                <button type="button" class="btn btn-primary btn-block" id="btn_planilla_aportes_patronales"><i class="fa fa-print"></i> Planilla Aportes Patronales</button>
              </div>
              <!-- <div class="col-md-3 col-sm-4 col-xs-6 mt-10"> // TODO: Aguinaldos
                <button type="button" class="btn btn-primary btn-block" id="btn_aguinaldos"><i class="fa fa-print"></i> Planilla Aguinaldos ?</button>
              </div> -->
              <!-- <div class="col-md-3 col-sm-4 col-xs-6 mt-10"> // TODO: Incremento SALARIAL
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_planilla_incremento_salarial"><i class="fa fa-print"></i> Planilla Incremento Salarial</button>
              </div> -->
              <!-- <div class="col-md-3 col-sm-4 col-xs-6 mt-10">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_planilla_incremento_salarial2"><i class="fa fa-print"></i> Papeletas de pago ?</button>
              </div> -->
              <!-- <div class="col-md-3 col-sm-4 col-xs-6 mt-10">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_planilla_incremento_salarial3"><i class="fa fa-print"></i> Planilla de Refrigerio ?</button>
              </div> -->
              <div class="col-md-3 col-sm-4 col-xs-6 mt-10">
                <button type="button" class="btn btn-primary btn-block" id="btn_planilla_asistencia"><i class="fa fa-print"></i> Planilla de Asistencia</button>
              </div>
              <div class="col-md-3 col-sm-4 col-xs-6 mt-10">
                <button type="button" class="btn btn-primary btn-block" id="btn_planillas_hrs_extras"><i class="fa fa-print"></i> Planilla Horas Extras</button>
              </div>
              <!-- <div class="col-md-3 col-sm-4 col-xs-6 mt-10"> # TODO unir con CACO, según arqueo
                <button type="button" class="btn btn-primary btn-block" id="btn_reporte_cajeros"><i class="fa fa-print"></i> Atención Cajeros</button>
              </div> -->
              <div class="col-md-3 col-sm-4 col-xs-6 mt-10">
                <button type="button" class="btn btn-primary btn-block" id="btn_reporte_faltas"><i class="fa fa-print"></i> Planilla de Sanciones</button>
              </div>
              <div class="col-md-3 col-sm-4 col-xs-6 mt-10">
                <button type="button" class="btn btn-primary btn-block" id="btn_archivo_banco"><i class="fa fa-print"></i> Archivo para Banco</button>
              </div>
              <!-- <div class="col-md-3 col-sm-4 col-xs-6 mt-10"> # TODO ver si se implementará
                <button type="button" class="btn btn-primary btn-block" id="btn_reporte_contable"><i class="fa fa-print"></i> Reporte Contable</button>
              </div> -->
              <div class="col-md-3 col-sm-4 col-xs-6 mt-10">
                <button type="button" class="btn btn-primary btn-block" id="btn_costo_por_hora"><i class="fa fa-print"></i> Costo por hora</button>
              </div>
            </div>
          </div> <!-- Body End -->
        </div>
      </div>
    </div>
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<!-- Modal Generar Planilla Salarial, Tributaria, Aportes Patronales, Horas Extras - MODELO 1-->
<div class="modal fade fs-12" id="modal_planilla_modelo_uno" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span id="modelo_uno_titulo"></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
          </button>
        </h4>
      </div>
      <div class="modal-body">
        <form action="#" id="from_generar_planilla_modelo_uno">
          <div class="row">
            <div class="col-sm-12">
              <label for="modelo_uno_tipo_servicio">Servicio</label>
              <select name="modelo_uno_tipo_servicio" id="modelo_uno_tipo_servicio" class="form-control" style="width:100%;" required>
                <?php foreach ($data_servicios as $s) : ?>
                  <option value="<?= $s->Id_Servicio ?>"><?= $s->Servicio ?></option>
                <?php endforeach; ?>
              </select>
              <label for="modelo_uno_mes" class="mt-10">Mes</label>
              <select name="modelo_uno_mes" id="modelo_uno_mes" class="form-control" style="width:100%;" required>
                <?php foreach ($data_meses as $m) : ?>
                  <option value="<?php echo $m->mes; ?>"><?php echo date('d/m/Y', strtotime($m->mes)); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="mt-10 text-center">
            <button type="submit" class="btn btn-success btn-sm" id="btn_modelo_uno_excel"><i class="fa fa-file-excel-o"></i> Imprimir</button>
            <button type="submit" class="btn btn-primary btn-sm" id="btn_modelo_uno_pdf"><i class="fa fa-file-pdf-o"></i> Imprimir</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Planilla Aguinaldos - Aguinaldos -->
<div class="modal fade fs-12" id="modal_planilla_aguinaldos" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Aguinaldos
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
          </button>
          <input type="hidden" id="registro_mensual_empleado_to_update">
        </h4>
      </div>
      <div class="modal-body">
        <form action="#" id="form_aguinaldos">
          <div class="row">
            <div class="col-sm-4">
              <label for="rm_empleado">Servicio</label>
              <select name="empleado" id="rm_empleado" class="form-control" style="width:100%;" required>
                <?php foreach ($data_empleados as $e) : ?>
                  <option value="<?php echo $e->empleado; ?>"><?php echo $e->paterno . ' ' . $e->materno . ' ' . $e->nombre1 . ' ' . $e->nombre2; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-sm-6">
              <label for="aguinaldo_empleado">Empleado</label>
              <select name="empleado" id="aguinaldo_empleado" class="form-control" style="width:100%;" required>
                <?php foreach ($data_empleados as $e) : ?>
                  <option value="<?php echo $e->empleado; ?>"><?php echo $e->empleado . ' - ' . $e->paterno . ' ' . $e->materno . ' ' . $e->nombre1 . ' ' . $e->nombre2; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-sm-2">
              <label>Item</label>
              <p class="form-control mostrarTexto fs-12 aguinaldo_item"></p>
            </div>
            <div class="col-sm-5">
              <label class="mt-10">Nombre Ítem</label>
              <p class="form-control mostrarTexto fs-12 aguinaldo_nombre_item"></p>
            </div>
            <div class="col-sm-4">
              <label class="mt-10">Nombre Sección</label>
              <p class="form-control mostrarTexto fs-12 aguinaldo_nombre_seccion"></p>
            </div>
            <div class="col-sm-3">
              <label class="mt-10">Ingreso</label>
              <p class="form-control mostrarTexto fs-12 aguinaldo_fecha_ingreso"></p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <label for="">Gestión</label>
              <p class="form-control mostrarTexto"></p>
            </div>
            <div class="col-sm-4">
              <label for="">Fecha Inicio Calculo</label>
              <p class="form-control mostrarTexto"></p>
            </div>
            <div class="col-sm-4 text-center">
              <label for="">&nbsp;</label>
              <button type="button" class="btn btn-info form-control">Calcular</button>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <label for="">Sueldo 1</label>
              <p class="form-control mostrarTexto"></p>
            </div>
            <div class="col-sm-3">
              <label for="">Sueldo 2</label>
              <p class="form-control mostrarTexto"></p>
            </div>
            <div class="col-sm-3">
              <label for="">Sueldo 3</label>
              <p class="form-control mostrarTexto"></p>
            </div>
            <div class="col-sm-3">
              <label for="">Promedio</label>
              <p class="form-control mostrarTexto"></p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <label class="mt-10" for="aguinaldo_dias_trabajo">Días Trabajo</label>
              <input type="number" step="0.01" min="0" name="" id="aguinaldo_dias_trabajo" class="form-control fs-12" required>
            </div>
            <div class="col-sm-3">
              <label class="mt-10" for="aguinaldo_dias_falta">Días Falta</label>
              <input type="number" step="0.01" min="0" name="" id="aguinaldo_dias_falta" class="form-control fs-12" required>
            </div>
            <div class="col-sm-3">
              <label class="mt-10" for="aguinaldo_aguinaldo">Aguinaldo</label>
              <input type="number" step="0.01" name="" id="aguinaldo_aguinaldo" class="form-control fs-12 mostrarTexto" required>
            </div>
          </div>
          <div class="mt-10 text-center">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Calcular</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Incremento Salarial  -->
<div class="modal fade fs-12" id="modal_planilla_incremento_salarial" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Planilla Incremento Salarial
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
          </button>
        </h4>
      </div>
      <div class="modal-body">
        <form action="#" id="form_generar_planilla_incremento_salarial">
          <div class="row">
            <div class="col-sm-12">
              <label for="inc_sal_gestion">Gestión</label>
              <input type="number" name="inc_sal_gestion" id="inc_sal_gestion" class="form-control" style="width: 100%;" value="<?= date('Y') ?>" />
            </div>
          </div>
          <div class="mt-10 text-center">
            <button type="submit" class="btn btn-success btn-sm" id="btn_inc_sal_excel"><i class="fa fa-file-excel-o"></i> Excel</button>
            <!-- <button type="submit" class="btn btn-primary btn-sm" id="btn_inc_sal_pdf"><i class="fa fa-file-pdf-o"></i> Pdf</button> -->
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Generar Planilla de Asistencia, - MODELO 3 -->
<div class="modal fade fs-12" id="modal_planilla_modelo_tres" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span id="modelo_tres_titulo"></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
          </button>
        </h4>
      </div>
      <div class="modal-body">
        <form action="#" id="from_generar_planilla_modelo_tres">
          <div class="row">
            <div class="col-sm-12">
              <label for="modelo_tres_mes">Mes</label>
              <select name="modelo_tres_mes" id="modelo_tres_mes" class="form-control" style="width:100%;" required>
                <?php foreach ($data_meses as $m) : ?>
                  <option value="<?php echo $m->mes; ?>"><?php echo date('d/m/Y', strtotime($m->mes)); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="mt-20 text-center">
            <button type="submit" class="btn btn-success btn-sm" id="btn_modelo_tres_excel"><i class="fa fa-file-excel-o"></i> Imprimir</button>
            <button type="submit" class="btn btn-primary btn-sm" id="btn_modelo_tres_pdf"><i class="fa fa-file-pdf-o"></i> Imprimir</button>
            <button type="submit" class="btn btn-primary btn-sm" id="btn_modelo_tres_txt"><i class="fa fa-file-text-o"></i> Exportar</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Generar Reportes Cajeros,  - MODELO 4-->
<div class="modal fade fs-12" id="modal_planilla_modelo_cuatro" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><span id="modelo_cuatro_titulo"></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
          </button>
        </h4>
      </div>
      <div class="modal-body">
        <form action="#" id="from_generar_planilla_modelo_cuatro">
          <div class="row">
            <div class="col-sm-12">
              <label for="modelo_cuatro_fecha_desde">Desde</label>
              <input type="date" name="modelo_cuatro_fecha_desde" id="modelo_cuatro_fecha_desde" class="form-control" value="<?= date('Y-m-d') ?>">
            </div>
          </div>
          <div class="row mt-10">
            <div class="col-sm-12">
              <label for="modelo_cuatro_fecha_hasta">Hasta</label>
              <input type="date" name="modelo_cuatro_fecha_hasta" id="modelo_cuatro_fecha_hasta" class="form-control" value="<?= date('Y-m-d') ?>">
            </div>
          </div>
          <div class="mt-20 text-center">
            <button type="submit" class="btn btn-success btn-sm" id="btn_modelo_cuatro_excel"><i class="fa fa-file-excel-o"></i> Imprimir</button>
            <button type="submit" class="btn btn-primary btn-sm" id="btn_modelo_cuatro_pdf"><i class="fa fa-file-pdf-o"></i> Imprimir</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Bono Refrigerio - Refrigerio -->
<div class="modal fade fs-12" id="modal_bono_refrigerio" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Refrigerio
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
          </button>
          <input type="hidden" id="registro_mensual_empleado_to_update2">
        </h4>
      </div>
      <div class="modal-body">
        <form action="#" id="form_incremento_salarial2">
          <div class="row">
            <div class="col-sm-4">
              <label for="rm_empleado2">Servicio</label>
              <select name="empleado" id="rm_empleado2" class="form-control" style="width:100%;" required>
                <?php foreach ($data_empleados as $e) : ?>
                  <option value="<?php echo $e->empleado; ?>"><?php echo $e->paterno . ' ' . $e->materno . ' ' . $e->nombre1 . ' ' . $e->nombre2; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-sm-6">
              <label for="aguinaldo_empleado2">Empleado</label>
              <select name="empleado" id="aguinaldo_empleado2" class="form-control" style="width:100%;" required>
                <?php foreach ($data_empleados as $e) : ?>
                  <option value="<?php echo $e->empleado; ?>"><?php echo $e->empleado . ' - ' . $e->paterno . ' ' . $e->materno . ' ' . $e->nombre1 . ' ' . $e->nombre2; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-sm-2">
              <label>Item</label>
              <p class="form-control mostrarTexto fs-12 aguinaldo_item"></p>
            </div>
            <div class="col-sm-5">
              <label class="mt-10">Nombre Ítem</label>
              <p class="form-control mostrarTexto fs-12 aguinaldo_nombre_item"></p>
            </div>
            <div class="col-sm-4">
              <label class="mt-10">Nombre Sección</label>
              <p class="form-control mostrarTexto fs-12 aguinaldo_nombre_seccion"></p>
            </div>
            <div class="col-sm-3">
              <label class="mt-10">Ingreso</label>
              <p class="form-control mostrarTexto fs-12 aguinaldo_fecha_ingreso"></p>
            </div>
          </div>
          <!-- <div class="row">
                        <div class="col-sm-4">
                            <label for="">Gestión</label>
                            <p class="form-control mostrarTexto"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Fecha Inicio Calculo</label>
                            <p class="form-control mostrarTexto"></p>
                        </div>
                        <div class="col-sm-4 text-center">
                            <label for="">&nbsp;</label>
                            <button type="button" class="btn btn-info form-control">Calcular</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="">Sueldo 1</label>
                            <p class="form-control mostrarTexto"></p>
                        </div>
                        <div class="col-sm-3">
                            <label for="">Sueldo 2</label>
                            <p class="form-control mostrarTexto"></p>
                        </div>
                        <div class="col-sm-3">
                            <label for="">Sueldo 3</label>
                            <p class="form-control mostrarTexto"></p>
                        </div>
                        <div class="col-sm-3">
                            <label for="">Promedio</label>
                            <p class="form-control mostrarTexto"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="mt-10" for="aguinaldo_dias_trabajo">Días Trabajo</label>
                            <input type="number" step="0.01" min="0" name="" id="aguinaldo_dias_trabajo" class="form-control fs-12" required>
                        </div>
                        <div class="col-sm-3">
                            <label class="mt-10" for="aguinaldo_dias_falta">Días Falta</label>
                            <input type="number" step="0.01" min="0" name="" id="aguinaldo_dias_falta" class="form-control fs-12" required>
                        </div>
                        <div class="col-sm-3">
                            <label class="mt-10" for="aguinaldo_aguinaldo">Aguinaldo</label>
                            <input type="number" step="0.01" name="" id="aguinaldo_aguinaldo" class="form-control fs-12 mostrarTexto" required>
                        </div>
                    </div> -->
          <div class="mt-10 text-center">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Calcular</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  const data_meses = <?php echo json_encode($data_meses); ?>;
  const data_empleados = <?php echo json_encode($data_empleados); ?>;
  const data_servicios = <?php echo json_encode($data_servicios); ?>;
  /* PLANILLAS */
  // MODELO 1
  // Planilla Salarial
  $('#btn_planilla_salarial').on('click', function() {
    $('#modelo_uno_titulo').text('Planilla Salarial');
    $('#btn_modelo_uno_excel').hide();
    $('#btn_modelo_uno_pdf').show();
    $('#modal_planilla_modelo_uno').modal('show');
  });
  // Planilla Tributaria
  $('#btn_planilla_tributaria').on('click', function() {
    $('#modelo_uno_titulo').text('Planilla Tributaria');
    $('#btn_modelo_uno_excel').hide();
    $('#btn_modelo_uno_pdf').show();
    $('#modal_planilla_modelo_uno').modal('show');
  });
  // Planilla Aportes Patronales
  $('#btn_planilla_aportes_patronales').on('click', function() {
    $('#modelo_uno_titulo').text('Planilla Aportes Patronales');
    $('#btn_modelo_uno_excel').hide();
    $('#btn_modelo_uno_pdf').show();
    $('#modal_planilla_modelo_uno').modal('show');
  });
  // Planilla Horas Extras
  $('#btn_planillas_hrs_extras').on('click', function() {
    $('#modelo_uno_titulo').text('Planilla Horas Extras');
    $('#btn_modelo_uno_excel').hide();
    $('#btn_modelo_uno_pdf').show();
    $('#modal_planilla_modelo_uno').modal('show');
  });
  // Reporte Contable
  $('#btn_reporte_contable').on('click', function() {
    $('#modelo_uno_titulo').text('Reporte Contable');
    $('#btn_modelo_uno_excel').hide();
    $('#btn_modelo_uno_pdf').show();
    $('#modal_planilla_modelo_uno').modal('show');
  });
  // Costo por Hora
  $('#btn_costo_por_hora').on('click', function() {
    $('#modelo_uno_titulo').text('Costo por Hora');
    $('#btn_modelo_uno_excel').hide();
    $('#btn_modelo_uno_pdf').show(); // Imp. Costo Tot, Ganado
    $('#modal_planilla_modelo_uno').modal('show');
  });
  // Generar Pdf | Excel - MODELO 1
  $('#from_generar_planilla_modelo_uno').submit(function(e) {
    e.preventDefault();
    const titulo = $('#modelo_uno_titulo').text();
    const btn_id = e.originalEvent.submitter.id;
    const servicio = $('#modelo_uno_tipo_servicio').val();
    const mes = $('#modelo_uno_mes').val();
    const url = {};
    if (titulo == 'Planilla Salarial') {
      url.excel = '<?= base_url('rrhh/planillas/planilla_salarial_excel?data=') ?>' + btoa(servicio + '+' + mes);
      url.pdf = '<?= base_url('rrhh/planillas/planilla_salarial_pdf?data=') ?>' + btoa(servicio + '+' + mes);
    } else if (titulo == 'Planilla Tributaria') {
      url.excel = '<?= base_url('rrhh/planillas/planilla_tributaria_excel?data=') ?>' + btoa(servicio + '+' + mes);
      url.pdf = '<?= base_url('rrhh/planillas/planilla_tributaria_pdf?data=') ?>' + btoa(servicio + '+' + mes);
    } else if (titulo == 'Planilla Aportes Patronales') {
      url.excel = '<?= base_url('rrhh/planillas/planilla_aportes_patronales_excel?data=') ?>' + btoa(servicio + '+' + mes);
      url.pdf = '<?= base_url('rrhh/planillas/planilla_aportes_patronales_pdf?data=') ?>' + btoa(servicio + '+' + mes);
    } else if (titulo == 'Planilla Horas Extras') {
      url.pdf = '<?= base_url('rrhh/planillas/planilla_horas_extras_pdf?data=') ?>' + btoa(servicio + '+' + mes);
    } else if (titulo == 'Reporte Contable') {
      url.pdf = '<?= base_url('rrhh/planillas/reporte_contable_pdf?data=') ?>' + btoa(servicio + '+' + mes);
    } else if (titulo == 'Costo por Hora') {
      url.pdf = '<?= base_url('rrhh/planillas/planilla_costo_por_hora_pdf?data=') ?>' + btoa(servicio + '+' + mes);
    }

    if (btn_id == 'btn_modelo_uno_excel')
      window.open(url.excel, '_blank');
    else
      window.open(url.pdf, '_blank');
  });
  // Planilla Incremento Salarial
  $('#form_generar_planilla_incremento_salarial').submit(async function(e) {
    e.preventDefault();
    const gestion = $('#inc_sal_gestion').val();
    const res = await $.ajax({
      type: "post",
      url: "<?= base_url('rrhh/planillas/verificar_existe_incremento_salarial') ?>",
      data: {
        gestion
      },
      dataType: "json",
      success: function(response) {
        return response;
      }
    });
    if (res.length == 0) {
      time_alert('error', 'Error!', 'No existen registros de incremento salarial<br>para la gestión ' + gestion + '.', 2000)
      return;
    }
    const btn_id = e.originalEvent.submitter.id;
    const url = {
      excel: '<?= base_url('rrhh/planillas/planilla_incremento_salarial_excel?data=') ?>' + btoa(gestion),
    };

    if (btn_id == 'btn_inc_sal_excel')
      window.open(url.excel, '_blank');
    else
      window.open(url.pdf, '_blank');
  });
  // Aguinaldo
  $('#btn_aguinaldos').on('click', function() {
    $('#aguinaldo_empleado').change();
    $('#modal_planilla_aguinaldos').modal('show');
  });
  $('#aguinaldo_empleado').on('change', function() {
    const emp = data_empleados.find(element => element.empleado == $('#aguinaldo_empleado').val());
    if (emp) {
      $('.aguinaldo_item').text(emp.item);
      $('.aguinaldo_nombre_item').text(emp.nombre_item);
      $('.aguinaldo_nombre_seccion').text(emp.nombre_seccion);
      $('.aguinaldo_fecha_ingreso').text(emp.fecha_ingreso.split('-').reverse().join('/'));

    } else {
      $('.aguinaldo_item').text(' - ');
      $('.aguinaldo_nombre_item').text('Seleccione un empleado');
      $('.aguinaldo_nombre_seccion').text('Seleccione un empleado');
      $('.aguinaldo_fecha_ingreso').text('Seleccione un empleado');

    }
  });
  $('#form_aguinaldos').submit(function(e) {
    e.preventDefault();
    //const mes = $('#from_generar_planilla_modelo_uno').val();
    msg_confirmation('warning', '¿Está seguro?', 'Se realizarán los calculos para el incremento salarial para los meses seleccionados.')
      .then((response) => {
        if (response) {
          swloading.start('Realizando calculos, espere por favor.');
          swloading.stop();
        }
      })
  });
  // Refrigerio
  $('#btn_refrigerio').on('click', function() {
    $('#modal_bono_refrigerio').modal('show');
  });
  // MODELO 3
  // Planilla de Asistencia
  $('#btn_planilla_asistencia').on('click', function() {
    $('#modelo_tres_titulo').text('Planilla de Asistencia');
    $('#btn_modelo_tres_excel').hide();
    $('#btn_modelo_tres_pdf').show();
    $('#btn_modelo_tres_txt').hide();
    $('#modal_planilla_modelo_tres').modal('show');
  });
  // Reporte Cajeros
  $('#btn_reporte_cajeros').on('click', function() {
    $('#modelo_tres_titulo').text('Reporte Cajeros');
    $('#btn_modelo_tres_excel').hide();
    $('#btn_modelo_tres_pdf').show();
    $('#btn_modelo_tres_txt').hide();
    $('#modal_planilla_modelo_tres').modal('show');
  });
  // Reporte de Sanciones
  $('#btn_reporte_faltas').on('click', function() {
    // Mismo que el reporte: Registro Mensual -> Sanciones
    $('#modelo_tres_titulo').text('Reporte de Sanciones');
    $('#btn_modelo_tres_excel').hide();
    $('#btn_modelo_tres_pdf').show();
    $('#btn_modelo_tres_txt').hide();
    $('#modal_planilla_modelo_tres').modal('show');
  });
  // Archivo para Banco
  $('#btn_archivo_banco').on('click', function() {
    $('#modelo_tres_titulo').text('Archivo para Banco');
    $('#btn_modelo_tres_excel').hide();
    $('#btn_modelo_tres_pdf').hide();
    $('#btn_modelo_tres_txt').show();
    $('#modal_planilla_modelo_tres').modal('show');
  });
  // Generar Pdf | Excel - MODELO 3
  $('#from_generar_planilla_modelo_tres').submit(function(e) {
    e.preventDefault();
    const titulo = $('#modelo_tres_titulo').text();
    const btn_id = e.originalEvent.submitter.id;
    const mes = $('#modelo_tres_mes').val();
    const url = {};
    if (titulo == 'Planilla de Asistencia') {
      url.pdf = '<?= base_url('rrhh/planillas/planilla_asistencia_pdf?data=') ?>' + btoa(mes);
    } else if (titulo == 'Reporte Cajeros') {
      url.pdf = '<?= base_url('rrhh/planillas/reporte_cajeros_pdf?data=') ?>' + btoa(mes);
    } else if (titulo == 'Reporte de Sanciones') {
      url.pdf = '<?= base_url('rrhh/sanciones/reporte?data=') ?>' + btoa(mes);
    } else if (titulo == 'Archivo para Banco') {
      url.txt = '<?= base_url('rrhh/planillas/archivo_banco?data=') ?>' + btoa(mes);
    }

    if (btn_id == 'btn_modelo_tres_excel')
      window.open(url.excel, '_blank');
    else if (btn_id == 'btn_modelo_tres_txt')
      window.open(url.txt, '_blank');
    else
      window.open(url.pdf, '_blank');
  });
  // MODELO 4
  // Planilla ...

  // Generar Pdf | Excel - MODELO 4
  $('#from_generar_planilla_modelo_cuatro').submit(function(e) {
    e.preventDefault();
    const titulo = $('#modelo_cuatro_titulo').text();
    const btn_id = e.originalEvent.submitter.id;
    const fecha_desde = $('#modelo_cuatro_fecha_desde').val();
    const fecha_hasta = $('#modelo_cuatro_fecha_hasta').val();
    if (fecha_desde > fecha_hasta) {
      time_alert('error', 'Error!', 'La <b>fecha hasta</b> debe ser igual o posterior<br>a la <b>fecha desde</b>.', 2000)
      return;
    }
    const url = {};
    if (titulo == '') {
      url.pdf = '<?= base_url('rrhh/...?data=') ?>' + btoa(fecha_desde + '+' + fecha_hasta);
    }

    if (btn_id == 'btn_modelo_cuatro_excel')
      window.open(url.excel, '_blank');
    else
      window.open(url.pdf, '_blank');
  });

  $(document).ready(function() {

  });
</script>