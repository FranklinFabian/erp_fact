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
              <h4><?php echo isset($comprobante) ? 'Editar' : 'Registrar' ?> Comprobante</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div id="primeraParteFormularioComprobante">
                <form action="#" id="formulario_uno">
                  <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="idTipoComprobante"><strong>Tipo de Comprobante</strong></label>
                        <?php if (!isset($comprobante)) : ?>
                          <select class="form-control dont-select-me" id="idTipoComprobante" required>
                            <?php foreach ($comprobantes_tipos as $ct) : ?>
                              <option value="<?php echo $ct->id; ?>"><?php echo $ct->nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        <?php else: ?>
                          <input type="text" class="form-control" value="<?php echo $comprobante['comprobante_tipo_nombre']; ?>" readonly>
                          <input type="text" id="idTipoComprobante" value="<?php echo $comprobante['comprobante_tipo_id']; ?>" hidden>
                          <input type="text" id="idComprobanteEditado" value="<?php echo $comprobante_id; ?>" hidden>
                        <?php endif; ?>
                      </div>
                      <div class="col-md-6">
                        <label for="idFechaComprobante"><strong>Fecha</strong></label>
                        <input type="date" class="form-control" id="idFechaComprobante" min="<?php echo selected_year() . "-01-01" ?>" max="<?php echo selected_year() . "-12-31" ?>"
                          value="<?php echo isset($comprobante) ? $comprobante['fecha'] : selected_year() . date('-m-d'); ?>" required>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-6">
                        <label for="idTcBUsComprobante"><strong>TC Bs/US$</strong></label>
                        <input class="form-control" type="text" placeholder="Ingrese TC BS/US$" id="idTcBUsComprobante" value="<?php echo isset($comprobante) ?  $comprobante['tcBsUS'] : '' ?>" required>
                      </div>
                      <div class="col-md-6">
                        <label for="idTcBUfvComprobante"><strong>TC Bs/UFV</strong></label>
                        <input class="form-control" type="text" placeholder="Ingrese TC BS/UFV" id="idTcBUfvComprobante" value="<?php echo isset($comprobante) ?  $comprobante['tcBsUFV'] : '' ?>" required>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-6">
                        <label for="idNomRazonSocComprobante"><strong>Nombre o Razón Social</strong></label>
                        <input type="text" class="form-control" id="idNomRazonSocComprobante" value="<?php echo empresa_gestion('nombre') ?>"  required readonly>
                      </div>
                      <div class="col-md-6">
                        <label for="idMonedaDataComprobante">Moneda:</label>
                        <select class="form-control dont-select-me" id="idMonedaDataComprobante" required>
                          <?php foreach ($monedas as $m) : ?>
                            <option value="<?php echo $m->id; ?>" <?php echo isset($comprobante) && $comprobante['moneda_id'] == $m->id ? 'selected':'' ?>><?php echo $m->codigo; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-12">
                        <label for="idGlosaComprobante"><strong>Glosa</strong></label>
                        <textarea class="form-control" id="idGlosaComprobante" placeholder="Ingrese la glosa del comprobante" rows="3"><?php echo isset($comprobante) ? $comprobante['glosa'] : ''; ?></textarea>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-arrow-right"></i> Siguiente</button>
                        <?php if (isset($comprobante)): ?>
                          <a href="<?php echo base_url('cofi/comprobantes'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Cancelar</a>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <div id="segundaParteFormularioComprobante">
                <div class="col-md-12">
                  <div id="formSecondPart">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="f-left">
                          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_usar_plantilla"><i class="fa fa-copy"></i> Usar plantilla</button>
                        </div>
                        <div class="f-right">
                          <strong>
                            <?php if (!isset($comprobante)) : ?>
                              <h4 id="correlativo"></h4>
                            <?php else : ?>
                              <h4><?php echo $comprobante['comprobante_tipo_nombre'] . " N°. " . numero_comprobante($comprobante['id']) ?></h4>
                            <?php endif; ?>
                          </strong>
                        </div>
                      </div>
                    </div>
                    <form action="#" id="formulario_add_cuenta">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="idCuentaDataComprobante"><strong>Cuenta</strong></label>
                          <select class="form-control" name="idCuentaDataComprobante" id="idCuentaDataComprobante" style="width: 100%;" required>
                            <option value="">Seleccione una cuenta...</option>
                            <?php foreach ($cuentas_finales as $cf) : ?>
                              <option value="<?php echo $cf->id; ?>"><?php echo $cf->codigo_formato . ' | ' . $cf->nombre; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label for="nombreCuentaDataComprobante"><strong>Nombre Cuenta</strong></label>
                          <input class="form-control" id="nombreCuentaDataComprobante" readonly />
                        </div>
                        <div class="col-md-2">
                          <label for="idDebeHaberDataComprobante"><strong>&nbsp;</strong></label>
                          <select class="form-control" name="idDebeHaberDataComprobante" id="idDebeHaberDataComprobante" style="width: 100%;" required>
                            <option value="DEBE">DEBE</option>
                            <option value="HABER">HABER</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-md-4">
                          <label for="idImporteDataComprobante"><strong>Importe en <span class="titleImporteDataComprobante">Bs.</span></strong></label>
                          <input type="number" name="idImporteDataComprobante" id="idImporteDataComprobante" class="form-control" value="0" min="0.01" step="0.01" placeholder="Importe">
                        </div>
                        <div class="col-md-6">
                          <label for="idReferenciaDataComprobante"><strong>Referencia</strong></label>
                          <input class="form-control" type="text" id="idReferenciaDataComprobante" placeholder="Ingrese la referencia">
                        </div>
                        <div class="col-md-2">
                          <label for=""><strong>&nbsp;</strong></label>
                          <button type="submit" class="col-md-12 btn btn-info btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Incluir</button>
                        </div>
                      </div>
                    </form>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <!-- tabla principal, comprobante -->
                      <div class="table-responsive mt-10">
                        <table id="tablaComprobantes" class="table table-responsive table-bordered table-hover table-sm table-striped text-center">
                          <thead>
                            <tr>
                              <th class="text-center">Código</th>
                              <th class="text-center">Nombre</th>
                              <th class="text-center">Debe (Bs)</th>
                              <th class="text-center">Haber (Bs)</th>
                              <th class="text-center" hidden>Debe (US$)</th>
                              <th class="text-center" hidden>Haber (US$)</th>
                              <th class="text-center" hidden>Debe (UFV)</th>
                              <th class="text-center" hidden>Haber (UFV)</th>
                              <th class="text-center">Referencia</th>
                              <th class="text-center" width="15%">Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- dinámico -->
                            <?php if (isset($comprobante)) : ?>
                              <?php foreach ($comprobante_data as $cd) : ?>
                                <tr>
                                  <td><?php echo $cd->cuenta_codigo_formato; ?></td>
                                  <td><?php echo $cd->cuenta_nombre; ?></td>
                                  <td><?php echo $cd->debeBs != 0 ? $cd->debeBs : ''; ?></td>
                                  <td><?php echo $cd->haberBs != 0 ? $cd->haberBs : ''; ?></td>
                                  <td hidden><?php echo $cd->debeUS != 0 ? $cd->debeUS : ''; ?></td>
                                  <td hidden><?php echo $cd->haberUS != 0 ? $cd->haberUS : ''; ?></td>
                                  <td hidden><?php echo $cd->debeUFV != 0 ? $cd->debeUFV : ''; ?></td>
                                  <td hidden><?php echo $cd->haberUFV != 0 ? $cd->haberUFV : ''; ?></td>

                                  <td><?php echo $cd->referencia; ?></td>
                                  <td>
                                    <input name="cuenta_id" value="<?php echo $cd->cuenta_id; ?>" hidden>
                                    <input name="referencia" value="<?php echo $cd->referencia; ?>" hidden>
                                    <span class="table-up"> <button class="btn btn-warning btn-xs">&nbsp;<i class="fa fa-long-arrow-up" aria-hidden="true"></i>&nbsp;</button></span>
                                    <span class="table-down"> <button class="btn btn-warning btn-xs">&nbsp;<i class="fa fa-long-arrow-down" aria-hidden="true"></i>&nbsp;</button></span>
                                    <span class="table-edit"> <button class="btn btn-primary btn-xs"><i class="fa fa fa-edit" aria-hidden="true"></i></button></span>
                                    <span class="table-remove"> <button class="btn btn-danger btn-xs"><i class="fa fa fa-times" aria-hidden="true"></i></button></span>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th></th>
                              <th>Totales</th>
                              <th class="text-right classDebeBs">0</th>
                              <th class="text-right classHaberBs">0</th>
                              <th class="text-right classDebeUS" hidden>0</th>
                              <th class="text-right classHaberUs" hidden>0</th>
                              <th class="text-right classDebeUFV" hidden>0</th>
                              <th class="text-right classHaberUFV" hidden>0</th>
                              <th></th>
                              <th></th>
                            </tr>
                            <tr>
                              <th></th>
                              <th>Diferencia</th>
                              <th class="text-right classDiffDebeBs"></th>
                              <th class="text-right classDiffHaberBs"></th>
                              <th class="text-right classDiffDebeUS" hidden></th>
                              <th class="text-right classDiffHaberUS" hidden></th>
                              <th class="text-right classDiffDebeUFV" hidden></th>
                              <th class="text-right classDiffHaberUFV" hidden></th>
                              <th></th>
                              <th></th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-12 text-right">
                      <?php if (!isset($comprobante)) : ?>
                        <button class="btn btn-primary btn-sm" id="btnRegistrarComprobante"><i class="fa fa-save" aria-hidden="true"></i> Guardar</button>
                      <?php else : ?>
                        <button class="btn btn-primary btn-sm" id="btnActualizarComprobante"><i class="fa fa-check" aria-hidden="true"></i> Actualizar</button>
                        <a href="<?php echo base_url('cofi/comprobantes'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Cancelar</a>
                      <?php endif; ?>
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

<!-- Modal -->
<div class="modal fade" id="modal_usar_plantilla" tabindex="-1" role="dialog" aria-labelledby="modal_usar_plantilla" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Usar Plantillas
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </h4>
      </div>
      <form action="#" id="formulario_insertar_plantilla">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <label for="plantilla_id">Plantilla</label>
              <select name="plantilla_id" id="plantilla_id" class="form-control" style="width: 100%;" required>
                <option value="">Seleccionar</option>
                <?php foreach ($plantillas as $plantilla) : ?>
                  <option value="<?php echo $plantilla->id ?>"><?php echo $plantilla->nombre ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label for="plantilla_monto">Monto Total</label>
              <input type="number" name="plantilla_monto" id="plantilla_monto" class="form-control" value="0" min="0" step="0.01" required>
            </div>
          </div>
          <div class="row mt-10">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-small" id="tabla_insertar_plantilla">
                  <thead>
                    <tr>
                      <th width="40%">Cuenta</th>
                      <th>Tipo</th>
                      <th>Referencia</th>
                      <th>Monto</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- dinámico -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Insertar</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const plantillas = <?php echo json_encode($plantillas) ?>;
  const cuentas_finales = <?php echo json_encode($cuentas_finales); ?>;
  const monedas = <?php echo json_encode($monedas); ?>;

  $(document).ready(function() {
    // Mostrar ocultar primer y segundo formulario
    $('#segundaParteFormularioComprobante').hide();
    actualizarTotalesDiferencia(); // editar comprobante
    // Buscando los valores para las tazas de cambio Bs->US $ y Bs->UFV
    $('#idFechaComprobante').on('change', function() {
      $('#idTcBUsComprobante').val('');
      $('#idTcBUfvComprobante').val('');
      const fecha = $('#idFechaComprobante').val();
      $.ajax({
        type: "GET",
        url: BASE_URL + 'cofi/utilidades/verificar_tasa_de_cambio/' + fecha,
        dataType: 'json',
        success: function(response) {
          if (response) {
            $('#idTcBUsComprobante').val(response.tcBsUS);
            $('#idTcBUfvComprobante').val(response.tcBsUFV);
          }
        }
      });
    }).change();
    // Caso, importe solo numero y 2 decimales para idTcBUsComprobante
    $('#idTcBUsComprobante').on('keyup', function() {
      var valImporte = $('#idTcBUsComprobante').val();
      // se ACEPTA SOLO NUMEROS con 6 decimales
      this.value = valImporte;
      var regex = /^\d+(\.\d{0,6})?$/g;
      if (!regex.test(this.value)) this.value = this.value.substring(0, this.value.length - 1);
    });
    // Caso, importe solo numero y 6 decimales para idTcBUfvComprobante
    $('#idTcBUfvComprobante').on('keyup', function() {
      var valImporte = $('#idTcBUfvComprobante').val();
      // se ACEPTA SOLO NUMEROS con 2 decimales
      this.value = valImporte;
      var regex = /^\d+(\.\d{0,6})?$/g;
      if (!regex.test(this.value)) this.value = this.value.substring(0, this.value.length - 1);
    });
  });

  // Boton para pasar a la parte 2 del formulario
  $('#formulario_uno').submit(async function (e) {
    e.preventDefault();
    const tipo_comprobante_id = $('#idTipoComprobante').val();
    const response = await $.ajax({
      type: "GET",
      url: BASE_URL + 'cofi/comprobantes/obtener_numero_comprobante/' + tipo_comprobante_id,
      dataType: 'json',
      success: function(response) {
        return response;
      },
      error: function (error) {
        ok_alert_error(error);
      }
    });

    $('#correlativo').text(response.data);
    $('#primeraParteFormularioComprobante').hide();
    $('#segundaParteFormularioComprobante').show();
  });

  // Caso, Seleccionar CUENTA
  $('#idCuentaDataComprobante').on('change', function() {
    $('#nombreCuentaDataComprobante').val('');
    const idCuentaAdd = $('#idCuentaDataComprobante').val();
    if (!idCuentaAdd) return;
    const data_cuenta = cuentas_finales.find((item) => item.id == idCuentaAdd);
    $('#nombreCuentaDataComprobante').val(data_cuenta.nombre);
  });
  // Caso, Seleccionar MONEDA (titulo del importe)
  $('#idMonedaDataComprobante').on('change', function() {
    const idMonedaAdd = $('#idMonedaDataComprobante').val();
    const data_moneda = monedas.find((item) => item.id == idMonedaAdd);
    $('.titleImporteDataComprobante').text(data_moneda?.codigo);
  });

  function add_asiento_contable(cuenta_id, tipo, importe, referencia) {
    const cuenta = cuentas_finales.find(item => item.id == cuenta_id);

    const tipoMoneda = $('#idMonedaDataComprobante').val();
    const tcBs_US = $('#idTcBUsComprobante').val();
    const tcBs_UFV = $('#idTcBUfvComprobante').val();

    const data1Fila = `
      <td>` + cuenta.codigo_formato + `</td>
      <td>` + cuenta.nombre + `</td>`;

    if (tipo === "DEBE") {
      if (tipoMoneda == 1) { // INGRESO BOLIVIANOS
        var data2Fila = `
          <td>` + (importe).toFixed(2) + `</td>
          <td></td>
          <td hidden>` + (importe / tcBs_US).toFixed(2) + `</td>
          <td hidden></td>
          <td hidden>` + (importe / tcBs_UFV).toFixed(2) + `</td>
          <td hidden></td>`;
      } else if (tipoMoneda == 2) { // INGRESO DOLARES
        var data2Fila = `
          <td>` + (importe * tcBs_US).toFixed(2) + `</td>
          <td></td>
          <td hidden>` + (importe).toFixed(2) + `</td>
          <td hidden></td>
          <td hidden>` + (importe * tcBs_US / tcBs_UFV).toFixed(2) + `</td>
          <td hidden></td>`;
      } else { // INGRESO UFV
        var data2Fila = `
          <td>` + (importe * tcBs_UFV).toFixed(2) + `</td>
          <td></td>
          <td hidden>` + (importe * tcBs_UFV / tcBs_US).toFixed(2) + `</td>
          <td hidden></td>
          <td hidden>` + (importe).toFixed(2) + `</td>
          <td hidden></td>`;
      }
    } else { // HABER
      if (tipoMoneda == 1) { // INGRESO EN BOLIVIANOS
        var data2Fila = `
          <td></td>
          <td>` + importe.toFixed(2) + `</td>
          <td hidden></td>
          <td hidden>` + (importe / tcBs_US).toFixed(2) + `</td>
          <td hidden></td>
          <td hidden>` + (importe / tcBs_UFV).toFixed(2) + `</td>`;
      } else if (tipoMoneda == 2) { // INGRESO EN DOLARES
        var data2Fila = `
          <td></td>
          <td>` + (importe * tcBs_US).toFixed(2) + `</td>
          <td hidden></td>
          <td hidden>` + (importe).toFixed(2) + `</td>
          <td hidden></td>
          <td hidden>` + (importe * tcBs_US / tcBs_UFV).toFixed(2) + `</td>`;
      } else { // INGRESO EN UFV
        var data2Fila = `
          <td></td>
          <td>` + (importe * tcBs_UFV).toFixed(2) + `</td>
          <td hidden></td>
          <td hidden>` + (importe * tcBs_UFV / tcBs_US).toFixed(2) + `</td>
          <td hidden></td>
          <td hidden>` + (importe).toFixed(2) + `</td>`;
      }
    }

    const data3Fila = `
      <td>${referencia}</td>
      <td>
        <input name="cuenta_id" value="${cuenta_id}" hidden>
        <input name="referencia" value="${referencia}" hidden>
        <span class="table-up">     <button class="btn btn-warning btn-xs">&nbsp;<i class="fa fa-long-arrow-up" aria-hidden="true"></i>&nbsp;</button></span>
        <span class="table-down">   <button class="btn btn-warning btn-xs">&nbsp;<i class="fa fa-long-arrow-down" aria-hidden="true"></i>&nbsp;</button></span>
        <span class="table-edit">   <button class="btn btn-primary btn-xs"><i class="fa fa fa-edit" aria-hidden="true"></i></button></span>
        <span class="table-remove"> <button class="btn btn-danger btn-xs"><i class="fa fa fa-times" aria-hidden="true"></i></button></span>
      </td>`;
    const nuevaFila = '<tr>' + data1Fila + '' + data2Fila + '' + data3Fila + '</tr>';
    $('#tablaComprobantes tbody').append(nuevaFila);
  }
  // Caso, Incluir dato nuevo del comprobante (fila)
  $('#formulario_add_cuenta').submit(function (e) {
    e.preventDefault();
    const cuenta_id = $('#idCuentaDataComprobante').val();
    const tipo = $('#idDebeHaberDataComprobante').val();
    const importe = parseFloat($('#idImporteDataComprobante').val());
    const referencia = $('#idReferenciaDataComprobante').val();
    add_asiento_contable(cuenta_id, tipo, importe, referencia);
    limpiarFormDataComprobante();
    actualizarTotalesDiferencia();
  });
  $('#tablaComprobantes').on('click', '.table-remove', function() { // eliminar fila
    $(this).parents('tr').detach();
    actualizarTotalesDiferencia();
  });
  $('#tablaComprobantes').on('click', '.table-up', function() { // boton flecha arriba
    const $row = $(this).parents('tr');
    if ($row.index() == 0) return;
    $row.prev().before($row.get(0));
  });
  $('#tablaComprobantes').on('click', '.table-down', function() { // botón flecha abajo
    const $row = $(this).parents('tr');
    $row.next().after($row.get(0));
  });
  $('#tablaComprobantes').on('click', '.table-edit', function() { // botón editar
    const tipoMoneda = $('#idMonedaDataComprobante').val();
    let debeHaber;
    if (tipoMoneda == 1) { // Bolivianos
      // eq(2) y eq(3)
      if ($(this).parents('tr').find('td').eq(3).text() == '') { // debe
        $('#idImporteDataComprobante').val($(this).parents('tr').find('td').eq(2).text()); // importe
        debeHaber = "DEBE";
      } else { // haber
        $('#idImporteDataComprobante').val($(this).parents('tr').find('td').eq(3).text()); // importe
        debeHaber = "HABER";
      }
    } else if (tipoMoneda == 2) { // Dolares
      // eq(4) y eq(5)
      if ($(this).parents('tr').find('td').eq(5).text() == '') { // debe
        $('#idImporteDataComprobante').val($(this).parents('tr').find('td').eq(4).text()); // importe
        debeHaber = "DEBE";
      } else { // haber
        $('#idImporteDataComprobante').val($(this).parents('tr').find('td').eq(5).text()); // importe
        debeHaber = "HABER";
      }
    } else { // UFV
      // eq(6) y eq(7)
      if ($(this).parents('tr').find('td').eq(7).text() == '') { // debe
        $('#idImporteDataComprobante').val($(this).parents('tr').find('td').eq(6).text()); // importe
        debeHaber = "DEBE";
      } else { // haber
        $('#idImporteDataComprobante').val($(this).parents('tr').find('td').eq(7).text()); // importe
        debeHaber = "HABER";
      }
    }
    // Cuenta seleccionada
    $("#idCuentaDataComprobante").val($(this).parents('tr').find('input[name="cuenta_id"]').val()).trigger('change.select2'); // cuenta
    $('#nombreCuentaDataComprobante').val($(this).parents('tr').find('td').eq(1).text()); // nombre cuenta
    $('#idReferenciaDataComprobante').val($(this).parents('tr').find('input[name="referencia"]').val()); // referencia
    // Debe y Haber
    $("#idDebeHaberDataComprobante").val(debeHaber).change();
    // eliminar la fila a editar
    $(this).parents('tr').detach();
    actualizarTotalesDiferencia();
  });
  $('#btnRegistrarComprobante').on('click', function() { // registrar comprobante, verificar balanceo
    // data
    const data = {
      comprobante_tipo_id: $('#idTipoComprobante').val(),
      fecha: $('#idFechaComprobante').val(),
      tcBsUS: $('#idTcBUsComprobante').val(),
      tcBsUFV: $('#idTcBUfvComprobante').val(),
      nombre_razon_social: $('#idNomRazonSocComprobante').val(),
      moneda_id: $('#idMonedaDataComprobante').val(),
      glosa: $('#idGlosaComprobante').val()
    };

    // comprobante data
    let debeBs = 0;
    let haberBs = 0;
    let debeUS = 0;
    let haberUS = 0;
    let debeUFV = 0;
    let haberUFV = 0;
    const dataComprobante = [];

    $('#tablaComprobantes tbody tr').each(function() {
      if ($(this).find('td').eq(2).text() == "") debeBs += 0;
      else debeBs += parseFloat($(this).find('td').eq(2).text());

      if ($(this).find('td').eq(3).text() == "") haberBs += 0;
      else haberBs += parseFloat($(this).find('td').eq(3).text());

      if ($(this).find('td').eq(4).text() == "") debeUS += 0;
      else debeUS += parseFloat($(this).find('td').eq(4).text());

      if ($(this).find('td').eq(5).text() == "") haberUS += 0;
      else haberUS += parseFloat($(this).find('td').eq(5).text());

      if ($(this).find('td').eq(6).text() == "") debeUFV += 0;
      else debeUFV += parseFloat($(this).find('td').eq(6).text());

      if ($(this).find('td').eq(7).text() == "") haberUFV += 0;
      else haberUFV += parseFloat($(this).find('td').eq(7).text());

      const row = {
        cuenta_id: $(this).find('td').eq(9).find('input').val(),
        debeBs: $(this).find('td').eq(2).text(),
        haberBs: $(this).find('td').eq(3).text(),
        debeUS: $(this).find('td').eq(4).text(),
        haberUS: $(this).find('td').eq(5).text(),
        debeUFV: $(this).find('td').eq(6).text(),
        haberUFV: $(this).find('td').eq(7).text(),
        referencia: $(this).find('td').eq(8).text(),
      };
      dataComprobante.push(row);
    });

    // DIFERENCIA
    const diffDebeBs = ($('.classDiffDebeBs').text() == "") ? 0 : parseFloat($('.classDiffDebeBs').text());
    const diffHaberBs = ($('.classDiffHaberBs').text() == "") ? 0 : parseFloat($('.classDiffHaberBs').text());
    const diffDebeUS = ($('.classDiffDebeUS').text() == "") ? 0 : parseFloat($('.classDiffDebeUS').text());
    const diffHaberUS = ($('.classDiffHaberUS').text() == "") ? 0 : parseFloat($('.classDiffHaberUS').text());
    const diffDebeUFV = ($('.classDiffDebeUFV').text() == "") ? 0 : parseFloat($('.classDiffDebeUFV').text());
    const diffHaberUFV = ($('.classDiffHaberUFV').text() == "") ? 0 : parseFloat($('.classDiffHaberUFV').text());

    // if(diffDebeBs+diffHaberBs+diffDebeUS+diffHaberUS+diffDebeUFV+diffHaberUFV != 0)
    if (diffDebeBs + diffHaberBs != 0) {
      time_alert('warning', 'Alerta!', 'Comprobante desbalanceado.', 2000)
      return;
    } else if (dataComprobante.length <= 0) {
      time_alert('warning', 'Alerta!', 'Ingrese los datos del Comprobante.', 2000)
      return;
    }
    const tc1 = $('#idTcBUsComprobante').val();
    const tc2 = $('#idTcBUfvComprobante').val();
    msg_confirmation('warning', 'Está seguro de Registrar el Comprobante?', 'No podrá revertir los cambios!')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "POST",
            url: BASE_URL + 'cofi/comprobantes/registrar',
            data: { data, dataComprobante },
            dataType: 'json',
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Registrado!', 'Comprobante registrado correctamente.', 2000)
                .then(() => window.location.reload());
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  });
  $('#btnActualizarComprobante').on('click', function() { // actualizar comprobante, verificar balanceo
    const comprabante_id_editar = $('#idComprobanteEditado').val(); // Id del comprobante a ser editado
    // data
    const data = {
      comprobante_tipo_id: $('#idTipoComprobante').val(),
      fecha: $('#idFechaComprobante').val(),
      tcBsUS: $('#idTcBUsComprobante').val(),
      tcBsUFV: $('#idTcBUfvComprobante').val(),
      nombre_razon_social: $('#idNomRazonSocComprobante').val(),
      moneda_id: $('#idMonedaDataComprobante').val(),
      glosa: $('#idGlosaComprobante').val()
    };

    // comprobante data
    let debeBs = 0;
    let haberBs = 0;
    let debeUS = 0;
    let haberUS = 0;
    let debeUFV = 0;
    let haberUFV = 0;
    const dataComprobante = [];

    $('#tablaComprobantes tbody tr').each(function() {
      if ($(this).find('td').eq(2).text() == "") debeBs += 0;
      else debeBs += parseFloat($(this).find('td').eq(2).text());

      if ($(this).find('td').eq(3).text() == "") haberBs += 0;
      else haberBs += parseFloat($(this).find('td').eq(3).text());

      if ($(this).find('td').eq(4).text() == "") debeUS += 0;
      else debeUS += parseFloat($(this).find('td').eq(4).text());

      if ($(this).find('td').eq(5).text() == "") haberUS += 0;
      else haberUS += parseFloat($(this).find('td').eq(5).text());

      if ($(this).find('td').eq(6).text() == "") debeUFV += 0;
      else debeUFV += parseFloat($(this).find('td').eq(6).text());

      if ($(this).find('td').eq(7).text() == "") haberUFV += 0;
      else haberUFV += parseFloat($(this).find('td').eq(7).text());

      const row = {
        cuenta_id: $(this).find('td').eq(9).find('input').val(),
        debeBs: $(this).find('td').eq(2).text(),
        haberBs: $(this).find('td').eq(3).text(),
        debeUS: $(this).find('td').eq(4).text(),
        haberUS: $(this).find('td').eq(5).text(),
        debeUFV: $(this).find('td').eq(6).text(),
        haberUFV: $(this).find('td').eq(7).text(),
        referencia: $(this).find('td').eq(8).text(),
      };
      dataComprobante.push(row);
    });

    // DIFERENCIA
    const diffDebeBs = ($('.classDiffDebeBs').text() == "") ? 0 : parseFloat($('.classDiffDebeBs').text());
    const diffHaberBs = ($('.classDiffHaberBs').text() == "") ? 0 : parseFloat($('.classDiffHaberBs').text());
    const diffDebeUS = ($('.classDiffDebeUS').text() == "") ? 0 : parseFloat($('.classDiffDebeUS').text());
    const diffHaberUS = ($('.classDiffHaberUS').text() == "") ? 0 : parseFloat($('.classDiffHaberUS').text());
    const diffDebeUFV = ($('.classDiffDebeUFV').text() == "") ? 0 : parseFloat($('.classDiffDebeUFV').text());
    const diffHaberUFV = ($('.classDiffHaberUFV').text() == "") ? 0 : parseFloat($('.classDiffHaberUFV').text());

    // if(diffDebeBs+diffHaberBs+diffDebeUS+diffHaberUS+diffDebeUFV+diffHaberUFV != 0){
    if (diffDebeBs + diffHaberBs != 0) {
      time_alert('warning', 'Alerta!', 'Comprobante desbalanceado.', 2000)
      return;
    } else if (dataComprobante.length <= 0) {
      time_alert('warning', 'Alerta!', 'Ingrese los datos del Comprobante.', 2000)
      return;
    }
    const tc1 = $('#idTcBUsComprobante').val();
    const tc2 = $('#idTcBUfvComprobante').val();
    msg_confirmation('warning', 'Está seguro de Actualizar el Comprobante?', 'El comprobante será actualziado!')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "POST",
            url: BASE_URL + 'cofi/comprobantes/actualizar/' + comprabante_id_editar,
            data: { data, dataComprobante },
            dataType: 'json',
            success: function(data) {
              swloading.stop();
              time_alert('success', 'Actualizado!', 'Comprobante actualizado correctamente.', 2000)
                .then(() => {
                  window.location = BASE_URL + 'cofi/comprobantes';
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

  function limpiarFormDataComprobante() {
    $("#idCuentaDataComprobante").val('').change();
    $('#nombreCuentaDataComprobante').val('');
    $('#idDebeHaberDataComprobante').val('DEBE').change();
    $('#idImporteDataComprobante').val(0);
    $('#idReferenciaDataComprobante').val('');
  }

  function actualizarTotalesDiferencia() {
    let debeBs = 0;
    let haberBs = 0;
    let debeUS = 0;
    let haberUS = 0;
    let debeUFV = 0;
    let haberUFV = 0;
    $('#tablaComprobantes tbody tr').each(function() {
      if ($(this).find('td').eq(2).text() == "") debeBs += 0;
      else debeBs += parseFloat($(this).find('td').eq(2).text());

      if ($(this).find('td').eq(3).text() == "") haberBs += 0;
      else haberBs += parseFloat($(this).find('td').eq(3).text());

      /*if($(this).find('td').eq(4).text() == "") debeUS   	+= 0;
      else debeUS   	+= parseFloat($(this).find('td').eq(4).text());

      if($(this).find('td').eq(5).text() == "") haberUS   += 0;
      else haberUS    += parseFloat($(this).find('td').eq(5).text());

      if($(this).find('td').eq(6).text() == "") debeUFV   += 0;
      else debeUFV   	+= parseFloat($(this).find('td').eq(6).text());

      if($(this).find('td').eq(7).text() == "") haberUFV	+= 0;
      else haberUFV	+= parseFloat($(this).find('td').eq(7).text());*/
    });
    $('.classDebeBs').text(debeBs.toFixed(2));
    $('.classHaberBs').text(haberBs.toFixed(2));
    /*$('.classDebeUS').text(debeUS.toFixed(2));
    $('.classHaberUs').text(haberUS.toFixed(2));
    $('.classDebeUFV').text(debeUFV.toFixed(2));
    $('.classHaberUFV').text(haberUFV.toFixed(2));*/

    // DIFERENCIA
    // Bs.
    if (debeBs > haberBs) {
      $('.classDiffDebeBs').text("");
      $('.classDiffHaberBs').text((debeBs - haberBs).toFixed(2));
    } else {
      $('.classDiffDebeBs').text((haberBs - debeBs).toFixed(2));
      $('.classDiffHaberBs').text("");
    }
    // US $.
    /*if(debeUS > haberUS) {
      $('.classDiffDebeUS').text("");
      $('.classDiffHaberUS').text((debeUS-haberUS).toFixed(2));
    }else {
      $('.classDiffDebeUS').text((haberUS-debeUS).toFixed(2));
      $('.classDiffHaberUS').text("");
    }*/
    // UFV.
    /*if(debeUFV > haberUFV) {
      $('.classDiffDebeUFV').text("");
      $('.classDiffHaberUFV').text((debeUFV-haberUFV).toFixed(2));
    }else {
      $('.classDiffDebeUFV').text((haberUFV-debeUFV).toFixed(2));
      $('.classDiffHaberUFV').text("");
    }*/
  }

  $('#plantilla_id').on('change', async function () {
    $('#tabla_insertar_plantilla tbody').empty();
    const plantilla_id = $('#plantilla_id').val();
    const plantilla = plantillas.find(item => item.id == plantilla_id);
    if (plantilla) {
      const plantilla_data = await $.ajax({
        type: "GET",
        url: BASE_URL + 'cofi/plantillas/get_plantilla_data_by_plantilla_id/' + plantilla_id,
        dataType: "json",
        success: function (response) {
          return response;
        },
        error: function (error) {
          ok_alert_error(error);
          return [];
        }
      });
      const monto = parseFloat($('#plantilla_monto').val());
      const html = plantilla_data.map(item => {
        const cuenta = cuentas_finales.find(lc => lc.id == item.cuenta_id);
        const monto_parcial = (parseInt(item.porcentaje)*monto/100).toFixed(2);
        return (`
          <tr>
            <td>${cuenta.codigo_formato} | ${cuenta.nombre}</td>
            <td>${item.tipo}</td>
            <td>${item.referencia}</td>
            <td>
              <input type="number" name="monto" min="0.01" step="0.01" class="form-control" value="${monto_parcial}" required>
              <input type="text" name="cuenta_id" value="${item.cuenta_id}" hidden>
              <input type="text" name="tipo" value="${item.tipo}" hidden>
              <input type="text" name="referencia" value="${item.referencia}" hidden>
            </td>
          </tr>
        `);
      }).join('');
      $('#tabla_insertar_plantilla tbody').append(html);
    }
  });
  $('#plantilla_monto').on('change', function () {
    $('#plantilla_id').change();
  });
  $('#formulario_insertar_plantilla').submit(function (e) {
    e.preventDefault();

    $('#tabla_insertar_plantilla tbody > tr').each(function () {
      const cuenta_id = $(this).find('input[name="cuenta_id"]').val();
      const tipo = $(this).find('input[name="tipo"]').val();
      const monto = parseFloat($(this).find('input[name="monto"]').val());
      const referencia = $(this).find('input[name="referencia"]').val();

      add_asiento_contable(cuenta_id, tipo, monto, referencia);
    });
    actualizarTotalesDiferencia();
    $('#modal_usar_plantilla').modal('hide');
  });
</script>