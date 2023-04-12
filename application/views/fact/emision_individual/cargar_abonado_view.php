<div class="header">
  <span class="titulo_pagina">Localidad - Nuevo</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url().$this->router->fetch_class();?>" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>

  <div class="pure-g" style="background-color: #fff; padding:.5em; border-radius:10px;">
    <div class="pure-u-1 pure-u-md-1-3"><strong>Abonado</strong> <?php echo $abonado['abonado'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Razón social</strong> <?php echo $cliente['razon_social'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Razón social</strong> <?php echo $direccion['calle'].' '.$abonado['numero'];?></div>

    <div class="pure-u-1 pure-u-md-1-3"><strong>Circuito</strong> <?php echo $centro['centro'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Poste</strong> <?php echo $poste['poste'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Medidor</strong> <?php echo $abonado['medidor'];?></div>

    <div class="pure-u-1 pure-u-md-1-3"><strong>Categoría</strong> <?php echo $categoria['categoria'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Estado</strong> <?php echo $estado['estado'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Cliente</strong> <?php echo $cliente['ci'];?></div>
  </div>

  <div style="padding: .5em;">
  <form method="post" class="pure-form pure-form-stacked" id="formulario" action="<?php echo base_url()?>emision_individual/crear/<?php echo $abonado['idabonado']?>" data-parsley-validate>
  <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
    <fieldset>
      <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Emisión:</label>
            <input type="text" value="<?php echo ($periodo_activo['emision']);?>" readonly>
          </div>  
        </div>
        <div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Factor Mul:</label>
            <?php if(is_null($lectura)):?>
              <input type="text" id="factor_mul" name="factor_mul" value="<?php echo $abonado['mulmed'];?>" readonly>
            <?php else:?>
              <input type="text" id="factor_mul" name="factor_mul" value="<?php echo $lectura['mulmed'];?>" readonly>
            <?php endif?>

          </div>  
        </div>
        <div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Potencia:</label>
            <?php if(is_null($lectura)):?>
              <input type="text" id="potencia" name="potencia" value="0" required>
            <?php else:?>
                <input type="text" id="potencia" name="potencia" value="<?php echo $lectura['potencia']?>" required>
            <?php endif?>
          </div>  
        </div>
        <div class="pure-u-1 pure-u-md-1-2">
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
        <div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Lectura actual:</label>
            <?php if(is_null($lectura)):?>
              <input type="number" value="" id="lectura_actual" name="lectura_actual"  required>
            <?php else:?>
              <input type="number" value="<?php echo $lectura['indice']?>" id="lectura_actual" name="lectura_actual"  required>
            <?php endif?>
            
          </div>  
        </div>
        <div class="pure-u-1 pure-u-md-1-2">
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
        <div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="" class="pure-radio">Emitir factura</label>
            <button type="submit" id="btn_emitir" class="pure-button button-success">Emitir factura</button>
          </div>  
        </div>
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

  $("#btn_emitir").click(function (){
    $("#btn_emitir").attr('disabled','disabled');
    $("#btn_emitir").html('Enviando...');
    $("#formulario").submit();
  });
  
});

</script>