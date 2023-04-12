<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta content="Ozz" name="author" />
    <title><?php echo $title;?></title>
    <style>
    body {
        font-size: 6px;
        font-family: "Tahoma", "Verdana", "Segoe", "sans-serif";
    }
    .redondo table {
    border-collapse:separate;
    border:solid black 1px;
    border-radius:6px;
    -moz-border-radius:6px;
    }

    .redondo-rayas table {
    border-collapse:separate;
    border:solid black 1px;
    border-radius:6px;
    -moz-border-radius:6px;
    }

    .redondo-rayas td, th {
        border:solid #888 1px;
        
    }
    </style>
<script>
    function imprimir(){
        //window.print();
    }
    function cerrar(){
        //window.close();
    }
    setTimeout(cerrar, 5000);
</script>

</head>
        
<body onload="imprimir()">

    <!-- Cabecera -->
    <table width="100%" border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td width=50%>
                <table width="100%" border=0 cellspacing=0 cellpadding=0>
                    <tr>
                        <td align="center"> <img src="<?php echo base_url()?>public/img/logo.png" alt="" height="30"> </td>
                    </tr>
                    <!--<tr>
                        <td align="center"><strong><?php echo $configuracion['logo_linea1'];?></strong></td>
                    </tr>-->
                    <tr>
                        <td align="center">
                                <?php 
                                    echo '<br><strong>CASA MATRIZ</strong>';
                                    echo '<br>N° PUNTO DE VENTA 0';//.$punto_venta['codigo_punto_venta'];
                                    echo '<br>Dirección:  '.$this->config->item('direccion');
                                    echo '<br>Teléfono:  '.$this->config->item('telefono');;
                                    echo '<br>'.$this->config->item('municipio');
                                ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td width=15%> </td>
            <td width=35% class="" style="text-align:center">
                <span style="font-weight:bold; font-size:12px;">N° <?php echo $lectura['idlectura'];?></span><br><br>
                <table width="100%" border=0 cellspacing=0 cellpadding=2>
                    <tr>
                        <td style="width: 50%; text-align:left"><strong>NIT:</strong></td> <td style="width: 50%; text-align:left"><?php echo $this->config->item('nit');?></td>
                    </tr>
                    <tr>
                        <td style="width: 50%; text-align:left"><strong>FACTURA N°:</strong></td> <td style="width: 50%; text-align:left"><?php echo $factura['nro_fact'];//$factura['nro_fact'];?></td>
                    </tr>
                    <tr>
                        <td style="width: 50%; text-align:left"><strong>CÓD. AUTORIZACIÓN:</strong></td> <td style="width: 50%; text-align:left"><?php echo $factura['cuf'];//substr($factura['cuf'],0,17).'<br>'.substr($factura['cuf'],17,17).'<br>'.substr($factura['cuf'],34,17).'<br>'.substr($factura['cuf'],51).'<br>';?></td>
                    </tr>
                </table>
            </td>
        </tr>
        
    </table>
    <!-- fin cabecera -->

    <p></p>

    <!-- CABECERA -->
    <table width="100%" border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td align="center"><strong style="font-size: 12px;">FACTURA</strong><br>(Con Derecho a Crédito Fiscal)</td>
        </tr>
    </table>
    
    <!-- FIN CABECERA -->

    <!-- DATOS CLIENTE -->
    <div class="redondo">
    <table width="100%" border=0 cellspacing=0 cellpadding=2>
        <?php //$cliente = $this->cliente_model->get_cliente($datos['idcliente']);?>
        <tr>
            <td width="70%"> <strong>FECHA: </strong> <?php echo (substr($factura['fecha_emision'], 0,10)).' Hr.:'.substr($factura['fecha_emision'], 11,8); ?></td>
            <td width="30%"> <strong>NIT/CI/CEX: </strong>
                <?php
                    $nro_doc = NULL;
                    switch ($cliente['tipo_doc_fact']) {
                      case '1': $nro_doc = $cliente['ci']; break;
                      case '2': $nro_doc = $cliente['cex']; break;
                      case '3': $nro_doc = $cliente['pas']; break;
                      case '4': $nro_doc = $cliente['od']; break;
                      case '5': $nro_doc = $cliente['nit']; break;
                      default:  $nro_doc = $cliente['ci']; break;
                    }
                    if ($nro_doc == '0')
                        $nro_doc = 99002;
                    echo $nro_doc;
                ?>
            </td>
        </tr>
        <tr>
            <td width="70%"> <strong>NOMBRE/RAZÓN SOCIAL: </strong>
                <?php
                    if($nro_doc==99002)
                        echo 'Control Tributario';
                    else
                        echo $cliente['razon_social'];
                ?>
            </td>
            <td width="30%"> <strong>COD. CLIENTE: </strong><?php echo $cliente['idcliente'];?></td>
        </tr>
        <tr>
            <td width="70%"> <strong>DIRECCIÓN: </strong> <?php echo $direccion_abonado['zona'].' '.$direccion_abonado['calle'];?></td>
            <td width="30%"> <strong>PERIODO FACTURADO: </strong><?php echo substr(($periodo['emision']),3);?></td>
        </tr>
        <tr>
            <td width="70%"> <strong>DIAS DE CONSUMO: </strong> <?php echo $lectura['kwh'];?></td>
            <td width="30%"> <strong></strong><?php //echo $abonado['medidor'];?></td>
        </tr>
    </table>
    </div>
    <!-- FIN DATOS CLIENTE -->
    

    <!-- DATOS PRODUCTOS/SERVICIOS -->
    <div class="redondo-rayas">
    <table width="100%" border=1 cellspacing=0 cellpadding=0>
        <tr>
            <td width=5%><strong>CÓDIGO PRODUCTO/<br>SERVICIO</strong></td>
            <td width=8%><strong>CANTIDAD</strong></td>
            <td width=14%><strong>UNIDAD DE MEDIDA</strong></td>
            <td width=35%><strong>DESCRIPCIÓN</strong></td>

            <td width=12%><strong>PRECIO UNITARIO</strong></td>
            <td width=12%><strong>DESCUENTO</strong></td>
            <td width=13%><strong>SUB TOTAL</strong></td>
        </tr>
        <?php
        $msjMostrar='';

        $msjMostrarDetalle= '';
        $total_cobrar = ($lectura['imp_total']+$lectura['conexion']+$lectura['reposicion']+$lectura['recargo']+$lectura['aseo']+$lectura['alumbrado']+$lectura['afcoop']-$lectura['ley1886']-$lectura['dignidad']-$lectura['devolucion']-$lectura['desdom']-$lectura['desap']-$lectura['desau']-$lectura['desafcoop']);
        $total_iva = ($lectura['imp_total']+$lectura['conexion']+$lectura['reposicion']-$lectura['ley1886']-$lectura['dignidad']-$lectura['devolucion']-$lectura['desdom']);
        
        $total_sin_iva = ($lectura['aseo']+$lectura['alumbrado']+$lectura['afcoop']+$lectura['devolucion']+$lectura['recargo']);
        $total_consumo = ($lectura['imp_total']+$lectura['conexion']+$lectura['reposicion']+$lectura['recargo']);
        $consumo_periodo = ($lectura['imp_total']-$lectura['devolucion']);
        $ajustes_sujetos_iva=($lectura['conexion']+$lectura['reposicion']);
        $t_tasas = ($lectura['aseo']+$lectura['alumbrado']);        

        // 1RA Linea de la factura POR CONSUMO      
        $msjMostrarDetalle.= '<tr><td>6161</td><td>1</td><td align=left>UNIDAD (SERVICIOS)</td><td>CONSUMO TV CABLE</td><td align="right">'.number_format($consumo_periodo,2,',','.').'</td><td align="right">'.number_format($lectura['devolucion'], 2, ',','.').'</td><td align="right">'.number_format($consumo_periodo-$lectura['imp_poten']-$lectura['imp_penal'] ,2,',','.').'</td>';
        if($lectura['imp_poten']>0){
            $msjMostrarDetalle.= '<tr><td>1</td><td>1</td><td align=left>UNIDAD (SERVICIOS)</td><td>POTENCIA</td><td align="right">'.number_format($lectura['imp_poten'],2,',','.').'</td><td align="right">0,00</td><td align="right">'.number_format($lectura['imp_poten'],2,',','.').'</td>';
        }
        // 2da Linea si hay penalizacion
        if($lectura['imp_penal']>0){
            $msjMostrarDetalle.= '<tr><td>1</td><td>1</td><td align=left>UNIDAD (SERVICIOS)</td><td>IMPORTE PENAL</td><td align="right">'.number_format($lectura['imp_penal'],2,',','.').'</td><td align="right">0,00</td><td align="right">'.number_format($lectura['imp_penal'],2,',','.').'</td>';
        }


        $msjMostrarDetalle.= '</tr>';        
        
        if($ajustes_sujetos_iva>0)
            $msjMostrarDetalle.= '<tr> <td colspan="3"></td> <td>RECONEXIÓN</td> <td></td> <td></td> <td align="right">'.number_format($ajustes_sujetos_iva,2,',','.').'</td> </tr>';
        
        //fracion
        $bs = floor($total_cobrar); // 1 $fraction = $total_cobrar - $bs; // .25
        $centavos = (($total_cobrar) - $bs)*100;

        $msjMostrarDetalle.= '
        
            <tr><td colspan="4"> </td><td colspan="2" align="right">SUB TOTAL Bs</td><td align="right">'.number_format((float)($total_cobrar), 2, ',', '.').'</td></tr>
            <tr><td colspan="4"> </td> <td colspan="2" align="right">(-) DESCUENTO Bs</td><td align="right">'.number_format((float)($lectura['devolucion']), 2, ',', '.').'</td></tr>
            <tr><td colspan="4"> </td> <td colspan="2" align="right">TOTAL Bs</td><td align="right"><strong>'.number_format((float)($total_cobrar), 2, ',', '.').'</strong></td></tr>
            <tr><td colspan="4"> </td> <td colspan="2" align="right">MONTO GIFT CARD Bs</td><td align="right">0,00</td></tr>
            <tr><td colspan="4"><strong>SON:</strong> '.$this->numeroaletras->convertir(($total_cobrar - $lectura['devolucion']),).' '.($centavos==0?'00':round($centavos,2)).'/100 Bolivianos</td> <td colspan="2" align="right"><strong>MONTO TOTAL A PAGAR Bs</strong></td><td align="right"><strong>'.number_format((float)($total_cobrar), 2, ',', '.').'</strong></td></tr>
            <tr><td colspan="4"> </td> <td colspan="2" align="right"><strong>IMPORTE BASE CRÉDITO FISCAL Bs</strong></td><td align="right"><strong>'.number_format((float)($total_cobrar - $total_sin_iva), 2, ',', '.').'</strong></td></tr>
        ';
    
        echo $msjMostrarDetalle;
        ?>
    </table>
    </div>
    <!-- FIN DATOS PRODUCTOS/SERVICIOS -->

    <!-- DATOS COD CONTROL, QR -->
    <table border="0" width="100%" cellspacing=0 cellpadding=2>
        <tr>
            <td width="85%" align="center">
                <p>ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY</p>
                <?php
                    echo '<p>'.$factura['leyenda_fact'].'</p>';
                ?>
                <?php
                    echo '<p>"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea"</p>';
                    // f($factura['tipo_emision']=='1')
                    //     echo '<p>"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea"</p>';
                    // else
                    //     echo '<p>"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido fuera de línea, verifique su envío con su proveedor o en la página web www.impuestos.gob.bo"</p>';
                ?>
            </td>
            <td width="15%" align="right">
                <?php
                    //QR
                    $this->load->library('ciqrcode');
                    $params['data'] = $this->config->item('url_qr').'nit='.$this->config->item('nit').'&cuf='.($factura['cuf']).'&numero='.$factura['nro_fact'].'&t='.$this->config->item('t_qr');
                    $params['level'] = 'H';
                    $params['size'] = 4;
                    $params['savename'] = 'public/qr_22/'.$factura['idlectura'].'.png';
                    $this->ciqrcode->generate($params);
                ?>
                <img width="80" src="<?php echo base_url()?>public/qr_22/<?php echo $factura['idlectura']?>.png" alt="qr">
            </td>
        </tr>
    </table>
    <!-- FIN DATOS COD CONTROL, QR -->
    <hr>
    <p style="text-align:center">
        <?php echo $configuracion['pie_impresion'];?>
    </p>
</body>
</html>