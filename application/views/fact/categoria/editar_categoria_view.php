<div class="header">
  <span class="titulo_pagina">Administración - Categorías - Editar Categoría</span>
</div>
<p></p>

<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url().$this->router->fetch_class();?>" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    
    <div class="l-box pure-u-1 pure-u-md-1-1 pure-u-lg-1-1">
      <form method="post" class="pure-form pure-form-stacked" id="form_actualizar" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="nombre_categoria">Categoría:</label>
                <input id="nombre_categoria" name="nombre_categoria" type="text" placeholder="Ej. Sodas" value="<?php echo $categoria['nombre_categoria']?>" required>
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="">Estado:</label>
                <?php
                  $estado['1'] = 'Habilitado';
                  $estado['0'] = 'Deshabilitado';
                  $estado_actual = $categoria['estado_categoria'];
                  echo form_dropdown('estado_categoria',$estado,$estado_actual);
                ?>
              </div>            
            </div>
          </div>
          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-controls">
                <label for="nombre_categoria">Crear nuevo:</label>
                <button type="submit" class="pure-button button-success">Guardar</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-controls">
                <label for="nombre_categoria">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div>
          </div>

        </fieldset>
      </form>
    </div>
<script>
$('#form_actualizar').submit(function(){
  if($(this).parsley().isValid())
    {
      var url = BASE_URL+"categoria/actualizar_categoria/<?php echo $categoria['id_categoria']?>";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_actualizar').serialize(),
        success: function(data)
        {
          location.href=BASE_URL+"categoria";
        }
      });
    }//fin if
  return false;
});
</script>
