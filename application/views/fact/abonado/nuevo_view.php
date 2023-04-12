<div class="header">
  <span class="titulo_pagina">Nuevo abono</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>abonado/listar_abonos_cliente/<?php echo $cliente['idcliente'];?>" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
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

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idservicio">Servicio:</label>
                <?php
                  $data_servicio[null]='Seleccione';
                  foreach ($servicios as $key => $value) 
                    $data_servicio[$value['idservicio']] = $value['descripcion'];
                  $js_servicio='id="idservicio" required="" onchange="cambio_servicio();"';
                  echo form_dropdown('idservicio',$data_servicio,'', $js_servicio);
                ?>
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idcategoria">Categoria:</label>
                <div id="ajax_idcategoria"><select><option value="">Seleccione</option></select></div>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idlocalidad">Localidad:</label>
                <?php
                  $data_localidad[null]='Seleccione';
                  foreach ($localidades as $key => $value) 
                    $data_localidad[$value['idlocalidad']] = $value['localidad'];
                  $js_localidad='id="idlocalidad" required="" onchange="cambio_localidad();"';
                  echo form_dropdown('idlocalidad',$data_localidad,'', $js_localidad);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="id_zona">Zona:</label>
                <div id="id_zona"><select><option value="">Seleccione</option></select></div>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="id_calle_ajax">Calle:</label>
                <div id="id_calle_ajax"><select><option value="">Seleccione</option></select></div>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="numero">Número de casa:</label>
                <input id="numero" name="numero" type="text" placeholder="Ej. Mi número" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="descripcion">Descripción (referencia):</label>
                <input id="descripcion" name="descripcion" type="text" placeholder="Ej. Lado tienda de barrio" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="idcentro">Circuito:</label>
                <div id="idcentro_ajax"><select><option value="">Seleccione</option></select></div>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="id_poste_ajax">Poste:</label>
                <div id="id_poste_ajax"><select><option value="">Seleccione</option></select></div>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idsuministro">Suministro:</label>
                <?php
                $data_suministro[null]="Selecciones";
                  foreach ($suministros as $key => $value) 
                    $data_suministro[$value['idsuministro']] = $value['suministro'];
                  $js_suministro='id="idsuministro" required=""';
                  echo form_dropdown('idsuministro',$data_suministro,'', $js_suministro);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idconsumidor">Consumidor:</label>
                <?php
                  $data_consumidor[null]="Seleccione";
                  foreach ($consumidores as $key => $value) 
                    $data_consumidor[$value['idconsumidor']] = $value['consumidor'];
                  $js_consumidor='id="idconsumidor" required=""';
                  echo form_dropdown('idconsumidor',$data_consumidor,'', $js_consumidor);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idmedicion">Mediciones:</label>
                <?php
                  $data_medicion[null] = "Seleccione";
                  foreach ($mediciones as $key => $value) 
                    $data_medicion[$value['idmedicion']] = $value['medicion'];
                  $js_medicion='id="idmedicion" required=""';
                  echo form_dropdown('idmedicion',$data_medicion,'', $js_medicion);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idliberacion">Liberación:</label>
                <?php
                $data_liberacion[null]="Seleccione";
                  foreach ($liberaciones as $key => $value) 
                    $data_liberacion[$value['idliberacion']] = $value['liberacion'];
                  $js_liberacion='id="idliberacion" required=""';
                  echo form_dropdown('idliberacion',$data_liberacion,'', $js_liberacion);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="cantidad">Cantidad de puntos:</label>
                <input type="number" id="cantidad" name="cantidad" min="0" placeholder="1" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="medidor">Nro. Medidor:</label>
                <input type="text" id="medidor" name="medidor" placeholder="1" required>
              </div>            
            </div>
            <!-- idcliente -->
            <input type="hidden" id="idcliente" name="idcliente" min="0" placeholder="1" value="<?php echo $cliente['idcliente']?>">

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
function cambio_servicio(){
  var idservicio = $("#idservicio").val();
  if(idservicio!=""){
    $("#ajax_idcategoria").html('<img src="'+BASE_URL+'public/img/loader.gif">')
    $("#ajax_idcategoria").load(BASE_URL+'abonado/cargar_categoria_servicio/'+idservicio);
  }
  else{
    $("#ajax_idcategoria").html('<select><option value="">Seleccione</option></select>');
  }
}

function cambio_localidad(){
  var idlocalidad = $("#idlocalidad").val();
  if(idlocalidad!=""){
    $("#id_zona").html('<img src="'+BASE_URL+'public/img/loader.gif">')
    $("#id_zona").load(BASE_URL+'abonado/cargar_zona_localidad/'+idlocalidad);

    $("#idcentro_ajax").html('<img src="'+BASE_URL+'public/img/loader.gif">')
    $("#idcentro_ajax").load(BASE_URL+'abonado/cargar_centro_localidad/'+idlocalidad);

  }
  else{
    $("#id_zona").html('<select><option value="">Seleccione</option></select>');
    $("#idcentro_ajax").html('<select><option value="">Seleccione</option></select>');
  }
}

function cambio_calle(){
  var idzona = $("#idzona").val();
  //alert("Cambio calle");
   if(idzona!=""){
     $("#id_calle_ajax").html('<img src="'+BASE_URL+'public/img/loader.gif">')
     $("#id_calle_ajax").load(BASE_URL+'abonado/cargar_calle_zona/'+idzona);
   }
   else{
     $("#id_calle_ajax").html('<select><option value="">Seleccione</option></select>');
   }
}

function cambio_poste(){

    var idcentro = $("#idcentro").val();
  if(idcentro!=""){
    $("#id_poste_ajax").html('<img src="'+BASE_URL+'public/img/loader.gif">')
    $("#id_poste_ajax").load(BASE_URL+'abonado/cargar_poste_centro/'+idcentro);
  }
  else{
    $("#id_poste_ajax").html('<select><option value="">Seleccione</option></select>');
  }
}


$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"abonado/crear";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          if(data=='ok')
            location.href=BASE_URL+"abonado/listar_abonos_cliente/<?php echo $cliente['idcliente']?>";
          else alert('Ocurrio un error');
        }
      });
    }//fin if
  return false;
});
</script>
