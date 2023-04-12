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
<>

    <table width="100%">
        <tr class="main_title">
            <th>INVENTARIO FISICO</th>
        </tr>
    </table>

    <br>

    <table id="table" width="100%">

        <?php if (!$datos) { ?>

        <tr>
            <th colspan="5">
                <strong> No hay clientes socios registrados en el sistema. </strong>
            </th>
        </tr>


        <?php }else{ ?>

            <tr class="titles">
                <th>Código cliente</th>
                <th>Fecha registro</th>
                <th>Socio</th>
                <th>Socio codigo </th>
                <th>Socio fecha</th>
                <th>Ci</th>
                <th>Razón social</th>
                <th>Fecha de nacimiento</th>
                <th>Nit</th>
                <th>Dirección</th>
                <th>Telefono</th>
            </tr>

            <?php foreach($datos as $dato){ ?>

                <tr style="font-size: 11px;">
                    <td><?php echo $dato['codigo']; ?></td>
                    <td><?php echo $dato['fecha_registro_formato']; ?></td>
                    <td><?php echo $dato['tipo_socio']; ?></td>
                    <td><?php echo $dato['codigo_socio']; ?></td>
                    <td><?php echo $dato['fecha_socio_formato']; ?></td>
                    <td><?php echo $dato['ci']; ?></td>
                    <td><?php echo $dato['razon_social']; ?></td>
                    <td><?php echo $dato['fecha_nacimiento_formato']; ?></td>
                    <td><?php echo $dato['nit']; ?></td>
                    <td><?php echo $dato['direccion']; ?></td>
                    <td><?php echo $dato['telefono']; ?></td>

                </tr>

            <?php }?>

        <?php } //exit; ?>

    </table>




</div>
</body></html>






































