<?php $html = '
<html>
    <head>
        <title>'.$titulo.'</title>
        <style>
            @page { margin: 30px 30px 30px; } /* top left&right botoom*/
            #footer { position: fixed; left: 0px; bottom: -145px; right: 0px; height: 145px; background-color: white; }
            #cuadroGeneral { position: fixed; left: -4px; top: 0px; right: -4px; height: 952px; background-color: transparent; }

            body { font-size:80%; font-family: "Helvetica";}

            .tamanioTitulo { font-size:100%; }
            .fontSize10px { font-size: 10px; }
            .fontSize11px { font-size: 11px; }
            .fontSize12px { font-size: 12px; }
            .fontSize13px { font-size: 13px; }
            .textCenter { text-align:center; }
            .textRight { text-align: right; }
            .subrrayar { text-decoration: underline; }
            .bold { font-weight: 600; }
            .borde4 { border: 1px solid #444; }
            .borde_tb { border-top: 1px solid #444; border-bottom: 1px solid #444; }
            .borde_t { border-top: 1px solid #444; }
            .pl-5 { padding-left: 5px; }
            .mt-10 { margin-top: 10px; }
            .mt-5 { margin-top: 5px; }
        </style>
    </head>
    <body>
        <div id="content">
            <table border="0" cellspacing="0" width="100%">
                <tr>
                    <td class="fontSize12px pl-5" width="55%">
                        <span>'.$this->empresa_nombre.'</span><br />
                        <span>'.$this->empresa_direccion.'</span><br /><br />
                    </td>
                    <td class="textRight pr-5" width="45%">
                        <span class="fontSize14px bold">'.$titulo.'</span><br>
                        <span class="fontSize14px bold">SERVICIO DE: '.utf8_encode($nombre_servicio).'</span><br>
                        <span class="fontSize13px bold">CORRESPONDIENTE A: '.$mes_anio.'</span><br>
                        <span class="fontSize12px">'.date('d/m/Y H:i:s').'</span>
                    </td>
                </tr>
            </table>

            <table border="0" cellspacing="0" width="100%" id="tabla_datos" class="fontSize10px mt-5">
                <thead class="borde_tb">
                    <tr>
                        <th width="6%">ITEM<br>&nbsp;</th>
                        <th width="20%">CARGO<br>&nbsp;</th>
                        <th width="25%"></th>
                        <th class="textRight">TOTAL GANADO<br>DIAS/MES 30</th>
                        <th class="textRight">APORTE<br>PATRONALES</th>
                        <th class="textRight">COSTO DIA<br>HRS/DIA 8</th>
                        <th class="textRight">COSTO<br>HORA</th>
                    </tr>
                </thead>
                <tbody>';
                    $this->seccion_empleado = 1;
                    $total_total_ganado     = 0;
                    $total_aportes_pat      = 0;
                    $total_costo_dia        = 0;
                    $tosal_costo_hora       = 0;
                    for($i=1; $i<count($data_secciones); $i++):
                        $this->seccion_empleado = $data_secciones[$i]->id;
                        $total_parcial_total_ganado     = 0;
                        $total_parcial_aportes_pat      = 0;
                        $total_parcial_costo_dia        = 0;
                        $tosal_parcial_costo_hora       = 0;

                        $html .='
                            <tr>
                                <td colspan="7" class="bold">'.$data_secciones[$i]->descripcion.'</td>
                            </tr>';
                        $empleados_seccion = array_filter($empleados_servicio_mes, function ($e) {
                            return $e->seccion_empleado == $this->seccion_empleado;
                        });

                        if(count($empleados_seccion) != 0):
                            foreach($empleados_seccion as $esm):
                                $aporte_patronal    = 0; # algo + algo2;
                                $costo_dia          = ($esm->total_ganado + $aporte_patronal)/30;
                                $costo_hora         = $costo_dia/8;
                                $total_parcial_total_ganado     += $esm->total_ganado;
                                $total_parcial_aportes_pat      += $aporte_patronal;
                                $total_parcial_costo_dia        += $costo_dia;
                                $tosal_parcial_costo_hora       += $costo_hora;

                                $html .='
                                <tr>
                                    <td>'.$esm->item.'</td>
                                    <td>'.utf8_encode($esm->cargo).'</td>
                                    <td>'.utf8_encode($esm->nombre_empleado).'</td>
                                    <td class="textRight">'.number_format($esm->total_ganado, 2, '.', ',').'</td>
                                    <td class="textRight">'.number_format($aporte_patronal, 2, '.', ',').'</td>
                                    <td class="textRight">'.number_format($costo_dia, 2, '.', ',').'</td>
                                    <td class="textRight">'.number_format($costo_hora, 2, '.', ',').'</td>
                                </tr>';
                            endforeach;
                        else:
                            $html.='
                                <tr class="textCenter">
                                    <td colspan="7">Sin Empleados</td>
                                </tr>';
                        endif;
                        $html.='
                            <tr>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class="textRight"><strong>'.number_format($total_parcial_total_ganado, 2, '.', '').'</strong></td>
                                <td class="textRight"><strong>'.number_format($total_parcial_aportes_pat, 2, '.', '').'</strong></td>
                                <td class="textRight"><strong>'.number_format($total_parcial_costo_dia, 2, '.', '').'</strong></td>
                                <td class="textRight"><strong>'.number_format($tosal_parcial_costo_hora, 2, '.', '').'</strong></td>
                            </tr>';
                        $total_total_ganado     += $total_parcial_total_ganado;
                        $total_aportes_pat      += $total_parcial_aportes_pat;
                        $total_costo_dia        += $total_parcial_costo_dia;
                        $tosal_costo_hora       += $tosal_parcial_costo_hora;
                    endfor;
                $html.='
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="textRight"><strong>'.number_format($total_total_ganado, 2, '.', '').'</strong></td>
                        <td class="textRight"><strong>'.number_format($total_aportes_pat, 2, '.', '').'</strong></td>
                        <td class="textRight"><strong>'.number_format($total_costo_dia, 2, '.', '').'</strong></td>
                        <td class="textRight"><strong>'.number_format($tosal_costo_hora, 2, '.', '').'</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>';
?>