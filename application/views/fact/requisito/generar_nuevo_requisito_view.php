<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
    <fieldset>
      <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3">
          <div class="pure-control-group">
            <label for="cliente">Cliente:</label>
            <input type="text" style="width: 90%;" value="<?php echo $cliente['razon_social']?>" readonly>
          </div>
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
          <div class="pure-control-group">
            <label for="documento">NIT:</label>
            <input type="text" style="width: 90%;" value="<?php echo $cliente['nit']?>" readonly>
          </div>
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
          <div class="pure-control-group">
            <label for="idcliente">ID:</label>
            <input name="idcliente" type="text" style="width: 90%;" value="<?php echo $cliente['idcliente']?>" readonly>
          </div>
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
          <div class="pure-control-group">
            <label for="idzona">Zona:</label>
            <?php
              $data_zona = array();
              $data_zona[NULL]= 'Seleccione';
              foreach ($zonas as $key => $value)
                $data_zona[$value['idzona']] = $value['zona'];
              $js_zona='id="idzona" style="width: 90%;" required=""';
              echo form_dropdown('idzona', $data_zona, '', $js_zona);
            ?>
          </div>
        </div>
        
        <div class="pure-u-1 pure-u-md-1-3">
          <div class="pure-control-group">
            <label for="calle">Calle:</label>
            <div id="id_calle_ajax"><select name="calle" id="calle" style="width: 90%;"><option value="">Seleccione</option></select></div>
          </div>
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
          <div class="pure-control-group">
            <label for="numero">Número:</label>
            <input name="numero" id="numero" type="text" style="width: 90%;" placeholder="Ej. 182" required>
          </div>
        </div>
        
        <div class="pure-u-1 pure-u-md-1-3">
          <div class="pure-control-group">
            <label for="referencias">Referencia:</label>
            <input name="referencias" id="referencias" type="text" style="width: 90%;" placeholder="Ej. Lado tienda barrio garaje rojo" required>
          </div>
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
          <div class="pure-control-group">
            <label for="idservicio">Servicio:</label>
            <?php
              $data_servicio = array();
              $data_servicio[NULL]= 'Seleccione';
              foreach ($servicios as $key => $value)
                $data_servicio[$value['idservicio']] = $value['descripcion'];
              $js_servicio='id="idservicio" style="width: 90%;" required=""';
              echo form_dropdown('idservicio', $data_servicio, '', $js_servicio);
            ?>
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
    
<script>

$("#idzona").change(function() {
  var idzona = $("#idzona").val();
   if(idzona!=""){
     $("#id_calle_ajax").html('<img src="'+BASE_URL+'public/img/loader.gif">')
     $("#id_calle_ajax").load(BASE_URL+'requisito/cargar_calle_zona/'+idzona);
   }
   else{
     $("#id_calle_ajax").html('<select><option value="">Seleccione</option></select>');
   }
  
});

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      //$("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"requisito/crear_requisito";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          //console.log(data);
          if(data=='ok')
            location.href=BASE_URL+"requisito/lista";
          else alert('Ocurrio un error');
        }
      });
    }//fin if
  return false;
});
</script>
