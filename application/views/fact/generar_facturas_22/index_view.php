<div class="header">
  <span class="titulo_pagina">Generar paquetes facturas tv cable</span>
</div>
<p></p>
<div class="content">
  <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-4"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>calcular_tv/" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Calcular lecturas TV</a></p></div>
      <div class="pure-u-1 pure-u-md-1-4"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>generar_facturas_22/" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Generar facturas TV SIN</a></p></div>
      <div class="pure-u-1 pure-u-md-1-4"><p style="margin:5px 20px 5px 20px"><a target="_blank" href="<?php echo base_url();?>envio_facturas_22/generar_pdf_enviar/" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Finalizar proceso</a></p></div>
    </div>
    <hr>

  <div class="pure-g">
    <div class="pure-u-1 pure-u-md-1-1">
        <h2 style="color: blue">Generar paquetes facturas tv cable</h2> 
    </div>
    <div class="pure-u-1 pure-u-md-1-1">
        <h3>Periodo activo: <?php echo ($periodo_act['emision']);?>  </h3> 
        <h3>Cantidad de facturas por enviar al SIN <span style="color:green"><?php echo $cantidad_restante;?> </span></h3>
    </div>
    <div class="pure-u-1 pure-u-md-1-1">
      <p style="margin:2em;" id="ajax_btn">
        <button onclick="javascript:ejecutar();" class="pure-button button-success" >Generar facturas tv cable</button>
      </p>
    </div>
  </div>
</div>
<script>
$(document).keydown(function(e) {
    if (e.keyCode == 27) return false;
});

  function ejecutar(){
    if(confirm("Esta seguro de generar las facturas tv cable?")){
      $("#ajax_btn").load
      var $contenidoAjax = $('#ajax_btn').html('<div>Generando facturas y firmando documentos, por favor no cierre esta ventana. <img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      location.href= BASE_URL+"generar_facturas_22/calcular";
    }
  }
</script>
