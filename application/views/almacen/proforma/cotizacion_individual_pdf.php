<html><head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial, Helvetica, sans-serif, normal;
            font-size: 11px;
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

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table td, .table th {
            border: 1px solid #6D6E70;
            padding: 4px;
        }

        .table th {
            text-align: center;
        }

        .titles{
            background-color: #D1D2D4;
        }

        .negrilla{
            font-weight:bold;
        }

        .tablefooter td{
            border: 0px !important;
        }

        .tablefooter{
            margin-top: 52px;
            text-align: center;
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
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $pdf->text(480, 795, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);
        ');
    }
</script>
<header>
    <table width="100%">
        <tr align="center">
            <td align="center" width="30%"><img src="assets/logos/logo.jpg" alt="Logo" height="50px"></td>
            <td align="center" width="42%">COOPERATIVA DE SERVICIOS PUBLICOS DE ELECTRICIDAD "TUPIZA" R.L.</td>
            <td align="center">Personería Jurídica No. 349 <br> NIT 1011247020 <br> Casilla No.42  Tel. 6942434  Fax. 6942194</td>
        </tr>

    </table>
</header>

<table class="table" width="100%">
    <tr class="titles">
        <th colspan="7">COTIZACIÓN</th>
    </tr>
    {cabecera}
    <tr>
        <td class="background negrilla" colspan="4">
            PROVEEDOR:
        </td>
        <td colspan="3">{proveedor}</td>
    </tr>
    <tr>
        <td class="background negrilla" colspan="4">
            FECHA:
        </td>
        <td colspan="3">{fecha_formateada}</td>
    </tr>
    {/cabecera}
</table>

<table class="table" width="100%">
    <tr class="titles negrilla">
        <td>N.</td>
        <td>CANTIDAD</td>
        <td>UNIDAD</td>
        <th>ARTICULO Y/O SERVICIO</th>
        <th>PRECIO UNITARIO</th>
        <th>IMPORTE</th>
    </tr>

    <?php  $importe = 0; $n=1; foreach($cuerpos as $cuerpo){ ?>

    <tr>
        <td width="5%"><?php echo $n; ?></td>
        <td width="5%"><?php echo $cuerpo['cantidad']; ?></td>
        <td width="5%"><?php echo $cuerpo['unidad']; ?></td>
        <td class="center"><?php echo $cuerpo['articulo']; ?></td>
        <td class="center"><?php echo number_format($cuerpo['costo'],2,',', '.'); ?> Bs.</td>
        <td class="center"><?php echo number_format($cuerpo['importe'],2,',', '.'); ?> Bs.</td>
        <?php $n++; $importe = $importe + $cuerpo['importe'];} ?>
    </tr>

    <tr>
        <th class="negrilla titles" colspan="5">TOTAL</th>

        <th><?php echo number_format($importe,2,',', '.'); ?> Bs.</th>
    </tr>

</table>

</body></html>






































