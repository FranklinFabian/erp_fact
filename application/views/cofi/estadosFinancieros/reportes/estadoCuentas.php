<?php $html = '
<html>
   <head>
      <title>Estado de Cuentas</title>
      <style>
         body { font-size:80%; font-family: calibri; }
         .textCenter{ text-align:center; }
         .textRight{ text-align: right; }
         .textSize12{ font-size:12px; }
         .textBold{ font-size:20px; }
         .borde4{ padding: 3px; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; }
         .bordeLeftRight{ padding: 2px; border-top: 0px solid black; border-right: 1px solid black; border-bottom: 0px solid black; border-left: 1px solid black; }
         table { color: #FFF; background-color: #122; }
         table td { color: #000; background-color: #FFF; }
         table th { color: #000; background-color: #FFF; }
      </style>
   </head>
   <body>
      <div class="seccionTitulo">
         <br><br>
         <table border="0" cellspacing="0" width="100%">
            <tr>
               <td>
                  <p class="textCenter"><strong>
                     AUXILIAR<br>
                     ESTADO DE LA CUENTA  '; $html.=$data_cuenta->codigo.str_repeat('0',10-$cantEspaciosCuenta).' '.$data_cuenta->nombre; $html.='<br>
                     DEL '; $html.=$fechaInicial.' AL '.$fechaFinal; $html.='<br>';
                     if($tpm == 1) # BOLIVIANOS
                        $html.='(Expresado en Bolivianos)';
                     elseif($tpm == 2) # DOLARES
                        $html.='(Expresado en D&oacute;lares)';
                     else # BOLIVIANOS Y DOLARES
                        $html.='(Expresado en Bolivianos y D&oacute;lares)';
                     $html.='</strong>
                  </p>
               </td>
            </tr>
         </table>
      </div>

      <table id="tablaGeneral" border="0" cellspacing="0" width="100%" style="margin-top: 10px;">
         <thead>
            <tr>';
               $html.='<th rowspan="2" class="textCenter borde4 textSize12" width="10%">C&Oacute;DIGO</th>';
               $html.='<th rowspan="2" class="textCenter borde4 textSize12" width="60%">NOMBRE CUENTA</th>';
               if($tpm == 1) # BOLIVIANOS
                  $html.='<th colspan="4" class="textCenter borde4 textSize12">BOLIVIANOS</th>';
               else if($tpm == 2) # DOLARES
                  $html.='<th colspan="4" class="textCenter borde4 textSize12">D&Oacute;LARES</th>';
               else{ # BOLIVIANOS Y DOLARES
                  $html.='<th colspan="4" class="textCenter borde4 textSize12">BOLIVIANOS</th>';
                  $html.='<th colspan="4" class="textCenter borde4 textSize12">D&Oacute;LARES</th>';
               }
               $html.='
            </tr>
            <tr>';
               if($tpm == 1){ # BOLIVIANOS
                  $html.='<th class="textCenter borde4 textSize12">DEBE</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER</th>';
                  $html.='<th class="textCenter borde4 textSize12">DEUDOR</th>';
                  $html.='<th class="textCenter borde4 textSize12">ACREEDOR</th>';
               }else if($tpm == 2){ # DOLARES
                  $html.='<th class="textCenter borde4 textSize12">DEBE</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER</th>';
                  $html.='<th class="textCenter borde4 textSize12">DEUDOR</th>';
                  $html.='<th class="textCenter borde4 textSize12">ACREEDOR</th>';
               }else{ # BOLIVIANOS Y DOLARES
                  $html.='<th class="textCenter borde4 textSize12">DEBE</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER</th>';
                  $html.='<th class="textCenter borde4 textSize12">DEUDOR</th>';
                  $html.='<th class="textCenter borde4 textSize12">ACREEDOR</th>';

                  $html.='<th class="textCenter borde4 textSize12">DEBE</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER</th>';
                  $html.='<th class="textCenter borde4 textSize12">DEUDOR</th>';
                  $html.='<th class="textCenter borde4 textSize12">ACREEDOR</th>';
               }
               $html.='
            </tr>
         </thead>
         <tbody>';
            $a1=0; $a2=0; $a3=0; $a4=0; $a5=0; $a6=0; $a7=0; $a8=0;
            if($dataEstadoCuentas):
               foreach($dataEstadoCuentas as $d):
                  $html.='
                  <tr>
                     <td class="bordeLeftRight textSize12">'; $html.= '&nbsp;&nbsp;'.$d->cuenta_codigo;    $html.='</td>
                     <td class="bordeLeftRight textSize12">'; $html.= '&nbsp;'.$d->cuenta_nombre; $html.='</td>';
                     if($tpm == 1){ #BOLIVIANOS
                        $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->debeBs > 0)       $html.= number_format($d->debeBs, 2);     $a1+=$d->debeBs;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->haberBs > 0)      $html.= number_format($d->haberBs, 2);    $a2+=$d->haberBs;    $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($d->deudorBs, 2);   $a3+=$d->deudorBs;   $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($d->acreedorBs, 2); $a4+=$d->acreedorBs; $html.='</td>';
                     }else if($tpm == 2){ # DOLARES
                        $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->debeUS > 0)       $html.= number_format($d->debeUS, 2);     $a5+=$d->debeUS;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->haberUS > 0)      $html.= number_format($d->haberUS, 2);    $a6+=$d->haberUS;    $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($d->deudorUS, 2);   $a7+=$d->deudorUS;   $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($d->acreedorUS, 2); $a8+=$d->acreedorUS; $html.='</td>';
                     }else{ # BOLIVIANOS Y DOLARES
                        $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->debeBs > 0)       $html.= number_format($d->debeBs, 2);     $a1+=$d->debeBs;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->haberBs > 0)      $html.= number_format($d->haberBs, 2);    $a2+=$d->haberBs;    $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($d->deudorBs, 2);   $a3+=$d->deudorBs;   $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($d->acreedorBs, 2); $a4+=$d->acreedorBs; $html.='</td>';

                        $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->debeUS > 0)       $html.= number_format($d->debeUS, 2);     $a5+=$d->debeUS;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; if($d->haberUS > 0)      $html.= number_format($d->haberUS, 2);    $a6+=$d->haberUS;    $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($d->deudorUS, 2);   $a7+=$d->deudorUS;   $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($d->acreedorUS, 2); $a8+=$d->acreedorUS; $html.='</td>';
                     }
                     $html.='
                  </tr>';
               endforeach;
            endif;
            $html.='
         </tbody>
         <tfoot>
            <tr>
               <td class="textRight borde4 textSize12" colspan="2">TOTALES: &nbsp;&nbsp;&nbsp;&nbsp;</td>';
               if($tpm == 1){ #BOLIVIANOS
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a1, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a2, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a3, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a4, 2); $html.='</td>';
               }else if($tpm == 2){ # DOLARES
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a5, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a6, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a7, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a8, 2); $html.='</td>';
               }else{ # BOLIVIANOS Y DOLARES
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a1, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a2, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a3, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a4, 2); $html.='</td>';

                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a5, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a6, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a7, 2); $html.='</td>';
                  $html.='<td class="textRight borde4 textSize12">'; $html.= number_format($a8, 2); $html.='</td>';
               }
               $html.='
            </tr>
         <Ttfoot>
      </table>
   </body>
</html>';
?>