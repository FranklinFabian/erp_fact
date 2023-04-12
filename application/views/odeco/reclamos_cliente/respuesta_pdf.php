<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?= $titulo; ?></title>
  </head>
  <style media="screen">
    td{
      text-align:center;
      vertical-align: middle;
      border: solid 1px black;
      font-size: 10px;
      height: 16px;
      padding: 0;
    }
    th{
      text-align:center;
      vertical-align: middle;
      border: solid 1px black;
      font-size: 10px;
      height: 20px;
      background-color: rgba(207, 207, 207, 0.67);
    }
    body{
      text-align:center;
      font-family: "Times New Roman", Times, serif;
      font-size: 8px;
    }
    tr{
      width: 100%;
    }
    table{
      width: 100%;
      border-collapse: collapse;
      border: solid 1.5px black;
      border: none;
      padding: 0;
    }
    span {

    }
  </style>
  <body style="font-family: Times New Roman, Times, serif; font-size:12px;">
    <h4 style="text-align: left; padding: -15px;"> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;7. DESCRIPCIÓN (MOTIVO) DE LA RECLAMACIÓN </h4>
    <div style="border: solid 1px #000;width:100%;">
      <div style="text-align: left;padding: 10px;"><span style="font-family: courier;"> <?php if(!empty($detalles_reclamo[0]['DESCRIPCION_TIPO'])){ echo $detalles_reclamo[0]['DESCRIPCION_TIPO'].' / ';}; ?> <?php if(!empty($detalles_reclamo[0]['DESCRIPCION_CATEGORIA'])){ echo $detalles_reclamo[0]['DESCRIPCION_CATEGORIA'].' / ';}; ?> <?= $detalles_reclamo[0]['DESCRIPCION']; ?>&nbsp;&nbsp; (<?= $detalles_reclamo[0]['MOTIVO']; ?>)</span></div>
    </div>
    <br>
    <h4 style="text-align: left; padding: -15px;"> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;8. COMPLEMENTACIÓN</h4>
    <div style="border: solid 1px #000;width:100%;">
      <div style="text-align: left;padding: 10px;"><span style="font-family: courier;"> <?= $detalles_reclamo[0]['ASUNTO']; ?></span></div>
    </div>
    </div>
    <br>
    <h4 style="text-align: left; padding: -15px;"> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;9. PRONUNCIAMIENTO DEL OPERADOR</h4>
    <div style="border: solid 1px #000;width:100%;">
      <div style="text-align: left;padding: 10px;"><strong>NRO. RECLAMACI&Oacute;N: </strong> <span style="font-family: courier;"><?= $detalles_reclamo[0]['NUMERO']; ?></span>&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <strong>FECHA: </strong> <span style="font-family: courier;"><?= date('d/m/Y',strtotime($detalles_reclamo[0]['FECHA_HORA_SOL'])); ?>  <?= date('H:i',strtotime($detalles_reclamo[0]['FECHA_HORA_SOL'])); ?> </span> &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; <strong> PRONUNCIAMIENTO: </strong> <span style="font-family: courier;"><?php if($detalles_reclamo[0]['IND_JUSTIFICADO']=='SI') { echo 'JUSTIFICADO';}else{echo 'INJUSTIFICADO';} ?> </span></div>
      <div style="text-align: left;padding: 10px;"> <strong> DETALLE DEL PRONUNCIAMIENTO: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['OBSERVACION']; ?> </span></div>
    </div>
    <br>
    <h4 style="text-align: left; padding: -15px;"> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;10. NOTIFICACIÓN DEL PRONUNCIAMIENTO</h4>
    <div style="border: solid 1px #000;width:100%;">
      <div style="text-align: left;padding: 10px;"><strong> FECHA Y HORA DE COMUNICACIÓN: </strong><span style="font-family: courier;"> <?= date('d/m/Y',strtotime($detalles_reclamo[0]['FECHA_HORA_RES'])); ?>  <?= date('H:i',strtotime($detalles_reclamo[0]['FECHA_HORA_RES'])); ?> </span></div>
      <div style="text-align: left;padding: 10px;"> <strong> DOMICILIO REAL: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['Domicilio_real_reclamante']; ?> </span></div>
      <div style="text-align: left;padding: 10px;"><strong> DOMICILIO PROCESAL: </strong><span style="font-family: courier;">  <?= $detalles_reclamo[0]['Domicilio_procesal']; ?> </span></div>
      <div style="text-align: left;padding: 10px;"> <strong> DOMICILIO ESPECIAL: </strong> <span style="font-family: courier;"><?= $detalles_reclamo[0]['Domicilio_especial']; ?> </span></div>
    </div>
    </div>
    <br>
    
    <br>
    <table style="height: 10%;">
    </table>
    <!--footer style="position: fixed; bottom: 3%; font-size: 9px; height:35px;"-->
      <table style="border:solid 1px white; width: 80%; border-collapse: collapse;">
        <tr>
          <td style="border:solid 1px white;text-align: left; width: 20%"></td>
          <td style="border:solid 1px white; border-top: solid 1px black; text-align: center; width: 40%;"> NOMBRE Y FIRMA (OPERADOR) </td>
          <td style="border:solid 1px white;text-align: left; width: 30%"></td>
          <td style="border:solid 1px white;border-top: solid 1px black; text-align: center; width: 40%;"> FIRMA DEL RECLAMANTE </td>
        </tr>
      </table>
    <!--/footer-->
    <br>
    <div style="width:100%; text-align: left;">
      <div style="text-align: left;padding: 5px;"><span><strong> 11. INFORMACIÓN PARA LA IMPUGNACIÓN</strong></span></div>
      <p>* Si el pronunciamiento de la Reclamación Directa no le fue comunicado, usted tiene derecho a acudir a la AE, para exigir sus derechos.</p>
      <p>* Si la Respuesta del Operador a la Reclamación Directa, establece que su reclamo es improcedente. Usted no está conforme con esta, tiene derecho a presentar ante la AE su Reclamación Administrativa dentro el plazo de 15 días hábiles administrativos de comunicado el Pronunciamiento.</p>
      <p>* Si la Reclamación Directa no fue resuelta por el Operador dentro de los quince (15) días hábiles administrativos de registrada la misma, usted tiene derecho a presentar ante la AE su Reclamación Administrativa dentro el plazo de quince (15) días hábiles administrativos de vencido el termino de respuesta de la empresa.</p>
    </div>
    <br>
    <div style="width:100%; text-align: left;">
      <div style="text-align: left;padding: 5px;"><span><strong>   COMO PUEDE ACUDIR A LA AUTORIDAD DE FISCALIZACIÓN Y CONTROL SOCIAL DE ELECTRICIDAD (A.E.)</strong></span></div>
      <p>* Personalmente, presentándose a la Oficina Regional de la AE.</p>
      <p>* De forma escrita, remitiéndose a la casilla Nro. 2802 Ciudad de La Paz.</p>
      <p>* De forma escrita, enviando una nota al Fax Gratuito Nro. 800104002.</p>
      <p>* Por teléfono, llamando a la línea Gratuita Nro. 800102407.</p>
      <p>* Por INTERNET, al correo electrónico: autoridaddeelectricidad@aetn.gob.bo.</p>
    </div>
    <br>
    <div style="width:100%;">
      <div style="text-align: left;padding: 5px; font-size: 10px;font-style: oblique; text-align: center;"><span><strong> "EMPRESA SUPERVISADA Y REGULADA POR LA AUTORIDAD DE FISCALIZACIÓN Y CONTROL SOCIAL DE ELECTRICIDAD (AE)" </strong></span></div>
    </div>
  </body>
</html>
