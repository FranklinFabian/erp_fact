<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Formulario Retrasos</title>
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
  </style>
  <body style="font-family: Times New Roman, Times, serif; font-size:12px;">
    <table style="border: hidden;width: 100%">
      <tr>
        <td style="border: hidden;font-size:16px; padding-top: 30px;"><strong> <?= $titulo; ?> </strong></td>
      </tr>
    </table>
    <br>
    <table style="border-spacing: 5px 5px;border-collapse: separate; border:0.5px;width:100%;">
      <tr>
        <td style="width:15%; border: hidden; text-align: right;font-size:12px;"><strong> SISTEMA: </strong></td>
        <td style="width:45%; border: 0.5px solid black; text-align: left;font-size:12px;">&nbsp;<?= $nombre_empresa['nombre']; ?></td>
        <td style="width:20%; border: hidden; text-align: right;font-size:12px; "><strong> PERIODO:</strong></td>
        <td style="width:20%; border-top: 0.5px solid black; text-align: center;font-size:12px; "><strong> <?= $periodo; ?></strong></td>
      </tr>
    </table><br>
    <table style="border:0.5px; width: 100%">
      <tr>
        <td style="width:15%; text-align: center;font-size:12px;"><strong> NRO CUENTA </strong></td>
        <td style="width:15%; text-align: center;font-size:12px;"><strong> CATEGORIA </strong></td>
        <td style="width:15%; text-align: center;font-size:12px;"><strong> FECHA CORTE </strong></td>
        <td style="width:15%; text-align: center;font-size:12px;"><strong> FECHA PAGO </strong></td>
        <td style="width:15%; text-align: center;font-size:12px;"><strong> FECHA REP. </strong></td>
        <td style="width:12%; text-align: center;font-size:12px;"><strong> TIEMPO (DIÁS) </strong></td>
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
    <table style="border-spacing: 5px 5px;border-collapse: separate; border:0.5px;width:30%;">
      <tr>
        <td style="width:5%; border: hidden; text-align: right;font-size:12px;"><strong> CALIDAD: </strong></td>
        <td style="width:3%; border: 0.5px solid black; text-align: center;font-size:12px;"> <?= $nivel_calidad; ?> </td>
      </tr>
      <tr>
        <td style="width:5%; border: hidden; text-align: right;font-size:12px; "><strong> HORAS:</strong></td>
        <td style="width:3%; border-top: 0.5px solid black; text-align: center;font-size:12px; "> 0 </td>
      </tr>
    </table>
  </body>
</html>
