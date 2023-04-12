<!-- Aqui cargamos la vista lectura/cargar_abonado_view -->
<div id="ajax_datos_abonado"></div>
<!-- FIN Aqui cargamos la vista lectura/cargar_abonado_view -->
<div class="table-responsive">
                  <table id="tabla_empleados" width=60%>
                    <tr>
                    <td ><div id="ajax_formulario">ajax form</div></td>
                    <td ><div id="ajax_datos_historico"></div></td>
                    </tr>
                    </table>
  </div>
 

<form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
  <fieldset>
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-8">
        <div class="pure-control-group">
          <label for="">Anterior:</label>
          <button id="btn_anterior" type="button">Anterior</button>

          <label for="idabonado">Abonado:</label>
          <?php
            $i=1;
            foreach ($abonados as $key => $value){              
              $data[$i++] = $value['idabonado'];
            }
            $js='id="idabonado" style=""';
            echo form_dropdown('idabonado',$data,'', $js);
          ?>
<label for="">Siguiente:</label>
          <button id="btn_siguiente" type="button">Siguiente</button>

        </div>            
      </div>

      
    </div>
  </fieldset>
</form>
</div>
<script>
  
  var total_opciones = $('#idabonado > option').length;
  var val_act;
  var idabonado_select;
  //carga el primer elemento
  cargar_datos_abonado($("#idabonado option:selected").text());
  cargar_datos_historico($("#idabonado option:selected").text());
  cargar_formulario($("#idabonado option:selected").text());
  
  //Carga el abonado pasado como parametro
  function cargar_datos_abonado(idabonado){
      var $contenidoAjax = $('#ajax_datos_abonado').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      $.get( BASE_URL+"fact/lectura/cargar_abonado/"+idabonado, function( data ) {
          $("#ajax_datos_abonado" ).html( data );
      });
  }

  //Carga el historico del abonado pasado como parametro
  function cargar_datos_historico(idabonado){
      var $contenidoAjax = $('#ajax_datos_historico').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      $.get( BASE_URL+"fact/lectura/cargar_historico/"+idabonado, function( data ) {
        $("#ajax_datos_historico" ).html( data );
      });
  }

  //Carga el formulario del abonado pasado como parametro
  function cargar_formulario(idabonado){
      var $contenidoAjax = $('#ajax_formulario').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      $.get( BASE_URL+"fact/lectura/cargar_formulario/"+idabonado, function( data ) {
          $("#ajax_formulario" ).html( data );
      });
  }

  $("#btn_anterior").click(function (){
    val_act = $("#idabonado").val();
    if(val_act>1){
      $("#idabonado").val(parseInt(val_act)-1);
      idabonado_select = $("#idabonado option:selected").text();
      cargar_datos_abonado(idabonado_select);
      cargar_datos_historico(idabonado_select);
      cargar_formulario(idabonado_select);
    }
  });
  $("#btn_siguiente").click(function (){
    val_act = $("#idabonado").val();
    if(val_act < total_opciones){
      $("#idabonado").val(parseInt(val_act)+1);
      idabonado_select = $("#idabonado option:selected").text();
      cargar_datos_abonado(idabonado_select);
      cargar_datos_historico(idabonado_select);
      cargar_formulario(idabonado_select);
    }
  });

  //Cuando se cambie por mouse
  $("#idabonado").change(function(){
    cargar_datos_abonado($("#idabonado option:selected").text());
    cargar_datos_historico($("#idabonado option:selected").text());
    cargar_formulario($("#idabonado option:selected").text());
  });
</script>
