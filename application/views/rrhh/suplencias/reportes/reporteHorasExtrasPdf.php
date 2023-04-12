<?php $html = '
<html>
    <head>
        <title>'.$titulo.'</title>
        <style>
            @page { margin: 45px 45px 200px; } /* top left&right botoom*/
            #footer { position: fixed; left: 0px; bottom: -145px; right: 0px; height: 145px; background-color: white; }
            #cuadroGeneral { position: fixed; left: -4px; top: 0px; right: -4px; height: 952px; background-color: transparent; }
            body { font-family: "Helvetica"; }
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
            .proFondo{
                background: #EAB;
            }
        </style>
    </head>
    <body>
        <div>
            <table border="0" cellspacing="0" width="100%">
                <tr>
                    <td class="fontSize12px pl-5" width="56%">
                        <span>'.$this->empresa_nombre.'</span><br />
                        <span>'.$this->empresa_direccion.'</span><br /><br />
                        <strong>Empleado: </strong> '.utf8_encode($data_empleado->paterno.' '.$data_empleado->materno.' '.$data_empleado->nombre1.' '.$data_empleado->nombre2).'
                    </td>
                    <td class="textRight pr-5" width="44%">
                        <span class="fontSize13px bold">'.$titulo.'</span><br>
                        <span class="fontSize13px bold">CORRESPONDIENTE A: '.$mes_anio.'</span><br>
                        <span class="fontSize12px">'.date('d/m/Y H:i:s').'</span>
                    </td>
                </tr>
            </table>

            <table border="0" cellspacing="0" width="100%" class="fontSize13px mt-20">
                <thead class="border-top border-bottom">
                    <tr>
                        <th width="6%">NRO.</th>
                        <th width="11%">FECHA</th>
                        <th width="20%">MOTIVO</th>
                        <th width="9%">DESDE</th>
                        <th width="9%">HASTA</th>
                        <th width="9%">HORAS</th>
                        <th width="9%">DOBLES</th>
                        <th width="13%">NOCTURNAS</th>
                        <th width="14%">SUPERVISOR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="9">&nbsp;</td></tr>';
                    $total_horas        = 0;
                    $total_dobles       = 0;
                    $total_nocturnas    = 0;
                    foreach($data_registros_mensuales as $index => $rm):
                        $total_horas        += (double) $rm->sencillas;
                        $total_dobles       += (double) $rm->dobles;
                        $total_nocturnas    += (double) $rm->nocturnas;
                        $html.='
                        <tr>
                            <td>'.($index +1).'</td>
                            <td>'.date('d/m/Y', strtotime($rm->fecha)).'</td>
                            <td>'.$rm->motivo.'</td>
                            <td>'.$rm->desde.'</td>
                            <td>'.$rm->hasta.'</td>
                            <td>'.$rm->sencillas.'</td>
                            <td>'.$rm->dobles.'</td>
                            <td>'.$rm->nocturnas.'</td>
                            <td>'.$rm->jefe_tec.'</td>
                        </tr>';
                    endforeach;
                    if(count($data_registros_mensuales) == 0):
                        $html.='
                            <tr class="textCenter">
                                <td colspan="9">Sin registros</td>
                            </tr>';
                    endif;
                    $html.='
                    <tr><td colspan="9">&nbsp;</td></tr>
                </tbody>
                <tfoot class="border-top border-bottom">
                    <tr>
                        <td colspan="8" class="bold">TOTAL</td>
                        <td colspan="1" class="textRight"></td>
                    </tr>
                </tfoot>
            </table>
            
            <table border="0" cellspacing="0" width="50%" class="fontSize13px mt-20">
                <tr>
                    <th width="70%">TOTAL HORAS SENCILLAS</th>
                    <td width="30%">'.number_format($total_horas, 2, '.', '').'</td>  
                </tr>
                <tr>
                    <th width="70%">TOTAL HORAS DOBLES</th>
                    <td width="30%">'.number_format($total_dobles, 2, '.', '').'</td>  
                </tr>
                <tr>
                    <th width="70%">TOTAL HORAS NOCTURNAS</th>
                    <td width="30%">'.number_format($total_nocturnas, 2, '.', '').'</td>  
                </tr>
                <tr>
                    <th width="70%">RECARGO 30% HRS NOCTURNAS</th>
                    <td width="30%">'.number_format($total_nocturnas*0.3, 2, '.', '').'</td>  
                </tr>
                <tr>
                    <th width="70%">TOTAL HORAS EXTRAS</th>
                    <td width="30%">'.number_format($total_dobles+$total_nocturnas*0.3, 2, '.', '').'</td>  
                </tr>
            </table>
            <br><br><br>
            <table border="0" cellspacing="0" width="100%" class="fontSize13px mt-20">
                <tr>
                    <td>EMPLEADO</td>
                    <td>JEFE T&Eacute;CNICO</td>
                    <td>GERENTE GRAL</td>
                    <td>REVISADO POR</td>
                    <td>CONTADOR</td>
                </tr>
            </table>
        </div>
    </body>
</html>';
?>