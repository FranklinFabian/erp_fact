<?php $html = '
<html>
    <head>
        <title>Kardex de Sueldos</title>
        <style>
            @page { margin: 45px 45px 200px; } /* top left&right botoom*/
            #footer { position: fixed; left: 0px; bottom: -145px; right: 0px; height: 145px; background-color: white; }
            #cuadroGeneral { position: fixed; left: -4px; top: 0px; right: -4px; height: 952px; background-color: transparent; }
            
            body { font-size:80%; font-family: "Helvetica";}

            .tamanioTitulo{ font-size:100%; }
            .fontSize11px{ font-size: 11px; }
            .fontSize12px{ font-size: 12px; }
            .textCenter{ text-align:center; }
            .textRight{ text-align: right; }
            .subrrayar{ text-decoration: underline; }
            .bold{ font-weight: 600; }
            .borde4{ border: 1px solid #444; }
            .pl-5{ padding-left: 5px; }
            

            .proFondo{
                background: #EAB;
            }

            


        </style>
    </head>
    <body>
        <div id="content">
            <table border="0" cellspacing="0" width="100%" id="tabla_cabecera" class="borde4">
                <tr>
                    <td class="fontSize11px pl-5" width="35%">
                        <span>'.$this->empresa_nombre.'</span><br>
                        <span>'.$this->empresa_direccion.'</span><br><br>
                    </td>
                    <td class="textCenter" width="30%">
                        <span class="tamanioTitulo bold">KARDEX DE SUELDOS<br>
                            ENERGIA ELECTRICA
                        </span>
                    </td>
                    <td class="textCenter fontSize11px" width="35%">'.date('d/m/Y H:i:s').'<br><br><br></td>
                </tr>
            </table>

            <table border="0" cellspacing="0" width="100%" class="fontSize11px">
                <tr>
                    <th width="10%">Abonado</th>
                    <td width="15%">'.'$data_abonado->Id_Abonado'.'</td>
                    <td width="10%"></td>
                    <td width="35%"></td>
                    <th width="10%">Medidor</th>
                    <td width="20%">'.'$data_abonado->Serie_Medidor'.'</td>
                </tr>
                <tr>
                    <th>Raz&oacute;n</th>
                    <td colspan="3">'.'strtoupper($data_abonado->Nombres)'.'</td>
                    <th>Categor&iacute;a</th>
                    <td>'.'$data_abonado->Descripcion_Categoria'.'</td>
                </tr>
                <tr>
                    <th>Circuito</th>
                    <td>'.'?'.'</td>
                    <th>Direcci&oacute;n</th>
                    <td>'.'$data_abonado->Nombre_Localidad'.', '.'$data_abonado->Nombre_Zona'.', '.'$data_abonado->Nombre_Calle'.'</td>
                    <th>Poste</th>
                    <td>'.'$data_abonado->Poste'.'</td>
                </tr>
            </table>
            
            <table border="0" cellspacing="0" width="100%" id="tabla_cabecera" class="fontSize11px">
                <thead class="borde4">
                    <tr class="textRight">
                        <th>Periodo</th>
                        <th>Lectura</th>
                        <th>Consumo</th>
                        <th>Importe</th>
                        <th>Servicio</th>
                        <th width="7%">Ley 1886</th>
                        <th>Dignidad</th>
                        <th>Aseo</th>
                        <th>Alumb</th>
                        <th>Recargo</th>
                        <th>Devol</th>
                        <th>Afcoop</th>
                        <th>Total</th>
                        <th>Pago&nbsp;</th>
                    </tr>
                </thead>
                <tbody>';
                    #if($data_deudas != false):
                        #foreach($data_deudas as $dd):
                            $html.='
                            <tr class="textRight">
                                <td>'.'date(d/m/Y, strtotime($dd->Emision))'.'</td>
                                <td>3287 R</td>
                                <td>123</td>
                                <td>238,23</td>
                                <td>0,00</td>
                                <td>0,00</td>
                                <td>0,00</td>
                                <td>0,00</td>
                                <td>0,00</td>
                                <td>0,00</td>
                                <td>0,00</td>
                                <td>0,00</td>
                                <td>0,00</td>
                                <td></td>
                            </tr>';
                        #endforeach;
                    #else:
                        $html.='
                            <tr class="textCenter">
                                <td colspan="14">Sin deudas</td>
                            </tr>';
                    #endif;
                    $html.='
                </tbody>
                <tfoot class="borde4">
                    <tr>
                        <th colspan="10" class="textRight">IMPORTE TOTAL</th>
                        <td></td>
                        <th colspan="2" class="textRight">0,00</th>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div>'.'$nota'.'</div>
        </div>
    </body>
</html>';
?>