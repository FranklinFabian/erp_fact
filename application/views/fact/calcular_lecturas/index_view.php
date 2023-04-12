<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Facturacion</h1>
      <small>Facturación Y Cobranzas</small>
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
              <h4>Calculo de Facturas</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/calcular_lecturas/" class="btn btn-primary">Calcular Lecturas</a>
                <a href="<?php echo base_url();?>fact/generar_facturas_13/" class="btn btn-primary">Generar Facturas SIN</a>
                <a href="<?php echo base_url();?>fact/envio_facturas_13/generar_pdf_enviar//" class="btn btn-primary">Finalizar Proceso</a>
              </div>
              
            </div>
<p></p>
<div class="content">
     <div class="pure-g">
    <div class="pure-u-1 pure-u-md-1-1">
        <h2>CALCULO DE LECTURAS</h2> 
    </div>
    <div class="pure-u-1 pure-u-md-1-1">
        <h3>Periodo activo: <?php echo ($periodo_act['emision']);?>  </h3> 
    </div>
    <div class="pure-u-1 pure-u-md-1-1">
      <p style="margin:2em;" id="ajax_btn">
        <button onclick="javascript:ejecutar_calculos();" class="pure-button button-success" >Realizar calculos</button>
      </p>
    </div>
  </div>
</div>
<script>
$(document).keydown(function(e) {
    if (e.keyCode == 27) return false;
});

  function ejecutar_calculos(){
    if(confirm("Esta seguro de ejecutar los calculos?")){
      $("#ajax_btn").load
      var $contenidoAjax = $('#ajax_btn').html('<div>Realizando el calculo, por favor no cierre esta ventana. <img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      location.href= BASE_URL+"fact/calcular_lecturas/calcular";
    }
  }
</script>
