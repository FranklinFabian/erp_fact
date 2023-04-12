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
            <th>Est.</th>
            <th>Imp. solicitud</th>
            <th>Abonado</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($requisitos as $key => $value){
            $servicio = $this->servicios_model->get_servicio($value['idservicio']);
            $cliente = $this->cliente_model->get_cliente($value['idcliente']);
            $zona = $this->zonas_model->get_zona($value['idzona']);
            $calle = $this->calles_model->get_calle($value['idcalle']);
            echo '
              <tr>
                <td>'.($value['idrequisito']).'</td>
                <td>'.($servicio['descripcion']).'</td>
                <td>'.($value['fecha']).'</td>
                <td>'.($cliente['razon_social']).'</td>
                <td>'.$zona['zona'].' - '.$calle['calle'].' #'.$value['numero']. '</td>
                <td>'.$value['estado']. '</td>
                <td> <a class="button-xsmall pure-button pure-button-primary" href="'.base_url().'requisito/imprimir_solicitud_cable/'.$value['idrequisito'].'" target="_blank">Imp. Solicitud</button></td>
                <td> <a class="button-xsmall pure-button pure-button-primary" href="'.base_url().'abonado/listar_abonos_cliente/'.$value['idcliente'].'">Ver/Crear</button></td>
              </tr>
            ';
          }
          ?>
        </tbody>
      </table>
    </div>
