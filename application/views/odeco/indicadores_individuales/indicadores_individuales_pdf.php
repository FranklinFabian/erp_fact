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
        <td style="border: hidden; text-align: right;font-size:12px; "><strong> FORMULARIO - ST2</strong></td>
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
        <td style="width:40%; border: 0.5px solid black; text-align: center;font-size:12px;">&nbsp;<?= $nombre_empresa; ?></td>
        <td style="width:20%; border: hidden;border-left: 0.5px;  text-align: right;font-size:12px;"><strong> SIGLA: </strong></td>
        <td style="width:20%; border: 0.5px solid black; text-align: center;font-size:12px;"> <?= $sigla; ?> </td>
      </tr>
      <tr style="">
        <td style="width:20%; border: hidden; text-align: right;font-size:12px; "><strong> </strong></td>
        <td style="width:40%; border: hidden; border-top: 0.5px; text-align: right;font-size:12px; "></td>
        <td style="width:20%; border: hidden; text-align: right;font-size:12px; "><strong> PERIODO:</strong></td>
        <td style="width:20%; border-top: 0.5px solid black; text-align: center;font-size:12px; "><?= $semestre; ?></td>
      </tr>
    </table>
    <table style="border-spacing: 5px 5px;border-collapse: separate; border:0.5px;width: 100%">
      <tr>
        <td style="width:40%; border: hidden; text-align: right;font-size:12px; "><strong> LÍMITE DE FRECUENCIA: </strong></td>
        <td style="width:10%; border: 0.5px solid black; text-align: center;font-size:12px; "> 12** </td>
        <td style="width:30%; border: hidden;border-left: 0.5px;  text-align: right;font-size:12px; "><strong> LÍMITE DE TIEMPO: </strong></td>
        <td style="width:10%; border: 0.5px solid black; text-align: center;font-size:12px;"><strong> 13** </strong></td>
      </tr>
    </table>
    <table style="border:0.5px; width: 100%">
      <tr>
        <td style="text-align: center;font-size:12px;" colspan="2"><strong> CONSUMIDOR </strong></td>
        <td style="text-align: center;font-size:12px; " colspan="3"><strong> (F) FRECUENCIA </strong></td>
        <td style="text-align: center;font-size:12px; " colspan="3"><strong> (T) TIEMPO TOTAL [HORAS] </strong></td>
      </tr>
      <tr>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> CUENTA </strong></td>
        <td style="width:25%; text-align: center;font-size:12px;"><strong> RAZÓN SOCIAL </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> PROGRAMADA </strong></td>
        <td style="width:10%; border: 0.5px solid black; text-align: center;font-size:12px;"><strong> FORZADA </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> TOTAL </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> PROGRAMADA </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> FORZADA </strong></td>
        <td style="width:10%; border: 0.5px solid black; text-align: center;font-size:12px;"><strong> TOTAL </strong></td>
      </tr>
      <!-- <tr>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> CUENTA </strong></td>
        <td style="width:25%; text-align: center;font-size:12px;"><strong> RAZÓN SOCIAL </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> PROGRAMADA </strong></td>
        <td style="width:10%; border: 0.5px solid black; text-align: center;font-size:12px;"><strong> FORZADA </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> TOTAL </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> PROGRAMADA </strong></td>
        <td style="width:10%; text-align: center;font-size:12px;"><strong> FORZADA </strong></td>
        <td style="width:10%; border: 0.5px solid black; text-align: center;font-size:12px;"><strong> TOTAL </strong></td>
      </tr> -->
    </table>
    <br>
    <br>
    <table style="height: 10%;">
    </table>
    <!--footer style="position: fixed; bottom: 3%; font-size: 9px; height:35px;"-->
      <table style="border:solid 1px white; width: 80%; border-collapse: collapse;">
        <tr>
          <td style="border:solid 1px white;text-align: left; width: 20%"></td>
          <td style="border:solid 1px white; text-align: center; width: 40%;"><strong> GERENTE GENERAL </strong></td>
          <td style="border:solid 1px white;text-align: left; width: 30%"></td>
          <td style="border:solid 1px white; text-align: center; width: 40%;"><strong> RESPONSABLE EMPRESA </strong></td>
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
