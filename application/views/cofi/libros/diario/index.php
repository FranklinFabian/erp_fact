<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Libros') ?></small>
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
    }
    ?>

    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="panel-title">
              <h4>Libro Diario</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                  <div class="panel-body text-center">
                    <!-- Default unchecked -->
                    <div class="custom-control custom-radio">
                      <table width="100%">
                        <tr>
                          <td>
                            <input type="radio" class="custom-control-input" id="idRepoPorMes" name="tipoBusquedaReporte" value="1" checked>
                            <label class="custom-control-label" for="idRepoPorMes">Reporte por Mes y Tipo de Comprobantes</label>
                          </td>
                          <td>
                            <input type="radio" class="custom-control-input" id="idRepoRango" name="tipoBusquedaReporte" value="2">
                            <label class="custom-control-label" for="idRepoRango">Reporte por Rango de Fechas</label>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <hr>

                    <div id="idFormulario1">
                      <div class="form-group col-md-8 col-md-offset-1 text-center">
                        <div class="form-group col-md-6">
                          <div class="md-form">
                            <label for="idMesForm1">Mes</label>
                            <select class="form-control" id="idMesForm1" style="width: 100%;">
                              <?php $i = 1; ?>
                              <?php foreach (MONTH_NAMES as $lm) : ?>
                                <option value="<?php echo $i++;; ?>"><?php echo $lm; ?></option>
                              <?php endforeach; ?>
                              <option value="*">Todo</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <div class="md-form">
                            <label for="idTipoComprobanteForm1">Tipo de Comprobante</label>
                            <select class="form-control" id="idTipoComprobanteForm1" style="width: 100%;">
                              <?php if (isset($listaTipoComprobantes)) : ?>
                                <?php foreach ($listaTipoComprobantes as $ltc) : ?>
                                  <option value="<?php echo $ltc->id; ?>"><?php echo $ltc->nombre; ?></option>
                                <?php endforeach; ?>
                              <?php endif; ?>
                              <option value="*">TODO</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="idFormulario2">
                      <div class="form-group col-md-3 text-center">
                        <label for="idFechaIniForm2">Desde Fecha: </label>
                        <input class="form-control" type="date" id="idFechaIniForm2" value="<?php echo selected_year() . '-01-01'; ?>">
                      </div>
                      <div class="form-group col-md-3 text-center">
                        <label for="idFechaFinForm2">Hasta Fecha: </label>
                        <input class="form-control" type="date" id="idFechaFinForm2" value="<?php echo selected_year() . '-12-31'; ?>">
                      </div>
                      <div class="form-group col-md-4 text-center">
                        <div class="form-group col-md-12">
                          <div class="md-form">
                            <label for="idTipoComprobanteForm2">Tipo de Comprobante</label>
                            <select class="form-control" id="idTipoComprobanteForm2" style="width: 100%;">
                              <?php if (isset($listaTipoComprobantes)) : ?>
                                <?php foreach ($listaTipoComprobantes as $ltc) : ?>
                                  <option value="<?php echo $ltc->id; ?>"><?php echo $ltc->nombre; ?></option>
                                <?php endforeach; ?>
                              <?php endif; ?>
                              <option value="*">TODO</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="idMonedaForm">Moneda</label>
                      <select id="idMonedaForm" class="form-control" name="" style="width: 100%;">
                        <?php foreach ($monedas as $m) : ?>
                          <option value="<?php echo $m->id; ?>"><?php echo $m->codigo; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-12 text-center">
                      <button id="btnGenerarLibroDiarioPDF" class="btn btn-primary btn-rounded mb-4"><i class="fa fa-file-pdf-o"></i> Generar Libro Diario</button>
                      <button id="btnGenerarLibroDiarioEXCEL" class="btn btn-success btn-rounded mb-4"><i class="fa fa-file-excel-o"></i> Generar Libro Diario</button>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Admin Home end -->

<script>
  var fechaIni;
  var fechaFin;
  var tipoComp;
  var tpMoneda;
  var form;
  var gestionEmpresaJS = "<?php echo selected_year() ?>";
  var mesf1 = 0;
  var tcomp = 0;
  var feinif2 = 0;
  var fefinf2 = 0;

  $(document).ready(function() {
    form = $('input[name=tipoBusquedaReporte]:checked').val();
    $('#idFormulario2').hide();
    // Ocultar formularios
    $("input[name=tipoBusquedaReporte]").change(function() {
      form = $('input[name=tipoBusquedaReporte]:checked').val();
      if (form == 1) {
        $('#idFormulario1').show();
        $('#idFormulario2').hide();
      } else {
        $('#idFormulario1').hide();
        $('#idFormulario2').show();
      }
    });

    function validarFormulario() {
      tpMoneda = $('#idMonedaForm').val();
      if (form == 1) {
        mesf1 = $('#idMesForm1').val();
        tcomp = $('#idTipoComprobanteForm1').val();
        if (mesf1 == null) {
          time_alert('error', 'Mes no Seleccionado!', 'Debe Seleccionar un Mes válido para generar el Libro Diario.', 2000)
          return false;
        } else if (tcomp == null) {
          time_alert('error', 'Tipo de Comprobante!', 'Debe Seleccionar el Tipo de Comprobante', 2000)
          return false;
        } else if (tpMoneda == null) {
          time_alert('error', 'Tipo de Moneda!', 'Debe Seleccionar el Tipo de Moneda', 2000)
          return false;
        } else {
          if (mesf1 == "*") {
            fechaIni = gestionEmpresaJS + "-01-01";
            fechaFin = gestionEmpresaJS + "-12-31";
          } else {
            fechaIni = gestionEmpresaJS + "-" + mesf1 + "-01";
            fechaFin = gestionEmpresaJS + "-" + mesf1 + "-" + (new Date(gestionEmpresaJS, mesf1, 0).getDate());
          }
          tipoComp = tcomp;
          tpMoneda = tpMoneda;
          return true;
        }
      } else { // form 2
        feinif2 = $('#idFechaIniForm2').val();
        fefinf2 = $('#idFechaFinForm2').val();
        tcomp = $('#idTipoComprobanteForm2').val();
        var anioinif2 = feinif2.split('-')[0];
        var aniofinf2 = fefinf2.split('-')[0];
        //console.log(feinif2, fefinf2, tcomp, anioinif2, aniofinf2);
        if (feinif2 == '') {
          Swal.fire(
            'Error en la Fecha!',
            'Debe Seleccionar la Fecha "Desde".',
            'error'
          )
          return false;
        } else if (fefinf2 == '') {
          time_alert('error', 'Error en la Fecha!', 'Debe Seleccionar la Fecha "Hasta".', 2000)
          return false;
        } else if (anioinif2 != gestionEmpresaJS || aniofinf2 != gestionEmpresaJS) {
          time_alert('error', 'Error en el Rango de Fechas!', 'Las fechas ingresadas no corresponde al periodo 01/01/' + gestionEmpresaJS + ' - ' + '31/12/' + gestionEmpresaJS, 2000)
          return false;
        } else if (tcomp == null) {
          time_alert('error', 'Tipo de Comprobantes!', 'Debe Seleccionar el Tipo de Comprobante', 2000)
          return false;
        } else if (tpMoneda == null) {
          time_alert('error', 'Tipo de Moneda!', 'Debe Seleccionar el Tipo de Moneda', 2000)
          return false;
        } else {
          fechaIni = feinif2;
          fechaFin = fefinf2;
          tipoComp = tcomp;
          tpMoneda = tpMoneda;
          return true;
        }
      }
    }
    $('#btnGenerarLibroDiarioPDF').on('click', function() {
      if (validarFormulario()) {
        const url = BASE_URL + 'cofi/libros/diario_pdf' + '?dt=' + btoa(fechaIni + '/' + fechaFin + '/' + tipoComp + '/' + tpMoneda);
        window.open(url);
      }
    });
    $('#btnGenerarLibroDiarioEXCEL').on('click', function() {
      if (validarFormulario()) {
        const url = BASE_URL + 'cofi/libros/diario_excel' + '?dt=' + btoa(fechaIni + '/' + fechaFin + '/' + tipoComp + '/' + tpMoneda);
        window.open(url);
      }
    });
  });
</script>
