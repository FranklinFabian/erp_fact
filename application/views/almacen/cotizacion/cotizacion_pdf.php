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
    <div>
        <table class="table" width="100%">
            <tr class="titles">
                <th colspan="7">CUADRO COMPARATIVO DE COTIZACIONES <br> (Expresado en Bolivianos)</th>
            </tr>

            {cabecera}
            <tr>
                <td class="background negrilla" colspan="4">
                    CODIGO:
                </td>
                <td colspan="3">COT-{codigo}-<?php echo date('Y')?></td>
            </tr>
            <tr>
                <td class="background negrilla" colspan="4">
                    FECHA:
                </td>
                <td colspan="3">{fecha_formateada}</td>
            </tr>

            {/cabecera}

            <tr class="titles">
                <th colspan="7">DETALLE</th>
            </tr>

        </table>

        <table class="table" width="100%">
            <tr class="titles negrilla">
                <td>N.</td>
                <td>CODIGO</td>
                <td>ARTICULO</td>
                <th>UNIDAD</th>
                <th>CANTIDAD</th>

                <?php foreach($proveedores as $proveedor){ ?>
                <th><?php echo $proveedor['nombre']; ?></th>
                <?php  }  ?>
                <td>OFERTA <br> ACEPTADA</td>
            </tr>

            <?php  $n=1; $total=0; foreach($cotizaciones as $cotizacion){ ?>

            <tr>
                <td width="5%"><?php echo $n; ?></td>
                <td width="5%"><?php echo $cotizacion['codigo_articulo']; ?></td>
                <td width="20%"><?php echo $cotizacion['nombre_articulo']; ?></td>
                <td width="5%" class="center"><?php echo $cotizacion['nombre_unidad']; ?></td>
                <td width="5%" class="center"><?php echo $cotizacion['cantidad']; ?></td>
                    <?php
                    foreach($proveedores as $proveedor){
                        /*Buscamos el costo del articulo y proveedor en interación*/
                        $this->db->select('c.costo costo');
                        $this->db->from('almacen_cotizacion c');
                        $this->db->where('c.id_cabecera_cotizacion', $cotizacion['id_cabecera_cotizacion']);
                        $this->db->where('c.id_articulo', $cotizacion['id']);
                        $this->db->where('c.id_proveedor', $proveedor['id']);
                        $query = $this->db->get();
                        if ($query->num_rows() == 0 ){
                    ?>
                            <td align="center"> - </td>
                    <?php
                        }else{
                    ?>
                            <td align="center">
                                <?php
                                    echo number_format($query->row()->costo * $cotizacion['cantidad'],2,',', '.');
                                ?> Bs.
                            </td>
                    <?php
                        }
                    ?>

                    <?php
                    }
                    ?>

                <td>

                    <?php
                    $this->db->select('p.nombre as nombre, c.costo costo');
                    $this->db->from('almacen_cotizacion c');
                    $this->db->join('almacen_proveedor p','p.id = c.id_proveedor','left');
                    $this->db->where('c.id_cabecera_cotizacion', $cotizacion['id_cabecera_cotizacion']);
                    $this->db->where('c.id_articulo', $cotizacion['id']);
                    $this->db->where('c.id_articulo', $cotizacion['id']);
                    $query = $this->db->get();
                    if ($query->num_rows() > 0 ){
                        $arr = $query->result_array();

                        //echo "<pre>";
                        //print_r($arr);

                        foreach ( $arr as $array   ){
                            $new_arr[$array['nombre']] = $array['costo'] ;
                        }

                        //echo "<pre>";
                        //print_r($new_arr);

                        $value = min($new_arr);

                        $key = array_search($value, $new_arr);

                        unset($new_arr);

                        echo "<strong>" . $key . "</strong>";

                    }
                    ?>

                </td>

                <?php $n++; } ?>


            </tr>



            <tr>
                <th class="negrilla titles" colspan="5">TOTAL</th>
                <?php foreach($proveedores_totales as $proveedor_total){ ?>
                    <th><?php echo number_format($proveedor_total['costo'],2,',', '.'); ?> Bs.</th>
                <?php  }  ?>

                <th></th>

            </tr>


        </table>

        <table  class="" width="100%">
            <tr>
                <td width="80%">
                    <strong>
                        OBSERVACIONES: REVISAR CARACTERISTICAS. <br>
                        RESOLUCION: <br>
                    </strong>

                    Debe aceptarse las siguientes ofertas de acuerdo a las especificaciones y condiciones económicas y técnicas, elaborar ( ) Orden de Compra ( ) Orden  de  Trabajo  para  las  mejores
                    ofertas  del  presente  cuadro. <br>

                    <br>

                    Informe:
                    .............................................................................................................................................................. <br> <br>
                    ............................................................................................................................................................................ <br> <br>
                    ............................................................................................................................................................................

                </td>
                <td width="20%"> <br> <br> <br> <br> <br> <br> <br> <br> <strong> V° B° </strong></td>
            </tr>

        </table>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>


        <table width="100%">
            <tr>
                <td  align="center"><strong> V° B° GERENTE GENERAL </strong></td>

                <td  align="center"><strong> V° B° TESORERO </strong></td>

                <td  align="center"><strong> V° B° PRESIDENTE </strong></td>
            </tr>
        </table>


    </div>
</body></html>






































