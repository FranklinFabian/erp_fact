<html>
<head>
  <title>
    Comprobante de <?php echo $comprobante['comprobante_tipo_nombre'] . ' Nro. ' . numero_comprobante($comprobante['correlativo']) ?>
  </title>

  <style>
    @page {
      margin: 45px 45px 200px;
    }
    body {
      font-size: 80%;
      font-family: "Helvetica";
    }
    .contenedor_firmas {
      position: fixed;
      left: 0px;
      right: 0px;
      bottom: -145px;
      height: 145px;
    }
    .margen_comprobante {
      position: fixed;
      padding: 3px;
      border: 1px solid black;
      top: 0px;
      left: -4px;
      right: -4px;
      height: 952px;
    }
    .textCenter {
      text-align: center;
    }
    .textRight {
      text-align: right;
    }
    .borde4 {
      padding: 3px;
      border: 1px solid black;
    }
    .bordeTopBotom {
      padding: 3px;
      border-top: 1px solid black;
      border-bottom: 1px solid black;
    }
    .bordeLeftRight {
      padding: 2px;
      border-right: 1px solid black;
      border-left: 1px solid black;
    }
    .b-left {
      padding: 2px;
      border-left: 1px solid black;
    }
    .b-right {
      padding: 2px;
      border-right: 1px solid black;
    }
    .bordeBottom {
      padding: 2px;
      border-bottom: 1px solid black;
    }
    .bordeTop {
      border-top: 1px solid black;
    }
    .bordeLeftTop {
      padding: 2px;
      border-top: 1px solid black;
      border-left: 1px solid black;
    }
    .bordeLeftBottomRight {
      padding: 2px;
      border-right: 1px solid black;
      border-bottom: 1px solid black;
      border-left: 1px solid black;
    }
    .bordeLTopRightBottom {
      padding: 2px;
      border-right: 1px solid black;
      border-bottom: 1px solid black;
      border-top: 1px solid black;
    }
    .nroComprobante {
      font-size: 19px;
      margin-top: 2px;
      padding-top: 8px;
      margin-left: 2px;
      border: 1px solid black;
      height: 32px;
      text-align: center;
    }

    .alineacionTop {
      vertical-align: top;
    }

    .tiposCambio {
      float: left;
      border: 1px solid black;
      text-align: center;
      padding-top: 3px;
      height: 18px;
      width: 77.5px;
      background: #FFF;
      margin-right: -1px;
    }
    .nombreTiposCambio {
      float: top;
      font-size: 11px;
    }
    .cuadroFirmas {
      margin: 2px;
      margin-top: 8px;
    }
    .contenedor_imagen_anulado {
      position: absolute;
    }
    .contenedor_imagen_anulado img {
      margin-top: 350px;
      margin-left: 210px;
    }
  </style>
</head>
<body>
  <div class="margen_comprobante"></div>
  <div class="contenedor_firmas">
    <?php
    $number_of_fields = comprobantes_parametros('numero_firmas');
    $custom_width = $number_of_fields * 100 / 6;
    ?>
    <table class="cuadroFirmas" cellspacing="0" width="<?php echo $custom_width ?>%">
      <tr>
        <?php $names = [1 => 'uno', 2 => 'dos', 3 => 'tres', 4 => 'cuatro', 5 => 'cinco', 6 => 'seis']; ?>
        <?php for ($i = 1; $i <= $number_of_fields; $i++) : ?>
          <th class="textCenter"><?php echo utf8_encode(comprobantes_parametros("cargo_firma_{$names[$i]}")) ?></th>
        <?php endfor; ?>
      </tr>
      <tr>
        <?php for ($i = 1; $i <= $number_of_fields; $i++) : ?>
          <td class="borde4"><br><br><br><br><br><?php echo utf8_encode(comprobantes_parametros("nombre_firma_{$names[$i]}")) ?></td>
        <?php endfor; ?>
      </tr>
    </table>
  </div>
  <div>
    <table cellspacing="0" width="100%">
      <thead>
        <tr>
          <td colspan="4">
            <table cellspacing="0" width="100%">
              <?php if ($comprobante['anulado']) : ?>
                <tr>
                  <td colspan="3" width="100%">
                    <div class="contenedor_imagen_anulado">
                      <img height="250px" src="<?php echo base_url('my-assets/image/anulado.png') ?>" />
                    </div>
                  </td>
                </tr>
              <?php endif; ?>
              <tr>
                <td class="textCenter" width="65%">
                  <strong><?php echo $this->EMPRESA_GESTION['nombre'] ?></strong><br>
                  <?php echo $this->EMPRESA_GESTION['direccion'] . ' - ' . $this->EMPRESA_GESTION['ciudad'] ?><br>
                  Teléfono: <?php echo $this->EMPRESA_GESTION['telefono'] ?>
                </td>
                <td class="textRight" width="25%"><br><br><br><br></td>
                <td class="textRight" width="10%"><br><br><br><br></td>
              </tr>
              <tr>
                <td colspan="3" class="bordeBottom"></td> <!-- para la separación -->
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="4">
            <table cellspacing="0" width="100%">
              <tr>
                <td width="80%">
                  <div class="textCenter" style="margin-bottom: 6px; font-size: 19px;">
                    <strong><u>COMPROBANTE CONTABLE DE <?php echo $comprobante['comprobante_tipo_nombre'] ?></u></strong>
                  </div>
                  <b>Del: </b><?php echo $this->lerp_utilities->convertDateToLiteral($comprobante['fecha']) ?>
                </td>
                <td width="5%" class="textRight">
                  <strong style="font-size:18px;">NRO:</strong>
                </td>
                <td width="15%">
                  <div class="nroComprobante">
                    <strong><?php echo numero_comprobante($comprobante['correlativo']) ?></strong>
                  </div>
                </td>
              </tr>
              <tr>
                <th>Por lo siguiente:</th>
                <td colspan="2" class="textCenter">
                  <strong>Tipos de cambio: </strong>
                </td>
              </tr>
              <tr>
                <td class="alineacionTop">
                  <div class="borde4">
                    <?php echo utf8_encode($comprobante['glosa']) ?>&nbsp;
                  </div>
                </td>
                <td colspan="2" width="16%">
                  <div class="tiposCambio"><?php echo $comprobante['tcBsUS'] ?></div>
                  <div class="tiposCambio"><?php echo $comprobante['tcBsUFV'] ?></div>
                  <div style="clear:left;"></div>
                  <strong class="nombreTiposCambio"><?php echo str_repeat("&nbsp;", 9) . '$US' . str_repeat("&nbsp;", 19) . 'UFV' ?></strong>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <!-- <strong>A la Orden de: </strong><?php echo utf8_encode("nombre persona") ?> --> &nbsp;
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <th class="textCenter borde4" width="15%">C&Oacute;DIGO</th>
          <th class="textCenter borde4" width="59%">DETALLE</th>
          <th class="textCenter borde4" width="13%">DEBE</th>
          <th class="textCenter borde4" width="13%">HABER</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $total_debe = 0;
          $total_haber = 0;
        ?>
        <?php foreach ($comprobante_data as $cd) : ?>
          <?php
            $total_debe += $cd->debeBs;
            $total_haber += $cd->haberBs;
          ?>
          <tr>
            <td class="b-left"><?php echo $cd->cuenta_codigo_formato ?><br>&nbsp;</td>
            <td><?php echo utf8_encode($cd->cuenta_nombre . '<br>' . $cd->referencia) ?></td>
            <td class="textRight"><?php echo number_format($cd->debeBs, 2) ?></td>
            <td class="textRight b-right"><?php echo number_format($cd->haberBs, 2) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th class="textRight bordeLeftTop" colspan="2">TOTALES: &nbsp;&nbsp;&nbsp;&nbsp;</th>
          <th class="textRight bordeTopBotom"><?php echo number_format($total_debe, 2) ?></th>
          <th class="textRight bordeLTopRightBottom"><?php echo number_format($total_haber, 2) ?></th>
        </tr>
        <tr>
          <td class="bordeLeftBottomRight" colspan="4"><b>SON:</b> <span><?php echo $this->numberstowords->convert_number($total_debe) ?></span></td>
        </tr>
      </tfoot>
    </table>
  </div>
</body>
</html>
