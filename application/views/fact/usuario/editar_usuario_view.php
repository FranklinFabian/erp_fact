<div class="header">
  <span class="titulo_pagina">Administración - Usuarios - Editar Usuario</span>
</div>
<p></p>

<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="l-box pure-u-1 pure-u-md-1-1 pure-u-lg-1-1">
      <form method="post" class="pure-form pure-form-stacked" id="form_actualizar" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nombre">Nombres:</label>
                <input id="nombre" name="nombre" type="text" placeholder="Ej. Juan Manuel" value="<?php echo $usuario['nombre'];?>" required>
              </div>            
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="apellido">Apellidos:</label>
                <input id="apellido" name="apellido" type="text" placeholder="Ej. Perez Lopez" value="<?php echo $usuario['apellido'];?>" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="usuario">Nombre de Usuario:</label>
                <input id="usuario" name="usuario" type="text" placeholder="Ej. j_perez_lopez" value="<?php echo $usuario['usuario'];?>" required>
              </div>            
            </div>
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="password">Contraseña:</label>
                <button type="button" class="pure-button button-warning" onclick="borrar_password(<?php echo $usuario['id_empleado'];?>)">Borrar Contraseña</button>
              </div>            
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="password2">Repita Contraseña:</label>
                <input id="password2" name="password2" type="password" data-parsley-equalto="#password" readonly>
              </div>            
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="usuario">Nivel de Usuario:</label>
                <?php
                  $nivel_actual = $usuario['nivel'];
                  $data_niveles = $this->config->item('niveles');
                  $js_niveles='id="nivel" required="required"';
                  echo form_dropdown('nivel',$data_niveles,$nivel_actual,$js_niveles);
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

                  if(is_null($usuario['id_punto_venta'])){
                    $js_pv='id="id_punto_venta" disabled';
                    echo form_dropdown('id_punto_venta', $data_pv,'',$js_pv);
                  }else{
                    $js_pv='id="id_punto_venta"';
                    $id_pv_actual = $usuario['id_punto_venta'];
                    echo form_dropdown('id_punto_venta', $data_pv, $id_pv_actual, $js_pv);
                  }
                }//fin else principal

                ?>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nombre">Estado Usuario:</label>

                  <?php
                    $data_estado['1'] = 'Habilitado';
                    $data_estado['0'] = 'Deshabilitado';
                    $estado_actual = $usuario['estado'];
                    echo form_dropdown('estado', $data_estado, $estado_actual)
                  ?>

              </div>            
            </div>            
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Crear nuevo:</label>
                <button type="submit" class="pure-button button-success">Actualizar</button>
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
  </div>
<script>
function borrar_password(id_empleado){
  if(confirm("¿Esta seguro de resetear la contraseña?"))
    location.href=BASE_URL+"usuario/borrar_password/"+id_empleado;
}
$("#nivel").change(function(){
    if(($(this).val()==1) || ($(this).val()==3)){// si es 1 == usuario o 3 comisionista
      $("#id_punto_venta").removeAttr("disabled");
      $("#id_punto_venta").attr("required","required");
    }else{
      $("#id_punto_venta").removeAttr("required");
      $("#id_punto_venta").val(0);
      $("#id_punto_venta").attr("disabled",true);
    }
  });

$('#form_actualizar').submit(function(){
  if($(this).parsley().isValid())
    {
      var url = BASE_URL+"usuario/actualizar_usuario/<?php echo $usuario['id_empleado']?>";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_actualizar').serialize(),
        success: function(data)
        {
          location.href=BASE_URL+"usuario";
        }
      });
    }//fin if
  return false;
});
</script>
