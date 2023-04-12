<?php $html = '
<html>
  <head>
    <title>'.$titulo.'</title>
    <style>
      @page { margin: 45px 45px 45px; } /* top left&right botoom*/
      #footer { position: fixed; left: 0px; bottom: -145px; right: 0px; height: 145px; background-color: white; }
      #cuadroGeneral { position: fixed; left: -4px; top: 0px; right: -4px; height: 952px; background-color: transparent; }

      body { font-family: "Helvetica"; }
      .fontSize4px{ font-size: 4px; }
      .fontSize8px{ font-size: 8px; }
      .fontSize11px{ font-size: 11px; }
      .fontSize12px{ font-size: 12px; }
      .fontSize13px{ font-size: 13px; }
      .fontSize14px{ font-size: 14px; }
      .fontSize15px{ font-size: 15px; }
      .fontSize16px{ font-size: 16px; }
      .textCenter{ text-align:center; }
      .textRight{ text-align: right; }
      .subrrayar{ text-decoration: underline; }
      .bold{ font-weight: 600; }
      .borde4{ border: 1px solid #444; }
      .borde_left_right{ border: 1px 1px 2px 1px solid #000; }
      .border-top{ border-top: 1px solid #000; }
      .border-bottom{ border-bottom: 1px solid #000; }
      .pl-5{ padding-left: 5px; }
      .pr-5{ padding-right: 5px; }
      .mt-20{ margin-top: 20px; }
      .mt-10{ margin-top: 10px; }
    </style>
  </head>
  <body>
    <div>
      <table border="0" cellspacing="0" width="100%">
        <tr>
          <td class="fontSize13px pl-5" width="55%">
            <span>'.$this->empresa_nombre.'</span><br />
            <span>'.$this->empresa_direccion.'</span><br /><br />
          </td>
          <td class="textRight pr-5" width="45%">
            <span class="fontSize14px bold">'.$titulo.'</span><br>
            <span class="fontSize13px bold">CORRESPONDIENTE A: '.$mes_anio.'</span><br>
            <span class="fontSize12px">'.date('d/m/Y H:i:s').'</span>
          </td>
        </tr>
      </table>

      <table border="0" cellspacing="0" width="100%" class="fontSize11px mt-10">
        <thead class="border-top border-bottom">
          <tr>
            <th width="10%"></th>';
            for($i=1; $i<=$d; $i++) {
              $html .= '<th class="textRight">'.date("w", strtotime($a.'-'.$m.'-'.$i)).'</th>';
            }
            $html.='
            <th></th>
          </tr>
          <tr>
            <th>NOMBRE</th>';
            for($i=1; $i<=$d; $i++) {
              $html .= '<th class="textRight">'.str_pad($i, 2, '0', STR_PAD_LEFT).'</th>';
            }
          $html.='
            <th class="textRight">DIAS</th>
          </tr>
        </thead>
        <tbody>';
          $this->atencion_cajero_empleado = [];
          $this->usuario                  = '';
          $this->fecha                    = '';
          foreach($empleados_cajeros as $ec) {
            $DIAS = 0;
            $html .= '
            <tr>
              <td>'.$ec->nombre_usuario.'</td>';
              $this->usuario = $ec->usuario;
              for($i=1; $i<=$d; $i++) {
                $this->fecha = $a.'-'.$m.'-'.$i;
                $this->atencion_cajero_empleado = array_filter($data_atencion_cajeros, function($a) {
                  return $a->usuario == $this->usuario && explode(' ', $a->fecha)[0] == $this->fecha;
                });
                $estado_dia = '';
                if($this->atencion_cajero_empleado) {
                  $estado_dia = '&times;';
                  $DIAS++;
                }
                $html .= '<td class="textRight">'.$estado_dia.'</td>';
              }
            $html .= '
              <td class="textRight">'.$DIAS.'</td>
            </tr>';
          }
          if(count($empleados_cajeros) == 0):
            $cols = $d + 2;
            $html.='
              <tr class="textCenter">
                <td colspan="'.$cols.'">Sin registros</td>
              </tr>';
          endif;
          $html.='
        </tbody>
        <tfoot class="border-top border-bottom">
          <!--<tr>
            <td colspan="3" class="bold">TOTAL</td>
            <td colspan="1" class="textRight">'.number_format(0, 2, '.', '').'</td>
          </tr>-->
        </tfoot>
      </table>
    </div>
  </body>
</html>';
?>