<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>

<div class="header">
  <span class="titulo_pagina">Procesar - NUEVAS CONEXIONES</span>
</div>
<p></p>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>orden_servicio/lista/" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>

    <div>
      <table style="margin-top: -1em;">
        <?php
          if($idservicio==1)
            echo '<caption>SERVICIO ELECTRICO</caption>';
          else 
            echo '<caption>SERVICIO TV CABLE</caption>';
          ?>
        
        <thead>
          <tr>
            <th>Nro. Conexión</th>
            <th>Servicio</th>
            <th>Fecha Hora</th>
            <th>Razón</th>
            <th>Zona/Calle</th>
            <th>Estado</th>
            <th>Procesar</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($ordenes as $key => $value){
            $servicio = $this->servicios_model->get_servicio($value['idservicio']);
            $orden = $this->ordenes_model->get_orden($value['idorden']);

            $abonado = $this->abonados_model->get_abonado($orden['idabonado']);
            $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
            $calle = $this->calles_model->get_calle($abonado['idcalle']);
            echo '
              <tr>
                <td>'.($value['numero']).'</td>
                <td>'.($servicio['descripcion']).'</td>
                <td>'.($value['fecha']).'</td>
                <td>'.($cliente['razon_social']).'</td>
                <td>'.$calle['calle'].' #'.$abonado['numero']. '</td>
                <td>'.$value['estado']. '</td>';
                if($idservicio==1)
                  echo ' <td> <a class="button-xsmall pure-button pure-button-primary" href="'.base_url().'orden_servicio/procesar_nueva_conexion/1/'.$value['idconexion'].'">Procesar</button></td>';
                else
                  echo ' <td> <a class="button-xsmall pure-button pure-button-primary" href="'.base_url().'orden_servicio/procesar_nueva_conexion/2/'.$value['idconexion'].'">Procesar</button></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

<script>
</script>
