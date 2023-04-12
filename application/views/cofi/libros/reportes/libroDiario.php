<?php $html = '
<html>
   <head>
      <title>LIBRO DIARIO</title>
      <style>
         body {
            font-size:80%;
            font-family: calibri;
         }
         h3 {
            text-align:center;
            color: #000;
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
         .conBorde{
            padding: 5px;
            border-top: 0px;
            border-right: 0px;
            border-bottom: 1px solid black;
            border-left: 0px;
         }

         #reporteDia{
               width: 100%;
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
         .bordeDoble{
               background-color: #FFF;
               /*border: 5 4 #000;*/
         }
         #cabecera{
               margin-top: 1%;
               margin-bottom: 1%;
         }
         #figura1{
               text-align: center;
               width: 35%;
               position: absolute;
         }
         #tituloPrincipal{
               text-align: center;
               width: 30%;
               position: absolute;
               margin-left: 35%;
         }
         #figura2{
               text-align: center;
               width: 35%;
               position: absolute;
               margin-left: 65%;
         }
      </style>
   </head>
   <body>
      <div class="seccionTitulo">
         <br><br>
         <table border="0" cellspacing="0" width="100%">
            <tr>
               <td>
                  <p class="textCenter"><strong>
                     LIBRO DIARIO<br>
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
      </div>

      <table id="tablaGeneral" border="0" cellspacing="0" width="100%" style="margin-top: 10px;">
         <thead>
            <tr>';
               $html.='<th class="textCenter borde4 textSize12">C&Oacute;DIGO</th>';
               $html.='<th class="textCenter borde4 textSize12" width="40%">DETALLE</th>';
               if($tipoMoneda == 1){ # BOLIVIANOS
                  $html.='<th class="textCenter borde4 textSize12">DEBE BS.</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER BS.</th>';
               }else if($tipoMoneda == 2){ # DOLARES
                  $html.='<th class="textCenter borde4 textSize12">DEBE US$.</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER US$.</th>';
               }else if($tipoMoneda == 3){ # UFV
                  $html.='<th class="textCenter borde4 textSize12">DEBE UFV.</th>';
                  $html.='<th class="textCenter borde4 textSize12">Haber UFV.</th>';
               }else if($tipoMoneda == 4){ # BOLIVIANOS Y DOLARES
                  $html.='<th class="textCenter borde4 textSize12">DEBE BS.</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER BS.</th>';
                  $html.='<th class="textCenter borde4 textSize12">DEBE US$.</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER US$.</th>';
               }else if($tipoMoneda == 5){ # BOLIVIANOS Y UFV'S
                  $html.='<th class="textCenter borde4 textSize12">DEBE BS.</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER BS.</th>';
                  $html.='<th class="textCenter borde4 textSize12">DEBE UFV.</th>';
                  $html.='<th class="textCenter borde4 textSize12">Haber UFV.</th>';
               }else{                      # TODAS
                  $html.='<th class="textCenter borde4 textSize12">DEBE BS.</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER BS.</th>';
                  $html.='<th class="textCenter borde4 textSize12">DEBE US$.</th>';
                  $html.='<th class="textCenter borde4 textSize12">HABER US$.</th>';
                  $html.='<th class="textCenter borde4 textSize12">DEBE UFV.</th>';
                  $html.='<th class="textCenter borde4 textSize12">Haber UFV.</th>';
               }
               $html.='
            </tr>
         </thead>
         <tbody>';
            $a1=0; $a2=0; $a3=0; $a4=0;
            $a1T=0; $a2T=0; $a3T=0; $a4T=0; $a5T=0; $a6T=0;
            foreach($comprobantesLibroDiario as $cld):
               $a1=0; $a2=0; $a3=0; $a4=0; $a5=0; $a6=0;
               $html.='
               <tr>';
                  if($tipoMoneda == 1 || $tipoMoneda == 2 || $tipoMoneda == 3)  # BOLIVIANOS || DOLARES || UFV
                     $html.='<td colspan="4" class="bordeLeftRight textSize12">Fecha: '.date('d/m/Y', strtotime($cld->fecha)).'</td>';
                  else if($tipoMoneda == 4 || $tipoMoneda == 5)
                     $html.='<td colspan="6" class="bordeLeftRight textSize12">Fecha: '.date('d/m/Y', strtotime($cld->fecha)).'</td>';
                  else
                     $html.='<td colspan="8" class="bordeLeftRight textSize12">Fecha: '.date('d/m/Y', strtotime($cld->fecha)).'</td>';
                  $html.='
               </tr>
               <tr>';
                  $html.='<td class="bordeLeftRight textSize12">Cpbte. '.$cld->comprobante_tipo_nombre.' Nro. '.$cld->correlativo.'</td>';
                  $html.='<td class="bordeLeftRight textSize12">'.$cld->glosa.'</td>';
                  if($tipoMoneda == 1 || $tipoMoneda == 2 || $tipoMoneda == 3) { # BOLIVIANOS || DOLARES || UFV
                     $html.='<td class="bordeLeftRight textRight textSize12"> TC Bs/US$<br>TC Bs/UFV</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.$cld->tcBsUS.'<br>'.$cld->tcBsUFV.'</td>';
                  }else if($tipoMoneda == 4 || $tipoMoneda == 5) {
                     $html.='<td class="bordeLeftRight textRight textSize12"> TC Bs/US$<br>TC Bs/UFV</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.$cld->tcBsUS.'<br>'.$cld->tcBsUFV.'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12"> TC Bs/US$<br>TC Bs/UFV</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.$cld->tcBsUS.'<br>'.$cld->tcBsUFV.'</td>';
                  }else{
                     $html.='<td class="bordeLeftRight textRight textSize12"> TC Bs/US$<br>TC Bs/UFV</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.$cld->tcBsUS.'<br>'.$cld->tcBsUFV.'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12"> TC Bs/US$<br>TC Bs/UFV</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.$cld->tcBsUS.'<br>'.$cld->tcBsUFV.'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12"> TC Bs/US$<br>TC Bs/UFV</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.$cld->tcBsUS.'<br>'.$cld->tcBsUFV.'</td>';
                  }
                  $html.='
               </tr>
               <tr>';
                  if($tipoMoneda == 1 || $tipoMoneda == 2 || $tipoMoneda == 3)  # BOLIVIANOS || DOLARES || UFV
                     $html.='<td colspan="4" class="bordeLeftRight textSize12">&nbsp;</td>';
                  else if($tipoMoneda == 4 || $tipoMoneda == 5)
                     $html.='<td colspan="6" class="bordeLeftRight textSize12">&nbsp;</td>';
                  else
                     $html.='<td colspan="8" class="bordeLeftRight textSize12">&nbsp;</td>';
                  $html.='
               </tr>';
                  foreach($cld->dataComprobanteLibroDiario as $dld):
                     $html.='
               <tr>';
                     $html.='<td class="textCenter bordeLeftRight textSize12">'; $html.= $dld->cuenta_codigo;   $html.='</td>';
                     $html.='<td class="bordeLeftRight textSize12">';            $html.= $dld->cuenta_nombre;  $html.='</td>';
                     if($tipoMoneda == 1){ # BOLIVIANOS
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->debeBs, 2);     $a1+=$dld->debeBs;      $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->haberBs, 2);    $a2+=$dld->haberBs;     $html.='</td>';
                     }else if($tipoMoneda == 2){ # DOLARES
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->debeUS, 2);     $a1+=$dld->debeUS;      $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->haberUS, 2);    $a2+=$dld->haberUS;     $html.='</td>';
                     }else if($tipoMoneda == 3){ # UFV
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->debeUFV, 2);    $a1+=$dld->debeUFV;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->haberUFV, 2);   $a2+=$dld->haberUFV;    $html.='</td>';
                     }else if($tipoMoneda == 4){ # BOLIVIANOS Y DOLARES
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->debeBs, 2);     $a1+=$dld->debeBs;      $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->haberBs, 2);    $a2+=$dld->haberBs;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->debeUS, 2);     $a3+=$dld->debeUS;      $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->haberUS, 2);    $a4+=$dld->haberUS;     $html.='</td>';
                     }else if($tipoMoneda == 5){ # BOLIVIANOS Y UFV'S
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->debeBs, 2);     $a1+=$dld->debeBs;      $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->haberBs, 2);    $a2+=$dld->haberBs;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->debeUFV, 2);    $a3+=$dld->debeUFV;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->haberUFV, 2);   $a4+=$dld->haberUFV;    $html.='</td>';
                     }else{                      # TODAS
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->debeBs, 2);     $a1+=$dld->debeBs;      $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->haberBs, 2);    $a2+=$dld->haberBs;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->debeUS, 2);     $a3+=$dld->debeUS;      $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->haberUS, 2);    $a4+=$dld->haberUS;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->debeUFV, 2);    $a5+=$dld->debeUFV;     $html.='</td>';
                        $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($dld->haberUFV, 2);   $a6+=$dld->haberUFV;    $html.='</td>';
                     }
                  $html.='
               </tr>';
                  endforeach;
                  $a1T+=$a1; $a2T+=$a2; $a3T+=$a3;
                  $a4T+=$a4; $a5T+=$a5; $a6T+=$a6;
                  $html.='
               <tr>
                  <td colspan="2" class="bordeLeftRight textRight textSize12"><strong>TOTAL</strong></td>';
                  if($tipoMoneda == 1 || $tipoMoneda == 2 || $tipoMoneda == 3){ # BOLIVIANOS || DOLARES || UFV
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a1, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a2, 2).'</td>';
                  }else if($tipoMoneda == 4){ # BOLIVIANOS Y DOLARES
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a1, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a2, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a3, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a4, 2).'</td>';
                  }else if($tipoMoneda == 5){ # BOLIVIANOS Y UFV'S
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a1, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a2, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a3, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a4, 2).'</td>';
                  }else{                      # TODAS
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a1, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a2, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a3, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a4, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a5, 2).'</td>';
                     $html.='<td class="bordeLeftRight textRight textSize12">'.number_format($a6, 2).'</td>';
                  }
                  $html.='
               </tr>';
            endforeach;
            if(count($comprobantesLibroDiario) == 0):
               $html.='<tr>';
               if($tipoMoneda == 1 || $tipoMoneda == 2 || $tipoMoneda == 3) # BOLIVIANOS || DOLARES || UFV
                  $html.='<td colspan="4" class="bordeLeftRight textSize12 textCenter">SIN REGISTROS</td>';
               else if($tipoMoneda == 4 || $tipoMoneda == 5) # BOLIVIANOS Y DOLARES  || BOLIVIANOS Y UFV's
                  $html.='<td colspan="6" class="bordeLeftRight textSize12 textCenter">SIN REGISTROS</td>';
               else
                  $html.='<td colspan="8" class="bordeLeftRight textSize12 textCenter">SIN REGISTROS</td>';
               $html.='</tr>';
            endif;
            $html.='
            <tr>
               <td colspan="2" class="borde4 textRight textSize12"><strong>TOTAL TOTAL</strong></td>';
               if($tipoMoneda == 1 || $tipoMoneda == 2 || $tipoMoneda == 3){ # BOLIVIANOS || DOLARES || UFV
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a1T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a2T, 2).'</td>';
               }else if($tipoMoneda == 4){ # BOLIVIANOS Y DOLARES
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a1T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a2T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a3T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a4T, 2).'</td>';
               }else if($tipoMoneda == 5){ # BOLIVIANOS Y UFV'S
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a1T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a2T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a3T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a4T, 2).'</td>';
               }else{                      # TODAS
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a1T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a2T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a3T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a4T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a5T, 2).'</td>';
                  $html.='<td class="borde4 textRight textSize12">'.number_format($a6T, 2).'</td>';
               }
               $html.='
            </tr>
         </tbody>
      </table>
   </body>
</html>';
?>