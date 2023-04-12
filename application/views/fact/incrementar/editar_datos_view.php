<div class="header" style="background:#581D8D;">
  <span class="titulo_pagina">INGRESO - EDITAR DATOS CABECERA</span>
</div>
<p></p>

<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<script>
$(document).ready(function (){
  $("#fecha_ingreso_almacen").datepicker();
});//fin ready
function pulsar(e) {
  tecla = (document.all) ? e.keyCode :e.which;
  return (tecla!=13);
} 
</script>
<div class="content">
  <h2 class="content-head is-center" style="margin-bottom: 1.2em;">EDITAR DATOS CABECERA INGRESO Nro. <?php echo $adquisicion['id_nro_adquisicion'];?></h2>

  <form method="post" action="<?php echo base_url();?>incrementar/actualizar_datos/<?php echo $adquisicion['id_nro_adquisicion'];?>" class="pure-form pure-form-stacked" data-parsley-validate>  
    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
    <fieldset>
          <div class="pure-g" style="margin-top: -2em">
          <!--
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="fecha_ingreso_almacen">Fecha:</label>
                <input name="fecha_ingreso_almacen" id="fecha_ingreso_almacen" value="<?php echo trim(($adquisicion['fecha_adquisicion']));?>" placeholder="Ej. 12/02/2018" required>
              </div>
            </div>-->
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="proveedor">Proveedor:</label>
                <input name="proveedor" id="proveedor" value="<?php echo $adquisicion['proveedor'];?>" placeholder="Ej. Juan Perez" required>
              </div>
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="observacion_general">Observación:</label>
                <input name="observacion_general" id="observacion_general" value="<?php echo $adquisicion['observacion_general'];?>" placeholder="Ej. Adqu. repuestos pala" required>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="doc_respaldo">Doc. Respaldo:</label>
                <?php
                  $valores = array('FACTURA'=>'FACTURA', 'RECIBO'=>'RECIBO', 'NOTA VENTA'=>'NOTA VENTA', 'OTRO'=>'OTRO');
                  $valores_actual = $adquisicion['doc_respaldo'];
                  $js_valores='id="doc_respaldo"';
                  echo form_dropdown('doc_respaldo', $valores, $valores_actual, $js_valores);
                ?>                
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nro_doc_respaldo">Nro. Doc. Respaldo:</label>
                <input type="number" name="nro_doc_respaldo" id="nro_doc_respaldo" value="<?php echo $adquisicion['nro_doc_respaldo'];?>" placeholder="Ej. 1001" data-parsley-min="0" required>
              </div>
            </div>
            
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_cargo">Crear nuevo:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Actualizar</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_cargo">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
            </div>            
          </div>
        </fieldset>      
  </form>

</div>
