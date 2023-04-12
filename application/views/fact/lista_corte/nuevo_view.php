<div class="header">
  <span class="titulo_pagina">LISTA - NUEVO</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:history.back()" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    
    <h3 style="margin-top:1em;">SERVICIO <?php echo $idservicio==1?'<span style="color:blue">ELECTRICIDAD</span>':'<span style="color:#8AC0EB">TV CABLE</span>'?></h3>
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="codigo">Circuito:</label>
                <?php
                  foreach ($circuitos as $key => $value)
                    $data_cir[$value['idcentro']] = '['.$value['codigo'].'] '.$value['centro'];
                  echo form_dropdown('idcentro', $data_cir);
                ?>
              </div>            
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="meses">Cantidad meses:</label>
                <input id="meses" name="meses" type="number" min="1" max="9" value="<?php echo $idservicio==1?'3':'2'?>" placeholder="Ej. 3" required>
                <!--<input id="meses" name="meses" type="number" min="1" max="9" value="1" placeholder="Ej. 3" required>-->
                </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Generar:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Generar</button>
              </div>
            </div>

          </div>

        </fieldset>
      </form>

      <div id="div_ajax"></div> 

    </div>
<script>

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      //$("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"lista_corte/generar/<?php echo $idservicio;?>";
      $("#div_ajax").html('<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"><p>Cargando...</p></div>');
      
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          $("#div_ajax").html(data);
          // if(data=='ok')
          //   location.href=BASE_URL+"lista_corte/lista";
          // else alert('Ocurrio un error');
        }
      });
    }//fin if
  return false;
});
</script>
