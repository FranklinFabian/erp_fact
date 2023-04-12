<div class="header">
  <span class="titulo_pagina">Inventario</span>
</div>

<div class="sub_content">
  <div class="pure-g">
    
    <div class="pure-u-1 pure-u-md-1-3">
      <p style="margin:5px 20px 5px 20px">
        <a href="<?php echo base_url();?>incrementar/" class="pure-button pure-button-primary" style="width:100%" type="submit">INGRESO</a>
      </p>
    </div>

  </div>

  <div class="pure-g">
    <!--<div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>admin/stock" class="pure-button button-black" style="width:100%;">Controlar Stock</a></p></div>-->
  </div>

  <div class="pure-g">
  </div>
</div>

<script>
function valores_fabrica(){
  if(confirm("Esta operación eliminara todos los datos del sistema. ¿Desea continuar?"))
    location.href="<?php echo base_url()?>admin/valores_fabrica/";
}
</script>