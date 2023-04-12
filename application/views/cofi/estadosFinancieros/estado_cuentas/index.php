<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Estados Financieros') ?></small>
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
              <h4>Estado de Cuentas</h4>
            </div>
          </div>

          <div class="panel-body">
            <div class="row">
              <div class="col-md-10 col-sm-12 col-md-offset-1" id="payment_from_1">
                <div class="panel panel-info">
                  <div class="panel-body text-center">
                    <p><strong>PERIODO 01/01/<?php echo selected_year() ?> - 31/12/<?php echo selected_year() ?></strong></p>
                    <hr>
                    <div class="form-group col-md-6 text-center">
                      <div class="row">
                        <div class="form-group col-md-12">
                          <label for="">Rango de Fechas</label>
                          <!-- <p>Si la fecha inicial (Desde Fecha) debe ser la fecha de inicio del periodo, para que los saldos sean correctos.</p> -->
                          <p>La fecha Hasta debe ser posterior o igual a la fecha Desde.</p>
                        </div>
                        <div class="form-group col-md-5">
                          <label for="">Desde Fecha: </label>
                          <input type="text" class="form-control" value="01/01/<?php echo selected_year() ?>" readonly />
                        </div>
                        <div class="form-group col-md-7">
                          <label for="">Hasta Fecha: </label>
                          <input class="form-control" type="date" id="idFechaFin" value="<?php echo selected_year() . '-12-31'; ?>" max="<?php echo selected_year() . '-12-31'; ?>" min="<?php echo selected_year() . '-01-01'; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-6 text-center">
                      <div class="row">
                        <div class="col-md-8">
                          <label for="idCuentas">Código de Cuenta</label>
                          <select class="form-control" id="idCuentas" style="width:100%;">
                            <option value="0">Seleccione una Cuenta...</option>
                            <?php foreach ($listaCuentasGE as $lc) : ?>
                              <?php if ($lc->cuenta_tipo_id == 4) : ?>
                                <!-- solo los que son CUENTA -->
                                <option value="<?php echo $lc->id; ?>"><?php echo $lc->codigo_formato . ' | ' . $lc->nombre; ?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label for="sTipoMoneda">Moneda</label>
                          <select class="form-control" name="sTipoMoneda" id="sTipoMoneda" style="width:100%;">
                            <option value="1">Bs.</option>
                            <option value="2">US $.</option>
                            <option value="3">Bs y US $.</option>
                          </select>
                        </div>
                        <div class="col-md-12 mt-10">
                          <label for="">Nombre de la Cuenta</label>
                          <input class="form-control" id="mostrarNombreCuenta" value="Seleccionar Cuenta" readonly />
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-12 text-center">
                      <button id="generarReporte" class="btn btn-primary btn-rounded mb-4"><i class="fa fa-file-pdf-o"></i> Reporte</button>
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
  const selected_year = '<?php echo selected_year() ?>';

  $(document).ready(function() {
    $('#idCuentas').on('change', function() {
      const cuenta_id = $('#idCuentas').val();
      const nomCuenta = $('#idCuentas option:selected').text().split('| ');
      $('#mostrarNombreCuenta').val('Seleccionar Cuenta');
      if (cuenta_id != 0)
        $('#mostrarNombreCuenta').val(nomCuenta[1]);
    });
    $('#generarReporte').on('click', function() {
      const fechaIni = selected_year + '-01-01';
      const fechaFin = $('#idFechaFin').val();
      const cuenta_id = $('#idCuentas').val();
      const tpMoneda = $('#sTipoMoneda').val();
      if (fechaFin == '') {
        time_alert('error', 'Error en el tipo de moneda!', 'Debe seleccionar un tipo de moneda.', 2000)
        return;
      }
      if (cuenta_id == 0) {
        time_alert('error', 'Error en la Cuenta!', 'Debe seleccionar una cuenta.', 2000)
        return;
      }
      if (!tpMoneda) {
        time_alert('error', 'Error en la moneda!', 'Debe seleccionar un tipo de moneda.', 2000)
        return;
      }
      swloading.start();
      $.ajax({
        type: "POST",
        url: BASE_URL + 'cofi/estadosFinancieros/verificar_estado_cuentas',
        data: {
          fechaIni,
          fechaFin,
          cuenta_id,
          tpMoneda
        },
        dataType: "text",
        success: function(url) {
          swloading.stop();
          if (url == "NO")
            time_alert('error', 'No existen registros!', 'No existen registros para esta cuenta.', 2000)
          else
            window.open(url);
        },
        error: function (error) {
          swloading.stop();
          ok_alert_error(error);
        }
      });
    });
  });
</script>
