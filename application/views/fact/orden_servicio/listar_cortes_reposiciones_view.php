<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>

<div class="header">
  <span class="titulo_pagina">Lista cortes y reposiciones</span>
</div>
<p></p>
<div class="content">
  <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/nuevo_corte/<?php echo $idabonado;?>/<?php echo $idservicio;?>" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Nuevo corte</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:history.back();" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <hr>

    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3">
        <h4><span style="color:#000">CLIENTE: </span><?php echo $cliente['ci']?></h4>
        <h4><span style="color:#000">NOMBRE: </span><?php echo $cliente['razon_social']?></h4>
      </div>
    </div>
    <hr>

    <table style="margin-top: 0em">
      <caption>CORTES DE SERVICIO</caption>
      <thead>
        <tr>
          <th>#</th>
          <th>Nro. Corte</th>
          <th>Fecha solicitud</th>
          <th>Cierre</th>
          <th>Servicio</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        foreach ($cortes as $key => $value){
          
          $servicio = $this->servicios_model->get_servicio($value['idservicio']);
          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['numero']).'</td>
              <td>'.($value['fecha']).'</td>
              <td>'.($value['fecha_final']).'</td>
              
              <td>'.$servicio['descripcion'].'</td>
              <td>
                <a class="button-small pure-button pure-button-primary" href="'.base_url().'orden_servicio/imprimir_corte/'.$value['idcorte'].'" target="_blank">Imp. solicitud</a> ';
                $reposicion = $this->reposiciones_model->contar_idcorte($value['idcorte']);
                //var_dump($reposicion);
                if($value['estado']=='E'){
                  if(is_null($reposicion))
                    echo '<a class="button-small pure-button button-warning" href="'.base_url().'orden_servicio/reponer_corte/'.$value['idcorte'].'">Reponer</a> ';
                  else
                    echo '<a class="button-small pure-button pure-button-primary" href="'.base_url().'orden_servicio/imprimir_form_rep/'.$value['idcorte'].'" target="_blank">Imp. form. rep.</a> ';
                }
          echo '</td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>    

  </div>

<script>
function eliminar(id){
  if(confirm("¿Esta seguro de eliminar?"))
    location.href="<?php echo base_url();?>abonado/eliminar/"+id;
}

$('#form_buscar').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#buscar").attr("disabled", true);
      var $contenidoAjax = $('#div_ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      var url = BASE_URL+"abonado/buscar_cliente/";
      
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_buscar').serialize(),
        success: function(data){
          //if(data=="ok")
            $('#div_ajax').html(data)//location.href=BASE_URL+"punto_venta/";
          $("#buscar").removeAttr("disabled");
          //else $('#ajax').html(data);
        }
      });
    }//fin if
  return false;
});
</script>