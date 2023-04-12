<?php $html = '
<html>
   <head>
      <title>Balance Sumas y Saldos</title>
      <style>
         @page {
            margin: 30px 1cm 45px 1cm;
         }
         body {
            font-size: 80%;
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
            BALANCE DE COMPROBACION DE SUMAS Y SALDOS<br>
            DEL '; $html.=$fechaInicial.' AL '.$fechaFinal; $html.='<br>';
            if($tpm == 1) # BOLIVIANOS
               $html.='(Expresado en Bolivianos)';
            elseif($tpm == 2) # DOLARES
               $html.='(Expresado en Dólares)';
            else # BOLIVIANOS Y DOLARES
               $html.='(Expresado en Bolivianos y Dólares)';
            $html.='
         </strong>
      </div>
      <table border="0" cellspacing="0" width="100%" style="margin-top: 10px;">
         <thead>
            <tr>';
               if(($tpm == 1)||($tpm == 2)){ # BOLIVIANOS O DOLARES
                  $html.='<th rowspan="2" class="textCenter borde4 textSize12">C&Oacute;DIGO</th>';
                  $html.='<th rowspan="2" class="textCenter borde4 textSize12" width="40%">NOMBRE CUENTA</th>';
                  $html.='<th colspan="2" class="textCenter borde4 textSize12">SUMAS</th>';
                  $html.='<th colspan="2" class="textCenter borde4 textSize12">SALDOS</th>';
               }else{ # BOLIVIANOS Y DOLARES
                  $html.='<th rowspan="3" class="textCenter borde4 textSize12">C&Oacute;DIGO</th>';
                  $html.='<th rowspan="3" class="textCenter borde4 textSize12" width="40%">NOMBRE CUENTA</th>';
                  $html.='<th colspan="4" class="textCenter borde4 textSize12">SALDOS</th>';
               }
               $html.='
            </tr>
            <tr>';
            if(($tpm == 1)||($tpm == 2)){ # BOLIVIANOS O DOLARES
               $html.='<th class="textCenter borde4 textSize12">CARGOS</th>';
               $html.='<th class="textCenter borde4 textSize12">ABONOS</th>';
               $html.='<th class="textCenter borde4 textSize12">DEUDOR</th>';
               $html.='<th class="textCenter borde4 textSize12">ACREEDOR</th>';
            }else{ # BOLIVIANOS Y DOLARES
               $html.='<th colspan="2" class="textCenter borde4 textSize12">BOLIVIANOS</th>';
               $html.='<th colspan="2" class="textCenter borde4 textSize12">D&Oacute;LARES</th>';
            }
            $html.='
            </tr>';
            if(($tpm != 1)&&($tpm != 2)){ # BOLIVIANOS y DOLARES
               $html.='<tr><th class="textCenter borde4 textSize12">DEUDOR</th>';
               $html.='<th class="textCenter borde4 textSize12">ACREEDOR</th>';
               $html.='<th class="textCenter borde4 textSize12">DEUDOR</th>';
               $html.='<th class="textCenter borde4 textSize12">ACREEDOR</th></tr>';
            }
            $html.='
         </thead>
         <tbody>';
            $a1=0; $a2=0; $a3=0; $a4=0;
            foreach($dataBalanceSumasSaldos as $d):
               $html.='
               <tr>
                  <td class="textCenter bordeLeftRight textSize12">'; $html.= $d->cuenta_codigo;    $html.='</td>
                  <td class="bordeLeftRight textSize12">'; $html.= '&nbsp;'.$d->cuenta_nombre;    $html.='</td>';
                  if($tpm == 1){ #BOLIVIANOS
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->debeBs > 0)       $html.= number_format($d->debeBs, 2);     $a1+=$d->debeBs;     $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->haberBs > 0)      $html.= number_format($d->haberBs, 2);    $a2+=$d->haberBs;    $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->deudorBs > 0)     $html.= number_format($d->deudorBs, 2);   $a3+=$d->deudorBs;   $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->acreedorBs > 0)   $html.= number_format($d->acreedorBs, 2); $a4+=$d->acreedorBs; $html.='</td>';
                  }else if($tpm == 2){ # DOLARES
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->debeUS > 0)       $html.= number_format($d->debeUS, 2);     $a1+=$d->debeUS;     $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->haberUS > 0)      $html.= number_format($d->haberUS, 2);    $a2+=$d->haberUS;    $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->deudorUS > 0)     $html.= number_format($d->deudorUS, 2);   $a3+=$d->deudorUS;   $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->acreedorUS > 0)   $html.= number_format($d->acreedorUS, 2); $a4+=$d->acreedorUS; $html.='</td>';
                  }else{ # BOLIVIANOS Y DOLARES
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->deudorBs > 0)     $html.= number_format($d->deudorBs, 2);   $a1+=$d->deudorBs;   $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->acreedorBs > 0)   $html.= number_format($d->acreedorBs, 2); $a2+=$d->acreedorBs; $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->deudorUS > 0)     $html.= number_format($d->deudorUS, 2);   $a3+=$d->deudorUS;   $html.='</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->acreedorUS > 0)   $html.= number_format($d->acreedorUS, 2); $a4+=$d->acreedorUS; $html.='</td>';
                  }
                  $html.='
               </tr>';
            endforeach;
            $html.='
            <tr>
               <td class="textRight borde4 textSize12" colspan="2">TOTALES: &nbsp;&nbsp;&nbsp;&nbsp;</td>
               <td class="textRight borde4 textSize12">'; $html.= number_format($a1, 2); $html.='</td>
               <td class="textRight borde4 textSize12">'; $html.= number_format($a2, 2); $html.='</td>
               <td class="textRight borde4 textSize12">'; $html.= number_format($a3, 2); $html.='</td>
               <td class="textRight borde4 textSize12">'; $html.= number_format($a4, 2); $html.='</td>
            </tr>
         </tbody>
      </table>
   </body>
</html>';
?>