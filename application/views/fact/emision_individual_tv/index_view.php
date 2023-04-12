<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<div class="header">
  <span class="titulo_pagina">Menu Venta TV cable</span>
</div>

<div class="content">
  <div class="pure-g">
    <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>localidad/lista" class="pure-button pure-button-primary" style="width:100%;">Nuevo</a></p></div>

    <!--<div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>zona/lista" class="pure-button pure-button-primary" style="width:100%;">Zonas</a></p></div>
    <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>calle/lista" class="pure-button pure-button-primary" style="width:100%;">Calles</a></p></div>
-->  
  </div>
  <hr>

  <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url()?>emision_individual_tv/cargar_abonado" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idabonado">Cod. abonado:</label>
                <input id="idabonado" name="idabonado" type="text" placeholder="Ej. 16055" autofocus required>
              </div>            
            </div>
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Buscar:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Buscar</button>
              </div>
            </div>
          </div>
        </fieldset>
      </form>  

</div>
