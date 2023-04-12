<?php
  $archivo_banco = 'Sueldo correspondiente al mes de '.$nombre_mes.PHP_EOL;
  foreach($emp_liq_pag_mes as $elpm):
    $archivo_banco .= $elpm->cuenta.number_format($elpm->liquido_pagable, 3, ',','').PHP_EOL;
  endforeach;

  $nombreExt  = 'Archivo para banco - '.$mes_anio.'.txt';
  header('Content-Description: File Transfer');
  header("Content-Type: text/plain");
  header("Content-Disposition: attachment; filename=$nombreExt");
  header("Content-Transfer-Encoding: binary");
  header("Content-Length: ".strlen($archivo_banco));
  header('Cache-Control: must-revalidate');
  header("Pragma: public");
  header("Expires: 0");

  echo $archivo_banco;
?>

