<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>

<div class="header">
  <span class="titulo_pagina">Lista abonos por cliente</span>
</div>
<p></p>
<div class="content">
<div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>abonado/nuevo/<?php echo $cliente['idcliente'];?>" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Nuevo abono +</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>abonado/lista/" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <hr>
  
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3">
        <h4><span style="color:#000">CLIENTE: </span><?php echo $cliente['ci']?></h4>
        <h4><span style="color:#000">NOMBRE: </span><?php echo $cliente['razon_social']?></h4>
      </div>
    </div>
    <hr>

    <table>
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Abonado</th>
          <th>F. Registro</th>
          <th>Servicio</th>
          <th>Zona / Calle</th>
          <th>Circuito</th>
          <th>Poste</th>
          <th>Categoria</th>
          <th>Medidor</th>
          <th>Estado</th>
          <th>Contrato</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        foreach ($abonos_cliente as $key => $value){
          $servicio = $this->servicios_model->get_servicio($value['idservicio']);
          $calle = $this->calles_model->get_calle($value['idcalle']);
          $zona = $this->zonas_model->get_zona($calle['idzona']);
          $poste = $this->postes_model->get_poste($value['idposte']);
          $centro = $this->centros_model->get_centro($poste['idcentro']);
          $categoria = $this->categorias_model->get_categorias($value['idcategoria']);
          $estado = $this->estados_model->get_estado($value['idestado']);
          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['idabonado']).'</td>
              <td>'.($value['fecha_registro_abonado']).'</td>
              <td>'.($servicio['descripcion']).'</td>
              <td>'.($zona['zona']).' / '.$calle['calle'].'</td>
              <td>'.($centro['codigo']).'</td>
              <td>'.($poste['poste']).'</td>
              <td>'.($categoria['categoria']).'</td>
              <td>'.($value['medidor']).'</td>
              <td>'.($estado['estado']).'</td>
              <td><a class="button-small pure-button pure-button-primary" target="_blank" href="'.base_url().'abonado/imprimir_contrato/'.$value['idabonado'].'">Imp.</a></td>
              <td>
              <a id="btn_editar" class="button-small pure-button pure-button-primary" href="'.base_url().'orden_servicio/listar_ordenes_servicio/'.$value['idabonado'].'/'.$value['idservicio'].'">Orden</a>
              <a id="btn_editar" class="button-small pure-button pure-button-primary" href="'.base_url().'orden_servicio/listar_cortes_reposiciones/'.$value['idabonado'].'/'.$value['idservicio'].'">Cortes y reposiciones</a>
              ';
              if($this->session->userdata('nivel')=='2'){
                echo '
                  <a id="btn_editar" class="button-small pure-button button-warning" href="'.base_url().'abonado/editar/'.$value['idabonado'].'">Editar</a>
                ';
                
              }

          echo '</td></tr>';
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
