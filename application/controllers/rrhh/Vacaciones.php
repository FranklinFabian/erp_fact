<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Vacaciones extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Vacaciones', base_url('rrhh/vacaciones'));
  }

  # routes
  public function index()
  {
    $data = [
      'data_mes_habilitado' => $this->rrhhModel->getMesHabilidato(),
      'data_control' => $this->rrhhModel->getControles(),
      'data_empleados' => $this->rrhhModel->getEmpleados(),
      'data_secciones' => $this->rrhhModel->getSecciones(),
      'data_servicios' => $this->rrhhModel->getSisServicios()
    ];

    $content = $this->parser->parse('rrhh/vacaciones/index', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function registrar()
  {
    $data_vacacion = $this->input->post('data');
    # Inactivar Registro de Vacación Activo
    $data_vacacion_activo['estado'] = 0;
    $data_vacacion_activo['actualizadoPor'] = $this->session->userdata('user_id');
    $data_vacacion_activo['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->inactivarVacacionRegistroEmpleadoActivo($data_vacacion['empleado'], $data_vacacion_activo);
    # Registrar nuevo Registro de Vacación
    $data_vacacion['dias_gestion_saldo'] = floatval($data_vacacion['dias_gestion_anterior']) + floatval($data_vacacion['dias_gestion']);
    $data_vacacion['estado'] = 1;
    $data_vacacion['creadoPor'] = $this->session->userdata('user_id');
    $data_vacacion['creadoEn'] = date('Y-m-d H:i:s');
    $data_vacacion['id'] = $this->rrhhModel->registrarVacacionRegistroEmpleado($data_vacacion);
    echo json_encode($data_vacacion);
    exit;
  }
  public function actualizar()
  {
    $vacaciones_id = $this->input->post('empleado_vacaciones_id');
    $empleado = $this->input->post('empleado');
    $fecha_inicial = $this->input->post('fecha_inicial');
    $fecha_final = $this->input->post('fecha_final');
    # VA
    $nro_vacaciones = count($this->rrhhModel->getVacacionesRangoFechaEmpleado($empleado, 'VA', $fecha_inicial, $fecha_final));
    # L1
    $nro_vacaciones += count($this->rrhhModel->getVacacionesRangoFechaEmpleado($empleado, 'L1', $fecha_inicial, $fecha_final));
    # L2
    $nro_vacaciones += count($this->rrhhModel->getVacacionesRangoFechaEmpleado($empleado, 'L2', $fecha_inicial, $fecha_final)) / 2;

    $data_vacacion = $this->rrhhModel->getVacacionById($vacaciones_id);
    $dias_vacaciones = $data_vacacion->dias_gestion + $data_vacacion->dias_gestion_anterior;
    $saldo = $dias_vacaciones - $nro_vacaciones;
    $data_vacacion_actualizado['dias_gestion_saldo'] = $dias_vacaciones - $nro_vacaciones;
    $data_vacacion_actualizado['actualizadoPor'] = $this->session->userdata('user_id');
    $data_vacacion_actualizado['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->actualizarVacacionRegistroEmpleado($vacaciones_id, $data_vacacion_actualizado);
    echo json_encode(($saldo));
    exit;
  }
  public function get_vacaciones_empleado()
  {
    $empleado = $this->input->post('empleado');
    $res['data_vacaciones'] = $this->rrhhModel->getDataVacacionesEmpleado($empleado);
    $res['data_empleado'] = $this->rrhhModel->getEmpleado($empleado);
    echo json_encode($res);
    exit;
  }
  public function get_vacaciones_empleado_periodo()
  {
    $empleado = $this->input->post('empleado');
    $fecha_inicial = $this->input->post('fecha_inicial');
    $fecha_final = $this->input->post('fecha_final');
    $res['VA'] = $this->rrhhModel->getVacacionesRangoFechaEmpleado($empleado, 'VA', $fecha_inicial, $fecha_final);
    $res['L1'] = $this->rrhhModel->getVacacionesRangoFechaEmpleado($empleado, 'L1', $fecha_inicial, $fecha_final);
    $res['L2'] = $this->rrhhModel->getVacacionesRangoFechaEmpleado($empleado, 'L2', $fecha_inicial, $fecha_final);
    echo json_encode($res);
    exit;
  }
}
