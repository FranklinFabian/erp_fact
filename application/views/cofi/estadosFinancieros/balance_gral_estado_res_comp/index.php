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
              <h4>Balance Gral. y Estados de Resultados Comparativos</h4>
            </div>
          </div>

          <div class="panel-body">
            <div class="row">
              <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                <div class="panel panel-info">
                  <div class="panel-body">
                    <p class="text-center"><strong>PERIODO 01/01/<?php echo selected_year() ?> - 31/12/<?php echo selected_year() ?></strong></p>
                    <hr>
                    <div class="form-group col-md-5 text-center">
                      <div class="form-group col-md-12">
                        <label for="">Nivel de Cuentas</label>
                        <select class="form-control" id="sNivelCuenta">
                          <?php foreach ($cuentas_tipos as $ct) : ?>
                            <option value="<?php echo $ct->id; ?>"><?php echo $ct->nombre; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group col-md-12">

                        <label for="">Moneda</label>
                        <select class="form-control" id="sTipoMoneda">
                          <option value="1">Bs.</option>
                          <option value="2">US $.</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group col-md-7">
                      <div class="col-md-12 text-center">
                        <label for="">Balance - Estado de Resultados</label>
                      </div>
                      <div class="form-check col-md-12">
                        <input class="form-check-input" type="radio" name="tipoBalance" id="balGenComp" value="1" checked>
                        <label class="form-check-label" for="balGenComp">Balance General Comparativo</label>
                      </div>
                      <div class="form-check col-md-12">
                        <input class="form-check-input" type="radio" name="tipoBalance" id="estResComp" value="2">
                        <label class="form-check-label" for="estResComp">Estado de Resultado Comparativo</label>
                      </div>
                      <div class="form-group col-md-12 text-center">
                        <label for="mesForm">Al mes de</label>
                        <select id="mesForm" class="form-control">
                          <option value="1">Enero</option>
                          <option value="2">Febrero</option>
                          <option value="3">Marzo</option>
                          <option value="4">Abril</option>
                          <option value="5">Mayo</option>
                          <option value="6">Junio</option>
                          <option value="7">Julio</option>
                          <option value="8">Agosto</option>
                          <option value="9">Septiembre</option>
                          <option value="10">Octubre</option>
                          <option value="11">Noviembre</option>
                          <option value="12">Diciembre</option>
                        </select>
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
  let nivelCta, tpMoneda;
  let tpBalance, mesBalance;

  $(document).ready(function() {
    $('#generarReporte').on('click', function() {
      nivelCta = $('#sNivelCuenta').val();
      tpMoneda = $('#sTipoMoneda').val();
      tpBalance = $('input:radio[name=tipoBalance]:checked').val();
      mesBalance = $('#mesForm').val();

      const dataGET = '?dt=' + btoa(nivelCta + '/' + tpMoneda + '/' + tpBalance + '/' + mesBalance + '/' + selected_year);
      const url = BASE_URL + 'cofi/estadosFinancieros/balance_gral_estado_res_comp_pdf' + dataGET;
      window.open(url);
    });
  });
</script>
