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

        .table td, .table th {
            font-size: 10px;
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
            <td align="center" width="40%">EMPRESA DE LUZ Y FUERZA ELECTRICA DE CHALLAPATA S.A. ELFEDECH S.A. (BOLIVIA)</td>
            <td align="center">Casa Matriz <br> Bolivar Zona Central <br> Challapata Oruro</td>
        </tr>

    </table>
</header>
<div>

    <table width="100%">
        <tr class="main_title">
            <th>LECTURACIÓN</th>
        </tr>
    </table>

    <br>
    {cabecera}
    <table width="100%" >

        <tr>

            <td>
                <strong> Abonado: </strong> {abonado}
            </td>
            <td>
                <strong> Categoria: </strong> {categoria}
            </td>
            <td>
                <strong> Medidor: </strong> {medidor}
            </td>
        </tr>
        <tr>
            <td>
                <strong> Razón Social: </strong> {razon_social}
            </td>
            <td>
                <strong> Dirección: </strong> {direccion}
            </td>
            <td>
                <strong> Suministro: </strong> {suministro}
            </td>
        </tr>
        <tr>
            <td>
                <strong> Centro: </strong> {centro}
            </td>
            <td>
                <strong> Poste: </strong> {poste}
            </td>
            <td>
                <strong> Consumidor: </strong> {consumidor}
            </td>
        </tr>


    </table>
    {/cabecera}

    <table id="table" class="table" width="100%">

        <tr class="titles">
            <th colspan="12">DETALLE</th>
        </tr>

        <?php if (isset($detalles)) { ?>

            <tr class="negrilla">
                <td>N°</td>
                <td>Fecha</td>
                <td>Lectura Anterior</td>
                <td>Potencia</td>
                <td>Lectura Actual</td>
                <td>Multiplicador</td>
                <td>Consumo</td>
                <td>Estimado</td>
                <td>Sin factura</td>
                <td>Observada</td>
                <td>Observacion</td>
                <td>Nota</td>
            </tr>

            <?php $contador = 1; foreach ($detalles as $detalle){ ?>


                <tr>
                    <td align="left">
                        <?php echo $contador; ?>
                    </td>
                    <td align="left">
                        <?php echo $detalle['fecha']; ?> <br>
                    </td>
                    <td>
                        <?php echo $detalle['lectura_anterior']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['potencia']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['lectura_actual']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['multiplicador']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['consumo']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['estimado']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['sin_factura']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['observada']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['observacion']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['nota']; ?>
                    </td>
                </tr>

                <?php $contador++; } ?>




        <?php }else{ ?>



            <tr>
                <th colspan="12">
                    <strong> No hay registros cargados. </strong>
                </th>
            </tr>



        <?php } ?>

    </table>







    <br>
    <br>
    <br>
    <br>
    <br>

    <table width="100%">
        <tr>
            <td width="3%"></td>
            <td align="center">
                <div style="border-top: 1px dotted #000;">Solicitado por:</div>
            </td >
            <td width="3%"></td>
            <td align="center">
                <div style="border-top: 1px dotted #000;">Atendido por:</div>
            </td>
            <td width="3%"></td>

        </tr>
    </table>


<?php //exit; ?>




</div>
</body></html>






































