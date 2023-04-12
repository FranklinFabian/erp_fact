<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?= $titulo; ?></title>
  </head>
  <style media="screen">
    td{
      text-align:center;
      vertical-align: middle;
      border: solid 1px black;
      font-size: 12px;
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
      font-weight: 500;
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
    <table style="border: hidden;width: 100%">
      <tr>
        <td style="border: hidden; text-align: right;font-size:12px; "><strong> FORMULARIO - SC1</strong></td>
      </tr>
      <tr>
        <td style="border: hidden;font-size:25px;"><strong> <?= $titulo; ?> </strong></td>
      </tr>
      <tr>
        <td style="border: hidden;font-size:16px; padding-top: 5px;"><strong> <?= $descripcion; ?> </strong></td>
      </tr>
    </table>
    <br>
    <table style="border-spacing: 5px 5px;border-collapse: separate; border:0.5px;width:100%;">
      <tr>
        <td style="width:20%; border: hidden; text-align: right;font-size:12px;"><strong> SISTEMA: </strong></td>
        <td style="width:40%; border: 0.5px solid black; text-align: center;font-size:12px;"><?= $nombre_empresa; ?></td>
        <td style="width:20%; border: hidden;border-left: 0.5px;  text-align: right;font-size:12px;"><strong> SIGLA: </strong></td>
        <td style="width:20%; border: 0.5px solid black; text-align: center;font-size:12px;"><strong> COOPELECT</strong></td>
      </tr>
      <tr style="">
        <td style="width:20%; border: hidden; text-align: right;font-size:12px; "><strong> </strong></td>
        <td style="width:40%; border: hidden; border-top: 0.5px; text-align: right;font-size:12px; "></td>
        <td style="width:20%; border: hidden; text-align: right;font-size:12px; "><strong> PERIODO:</strong></td>
        <td style="width:20%; border-top: 0.5px solid black; text-align: center;font-size:12px; "><strong> <?= $periodo; ?> </strong></td>
      </tr>
    </table>
    <table style="border-spacing: 5px 5px; border:0.5px;width: 100%; margin-top: 5px;">
      <tr>
        <td style="width:8%; text-align: center;font-size:12px; border: hidden;"></td>
        <td style="width:25%; text-align: center;font-size:12px; border: hidden;"></td>
        <td style="width:15%; text-align: center;font-size:12px;"><strong> Valores Limites Según Reglamento </strong></td>
        <td style="width:15%; text-align: center;font-size:12px;"><strong> Valores Obtenidos en el Semestre </strong></td>
        <td style="width:15%; text-align: center;font-size:12px;"><strong> Variación Porcentual (%) </strong></td>
        <td style="width:15%; text-align: center;font-size:12px;"><strong> Ventas de Energía del Semestre (kWh) </strong></td>
        <td style="width:15%; text-align: center;font-size:12px;"><strong> Monto de la Reducción (Bs) </strong></td>
      </tr>
      <tr>
        <td style="width:8%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> <strong> IRT </strong></td>
        <td style="width:25%; text-align: left;font-size:12px; padding: 10px 0px 10px 0px;"> &nbsp;Reclamos Técnicos por 100 Clientes </td>
        <td style="width:15%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> 0 </td>
        <td style="width:15%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> 0 </td>
        <td style="width:15%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> 0 </td>
        <td style="width:15%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> 0 </td>
        <td style="width:15%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> 0 </td>
      </tr>
      <tr>
        <td style="width:8%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> <strong>  IRC  </strong></td>
        <td style="width:25%; text-align: left;font-size:12px; padding: 10px 0px 10px 0px;"> &nbsp;Reclamos Comerciales por 100 Clientes </td>
        <td style="width:15%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> 0 </td>
        <td style="width:15%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> 0 </td>
        <td style="width:15%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> 0 </td>
        <td style="width:15%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> 0 </td>
        <td style="width:15%; text-align: center;font-size:12px; padding: 10px 0px 10px 0px;"> 0 </td>
      </tr>
    </table>
    <br><br>
    <table style="border-spacing: 5px 5px; border:0.5px;width: 100%">
      <tr>
        <td style="width:40%;text-align: justify; border-right: 0.5px solid black; vertical-align: text-top;"><strong> OBSERVACIONES:</strong></td>
        <td style="width:3%;  border-left: 1px; border-top: :hidden;border-bottom: hidden;"></td>
        <td style="width:55%;">
          <table style="border-spacing: 5px 5px; border:0.5px;width: 100%">
            <tr>
              <td style="width:60%; text-align: left; padding: 5px;"><strong>Nro. de Consumidores al Último mes del Periodo:</strong></td>
              <td style="width:30%; padding: 5px;">0</td>
            </tr>
            <tr>
              <td style="width:60%; text-align: left; padding: 5px;"><strong>Nro. Total de Reclamaciones Técnicas:</strong></td>
              <td style="width:30%; padding: 5px;">0</td>
            </tr>
            <tr>
              <td style="width:60%; text-align: left; padding: 5px;"><strong>Nro. Total de Reclamaciones Técnicas Justificadas:</strong></td>
              <td style="width:30%; padding: 5px;">0</td>
            </tr>
            <tr>
              <td style="width:60%; text-align: left; padding: 5px;"><strong>Nro. Total de Reclamaciones Comerciales:</strong></td>
              <td style="width:30%; padding: 5px;">0</td>
            </tr>
            <tr>
              <td style="width:60%; text-align: left; padding: 5px;"><strong>Nro. Total de Reclamaciones Comerciales Justificadas:</strong></td>
              <td style="width:30%; padding: 5px;">0</td>
            </tr>
            <tr>
              <td style="width:60%; text-align: left; padding: 5px;"><strong>Precio Básico de Energía (Bs/kWh):</strong></td>
              <td style="width:30%; padding: 5px;">0</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <br>
    <br>
    <table style="height: 10%;">
    </table>
    <!--footer style="position: fixed; bottom: 3%; font-size: 9px; height:35px;"-->
      <table style="border:solid 1px white; width: 80%; border-collapse: collapse;">
        <tr>
          <td style="border:solid 1px white;text-align: left; width: 20%"></td>
          <td style="border:solid 1px white; text-align: center; width: 40%;border-top: 1px solid black"><strong> GERENTE GENERAL </strong></td>
          <td style="border:solid 1px white;text-align: left; width: 30%"></td>
          <td style="border:solid 1px white; text-align: center; width: 40%;border-top: 1px solid black"><strong> RESPONSABLE EMPRESA </strong></td>
        </tr>
      </table>
    <!--/footer-->
    <br>
    <div style="width:100%;">
      <div style="text-align: right;padding: 5px; font-size: 8px;"><strong> FECHA Y HORA (GENERACION REPORTE):</strong> <span> <?php date_default_timezone_set('America/La_Paz');
                $now = date('d/m/Y H:i');
                echo ($now); ?></span></div>
    </div>
  </body>
</html>
