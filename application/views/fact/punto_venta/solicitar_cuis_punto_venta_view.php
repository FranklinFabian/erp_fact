<div class="header">
  <span class="titulo_pagina">Solicitud CUIS</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:history.back()" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <p class="amarillo">
      ADVERTENCIA: Va a solicitar CUIS por 365 días para el punto de venta <strong><?php echo $pv['nombre_punto_venta'];?></strong> con el código punto de venta <strong><?php echo $pv['codigo_punto_venta'];?></strong> no podra editar esta acción.
    </p>
    
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="codigo_sucursal">Código sucursal:</label>
                <input id="codigo_sucursal" name="codigo_sucursal" type="number" min=0 max=100 value="<?php echo $pv['codigo_sucursal'];?>" placeholder="Ej. 0" required readonly>
              </div>            
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="codigo_punto_venta">Código punto venta:</label>
                <input id="codigo_punto_venta" name="codigo_punto_venta" type="number" min=0 max=100 value="<?php echo $pv['codigo_punto_venta'];?>" placeholder="Ej. 0" required readonly>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="usuario">Tipo punto venta:</label>
                <?php
                  $codigo_tipo_punto_venta = $this->config->item('codigo_tipo_punto_venta');
                  $js_codigo_tipo_punto_venta='required="required" readonly="" ';
                  echo form_dropdown('codigo_tipo_punto_venta',$codigo_tipo_punto_venta, $pv['codigo_tipo_punto_venta'],$js_codigo_tipo_punto_venta);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="descripcion_punto_venta">Descripción punto venta:</label>
                <input id="descripcion_punto_venta" name="descripcion_punto_venta" type="text" value="<?php echo $pv['descripcion_punto_venta'];?>" placeholder="Ej. PV casa matriz único" required readonly>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nombre_punto_venta">Nombre punto venta:</label>
                <input id="nombre_punto_venta" name="nombre_punto_venta" type="text" value="<?php echo $pv['nombre_punto_venta'];?>" placeholder="Ej. PV casa matriz" required readonly>
              </div>            
            </div>

          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Solicitar CUIS:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Solicitar CUIS</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div>
          </div>

        </fieldset>
      </form>
      <div id="ajax" class="resultado">Salida</div>
    </div>
<script>

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      var $contenidoAjax = $('#ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      var url = BASE_URL+"fact/punto_venta/obtener_cuis/<?php echo $pv['id_punto_venta'];?>";

      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data){
          if(data=="ok")
            location.href=BASE_URL+"fact/punto_venta/";
          else $('#ajax').html(data);
        }
      });
    }//fin if
  return false;
});
</script>
