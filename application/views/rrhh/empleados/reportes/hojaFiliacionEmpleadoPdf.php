<?php $html = '
<html>
  <head>
    <title>HOJA FILIACIÓN EMPLEADO</title>
    <style>
      @page { margin: 45px 45px 200px; } /* top left&right botoom*/
      #footer { position: fixed; left: 0px; bottom: -145px; right: 0px; height: 145px; background-color: white; }
      #cuadroGeneral { position: fixed; left: -4px; top: 0px; right: -4px; height: 952px; background-color: transparent; }
      body { font-size:80%; font-family: "Helvetica";}
      .tamanioTitulo{ font-size:100%; }
      .fontSize11px{ font-size: 11px; }
      .fontSize12px{ font-size: 12px; }
      .textCenter{ text-align:center; }
      .textRight{ text-align: right; }
      .bold{ font-weight: 600; }
      .borde4{ border: 1px solid #444; }
      .pl-5{ padding-left: 5px; }
      .tabla_datos { margin: 20px 50px 0px 50px; }
    </style>
  </head>
  <body>
    <div>
      <table border="0" cellspacing="0" width="100%" id="tabla_cabecera" class="borde4">
        <tr>
          <td class="textCenter fontSize11px pl-5" width="35%">
            <span>'.$this->empresa_nombre.'</span><br>
            <span>'.$this->empresa_direccion.'</span>
          </td>
          <td class="textCenter" width="30%">
            <span class="tamanioTitulo bold">HOJA FILIACIÓN</span>
          </td>
          <td class="textRight fontSize11px" width="35%">'.date('d/m/Y H:i:s').' <br><br><br></td>
        </tr>
      </table>

      <table border="0" cellspacing="0" width="100%" class="tabla_datos">
        <tr>
          <th width="25%">Empleado</th>
          <td width="75%">'.$data_empleado->paterno.' '.$data_empleado->materno.' '.$data_empleado->nombre1.' '.$data_empleado->nombre2.'</td>
        </tr>
        <tr>
          <th>Documento</th>
          <td>'.$data_empleado->empleado.' '.$data_empleado->ci_extension.' ('.$data_empleado->documento.')</td>
        </tr>
        <tr>
          <th>Edad</th>
          <td>'.(intval(date('Y')) - intval(explode('-', $data_empleado->fecha_nacimiento)[0])).'</td>
        </tr>
        <tr>
          <th>Teléfono</th>
          <td>'.$data_empleado->telefono.'</td>
        </tr>
        <tr>
          <th>Dirección</th>
          <td>'.$data_empleado->direccion.'</td>
        </tr>
        <tr>
          <th>Zona</th>
          <td>'.$data_empleado->zona.' Nro. '.$data_empleado->numero.'</td>
        </tr>
        <tr>
          <th>&nbsp;</th>
          <td></td>
        </tr>
        <tr>
          <th>Profesión</th>
          <td>'.$data_empleado->profesion.'</td>
        </tr>
        <tr>
          <th>Estado civil</th>
          <td>'.$data_empleado->estado_civil.'</td>
        </tr>
        <tr>
          <th>Grado de instrucción</th>
          <td>'.$data_empleado->grado_instruccion.'</td>
        </tr>
        <tr>
          <th>Nacionalidad</th>
          <td>'.$data_empleado->nacionalidad.'</td>
        </tr>
        <tr>
          <th>Genero</th>
          <td>'.$data_empleado->sexo.'</td>
        </tr>
        <tr>
          <th>Fecha de nacimiento</th>
          <td>'.date('d/m/Y', strtotime($data_empleado->fecha_nacimiento)).'</td>
        </tr>
      </table>
    </div>
  </body>
</html>';