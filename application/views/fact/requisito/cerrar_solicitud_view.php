<div class="header">
  <span class="titulo_pagina">Requisito - Cerrar requisito</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url().$this->router->fetch_class().'/lista';?>" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <hr>
<strong>DATOS CLIENTE:</strong>
    <div class="pure-g" style="background-color: #fff; border-radius:8px; padding: 1em;">
      <div class="pure-u-1 pure-u-md-1-3"><strong>Razón social: </strong><?php echo $cliente['razon_social']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>NIT: </strong><?php echo $cliente['nit']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Dirección: </strong><?php echo $cliente['direccion']?></div>
    </div>
<br>
<strong>DATOS REQUISITO:</strong>
    <div class="pure-g" style="background-color: #ffe8bc; border-radius:8px; padding: 1em;">
      <div class="pure-u-1 pure-u-md-1-3"><strong>Servicio: </strong><?php echo $requisito['idservicio']==1?'ELÉCTRICO':'TV CABLE';?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Fecha solicitud: </strong><?php echo ($requisito['fecha']);?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Dirección: </strong><?php echo $direccion['zona'].' - '.$direccion['calle']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Correlativo: </strong><?php echo $requisito['correlativo'];?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Estado: </strong><?php echo $requisito['estado'];?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Referencia: </strong><?php echo $requisito['referencias']?></div>
    </div>

    <form method="post" class="pure-form pure-form-stacked" id="form_cerrar" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
          <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="fecha_atencion">Fecha atención:</label>
                <input id="fecha_atencion" name="fecha_atencion" type="date" required>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="hora_atencion">Hora atención:</label>
                <input id="hora_atencion" name="hora_atencion" type="time" required>
              </div>
            </div>
            <!--<div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="tiempo">Tiempo atención:</label>
                <input id="tiempo" name="tiempo" type="text" value="1.3" readonly required>
              </div>
            </div>-->
            <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="tiempo">Seleccione técnico:</label>
                <?php
                  foreach ($empleados as $key => $value)
                    $data_empleado[$value['idempleado']] = $value['paterno'].' '.$value['materno'].$value['nombre'];
                  echo form_dropdown('idempleado', $data_empleado);
                ?>
              </div>
            </div>
            
            <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-controls">
                <label for="">Cerrar requisito:</label>
                <button id="btn_guardar" type="submit" class="pure-button pure-button-primary">Guardar</button>
              </div>
            </div>
          </div>
        </fieldset>
    </form>    
      
    </div>
<script>
$('#form_cerrar').submit(function(){
    if($(this).parsley().isValid())
      {
        if(confirm("¿Esta seguro de cerrar este requisito?")){
            var url = BASE_URL+"requisito/ejecutar_cierre/<?php echo $requisito['idrequisito'];?>";
            $.ajax({
              type: "POST",
              url: url,
              data: $('#form_cerrar').serialize(),
              success: function(data){
                if(data=='ok')
                  location.href=BASE_URL+'requisito/lista';
                else
                  alert("Ocurrio un error inesperado");
              }
            });
        }

      }//fin if
    return false;
});

</script>
