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
            <th>INVENTARIO FISICO</th>
        </tr>
    </table>

    <br>

    <table id="table" width="100%">

        <?php if (!$grupos) { ?>

        <tr>
            <th colspan="5">
                <strong> No hay articulos cargados en el sistema. </strong>
            </th>
        </tr>


        <?php }else{ ?>


    <?php $total = 0; foreach ($grupos as $grupo){ ?>

                <tr>
                    <td align="left" style="border: none;"><strong><?php echo $grupo['codigo']; ?></strong></td>
                    <td align="left" colspan="4" style="border: none;"><strong><?php echo $grupo['nombre']; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="5" style="border: none; padding-top: -6px;">
                        <hr>
                    </td>
                </tr>

                <tr class="titles">
                    <th width="15%">Código</th>
                    <th width="40%">Articulo</th>
                    <th>Ingreso</th>
                    <th>Egreso</th>
                    <th>Saldo</th>
                </tr>

                <?php foreach($detalles as $detalle){ ?>

                    <?php  if ( $grupo['id'] == $detalle['id_grupo']){?>

                        <tr style="font-size: 11px;">
                            <td><?php echo $detalle['codigo_articulo']; ?></td>
                            <td><?php echo $detalle['articulo']; ?></td>
                            <td><div align="right"><?php echo $detalle['ingreso']; ?></div></td>
                            <td><div align="right"><?php echo $detalle['egreso']; ?></div></td>
                            <td><div align="right"><?php echo $detalle['saldo']; ?></div></td>

                        </tr>

                        <?php } ?>
                <?php }?>

            <?php } ?>

        <?php } //exit; ?>

    </table>




</div>
</body></html>






































