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
    <table style="border: hidden;width: 100%">
      <tr>
        <td style="border: hidden; text-align: right;font-size:12px; "><strong> FORMULARIO - ST1</strong></td>
      </tr>
      <tr>
        <td style="border: hidden;font-size:20px;"><strong> <?= $titulo; ?> </strong></td>
      </tr>
      <tr>
        <td style="border: hidden;font-size:12px; padding-top: 5px;"><strong> <?= $descripcion; ?> </strong></td>
      </tr>
    </table>
    <br>
    <table style="border-spacing: 5px 5px;border-collapse: separate; border:0.5px;width:100%;">
      <tr>
        <td style="width:20%; border: hidden; text-align: right;font-size:12px;"><strong> SISTEMA: </strong></td>
        <td style="width:40%; border: 0.5px solid black; text-align: center;font-size:12px;"><?= $nombre_empresa; ?></td>
        <td style="width:20%; border: hidden;border-left: 0.5px;  text-align: right;font-size:12px;"><strong> SIGLA: </strong></td>
        <td style="width:20%; border: 0.5px solid black; text-align: center;font-size:12px;"><strong> COOPOLECT</strong></td>
      </tr>
      <tr style="">
        <td style="width:20%; border: hidden; text-align: right;font-size:12px; "><strong> </strong></td>
        <td style="width:40%; border: hidden; border-top: 0.5px; text-align: right;font-size:12px; "></td>
        <td style="width:20%; border: hidden; text-align: right;font-size:12px; "><strong> PERIODO:</strong></td>
        <td style="width:20%; border-top: 0.5px solid black; text-align: center;font-size:12px; "><strong> 2020</strong></td>
      </tr>
    </table>
    <table style="border-spacing: 5px 5px; border:0.5px;width: 100%">
      <tr>
        <td style="width:10%; border: hidden;"></td>
        <td style="width:10%; border: 0.5px solid black; text-align: center;font-size:12px; "> <strong>LÍMITE DE FRECUENCIA: </strong></td>
        <td style="width:5%; border: 0.5px solid black;  text-align: center;font-size:12px; "> <?= $frecuencia; ?> </td>
        <td style="width:10%; border: hidden;border-left: 0.5px solid black;"></td>
        <td style="width:10%; border: 0.5px solid black; text-align: center;font-size:12px;"><strong> <strong>LÍMITE DE TIEMPO: </strong></td>
        <td style="width:5%; border: 0.5px solid black; text-align: center;font-size:12px;"><?= $tiempo; ?> </td>
        <td style="width:5%; border: hidden; hidden;border-left: 0.5px solid black;"></td>
      </tr>
    </table>
    <table style="border-spacing: 5px 5px; border:0.5px;width: 100%; margin-top: 5px;">
      <tr>
        <td style="width:20%; text-align: center;font-size:12px; border: hidden;"><strong> </strong></td>
        <td style="width:10%; text-align: center;font-size:12px; " colspan="3"><strong> (F) FRECUENCIA </strong></td>
        <td style="width:10%; text-align: center;font-size:12px; " colspan="3"><strong> (T) TIEMPO TOTAL [HORAS] </strong></td>
      </tr>
      <tr>
        <td style="width:20%; text-align: center;font-size:12px;"><strong> O R I G E N </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> PROGRAMADA </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> FORZADA </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> TOTAL </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> PROGRAMADA </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> FORZADA </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> TOTAL </strong></td>
      </tr>
      <tr>
        <td style="width:20%; text-align: left;font-size:12px;"> &nbsp;<strong> Subtransmisión </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
      </tr>
      <tr>
        <td style="width:20%; text-align: left;font-size:12px;"> &nbsp;<strong>  Distribución Primaria </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
      </tr>
      <tr>
        <td style="width:20%; text-align: left;font-size:12px;"> &nbsp;<strong>  Distribución Secundaria </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
      </tr>
      <tr>
        <td style="width:20%; text-align: left;font-size:12px;"> &nbsp;<strong>  Total Distribución </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
        <td style="width:10%; text-align: center;font-size:12px;"> 0 </td>
      </tr>
    </table>
    <br>
    <table style="border-spacing: 5px 5px; border:0.5px;width: 100%">
      <tr>
        <td style="width:55%;"></td>
        <td style="width:45%;">
          <table style="border-spacing: 5px 5px; border-collapse: separate; border:0.5px;width: 100%">
            <tr>
              <td style="width:60%;border: hidden; text-align: right;"><strong>TOTAL CONSUMIDORES EN BT:</strong></td>
              <td style="width:30%;">0</td>
              <td style="width:10%;border: hidden;"></td>
            </tr>
            <tr>
              <td style="width:60%;border: hidden; text-align: right;"><strong>TOTAL kVA INSTALADOS:</strong></td>
              <td style="width:30%;">0</td>
              <td style="width:10%;border: hidden;"></td>
            </tr>
            <tr>
              <td style="width:60%;border: hidden; text-align: right;"><strong>MÁXIMA TENSIÓN DISTRIBUCIÓN:</strong></td>
              <td style="width:30%;">0</td>
              <td style="width:10%;border: hidden;"><strong>kV</strong></td>
            </tr>
            <tr>
              <td style="width:60%;border: hidden; text-align: right;"><strong>LONGITUD LÍNEA EN BT:</strong></td>
              <td style="width:30%;">0</td>
              <td style="width:10%;border: hidden;"><strong>km</strong></td>
            </tr>
            <tr>
              <td style="width:60%;border: hidden; text-align: right;"><strong>LONGITUD LÍNEA EN MT:</strong></td>
              <td style="width:30%;">0</td>
              <td style="width:10%;border: hidden;"><strong>km</strong></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <p style="text-align: left;"><strong> OBSERVACIONES:</strong></p>
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
