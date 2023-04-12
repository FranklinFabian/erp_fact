<div class="header">
  <span class="titulo_pagina">Nueva orden de servicio</span>
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
                <label for="medidor">Orden:</label>
                <?php
                  foreach ($gestiones as $key => $value)
                    $data[$value['idgestion']] = $value['descripcion'];
                  $js='style="width:90%" id="idgestion"';
                  echo form_dropdown('idgestion',$data,'',$js);
                ?>
              </div>
            </div>

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

            <div id="div_cantidad" class="pure-u-1 pure-u-md-1-2 ocultar">
              <div class="pure-control-group">
                <label for="cantidad">Cantidad puntos:</label>
                <input type="number" style="width: 90%;" name="cantidad" id="cantidad" placeholder="Ej. 2">
              </div>
            </div>

            <div id="div_ncategoria" class="pure-u-1 pure-u-md-1-2 ocultar">
              <div class="pure-control-group">
                <label for="ncategoria">Nueva Categoria:</label>
                <?php
                  foreach ($categorias as $key => $value)
                    $data_categoria[$value['idcategoria']] = $value['codigo'].' - '.$value['categoria'];
                  echo form_dropdown('ncategoria',$data_categoria, $abonado['idcategoria']);
                ?>
              </div>
            </div>
            <!-- idabonado -->
            <input type="hidden" id="idabonado" name="idabonado" value="<?php echo $idabonado;?>">
            <input type="hidden" id="idservicio" name="idservicio" value="<?php echo $idservicio;?>">
          </div>

          <!-- para el buscador -->
          <div id="div_ci" class="pure-g ocultar" style="background-color: #fff; padding:1em;">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="ci">CI del nuevo consumidor:</label>
                <input id="ci" name="ci" type="number" placeholder="Ej. 4043274">
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="buscar">Buscar:</label>
                <button id="btn_buscar" type="button" class="pure-button pure-button-primary button-small">Buscar</button>
              </div>
            </div>
          </div>  
          <div class="ocultar" id="div_ajax" style="background-color: #fff; padding:1em;"></div>
          <!-- fin para el buscador -->

          <div id="div_ncliente" class="pure-g ocultar">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="ncliente">Nuevo consumidor:</label>
                <input id="ncliente" name="ncliente" type="text" value="" readonly>
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
  function establecer_id_cliente(idcliente){
    $("#ncliente").val(idcliente);
    //alert("idcliente: "+idcliente);
  }

  $("#btn_buscar").click(function (){
    $("#ncliente").val('');
    $("#div_ajax").load(BASE_URL+'orden_servicio/buscar_ci/'+$("#ci").val());
  });

  $("#idgestion").change(function() {
    if(($("#idgestion").val()==11) || ($("#idgestion").val()==5)){// si es 11 o 5 ->CAMBIO DE CATEGORIA
      $("#div_ncategoria").fadeIn(); 
      //ocultando
      $("#div_ci").fadeOut(0);
      $("#div_ajax").fadeOut(0);
      $("#div_ncliente").fadeOut(0);
      $("#div_cantidad").fadeOut(0);
      $("#cantidad").removeAttr("required");

      $("#ncliente").val("");
      $("#ncliente").removeAttr("required");

    }else if(($("#idgestion").val()==13) || ($("#idgestion").val()==7)){// si es 13 o 7-> CAMBIO CLIENTE
      $("#div_ci").fadeIn();
      $("#div_ajax").fadeIn();
      $("#div_ncliente").fadeIn();
      $("#ncliente").attr("required","true");
      //ocultando
      $("#div_ncategoria").fadeOut(0)
      $("#div_cantidad").fadeOut(0);
      $("#cantidad").removeAttr("required");

    }else if(($("#idgestion").val()==6)){// si es 6 para agregar puntos en cable
      $("#div_cantidad").fadeIn();
      $("#cantidad").attr("required","true");
      //ocultando
      $("#div_ci").fadeOut(0);
      $("#div_ajax").fadeOut(0);
      $("#div_ncliente").fadeOut(0);
      $("#div_ncategoria").fadeOut(0)

    }else{
      //ocultando todo
      $("#div_ncategoria").fadeOut(0);
      $("#div_ci").fadeOut(0);
      $("#div_ajax").fadeOut(0);
      $("#div_ncliente").fadeOut(0);
      $("#ncliente").val("");
      $("#ncliente").removeAttr("required");
      $("#div_cantidad").fadeOut(0);
      $("#cantidad").removeAttr("required");

    }
  });

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"orden_servicio/crear";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          //console.log(data);
          if(data=='ok')
            location.href=BASE_URL+"orden_servicio/listar_ordenes_servicio/<?php echo $idabonado?>/<?php echo $idservicio?>";
          else alert('Ocurrio un error');
        }
      });
    }//fin if
  return false;
});
</script>
