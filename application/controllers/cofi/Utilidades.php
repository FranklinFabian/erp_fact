<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

require_once('Core.php');

class Utilidades extends Core
{
  public function __construct() {
    parent::__construct();

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }

    $this->breadcrumb->add('Utilidades', base_url('cofi/utilidades'));
  }

  # routes
  public function index() {
    redirect(base_url('cofi/utilidades/tasa_de_cambio'));
  }
  public function tasa_de_cambio() {
    $this->breadcrumb->add('Tasas de Cambio', '#');
    $content = $this->parser->parse('cofi/utilidades/tasa_de_cambio/index', [], true);
    $this->template->full_admin_html_view($content);
  }
  public function tasa_de_cambio_administrar($year, $month) {
    $data = [
      'tasas_cambio' => $this->cofiModel->getTasasDeCambioByAnioMes("$year-$month"),
      'numero_dias_mes' => cal_days_in_month(CAL_GREGORIAN, $month, $year),
      'year' => $year,
      'month' => $month,
    ];

    $this->breadcrumb->add('Administrar Tasas de Cambio', '#');
    $content = $this->parser->parse('cofi/utilidades/tasa_de_cambio/administrar', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function registrar_tasa_de_cambio() {
    $data = $this->input->post('data');
    $data['created_by'] = $this->session->userdata('user_id');
    $data['created_at'] = date('Y-m-d H:i:s');
    $this->cofiModel->registrarTasaCambio($data);
  }
  public function actualizar_tasa_de_cambio($fecha) {
    $data = $this->input->post('data');
    $data['created_by'] = $this->session->userdata('user_id');
    $data['created_at'] = date('Y-m-d H:i:s');
    $this->cofiModel->actualizarTasaCambio($fecha, $data);
  }
  public function verificar_tasa_de_cambio($fecha) {
    echo json_encode($this->cofiModel->verificarTasaCambio($fecha));
  }
  public function subir_leer_datos_archivo_tasa_cambio($file_name = '') {
    $res['estado'] = 0;
    if (is_array($_FILES) && count($_FILES) > 0) {
      $tipo = $_FILES["file"]["type"];
      if (($tipo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || ($tipo == "application/vnd.ms-excel")) {
        $nombre_archivo = "uploads/tasas_cambio/" . $file_name . '_' . strtotime(date('Y-m-d H:i:s')) . ".xlsx";
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $nombre_archivo)) {
          $res['estado']    = 1;
          $res['direccion'] = $nombre_archivo;
        }
      }
    }
    if ($res['estado'] == 0) {
      echo json_encode($res);
      return;
    }
    # Leer Archivo
    $inputFileName  = $res['direccion']; #'data_productos.xlsx';
    $spreadsheet    = IOFactory::load($inputFileName);
    $number_rows    = $spreadsheet->setActiveSheetIndex(0)->getHighestRow();
    $data           = array();
    for ($i = 2; $i <= $number_rows; $i++) {
      $data_aux = array();
      $data_aux['dia']    = $spreadsheet->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
      $data_aux['bs_us']  = $spreadsheet->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
      $data_aux['bs_ufv'] = $spreadsheet->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
      array_push($data, $data_aux);
    }
    $res['data'] = $data;
    echo json_encode($res);
  }
  public function importar_datos_tasas_cambio() {
    $data_importar = $this->input->post('data_importar');
    foreach ($data_importar as $di) {
      $di['created_by'] = $this->session->userdata('user_id');
      $di['created_at'] = date('Y-m-d H:i:s');
      $response = $this->cofiModel->verificarTasaCambio($di['fecha']);
      if ($response) {
        $this->cofiModel->actualizarTasaCambio($di['fecha'], $di);
      } else {
        $this->cofiModel->registrarTasaCambio($di);
      }
    }
    echo json_encode($data_importar);
  }

  # local functions
}
