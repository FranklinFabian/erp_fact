<?php $html = '
<html>
   <head>
      <title>Estado de Resultados</title>
      <style>
         @page {
            margin: 30px 1cm 45px 1cm;
         }
         body {
            font-size:80%;
            font-family: calibri;
         }
         .textCenter{
            text-align:center;
         }
         .textRight{
            text-align: right;
         }
         .textSize12{
            font-size:12px;
         }
         .textBold{
            font-size:20px;
         }
         .borde4{
            padding: 3px;
            border: 1px solid black;
         }
         .bordeLeftRight{
            padding: 2px;
            border-top: 0px solid black;
            border-right: 1px solid black;
            border-bottom: 0px solid black;
            border-left: 1px solid black;
         }
         table td, table th { /* datos de la tabla*/
            color: #000;
            background-color: #FFF;
         }
      </style>
   </head>
   <body>
      <div class="textCenter">
         <strong>
            '.utf8_encode($this->EMPRESA_GESTION['nombre']).'<br>
            ESTADO DE RESULTADOS<br>
            DEL '; $html.=$fechaInicial.' AL '.$fechaFinal; $html.='<br>';
            if($tpm == 1) # BOLIVIANOS
               $html.='(Expresado en Bolivianos)';
            elseif($tpm == 2) # DOLARES
               $html.='(Expresado en D&oacute;lares)';
            else # BOLIVIANOS Y DOLARES
               $html.='(Expresado en Bolivianos y D&oacute;lares)';
            $html.='
         </strong>
      </div>
      <p><strong>INGRESO</strong></p>
      <table border="0" cellspacing="0" width="100%" style="margin-top: 10px;">
         <thead>
            <tr>';
               $html.='<th class="textCenter borde4 textSize12">C&Oacute;DIGO</th>';
               $html.='<th class="textCenter borde4 textSize12" width="60%">NOMBRE CUENTA</th>';
               if($tpm == 1) # BOLIVIANOS
                  $html.='<th class="textCenter borde4 textSize12">BOLIVIANOS</th>';
               else if($tpm == 2) # DOLARES
                  $html.='<th class="textCenter borde4 textSize12">D&Oacute;LARES</th>';
               else{ # BOLIVIANOS Y DOLARES
                  $html.='<th class="textCenter borde4 textSize12">BOLIVIANOS</th>';
                  $html.='<th class="textCenter borde4 textSize12">D&Oacute;LARES</th>';
               }
               $html.='
            </tr>
         </thead>
         <tbody>';
            foreach($dataEstadoResultados['data_ingresos'] as $d):
               $html.='
               <tr>
                  <td class="bordeLeftRight textSize12">'; $html.= '&nbsp;&nbsp;'.$d->cuenta_codigo;    $html.='</td>
                  <td class="bordeLeftRight textSize12">';
                     if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.= '&nbsp;'.str_repeat('&nbsp;', $d->cuenta_tipo_sangria).$d->cuenta_nombre;
                     if($d->cuenta_tipo_sangria <= 8) $html.='</strong>';
                  $html.='</td>';
                  $monto_balance_general_bs = $d->acreedorBs - $d->deudorBs;
                  $monto_balance_general_us = $d->acreedorUS - $d->deudorUS;
                  if($tpm == 1){ #BOLIVIANOS
                     $html.='<td class="bordeLeftRight textRight textSize12">';  if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.= number_format($monto_balance_general_bs, 2);        if($d->cuenta_tipo_sangria <= 8) $html.='</strong>';
                     $html.='</td>';
                  }else if($tpm == 2){ # DOLARES
                     $html.='<td class="bordeLeftRight textRight textSize12">';  if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.= number_format($monto_balance_general_us, 2);        if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.='</td>';
                  }else{ # BOLIVIANOS Y DOLARES
                     $html.='<td class="bordeLeftRight textRight textSize12">';  if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.= number_format($monto_balance_general_bs, 2);        if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">';  if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.= number_format($monto_balance_general_us, 2);        if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.='</td>';
                  }
                  $html.='
               </tr>';
            endforeach;
            $html.='
            <tr>
               <td class="textRight borde4 textSize12" colspan="2">
                  TOTAL CUENTAS DE INGRESO: &nbsp;&nbsp;&nbsp;&nbsp;<br>
                  <strong>RESULTADO DEL EJERCICIO: &nbsp;&nbsp;&nbsp;&nbsp;</strong>
               </td>';
               if($tpm == 1){ # BOLIVIANOS
                  $html.='<td class="textRight borde4 textSize12">'.
                     number_format($dataEstadoResultados['total_ingresos_bs'], 2).'<br>'.
                     '<strong>'.number_format($dataEstadoResultados['total_ingresos_bs'] - $dataEstadoResultados['total_egresos_bs'], 2).'</strong>';
                  $html.='</td>';
               }else if($tpm == 2){ # DOLARES
                  $html.='<td class="textRight borde4 textSize12">'.
                     number_format($dataEstadoResultados['total_ingresos_us'], 2).'<br>'.
                     '<strong>'.number_format($dataEstadoResultados['total_ingresos_us'] - $dataEstadoResultados['total_egresos_us'], 2).'</strong>';
                  $html.='</td>';
               }else{ # BOLIVIANOS Y DOLARES
                  $html.='<td class="textRight borde4 textSize12">'.
                     number_format($dataEstadoResultados['total_ingresos_bs'], 2).'<br>'.
                     '<strong>'.number_format($dataEstadoResultados['total_ingresos_bs'] - $dataEstadoResultados['total_egresos_bs'], 2).'</strong>';
                  $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'.
                     number_format($dataEstadoResultados['total_ingresos_us'], 2).'<br>'.
                     '<strong>'.number_format($dataEstadoResultados['total_ingresos_us'] - $dataEstadoResultados['total_egresos_us'], 2).'</strong>';
                  $html.='</td>';
               }
               $html.='
            </tr>
         </tbody>
      </table>
      <div style="page-break-after:always;"></div>
      <div class="textCenter">
         <strong>
            '.utf8_encode($this->EMPRESA_GESTION['nombre']).'<br>
            ESTADO DE RESULTADOS<br>
            DEL '; $html.=$fechaInicial.' AL '.$fechaFinal; $html.='<br>';
            if($tpm == 1) # BOLIVIANOS
               $html.='(Expresado en Bolivianos)';
            elseif($tpm == 2) # DOLARES
               $html.='(Expresado en D&oacute;lares)';
            else # BOLIVIANOS Y DOLARES
               $html.='(Expresado en Bolivianos y D&oacute;lares)';
            $html.='
         </strong>
      </div>
      <p><strong>EGRESO</strong></p>
      <table border="0" cellspacing="0" width="100%" style="margin-top: 10px;">
         <thead>
            <tr>';
               $html.='<th class="textCenter borde4 textSize12">C&Oacute;DIGO</th>';
               $html.='<th class="textCenter borde4 textSize12" width="60%">NOMBRE CUENTA</th>';
               if($tpm == 1) # BOLIVIANOS
                  $html.='<th class="textCenter borde4 textSize12">BOLIVIANOS</th>';
               else if($tpm == 2) # DOLARES
                  $html.='<th class="textCenter borde4 textSize12">D&Oacute;LARES</th>';
               else{ # BOLIVIANOS Y DOLARES
                  $html.='<th class="textCenter borde4 textSize12">BOLIVIANOS</th>';
                  $html.='<th class="textCenter borde4 textSize12">D&Oacute;LARES</th>';
               }
               $html.='
            </tr>
         </thead>
         <tbody>';
            foreach($dataEstadoResultados['data_egresos'] as $d):
               $html.='
               <tr>
                  <td class="bordeLeftRight textSize12">'; $html.= '&nbsp;&nbsp;'.$d->cuenta_codigo;    $html.='</td>
                  <td class="bordeLeftRight textSize12">';
                     if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.= '&nbsp;'.str_repeat('&nbsp;', $d->cuenta_tipo_sangria).$d->cuenta_nombre;
                     if($d->cuenta_tipo_sangria <= 8) $html.='</strong>';
                  $html.='</td>';
                  $monto_balance_general_bs = $d->deudorBs - $d->acreedorBs;
                  $monto_balance_general_us = $d->deudorUS - $d->acreedorUS;
                  if($tpm == 1){ #BOLIVIANOS
                     $html.='<td class="bordeLeftRight textRight textSize12">';  if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.= number_format($monto_balance_general_bs, 2);        if($d->cuenta_tipo_sangria <= 8) $html.='</strong>';
                     $html.='</td>';
                  }else if($tpm == 2){ # DOLARES
                     $html.='<td class="bordeLeftRight textRight textSize12">';  if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.= number_format($monto_balance_general_us, 2);        if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.='</td>';
                  }else{ # BOLIVIANOS Y DOLARES
                     $html.='<td class="bordeLeftRight textRight textSize12">';  if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.= number_format($monto_balance_general_bs, 2);        if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">';  if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.= number_format($monto_balance_general_us, 2);        if($d->cuenta_tipo_sangria <= 8) $html.='<strong>';
                     $html.='</td>';
                  }
                  $html.='
               </tr>';
            endforeach;
            $html.='
            <tr>
               <td class="textRight borde4 textSize12" colspan="2">
                  TOTAL CUENTAS DE EGRESO: &nbsp;&nbsp;&nbsp;&nbsp;<br>
                  <strong>RESULTADO DEL EJERCICIO: &nbsp;&nbsp;&nbsp;&nbsp;</strong>
               </td>';
               if($tpm == 1){ # BOLIVIANOS
                  $html.='<td class="textRight borde4 textSize12">'.
                     number_format($dataEstadoResultados['total_egresos_bs'], 2).'<br>'.
                     '<strong>'.number_format($dataEstadoResultados['total_ingresos_bs'] - $dataEstadoResultados['total_egresos_bs'], 2).'</strong>';
                  $html.='</td>';
               }else if($tpm == 2){ # DOLARES
                  $html.='<td class="textRight borde4 textSize12">'.
                     number_format($dataEstadoResultados['total_egresos_us'], 2).'<br>'.
                     '<strong>'.number_format($dataEstadoResultados['total_ingresos_us'] - $dataEstadoResultados['total_egresos_us'], 2).'</strong>';
                  $html.='</td>';
               }else{ # BOLIVIANOS Y DOLARES
                  $html.='<td class="textRight borde4 textSize12">'.
                     number_format($dataEstadoResultados['total_egresos_bs'], 2).'<br>'.
                     '<strong>'.number_format($dataEstadoResultados['total_ingresos_bs'] - $dataEstadoResultados['total_egresos_bs'], 2).'</strong>';
                  $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'.
                     number_format($dataEstadoResultados['total_egresos_us'], 2).'<br>'.
                     '<strong>'.number_format($dataEstadoResultados['total_ingresos_us'] - $dataEstadoResultados['total_egresos_us'], 2).'</strong>';
                  $html.='</td>';
               }
               $html.='
            </tr>
         </tbody>
      </table>
   </body>
</html>';
?>