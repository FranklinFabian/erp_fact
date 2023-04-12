<?php $html = '
<html>
    <head>
        <title>'.$titulo.'</title>
        <style>
            @page { margin: 45px 45px 60px; } /* top left&right botoom*/
            #footer { position: fixed; left: 0px; bottom: -145px; right: 0px; height: 145px; background-color: white; }
            #cuadroGeneral { position: fixed; left: -4px; top: 0px; right: -4px; height: 952px; background-color: transparent; }

            body { font-family: "Helvetica"; }
            .fontSize4px{ font-size: 4px; }
            .fontSize10px{ font-size: 10px; }
            .fontSize11px{ font-size: 11px; }
            .fontSize12px{ font-size: 12px; }
            .fontSize13px{ font-size: 13px; }
            .fontSize14px{ font-size: 14px; }
            .fontSize15px{ font-size: 15px; }
            .fontSize16px{ font-size: 16px; }
            .textCenter{ text-align:center; }
            .textRight{ text-align: right; }
            .subrrayar{ text-decoration: underline; }
            .bold{ font-weight: 600; }
            .borde4{ border: 1px solid #444; }
            .borde_left_right{ border: 1px 1px 2px 1px solid #000; }
            .border-top{ border-top: 1px solid #000; }
            .border-bottom{ border-bottom: 1px solid #000; }
            .pl-5{ padding-left: 5px; }
            .pr-5{ padding-right: 5px; }
            .mt-20{ margin-top: 20px; }
            .mt-10{ margin-top: 10px; }
        </style>
    </head>
    <body>
        <div>
            <table border="0" cellspacing="0" width="100%">
                <tr>
                    <td class="fontSize12px pl-5" width="56%">
                        <span>'.$this->empresa_nombre.'</span><br />
                        <span>'.$this->empresa_direccion.'</span><br /><br />
                    </td>
                    <td class="textRight pr-5" width="44%">
                        <span class="fontSize13px bold">'.$titulo.'</span><br>
                        <span class="fontSize13px bold">SERVICIO DE: '.$nombre_servicio.'</span><br>
                        <span class="fontSize13px bold">CORRESPONDIENTE A: '.$mes_anio.'</span><br>
                        <span class="fontSize12px">'.date('d/m/Y H:i:s').'</span>
                    </td>
                </tr>
            </table>

            <table border="0" cellspacing="0" width="100%" class="fontSize10px mt-10">
                <thead class="border-top border-bottom">
                    <tr>
                        <th width="10%">EMPLEADO</th>
                        <th width="24%">NOMBRE</th>
                        <th width="22%">CARGO</th>
                        <th width="10%" class="textRight">SENCILLAS</th>
                        <th width="8%" class="textRight">DOBLES</th>
                        <th width="10%" class="textRight">NOCTURNAS</th>
                        <th width="8%" class="textRight">RECARGO</th>
                        <th width="8%" class="textRight">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="fontSize4px" colspan="8">&nbsp;</td></tr>';
                    $this->servicio = $servicio;
                    $data_horas_extras_servicio = array_filter($data_horas_extras, function ($e) {
                        return $e['servicio'] == $this->servicio;
                    });
                    foreach($data_horas_extras_servicio as $rm):
                        $html.='
                        <tr>
                            <td>'.$rm['empleado'].'</td>
                            <td>'.$rm['nombre_empleado'].'</td>
                            <td>'.$rm['nombre_item'].'</td>
                            <td class="textRight">'.number_format($rm['total_sencillas'], 2, '.', ',').'</td>
                            <td class="textRight">'.number_format($rm['total_dobles'], 2, '.', ',').'</td>
                            <td class="textRight">'.number_format($rm['total_nocturnas'], 2, '.', ',').'</td>
                            <td class="textRight">'.number_format($rm['total_recargo'], 2, '.', ',').'</td>
                            <td class="textRight">'.number_format($rm['total_hrs_extras'], 2, '.', ',').'</td>
                        </tr>';
                    endforeach;
                    if(count($data_horas_extras_servicio) == 0):
                        $html.='
                            <tr class="textCenter">
                                <td colspan="8">Sin registros</td>
                            </tr>';
                    endif;
                    $html.='
                    <tr><td class="fontSize4px" colspan="8">&nbsp;</td></tr>
                </tbody>
                <!--<tfoot class="border-top border-bottom">
                    <tr>
                        <td colspan="3" class="bold">TOTAL</td>
                        <td colspan="1" class="textRight">'.number_format(0, 2, '.', '').'</td>
                    </tr>
                </tfoot>-->
            </table>
        </div>
    </body>
</html>';
?>