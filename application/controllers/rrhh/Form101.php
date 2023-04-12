<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Form101 extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Form101', base_url('rrhh/form101'));
  }

  # routes
  public function index()
  {
    $data = [
      'mes_habilitado' => $this->rrhhModel->getMesHabilidato(),
      'meses' => $this->rrhhModel->getAllMeses(),
      'empleados' => $this->rrhhModel->getEmpleados()
    ];

    $content = $this->parser->parse('rrhh/form101/index', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function reporte()
  {
    $mes_repo = base64_decode($this->input->get('data'));
    list($anio, $mes, $dia) = explode('-', $mes_repo);
    $mes_ini    = $anio . '-' . $mes . '-01';
    $mes_fin    = $mes_repo;
    $mes_anio = MONTH_NAMES[$mes] . '/' . $anio;

    $titulo = 'PLANILLA DE DESCUENTO FORM101';
    $nombre_archivo = 'Form101 ' . MONTH_NAMES[$mes] . '-' . $anio;

    $data_registros_mensuales   = $this->rrhhModel->getRegistrosMensualesByTablaRangoFechas('rrhh_empleado_form101', $mes_ini, $mes_fin);
    include('./application/views/rrhh/registros_mensuales/registros_mensuales_f1/reportes/reporteRegistroMensualF1Pdf.php'); # incluye - '$html'
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

  # functions
  public function get_data()
  {
    $nombre_tabla = 'rrhh_empleado_form101';
    list($anio, $mes, $dia) = explode('-', $this->input->post('mes'));
    $mes_ini = $anio . '-' . $mes . '-01';
    $mes_fin = $this->input->post('mes');
    $data['data_reg_mes'] = $this->rrhhModel->getRegistrosMensualesByTablaRangoFechas($nombre_tabla, $mes_ini, $mes_fin);

    echo json_encode($data);
    exit;
  }
  public function registrar()
  {
    $nombre_tabla = 'rrhh_empleado_form101';
    $data = $this->input->post('data_form');
    $data['creadoPor'] = $this->session->userdata('user_id');
    $data['creadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->crearNuevoRegistroMensual($nombre_tabla, $data);
    echo json_encode($data);
    exit;
  }
  public function actualizar()
  {
    $nombre_tabla = 'rrhh_empleado_form101';
    $data = $this->input->post('data_form');
    $mes = $data['mes'];
    $empleado = $data['empleado'];
    unset($data['mes']);
    unset($data['empleado']);
    $data['actualizadoPor'] = $this->session->userdata('user_id');
    $data['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->updateRegistroMensual($nombre_tabla, $empleado, $mes, $data);
    echo json_encode($data);
    exit;
  }
  public function eliminar()
  {
    $nombre_tabla = 'rrhh_empleado_form101';
    $empleado = $this->input->post('empleado');
    $mes = $this->input->post('mes');
    $this->rrhhModel->deleteRegistroMensual($nombre_tabla, $empleado, $mes);
  }
}
