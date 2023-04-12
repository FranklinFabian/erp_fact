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
      if (isset($message)){ ?>
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
                     <h4>Estados Financieros</h4>
                  </div>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                        <div class="panel panel-info">
                           <div class="panel-body text-center">
                              <p><strong>PERIODO 01/01/<?php echo selected_year() ?> - 31/12/<?php echo selected_year() ?></strong></p>
                              <hr>
                              <div class="form-group col-md-8 text-center">
                                 <div class="form-group col-md-12">
                                    <label for="">Rango de Fechas</label>
                                    <!-- <p>Si la fecha inicial (Desde Fecha) es posterior a la fecha de inicio del periodo, entonces se tendrá un saldo.</p> -->
                                    <p>La fecha Hasta debe ser posterior o igual a la fecha Desde.</p>
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="">Desde Fecha: </label>
                                    <input class="form-control" type="date" id="idFechaIni" value="<?php echo selected_year() . '-01-01'; ?>" min="<?php echo selected_year() . '-01-01'; ?>">
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label for="">Hasta Fecha: </label>
                                    <input class="form-control" type="date" id="idFechaFin" value="<?php echo selected_year() . '-12-31'; ?>" max="<?php echo selected_year() . '-12-31'; ?>">
                                 </div>
                              </div>
                              <div class="form-group col-md-4 text-center">
                                 <div class="col-md-12">
                                    <label for="sNivelCuenta">Nivel de Cuenta</label>
                                    <select class="form-control" id="sNivelCuenta" style="width:100%;">
                                       <?php foreach($cuentas_tipos as $index => $ct): ?>
                                          <option value="<?php echo $ct->id; ?>"><?php echo $ct->nombre; ?></option>
                                          <?php if($index == 4) break; ?> <!-- Desde GRUPOS hasta CUENTAS -->
                                       <?php endforeach; ?>
                                    </select>
                                 </div>
                                 <div class="col-md-12 mt-10">
                                    <label for="sTipoMoneda">Moneda</label>
                                    <select class="form-control" id="sTipoMoneda" style="width:100%;">
                                       <option value="<?php echo "1"; ?>"><?php echo "Bs."; ?></option>
                                       <option value="<?php echo "2"; ?>"><?php echo "US $."; ?></option>
                                       <option value="<?php echo "3"; ?>"><?php echo "Bs y US $."; ?></option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-12 text-center">
                                 <button id="btnBalSumasSaldos" class="btn btn-primary btn-rounded mb-4"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Bal. Sumas y Saldos</button>
                                 <button id="btnBalGeneral" class="btn btn-primary btn-rounded mb-4"><i class="fa fa-file-pdf-o"></i> Balance General</button>
                                 <button id="btnEstResultados" class="btn btn-primary btn-rounded mb-4"><i class="fa fa-file-pdf-o"></i> Estado de Resultados</button>
                              </div>
                              <div class="col-md-12 text-center mt-2">
                                 <button onclick="generarBalSumasSaldosExcel()" class="btn btn-success btn-rounded mb-4"><i class="fa fa-file-excel-o"></i> Bal. Sumas y Saldos</button>
                                 <button onclick="generarBalGeneralExcel()" class="btn btn-success btn-rounded mb-4"><i class="fa fa-file-excel-o"></i> Balance General</button>
                                 <button onclick="generarEstResultadosExcel()" class="btn btn-success btn-rounded mb-4"><i class="fa fa-file-excel-o"></i> Estado de Resultados</button>
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
   const BASE_URL_EF = BASE_URL + 'cofi/estadosFinancieros/';
   let fechaIni, fechaFin;
   let nivelCta, tpMoneda;

   function validarFormulario() {
      fechaIni = $('#idFechaIni').val();
      fechaFin = $('#idFechaFin').val();
      nivelCta = $('#sNivelCuenta').val();
      tpMoneda = $('#sTipoMoneda').val();
      // Rango de fechas formulario
      const fi   = new Date(fechaIni+"T00:00:00"); // agregar la hora +, para mas llevar a una fecha correcta
      const ff   = new Date(fechaFin+"T00:00:00");
      // Rango de fecha válido
      const fri  = new Date(selected_year + "-01-01T00:00:00");
      const frf  = new Date(selected_year + "-12-31T00:00:00");
      // Validadición
      if(((fi>=fri)&&(fi<=frf))&&((ff>=fri)&&(ff<=frf))) {
         if(fi<=ff) {
            return true;
         } else{
            time_alert('error', 'Error en la fecha!', 'La <b>Fecha "Desde"</b> debe ser <br>anterior a la <b>Fecha "Hasta"</b>.', 2000)
               .then(() => { return false; });
         }
      } else {
         time_alert('error', 'Error en la fecha!', `No corresponde al periodo 01/01/${selected_year} - 31/12/${selected_year}.`, 2000)
            .then(() => { return false; });
      }
   }

   function generarBalSumasSaldosExcel() {
      if (validarFormulario()) {
         const url = BASE_URL_EF + 'balance_sumas_saldos_excel?dt=' + btoa(fechaIni+'/'+fechaFin+'/'+nivelCta+'/'+tpMoneda);
         window.open(url);
      }
   }
   function generarBalGeneralExcel() {
      if (validarFormulario()) {
         const url = BASE_URL_EF + 'balance_general_excel?dt=' + btoa(fechaIni+'/'+fechaFin+'/'+nivelCta+'/'+tpMoneda);
         window.open(url);
      }
   }
   function generarEstResultadosExcel() {
      if (validarFormulario()) {
         const url = BASE_URL_EF + 'estado_resultados_excel?dt=' + btoa(fechaIni+'/'+fechaFin+'/'+nivelCta+'/'+tpMoneda);
         window.open(url);
      }
   }

   $(document).ready(function () {
		$('#btnBalSumasSaldos').on('click', function () {
         if (validarFormulario()) {
            const url = BASE_URL_EF + 'balance_sumas_saldos_pdf?dt=' + btoa(fechaIni+'/'+fechaFin+'/'+nivelCta+'/'+tpMoneda);
            window.open(url);
         }
      });
		$('#btnBalGeneral').on('click', function () {
         if (validarFormulario()) {
            const url = BASE_URL_EF + 'balance_general_pdf?dt='+btoa(fechaIni+'/'+fechaFin+'/'+nivelCta+'/'+tpMoneda);
            window.open(url);
         }
      });
      $('#btnEstResultados').on('click', function () {
         if (validarFormulario()) {
            const url = BASE_URL_EF + 'estado_resultados_pdf?dt=' + btoa(fechaIni+'/'+fechaFin+'/'+nivelCta+'/'+tpMoneda);
            window.open(url);
         }
      });
	});
</script>