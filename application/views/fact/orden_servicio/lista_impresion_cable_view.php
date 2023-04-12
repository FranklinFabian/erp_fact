    <div id="tabla_ajax">
      <table style="margin-top: -1em;">
        <caption>SERVICIO CABLE</caption>
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
