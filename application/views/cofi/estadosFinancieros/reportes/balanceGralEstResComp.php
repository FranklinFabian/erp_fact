<?php $html = '
<html>
    <head>
        <title>Estado de Resultados</title>
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
            .textBold{
               font-size:20px;
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
            .bordeTopBottom{
               padding: 2px;
               border-top: 1px solid black;
               border-right: 0px solid black;
               border-bottom: 1px solid black;
               border-left: 0px solid black;
            }
            .bordeTop{
               padding: 2px;
               border-top: 1px solid black;
               border-right: 0px solid black;
               border-bottom: 0px solid black;
               border-left: 0px solid black;
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
                     BALANCE GENERAL COMPARATIVO A '; $html.=$hastaMes.' / '.$gestion; $html.='<br>';
                     if($tpm == 1) # BOLIVIANOS
                        $html.='(Expresado en Bolivianos)';
                     else # DOLARES
                        $html.='(Expresado en D&oacute;lares)';
                     $html.='</strong>
                  </p>
               </td>
            </tr>
         </table>
      </div>

      <!--div class="seccionDatos">
         <table border="0" cellspacing="0" width="100%">
            <tr>
               <td width="80%">Nombre o Raz&oacute;n Social: </td>
               <td colspan="2" class="textRight"></td>
            </tr>
            <tr>
               <td> '; $html.="data"; $html.='</td>
               <td colspan="2" class="textRight">Fecha: '; $html.="data"; $html.='</td>
            </tr>
            <tr>
               <td>SON: '; $html.="data"; $html.=' </td>
               <td colspan="2" class="textRight"></td>
            </tr>
            <tr>
               <td>Concepto: </td>
               <td colspan="2" class="textRight"></td>
            </tr>
            <tr>
               <td>'; $html.="data"; $html.='</td>
               <td class="textRight">TC Bs/US$</td>
               <td class="textRight">'; $html.="data"; $html.='</td>
            </tr>
            <tr>
               <td></td>
               <td class="textRight">TC Bs/UFV</td>
               <td class="textRight">'; $html.="data"; $html.='</td>
            </tr>
         </table>
      </div-->';
      
      # SE CREAN LAS TABLAS DE ACUERDO A LOS GRUPOS DE LAS CUENTAS
            $html.='
               <table id="tablaGeneral" border="0" cellspacing="0" width="100%" style="margin-top: 10px;">
                  <thead>
                     <tr>
                        <th class="textCenter borde4 textSize12" width="6%">C&Oacute;DIGO</th>
                        <th class="textCenter borde4 textSize12" width="30%">NOMBRE CUENTA</th>
                        <th class="textCenter borde4 textSize12">Enero</th>
                        <th class="textCenter borde4 textSize12">Febrero</th>
                        <th class="textCenter borde4 textSize12">Marzo</th>
                        <th class="textCenter borde4 textSize12">Abril</th>
                        <th class="textCenter borde4 textSize12">Mayo</th>
                        <th class="textCenter borde4 textSize12">Junio</th>
                        <th class="textCenter borde4 textSize12">Julio</th>
                        <th class="textCenter borde4 textSize12">Agosto</th>
                        <th class="textCenter borde4 textSize12">Septiembre</th>
                        <th class="textCenter borde4 textSize12">Octubre</th>
                        <th class="textCenter borde4 textSize12">Noviembre</th>
                        <th class="textCenter borde4 textSize12">Diciembre</th>
                        <th class="textCenter borde4 textSize12">Acumulado</th>
                        <th class="textCenter borde4 textSize12">Promedio</th>
                     </tr>
                  </thead>

                  <tbody>';
                  if($listaGruposCuentas != false):
                     $sw2 = 0; # para solo imprimir una ultima vez la ultima fila
                     foreach($listaGruposCuentas as $li):
                        $sw = 0; # indica que si hay el grupo en accion
                        if($dataBalanceGralEstadoResComp):
                           $ai = 0; $da = $dataBalanceGralEstadoResComp;
                           foreach($dataBalanceGralEstadoResComp[1] as $d):
                              if(substr($d->cuenta_codigo, 0, 1) == ($li->id + 1)){ # nos adelantamos al futuro
                                 $sw += 1;
                                 $sw2 = 0; # existira otro ultimo
                              }
                              if(substr($d->cuenta_codigo, 0, 1) == $li->id ):
                                 if($tpm == 1){ # BOLIVIANOS
                                    $html.='
                                    <tr>
                                       <td class="bordeLeftRight textSize12">'; $html.= '&nbsp;'.$d->cuenta_codigo.str_repeat('0', 10 - $d->cantCerosTipCuenta);   $html.='</td>';
                                       $html.='<td class="bordeLeftRight textSize12">'; $html.= '&nbsp;'.str_repeat('&nbsp;',$d->cuenta_tipo_sangria).$d->cuenta_nombre;   $html.='</td>';
                                       # ACUMULADOS y # PROMEDIO
                                       $acumuladoBs = 0;
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 1)   if ($da[1][$ai]->montoBs != 0){      $html.= number_format($da[1][$ai]->montoBs, 2);  $acumuladoBs += $da[1][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 2)   if ($da[2][$ai]->montoBs != 0){      $html.= number_format($da[2][$ai]->montoBs, 2);  $acumuladoBs += $da[2][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 3)   if ($da[3][$ai]->montoBs != 0){      $html.= number_format($da[3][$ai]->montoBs, 2);  $acumuladoBs += $da[3][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 4)   if ($da[4][$ai]->montoBs != 0){      $html.= number_format($da[4][$ai]->montoBs, 2);  $acumuladoBs += $da[4][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 5)   if ($da[5][$ai]->montoBs != 0){      $html.= number_format($da[5][$ai]->montoBs, 2);  $acumuladoBs += $da[5][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 6)   if ($da[6][$ai]->montoBs != 0){      $html.= number_format($da[6][$ai]->montoBs, 2);  $acumuladoBs += $da[6][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 7)   if ($da[7][$ai]->montoBs != 0){      $html.= number_format($da[7][$ai]->montoBs, 2);  $acumuladoBs += $da[7][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 8)   if ($da[8][$ai]->montoBs != 0){      $html.= number_format($da[8][$ai]->montoBs, 2);  $acumuladoBs += $da[8][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 9)   if ($da[9][$ai]->montoBs != 0){      $html.= number_format($da[9][$ai]->montoBs, 2);  $acumuladoBs += $da[9][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 10)  if ($da[10][$ai]->montoBs != 0){     $html.= number_format($da[10][$ai]->montoBs, 2); $acumuladoBs += $da[10][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 11)  if ($da[11][$ai]->montoBs != 0){     $html.= number_format($da[11][$ai]->montoBs, 2); $acumuladoBs += $da[11][$ai]->montoBs; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 12)  if ($da[12][$ai]->montoBs != 0){     $html.= number_format($da[12][$ai]->montoBs, 2); $acumuladoBs += $da[12][$ai]->montoBs; } $html.='</td>';
                  
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($acumuladoBs, 2); $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($acumuladoBs/$mesBal, 2); $html.='</td>
                                    </tr>';
                                 }else{ # DÓLARES
                                    $html.='
                                    <tr>
                                       <td class="bordeLeftRight textSize12">'; $html.= '&nbsp;'.str_repeat('&nbsp;',$d->cuenta_tipo_sangria).$d->cuenta_codigo.str_repeat('0', 10 - $d->cantCerosTipCuenta);   $html.='</td>';
                                       $html.='<td class="bordeLeftRight textSize12">'; $html.= '&nbsp;'.$d->cuenta_nombre;   $html.='</td>';
                                       # ACUMULADOS y # PROMEDIO
                                       $acumuladoUS = 0;
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 1)   if ($da[1][$ai]->montoUS != 0) {     $html.= number_format($da[1][$ai]->montoUS, 2);  $acumuladoUS += $da[1][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 2)   if ($da[2][$ai]->montoUS != 0) {     $html.= number_format($da[2][$ai]->montoUS, 2);  $acumuladoUS += $da[2][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 3)   if ($da[3][$ai]->montoUS != 0) {     $html.= number_format($da[3][$ai]->montoUS, 2);  $acumuladoUS += $da[3][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 4)   if ($da[4][$ai]->montoUS != 0) {     $html.= number_format($da[4][$ai]->montoUS, 2);  $acumuladoUS += $da[4][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 5)   if ($da[5][$ai]->montoUS != 0) {     $html.= number_format($da[5][$ai]->montoUS, 2);  $acumuladoUS += $da[5][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 6)   if ($da[6][$ai]->montoUS != 0) {     $html.= number_format($da[6][$ai]->montoUS, 2);  $acumuladoUS += $da[6][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 7)   if ($da[7][$ai]->montoUS != 0) {     $html.= number_format($da[7][$ai]->montoUS, 2);  $acumuladoUS += $da[7][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 8)   if ($da[8][$ai]->montoUS != 0) {     $html.= number_format($da[8][$ai]->montoUS, 2);  $acumuladoUS += $da[8][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 9)   if ($da[9][$ai]->montoUS != 0) {     $html.= number_format($da[9][$ai]->montoUS, 2);  $acumuladoUS += $da[9][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 10)  if ($da[10][$ai]->montoUS != 0) {    $html.= number_format($da[10][$ai]->montoUS, 2); $acumuladoUS += $da[10][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 11)  if ($da[11][$ai]->montoUS != 0) {    $html.= number_format($da[11][$ai]->montoUS, 2); $acumuladoUS += $da[11][$ai]->montoUS; } $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; if($mesBal >= 12)  if ($da[12][$ai]->montoUS != 0) {    $html.= number_format($da[12][$ai]->montoUS, 2); $acumuladoUS += $da[12][$ai]->montoUS; } $html.='</td>';
                  
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($acumuladoUS, 2); $html.='</td>';
                                       $html.='<td class="bordeLeftRight textRight textSize12">'; $html.= number_format($acumuladoUS/$mesBal, 2); $html.='</td>
                                    </tr>';
                                 }
                              endif;
                              $ai = $ai + 1;
                           endforeach;
                        endif;
                     
                     if($sw > 0)
                        $html.='<tr><td colspan="16" class="bordeTopBottom textRight textSize12">&nbsp;</td></tr>';
                     else if($sw2 == 0){
                        $sw2 = 1;
                        $html.='<tr><td colspan="16" class="bordeTop textRight textSize12">&nbsp;</td></tr>';
                     }

                  endforeach;
               endif;
                     $html.='
                  </tbody>
               </table>';



      
      
$html.='
    
    </body>
</html>';
?>