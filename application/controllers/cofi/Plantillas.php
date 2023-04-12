<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Plantillas extends Core {

  public function __construct() {
    parent::__construct();

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }

    $this->breadcrumb->add('Plantillas', base_url('cofi/plantillas'));
  }

  # routes
  public function index() {
    $data = [
      'plantillas' => $this->cofiModel->getPlantillasByGestionEmpresa(),
    ];

    $content = $this->parser->parse('cofi/plantillas/index', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function crear() {
    $data = [
      'cuentas_finales' => $this->cofiModel->getCuentasFinales($this->EMPRESA_GESTION_ID),
    ];

    $this->breadcrumb->add('Registrar Plantilla', '#');
    $content = $this->parser->parse('cofi/plantillas/formulario', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function editar($id) {
    $data = [
      'cuentas_finales' => $this->cofiModel->getCuentasFinales($this->EMPRESA_GESTION_ID),
      'plantilla' => (array) $this->cofiModel->getPlantillaById($id),
      'plantilla_data' => $this->cofiModel->getPlantillaDataByPlantillaId($id),
    ];

    $this->breadcrumb->add('Editar Plantilla', '#');
    $content = $this->parser->parse('cofi/plantillas/formulario', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function registrar() {
    $plantilla = $this->input->post('plantilla');
    $plantilla['empresa_gestion_id'] = $this->EMPRESA_GESTION_ID;
    $plantilla['created_at'] = date('Y-m-d H:i:s');
    $plantilla['created_by'] = $this->session->userdata('user_id');
    $plantilla_id = $this->cofiModel->insert('cofi_plantillas', $plantilla);

    $plantilla_data = $this->input->post('plantilla_data');
    foreach($plantilla_data as $pd) {
      $pd['plantilla_id'] = $plantilla_id;
      $this->cofiModel->insert('cofi_plantillas_data', $pd);
    }

    echo json_encode($plantilla_id);
  }
  public function actualizar($id) {
    $plantilla = $this->input->post('plantilla');
    $plantilla['updated_at'] = date('Y-m-d H:i:s');
    $plantilla['updated_by'] = $this->session->userdata('user_id');
    $res = $this->cofiModel->updateById('cofi_plantillas', $plantilla, $id);

    $this->cofiModel->deleteByCustomAttribute('cofi_plantillas_data', 'plantilla_id', $id);
    $plantilla_data = $this->input->post('plantilla_data');
    foreach($plantilla_data as $pd) {
      $pd['plantilla_id'] = $id;
      $this->cofiModel->insert('cofi_plantillas_data', $pd);
    }

    echo json_encode($res);
  }
  public function eliminar($id) {
    # delete cofi_plantillas
    $res = $this->cofiModel->deleteByCustomAttribute('cofi_plantillas', 'id', $id);
    # delete cofi_plantillas_data
    $res = $this->cofiModel->deleteByCustomAttribute('cofi_plantillas_data', 'plantilla_id', $id);

    echo json_encode($res);
  }
  public function get_plantilla_data_by_plantilla_id($id) {
    $data = $this->cofiModel->getPlantillaDataByPlantillaId($id);
    echo json_encode($data);
    exit;
  }

}
