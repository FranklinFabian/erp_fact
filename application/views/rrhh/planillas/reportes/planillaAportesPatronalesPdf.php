<?php
list($a, $m, $d) = explode('-', $mes);
$mes_anio = strtolower(MONTH_NAMES[$m]) . '-' . $a;

$html = '
<html>
    <head>
        <title>Planilla de Aportes Patronales</title>
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
                        <br><span class="tamanioTitulo bold">PLANILLA DE APORTES PATRONALES</span><br>
                        <span>Correspondiente al mes de: '.$mes_anio.'</span>
                    </td>
                    <td class="textRight fontSize11px" width="30%">'.date('d/m/Y H:i:s').'<br><br><br></td>
                </tr>
            </table>

            <table border="0" cellspacing="0" width="100%" id="tabla_datos" class="fontSize10px mt-5">
                <thead class="borde_tb">
                    <tr>
                        <th colspan="2">Item</th>
                        <th>Nombre</th>
                        <th>Cargo</th>
                        <th>Cns</th>
                        <th>Afp</th>
                        <th>Fonvis</th>
                        <th>Solidaridad</th>
                        <th>Aguinaldo</th>
                        <th>Aguinaldo2</th>
                        <th>Indemn.</th>
                        <th>Prima</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>';
                    $this->seccion_empleado = 1;
                    $total_cns          = 0;
                    $total_afp          = 0;
                    $total_fonvis       = 0;
                    $total_solidaridad  = 0;
                    $total_aguinaldo    = 0;
                    $total_aguinaldo2   = 0;
                    $total_indemn       = 0;
                    $total_prima        = 0;
                    $total_total        = 0;

                    foreach($data_secciones as $ds):
                        $this->seccion_empleado = $ds->id;
                        $total_parcial_cns          = 0;
                        $total_parcial_afp          = 0;
                        $total_parcial_fonvis       = 0;
                        $total_parcial_solidaridad  = 0;
                        $total_parcial_aguinaldo    = 0;
                        $total_parcial_aguinaldo2   = 0;
                        $total_parcial_indemn       = 0;
                        $total_parcial_prima        = 0;
                        $total_parcial_total        = 0;

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
                            $cns            = $esm->total_ganado;       # cns
                            $afp            = $esm->afp_individual;     # afp
                            $fonvis         = $esm->afp_comun;          # fonvis
                            $solidaridad    = $esm->afp_comision;       # solidaridad
                            $aguinaldo      = $esm->sol_laboral;        # aguinaldo
                            $aguinaldo2     = $esm->rc_iva;             # aguinaldo2
                            $indemn         = $esm->club;               # indemn
                            $prima          = $esm->anticipo;           # prima
                            $total          = $esm->sancion;            # total

                            # Acumulando totales parciales - por sección
                            $total_parcial_cns          += $cns;
                            $total_parcial_afp          += $afp;
                            $total_parcial_fonvis       += $fonvis;
                            $total_parcial_solidaridad  += $solidaridad;
                            $total_parcial_aguinaldo    += $aguinaldo;
                            $total_parcial_aguinaldo2   += $aguinaldo2;
                            $total_parcial_indemn       += $indemn;
                            $total_parcial_prima        += $prima;
                            $total_parcial_total        += $total;

                            $html .='
                            <tr>
                                <td>&nbsp;</td>
                                <td class="textRight">'.$esm->item.'</td>
                                <td>'.$esm->nombre_empleado.'</td>
                                <td>'.$esm->cargo.'</td>
                                <td class="textRight">'.number_format($cns, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($afp, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($fonvis, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($solidaridad, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($aguinaldo, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($aguinaldo2, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($indemn, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($prima, 2, '.', ',').'</td>
                                <td class="textRight">'.number_format($total, 2, '.', ',').'</td>
                            </tr>';
                        endforeach;
                        if(count($empleados_seccion) == 0):
                            $html.='
                                <tr class="textCenter">
                                    <td colspan="13">Sin Empleados</td>
                                </tr>';
                        endif;
                        $html.='
                            <tr>
                                <td></td>
                                <td colspan="3" class="borde_t"></td>
                                <td class="textRight borde_t">'.number_format($total_parcial_cns, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_afp, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_fonvis, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_solidaridad, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_aguinaldo, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_aguinaldo2, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_indemn, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_prima, 2, '.', '').'</td>
                                <td class="textRight borde_t">'.number_format($total_parcial_total, 2, '.', '').'</td>
                            </tr>';
                        $total_cns          += $total_parcial_cns;
                        $total_afp          += $total_parcial_afp;
                        $total_fonvis       += $total_parcial_fonvis;
                        $total_solidaridad  += $total_parcial_solidaridad;
                        $total_aguinaldo    += $total_parcial_aguinaldo;
                        $total_aguinaldo2   += $total_parcial_aguinaldo2;
                        $total_indemn       += $total_parcial_indemn;
                        $total_prima        += $total_parcial_prima;
                        $total_total        += $total_parcial_total;
                    endforeach;
                $html.='
                </tbody>
                <tfoot class="borde_t">
                    <tr>
                        <td></td>
                        <td colspan="3" class="borde_t"></td>
                        <td class="textRight borde_t">'.number_format($total_cns, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_afp, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_fonvis, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_solidaridad, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_aguinaldo, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_aguinaldo2, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_indemn, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_prima, 2, '.', '').'</td>
                        <td class="textRight borde_t">'.number_format($total_total, 2, '.', '').'</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>';
?>