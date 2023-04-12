<div class="header">
  <span class="titulo_pagina">Administración - Productos - Editar Producto</span>
</div>
<p></p>

<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">

    <div id="ajax" style="background-color: #e5ff7f; padding:0.5em; border-radius:5px; color:#000; display:none;"></div>

    <div class="l-box pure-u-1 pure-u-md-1-1 pure-u-lg-1-1">
      <form method="post" class="pure-form pure-form-stacked" id="form_actualizar" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
          <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="id_categoria">Categoria:</label>
                <?php
                  $data_categoria = array();
                  $data_categoria[NULL] = 'ELIJA CATEGORIA';
                  $categorias = $this->categoria_model->get_all_habilitados();
                  foreach ($categorias as $key => $value) {
                      $data_categoria[$value['id_categoria']] = $value['nombre_categoria'];
                  }
                  
                  $js_categoria = 'id="id_categoria" required=""';
                  echo form_dropdown('id_categoria', $data_categoria, $producto['id_categoria'], $js_categoria);
                ?>

              </div>
            </div>            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nombre_producto">Nombre Producto:</label>
                <input id="nombre_producto" name="nombre_producto" type="text" placeholder="Ej. Fusible" value="<?php echo $producto['nombre_producto'];?>" required>
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="cod_producto">Código Barras:</label>
                <input id="cod_producto" name="cod_producto" type="text" placeholder="Ej. 7771501000013" value="<?php echo $producto['cod_producto'];?>">
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="precio_venta">Precio venta:</label>
                <input id="precio_venta" name="precio_venta" type="number" step="0.01" placeholder="Ej. 12.5" value="<?php echo $producto['precio_venta'];?>" required>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="unidad_medida">Unidad Medida:</label>
                <?php
                  //$unidades = $this->config->item('unidades');
                  foreach ($unidades as $key => $value)
                    $data[$value['id_parametrica_unidad_medida']] = $value['descripcion'];

                  $js = "id='id_unidad_medida'";
                  $unidad_actual = $producto['id_unidad_medida'];
                  echo form_dropdown('id_unidad_medida',$data,$unidad_actual,$js);
                ?>
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="estado_producto">Estado:</label>
                <?php 
                  $data_habilitado['1'] = 'Habilitado';
                  $data_habilitado['0'] = 'Deshabilitado';
                  $estado_actual = $producto['estado_producto'];
                  echo form_dropdown('estado_producto', $data_habilitado,$estado_actual);
                 ?>
              </div>            
            </div>
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-1">
              <div class="pure-control-group">
                <label for="id_producto_servicio">Homologación de producto:</label>
                <?php
                  
                  foreach ($prod_serv as $key => $value)
                    $data_prod_serv[$value['id_producto_servicio']] = substr($value['descripcion_producto'],0,125).'...';
                
                echo form_dropdown('id_producto_servicio',$data_prod_serv, $producto['id_producto_servicio']);
                ?>
              </div>
            </div>
          </div>
          
          <div class="pure-g">
              <div class="pure-u-1 pure-u-md-1-3">
                <div class="pure-controls">
                  <label for="">Actualizar:</label>
                  <button type="submit" id="btn_guardar" class="pure-button button-success">Guardar</button>
                </div>
              </div>
              <div class="pure-u-1 pure-u-md-1-3">
                <div class="pure-controls">
                  <label for="">Cancelar:</label>
                  <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
                </div>
              </div>          
          </div>          
        </fieldset>
      </form>
    </div>
<script>
  $(document).ready(function(){
    $('#nombre_producto').keypress(function(tecla) {
        if(tecla.charCode == 34 || tecla.charCode == 39) return false;
    });
  });

$('#form_actualizar').submit(function(){
  if($(this).parsley().isValid())
    {
      var url = BASE_URL+"producto/actualizar_producto/<?php echo $producto['id_producto']?>";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_actualizar').serialize(),
        success: function(data)
        {
          if(data=='ok')
            location.href=BASE_URL+"producto";
          else{
            $("#ajax").fadeIn();
            $("#ajax").html("El producto <strong>"+data+"</strong> ya existe.");
            $("#nombre_producto").focus();
            $("#btn_guardar").attr("disabled", false);
          }
        }
      });
    }//fin if
  return false;
});
</script>
