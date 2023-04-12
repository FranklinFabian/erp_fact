<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>

<div class="header">
  <span class="titulo_pagina">Impresión - lista</span>
</div>
<p></p>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/lista/" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <hr>
    <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
      <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
      <fieldset>
          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="codigo">Seleccione servicio:</label>
                <?php
                  $servicios = $this->servicios_model->get_all();
                  foreach ($servicios as $key => $value)
                    $data_servicios[$value['idservicio']] = $value['descripcion'];
                  $js='id="idservicio"';
                  echo form_dropdown('idservicio', $data_servicios,'',$js);
                ?>
              </div>
            </div>

            
        </div>
      </fieldset>
    </form>
    <div id="tabla_ajax">
      <table style="margin-top: -1em;">
        <caption>SERVICIO ELECTRICO</caption>
        <thead>
          <tr>
            <th>ID</th>
            <th>Servicio</th>
            <th>Fecha Hora</th>
            <th>Razón</th>
            <th>Zona/Calle</th>
            <th>Imp. solicitud</th>
            <th>Est.</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($ordenes as $key => $value){
            $servicio = $this->servicios_model->get_servicio($value['idservicio']);
            $abonado = $this->abonados_model->get_abonado($value['idabonado']);
            $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
            $calle = $this->calles_model->get_calle($abonado['idcalle']);
            echo '
              <tr>
                <td>'.($value['idorden']).'</td>
                <td>'.($servicio['descripcion']).'</td>
                <td>'.($value['fecha']).'</td>
                <td>'.($cliente['razon_social']).'</td>
                <td>'.$calle['calle'].' #'.$abonado['numero']. '</td>
                <td>'.$value['estado']. '</td>
                <td> <a class="button-xsmall pure-button pure-button-primary" href="'.base_url().'orden_servicio/imprimir_orden/'.$value['idorden'].'" target="_blank">Imprimir</button></td>
              </tr>
            ';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

<script>
$("#idservicio").change(function() {
  if($("#idservicio").val()==2){
    $("#tabla_ajax").html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
    var url = BASE_URL+"orden_servicio/lista_impresion_cable/";
    $.get(url, function (data){
      $('#tabla_ajax').html(data);
    });
  }else{
    location.href=BASE_URL+"orden_servicio/lista_impresion";
  }

});

function eliminar(id){
  if(confirm("¿Esta seguro de eliminar?"))
    location.href="<?php echo base_url();?>consumidor/eliminar/"+id;
}
</script>
