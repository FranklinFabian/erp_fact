<div class="header">
  <span class="titulo_pagina">PAQUETE ENVIADO EXISTOSAMENTE</span>
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
        <p><?php echo $mensaje_paquete;?></p>
        <h2 style="color: blue">PAQUETE ENVIADO EXITOSAMENTE</h2> 
        <p><?php echo 'Se enviaron '.$cont_enviado.' Facturas empaquetadas.';?></p>
    </div>
  </div>
</div>
