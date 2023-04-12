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
            <td align="center" width="40%">COOPERATIVA DE SERVICIOS PUBLICOS DE ELECTRICIDAD "TUPIZA" R.L.</td>
            <td align="center">Personería Jurídica No. 349 <br> NIT 1011247020 <br> Casilla No.42  Tel. 6942434  Fax. 6942194</td>
        </tr>

    </table>
</header>
<div>

    <table width="100%">
        <tr class="main_title">
            <th>COMPROBANTE DE EGRESO</th>
        </tr>
    </table>

    <br>

    <table width="100%" >
        {cabecera}
        <tr>
            <td class="negrilla" style="width: 10%">
                CODIGO:
            </td>
            <td >{codigo}</td>

            <td class="negrilla" style="width: 10%">
                FECHA:
            </td>
            <td >{fecha_formateada}</td>
        </tr>

        <tr>
            <td class=" negrilla">
                GLOSA:
            </td>
            <td>{glosa}</td>
            <td class="negrilla" style="width: 10%">
                SOLICITANTE:
            </td>
            <td >{solicitante}</td>
        </tr>

        {/cabecera}


    </table>

    <table id="table" width="100%">

        <tr class="titles">
            <th colspan="8">LISTA DE ARTICULOS</th>
        </tr>

        <?php if (!$detalles) { ?>

            <tr>
                <th colspan="8">
                    <strong> No hay articulos cargados en este comprobante de egreso. </strong>
                </th>
            </tr>


        <?php }else{ ?>

            <tr class="titles negrilla" style="font-size: 9px;" >
                <th width="15%">CUENTA CONTABLE</th>
                <th width="15%">ARTICULO</th>
                <th width="6%">UNIDAD</th>
                <th width="8%">CANTIDAD</th>
                <th width="12%">COSTO REAL</th>
                <th width="12%">COSTO CONTABLE</th>
                <th width="12%">SUBTOTAL REAL</th>
                <th>SUBTOTAL CONTABLE</th>
            </tr>

            <?php $total_auxiliar=0; foreach($detalles as $detalle){ ?>


                <tr style="font-size: 11px;">
                    <td><?php echo $detalle['cuenta_contable'] . ' - ' . $detalle['cuenta_contable']; ?></td>
                    <td><?php echo $detalle['codigo_articulo'] . ' - ' . $detalle['nombre_articulo']; ?></td>
                    <td><?php echo $detalle['nombre_unidad']; ?></td>
                    <td><?php echo $detalle['cantidad']; ?></td>
                    <td><?php echo number_format($detalle['costo_real'],2,',', '.'); ?> Bs. </td>
                    <td><?php echo number_format($detalle['costo_contable'],2,',', '.'); ?> Bs. </td>
                    <td><?php $subtotal = $detalle['costo_real'] * $detalle['cantidad']; echo number_format($subtotal,2,',', '.'); ?> Bs. </td>
                    <td><?php $subtotal_auxiliar = ($detalle['costo_contable'] * $detalle['cantidad']); echo number_format($subtotal_auxiliar,2,',', '.'); ?> Bs. </td>
                </tr>


                <?php $total = $total_auxiliar + $subtotal_auxiliar; } ?>



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
    <?php if ($detalles) { ?>
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
                Revisado por
            </td>
            <td width="33%">
                V° B° Contador
            </td>
        </tr>
    </table>

    <?php }  //exit;?>

</div>
</body></html>






































