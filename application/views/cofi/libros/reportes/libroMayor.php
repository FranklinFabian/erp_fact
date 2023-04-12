<?php $html = '
<html>
   <head>
      <title>Libro Mayor</title>
      <style>
         body { font-size:80%; font-family: calibri; }
         .textCenter{ text-align:center; }
         .textRight{ text-align: right; }
         .fs-12{ font-size:12px; }
         .borde4{
            padding: 3px;
            border-top: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            border-left: 1px solid black;
         }
         .bordeLeftRight{
            padding: 2px;
            border-top: 0px solid black;
            border-right: 1px solid black;
            border-bottom: 0px solid black;
            border-left: 1px solid black;
         }
         table {
            color: #FFF;
            /*font-weight: bold;*/
            /*text-align: center;*/
            background-color: #122;
         }
         table td { /* datos de la tabla*/
            color: #000;
            background-color: #FFF;
         }
         table th { /* datos de la tabla*/
            color: #000;
            background-color: #FFF;
         }
      </style>
   </head>
   <body>
      <div>
         <table border="0" cellspacing="0" width="100%">
            <tr>
               <td>
                  <p class="textCenter"><strong>
                     LIBRO MAYOR<br>
                     DEL '; $html.=$fechaInicial.' AL '.$fechaFinal; $html.='<br>';
                     if($tipoMoneda == 1) # BOLIVIANOS
                        $html.='(Expresado en Bolivianos)';
                     elseif($tipoMoneda == 2) # DOLARES
                        $html.='(Expresado en D&oacute;lares)';
                     elseif($tipoMoneda == 3) # UFV
                        $html.='(Expresado en UFV\'s)';
                     elseif($tipoMoneda == 4) # BOLIVIANOS Y DOLARES
                        $html.='(Expresado en Bolivianos y D&oacute;lares)';
                     elseif($tipoMoneda == 5) # BOLIVIANOS Y UFV's
                        $html.='(Expresado en Bolivianos y UFV\'s)';
                     else # BOLIVIANOS DOLARES Y UFV's
                        $html.='(Expresado en Bolivianos, D&oacute;lares y UFV\'s)';
                     $html.='</strong>
                  </p>
               </td>
            </tr>
         </table>
      </div>';
      $a1T=0; $a2T=0; $a3T=0; $a4T=0; $a5T=0; $a6T=0; $a7T=0; $a8T=0; $a9T=0;
      foreach($dataCuentasLibroMayor as $clm):
         $a1=0; $a2=0; $a3=0; $a4=0; $a5=0; $a6=0; $a7=0; $a8=0; $a9=0;
         $html .='
         <table border="0" cellspacing="0" width="100%">
            <tr>
               <td width="15%"><strong class="">Cuenta: </strong></td>
               <td>'.$clm->codigo.'</td>
            </tr>
            <tr>
               <td><strong class="">Nombre de la Cuenta: </strong></td>
               <td>'.$clm->nombre.'</td>
            </tr>
         </table>
         <table border="0" cellspacing="0" width="100%" style="margin-top: 10px;">
            <thead>
               <tr>';
                  $html.='<th rowspan="2" class="textCenter borde4 fs-12">Fecha</th>';
                  $html.='<th rowspan="2" class="textCenter borde4 fs-12">Nro. Comprobante</th>';
                  $html.='<th rowspan="2" class="textCenter borde4 fs-12" width="30%">DETALLE</th>';
                  if($tipoMoneda == 1){ # BOLIVIANOS
                     $html.='<th colspan="3" class="textCenter borde4 fs-12">BOLIVIANOS</th>';
                  }else if($tipoMoneda == 2){ # DOLARES
                     $html.='<th colspan="3" class="textCenter borde4 fs-12">D&Oacute;LARES</th>';
                  }else if($tipoMoneda == 3){ # UFV
                     $html.='<th colspan="3" class="textCenter borde4 fs-12">UFV\'s</th>';
                  }else if($tipoMoneda == 4){ # BOLIVIANOS Y DOLARES
                     $html.='<th colspan="3" class="textCenter borde4 fs-12">BOLIVIANOS</th>';
                     $html.='<th colspan="3" class="textCenter borde4 fs-12">D&Oacute;LARES</th>';
                  }else if($tipoMoneda == 5){ # BOLIVIANOS Y UFV
                     $html.='<th colspan="3" class="textCenter borde4 fs-12">BOLIVIANOS</th>';
                     $html.='<th colspan="3" class="textCenter borde4 fs-12">UFV\'s</th>';
                  }else{
                     $html.='<th colspan="3" class="textCenter borde4 fs-12">BOLIVIANOS</th>';
                     $html.='<th colspan="3" class="textCenter borde4 fs-12">D&Oacute;LARES</th>';
                     $html.='<th colspan="3" class="textCenter borde4 fs-12">UFV\'s</th>';
                  }
                  $html.='<th rowspan="2" class="textCenter borde4 fs-12" width="6%">T/C</th>';
                  $html.='
               </tr>
               <tr>';
                  if($tipoMoneda == 1 || $tipoMoneda == 2 || $tipoMoneda == 3){ # BOLIVIANOS || DOLARES || UFV
                     $html.='<th class="textCenter borde4 fs-12">DEBE</th>';
                     $html.='<th class="textCenter borde4 fs-12">HABER</th>';
                     $html.='<th class="textCenter borde4 fs-12">SALDO</th>';
                  }else if($tipoMoneda == 4){ # BOLIVIANOS Y DOLARES
                     $html.='<th class="textCenter borde4 fs-12">DEBE</th>';
                     $html.='<th class="textCenter borde4 fs-12">HABER</th>';
                     $html.='<th class="textCenter borde4 fs-12">SALDO</th>';
                     $html.='<th class="textCenter borde4 fs-12">DEBE</th>';
                     $html.='<th class="textCenter borde4 fs-12">HABER</th>';
                     $html.='<th class="textCenter borde4 fs-12">SALDO</th>';
                  }else if($tipoMoneda == 5){ # BOLIVIANOS Y UFV
                     $html.='<th class="textCenter borde4 fs-12">DEBE</th>';
                     $html.='<th class="textCenter borde4 fs-12">HABER</th>';
                     $html.='<th class="textCenter borde4 fs-12">SALDO</th>';
                     $html.='<th class="textCenter borde4 fs-12">DEBE</th>';
                     $html.='<th class="textCenter borde4 fs-12">HABER</th>';
                     $html.='<th class="textCenter borde4 fs-12">SALDO</th>';
                  }else{
                     $html.='<th class="textCenter borde4 fs-12">DEBE</th>';
                     $html.='<th class="textCenter borde4 fs-12">HABER</th>';
                     $html.='<th class="textCenter borde4 fs-12">SALDO</th>';
                     $html.='<th class="textCenter borde4 fs-12">DEBE</th>';
                     $html.='<th class="textCenter borde4 fs-12">HABER</th>';
                     $html.='<th class="textCenter borde4 fs-12">SALDO</th>';
                     $html.='<th class="textCenter borde4 fs-12">DEBE</th>';
                     $html.='<th class="textCenter borde4 fs-12">HABER</th>';
                     $html.='<th class="textCenter borde4 fs-12">SALDO</th>';
                  }
                  $html.='
               </tr>
            </thead>
            <tbody>';
               foreach($clm->dataCuentaLibroMayor as $dlm):
                  $html.='
               <tr>
                  <td class="fs-12 textCenter">'.date('d/m/Y', strtotime($dlm->fecha)).'</td>
                  <td class="fs-12 textCenter">'.$dlm->comprobante_tipo_nombre.' Nro. '.$dlm->correlativo.'</td>
                  <td class="fs-12">'.utf8_encode($dlm->referencia).'</td>';
                  if($tipoMoneda == 1){ # BOLIVIANOS
                     $html.='<td class="textRight fs-12">'; $a1+=$dlm->debeBs;                     $html.= number_format($dlm->debeBs, 2);            $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a2+=$dlm->haberBs;                    $html.= number_format($dlm->haberBs, 2);           $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a3+=($dlm->debeBs-$dlm->haberBs);     $html.= number_format($a3, 2);                     $html.='</td>';
                  }else if($tipoMoneda == 2){ # DOLARES
                     $html.='<td class="textRight fs-12">'; $a1+=$dlm->debeUS;                     $html.= number_format($dlm->debeUS, 2);            $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a2+=$dlm->haberUS;                    $html.= number_format($dlm->haberUS, 2);           $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a3+=($dlm->debeUS-$dlm->haberUS);     $html.= number_format($a3, 2);                     $html.='</td>';
                  }else if($tipoMoneda == 3){ # UFV
                     $html.='<td class="textRight fs-12">'; $a1+=$dlm->debeUFV;                    $html.= number_format($dlm->debeUFV, 2);           $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a2+=$dlm->haberUFV;                   $html.= number_format($dlm->haberUFV, 2);          $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a3+=($dlm->debeUFV-$dlm->haberUFV);   $html.= number_format($a3, 2);                     $html.='</td>';
                  }else if($tipoMoneda == 4){ # BOLIVIANOS Y DOLARES
                     $html.='<td class="textRight fs-12">'; $a1+=$dlm->debeBs;                     $html.= number_format($dlm->debeBs, 2);            $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a2+=$dlm->haberBs;                    $html.= number_format($dlm->haberBs, 2);           $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a3+=($dlm->debeBs-$dlm->haberBs);     $html.= number_format($a3, 2);                     $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a4+=$dlm->debeUS;                     $html.= number_format($dlm->debeUS, 2);            $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a5+=$dlm->haberUS;                    $html.= number_format($dlm->haberUS, 2);           $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a6+=($dlm->debeUS-$dlm->haberUS);     $html.= number_format($a6, 2);                     $html.='</td>';
                  }else if($tipoMoneda == 5){ # BOLIVIANOS Y UFV
                     $html.='<td class="textRight fs-12">'; $a1+=$dlm->debeBs;                     $html.= number_format($dlm->debeBs, 2);            $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a2+=$dlm->haberBs;                    $html.= number_format($dlm->haberBs, 2);           $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a3+=($dlm->debeBs-$dlm->haberBs);     $html.= number_format($a3, 2);                     $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a4+=$dlm->debeUFV;                    $html.= number_format($dlm->debeUFV, 2);           $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a5+=$dlm->haberUFV;                   $html.= number_format($dlm->haberUFV, 2);          $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a6+=($dlm->debeUFV-$dlm->haberUFV);   $html.= number_format($a6, 2);                     $html.='</td>';
                  }else{
                     $html.='<td class="textRight fs-12">'; $a1+=$dlm->debeBs;                     $html.= number_format($dlm->debeBs, 2);            $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a2+=$dlm->haberBs;                    $html.= number_format($dlm->haberBs, 2);           $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a3+=($dlm->debeBs-$dlm->haberBs);     $html.= number_format($a3, 2);                     $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a4+=$dlm->debeUS;                     $html.= number_format($dlm->debeUS, 2);            $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a5+=$dlm->haberUS;                    $html.= number_format($dlm->haberUS, 2);           $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a6+=($dlm->debeUS-$dlm->haberUS);     $html.= number_format($a6, 2);                     $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a7+=$dlm->debeUFV;                    $html.= number_format($dlm->debeUFV, 2);           $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a8+=$dlm->haberUFV;                   $html.= number_format($dlm->haberUFV, 2);          $html.='</td>';
                     $html.='<td class="textRight fs-12">'; $a9+=($dlm->debeUFV-$dlm->haberUFV);   $html.= number_format($a9, 2);                     $html.='</td>';
                  }
                  $html.='<td class="textCenter fs-12">'.$dlm->tcBsUS.' '.$dlm->tcBsUFV.'</td>';
                  $html.='
               </tr>';
               endforeach;
               $a1T+=$a1; $a2T+=$a2; $a3T+=$a3;
               $a4T+=$a4; $a5T+=$a5; $a6T+=$a6;
               $a7T+=$a7; $a8T+=$a8; $a9T+=$a9;
               if(count($clm->dataCuentaLibroMayor) == 0):
                  $html.='<tr>';
                  if($tipoMoneda == 1 || $tipoMoneda == 2 || $tipoMoneda == 3) # BOLIVIANOS || DOLARES || UFV
                     $html.='<td colspan="7" class="fs-12 textCenter">SIN REGISTROS</td>';
                  else if($tipoMoneda == 4 || $tipoMoneda == 5) # BOLIVIANOS Y DOLARES  || BOLIVIANOS Y UFV's
                     $html.='<td colspan="10" class="fs-12 textCenter">SIN REGISTROS</td>';
                  else
                     $html.='<td colspan="13" class="fs-12 textCenter">SIN REGISTROS</td>';
                  $html.='</tr>';
               endif;
               $html.='
                  <tr>
                     <td colspan="3" class="textRight fs-12"><strong>TOTAL</strong></td>';
                     if($tipoMoneda == 1 || $tipoMoneda == 2 || $tipoMoneda == 3){ # BOLIVIANOS || DOLARES || UFV
                        $html.='<td class="textRight fs-12">'.number_format($a1, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a2, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a3, 2).'</td>';
                     }else if($tipoMoneda == 4 || $tipoMoneda == 5){ # BOLIVIANOS Y DOLARES  || BOLIVIANOS Y UFV's
                        $html.='<td class="textRight fs-12">'.number_format($a1, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a2, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a3, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a4, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a5, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a6, 2).'</td>';
                     }else{
                        $html.='<td class="textRight fs-12">'.number_format($a1, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a2, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a3, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a4, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a5, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a6, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a7, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a8, 2).'</td>';
                        $html.='<td class="textRight fs-12">'.number_format($a9, 2).'</td>';
                     }
                     $html.='
                     <td class="textRight fs-12">&nbsp;</td>
                  </tr>';
               $html.='
            </tbody>
            <!-- OCULTO, solo se lista de una cuenta -->
            <!--<tfoot>
               <tr>
                  <td colspan="3" class="borde4 textRight fs-12"><strong>TOTAL TOTAL</strong></td>';
                  if($tipoMoneda == 1 || $tipoMoneda == 2 || $tipoMoneda == 3){ # BOLIVIANOS || DOLARES || UFV
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a1T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a2T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a3T, 2).'</td>';
                  }else if($tipoMoneda == 4 || $tipoMoneda == 5){ # BOLIVIANOS Y DOLARES  || BOLIVIANOS Y UFV's
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a1T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a2T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a3T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a4T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a5T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a6T, 2).'</td>';
                  }else{
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a1T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a2T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a3T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a4T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a5T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a6T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a7T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a8T, 2).'</td>';
                     $html.='<td class="borde4 textRight fs-12">'.number_format($a9T, 2).'</td>';
                  }
                  $html.='
                  <td class="borde4 textRight fs-12">&nbsp;</td>
               </tr>
            <tfoot>-->
         </table>';
      endforeach;
      $html .='
   </body>
</html>';
?>