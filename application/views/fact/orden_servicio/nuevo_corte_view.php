<div class="header">
  <span class="titulo_pagina">Nueva orden de corte</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:history.back();" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>

    <hr>
  
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3">
        <h4><span style="color:#000">CLIENTE: </span><?php echo $cliente['ci']?></h4>
        <h4><span style="color:#000">NOMBRE: </span><?php echo $cliente['razon_social'];?></h4>
      </div>
    </div>
    <hr>
    
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">

            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="nota">Nota:</label>
                <input type="text" style="width: 90%;" id="nota" name="nota" placeholder="Visitar a hrs.: 15:30" required>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="solicitante">Solicitante:</label>
                <input type="text" style="width: 90%;" id="solicitante" name="solicitante" placeholder="Ej. Hijo mayor juan perez" required>
              </div>
            </div>


            <!-- idabonado -->
            <input type="hidden" id="idabonado" name="idabonado" value="<?php echo $idabonado;?>">
            <input type="hidden" id="idservicio" name="idservicio" value="<?php echo $idservicio;?>">
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
  function establecer_id_cliente(idcliente){
    $("#ncliente").val(idcliente);
  }

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"orden_servicio/crear_corte";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          //console.log(data);
          if(data=='ok')
            location.href=BASE_URL+"orden_servicio/listar_cortes_reposiciones/<?php echo $idabonado?>/<?php echo $idservicio?>";
          else alert('Ocurrio un error');
        }
      });
    }//fin if
  return false;
});
</script>
