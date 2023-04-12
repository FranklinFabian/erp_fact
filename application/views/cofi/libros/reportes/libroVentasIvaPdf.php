<?php $html = '
<html>
    <head>
        <title>Libro de Ventas IVA</title>
        <style>
            body { font-size:80%; font-family: "Helvetica";}
            .textCenter{ text-align:center; }
            .textRight{ text-align: right; }
            .textSize12px{ font-size:12px; }
            .textSize10px{ font-size:10px; }

            .seccionTitulo{ margin-top: -50px; }
            .bold{ font-weight: bold; }
            .borde4{ padding: 3px; border: 1px solid black;}

            .bordeLeftRight{
               padding: 2px;
               border-top: 0px solid black;
               border-right: 1px solid black;
               border-bottom: 0px solid black;
               border-left: 1px solid black;
            }
            #figura1{
                text-align: center;
                width: 35%;
                position: absolute;
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
               <td colspan="3" class="textCenter bold">
                  LIBRO DE VENTAS IVA<br>PERIODO FISCAL: '.$periodoFiscal.'<br>(Expresado en Bolivianos)
               </td>
            </tr>
            <tr>
               <td width="55%"><span class="bold">RAZ&Oacute;N SOCIAL: </span>'.strtoupper($razonSocial).'</td>
               <td width="23%"><span class="bold">NIT: </span>'.$numeroNIT.'</td>
               <td width="22%"><span class="bold">FOLIO: </span>'.$numeroFolio.'</td>
            </tr>
            <tr>
               <td><span class="bold">N&deg; SUCURSAL: </span>'.$nroSucursal.'</td>
               <td colspan="2"><span class="bold">DIRECCI&Oacute;N: </span>'.strtoupper($direccion).'</td>
            </tr>
         </table>
      </div>

      <table id="tablaGeneral" border="0" cellspacing="0" width="100%" style="margin-top: 5px;">
         <thead>
            <tr>
               <th class="textCenter borde4 textSize10px" width="%">N&deg; DE NIT/CI<br>DEL COMPRADOR</th>
               <th class="textCenter borde4 textSize10px" width="50%">NOMBRE O RAZ&Oacute;N SOCIAL DEL COMPRADOR</th>
               <th class="textCenter borde4 textSize10px" width="%">N&deg; DE FACTURA</th>
               <th class="textCenter borde4 textSize10px" width="%">N&deg; DE AUTORIZACI&Oacute;N</th>
               <th class="textCenter borde4 textSize10px" width="%">FECHA</th>
               <th class="textCenter borde4 textSize10px" width="%">TOTAL FACTURA (A)</th>
               <th class="textCenter borde4 textSize10px" width="%">TOTAL ICE (B)</th>
               <th class="textCenter borde4 textSize10px" width="%">IMPORTE EXENTOS (C)</th>
               <th class="textCenter borde4 textSize10px" width="%">IMPORTE NETO<br>(A-B-C)</th>
               <th class="textCenter borde4 textSize10px" width="%">D&Eacute;BITO FISCAL IVA</th>
               <th class="textCenter borde4 textSize10px" width="%">ESTADO FACTURA</th>
               <th class="textCenter borde4 textSize10px" width="%">C&Oacute;DIGO DE CONTROL</th>
            </tr>   
         </thead>
         <tbody>';
            $a1=0; $a2=0; $a3=0; $a4=0; $a5=0;
            
            $html.='
         </tbody>
         <tfoot>
            <tr>
               <td class="borde4 textSize10px">'.$ciResponsable.'</td>   
               <td class="borde4 textSize10px">'.strtoupper($nombreResponsable).'</td>
               <td colspan="3" class="borde4 textSize10px"><strong>TOTALES PARCIALES</strong></td>
               <td class="borde4 textRight textSize10px">'.number_format($a1, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a2, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a3, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a4, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a5, 2).'</td>
               <td class="borde4 textRight textSize10px"> </td>
               <td class="borde4 textRight textSize10px"> </td>
            </tr>
            <tr>
               <td class="borde4 textSize10px bold">C.I.</td>
               <td class="borde4 textSize10px bold">NOMBRE COMPLETO RESPONSABLE</td>   
               <td colspan="3" class="borde4 textSize10px"><strong>TOTALES GENERALES</strong></td>
               <td class="borde4 textRight textSize10px">'.number_format($a1, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a2, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a3, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a4, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a5, 2).'</td>
               <td class="borde4 textRight textSize10px"> </td>
               <td class="borde4 textRight textSize10px"> </td>
            </tr>
         <tfoot>
      </table>
    
    </body>
</html>';
?>