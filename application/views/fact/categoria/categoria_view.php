<div class="header">
  <span class="titulo_pagina">Administración - Categorías - Nueva Categoría</span>
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
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="nombre_categoria">Nombre Categoría:</label>
                <input id="nombre_categoria" name="nombre_categoria" type="text" placeholder="Ej. Sodas" autofocus required>
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="descripcion_categoria">Estado:</label>
                <select name="estado_categoria" id="estado_categoria">
                  <option value="1">Habilitado</option>
                  <option value="0">Deshabilitado</option>
                </select>
              </div>
            </div>
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-controls">
                <label for="">Crear nuevo:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Guardar</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-controls">
                <label for="">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div>
          </div>

        </fieldset>
      </form>
<script>
$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"categoria/crear_categoria";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          location.href=BASE_URL+"categoria";
        }
      });
    }//fin if
  return false;
});
</script>
