<?php
list($a, $m, $d) = explode('-', $mes);
$mes_anio = strtolower(MONTH_NAMES[$m]) . '-' . $a;

$html = '
<html>
    <head>
        <title>PLANILLA DE SUELDOS Y SALARIOS</title>
        <style>
            @page { margin: 30px 30px 30px; } /* top left&right botoom*/
            #footer { position: fixed; left: 0px; bottom: -145px; right: 0px; height: 145px; background-color: white; }
            #cuadroGeneral { position: fixed; left: -4px; top: 0px; right: -4px; height: 952px; background-color: transparent; }

            body { font-size:80%; font-family: "Helvetica";}

            .tamanioTitulo { font-size:100%; }
            .fontSize10px { font-size: 10px; }
            .fontSize11px { font-size: 11px; }
            .fontSize12px { font-size: 12px; }
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
            #tabla_datos th { text-align: center; }
            .proFondo{
                background: #EAB;
            }
        </style>
    </head>
    <body>
        <div id="content">
            <table border="0" cellspacing="0" width="100%" id="tabla_cabecera">
                <tr>
                    <td class="fontSize11px textCenter" width="30%">
                        <span>'.$this->empresa_nombre.'</span><br>
                        <span>'.$this->empresa_direccion.'</span><br><br>
                    </td>
                    <td class="textCenter" width="40%">
                        <br><span class="tamanioTitulo bold">PLANILLA DE SUELDOS Y SALARIOS</span><br>
                        <span>Correspondiente al mes de: '.$mes_anio.'</span>
                    </td>
                    <td class="textRight fontSize11px" width="30%">'.date('d/m/Y H:i:s').'<br><br><br></td>
                </tr>
            </table>

            <table border="0" cellspacing="0" width="100%" id="tabla_datos" class="fontSize10px mt-5">
                <thead class="borde_tb">
                    <tr>
                        <th rowspan="2" colspan="2">Item</th>
                        <th rowspan="2" width="15%">Nombre y Apellidos</th>
                        <th rowspan="2" width="10%">Cargo</th>
                        <th rowspan="2">CID</th>
                        <th rowspan="2">Fecha Ingreso</th>
                        <th rowspan="2">D&iacute;as Trab.</th>
                        <th rowspan="2">Haber Mensual</th>
                        <th colspan="3" class="borde_tb">Reemplazo</th>
                        <th rowspan="2">Hrs. Extra</th>
                        <th rowspan="2">Importe Extras</th>
                        <th rowspan="2">Bono Antig.</th>
                        <th rowspan="2">Bono Front.</th>
                        <th rowspan="2">Total Ganado</th>
                        <th rowspan="2">AFP Individual</th>
                        <th rowspan="2">AFP Com.</th>
                        <th rowspan="2">AFP Comis.</th>
                        <th rowspan="2">Aporte Solidario</th>
                        <th rowspan="2">Rc_Iva</th>
                        <th rowspan="2">Club</th>
                        <th rowspan="2">Anticipo</th>
                        <th rowspan="2">Sancion</th>
                        <th rowspan="2">Otro Desc.</th>
                        <th rowspan="2">Total Desctos</th>
                        <th rowspan="2">Liquido Pagable</th>
                    </tr>
                    <tr>
                        <th>Item</th>
                        <th>D&iacute;as</th>
                        <th>Haber</th>
                    </tr>
                </thead>
                <tbody>';
                    $this->seccion_empleado = 1;
                    $total_haber_mensual    = 0;
                    $total_haber_reemplazo  = 0;
                    $total_importe_extras   = 0;
                    $total_bono_antiguedad  = 0;
                    $total_bono_frontera    = 0;
                    $total_total_ganado     = 0;
                    $total_afp_individual   = 0;
                    $total_afp_comun        = 0;
                    $total_afp_comision     = 0;
                    $total_sol_laboral      = 0;
                    $total_rc_iva           = 0;
                    $total_club             = 0;
                    $total_anticipo         = 0;
                    $total_sancion          = 0;
                    $total_otros_descuentos = 0;
                    $total_total_descuentos = 0;
                    $total_liquido_pagable  = 0;
                    foreach($data_secciones as $ds):
                        $this->seccion_empleado = $ds->id;
                        $total_parcial_haber_mensual    = 0;
                        $total_parcial_haber_reemplazo  = 0;
                        $total_parcial_importe_extras   = 0;
                        $total_parcial_bono_antiguedad  = 0;
                        $total_parcial_bono_frontera    = 0;
                        $total_parcial_total_ganado     = 0;
                        $total_parcial_afp_individual   = 0;
                        $total_parcial_afp_comun        = 0;
                        $total_parcial_afp_comision     = 0;
                        $total_parcial_sol_laboral      = 0;
                        $total_parcial_rc_iva           = 0;
                        $total_parcial_club             = 0;
                        $total_parcial_anticipo         = 0;
                        $total_parcial_sancion          = 0;
                        $total_parcial_otros_descuentos = 0;
                        $total_parcial_total_descuentos = 0;
                        $total_parcial_liquido_pagable  = 0;

                        $html .='
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="26" class="bold">'.$ds->descripcion.'</td>
                            </tr>';
                        $empleados_seccion = array_filter($empleados_servicio_mes, function ($e) {
                            return $e->seccion_empleado == $this->seccion_empleado;
                        });

                        foreach($empleados_seccion as $esm):
                            $total_parcial_haber_mensual    += $esm->haber_mensual;
                            $item_reemplazo                 = ($esm->item_reemplazo != 0) ? $esm->item_reemplazo:'';
                            $dias_reemplazo                 = ($esm->dias_reemplazo > 0) ? $esm->dias_reemplazo:'';
                            $haber_reemplazo                = ($esm->haber_reemplazo > 0) ? number_format($esm->haber_reemplazo, 2, '.', ','):'';
                            $total_parcial_haber_reemplazo  += $esm->haber_reemplazo;
                            $total_parcial_importe_extras   += $esm->haber_extras;
                            $total_parcial_bono_antiguedad  += $esm->bono_antiguedad;
                            $total_parcial_bono_frontera    += $esm->bono_frontera;
                            $total_parcial_total_ganado     += $esm->total_ganado;
                            $total_parcial_afp_individual   += $esm->afp_individual;
                            $total_parcial_afp_comun        += $esm->afp_comun;
                            $total_parcial_afp_comision     += $esm->afp_comision;
                            $total_parcial_sol_laboral      += $esm->sol_laboral;
                            $total_parcial_rc_iva           += $esm->rc_iva;
                            $total_parcial_club             += $esm->club;
                            $total_parcial_anticipo         += $esm->anticipo;
                            $total_parcial_sancion          += $esm->sancion;
                            $total_parcial_otros_descuentos += $esm->fondo_rotativo + $esm->otros_descuentos; # alguno otro caso similar ?
                            $total_parcial_total_descuentos += $esm->total_descuentos;
                            $total_parcial_liquido_pagable  += $esm->liquido_pagable;

                            $html .='
                            <tr>
                                <td>&nbsp;</td>
                                <td class="textRight">'.$esm->item.'</td>
                                <td>'.$esm->nombre_empleado.'</td>
                                <td>'.$esm->cargo.'</td>
                                <td class="textRight">'.$esm->cid_empleado.'</td>
                                <td class="textRight">'.date('d/m/Y', strtotime($esm->fecha_ingreso)).'</td>
                                <td class="textRight">'.$esm->dias_trabajados.'</td>
                                <td class="textRight">'.number_format($esm->haber_mensual, 2, '.', ',').'</td>
                                <td class="textRight">'.$item_reemplazo.'</td>
                                <td class="textRight">'.$dias_reemplazo.'</td>
                                <td class="textRight">'.$haber_reemplazo.'</td>
                                <td class="textRight">'.number_format($esm->horas_extras, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->haber_extras, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->bono_antiguedad, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->bono_frontera, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->total_ganado, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->afp_individual, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->afp_comun, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->afp_comision, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->sol_laboral, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->rc_iva, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->club, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->anticipo, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->sancion, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->fondo_rotativo+$esm->otros_descuentos, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->total_descuentos, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($esm->liquido_pagable, 2, '.', ',').'</td>
                            </tr>';
                        endforeach;
                        if(count($empleados_seccion) == 0):
                            $html.='
                                <tr class="textCenter">
                                    <td colspan="26">Sin Empleados</td>
                                </tr>';
                        endif;
                        $html.='
                            <tr>
                                <td></td>
                                <td colspan="6" class="borde_t"></td>
                                <td class="textRight borde_t">'.number_format($total_parcial_haber_mensual, 2, '.', '').'</td>
                                <td class="borde_t"></td>
                                <td class="borde_t"></td>
                                <td class="textRight borde_t">'.number_format($total_parcial_haber_reemplazo, 2, '.', '').'</td>
                                <td class="borde_t"></td>
                                <td class="textRight borde_t">'.number_format($total_parcial_importe_extras, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_bono_antiguedad, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_bono_frontera, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_total_ganado, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_afp_individual, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_afp_comun, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_afp_comision, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_sol_laboral, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_rc_iva, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_club, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_anticipo, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_sancion, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_otros_descuentos, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_total_descuentos, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_liquido_pagable, 2, '.', '').'</td>
                            </tr>';
                        $total_haber_mensual    += $total_parcial_haber_mensual;
                        $total_haber_reemplazo  += $total_parcial_haber_reemplazo;
                        $total_importe_extras   += $total_parcial_importe_extras;
                        $total_bono_antiguedad  += $total_parcial_bono_antiguedad;
                        $total_bono_frontera    += $total_parcial_bono_frontera;
                        $total_total_ganado     += $total_parcial_total_ganado;
                        $total_afp_individual   += $total_parcial_afp_individual;
                        $total_afp_comun        += $total_parcial_afp_comun;
                        $total_afp_comision     += $total_parcial_afp_comision;
                        $total_sol_laboral      += $total_parcial_sol_laboral;
                        $total_rc_iva           += $total_parcial_rc_iva;
                        $total_club             += $total_parcial_club;
                        $total_anticipo         += $total_parcial_anticipo;
                        $total_sancion          += $total_parcial_sancion;
                        $total_otros_descuentos += $total_parcial_otros_descuentos;
                        $total_total_descuentos += $total_parcial_total_descuentos;
                        $total_liquido_pagable  += $total_parcial_liquido_pagable;
                    endforeach;
                $html.='
                </tbody>
                <tfoot class="borde_t">
                    <tr>
                        <td></td>
                        <td colspan="6" class="borde_t"></td>
                        <td class="textRight borde_t">'.number_format($total_haber_mensual, 2, '.', '').'</td>
                        <td class="borde_t"></td>
                        <td class="borde_t"></td>
                        <td class="textRight borde_t">'.number_format($total_haber_reemplazo, 2, '.', '').'</td>
                        <td class="borde_t"></td>
                        <td class="textRight borde_t">'.number_format($total_importe_extras, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_bono_antiguedad, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_bono_frontera, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_total_ganado, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_afp_individual, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_afp_comun, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_afp_comision, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_sol_laboral, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_rc_iva, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_club, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_anticipo, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_sancion, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_otros_descuentos, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_total_descuentos, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_liquido_pagable, 2, '.', '').'</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>';
?>