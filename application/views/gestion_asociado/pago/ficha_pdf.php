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
            <th>FICHA DE CLIENTE</th>
        </tr>
    </table>
    <br>
    <table width="100%">
        <?php if ($fotografia == 1) { ?>
        <tr class="main_title">
            <td align="center" width="30%"><img src="assets/uploads/gestion_asociado/<?php echo $id ?>.jpg" alt="" height="100px"></td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <table width="100%" id="table" >
        {cliente}
        <tr>
            <td class="negrilla titles" style="width: 30%">
                CODIGO DE CLIENTE:
            </td>
            <td >{codigo}</td>
        </tr>
        <tr>
            <td class="negrilla titles" style="width: 30%">
                CI:
            </td>
            <td >{ci}</td>
        </tr>
        <tr>
            <td class="negrilla titles" style="width: 30%">
                EXPEDIDO:
            </td>
            <td >{departamento}</td>
        </tr>
        <tr>
            <td class="negrilla titles" style="width: 30%">
                RAZON SOCIAL:
            </td>
            <td >{razon_social}</td>
        </tr>
        <tr>
            <td class="negrilla titles" style="width: 30%">
                FECHA DE NACIMIENTO:
            </td>
            <td >{fecha_nacimiento_formato}</td>
        </tr>
        <tr>
            <td class="negrilla titles" style="width: 30%">
                NIT:
            </td>
            <td >{nit}</td>
        </tr>
        <tr>
            <td class="negrilla titles" style="width: 30%">
                DIRECCIÓN:
            </td>
            <td >{direccion}</td>
        </tr>
        <tr>
            <td class="negrilla titles" style="width: 30%">
                TELEFONO:
            </td>
            <td >{telefono}</td>
        </tr>
        {/cliente}
    </table>

    <br>
        <table width="100%">
            <tr class="main_title">
                <th>DATOS SOCIO</th>
            </tr>
        </table>
        <table width="100%" id="table" >
            {cliente}
            <tr>
                <td class="negrilla titles" style="width: 30%">
                    TIPO DE SOCIO:
                </td>
                <td >{tipo_socio}</td>
            </tr>
            <tr>
                <td class="negrilla titles" style="width: 30%">
                    FECHA DE ASOCIACIÓN:
                </td>
                <td >{fecha_socio_formato}</td>
            </tr>
            <tr>
                <td class="negrilla titles" style="width: 30%">
                    CODIGO DE SOCIO:
                </td>
                <td >{codigo_socio}</td>
            </tr>
            {/cliente}
        </table>

    <br>

    <table width="100%">
        <tr class="main_title">
            <th>DATOS SUSCRIPCIÓN</th>
        </tr>
    </table>
    <table width="100%" id="table" >
        {cliente}
        <tr>
            <td class="negrilla titles" style="width: 30%">
                CODIGO DE SUSCRIPCIÓN:
            </td>
            <td >{codigo_suscripcion}</td>
        </tr>
        <tr>
            <td class="negrilla titles" style="width: 30%">
                FECHA DE SUSCRIPCIÓN:
            </td>
            <td >{fecha_suscripcion_formato}</td>
        </tr>
        <tr>
            <td class="negrilla titles" style="width: 30%">
                COSTO DE SUSCRIPCIÓN:
            </td>
            <td >{costo_suscripcion}</td>
        </tr>
        {/cliente}
    </table>

    <br>

    <table width="100%">
        <tr class="main_title">
            <th>PAGOS</th>
        </tr>
    </table>
    <table width="100%" id="table" >
        <tr class="titles">
            <th>N°</th>
            <th>CODIGO</th>
            <th>FECHA</th>
            <th>MONTO</th>
        </tr>

        <?php
        if ($pagos != null){
            $contador = 1;
            foreach($pagos as $pago){ ?>
               <tr style="font-size: 11px;">
                    <td><?php echo $contador; ?></td>
                    <td><?php echo $pago['codigo']; ?></td>
                    <td><?php echo $pago['fecha_formato']; ?></td>
                    <td><?php echo number_format($pago['importe_pagado'],2,',', '.'); ?> Bs. </div></td>

                </tr>
        <?php
           $contador++; }
        }else{
        ?>
            <tr>
                <td colspan="4">No se registraron pagos en esta suscripción</td>
            </tr>
        <?php
        }
        ?>
    </table>

</div>
</body></html>
<?php //exit; ?>






































