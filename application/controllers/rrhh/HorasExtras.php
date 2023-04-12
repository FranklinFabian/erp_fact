<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class HorasExtras extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Horas Extras', base_url('rrhh/horasExtras'));
  }

  # routes
  public function index()
  {
    $data = [
      'data_mes_habilitado' => $this->rrhhModel->getMesHabilidato(),
      'data_meses' => $this->rrhhModel->getAllMeses(),
      'data_empleados' => $this->rrhhModel->getEmpleados()
    ];

    $content = $this->parser->parse('rrhh/horas_extras/indexHorasExtras', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function reporte()
  {
    $mes_repo                   = base64_decode($_GET['data']);
    list($anio, $mes, $dia)     = explode('-', $mes_repo);
    $mes_anio                   = MONTH_NAMES[$mes] . '/' . $anio;
    $titulo                     = 'RESUMEN DE HORAS EXTRAS';
    $nombre_archivo             = 'Resumen Horas Extras ' . MONTH_NAMES[$mes] . '-' . $anio;
    $data_registros_mensuales   = $this->rrhhModel->getRegistrosResumenHorasExtrasByMes($mes_repo);
    include('./application/views/rrhh/horas_extras/reportes/reporteResumenHeMensualPdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    $canvas = $this->dompdf->get_canvas();
    $x = $canvas->get_width() - 125;
    $y = $canvas->get_height() - 50;
    $text = "Página:      {PAGE_NUM} de {PAGE_COUNT}";
    $font = null;
    $size = 9.5;
    $color = array(0, 0, 0);
    $word_space = 0.0;
    $char_space = 0.0;
    $angle = 0.0;
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream($nombre_archivo . ".pdf", array("Attachment" => 0));
  }
  public function reporte_empleado()
  { // por tipo de control
    list($mes_repo, $empleado) = explode(' ', base64_decode($_GET['data']));
    list($anio, $mes, $dia) = explode('-', $mes_repo);
    $mes_ini        = $anio . '-' . $mes . '-01';
    $mes_fin        = $mes_repo;
    $mes_anio       = MONTH_NAMES[$mes] . '/' . $anio;
    $data_empleado  = $this->rrhhModel->getEmpleado($empleado);
    # data reporte
    $titulo         = 'PLANILLA DE HORARIO EXTRAORDINARIO';
    $nombre_archivo = 'Horas extras, ' . $data_empleado->paterno . ' ' . $data_empleado->nombre1 . ', ' . MONTH_NAMES[$mes] . '-' . $anio;
    $data_registros_mensuales   = $this->rrhhModel->getRegistrosHorasExtrasByRangoFechas($empleado, $mes_ini, $mes_fin);

    include('./application/views/rrhh/horas_extras/reportes/reporteHorasExtrasPdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    # paginar pdf generado - add the header
    $canvas = $this->dompdf->get_canvas();
    # datos para paginar el pdf generado
    $x = $canvas->get_width() - 125;         # posición eje x ($canvas->get_width() el borde maximo de la pag)
    $y = $canvas->get_height() - 50;         # posición eje y
    $text = "Página:      {PAGE_NUM} de {PAGE_COUNT}";   # texto a mostrar
    $font = null;                   # $fontMetrics->get_font("helvetica", "bold");
    $size = 9.5;                   # tamaño de las letras
    $color = array(0, 0, 0);               # color del texto (negro)
    $word_space = 0.0;                # separacion entre palabras
    $char_space = 0.0;                # separacion entre caracteres
    $angle = 0.0;                   # angulo de orientacion del texto
    # the same call as in my previous example
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream($nombre_archivo . ".pdf", array("Attachment" => 0));
  }
  // ? TODO: to implement?
  public function reporteHorasExtrasPorEmpleadoPDF2()
  { # Verificar
    list($mes_repo, $empleado) = explode(' ', base64_decode($_GET['data']));
    list($anio, $mes, $dia) = explode('-', $mes_repo);
    $mes_ini        = $anio . '-' . $mes . '-01';
    $mes_fin        = $mes_repo;
    $mes_anio       = MONTH_NAMES[$mes] . '/' . $anio;
    $data_empleado  = $this->rrhhModel->getEmpleado($empleado);
    # data reporte
    $titulo         = 'PLANILLA DE HORARIO EXTRAORDINARIO';
    $nombre_archivo = 'Horas extras, ' . $data_empleado->paterno . ' ' . $data_empleado->nombre1 . ', ' . MONTH_NAMES[$mes] . '-' . $anio;
    $data_registros_mensuales   = $this->rrhhModel->getRegistrosHorasExtrasByRangoFechas($empleado, $mes_ini, $mes_fin);

    include('./application/views/rrhh/registros_mensuales/horas_extras/reportes/reporteHorasExtrasPdf.php'); # incluye - '$html'
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    # paginar pdf generado - add the header
    $canvas = $this->dompdf->get_canvas();
    # datos para paginar el pdf generado
    $x = $canvas->get_width() - 125;         # posición eje x ($canvas->get_width() el borde maximo de la pag)
    $y = $canvas->get_height() - 50;         # posición eje y
    $text = "Página:      {PAGE_NUM} de {PAGE_COUNT}";   # texto a mostrar
    $font = null;                   # $fontMetrics->get_font("helvetica", "bold");
    $size = 9.5;                   # tamaño de las letras
    $color = array(0, 0, 0);               # color del texto (negro)
    $word_space = 0.0;                # separacion entre palabras
    $char_space = 0.0;                # separacion entre caracteres
    $angle = 0.0;                   # angulo de orientacion del texto
    # the same call as in my previous example
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream($nombre_archivo . ".pdf", array("Attachment" => 0));
  }

  # functions
  public function get_horas_extras_totales()
  {
    $mes = $_POST['mes'];
    $data['data_empleados'] = $this->rrhhModel->getEmpleados();
    $data['data_horas_extras'] = $this->rrhhModel->getHorasExtrasTotalesByMes($mes);
    echo json_encode($data);
    exit;
  }
  public function get_horas_extras()
  {
    $empleado = $_POST['emp'];
    $mes = $_POST['mes'];
    $data = $this->rrhhModel->getHorasExtrasEmpleadoByMes($empleado, $mes);
    echo json_encode($data);
    exit;
  }
  public function registrar()
  {
    $data = $_POST['data_form'];
    $data['creadoPor'] = $this->session->userdata('user_id');
    $data['creadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->crearNuevasHorasExtras($data);
    echo json_encode($data);
    exit;
  }
  public function actualizar()
  {
    $id_hora_extra = $_POST['id_hora_extra'];
    $data = $_POST['data_form'];
    $data['actualizadoPor'] = $this->session->userdata('user_id');
    $data['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->updateHorasExtras($id_hora_extra, $data);
    echo json_encode($data);
    exit;
  }
  public function eliminar()
  {
    $id_hora_extra = $_POST['id_hora_extra'];
    $this->rrhhModel->deleteHorasExtras($id_hora_extra);
  }
}
