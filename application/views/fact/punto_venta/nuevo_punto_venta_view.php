<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Atención al consumidor</h1>
      <small>Administración</small>
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
              <h4>Nuevo Puntos de Venta</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
            <div class="col-md-12">
                 <a href="<?php echo base_url();?>fact/punto_venta/" class="btn btn-primary">Volver Atrás</a>
              </div>
            </div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
   
    <?php 
      $cuis_principal = $this->cuis_model->get_cuis(1);
      if(is_null($cuis_principal)):
    ?>
    <p>Necesita obtener el CUIS del punto de venta CASA MATRIZ</p>
    <?php else:?>
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            
          <p>  <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="codigo_sucursal">Código sucursal:</label>
                <input id="codigo_sucursal" name="codigo_sucursal" type="number" min=0 max=100 placeholder="Ej. 0" required>
              </div>            
            </div></p>
            
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="codigo_punto_venta">Código punto venta:</label>
                <?php $pv = $this->punto_venta_model->get_ultimo_punto_venta();?>
                <input id="codigo_punto_venta" name="codigo_punto_venta" type="number" min=0 max=100 value="<?php echo $pv['codigo_punto_venta']+1;?>" placeholder="Ej. 0" required readonly>
              </div>            
            </div></p>

            <p> <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="usuario">Tipo punto venta:</label>
                <?php
                  $codigo_tipo_punto_venta = $this->config->item('codigo_tipo_punto_venta');
                  $js_codigo_tipo_punto_venta='required="required"';
                  echo form_dropdown('codigo_tipo_punto_venta',$codigo_tipo_punto_venta, '',$js_codigo_tipo_punto_venta);
                ?>
              </div>            
            </div></p>

            <p> <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="descripcion_punto_venta">Descripción punto venta:</label>
                <input id="descripcion_punto_venta" name="descripcion_punto_venta" type="text" placeholder="Ej. PV casa matriz único" required>
              </div>            
            </div></p>

            <p> <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nombre_punto_venta">Nombre punto venta:</label>
                <input id="nombre_punto_venta" name="nombre_punto_venta" type="text" placeholder="Ej. PV casa matriz" required>
              </div>            
            </div></p>

          </div>

          <p> <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Registrar punto venta:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Registrar</button>
              </div>
            </div></p>
            <p>  <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div></p>
          </div>

        </fieldset>
      </form>
      <?php endif;?>
      <div id="ajax" class="resultado">Resultado</div>

    </div>
<script>

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      var $contenidoAjax = $('#ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      var url = BASE_URL+"fact/unto_venta/guardar_punto_venta/<?php echo $cuis_principal['cuis_codigo'];?>";
      
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data){
          //location.href=BASE_URL+"usuario";
          if(data=="ok")
            location.href=BASE_URL+"fact/punto_venta/";
          else $('#ajax').html(data);
        }
      });
    }//fin if
  return false;
});
</script>
