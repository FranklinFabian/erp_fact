<div class="header">
  <span class="titulo_pagina">emisión de masiva</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:history.back()" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>      
    </div>
    <?php 
      if(is_null($pvs)):
    ?>
    <p>NO EXISTEN PUNTOS DE VENTA QUE SINCRONIZAR</p>
    <?php else:?>
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            <?php if($this->config->item('codigoAmbiente')=='2'):?>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nro_peticiones">Nro de facturas:</label>
                <input id="nro_peticiones" name="nro_peticiones" type="number" min=0 max=1000 placeholder="Ej. 1000" required>
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="peticiones">Nro de peticiones:</label>
                <input id="peticiones" name="peticiones" type="number" min=0 max=100 placeholder="Ej. 10" required>
              </div>            
            </div>

            <?php endif;?>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="usuario">Punto venta:</label>
                <?php
                  foreach ($pvs as $key => $value) 
                    $data[$value['id_punto_venta']] = '(cod: '.$value['codigo_punto_venta'].') - '.$value['nombre_punto_venta'];
                  echo form_dropdown('id_punto_venta',$data);
                ?>
              </div>            
            </div>
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Enviar:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Enviar</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div>
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
      var url = BASE_URL+"sf_sin/generar_masivo_xml/";
      
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data){
          //if(data=="ok")
            $('#ajax').html(data)//location.href=BASE_URL+"punto_venta/";
          $("#btn_guardar").removeAttr("disabled");
          //else $('#ajax').html(data);
        }
      });
    }//fin if
  return false;
});
</script>
