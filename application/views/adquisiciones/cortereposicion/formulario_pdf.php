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
            <td align="center" width="40%">EMPRESA DE LUZ Y FUERZA ELECTRICA DE CHALLAPATA S.A. ELFEDECH S.A. (BOLIVIA)</td>
            <td align="center">Casa Matriz <br> Bolivar Zona Central <br> Challapata Oruro</td>
        </tr>

    </table>
</header>
<div>
    {cabecera}
    <table width="100%">
        <tr class="main_title">
            <th><?php echo mb_strtoupper($cabecera[0][tipo]) ?></th>
        </tr>
    </table>

    <br>

    <table width="100%" >

        <tr>
            <td>
                <strong> Número: </strong> {numero}
            </td>
            <td>
                <strong> Fecha de Registro: </strong> {fecha}
            </td>
            <td>
                <strong> Abonado: </strong> {abonado}
            </td>
        </tr>
        <tr>
            <td>
                <strong> Categoria: </strong> {categoria}
            </td>
            <td>
                <strong> Medidor: </strong> {medidor}
            </td>
            <td>
                <strong> Razón Social: </strong> {razon_social}
            </td>
        </tr>
        <tr>
            <td>
                <strong> Dirección: </strong> {direccion}
            </td>
            <td>
                <strong> Suministro: </strong> {suministro}
            </td>
            <td>
                <strong> Centro: </strong> {centro}
            </td>
        </tr>
        <tr>
            <td>
                <strong> Poste: </strong> {poste}
            </td>
            <td>
                <strong> Consumidor: </strong> {consumidor}
            </td>
        </tr>

    </table>

    <table id="table">
        <tr>
            <td colspan="2">
                <strong>Servicio Solicitado: </strong> <?php if ($cabecera[0][tipo] == 'Corte'){ echo 'Corte del Servicio Eléctrico'; }else{ echo 'Reposición del Servicio Eléctrico'; } ?>  <br>
                <strong>Nota: </strong> {nota}
            </td>
        </tr>
        <tr>
            <td>
                Fecha del Corte:
            </td>
            <td>
                Lectura Medidor:
            </td>
        </tr>
        <tr>
            <td width="50%" rowspan="9">Nota:</td>
            <td width="50%" rowspan="9"></td>
        </tr>


    </table>
    {/cabecera}






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
            <td align="center">
                <div style="border-top: 1px dotted #000;">Aprobado por:</div>
            </td>
            <td width="3%"></td>
            <td align="center">
                <div style="border-top: 1px dotted #000;">Procesado por:</div>
            </td>
            <td width="3%"></td>
        </tr>
    </table>


<?php //exit; ?>




</div>
</body></html>






































