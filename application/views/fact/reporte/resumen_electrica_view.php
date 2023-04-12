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
              <h4>Resumen Venta De Energía Eléctrica</h4>
            </div>
          </div>
          <div class="panel-body">
          <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/reporte/" class="btn btn-primary">Volver atrás</a>
                
                
              </div>
            </div>
            <?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>


<p></p>
<div class="content">
    <div class="pure-g">
     
    

    <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url()?>fact/reporte/generar_venta_electrica" target="_blank" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
          <p> <div class="pure-u-1 pure-u-md-1-4">
          <p><div class="pure-control-group">
                <label for="razon_social">Periodo:</label>
                <?php
                  foreach ($periodos as $key => $value)
                    $data[$value['idperiodo']] = ($value['emision']).' - '.$value['idperiodo'];
                  echo form_dropdown('idperiodo', $data);
                ?>                
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-controls">
                <label for="generar">Generar:</label>
                <button id="generar" type="submit" class="pure-button button-success">Generar</button>
              </div>
            </div></p>
          </div>
        </fieldset>
    </form>

    <div id="div_ajax"><!--ajax -->
    </div><!--Fin ajax -->

  </div>

<script>
/*
$('#form_buscar').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#buscar").attr("disabled", true);
      var $contenidoAjax = $('#div_ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      var url = BASE_URL+"reporte/buscar_cliente/";
      
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_buscar').serialize(),
        success: function(data){
            $('#div_ajax').html(data)//location.href=BASE_URL+"punto_venta/";
          $("#buscar").removeAttr("disabled");
        }
      });
    }//fin if
  return false;
});
*/
</script>
