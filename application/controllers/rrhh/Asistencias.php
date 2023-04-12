<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Asistencias extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Asistencias', base_url('rrhh/asistencias'));
  }

  # routes
  public function index()
  {
    $data = [
      'data_mes_habilitado' => $this->rrhhModel->getMesHabilidato(),
      'data_control' => $this->rrhhModel->getControles(),
      'data_empleados' => $this->rrhhModel->getEmpleados()
    ];

    $content = $this->parser->parse('rrhh/asistencias/index', $data, true);
    $this->template->full_admin_html_view($content);
  }

  public function reporte_simple()
  {
    list($empleado, $fecha_ini, $fecha_fin) = explode(' ', base64_decode($_GET['data']));
    $data_empleado  = $this->rrhhModel->getEmpleado($empleado);  # nro_ci
    $data_reporte   = $this->rrhhModel->getDataAsistenciaByRangoFechas($empleado, $fecha_ini, $fecha_fin);
    include('./application/views/rrhh/asistencias/reportes/reporteSimpleAsistenciaPdf.php'); # incluye - '$html'
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    $canvas = $this->dompdf->get_canvas();
    $x = $canvas->get_width() - 125;
    $y = $canvas->get_height() - 50;
    $text = "Página:       {PAGE_NUM} de {PAGE_COUNT}";
    $font = null;
    $size = 9.5;
    $color = array(0, 0, 0);
    $word_space = 0.0;
    $char_space = 0.0;
    $angle = 0.0;
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream("Reporte Simple de Asistencia, " . $empleado . " - " . $nombre_empleado . ", " . date('d-m-Y') . ".pdf", array("Attachment" => 0));
  }
  public function reporte_vacaciones()
  {
    list($empleado, $fecha_ini, $fecha_fin) = explode(' ', base64_decode($_GET['data']));
    $data_empleado  = $this->rrhhModel->getEmpleado($empleado);  # nro_ci
    $data_reporte   = $this->rrhhModel->getDataAsistenciaLicenciasVacacionesByRangoFechas($empleado, $fecha_ini, $fecha_fin);
    include('./application/views/rrhh/asistencias/reportes/reporteVacacionesPdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    $canvas = $this->dompdf->get_canvas();
    $x = $canvas->get_width() - 125;
    $y = $canvas->get_height() - 50;
    $text = "Página:       {PAGE_NUM} de {PAGE_COUNT}";
    $font = null;
    $size = 9.5;
    $color = array(0, 0, 0);
    $word_space = 0.0;
    $char_space = 0.0;
    $angle = 0.0;
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream("Reporte de Licencias y Vacaciones, " . $empleado . " - " . $nombre_empleado . ", " . date('d-m-Y') . ".pdf", array("Attachment" => 0));
  }
  public function reporte_otros()
  {
    list($control, $empleado, $fecha_ini, $fecha_fin) = explode(' ', base64_decode($_GET['data']));
    $data_control   = $this->rrhhModel->getControl($control);
    $data_empleado  = $this->rrhhModel->getEmpleado($empleado);  # nro_ci
    $data_reporte   = $this->rrhhModel->getDataAsistenciaByControlAndRangoFechas($control, $empleado, $fecha_ini, $fecha_fin);
    include('./application/views/rrhh/asistencias/reportes/reporteOtrosPdf.php'); # incluye - '$html'
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    $canvas = $this->dompdf->get_canvas();
    $x = $canvas->get_width() - 125;
    $y = $canvas->get_height() - 50;
    $text = "Página:       {PAGE_NUM} de {PAGE_COUNT}";
    $font = null;
    $size = 9.5;
    $color = array(0, 0, 0);
    $word_space = 0.0;
    $char_space = 0.0;
    $angle = 0.0;
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream("Reporte de " . $nombre_reporte . ", " . $empleado . " - " . $nombre_empleado . ", " . date('d-m-Y') . ".pdf", array("Attachment" => 0));
  }

  # functions
  public function actualizar()
  {
    $nro_ci_emp = $this->input->post('ci_emp');
    $fecha = $this->input->post('fecha');
    $data_asistencia = $this->input->post('data_as');
    $this->rrhhModel->updateAsistencia($nro_ci_emp, $fecha, $data_asistencia);
    echo json_encode($data_asistencia);
    exit;
  }
  public function actualizar_rango_fechas()
  {
    $nro_ci_emp = $this->input->post('ra_ci_emp');
    $data_asitencia_fechas = $this->input->post('data_asistencia');
    list($ad, $md, $dd) = explode('-', $data_asitencia_fechas['fecha_desde']);
    list($ah, $mh, $dh) = explode('-', $data_asitencia_fechas['fecha_hasta']);
    $dias_habiles = 0;
    for ($i = intval($dd); $i <= intval($dh); $i++) {
      $dia_semana = date('w', strtotime($ad . '-' . $md . '-' . $i));
      if ($dia_semana != "6" && $dia_semana != "0") { # Sabado & Domingo
        $dias_habiles++;
        $fecha_asistencia = $ad . '-' . $md . '-' . $i;
        $data_asistencia = array(
          'control' => $data_asitencia_fechas['control'],
          'nota'    => $dia_semana . ' ' . $data_asitencia_fechas['nota'],
        );
        $this->rrhhModel->updateAsistencia($nro_ci_emp, $fecha_asistencia, $data_asistencia);
      }
    }
    echo json_encode($data_asitencia_fechas);
    exit;
  }
  public function actualizar_rango_fechas_all_empleados()
  {
    $mes_habilitado = $this->input->post('mes_habilitado');
    $data_asitencia_fechas = $this->input->post('data_asistencia');
    list($ad, $md, $dd) = explode('-', $data_asitencia_fechas['fecha_desde']);
    list($ah, $mh, $dh) = explode('-', $data_asitencia_fechas['fecha_hasta']);
    # Obtener lista de empleados activos del mes habilitado
    $data_empleados = $this->rrhhModel->getEmpleados();     # empleados
    foreach ($data_empleados as $de) {
      for ($i = intval($dd); $i <= intval($dh); $i++) {
        $dia_semana = date('w', strtotime($ad . '-' . $md . '-' . $i));
        if ($dia_semana != "6" && $dia_semana != "0") { // Sabado & Domingo
          $fecha_asistencia = $ad . '-' . $md . '-' . $i;
          $data_asistencia = array(
            'control' => $data_asitencia_fechas['control'],
            'nota'    => $dia_semana . ' ' . $data_asitencia_fechas['nota'],
          );
          $this->rrhhModel->updateAsistencia($de->empleado, $fecha_asistencia, $data_asistencia);
        }
      }
    }
    echo json_encode($data_asitencia_fechas);
    exit;
  }
  public function get_mes_empleado()
  {
    $nro_ci_empleado = $this->input->post('ci_emp');
    $mes_asistencia = $this->input->post('mes');
    $res = $this->rrhhModel->getAsistenciaMesEmpleado($nro_ci_empleado, $mes_asistencia);
    echo json_encode($res);
    exit;
  }
  public function registrar_dia_mes()
  {
    # crea un registro por cada día del mes seleccionado para cada empleado
    list($anio, $mes, $dia) = explode('-', $this->input->post('mes'));
    $empleados  = $this->rrhhModel->getEmpleados();
    $data = [];
    foreach ($empleados as $emp) {
      for ($i = 1; $i <= $dia; $i++) {
        $data_emp['empleado']   = $emp->empleado;
        $data_emp['fecha']      = $anio . '-' . $mes . '-' . $i;
        $data_emp['nota']       = date("w", strtotime($anio . '-' . $mes . '-' . $i));
        $data_emp['mes']        = $this->input->post('mes');
        $data[$i]               = $anio . '-' . $mes . '-' . $i;
        $this->rrhhModel->registrarAsistenciaDiaMesEmpleado($data_emp);
      }
    }
    echo json_encode($data);
    exit;
  }
}
