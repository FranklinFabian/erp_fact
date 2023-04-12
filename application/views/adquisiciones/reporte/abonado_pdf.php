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
            font-size: 6px;
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
            <td align="center"><h3>LISTA DE ABONADOS DEL {fecha_inicio} AL {fecha_fin}</td>
        </tr>
    </table>

    <br>

    <table id="table" width="100%" class="table" >

        <tr class="titles">
            <th colspan=23">LISTA</th>
        </tr>

        <?php if (isset($detalles)) { ?>

            <tr class="negrilla">
                <td>N°</td>
                <td>Codigo</td>
                <td>Cliente</td>
                <td>Registro</td>
                <td>Zona</td>
                <td>Dirección</td>
                <td>Número</td>
                <td>Transformador</td>
                <td>Poste</td>
                <td>Distancia</td>
                <td>Medidor</td>
                <td>Lectura</td>
                <td>Multiplicador</td>
                <td>Suministro</td>
                <td>Consumidor</td>
                <td>Medición</td>
                <td>Liberación</td>
                <td>Inquilino</td>
                <td>CI Inquilino</td>
                <td>Nombre Inquilino</td>
                <td>Cel Inquilino</td>
                <td>Ley 1886</td>
                <td>Fecha Ley 1886</td>
            </tr>

            <?php $contador = 1; foreach ($detalles as $detalle){ ?>


                <tr>
                    <td align="left">
                        <?php echo $contador; ?>
                    </td>
                    <td align="left">
                        <?php echo $detalle['id']; ?> <br>
                    </td>
                    <td align="left">
                        <?php echo $detalle['id_cliente']; ?> <br>
                    </td>
                    <td>
                        <?php echo $detalle['fecha_registro']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['id_zona']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['direccion']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['numero']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['transformador']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['id_poste']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['distancia_poste']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['medidor']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['lectura']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['multiplicador']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['id_suministro']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['id_consumidor']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['id_medicion']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['id_liberacion']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['id_existe_inquilino']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['ci_inquilino']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['nombre_inquilino']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['cel_inquilino']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['id_ley_adulto']; ?>
                    </td>
                    <td>
                        <?php echo $detalle['fecha_ley_adulto']; ?>
                    </td>



                </tr>

                <?php $contador++; } ?>




        <?php }else{ ?>



            <tr>
                <th colspan="23">
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
