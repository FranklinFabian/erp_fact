<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<div class="content">
  <h2 class="content-head is-center">Editar item nro. <?php echo $item['id_adquisicion_producto'];?></h2>

      <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url();?>incrementar/actualizar_item/<?php echo $item['id_adquisicion_producto'];?>/<?php echo $item['id_nro_adquisicion'];?>" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-1">
              <div class="pure-control-group">
                <label for="id_producto">Producto:</label>
                <?php
                  $productos = $this->producto_model->get_all_habilitados();
                  foreach ($productos as $key => $value)
                    $dataProd[$value['id_producto']] = substr($value['nombre_producto'], 0,75).'...';
                  $prodActual = $item['id_producto']; 
                  $js='id="id_producto"';
                  echo form_dropdown('id_producto', $dataProd, $prodActual, $js);
                ?>
              </div>            
            </div>
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="cantidad_ingreso">Cantidad ingreso:</label>
                <input id="cantidad_ingreso" name="cantidad_ingreso" type="text" data-parsley-min="1" placeholder="Ej. 12" value="<?php echo $item['cantidad_ingreso'];?>" required>
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="precio_adquisicion">Precio adquisición:</label>
                <input id="precio_adquisicion" name="precio_adquisicion" type="text" data-parsley-min="0" placeholder="Ej. 12" value="<?php echo number_format($item['precio_adquisicion'], 2);?>" required>
              </div>            
            </div>            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="observacion">Observación:</label>
                <input id="observacion" name="observacion" type="text" placeholder="Ej. obs"  value="<?php echo $item['observacion'];?>">
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Crear nuevo:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Actualizar</button>
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

</div>
