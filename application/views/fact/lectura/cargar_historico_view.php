

            <div class="panel-title">
              <h4><strong>HISTORICO</strong></h4>
            </div>
               
<table id="tabla_historico" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
  <thead>
    <tr>
      <th class="text-center">Emisión</th>
      <th class="text-center">Lectura</th>
      <th class="text-center">Consumo</th>
      <th class="text-center">Estimado</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $n = count($lecturas);
    $promedio = 0;
    $sumatoria = 0;

    foreach ($lecturas as $key => $value) {
      $periodo = $this->periodos_model->get_periodo($value['idperiodo']);
      $sumatoria += $value['kwh'];
      echo '
        <tr>
          <td style="vertical-align: middle;">'.($periodo['emision']).'</td>
          <td style="vertical-align: middle;">'.($value['indice']).'</td>
          <td style="vertical-align: middle;">'.($value['kwh']).'</td>
          <td style="vertical-align: middle;">'.($value['estimado']).'</td>
        </tr>
      ';
    }
    echo '
    <tr>
      <td class="text-center" style="font-weight:bold">Promedio:</td>
      <td></td>
      <td style="font-weight:bold">'.number_format(($sumatoria/$n),2,',','.').'</td>
      <td></td>
    </tr>'
    ?>
  </tbody>
</table>
