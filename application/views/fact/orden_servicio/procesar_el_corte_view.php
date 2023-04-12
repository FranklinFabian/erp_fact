<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>

<div class="header">
  <span class="titulo_pagina">Procesar - Corte</span>
</div>
<p></p>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:history.back();" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <div class="pure-g" style="background-color: #fff; padding:.5em; border-radius:5px">
      <div class="pure-u-1 pure-u-md-1-3"><strong>Cliente: </strong> <?php echo $cliente['ci']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Nombre: </strong> <?php echo $cliente['razon_social']?></div>
      <div class="pure-u-1 pure-u-md-1-3"></div>
      
      <div class="pure-u-1 pure-u-md-1-3"><strong>Circuito: </strong> <?php echo $centro['centro']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Poste: </strong> <?php echo $poste['poste']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Medidor: </strong> <?php echo $abonado['medidor']?></div>

      <div class="pure-u-1 pure-u-md-1-3"><strong>Zona: </strong> <?php echo $direccion['zona']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Calle: </strong> <?php echo $direccion['calle']?></div>
      <div class="pure-u-1 pure-u-md-1-3"></div>

      <div class="pure-u-1 pure-u-md-1-3"><strong>Categoria: </strong> <?php echo $categoria['categoria']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Estado: </strong> <?php echo $estado['estado']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Abonado: </strong> <?php echo $abonado['idabonado']?></div>
    </div>

    <div class="pure-g" style="background-color: #fff; padding:.5em; border-radius:5px">
      <div class="pure-u-1 pure-u-md-1-3"><strong>Numero: </strong> <?php echo $corte['numero']?></div>
      
      <div class="pure-u-1 pure-u-md-1-3"><strong>Fecha sol.: </strong> <?php echo ($corte['fecha'])?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Nota: </strong> <?php echo $corte['nota']?></div>
      <div class="pure-u-1 pure-u-md-1-3"></div>
          
    </div>
    <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url();?>orden_servicio/ejecutar_corte/<?php echo $corte['idcorte'];?>" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="fecha_fin">Fecha final:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" onblur="calcular()" required>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="hora_fin">Hora final:</label>
                <input type="time" name="hora_fin" id="hora_fin" onblur="calcular()" required>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idservicio">Empleado:</label>
                <?php
                  $data_empleado[null]='Seleccione';
                  foreach ($empleados as $key => $value) 
                    $data_empleado[$value['idempleado']] = $value['paterno'].' '.$value['materno'].' '.$value['nombre'];
                  $js_empleado='id="idempleado" required=""';
                  echo form_dropdown('idempleado',$data_empleado,'' , $js_empleado);
                ?>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tiempo_tram">Tiempo tramite(min):</label>
                <input type="number" id="tiempo_tram" name="tiempo_tram" readonly required>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tiempo_tram_dias">Tiempo tramite(dias):</label>
                <input type="text" id="tiempo_tram_dias" name="tiempo_tram_dias" readonly required>
              </div>
            </div>
          <?php if($corte['idservicio']==1)
          echo '
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="lectura">Lectura medidor al corte:</label>
                <input type="number" id="lectura" name="lectura" required>
              </div>
            </div>
              ';
          ?>

          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-controls">
                <label for="">Actualizar:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Actualizar</button>
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

</div>

<script>
  function calcular(){
    let f_orden = "<?php echo substr($corte['fecha'], 0,10);?>";
    let h_orden = "<?php echo substr($corte['fecha'], 11,8);?>";

    let fecha1 = new Date(f_orden+' '+ h_orden);
    let fecha2 = new Date($("#fecha_fin").val()+' '+$("#hora_fin").val())

    let resta = fecha2.getTime() - fecha1.getTime();
    
    let minutos = Math.round(resta/60/1000);
    if(minutos > 0){
      $("#tiempo_tram").val(minutos);
      $("#tiempo_tram_dias").val((minutos/1440).toFixed(2));
    }else{
      $("#tiempo_tram").val('');
      $("#tiempo_tram_dias").val('');
    }
  }

</script>
