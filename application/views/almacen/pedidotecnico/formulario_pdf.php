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
            <th>PEDIDO DE MATERIALES</th>
        </tr>
        <tr>
            <th>(SECCIÓN TÉCNICA)</th>
        </tr>
    </table>

    <br>

    <table width="100%">
        {cabecera}
        <tr>
            <td align="right" colspan="3">
                <strong> CODIGO: </strong> {codigo}
            </td>
        </tr>
        <tr>
            <td align="left" colspan="3">
                <strong> Fecha: </strong> {fecha_formateada}
            </td>
        </tr>

        {/cabecera}

        <tr>
            <td width="33%">&nbsp;</td>
            <td width="33%">
                <br><br><br>
                <div align="center" style="border-top: 1px solid #000;">Firma Solicitante</div>
                <br>
                Nombre y <br>
                Apellido:
            </td>
            <td width="33%">
                <br><br><br>
                <div align="center" style="border-top: 1px solid #000;">Firma Responsable</div>
                <br>
                Nombre y <br>
                Apellido:
            </td>
        </tr>

    </table>

    <table id="table" width="100%">

        <tr class="titles negrilla" style="font-size: 9px;" >
            <th width="10%">ITEM</th>
            <th width="20%">GRUPO</th>
            <th>ARTICULO</th>
            <th width="10%">CANTIDAD</th>
            <th width="10%">UNIDAD</th>

        </tr>

        <?php if (!$detalles) { ?>

        <tr>
            <th colspan="5">
                <strong> No hay articulos cargados en este pedido. </strong>
            </th>
        </tr>


        <?php }else{ ?>

            <?php $contador = 1; $total = 0; foreach ($detalles as $detalle){ ?>

                <tr>
                    <td><?php echo $contador; ?></td>
                    <td><?php echo $detalle['grupo']; ?></td>
                    <td><?php echo $detalle['articulo']; ?></td>
                    <td><?php echo $detalle['cantidad']; ?></td>
                    <td><?php echo $detalle['unidad']; ?></td>
                </tr>




            <?php $contador++;}?>

            <tr>
                <td colspan="5" style="border:0;" >
                    <br>
                </td>
            </tr>

            <tr>
                <td colspan="5" style="border:0;">
                    <br>
                </td>
            </tr>
            <tr>
                <td align="right" colspan="5" style="border:0; padding-right: 200px;">
                    Recibí Conforme:
                </td>
            </tr>

        <?php } //exit; ?>

    </table>



    <br>
    <br>
    <br>
    <br>
    <br>
    <?php if ($detalles) { ?>
        <table width="100%">
            <tr>
                <td width="3%"></td>
                <td align="center">
                    <div style="border-top: 1px solid #000;">Gerencia General</div>
                </td >
                <td width="3%"></td>
                <td align="center">
                    <div style="border-top: 1px solid #000;">Enc. Almacenes</div>
                </td>
                <td width="3%"></td>
                <td align="center">
                    <div style="border-top: 1px solid #000;">Interesado</div>
                </td>
                <td width="3%"></td>
            </tr>
        </table>


    <?php } // exit; ?>




</div>
</body></html>






































