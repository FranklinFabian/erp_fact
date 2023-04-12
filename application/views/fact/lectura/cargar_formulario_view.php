

            <div class="panel-title">
              <h4><strong>Datos De La Lectura:</strong></h4>
            </div>   
                  
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>

<?php
    $n = count($lecturas);
    $promedio = 0;
    $sumatoria = 0;
    foreach ($lecturas as $key => $value){
      $sumatoria+=$value['kwh'];
    }
    $promedio =  ($sumatoria/$n)*1.5;
    echo '<script>
    var promedio = '.($sumatoria/$n).'
    var promedio_incrementado = '.$promedio.'
    </script>';
  ?>
<div class="panel-body">
<div style="padding: .5em;">
  <form method="post" class="pure-form pure-form-stacked" id="formulario" data-parsley-validate>
  <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
    <fieldset>
      <div class="pure-g">
      <p> <div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Emisión:</label>
            <input type="text" value="<?php echo ($periodo_activo['emision']);?>" readonly>
          </div>  
        </div>
        </p>
        <p><div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Factor Mul:</label>
            <?php if(is_null($lectura)):?>
              <input type="text" id="factor_mul" name="factor_mul" value="<?php echo $abonado['mulmed'];?>" readonly>
            <?php else:?>
              <input type="text" id="factor_mul" name="factor_mul" value="<?php echo $lectura['mulmed'];?>" readonly>
            <?php endif?>

          </div>  
        </div>
        </p>
        <p><div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Potencia:</label>
            <?php if(is_null($lectura)):?>
              <input type="text" id="potencia" name="potencia" value="0" required>
            <?php else:?>
                <input type="text" id="potencia" name="potencia" value="<?php echo $lectura['potencia']?>" required>
            <?php endif?>
          </div>  
        </div>
        </p>
        <p><div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Lectura anterior: </label>
            <?php 
              if(empty($lectura_anterior)){
                if(is_null($abonado['indiceinicial']))
                  echo '<input id="lectura_anterior" name="lectura_anterior" type="text" value="0" readonly>';
                else echo '<input id="lectura_anterior" name="lectura_anterior" type="text" value="'.$abonado['indiceinicial'].'" readonly>';
              }else{
                echo '<input id="lectura_anterior" name="lectura_anterior" type="text" value="'.$lectura_anterior['indice'].'" readonly>';
              }
              ?>
          </div>
        </div>
        </p>
        <p><div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Lectura actual:</label>
            <?php if(is_null($lectura)):?>
              <input type="number" value="" id="lectura_actual" name="lectura_actual"  required>
            <?php else:?>
              <input type="number" value="<?php echo $lectura['indice']?>" id="lectura_actual" name="lectura_actual"  required>
            <?php endif?>
            
          </div>  
        </div>
        </p>
        <p><div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Consumo kwh:</label>
            <?php if(is_null($lectura)):?>
              <input type="number" value="" id="consumo_kwh" name="consumo_kwh" readonly required>
            <?php else:?>
              <input type="number" value="<?php echo $lectura['kwh']?>" id="consumo_kwh" name="consumo_kwh" readonly required>
            <?php endif?>

            <input type="hidden" value="0" id="lec_observada" name="lec_observada"><!-- -->
          </div>  
        </div>
        </p>
        <p><div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="operacion" class="pure-radio">Opción:</label>
            <?php if(is_null($lectura)):?>
              <select name="operacion" id="operacion">
                <option value="0">Ninguno</option>
                <option value="1">Estimado</option>
                <option value="2">Sin factura</option>
              </select>
            <?php else:?>
            <?php
              $data_op['0']='Ninguno';
              $data_op['1']='Estimado';
              $data_op['2']='Sin factura';
              if($lectura['estimado']=='1')
                $opt_act='1';
              elseif($lectura['estado']=='L')
                $opt_act='2';
              else 
                $opt_act='0';
              
              $js_opt='id="operacion"';
              echo form_dropdown('operacion', $data_op, $opt_act, $js_opt);
            ?>
            <?php endif?>
          
          </div>  
        </div>
        </p>
        <p><div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="" class="pure-radio">Grabar:</label>
            <button type="submit" class="pure-button button-success">Grabar</button>
          </div>  
        </div>
            </p>
      </div>
    </fieldset>
  </form>

</div>
</div>
<script>
  
  $(document).ready(function (){
    $("#lectura_actual").focus();
    var cal;
    var lec_observada = 0;

    //calculo al salir de lectura_actual
    $("#lectura_actual").keyup(function (){
    var LAct = parseInt($("#lectura_actual").val());
    var LAnt = parseInt($("#lectura_anterior").val());
    var MulMed = parseInt($("#factor_mul").val());
    if (LAct < LAnt){
      if ((LAnt >= 1) && (LAnt <= 999)) 
        cal = (999 - LAnt) + LAct + 1;
      if ((LAnt >= 1000) && (LAnt <= 9999))
        cal = (9999 - LAnt) + LAct + 1;
      if ((LAnt >= 10000) && (LAnt <= 99999))
        cal = (99999 - LAnt) + LAct + 1;
      if ((LAnt >= 100000) && (LAnt <= 999999))
        cal = (999999 - LAnt) + LAct + 1;

    }else{
      cal = (LAct - LAnt);
    }

    if (MulMed != 0)
      $("#consumo_kwh").val((cal * MulMed));
    else
      $("#consumo_kwh").val(cal);


    
  });

  //para el select
  $("#operacion").change(function() {
    if($("#operacion").val() == 1)//estimado
      {
        var calculo = Math.round(promedio + parseInt($("#lectura_anterior").val()));
        $("#lectura_actual").val(calculo);
        var calculo2 = calculo - parseInt($("#lectura_anterior").val()); 
        $("#consumo_kwh").val(calculo2);
      }
    else if($("#operacion").val() == 2)//sin factura
      {
        $("#lectura_actual").val($("#lectura_anterior").val());
        $("#consumo_kwh").val(0);
      }
  });

  //enviando el formulario
  $('#formulario').submit(function(){
    //alert("Alerta "+lec_observada);
    if($(this).parsley().isValid()){

      //Para los alert
      if((cal >100) && ((promedio*1.5) < cal) ){
        lec_observada = 2;
        alert("El promedio se disparo "+lec_observada);
        $("#lec_observada").val(lec_observada);
      }
        
      else if((((promedio)/2) > cal) && (cal>25)){
        lec_observada = 1;
        alert("El consumo rebajo "+lec_observada);
        $("#lec_observada").val(lec_observada);
      }//Fin los alerts

        var url = BASE_URL+"fact/lectura/crear/<?php echo $abonado['idabonado']?>";
        $.ajax({
          type: "POST",
          url: url,
          data: $('#formulario').serialize() ,
          success: function(data)
          {
            //console.log(data);
            if(data=='ok'){
              val_act = $("#idabonado").val();
              if(val_act < total_opciones){
                $("#idabonado").val(parseInt(val_act)+1);
                idabonado_select = $("#idabonado option:selected").text();
                cargar_datos_abonado(idabonado_select);
                cargar_datos_historico(idabonado_select);
                cargar_formulario(idabonado_select);
              }
            }else
              alert("Hubo un error inesperado"+dato);
          }
        });
      }//fin if
      return false;
  });

  
});

</script>