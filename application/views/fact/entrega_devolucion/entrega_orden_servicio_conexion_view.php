<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>

<div class="header">
  <span class="titulo_pagina">Entrega CONEXIONES</span>
</div>
<p></p>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>entrega_devolucion/entrega_orden_servicio_conexion/1" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Energia electrica</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>entrega_devolucion/entrega_orden_servicio_conexion/2" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">TV Cable</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>entrega_devolucion/" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
  <br>

  <form method="post" class="pure-form pure-form-stacked" id="form_lista" data-parsley-validate>
    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
    <fieldset>
    
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3">
        <div class="pure-control-group">
          <label for="razon_social">Técnico:</label>
          <?php
            $data=array();
            $data[null]='Seleccione';
            $empleados = $this->empleados_model->get_all_vigente();
            foreach ($empleados as $key => $value)
              $data[$value['idempleado']]=$value['paterno'].' '.$value['materno'].' '.$value['nombre'] ;
            $js='id="idempleado" required=""';
            echo form_dropdown('idempleado',$data,'',$js);
          ?>
        </div>            
      </div>
      <div class="pure-u-1 pure-u-md-1-3">
        <div class="pure-control-group">
          <label for="razon_social">Asignar:</label>
          <button class="pure-button button-success">Asignar</button>
        </div>            
      </div>
    </div>

    <table style="margin-top: 1em;">
      <thead>
        <?php
          if($idservicio==1)
            echo '<caption>LISTA ENERGIA ELECTRICA</caption>';
          else
            echo '<caption>LISTA TV CABLE</caption>';

        ?>
        
        <tr>
          <th></th>
          <th>Nro. Conexión</th>
          <th>Fecha</th>
          <th>Abonado</th>
          <th>Razón</th>
        </tr>
      </thead>
      <tbody>
        <?php        
        foreach ($ordenes as $key => $value){
          $orden = $this->ordenes_model->get_orden($value['idorden']);
          $abonado=$this->abonados_model->get_abonado($orden['idabonado']);
          $cliente=$this->cliente_model->get_cliente($abonado['idcliente']);
          echo '
            <tr>
              <td><input type="checkbox" id="cbox_'.$value['idconexion'].'" value="'.$value['idconexion'].'"></td>
              <td>'.($value['numero']).'</td>
              <td>'.($value['fecha']).'</td>
              <td>'.($abonado['idabonado']).'</td>
              <td>'.($cliente['razon_social']).'</td>
            </tr>
          ';
        }
        ?>
      </tbody>
    </table>


    </fieldset>
  </form>
</div>

<script>
$('#form_lista').submit(function(){
  if($(this).parsley().isValid())
    {
      var selected = '';
        $('#form_lista input[type=checkbox]').each(function(){
            if (this.checked) {
                selected += $(this).val()+',';
            }
        });

        if(selected != ''){

          if(confirm("¿Confirmar si desea asignar estos registros al técnico correspondiente?")){
            selected = selected.substring(0, selected.length - 1);          
            $.get( BASE_URL+"entrega_devolucion/asigna_orden_servicio_conexion/"+$("#idempleado").val()+"/"+selected, function( data ) {
              //console.log(data);
              location.href=BASE_URL+"entrega_devolucion/entrega_orden_servicio_conexion/<?php echo $idservicio==1?'1':2;?>";
            });            
          }

        }
        else
            alert('Debes seleccionar al menos una orden.');
    }//fin if
  return false;
});
</script>
