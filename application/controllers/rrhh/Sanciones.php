<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Sanciones extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Sanciones', base_url('rrhh/sanciones'));
  }

  # routes
  public function index()
  {
    $data = [
      'data_mes_habilitado' => $this->rrhhModel->getMesHabilidato(),
      'data_meses' => $this->rrhhModel->getAllMeses(),
      'data_empleados' => $this->rrhhModel->getEmpleados(),
      'data_items' => $this->rrhhModel->getItems(),
      'enum_remamplia' => $this->rrhhModel->get_enum_values('rrhh_empleado_suplencia', 'remamplia')
    ];

    $content = $this->parser->parse('rrhh/sanciones/indexSanciones', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function reporte() {
    list($mes_repo) = explode(' ', base64_decode($_GET['data']));
    list($anio, $mes, $dia) = explode('-', $mes_repo);
    $mes_ini        = $anio.'-'.$mes.'-01';
    $mes_fin        = $mes_repo;
    $mes_anio       = MONTH_NAMES[$mes].'/'.$anio;
    # data reporte
    $titulo         = 'PLANILLA DE SANCIONES';
    $nombre_archivo = 'Sanciones '.', '.MONTH_NAMES[$mes].'-'.$anio;
    $data_registros_mensuales   = $this->rrhhModel->getSancionesByRangoFechas($mes_ini, $mes_fin);

    include('./application/views/rrhh/sanciones/reportes/reporteSancionesPdf.php'); # incluye - '$html'
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    # paginar pdf generado - add the header
    $canvas = $this->dompdf->get_canvas();
    # datos para paginar el pdf generado
    $x = $canvas->get_width() - 125; 				# posición eje x ($canvas->get_width() el borde maximo de la pag)
    $y = $canvas->get_height() - 50; 				# posición eje y
    $text = "Página:      {PAGE_NUM} de {PAGE_COUNT}"; 	# texto a mostrar
    $font = null; 									# $fontMetrics->get_font("helvetica", "bold");
    $size = 9.5; 									# tamaño de las letras
    $color = array(0,0,0); 							# color del texto (negro)
    $word_space = 0.0;  							# separacion entre palabras
    $char_space = 0.0;  							# separacion entre caracteres
    $angle = 0.0;   								# angulo de orientacion del texto
    # the same call as in my previous example
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream($nombre_archivo.".pdf", array("Attachment"=>0));
}

  # functions

public function get_sanciones() {
    list($anio, $mes, $dia) = explode('-', $_POST['mes']);
    $mes_ini = $anio.'-'.$mes.'-01';
    $mes_fin = $_POST['mes'];
    $data = $this->rrhhModel->getSancionesByMes($mes_ini, $mes_fin);
    echo json_encode($data);
    exit;
}
public function registrar() {
    $data = $_POST['data_form'];
    $data['creadoPor'] = $this->session->userdata('user_id');  # id del usuario logeado
    $data['creadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->crearNuevaSancion($data);
    echo json_encode($data);
    exit;
}
public function actualizar() {
    $data = $_POST['data_form'];
    $empleado = $data['empleado'];
    $mes = $data['mes'];
    $data['actualizadoPor'] = $this->session->userdata('user_id');  # id del usuario logeado
    $data['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->updateSancion($empleado, $mes, $data);
    echo json_encode($data);
    exit;
}
public function eliminar() {
    $empleado = $_POST['empleado'];
    $mes = $_POST['mes'];
    $this->rrhhModel->deleteSancion($empleado, $mes);
}

}
