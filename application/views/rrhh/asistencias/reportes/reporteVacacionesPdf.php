<?php
    $nombre_empleado = $data_empleado->paterno.' '.$data_empleado->materno.' '.$data_empleado->nombre1.' '.$data_empleado->nombre2;
$html = '
<html>
    <head>
        <title>Reporte de Licencias y Vacaciones</title>
        <style>
            @page { margin: 45px 45px 60px; } /* top left&right botoom*/
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
            .mt-10{ margin-top: 10px; }
            .proFondo{
                background: #EAB;
            }
        </style>
    </head>
    <body>
        <div id="content">
            <table border="0" cellspacing="0" width="100%" id="tabla_cabecera" class="">
                <tr>
                    <td class="fontSize11px pl-5" width="30%">
                        <span>'.$this->empresa_nombre.'</span><br />
                        <span>'.$this->empresa_direccion.'</span>
                    </td>
                    <td class="textRight" width="70%">
                        <span class="tamanioTitulo bold">REPORTE DE LICENCIAS Y VACACIONES <br>
                        DEL '.date('d/m/Y', strtotime($fecha_ini)).' AL '.date('d/m/Y', strtotime($fecha_fin)).'
                        </span><br>
                        <span class="textCenter fontSize11px">'.date('d/m/Y H:i:s').'&nbsp;</span>
                    </td>
                </tr>
            </table>
            <table border="0" cellspacing="0" width="100%" class="fontSize11px mt-10">
                <tr>
                    <th width="15%">EMPLEADO: </th>
                    <td width="85%">'.$data_empleado->empleado.'</td>
                </tr>
                <tr>
                    <th>NOMBRE: </th>
                    <td>'.utf8_encode($nombre_empleado).'</td>
                </tr>
            </table>

            <table border="0" cellspacing="0" width="100%" id="tabla_cabecera" class="fontSize11px mt-10">
                <thead> <!-- class="borde4" -->
                    <tr>
                        <th width="8%">Nro.</th>
                        <th width="10%">FECHA</th>
                        <th width="32%">CONTROL</th>
                        <th width="50%">NOTA</th>
                    </tr>
                </thead>
                <tbody>';
                    $vacaciones_dias = 0;
                    foreach($data_reporte as $i => $dr):
                        $html.='
                        <tr>
                            <td>'.($i + 1).'</td>
                            <td>'.date('d/m/Y', strtotime($dr->fecha)).'</td>
                            <td width="10%">'.$dr->control.'&nbsp;&nbsp;&nbsp;&nbsp;'.utf8_encode($dr->descripcion).'</td>
                            <td>'.utf8_encode($dr->nota).'</td>
                        </tr>';
                        if($dr->control == 'L2') {
                            $vacaciones_dias += 0.5;
                        } else {
                            $vacaciones_dias += 1;
                        }
                    endforeach;
                    if(count($data_reporte) == 0):
                        $i = -1;
                        $html.='
                            <tr class="textCenter">
                                <td colspan="4">Sin registros</td>
                            </tr>';
                    endif;
                    $html.='
                </tbody>
                <tfoot> <!-- class="borde4" -->
                    <tr>
                        <th class="">TOTAL: </th>
                        <td>'.($i + 1).'</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>DIAS:</th>
                        <td>'.number_format($vacaciones_dias, '2', '.', ',').'</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>';
?>