<div class="header">
  <span class="titulo_pagina">Conexión - Nuevo</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:history.back()" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            
          <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="solicitante">Solicitante:</label>
                <input id="solicitante" name="solicitante" type="text" placeholder="Ej. Juan Perez" style="width: 90%;" required>
              </div>            
            </div>
            
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="nota">Nota:</label>
                <input id="nota" name="nota" type="text" placeholder="Ej. Esto es una nota" style="width: 90%;">
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

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      //$("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"conexion/crear/<?php echo $orden['idorden'];?>";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          if(data=='ok')
            location.href=BASE_URL+"orden_servicio/listar_ordenes_servicio/<?php echo $orden['idabonado']?>/<?php echo $orden['idservicio']?>";
          else alert('Ocurrio un error');
        }
      });
    }//fin if
  return false;
});
</script>
