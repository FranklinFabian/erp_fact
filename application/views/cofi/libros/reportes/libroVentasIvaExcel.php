<?php
    date_default_timezone_set('America/La_Paz');
    # header para exportar en excel
    $tipo       = 'excel';
    $extension  = $tipo == 'excel' ? '.xls' : '.doc';
    $nombreExt  = 'Libro  de Ventas IVA - Periodo '.$periodoFiscal.' - Generado el '.date('d/m/Y H:i:s').$extension;
    header("Content-type: application/vnd.ms-$tipo"); /* Indica que tipo de archivo es que va a descargar */
    header("Content-Disposition: attachment; filename=$nombreExt"); /* El nombre del archivo y la extensiòn */
    header("Pragma: no-cache");
    header("Expires: 0");
?> 
<style>
    .textCenter12px{ text-align: center; font-size:12px;}
    .textLeft12px{ text-align: left; font-size:12px; }
    .textCenter10px{ text-align: center; font-size:11px;}
    .textRight10px{ text-align: right; font-size:11px; }
    .textLeft10px{ text-align: left; font-size:11px; }
    .borde4{ padding: 3px; border: 1px solid black;}
    .bold{ font-weight: bold; }
</style>
<table>
    <tr>
        <th colspan="12" class="textCenter12px">LIBRO DE VENTAS IVA</td>
    </tr>
    <tr>
        <th colspan="12" class="textCenter12px">PERIODO FISCAL: <?php echo $periodoFiscal; ?> </td>
    </tr>
    <tr>
        <th colspan="12" class="textCenter12px">(Expresado en Bolivianos)</td>
    </tr>
    <tr>
        <td colspan="6" class="textLeft12px"><span class="bold">RAZ&Oacute;N SOCIAL: </span><?php echo strtoupper($razonSocial); ?></td>
        <td colspan="3" class="textLeft12px"><span class="bold">NIT: </span><?php echo $numeroNIT; ?></td>
        <td colspan="3" class="textLeft12px"><span class="bold">FOLIO: </span><?php echo $numeroFolio; ?></td>
    </tr>
    <tr>
        <td colspan="6" class="textLeft12px"> <span class="bold">N&deg; SUCURSAL: </span><?php echo $nroSucursal; ?></td>
        <td colspan="6" class="textLeft12px"><span class="bold">DIRECCI&Oacute;N: </span><?php echo strtoupper($direccion); ?></td>
    </tr>
</table>
<table border="1" width="100%">
    <thead>
        <tr>
            <th width="8%" class="textCenter10px">N&deg; DE NIT/CI DEL COMPRADOR</th>
            <th width="25%" class="textCenter10px">NOMBRE O RAZ&Oacute;N SOCIAL DEL COMPRADOR</th>
            <th width="30%" class="textCenter10px">N&deg; DE FACTURA</th>
            <th class="textCenter10px">N&deg; DE AUTORIZACI&Oacute;N</th>
            <th class="textCenter10px">FECHA</th>
            <th class="textCenter10px">TOTAL FACTURA (A)</th>
            <th class="textCenter10px">TOTAL ICE (B)</th>
            <th class="textCenter10px">IMPORTE EXENTOS (C)</th>
            <th class="textCenter10px">IMPORTE NETO (A-B-C)</th>
            <th class="textCenter10px">D&Eacute;BITO FISCAL IVA</th>
            <th class="textCenter10px">ESTADO FACTURA</th>
            <th class="textCenter10px">C&Oacute;DIGO DE CONTROL</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i=1; $a1=0; $a2=0; $a3=0; $a4=0; $a5=0;
    if($dataLibroVentasIva != null):
        foreach($dataLibroVentasIva as $dlv):
    ?>
        <tr>
            <td class="textCenter10px"> <?php echo $i++;                                                    ?></td>
            <td class="textCenter10px"> <?php echo $dlv->dato;                                              ?></td>
            <td class="textCenter10px"> <?php echo $dlv->dato;                                              ?></td>
            <td class="textCenter10px"> <?php echo $dlv->dato;                                              ?></td>
            <td class="textCenter10px"> <?php echo $dlv->dato;                                              ?></td>
            <td class="textCenter10px"> <?php echo $dlv->dato;                                              ?></td>
            <td class="textCenter10px"> <?php echo $dlv->dato;                                              ?></td>
            <td class="textCenter10px"> <?php echo $dlv->dato;                                              ?></td>
            <td class="textCenter10px"> <?php echo $dlv->dato;                                              ?></td>
            <td class="textCenter10px"> <?php echo $dlv->dato;                                              ?></td>
            <td class="textCenter10px"> <?php echo $dlv->dato;                                              ?></td>
            <td class="textCenter10px"> <?php echo str_replace('.', ',', $dlv->dato);   $a5 += $dlv->dato;  ?></td>
        </tr>
    <?php                
        endforeach;
    else:
    ?>    
        <tr>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
            <td class="textCenter10px">No Existen Registros</td>
        </tr>
    <?php
    endif;
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="textLeft10px"><?php echo $ciResponsable;                      ?></td>   
            <td class="textLeft10px"><?php echo strtoupper($nombreResponsable);      ?></td>
            <th colspan="3" class="textLeft10px">TOTALES PARCIALES</th>
            <td class="textRight10px"><?php echo number_format($a1, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a2, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a3, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a4, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a5, 2); ?></td>
            <td class="textRight10px"> </td>
            <td class="textRight10px"> </td>
        </tr>
        <tr>
            <th class="textLeft10px">C.I.</th>
            <th class="textLeft10px">NOMBRE COMPLETO RESPONSABLE</th>
            <th colspan="3" class="textLeft10px">TOTALES GENERALES</th>
            <td class="textRight10px"><?php echo number_format($a1, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a2, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a3, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a4, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a5, 2); ?></td>
            <td class="textRight10px"> </td>
            <td class="textRight10px"> </td>
        </tr>
    </tfoot>
</table> 


