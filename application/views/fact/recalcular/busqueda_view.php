<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>

<div class="header">
  <span class="titulo_pagina">SERVICIO TV CABLE</span>
</div>
<p></p>
<div class="content">
    <form method="post" class="pure-form pure-form-stacked" id="form_buscar" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-5">
              <div class="pure-control-group">
                <label for="apellidos">Apellidos:</label>
                <input id="apellidos" name="apellidos" type="text" placeholder="Ej. lopez" autofocus>
              </div>            
            </div>
            
            <div class="pure-u-1 pure-u-md-1-5">
              <div class="pure-control-group">
                <label for="nombres">Nombres:</label>
                <input id="nombres" name="nombres" type="text" placeholder="Ej. juan">
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-5">
              <div class="pure-controls">
                <label for="nombre_area">Buscar:</label>
                <button id="btn_guardar" type="submit" class="pure-button pure-button-primary">Buscar</button>
              </div>
            </div>

          </div>
        </fieldset>
      </form>    
    
    <div id="div_ajax"><!--ajax -->
    </div><!--Fin ajax -->
  
</div>

<script>
  /* Busqueda */
$('#form_buscar').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#buscar").attr("disabled", true);
      var $contenidoAjax = $('#div_ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      var url = BASE_URL+"recalcular/buscar_cliente/";
      
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

</script>
