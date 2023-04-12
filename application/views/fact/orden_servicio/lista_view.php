<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>

<div class="header">
  <span class="titulo_pagina">PROCESAR</span>
</div>
<p></p>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-5"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/procesar_ordenes/1" class="pure-button pure-button-primary" style="width:100%;">Inspecciones</a></p></div>
      <div class="pure-u-1 pure-u-md-1-5"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/procesar_ordenes_nueva_conexion/1" class="pure-button pure-button-primary" style="width:100%;">Nuevas conexiones</a></p></div>
      <div class="pure-u-1 pure-u-md-1-5"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/procesar_cortes/1" class="pure-button pure-button-primary" style="width:100%;">Cortes</a></p></div>
      <div class="pure-u-1 pure-u-md-1-5"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/procesar_reposiciones/1" class="pure-button pure-button-primary" style="width:100%;">Reposiciones</a></p></div>
    </div>
    <hr>
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-5"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/procesar_ordenes/2" class="pure-button button-secondary" style="width:100%;">Inspecciones tv</a></p></div>
      <div class="pure-u-1 pure-u-md-1-5"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/procesar_ordenes_nueva_conexion/2" class="pure-button button-secondary" style="width:100%;">Nuevas conexiones tv</a></p></div>
      <div class="pure-u-1 pure-u-md-1-5"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/procesar_cortes/2" class="pure-button button-secondary" style="width:100%;">Cortes tv</a></p></div>
      <div class="pure-u-1 pure-u-md-1-5"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/procesar_reposiciones/2" class="pure-button button-secondary" style="width:100%;">Reposiciones tv</a></p></div>
    </div>
<!-- 
    <form method="post" class="pure-form pure-form-stacked" id="form_buscar" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
          <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="razon_social">Razón Social abonado:</label>
                <input id="razon_social" name="razon_social" type="text" placeholder="Ej. Rafa">
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-controls">
                <label for="buscar">Buscar:</label>
                <button id="buscar" type="submit" class="pure-button button-success">Buscar</button>
              </div>
            </div>
          </div>
        </fieldset>
    </form>

    <div id="div_ajax"></div>
-->
  </div>

<script>

$('#form_buscar').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#buscar").attr("disabled", true);
      var $contenidoAjax = $('#div_ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      var url = BASE_URL+"orden_servicio/buscar_cliente/";
      
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_buscar').serialize(),
        success: function(data){
          //if(data=="ok")
            $('#div_ajax').html(data)//location.href=BASE_URL+"punto_venta/";
          $("#buscar").removeAttr("disabled");
          //else $('#ajax').html(data);
        }
      });
    }//fin if
  return false;
});


</script>
