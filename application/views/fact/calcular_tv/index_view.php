<div class="header">
  <span class="titulo_pagina">Calcular lecturas</span>
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
        <h2>CALCULO TV</h2> 
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
      location.href= BASE_URL+"calcular_tv/calcular";
    }
  }
</script>
