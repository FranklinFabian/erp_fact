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
                     <h4>Libro Mayor</h4>
                  </div>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                        <div class="panel panel-info">
                           <div class="panel-body text-center">
                              <p><strong>PERIODO 01/01/<?php echo selected_year() ?> - 31/12/<?php echo selected_year() ?></strong></p>
                              <hr>
                              <div class="col-md-12">
                                 <p><strong>Rango de Cuentas:</strong></p>
                              </div>
                              <div class="col-md-12">
                                 <div class="col-md-4">
                                    <label for="idCuentaDesde">Desde la Cuenta: </label>
                                 </div>
                                 <div class="col-md-8">
                                    <select class="form-control" id="idCuentaDesde" style="width: 100%;">
                                       <?php foreach($listaCuentasFinalesGE as $index=>$lc): ?>
                                          <option value="<?php echo $index.'-'.$lc->codigo; ?>"><?php echo $lc->codigo_formato.' | '.$lc->nombre; ?></option>
                                       <?php endforeach; ?>
												</select>
                                 </div>
                              </div>
                              <div class="col-md-12" style="margin-top: 10px;">
                                 <div class="col-md-4">
                                    <label for="idCuentaHasta">Hasta la Cuenta: </label>
                                 </div>
                                 <div class="col-md-8">
                                    <select class="form-control" id="idCuentaHasta" style="width: 100%;">
                                       <?php foreach($listaCuentasFinalesGE as $index=>$lc): ?>
                                          <option value="<?php echo $index.'-'.$lc->codigo; ?>"><?php echo $lc->codigo_formato.' | '.$lc->nombre; ?></option>
                                       <?php endforeach; ?>
												</select>
                                 </div>
                              </div>
                              <div class="col-md-12 row" style="margin-top: 20px;">
                                 <div class="col-md-8">
                                    <div class="col-md-12">
                                       <p><strong>Rango de Fechas:</strong></p>
                                    </div>
                                    <div class="form-group col-md-6 text-center">
                                       <label for="idFechaIniForm">Desde Fecha: </label>
                                       <input class="form-control" type="date" id="idFechaIniForm" value="<?php echo selected_year() . '-01-01'; ?>">
                                    </div>
                                    <div class="form-group col-md-6 text-center">
                                       <label for="idFechaFinForm">Hasta Fecha: </label>
                                       <input class="form-control" type="date" id="idFechaFinForm" value="<?php echo selected_year() . '-12-31'; ?>">
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="col-md-12">
                                       <p><strong>&nbsp;</strong></p>
                                    </div>
                                    <div class="col-md-12">
                                       <label for="idMonedaForm">Moneda</label>
                                       <select id="idMonedaForm" class="form-control" style="width: 100%;">
                                          <?php foreach($monedas as $m): ?>
                                             <option value="<?php echo $m->id; ?>"><?php echo $m->codigo; ?></option>
                                          <?php endforeach; ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group col-md-12 text-center" style="margin-top:10px;">
                                 <button onclick="generarLibroMayorPDF()" class="btn btn-primary btn-rounded mb-4"><i class="fa fa-file-pdf-o"></i> Generar Libro Mayor</button>
                                 <button onclick="generarLibroMayorEXCEL()" class="btn btn-success btn-rounded mb-4"><i class="fa fa-file-excel-o"></i> Generar Libro Mayor</button>
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
   const gestionEmpresaJS = "<?php echo selected_year(); ?>";
   let fechaIni, fechaFin;
   let codCuentaDesde, codCuentaHasta;
   let tipoMoneda;

   function validarFormulario(){
      fechaIni          = $('#idFechaIniForm').val();
      fechaFin          = $('#idFechaFinForm').val();
      tipoMoneda        = $('#idMonedaForm').val();

      if(!$('#idCuentaDesde').val()) {
         time_alert('error', 'Error en la Cuenta!', 'Debe seleccionar la <b>Cuenta Desde</b>.', 2000)
         return false;
      }
      if(!$('#idCuentaHasta').val()) {
         time_alert('error', 'Error en la Cuenta!', 'Debe seleccionar la <b>Cuenta Hasta</b>.', 2000)
         return false;
      }
      let idesde = 0, ihasta = 0;
      [idesde, codCuentaDesde]   = $('#idCuentaDesde').val().split('-');
      [ihasta, codCuentaHasta]   = $('#idCuentaHasta').val().split('-');

      if(parseInt(idesde) > parseInt(ihasta)) {
         time_alert('error', 'Error en las Cuentas!', 'La <b>Cuenta Desde</b> debe ser menor o<br/>igual a la <b>Cuenta Hasta</b>.', 3000)
         return false;
      }

      if(fechaIni > fechaFin) {
         time_alert('error', 'Error en el Rango de Fechas!', 'La Fecha "Desde" debe ser anterior o <br>igual a la Fecha "Hasta".', 2000)
         return false;
      }
      if(fechaIni.split('-')[0]!=gestionEmpresaJS || fechaFin.split('-')[0]!=gestionEmpresaJS) {
         time_alert('error', 'Error en el Rango de Fechas!', 'Las fechas ingresadas no corresponde al periodo 01/01/'+gestionEmpresaJS+' - '+'31/12/'+gestionEmpresaJS, 2000)
         return false;
      }
      if(tipoMoneda == null) {
         time_alert('error', 'Error en el Tipo de Moneda!', 'Debe seleccionar un Tipo de Moneda Válido', 2000)
         return false;
      }
      return true;
   }
   function generarLibroMayorPDF() {
      if(validarFormulario()){
         const url = BASE_URL + 'cofi/libros/mayor_pdf?dt=' + btoa(codCuentaDesde+'/'+codCuentaHasta+'/'+fechaIni+'/'+fechaFin+'/'+tipoMoneda);
         window.open(url);
      }
   }
   function generarLibroMayorEXCEL() {
      if(validarFormulario()){
         const url = BASE_URL + 'cofi/libros/mayor_excel?dt='+btoa(codCuentaDesde+'/'+codCuentaHasta+'/'+fechaIni+'/'+fechaFin+'/'+tipoMoneda);
         window.open(url);
      }
   }
   $(document).ready(function () {
      $('#idCuentaDesde').on('change', function () {
         cuentaDesde = $('#idCuentaDesde').val();
         $("#idCuentaHasta").val(cuentaDesde).trigger('change.select2');   // cuenta
      });
	});
</script>
