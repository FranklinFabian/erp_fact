<html><head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial, Helvetica, sans-serif, normal;
            font-size: 12px;
        }

        body {
            margin: 3cm 2cm 2cm;
        }

        header {
            position: fixed;
            top: 0.6cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            text-align: center;
            line-height: 15px;
            margin-left: 1cm;
            margin-right: 1cm;
        }

        #table {

            width: 100%;
        }

        #table td, #table th {
            border: 1px solid #6D6E70;
            padding: 3px;
        }

        #table th {
            text-align: center;
        }

        .titles{
            background-color: #D1D2D4;
        }

        .main_title{
            font-size: 15px;
        }

        .negrilla{
            font-weight:bold;
        }


        .background{
            background-color: #D1D2D4;
        }

        .center{
            text-align: center;
        }
    </style>
</head><body>
<script type="text/php">
if ( isset($pdf) ) {
    $font = Font_Metrics::get_font("verdana");;
    $size = 6;
    $color = array(0,0,0);
    $text_height = Font_Metrics::get_font_height($font, $size);

    $foot = $pdf->open_object();
    $w = $pdf->get_width();
    $h = $pdf->get_height();
    // Draw a line along the bottom
    $y = $h - $text_height - 24;
    //$pdf->line(16, $y, $w - 16, $y, $color, 0.5);
    $pdf->close_object();
    $pdf->add_object($foot, "all");
    $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
    $text = html_entity_decode($text);

    //echo $text; exit;
    // Center the text
    $width = Font_Metrics::get_text_width("Page 1 of 2", $font, $size);
    $pdf->page_text($w / 2 - $width / 2, $y, $text, $font, $size, $color);
}
</script>
<header>
    <table width="100%">
        <tr align="center">
            <td align="center" width="30%"><img src="assets/logos/logo.jpg" alt="Logo" height="50px"></td>
            <td align="center" width="40%">COOPERATIVA DE SERVICIOS PUBLICOS ELÉCTRICOS ATOCHA R.L.</td>
            <td align="center">Calle Comercio Nro. 70 <br> Atocha, Bolivia <br> <strong>Email:</strong> info@cosealrl.com <br> <strong>Telf:</strong> 26949116 </td>
        </tr>
    </table>
</header>
<div>

    <table width="100%">
        <tr class="main_title">
            <td align="center"><h3>SALIDA DE ALMACEN</h3>Del {fecha_inicio} al {fecha_fin}</td>
        </tr>
    </table>

    <br>


    <table id="table" width="100%">

        <tr class="titles">
            <th colspan="8">LISTA DE ARTICULOS</th>
        </tr>

        <?php if (!$cuentas) { ?>

            <tr>
                <th colspan="8">
                    <strong> No hay articulos cargados en este comprobante de egreso. </strong>
                </th>
            </tr>


        <?php }else{ ?>


            <?php $total = 0; foreach ($cuentas as $cuenta_contable){ ?>

                <tr>
                    <td colspan="8" align="left">
                        <strong>Codigo:</strong> <?php echo $cuenta_contable['codigo']; ?> <br>
                        <strong>Cuenta Contable:</strong> <?php echo $cuenta_contable['codigo'] . " - " . $cuenta_contable['nombre']; ?>
                    </td>
                </tr>


                <?php $total_contable=0; foreach ($cuenta_contable['cuenta_auxiliar'] as $cuenta_auxiliar){ ?>

                    <tr>
                        <td colspan="8" align="center">
                            <strong>Cuenta Auxiliar:</strong> <?php echo $cuenta_auxiliar['codigo'] . " - " .$cuenta_auxiliar['nombre'];; ?>
                        </td>
                    </tr>


                    <tr class="titles negrilla" style="font-size: 9px;" >
                        <td>FECHA</td>
                        <td>CODIGO</td>
                        <td>ARTICULO</td>
                        <td>UNIDAD</td>
                        <td>PEDIDO</td>
                        <!-- <td>CUENTA CONTABLE</td> -->
                        <!-- <td>CUENTA AUXILIAR</td> -->
                        <th>CANTIDAD</th>
                        <th>COSTO CONTABLE</th>
                        <th>SUBTOTAL CONTABLE</th>
                    </tr>

                    <?php $total_auxiliar=0; foreach($detalles as $detalle){ ?>

                        <?php  if ( $cuenta_contable['id'] == $detalle['id_cuenta_contable'] && $cuenta_auxiliar['id'] == $detalle['id_cuenta_auxiliar'] ){?>

                            <tr style="font-size: 11px;">
                                <td><?php echo $detalle['fecha']; ?></td>
                                <td><?php echo $detalle['codigo_articulo']; ?></td>
                                <td><?php echo $detalle['nombre_articulo']; ?></td>
                                <td><?php echo $detalle['nombre_unidad']; ?></td>
                                <td><?php echo $detalle['nombre_unidad']; ?></td>
                                <!-- <td width="10%"><?php echo $detalle['cuenta_contable']; ?></td> -->
                                <!-- <td width="10%"><?php echo $detalle['cuenta_auxiliar']; ?></td> -->
                                <td><?php echo $detalle['cantidad']; ?></td>
                                <td><?php echo number_format($detalle['costo_contable'],2,',', '.'); ?> Bs. </td>
                                <td> <?php $subtotal_auxiliar = $detalle['costo_contable'] * $detalle['cantidad'] ; echo number_format($subtotal_auxiliar,2,',', '.'); ?> Bs. </td>
                            </tr>

                            <?php $total_auxiliar = $total_auxiliar + $subtotal_auxiliar ; } ?>

                    <?php } ?>

                    <tr>
                        <td align="right" class="negrilla titles" colspan="7">Total por Cuenta Auxiliar</td>
                        <td colspan="1"> <strong> <?php echo number_format($total_auxiliar,2,',', '.'); ?> Bs. </strong> </td>
                    </tr>
                    <?php $total_contable = $total_contable + $total_auxiliar ;?>

                <?php } ?>

                <tr>
                    <td align="right" class="negrilla titles" colspan="7">Total por Cuenta Contable</td>
                    <td colspan="1"> <strong> <?php echo number_format($total_contable,2,',', '.'); ?> Bs. </strong> </td>
                </tr>

                <?php $total = $total + $total_contable ;?>



            <?php } ?>


            <tr>
                <td align="right" class="negrilla titles" colspan="7">Total</td>
                <td colspan="1"> <strong> <?php echo number_format($total,2,',', '.'); ?> Bs. </strong> </td>
            </tr>



        <?php } ?>

    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php if ($cuentas) { ?>
    <table width="100%" id="table">
        <tr>
            <td>
                &nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;
            </td>
            <td>
                &nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;
            </td>
            <td>
                &nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="33%">
                Encargado de Almacenes
            </td>
            <td width="33%">
                Revizado por
            </td>
            <td width="33%">
                V° B° Contador
            </td>
        </tr>
    </table>

    <?php }  //exit;?>

</div>
</body></html>






































