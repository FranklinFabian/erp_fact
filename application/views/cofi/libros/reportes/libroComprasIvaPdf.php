<?php $html = '
<html>
    <head>
        <title>Libro de Compras IVA</title>
        <style>
            body { font-size:80%; font-family: "Helvetica";}
            .textCenter{ text-align:center; }
            .textRight{ text-align: right; }
            .textSize12px{ font-size:12px; }
            .textSize10px{ font-size:10px; }
            .textSize8px{ font-size:8px; }

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
                  LIBRO DE COMPRAS IVA<br>PERIODO FISCAL: '.$periodoFiscal.'<br>(Expresado en Bolivianos)
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
               <th class="textCenter borde4 textSize8px" width="3%">E S P E C I F I C A C I &Oacute; N</th>
               <th class="textCenter borde4 textSize10px" width="2%">N&deg;</th>
               <th class="textCenter borde4 textSize10px" width="8%">FECHA DE LA FACTURA O DUI</th>
               <th class="textCenter borde4 textSize10px" width="8%">NIT PROVEEDOR</th>
               <th class="textCenter borde4 textSize10px" width="22%">NOMBRE Y APELLIDOS/RAZ&Oacute;N SOCIAL</th>
               <th class="textCenter borde4 textSize8px" width="%">N&deg; DE FACTURA</th>
               <th class="textCenter borde4 textSize8px" width="%">N&deg; DE DUI</th>
               <th class="textCenter borde4 textSize8px" width="6%">N&deg; DE AUTORIZACI&Oacute;N</th>
               <th class="textCenter borde4 textSize8px" width="%">IMPORTE TOTAL DE LA COMPRA</th>
               <th class="textCenter borde4 textSize8px" width="%">IMPORTE NO SUJETO A CR&Eacute;DITO FISCAL</th>
               <th class="textCenter borde4 textSize8px" width="%">SUBTOTAL</th>
               <th class="textCenter borde4 textSize8px" width="%">DESCUENTOS BONIFICACIONES Y REBAJAS OBTENIDAS</th>
               <th class="textCenter borde4 textSize8px" width="%">IMPORTE BASE PARA CR&Eacute;DITO FISCAL</th>
               <th class="textCenter borde4 textSize8px" width="%">CR&Eacute;DITO FISCAL</th>
               <th class="textCenter borde4 textSize8px" width="%">C&Oacute;DIGO DE CONTROL</th>
               <th class="textCenter borde4 textSize8px" width="3%">T I P O  DE  C O M P R A</th>
            </tr>   
         </thead>
         <tbody>';
            $a1=0; $a2=0; $a3=0; $a4=0; $a5=0; $a6=0;
            
            $html.='
         </tbody>
         <tfoot>
            <tr>
               <td class="borde4 textSize10px" colspan="4">'.$ciResponsable.'</td>   
               <td class="borde4 textSize10px">'.strtoupper($nombreResponsable).'</td>
               <td class="borde4 textSize10px bold" colspan="3">TOTALES PARCIALES</td>
               <td class="borde4 textRight textSize10px">'.number_format($a1, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a2, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a3, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a4, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a5, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a6, 2).'</td>
               <td class="borde4 textRight textSize10px"> </td>
               <td class="borde4 textRight textSize10px"> </td>
            </tr>
            <tr>
               <td class="borde4 textSize10px bold" colspan="4">C.I.</td>
               <td class="borde4 textSize10px bold">NOMBRE COMPLETO RESPONSABLE</td>   
               <td class="borde4 textSize10px bold" colspan="3">TOTALES GENERALES</td>
               <td class="borde4 textRight textSize10px">'.number_format($a1, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a2, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a3, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a4, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a5, 2).'</td>
               <td class="borde4 textRight textSize10px">'.number_format($a6, 2).'</td>
               <td class="borde4 textRight textSize10px"> </td>
               <td class="borde4 textRight textSize10px"> </td>
            </tr>
         <tfoot>
      </table>
    
    </body>
</html>';
?>