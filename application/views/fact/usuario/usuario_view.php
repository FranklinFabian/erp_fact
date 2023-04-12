<div class="header">
  <span class="titulo_pagina">Administración - Usuarios - Nuevo Usuario</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url().$this->router->fetch_class();?>" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nombre">Nombres:</label>
                <input id="nombre" name="nombre" type="text" placeholder="Ej. Juan Manuel" autofocus required>
              </div>            
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="apellido">Apellidos:</label>
                <input id="apellido" name="apellido" type="text" placeholder="Ej. Perez Lopez" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="usuario">Nombre de Usuario:</label>
                <input id="usuario" name="usuario" type="text" placeholder="Ej. j_perez_lopez" required>
              </div>            
            </div>
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="password">Contraseña:</label>
                <input id="password" name="password" type="password" required>
              </div>            
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="password2">Repita contraseña:</label>
                <input id="password2" name="password2" type="password" data-parsley-equalto="#password" required>
              </div>            
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="usuario">Nivel de Usuario:</label>
                <?php
                  $data_niveles = $this->config->item('niveles');
                  $js_niveles='id="nivel" required="required"';
                  echo form_dropdown('nivel',$data_niveles,'',$js_niveles);
                ?>
              </div>            
            </div>
          </div>


          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nombre">Punto venta:</label>
                <?php
                $pv = $this->punto_venta_model->get_all();
                if(is_null($pv)){
                  echo 'No existe puntos de venta, creelos primero.';
                }else{
                  $data_pv[null]="Seleccione...";
                  foreach ($pv as $key => $value) {
                    $data_pv[$value['id_punto_venta']]= 'Suc:'.$value['codigo_sucursal'].' Cod:'.$value['codigo_punto_venta'].'-'.$value['nombre_punto_venta'];
                  }
                  $js_pv='id="id_punto_venta" disabled';
                  echo form_dropdown('id_punto_venta', $data_pv,'',$js_pv);
                }
                ?>
              </div>            
            </div>            

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nombre">Estado Usuario:</label>
                <select name="estado" id="estado">
                  <option value="1">Habilitado</option>
                  <option value="0">Deshabilitado</option>
                </select>
              </div>            
            </div>            
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Crear nuevo:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Guardar</button>
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
<script>

$("#nivel").change(function(){
    if(($(this).val()==1) || ($(this).val()==2)  || ($(this).val()==3) ){// si es 1 == usuario o 3 comisionista
      $("#id_punto_venta").removeAttr("disabled");
      $("#id_punto_venta").attr("required","required");
    }else{
      $("#id_punto_venta").removeAttr("required");
      $("#id_punto_venta").val(0);
      $("#id_punto_venta").attr("disabled",true);
    }
  });

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"usuario/crear_usuario";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          location.href=BASE_URL+"usuario";
        }
      });
    }//fin if
  return false;
});
</script>
