<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Calculos extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Cálculos', base_url('rrhh/calculos'));
  }

  # routes
  public function index()
  {
    $data = [
      'data_meses' => $this->rrhhModel->getMesHabilidato(),
      'data_empleados' => $this->rrhhModel->getEmpleados()
    ];

    $content = $this->parser->parse('rrhh/calculos/indexCalculos', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  // PLANILLAS SALARIALES
  public function planilla_salarial()
  {
    $mes_planilla = $this->input->post('mes');
    list($anio, $mes, $dia) = explode('-', $mes_planilla);
    $mes_ini = $anio . '-' . $mes . '-01';
    $mes_fin = $mes_planilla;

    # lectura de los parametros del mes a trabajar
    $this->parametros_mes = $this->rrhhModel->getParametrosMes($mes_planilla);

    $data_empleados = $this->rrhhModel->getEmpleados();
    $res['response'] = FALSE;
    foreach ($data_empleados as $data_empleado) {
      $data_empleado_sueldo   = $this->calcularSueldoEmpleado($data_empleado, $mes_planilla, $mes_ini, $mes_fin);
      $empleado               = $data_empleado->empleado;
      # VERIFICAR SI ES REGISTRO O SI ES ACTUALIZACIÓN DE DATOS
      $calculo_empleado       = $this->rrhhModel->existeCalculosPlanillaSalarialEmpleado($empleado, $mes_planilla);
      if ($calculo_empleado == null) {
        # REGISTRAR DATOS SUELDO EMPLEADO
        $res['response']    = $this->rrhhModel->registrarCalculosPlanillaSalarialEmpleado($data_empleado_sueldo);
      } else {
        # ACTUALIZAR DATOS SUELDO EMPLEADO
        $id_sueldo          = $calculo_empleado->id;
        $res['response']    = $this->rrhhModel->actualizarCalculosPlanillaSalarialEmpleado($id_sueldo, $data_empleado_sueldo);
      }
    }

    echo json_encode($res);
    exit;
  }
  private function calcularSuplencias($mes_ini, $mes_fin, $empleado, $basico_empleado)
  {
    $enum_remamplia         = $this->rrhhModel->get_enum_values('rrhh_empleado_suplencia', 'remamplia'); # tabla, columna
    $data_suplencias        = $this->rrhhModel->getSuplenciasByMesEmpleado($mes_ini, $mes_fin, $empleado);
    $res['remamplia']       = '';
    $res['item_reemplazo']  = '';
    $res['dias_reemplazo']  = 0;
    $res['haber_reemplazo'] = 0;
    foreach ($data_suplencias as $s) {
      $haberBasicoRemplazo    = $this->rrhhModel->getHaberBasicoByItem($s->item)->basico;
      if ($s->remamplia == $enum_remamplia[2]) { # Remplaza
        $haberRemplazo          = round((($haberBasicoRemplazo - $basico_empleado) / 30) * $s->dias, 2, PHP_ROUND_HALF_DOWN);
      } else if ($s->remamplia == $enum_remamplia[1]) { # Ampliación
        $haberRemplazo          = round((($haberBasicoRemplazo * 0.2) / 30) * $s->dias, 2, PHP_ROUND_HALF_DOWN);
      } else {
        $haberRemplazo          = 0;
      }
      $res['remamplia']       .= $s->remamplia . ' ';
      $res['item_reemplazo']  .= $s->item . ' ';
      $res['dias_reemplazo']  = $res['dias_reemplazo'] + $s->dias;
      $res['haber_reemplazo'] = $res['haber_reemplazo'] + $haberRemplazo;
    }
    return $res;
  }
  private function calcularHorasExtrasAndRecargoNocturno($mes_planilla, $empleado, $basico_empleado)
  {
    $data_horas_extras              = $this->rrhhModel->getHorasExtrasEmpleadoByMes($empleado, $mes_planilla);
    $res['horas_extras']            = 0;
    $res['haber_extras']            = 0;
    $res['horas_recargo_nocturno']  = 0;
    $res['monto_horas_nocturnas']   = 0;
    foreach ($data_horas_extras as $he) {
      $res['horas_extras']            += $he->dobles;
      $res['horas_recargo_nocturno']  += $he->nocturnas;
    }
    $res['horas_extras']            = round($res['horas_extras'], 2, PHP_ROUND_HALF_DOWN);
    $res['horas_recargo_nocturno']  = round($res['horas_recargo_nocturno'] * 0.3, 2, PHP_ROUND_HALF_DOWN);
    # formula horas extras
    $res['haber_extras']            = round((($basico_empleado / 30) / 8) * $res['horas_extras'], 2, PHP_ROUND_HALF_DOWN);
    # formula horas recargo nocturno
    $res['monto_horas_nocturnas']   = round((($basico_empleado / 30) / 8) * $res['horas_recargo_nocturno'], 2, PHP_ROUND_HALF_DOWN);
    return $res;
  }
  private function calcularBonoAntiguedad($mes_planilla, $fecha_ingreso, $dias_trabajados)
  {
    # bono antiguedad solo para personal con contrato INDEFINIDO ?
    # '= 2122*3*porcentajeAntiguedad(añosAntiguedad)/100)'
    $fechaIngreso           = new Datetime($fecha_ingreso);
    $fechaHoyCalc           = new Datetime($mes_planilla);
    $diff                   = $fechaIngreso->diff($fechaHoyCalc);
    $res['antiguedad']      = $diff->y;
    $porcentaje_bono        = $this->rrhhModel->getPorcentajeBonoAntiguedad($res['antiguedad']);
    $bono_antiguedad        = ((3 * floatval($this->parametros_mes->sueldo_minimo) * $porcentaje_bono->porcentaje) / 100);
    if ($dias_trabajados < 30) {
      $res['bono_antiguedad'] = round(($bono_antiguedad / 30) * $dias_trabajados, 2, PHP_ROUND_HALF_DOWN);
    } else {
      $res['bono_antiguedad'] = round($bono_antiguedad, 2, PHP_ROUND_HALF_DOWN);
    }
    return $res;
  }
  private function calcularEdadEmpleado($fecha_nacimiento, $mes_planilla)
  {
    $fechaNacimiento        = new Datetime($fecha_nacimiento);
    $fechaHoyCalc           = new Datetime($mes_planilla);
    $diff                   = $fechaNacimiento->diff($fechaHoyCalc);
    return $diff->y;
  }
  private function calcularSancion($fecha_ini, $fecha_fin, $empleado, $basico_empleado)
  {
    $sancion                = $this->rrhhModel->getSancionesEmpleadoMes($fecha_ini, $fecha_fin, $empleado);
    $res['dias_sancion']    = 0;
    $res['sancion']         = 0;
    if ($sancion != []) {
      $res['dias_sancion']    = $sancion->dias;
      $res['sancion']         = round((($basico_empleado) / 30) * $sancion->dias, 2, PHP_ROUND_HALF_DOWN);
    }
    return $res;
  }
  private function calcularSueldoEmpleado($data_empleado, $mes_planilla, $mes_ini, $mes_fin)
  {
    # Datos del empleado
    #$data_empleado = $this->rrhhModel->getEmpleado($empleado);
    $empleado   = $data_empleado->empleado;
    $edad_empleado = $this->calcularEdadEmpleado($data_empleado->fecha_nacimiento, $mes_planilla);

    # DATOS PLANILLA SALARIAL x EMPLEADO
    $data_emp_sueldo = [];
    # Empleado (CI -> id)
    $data_emp_sueldo['empleado']                = $empleado;
    # Mes Planillas
    $data_emp_sueldo['mes']                     = $mes_planilla;
    # Dias Trabajados (Datos de la asistencia)
    $data_emp_sueldo['dias_trabajados']         = 0; # ? - nro de días trabajados, el mes comercial 30 días
    # Haber Mensual
    $data_emp_sueldo['haber_mensual']           = $data_empleado->basico;
    # Remplazo Amplia - Suplencias (Ampliación/Reemplazo)
    $suplencias = $this->calcularSuplencias($mes_ini, $mes_fin, $empleado, $data_empleado->basico);
    $data_emp_sueldo['remamplia']               = $suplencias['remamplia'];
    # Item Reemplazo
    $data_emp_sueldo['item_reemplazo']          = $suplencias['item_reemplazo'];
    # Días Reemplazo
    $data_emp_sueldo['dias_reemplazo']          = $suplencias['dias_reemplazo'];
    # Haber Reemplazo
    $data_emp_sueldo['haber_reemplazo']         = $suplencias['haber_reemplazo'];
    # Horas Extras (dobles) y Recargo Noctunro (recargo)
    $horas_extras   = $this->calcularHorasExtrasAndRecargoNocturno($mes_planilla, $empleado, $data_empleado->basico);
    $data_emp_sueldo['horas_extras']            = $horas_extras['horas_extras'];
    # Haber Extras
    $data_emp_sueldo['haber_extras']            = $horas_extras['haber_extras'];
    # Horas Recargo Nocturno
    $data_emp_sueldo['horas_recargo_nocturno']  = $horas_extras['horas_recargo_nocturno'];
    # Monto Horas Nocturnas
    $data_emp_sueldo['monto_horas_nocturnas']   = $horas_extras['monto_horas_nocturnas'];
    # Antiguedad
    $antiguedad = $this->calcularBonoAntiguedad($mes_planilla, $data_empleado->fecha_ingreso, 30);
    $data_emp_sueldo['antiguedad']              = $antiguedad['antiguedad'];
    # Bono Antiguedad
    $data_emp_sueldo['bono_antiguedad']         = $antiguedad['bono_antiguedad'];
    # Bono Frontera
    $bono_frontera = round($data_empleado->basico * floatval($this->parametros_mes->bono_frontera), 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['bono_frontera']           = $bono_frontera;
    # Otros Ingresos
    $otros_ingresos = 0; # ?
    $data_emp_sueldo['otros_ingresos']          = $otros_ingresos;
    # Total Ganado
    $total_ganado = $data_empleado->basico + $suplencias['haber_reemplazo'] + $horas_extras['haber_extras'] + $horas_extras['monto_horas_nocturnas'] + $antiguedad['bono_antiguedad'] + $bono_frontera;
    $data_emp_sueldo['total_ganado']            = $total_ganado;
    # AFP Individual
    $afp_individual = round($total_ganado * $this->parametros_mes->afp_individual, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['afp_individual']          = $afp_individual;
    # Afp comun (riesgo)
    $afp_comun = ($edad_empleado >= 65) ? 0 : round($total_ganado * $this->parametros_mes->afp_riesgo, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['afp_comun']               = $afp_comun;
    # Afp comision
    $afp_comision = round($total_ganado * $this->parametros_mes->afp_comision, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['afp_comision']            = $afp_comision;
    # Sol_Laboral
    $sol_laboral = round($total_ganado * $this->parametros_mes->sol_laboral, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['sol_laboral']             = $sol_laboral;
    # RC IVA
    $rc_iva = '?'; # Saldo Retenido de la planilla tributaria - round($total_ganado*$this->parametros_mes->rc_iva, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['rc_iva']                  = $rc_iva;
    # Club
    $club = ($data_empleado->club == '1') ? round(($data_empleado->basico * $this->parametros_mes->club), 2, PHP_ROUND_HALF_DOWN) : 0;
    $data_emp_sueldo['club']                    = $club;
    # Pulperia
    $data_emp_sueldo['pulperia']                = '-'; # ya no está en uso
    # Fondo Rotativo
    $fondo_rotativo         = 0;
    $data_fondo_rotativo    = $this->rrhhModel->getFondoRotativoEmpleadoMes($mes_planilla, $empleado);
    if ($data_fondo_rotativo != [])
      $fondo_rotativo = $data_fondo_rotativo->importe;
    $data_emp_sueldo['fondo_rotativo']          = $fondo_rotativo;
    # Anticipo
    $anticipo       = 0;
    $data_anticipo  = $this->rrhhModel->getAnticipoEmpleadoMes($mes_planilla, $empleado);
    if ($data_anticipo != [])
      $anticipo = $data_anticipo->importe;
    $data_emp_sueldo['anticipo']                = $anticipo;
    # Dias Sanción
    $sancion = $this->calcularSancion($mes_ini, $mes_fin, $empleado, $data_empleado->basico);
    $data_emp_sueldo['dias_sancion']            = $sancion['dias_sancion'];
    # Sanción
    $data_emp_sueldo['sancion']                 = $sancion['sancion'];
    # Otros Descuentos
    $otros_descuentos = 0; # Se registra el APORTE SINDICAL -> APORTE SINDICAL ?
    $data_emp_sueldo['otros_descuentos']        = $otros_descuentos;
    # Total Descuentos (falta otros_decuentos)
    $total_descuentos = round(($afp_individual + $afp_comun + $afp_comision + $sol_laboral + $club + $sancion['sancion']  + $anticipo + $otros_descuentos + $fondo_rotativo), 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['total_descuentos']        = $total_descuentos;
    # Sueldo_neto
    $sueldo_neto = round(($total_ganado - ($afp_individual + $afp_comun + $afp_comision + $sol_laboral)), 0, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['sueldo_neto']             = $sueldo_neto;
    # Minimos_No_Imponibles (dosMinimos (dosSalariosMinimoNacional))
    # Diferencia
    if ($sueldo_neto > ($this->parametros_mes->sueldo_minimo * 2)) {
      $minimos_no_imponibles  = round($this->parametros_mes->sueldo_minimo * 2, 2, PHP_ROUND_HALF_DOWN);
      $diferencia             = round(($sueldo_neto - $minimos_no_imponibles), 0, PHP_ROUND_HALF_DOWN);
    } else {
      $minimos_no_imponibles  = $sueldo_neto;
      $diferencia             = 0;
    }
    $data_emp_sueldo['minimos_no_imponibles']   = $minimos_no_imponibles;
    $data_emp_sueldo['diferencia']              = $diferencia;
    # Impuesto
    $impuesto = round($diferencia * $this->parametros_mes->rc_iva, 0, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['impuesto']                = $impuesto;
    # Form_101
    $form_101           = 0;
    $data_form_101      = $this->rrhhModel->getForm101EmpleadoMes($mes_planilla, $empleado);
    if ($data_form_101 != [])
      $form_101       = $data_form_101->importe;
    $data_emp_sueldo['form_101']                = $form_101;
    # Dos_Minimos (nDos_13_Minimos)
    $dos_minimos = round(($minimos_no_imponibles * $this->parametros_mes->rc_iva), 0, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['dos_minimos']             = $dos_minimos;
    # ImpuestoNeto
    if ($impuesto > $dos_minimos)
      $impuesto_neto  = round($impuesto - $dos_minimos, 0, PHP_ROUND_HALF_DOWN);
    else
      $impuesto_neto  = 0;
    $data_emp_sueldo['impuesto_neto']           = $impuesto_neto;
    # Fisco
    # Dependiente
    if (($impuesto - ($dos_minimos + $form_101)) > 0) {
      $fisco          = $impuesto - ($dos_minimos + $form_101);
      $dependiente    = 0;
    } else {
      $fisco          = 0;
      if ($impuesto <= $dos_minimos)
        $dependiente = $form_101;
      else
        $dependiente = ($dos_minimos + $form_101) - $impuesto;
    }
    $data_emp_sueldo['fisco']                   = $fisco;
    $data_emp_sueldo['dependiente']             = $dependiente;
    # Saldo_Anterior
    $saldo_anterior = 261; # Es el saldo del mes anterior del RC-IVA - ???
    $data_emp_sueldo['saldo_anterior']          = $saldo_anterior;
    # Mantenimiento
    $mantenimiento = round((($this->parametros_mes->cot_actual / $this->parametros_mes->cot_anterior) - 1) * $saldo_anterior, 0, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['mantenimiento']           = $mantenimiento;
    # Total_Actualizado
    $total_actualizado = round(($saldo_anterior + $mantenimiento), 0, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['total_actualizado']       = $total_actualizado;
    # Total_Dependiente
    $total_dependiente = round(($dependiente + $total_actualizado), 0, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['total_dependiente']       = $total_dependiente;
    # Saldo_Utilizado
    if ($fisco > $total_dependiente)
      $saldo_utilizado = $total_dependiente;
    else
      $saldo_utilizado = $fisco;
    $data_emp_sueldo['saldo_utilizado']         = $saldo_utilizado;
    # Saldo_Retenido
    $saldo_retenido = $fisco - $saldo_utilizado;
    $data_emp_sueldo['saldo_retenido']          = $saldo_retenido;
    # Saldo_Mes_Siguiente
    if (($total_dependiente - $saldo_retenido) > 0)
      $saldo_mes_siguiente    = $total_dependiente - $saldo_utilizado;
    else
      $saldo_mes_siguiente    = 0;
    $data_emp_sueldo['saldo_mes_siguiente']     = $saldo_mes_siguiente;
    # Total Descuentos (2da vez) (NO HAY EN LA TABLA)
    $total_descuentos = $total_descuentos + $saldo_retenido;
    # Liquido Pagable
    $liquido_pagable = $total_ganado - $total_descuentos;
    $data_emp_sueldo['liquido_pagable']         = $liquido_pagable;
    # Pat_Afp
    $pat_afp = ($edad_empleado >= 65) ? 0 : round($total_ganado * $this->parametros_mes->pat_afp, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['pat_afp']                 = $pat_afp;
    # Sol_Patronal
    $sol_patronal = round($total_ganado * $this->parametros_mes->sol_patronal, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['sol_patronal']            = $sol_patronal;
    # Pat_Cns
    $pat_cns = round($total_ganado * $this->parametros_mes->pat_cns, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['pat_cns']                 = $pat_cns;
    # Pat_Fonvis
    $pat_fonvis = round($total_ganado * $this->parametros_mes->pat_fonvis, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['pat_fonvis']              = $pat_fonvis;
    # Aguinaldo
    $aguinaldo = round($total_ganado * 0.0833, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['aguinaldo']               = $aguinaldo;
    # aguinaldo2
    $aguinaldo2 = round($total_ganado * 0.0833, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['aguinaldo2']              = $aguinaldo2;
    # PRIMA
    $prima = 0; #round($total_ganado * 0.0833, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['prima']                   = $prima;
    # Indemnizacion
    $indemnizacion = round($total_ganado * 0.0833, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['indemnizacion']           = $indemnizacion;
    # Pat_Total
    $pat_total = round($pat_afp + $pat_cns + $pat_fonvis + $sol_patronal + $aguinaldo + $indemnizacion + $prima + $aguinaldo2, 2, PHP_ROUND_HALF_DOWN);
    $data_emp_sueldo['pat_total']               = $pat_total;
    # Pre_Natal
    $pre_natal = 0;
    $data_emp_sueldo['pre_natal']               = $pre_natal;
    # Natal
    $natal = 0;
    $data_emp_sueldo['natal']                   = $natal;
    # Lactancia
    $lactancia = 0;
    $data_emp_sueldo['lactancia']               = $lactancia;
    # Cepelio
    $cepelio = 0;
    $data_emp_sueldo['cepelio']                 = $cepelio;
    # Total_Subsidio
    $total_subsidio = 0;
    $data_emp_sueldo['total_subsidio']          = $total_subsidio;
    # HORAS_EXTRAS_DOMINICALES
    $data_emp_sueldo['horas_extras_dominicales']    = 0; # ?
    # MONTO_EXTRAS_DOMINICALES
    $data_emp_sueldo['monto_extras_dominicales']    = 0; # ?
    # DOMINGOS_TRABAJADOS
    $data_emp_sueldo['domingos_trabajados']         = 0; # ?
    # MONTO_DOMINGOS_TRABAJADOS
    $data_emp_sueldo['monto_domingos_trabajados']   = 0; # ?
    # NRO_DOMINICALES
    $data_emp_sueldo['nro_dominicales']             = 0; # ?
    # SALARIO_DOMINICAL
    $data_emp_sueldo['salario_dominical']           = 0; # ?
    # BONO_PRODUCCION
    $data_emp_sueldo['bono_produccion']             = 0; # ?
    return $data_emp_sueldo;
  }

  //? INCREMENTO SALARIAL
  public function incremento_salarial()
  {
    $meses_planilla = $this->input->post('meses');
    foreach ($meses_planilla as $mes_planilla) {
      list($anio, $mes, $dia) = explode('-', $mes_planilla);
      $mes_ini = $anio . '-' . $mes . '-01';
      $mes_fin = $mes_planilla;

      # lectura de los parametros del mes a trabajar
      $this->parametros_mes = $this->rrhhModel->getParametrosMes($mes_planilla);

      $data_empleados = $this->rrhhModel->getEmpleados();
      foreach ($data_empleados as $data_empleado) {
        $data_empleado_inc_sal  = $this->calcularSueldoEmpleado($data_empleado, $mes_planilla, $mes_ini, $mes_fin);
        $empleado               = $data_empleado->empleado;
        # VERIFICAR SI ES REGISTRO O SI ES ACTUALIZACIÓN DE DATOS
        #$calculo_empleado       = $this->rrhhModel->existeCalculosPlanillaSalarialEmpleado($empleado, $mes_planilla);
        #if($calculo_empleado == null){
        # REGISTRAR DATOS INCREMENTO SALARIAL EMPLEADO
        #$res['response']    = $this->rrhhModel->registrarCalculosPlanillaSalarialEmpleado($data_empleado_inc_sal);
        #}else {
        # ACTUALIZAR DATOS INCREMENTO SALARIAL EMPLEADO
        #$id_sueldo          = $calculo_empleado->id;
        #$res['response']    = $this->rrhhModel->actualizarCalculosPlanillaSalarialEmpleado($id_sueldo, $data_empleado_inc_sal);
        #}
        #print_r($data_empleado_inc_sal);
      }
    }

    echo json_encode($meses_planilla);
    exit;
  }

  //? TODO: PLANILLA  AGUINALDOS
  //? TODO: BONO REFRIGERIO
}
