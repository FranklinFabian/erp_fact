<div class="header">
  <span class="titulo_pagina">Administración - Productos - Nuevo Producto</span>
</div>
<p></p>

<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url().$this->router->fetch_class();?>" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <hr>
    
    <div id="ajax" style="background-color: #e5ff7f; padding:0.5em; border-radius:5px; color:#000; display:none;"></div>

      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
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
                  echo form_dropdown('id_categoria', $data_categoria, '', $js_categoria);
                ?>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nombre_producto">Nombre Producto:</label>
                <input id="nombre_producto" name="nombre_producto" type="text" placeholder="Ej. Fusible" autofocus required>
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="precio_venta">Precio de venta:</label>
                <input id="precio_venta" name="precio_venta" type="number" step="0.01" placeholder="Ej. 12.5" required>
              </div>
            </div>            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="cod_producto">Código Barras:</label>
                <input id="cod_producto" name="cod_producto" type="number" placeholder="Ej. 7771501000013">
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="unidad_medida">Unidad Medida:</label>
                <?php
                  foreach ($unidades as $key => $value)
                    $data[$value['id_parametrica_unidad_medida']] = $value['descripcion'];
                  echo form_dropdown('id_parametrica_unidad_medida',$data);
                ?>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nombre_producto">Estado:</label>
                <select name="estado_producto" id="estado_producto">
                  <option value="1">Habilitado</option>
                  <option value="0">Deshabilitado</option>
                </select>
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
                echo form_dropdown('id_producto_servicio',$data_prod_serv);
                ?>
              </div>
            </div>
          </div>
          
        <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Crear nuevo:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Guardar</button>
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
<script>
  $(document).ready(function(){
    $('#nombre_producto').keypress(function(tecla) {
        if(tecla.charCode == 34 || tecla.charCode == 39) return false;
    });
  });
$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);

      var url = BASE_URL+"producto/crear_producto";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
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
