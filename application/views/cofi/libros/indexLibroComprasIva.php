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
            <div class="column">
               <?php #if($this->permission1->method('manage_invoice','read')->access()){ ?>
                  <!--a href="<?php #echo base_url('Cinvoice/manage_invoice') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_invoice') ?> </a-->
               <?php #}?>
               <?php #if($this->permission1->method('pos_invoice','create')->access()){ ?>
                  <!--a href="<?php #echo base_url('Cinvoice/pos_invoice') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('pos_invoice') ?> </a-->
               <?php #}?>
            </div>
         </div>
      </div>

      <!--Add Invoice -->
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                  
               <div class="panel-heading">
                  <!-- header indexCuentas -->   
                  <div class="panel-title">
                     <!--h4><?php echo display('new_invoice') ?></h4-->
                     <h4><?php echo "Libro de Compras IVA" ?></h4>
                  </div>
               </div>
                  
               <div class="panel-body">
                  <div class="row">
                     
                     <div class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                        <div class="panel panel-info">
                           <div class="panel-body text-center">
                              <div id="idFormulario">
                                 <div class="form-group col-md-10 col-md-offset-1 text-center">
                                    <div class="form-group col-md-6 col-md-offset-3">
                                       <div class="md-form">
                                          <label for="idPeriodoFiscal">Periodo Fiscal</label>
                                          <select class="form-control" id="idPeriodoFiscal">
                                             <?php $i=1;?>
                                             <?php foreach(MONTH_NAMES as $lm): ?>
                                                <option value="<?php echo $i++;; ?>"><?php echo $lm; ?></option>
                                             <?php endforeach; ?>
                                          </select>
                                       </div>
                                    </div>      
                                    <!-- <div class="form-group col-md-6">
                                       <div class="md-form">
                                          <label for="idSucursal">Sucursal</label>
                                          <select class="form-control" id="idSucursal">
                                             <option value="0">0</option>
                                          </select>
                                       </div>
                                    </div> -->
                                 </div>
                              </div>

                              <div class="form-group col-md-12 text-center">
                                 <button id="btnGenerarLibroComprasIvaPdf" class="btn btn-primary btn-rounded mb-4"><i class="fa fa-file-pdf-o"></i> Generar Libro de Compras IVA</button>
                                 <button id="btnGenerarLibroComprasIvaExcel" class="btn btn-success btn-rounded mb-4"><i class="fa fa-file-excel-o"></i> Generar Libro de Compras IVA</button>
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

<!-- ChartJs JavaScript -->
<script src="<?php echo base_url() ?>assets/plugins/chartJs/Chart.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/canvasjs.min.js" type="text/javascript"></script>

<!-- ====== JS sweet alerts ======== -->
<script src="<?php echo base_url(); ?>assets/js/sweet-alert/sweetalert.js"></script> 

<script type="text/javascript">
   // Variables globales (formulario)
   var mesPeriodoFiscal;
   var sucursal;
   $(document).ready(function () {
      function validarFormulario(){
         mesPeriodoFiscal  = $('#idPeriodoFiscal').val();
         sucursal          = $('#idSucursal').val();
         if(mesPeriodoFiscal == null){
            Swal.fire(
               'Periodo Fiscal!',
               'Debe Seleccionar un Periodo Fiscal válido para generar el Libro de Ventas IVA.',
               'error'
            )
            return false;
         }else if(sucursal == null){
            Swal.fire(
               'Sucursal!',
               'Debe Seleccionar una Sucursal válida.',
               'error'
            )
            return false;
         }else{
            return true;
         }
      }
		$('#btnGenerarLibroComprasIvaPdf').on('click', function () {
         if(validarFormulario()){
            $.ajax({
               type: "POST",
               dataType: 'text',
               url: "<?php echo base_url('cofi/llamarGenerarLibroComprasIva'); ?>",
               data: { mpf: mesPeriodoFiscal, s: sucursal, tr : 'PDF' },
               success: function(url) { 
                  window.open(url); // abre en otra pestaña
               }
            });
         }
      });
      $('#btnGenerarLibroComprasIvaExcel').on('click', function () {
         if(validarFormulario()){
            $.ajax({
               type: "POST",
               dataType: 'text',
               url: "<?php echo base_url('cofi/llamarGenerarLibroComprasIva'); ?>",
               data: { mpf: mesPeriodoFiscal, s: sucursal, tr : 'EXCEL' },
               success: function(url) { 
                  window.open(url); // abre en otra pestaña
               }
            });
         }
      });
	});
</script>