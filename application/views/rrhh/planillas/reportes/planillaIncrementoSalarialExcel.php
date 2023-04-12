<?php
  date_default_timezone_set('America/La_Paz');
  # header para exportar en excel
  $tipo       = 'excel';
  $extension  = $tipo == 'excel' ? '.xls' : '.doc';
  $nombreExt  = 'Planilla Incremento Salarial - Gestión '.$gestion.' - '.date('d/m/Y H:i:s').$extension;
  header("Content-type: application/vnd.ms-$tipo"); /* Indica que tipo de archivo es que va a descargar */
  header("Content-Disposition: attachment; filename=$nombreExt"); /* El nombre del archivo y la extensiòn */
  header("Pragma: no-cache");
  header("Expires: 0");
?>
<style>
  #tabla_principal {
    font-size: 11px;
  }
  .textCenter12px{ text-align: center; font-size:12px;}
  .textLeft12px{ text-align: left; font-size:12px; }
  .textRight10px{ text-align: right; font-size:11px; }
  .textLeft10px{ text-align: left; font-size:11px; }
  .borde4{ padding: 3px; border: 1px solid black;}
  .bold{ font-weight: bold; }
</style>

<table border="1" width="100%" id="tabla_principal">
  <thead>
    <tr>
      <th>Empleado</th>
      <th>NOMBRES</th>
      <th>Nacionalidad</th>
      <th>Nacimiento</th>
      <th>Cargo</th>
      <th>FecIngreso</th>
      <th>Mes</th>
      <th>Días_Trabajados</th>
      <th>HABER_MENSUAL</th>
      <th>HABER_REEMPLAZO</th>
      <th>HABER_EXTRAS</th>
      <th>BONO_ANTIGUEDAD</th>
      <th>BONO_FRONTERA</th>
      <th>OTROS_INGRESOS</th>
      <th>TOTAL_GANADO</th>
      <th>AFP_INDIVIDUAL</th>
      <th>AFP_COMUN</th>
      <th>AFP_COMISION</th>
      <th>AFP_SOLIDARIDAD</th>
      <th>RC_IVA</th>
      <th>CLUB</th>
      <th>Sancion</th>
      <th>TOTAL_DESCUENTOS</th>
      <th>LIQUIDO_PAGABLE</th>
      <th>Afp_Patronal</th>
      <th>Pat_Cns</th>
      <th>Pat_Fonvis</th>
      <th>Pat_Afp_solidaridad</th>
      <th>Aguinaldo</th>
      <th>Aguinaldo2</th>
      <th>Indemnizacion</th>
      <th>Prima</th>
      <th>SERVICIO</th>
      <th>Seccion</th>
      <th>Item</th>
      <th>TOTAL_GANADO_ACTUAL</th>
      <th>TOTAL_GANADO_ANTERIOR</th>
      <th>HABER_BASICO_ACTUAL</th>
      <th>HABER_BASICO_ANTERIOR</th>
      <th>Clasificacion_Laboral</th>
      <th>Tipo_Contrato</th>
      <th>Horas_Pagadas</th>
      <th>CUENTA</th>
    </tr>
  </thead>
    <tbody>
    <?php
      $this->salario_empleado = [];
      $this->empleado = '';
      $this->mes      = '';
      $a1=0; $a2=0; $a3=0; $a4=0; $a5=0; $a6=0;
    if(count($data_incremento_salarial) > 0):
        foreach($data_incremento_salarial as $dis):
          $this->empleado = $dis->empleado;
          $this->mes      = $dis->mes;
          $this->salario_empleado = array_filter($data_salario, function($s) {
            return $s->empleado == $this->empleado && $s->mes == $this->mes;
          });
          $this->salario_empleado = reset($this->salario_empleado);
    ?>
        <tr>
            <td> <?php echo $dis->empleado;                                                       ?></td>
            <td> <?php echo $dis->nombre_empleado;                                                ?></td>
            <td> <?php echo $dis->nacionalidad;                                                   ?></td>
            <td> <?php echo date('d/m/Y', strtotime($dis->fecha_nacimiento));                     ?></td>
            <td> <?php echo $dis->cargo;                                                          ?></td>
            <td> <?php echo date('d/m/Y', strtotime($dis->fecha_ingreso));                        ?></td>
            <td> <?php echo date('d/m/Y', strtotime($dis->mes));                                  ?></td>
            <td> <?php echo $dis->dias_trabajados;                                                ?></td>
            <td> <?php echo ($dis->haber_mensual - $this->salario_empleado->haber_mensual);       ?></td>
            <td> <?php echo ($dis->haber_reemplazo - $this->salario_empleado->haber_reemplazo);   ?></td>
            <td> <?php echo ($dis->haber_extras - $this->salario_empleado->haber_extras);         ?></td>
            <td> <?php echo ($dis->bono_antiguedad - $this->salario_empleado->bono_antiguedad);   ?></td>
            <td> <?php echo ($dis->bono_frontera - $this->salario_empleado->bono_frontera);       ?></td>
            <td> <?php echo ($dis->otros_ingresos - $this->salario_empleado->otros_ingresos);     ?></td>
            <td> <?php echo ($dis->total_ganado - $this->salario_empleado->total_ganado);         ?></td>
            <td> <?php echo ($dis->afp_individual - $this->salario_empleado->afp_individual);     ?></td>
            <td> <?php echo ($dis->afp_comun - $this->salario_empleado->afp_comun);               ?></td>
            <td> <?php echo ($dis->afp_comision - $this->salario_empleado->afp_comision);         ?></td>
            <td> <?php echo ($dis->sol_laboral - $this->salario_empleado->sol_laboral);           ?></td> <!-- afp_solidario -->
            <td> <?php echo ($dis->rc_iva - $this->salario_empleado->rc_iva);                     ?></td>
            <td> <?php echo ($dis->club - $this->salario_empleado->club);                         ?></td>
            <td> <?php echo ($dis->sancion - $this->salario_empleado->sancion);                   ?></td>
            <td> <?php echo ($dis->total_descuentos - $this->salario_empleado->total_descuentos); ?></td>
            <td> <?php echo ($dis->liquido_pagable - $this->salario_empleado->liquido_pagable);   ?></td>
            <td> <?php echo ($dis->pat_afp - $this->salario_empleado->pat_afp);                   ?></td> <!-- afp_patronal -->
            <td> <?php echo ($dis->pat_cns - $this->salario_empleado->pat_cns);                   ?></td>
            <td> <?php echo ($dis->pat_fonvis - $this->salario_empleado->pat_fonvis);             ?></td>
            <td> <?php echo ($dis->sol_patronal - $this->salario_empleado->sol_patronal);         ?></td> <!-- pat_afp_solidaridad -->
            <td> <?php echo ($dis->aguinaldo - $this->salario_empleado->aguinaldo);               ?></td>
            <td> <?php echo ($dis->aguinaldo2 - $this->salario_empleado->aguinaldo2);             ?></td>
            <td> <?php echo ($dis->indemnizacion - $this->salario_empleado->indemnizacion);       ?></td>
            <td> <?php echo ($dis->prima - $this->salario_empleado->prima);                       ?></td>
            <td> <?php echo $dis->servicio;                                                       ?></td>
            <td> <?php echo $dis->seccion;                                                        ?></td>
            <td> <?php echo $dis->item;                                                           ?></td>
            <td> <?php echo $dis->total_ganado;                                                   ?></td> <!-- total_ganado_actual -->
            <td> <?php echo $this->salario_empleado->total_ganado;                                ?></td> <!-- total_ganado_anterior -->
            <td> <?php echo $dis->haber_mensual;                                                  ?></td> <!-- haber_basico_actual -->
            <td> <?php echo $this->salario_empleado->haber_mensual;                               ?></td> <!-- haber_basico_anterior -->
            <td> <?php echo $dis->clasificacion_laboral;                                          ?></td>
            <td> <?php echo $dis->contrato;                                                       ?></td>
            <td> <?php echo $dis->horas_pagadas;                                                  ?></td>
            <td> <?php echo '-';                                                                  ?></td> <!-- ??? -->
        </tr>
    <?php
        endforeach;
    else:
    ?>
        <tr>
            <td colspan="45">No Existen Registros</td>
        </tr>
    <?php
    endif;
    ?>
    </tbody>
    <!--<tfoot>
        <tr>
            <th colspan="4" class="textLeft10px">C.I.</th>
            <th class="textLeft10px">NOMBRE COMPLETO RESPONSABLE</th>
            <th colspan="3" class="textLeft10px">TOTALES GENERALES</th>
            <td class="textRight10px"><?php echo number_format($a1, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a2, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a3, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a4, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a5, 2); ?></td>
            <td class="textRight10px"><?php echo number_format($a6, 2); ?></td>
            <td class="textRight10px"> </td>
            <td class="textRight10px"> </td>
        </tr>
    </tfoot>-->
</table>