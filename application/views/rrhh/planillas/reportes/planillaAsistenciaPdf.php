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
            <span>'.$this->empresa_nombre.'</span><br>
            <span>'.$this->empresa_direccion.'</span><br><br>
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
            <th width="5%"></th>
            <th width="15%"></th>';
            for($i=1; $i<=$d; $i++) {
              $html .= '<th class="textRight">'.date("w", strtotime($a.'-'.$m.'-'.$i)).'</th>';
            }
            $html.='
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <th>EMPDO</th>
            <th>NOMBRE</th>';
            for($i=1; $i<=$d; $i++) {
              $html .= '<th class="textRight">'.str_pad($i, 2, '0', STR_PAD_LEFT).'</th>';
            }
          $html.='
            <th class="textRight">DT</th>
            <th class="textRight">LC</th>
            <th class="textRight">VA</th>
            <th class="textRight">BM</th>
            <th class="textRight">CI</th>
            <th class="textRight">CS</th>
            <th class="textRight">PT</th>
          </tr>
        </thead>
        <tbody>';
          $this->asistencia_empleado  = '';
          $this->empleado             = '';
          foreach($empleados_asistencia as $ea) {
            $DT = 0; $LC = 0; $VA = 0; $BM = 0; $CO = 0; $CS = 0; $PT = 0; $AUX = 0;
            $html .= '
            <tr>
              <td>'.$ea->empleado.'</td>
              <td>'.$ea->nombre_empleado.'</td>';
              $this->empleado = $ea->empleado;
              $this->asistencia_empleado = array_filter($data_asistencia, function($a) {
                return $a->empleado == $this->empleado;
              });
              foreach($this->asistencia_empleado as $d) {
                #echo $d->empleado.' - '.$d->fecha.' - '.$d->control.'<br>';
                if($d->control == 'PT') # Presente
                  $html .= '<td class="textRight">'.$d->control.'</td>';
                else if($d->control == 'FS') # Fin de semana
                  $html .= '<td class="textRight fontSize8px">'.$d->control.'</td>';
                else { # Cualquier ausencia (para calcular DT)
                  $html .= '<td class="textRight"><strong>'.$d->control.'</strong></td>';
                  $AUX++;
                }

                if($d->control == 'L1' || $d->control == 'L2'): # Licencias
                  $LC++;
                elseif($d->control == 'VA'): # Vcacion
                  $VA++;
                elseif($d->control == 'BM'): # Baja Médica
                  $BM++;
                elseif($d->control == 'CI'): # Comisión institucional
                  $CO++;
                elseif($d->control == 'CS'): # Comisión Sindical
                  $CS++;
                elseif($d->control == 'PT'): # Presente
                  $PT++;
                endif;
              }
              $DT = 30 - $AUX; # Dias Trabajados
            $html .= '
              <td class="textRight">'.$DT.'</td>
              <td class="textRight">'.$LC.'</td>
              <td class="textRight">'.$VA.'</td>
              <td class="textRight">'.$BM.'</td>
              <td class="textRight">'.$CO.'</td>
              <td class="textRight">'.$CS.'</td>
              <td class="textRight">'.$PT.'</td>
            </tr>';
          }
          if(count($empleados_asistencia) == 0):
            $cols = $d + 9;
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