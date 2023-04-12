<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<div class="content">
      <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url();?>incrementar/add_to_adq/<?php echo $id_nro_adquisicion;?>" data-parsley-validate>
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
                  echo form_dropdown('id_producto', $dataProd);
                ?>
              </div>            
            </div>
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="cantidad_ingreso">Cantidad ingreso:</label>
                <input id="cantidad_ingreso" name="cantidad_ingreso" type="number" data-parsley-min="1" placeholder="Ej. 12" required>
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="precio_adquisicion">Precio adquisición:</label>
                <input id="precio_adquisicion" name="precio_adquisicion" type="text" data-parsley-min="0" placeholder="Ej. 12" required>
              </div>            
            </div>            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="observacion">Observación:</label>
                <input id="observacion" name="observacion" type="text" placeholder="Ej. obs">
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Agregar a la adq.:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-small button-success">Agregar</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Cancelar:</label>
                <a href="<?php echo base_url().'incrementar/editar_items/'.$id_nro_adquisicion?>" class="pure-button button-small button-error">Cancelar agregar</a>
              </div>
            </div>

          </div>
        </fieldset>
      </form>

</div>
