<?php
list($a, $m, $d) = explode('-', $mes);
$mes_anio = strtolower(MONTH_NAMES[$m]) . '-' . $a;

$html = '
<html>
    <head>
        <title>PLANILLA TRIBUTARIA</title>
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
                        <br><span class="tamanioTitulo bold">PLANILLA TRIBUTARIA</span><br>
                        <span>Correspondiente al mes de: '.$mes_anio.'</span>
                    </td>
                    <td class="textRight fontSize11px" width="30%">'.date('d/m/Y H:i:s').'<br><br><br></td>
                </tr>
            </table>

            <table border="0" cellspacing="0" width="100%" id="tabla_datos" class="fontSize10px mt-5">
                <thead class="borde_tb">
                    <tr>
                        <th rowspan="2" colspan="2">Item</th>
                        <th rowspan="2" width="15%">Nombres</th>
                        <th rowspan="2">Total Ganado</th>
                        <th rowspan="2">Otros Ingresos</th>
                        <th rowspan="2">Afp</th>
                        <th rowspan="2">Sueldo neto</th>
                        <th rowspan="2">Min. No Imponible</th>
                        <th rowspan="2">Diferencia Suj. Imp.</th>
                        <th rowspan="2">Impuesto IVA</th>
                        <th rowspan="2">Form 101</th>
                        <th rowspan="2">13% / Dos Min</th>
                        <th colspan="2">Saldo a Favor</th>
                        <th rowspan="2">Saldo Anterior</th>
                        <th rowspan="2">Manteni-miento</th>
                        <th rowspan="2">Total Actualiza</th>
                        <th rowspan="2">Total Depend.</th>
                        <th rowspan="2">Saldo Utilizado</th>
                        <th rowspan="2">Saldo Retenido</th>
                        <th rowspan="2">Saldo Mes_Sig.</th>
                    </tr>
                    <tr>
                        <th>Fisco</th>
                        <th>Depend.</th>
                    </tr>

                </thead>
                <tbody>';
                    $this->seccion_empleado = 1;
                    $total_total_ganado     = 0;
                    $total_otros_ingresos   = 0;
                    $total_afp              = 0;
                    $total_sueldo_neto      = 0;
                    $total_min_no_imponible = 0;
                    $total_dif_suj_imp      = 0;
                    $total_impuesto_iva     = 0;
                    $total_form_101         = 0;
                    $total_p13_dos_min      = 0;
                    $total_sal_fav_fisco    = 0;
                    $total_sal_fav_depend   = 0;
                    $total_saldo_anterior   = 0;
                    $total_mantenimiento    = 0;
                    $total_total_actualiza  = 0;
                    $total_total_depend     = 0;
                    $total_saldo_utilizado  = 0;
                    $total_saldo_retenido   = 0;
                    $total_saldo_mes_sig    = 0;

                    foreach($data_secciones as $ds):
                        $this->seccion_empleado = $ds->id;
                        $total_parcial_total_ganado     = 0;
                        $total_parcial_otros_ingresos   = 0;
                        $total_parcial_afp              = 0;
                        $total_parcial_sueldo_neto      = 0;
                        $total_parcial_min_no_imponible = 0;
                        $total_parcial_dif_suj_imp      = 0;
                        $total_parcial_impuesto_iva     = 0;
                        $total_parcial_form_101         = 0;
                        $total_parcial_p13_dos_min      = 0;
                        $total_parcial_sal_fav_fisco    = 0;
                        $total_parcial_sal_fav_depend   = 0;
                        $total_parcial_saldo_anterior   = 0;
                        $total_parcial_mantenimiento    = 0;
                        $total_parcial_total_actualiza  = 0;
                        $total_parcial_total_depend     = 0;
                        $total_parcial_saldo_utilizado  = 0;
                        $total_parcial_saldo_retenido   = 0;
                        $total_parcial_saldo_mes_sig    = 0;
                        $html .='
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="19" class="bold">'.$ds->descripcion.'</td>
                            </tr>';
                        $empleados_seccion = array_filter($empleados_servicio_mes, function ($e) {
                            return $e->seccion_empleado == $this->seccion_empleado;
                        });

                        foreach($empleados_seccion as $esm):
                            # Se generar todos los campos de la tabla (sumas y restas de valores correspondientes)
                            $total_ganado       = $esm->total_ganado;       # TOTAL GANADO
                            $otros_ingresos     = $esm->afp_individual;     # OTROS INGRESOS
                            $afp                = $esm->afp_comun;          # AFP
                            $sueldo_neto        = $esm->afp_comision;       # SUELDO NETO
                            $min_no_imponible   = $esm->sol_laboral;        # MIN NO IMPONIBLE
                            $dif_suj_imp        = $esm->rc_iva;             # DIFERENCIA SUJ IMP
                            $impuesto_iva       = $esm->club;               # IMPUESTO IVA
                            $form_101           = $esm->anticipo;           # FORM 101
                            $p13_dos_min        = $esm->sancion;            # 13% / DOS MIN
                            $sal_fav_fisco      = $esm->fondo_rotativo;     # SALDO FAVOR FISCO
                            $sal_fav_depend     = $esm->total_descuentos;   # SALDO FAVOR DEPEND
                            $saldo_anterior     = $esm->liquido_pagable;    # SALDO ANTERIOR
                            $mantenimiento      = $esm->liquido_pagable;    # MANTENIMIENTO
                            $total_actualiza    = $esm->liquido_pagable;    # TOTAL ACTUALIZA
                            $total_depend       = $esm->liquido_pagable;    # TOTAL DEPEND
                            $saldo_utilizado    = $esm->liquido_pagable;    # SALDO UTILIZADO
                            $saldo_retenido     = $esm->liquido_pagable;    # SALDO RETENIDO
                            $saldo_mes_sig      = $esm->liquido_pagable;    # SALDO MES SIG

                            # Acumulando totales parciales - por sección
                            $total_parcial_total_ganado     += $total_ganado;
                            $total_parcial_otros_ingresos   += $otros_ingresos;
                            $total_parcial_afp              += $afp;
                            $total_parcial_sueldo_neto      += $sueldo_neto;
                            $total_parcial_min_no_imponible += $min_no_imponible;
                            $total_parcial_dif_suj_imp      += $dif_suj_imp;
                            $total_parcial_impuesto_iva     += $impuesto_iva;
                            $total_parcial_form_101         += $form_101;
                            $total_parcial_p13_dos_min      += $p13_dos_min;
                            $total_parcial_sal_fav_fisco    += $sal_fav_fisco;
                            $total_parcial_sal_fav_depend   += $sal_fav_depend;
                            $total_parcial_saldo_anterior   += $saldo_anterior;
                            $total_parcial_mantenimiento    += $mantenimiento;
                            $total_parcial_total_actualiza  += $total_actualiza;
                            $total_parcial_total_depend     += $total_depend;
                            $total_parcial_saldo_utilizado  += $saldo_utilizado;
                            $total_parcial_saldo_retenido   += $saldo_retenido;
                            $total_parcial_saldo_mes_sig    += $saldo_mes_sig;

                            $html .='
                            <tr>
                                <td>&nbsp;</td>
                                <td class="textRight">'.$esm->item.'</td>
                                <td>'.$esm->nombre_empleado.'</td>
                                <td class="textRight">'.number_format($total_ganado, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($otros_ingresos, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($afp, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($sueldo_neto, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($min_no_imponible, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($dif_suj_imp, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($impuesto_iva, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($form_101, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($p13_dos_min, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($sal_fav_fisco, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($sal_fav_depend, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($saldo_anterior, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($mantenimiento, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($total_actualiza, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($total_depend, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($saldo_utilizado, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($saldo_retenido, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($saldo_mes_sig, 2, '.', ',').'</td>
                            </tr>';
                        endforeach;
                        if(count($empleados_seccion) == 0):
                            $html.='
                                <tr class="textCenter">
                                    <td colspan="21">Sin Empleados</td>
                                </tr>';
                        endif;
                        $html.='
                            <tr>
                                <td></td>
                                <td colspan="2" class="borde_t"></td>
                                <td class="textRight borde_t">'.number_format($total_parcial_total_ganado, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_otros_ingresos, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_afp, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_sueldo_neto, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_min_no_imponible, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_dif_suj_imp, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_impuesto_iva, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_form_101, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_p13_dos_min, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_sal_fav_fisco, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_sal_fav_depend, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_saldo_anterior, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_mantenimiento, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_total_actualiza, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_total_depend, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_saldo_utilizado, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_saldo_retenido, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_saldo_mes_sig, 2, '.', '').'</td>
                            </tr>';
                        $total_total_ganado     += $total_parcial_total_ganado;
                        $total_otros_ingresos   += $total_parcial_otros_ingresos;
                        $total_afp              += $total_parcial_afp;
                        $total_sueldo_neto      += $total_parcial_sueldo_neto;
                        $total_min_no_imponible += $total_parcial_min_no_imponible;
                        $total_dif_suj_imp      += $total_parcial_dif_suj_imp;
                        $total_impuesto_iva     += $total_parcial_impuesto_iva;
                        $total_form_101         += $total_parcial_form_101;
                        $total_p13_dos_min      += $total_parcial_p13_dos_min;
                        $total_sal_fav_fisco    += $total_parcial_sal_fav_fisco;
                        $total_sal_fav_depend   += $total_parcial_sal_fav_depend;
                        $total_saldo_anterior   += $total_parcial_saldo_anterior;
                        $total_mantenimiento    += $total_parcial_mantenimiento;
                        $total_total_actualiza  += $total_parcial_total_actualiza;
                        $total_total_depend     += $total_parcial_total_depend;
                        $total_saldo_utilizado  += $total_parcial_saldo_utilizado;
                        $total_saldo_retenido   += $total_parcial_saldo_retenido;
                        $total_saldo_mes_sig    += $total_parcial_saldo_mes_sig;
                    endforeach;
                $html.='
                </tbody>
                <tfoot class="borde_t">
                    <tr>
                        <td></td>
                        <td colspan="2" class="borde_t"></td>
                        <td class="textRight borde_t">'.number_format($total_total_ganado, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_otros_ingresos, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_afp, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_sueldo_neto, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_min_no_imponible, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_dif_suj_imp, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_impuesto_iva, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_form_101, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_p13_dos_min, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_sal_fav_fisco, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_sal_fav_depend, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_saldo_anterior, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_mantenimiento, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_total_actualiza, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_total_depend, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_saldo_utilizado, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_saldo_retenido, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_saldo_mes_sig, 2, '.', '').'</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>';
?>