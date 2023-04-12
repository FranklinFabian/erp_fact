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
                    <td class="fontSize13px pl-5" width="55%">
                        <span>COOPERATIVA DE SERVICIOS ELECTRICOS TUPIZA LTDA</span><br>
                        TUPIZA - BOLIVIA<br><br>
                    </td>
                    <td class="textRight pr-5" width="45%">
                        <span class="fontSize14px bold">'.$titulo.'</span><br>
                        <span class="fontSize14px bold">SERVICIO DE: '.utf8_encode($nombre_servicio).'</span><br>
                        <span class="fontSize13px bold">CORRESPONDIENTE A: '.$mes_anio.'</span><br>
                        <span class="fontSize12px">'.date('d/m/Y H:i:s').'</span>
                    </td>
                </tr>
            </table>

            <table border="0" cellspacing="0" width="100%" class="fontSize10px mt-10">
                <thead class="border-top border-bottom">
                    <tr>
                        <th width="10%">CUENTA</th>
                        <th width="50%">DESCRIPCION</th>
                        <th width="20%" class="textRight">DEBE</th>
                        <th width="20%" class="textRight">HABER</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="fontSize4px" colspan="4">&nbsp;</td></tr>';
                    foreach($data_repo_contable as $rc):
                        $html.='
                        <tr>
                            <td>'.$rc->empleado.'</td>
                            <td>'.$rc->empleado.'</td>
                            <td class="textRight">'.$rm->recargo.'</td>
                            <td class="textRight">'.$rm->total.'</td>
                            <td>'.$rc->nota.'</td>
                        </tr>';
                    endforeach;
                    if(count($data_repo_contable) == 0):
                        $html.='
                            <tr class="textCenter">
                                <td colspan="4">Sin registros</td>
                            </tr>';
                    endif;
                    $html.='
                    <tr><td class="fontSize4px" colspan="4">&nbsp;</td></tr>
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