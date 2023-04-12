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
    <table style="border: hidden;">
      <tr>
        <td style="width:100%; border: hidden; text-align: center;font-size:18px;"><strong> ODECO: <?= $nombre_empresa; ?></strong></td>
      </tr>
      <tr>
        <td style="width:100%; border: hidden;font-size:18px;"><strong> <?= $asunto; ?> </strong></td>
      </tr>
    </table>
    <br>
    <h4 style="text-align: left; padding: -15px;"> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;1. DATOS DE LA RECLAMACI&Oacute;N </h4>
    <div style="border: solid 1px #000;width:100%;">
      <div style="text-align: left;padding: 10px;"><strong>NRO. RECLAMACI&Oacute;N: </strong> <span style="font-family: courier;"><?= $detalles_reclamo[0]['NUMERO']; ?></span>&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <strong>OFICINA COMERCIAL: </strong> <span style="font-family: courier;">OFICINA ODECO <?= $detalles_reclamo[0]['Oficina_odeco']; ?> </span></div>
      <div style="text-align: left;padding: 10px;"><strong>FECHA RECEPCI&Oacute;N: </strong> <span style="font-family: courier;"><?= date('d/m/Y',strtotime($detalles_reclamo[0]['FECHA_HORA_REC'])); ?></span>&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; <strong> HORA RECEPCI&Oacute;N:</strong><span style="font-family: courier;"> <?= date('H:i',strtotime($detalles_reclamo[0]['FECHA_HORA_REC'])); ?> </span> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; <strong> MEDIO DE RECEPCI&Oacute;N: </strong> <span style="font-family: courier;"><?= $detalles_reclamo[0]['Medio_recepcion']; ?> </span></div>
    </div>
    <br>
    <h4 style="text-align: left; padding: -15px;"> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;2. IDENTIFICACI&Oacute;N DEL SERVICIO Y RECLAMANTE</h4>
    <div style="border: solid 1px #000;width:100%;">
      <div style="text-align: left;padding: 5px;"><strong> NOMBRE Y APELLIDOS: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['Nombres']; ?></span>&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <strong> NRO. DOC: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['Ci_reclamante']; ?> </span></div>
      <div style="text-align: left;padding: 5px;"><strong> DIRECCI&Oacute;N: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['Direccion_reclamante']; ?></span>&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <strong> NRO. MEDIDOR: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['Nro_medidor_reclamante']; ?> </span></div>
      <div style="text-align: left;padding: 5px;"><strong> LOCALIDAD: </strong> <span style="font-family: courier;"><?= $detalles_reclamo[0]['Localidad']; ?></span>&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <strong> BARRIO O ZONA: </strong> <span style="font-family: courier;"><?= $detalles_reclamo[0]['Zona']; ?> </span></div>
      <div style="text-align: left;padding: 5px;"><strong> TEL&Eacute;FONO: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['Telefono_1_reclamante']; ?></span>&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <strong> NRO. CUENTA:</strong> <span style="font-family: courier;"><?= $detalles_reclamo[0]['Nro_cuenta_reclamante']; ?> </span>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; <strong> CATEGOR&Iacute;A: </strong> <span style="font-family: courier;"><?= $detalles_reclamo[0]['CATEGORIA']; ?> </span></div>
    </div>
    <br>
    <h4 style="text-align: left; padding: -15px;"> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;3. DOMICILIOS PARA NOTIFICAR AL(A) RECLAMANTE</h4>
    <div style="border: solid 1px #000;width:100%;">
      <div style="text-align: left;padding: 5px;"><strong> DOMICILIO REAL: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['Domicilio_real_reclamante']; ?></span></div>
      <div style="text-align: left;padding: 5px;"><strong> DOMICILIO PROCESAL: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['Domicilio_procesal']; ?></span></div>
      <div style="text-align: left;padding: 5px;"><strong> DOMICILIO ESPECIAL: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['Domicilio_especial']; ?></span></div>
    </div>
    <div style="text-align: left;"><strong>NOTA.- Los domicilios deberán ser señalados de forma clara, precisa y conforme al Artículo 26 del Reglamento de la Ley de Procedimiento Administrativo para el Sistema de Regulación Sectorial (RLPA-SIRESE).</strong></div>
    <br>
    <h4 style="text-align: left; padding: -15px;"> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;4.  DETALLE DE LA RECLAMACIÓN Y/O DOCUMENTACIÓN PROPORCIONADA POR EL RECLAMANTE</h4>
    <div style="border: solid 1px #000;width:100%;">
      <div style="text-align: left;padding: 5px;"><strong> FECHA Y HORA DE PRODUCIDO EL HECHO: </strong><span style="font-family: courier;">  <?= date('d/m/Y',strtotime($detalles_reclamo[0]['Fecha_evento_causa'])); ?> <?= date('H:i',strtotime($detalles_reclamo[0]['Hora_evento_causa'])); ?></span></div>
      <div style="text-align: left;padding: 5px;"><strong> DESCRIPCIÓN DE LO OCURRIDO: </strong><span style="font-family: courier;"> <?= $detalles_reclamo[0]['ASUNTO']; ?></span></div>
    </div>
    <br>
    <h4 style="text-align: left; padding: -15px;"> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;5. EQUIPO(S) / INSTALACION(ES) DAÑADA(S)</h4>
    <div style="border: solid 1px #000;width:100%;">
      <?php if(empty($detalles_equipos)){ ?>
        <div style="text-align: left;padding: 5px;"><span><strong> En la reclamación no se detallaron equipos dañados. </strong></span></div>
      <?php } else { ?>
        <table style="">
          <tr>
            <td style="width:15%; padding: 0px; text-align: center;"><strong> DESCRIPCIÓN</strong></td>
            <td style="width:15%; padding: 0px; text-align: center;"><strong> MARCA</strong></td>
            <td style="width:15%; padding: 0px; text-align: center;"><strong> MODELO</strong></td>
            <td style="width:15%; padding: 0px; text-align: center;"><strong> SERIE</strong></td>
            <td style="width:15%; padding: 0px; text-align: center;"><strong> AÑO</strong></td>
            <td style="width:15%; padding: 0px; text-align: center;"><strong> OBSERVACIONES</strong></td>
          </tr>
          <?php 
          foreach ($detalles_equipos as $key => $valor) {
             ?>
          <tr>
            <td style="width:15%; padding: 0px; text-align: center;"><?= $valor['Descripcion']; ?></td>
            <td style="width:15%; padding: 0px; text-align: center;"><?= $valor['Marca']; ?></td>
            <td style="width:15%; padding: 0px; text-align: center;"><?= $valor['Modelo']; ?></td>
            <td style="width:15%; padding: 0px; text-align: center;"><?= $valor['Serie']; ?></td>
            <td style="width:15%; padding: 0px; text-align: center;"><?= $valor['Anio']; ?></td>
            <td style="width:15%; padding: 0px; text-align: center;"><?= $valor['Observaciones']; ?></td>
          </tr>
          <?php } ?>
        </table>
      <?php } ?>
    </div>
    <br>
    <h4 style="text-align: left; padding: -15px;"> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;6. FIRMAS</h4>
    <table style="height: 10%;">
    </table>
    <!--footer style="position: fixed; bottom: 3%; font-size: 9px; height:35px;"-->
      <table style="border:solid 1px white; width: 80%; border-collapse: collapse;">
        <tr>
          <td style="border:solid 1px white;text-align: left; width: 20%"></td>
          <td style="border:solid 1px white; border-top: solid 1px black; text-align: center; width: 40%;"> REPRESENTANTE DE <?= $nombre_empresa; ?> </td>
          <td style="border:solid 1px white;text-align: left; width: 30%"></td>
          <td style="border:solid 1px white;border-top: solid 1px black; text-align: center; width: 40%;"> <?= $detalles_reclamo[0]['Nombres']; ?> </td>
        </tr>
        <tr style="padding: -50px;">
          <td style="border:solid 1px white;text-align: left; width: 20%"></td>
          <td style="border:solid 1px white; border-top: solid 1px black; text-align: center; width: 40%;">  </td>
          <td style="border:solid 1px white;text-align: left; width: 30%"></td>
          <td style="border:solid 1px white;border-top: solid 1px black; text-align: center; width: 40%;"> CI: <?= $detalles_reclamo[0]['Ci_reclamante']; ?> </td>
        </tr>
      </table>
    <!--/footer-->
    <br>
    <div style="border: solid 1px #000;width:100%;">
      <div style="text-align: left;padding: 5px;"><span><strong> IMPORTANTE.- Para ser atendido en su reclamación debe conservar esta copia, y presentarla cada vez que se le solicite.</strong></span></div>
    </div>
    <br>
    <div style="width:100%;">
      <div style="text-align: left;padding: 5px; font-size: 10px;font-style: oblique; text-align: center;"><span><strong> "EMPRESA SUPERVISADA Y REGULADA POR LA AUTORIDAD DE FISCALIZACIÓN Y CONTROL SOCIAL DE ELECTRICIDAD (AE)" </strong></span></div>
    </div>
  </body>
</html>
