<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Control extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Control', base_url('rrhh/control'));
  }

  # routes
  public function index()
  {
    $data = [
      'controles' => $this->rrhhModel->getControles()
    ];

    $content = $this->parser->parse('rrhh/control/index', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function registrar()
  {
    $data = $this->input->post('form');
    $data['creadoPor'] = $this->session->userdata('user_id');
    $data['creadoEn'] = date('Y-m-d H:i:s');
    $data['id'] = $this->rrhhModel->registrarControl($data);

    echo json_encode($data);
    exit;
  }
  public function actualizar()
  {
    $data = $this->input->post('form');
    $control_id = $this->input->post('control_id');
    $data['actualizadoPor'] = $this->session->userdata('user_id');
    $data['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->actualizarControl($control_id, $data);

    echo json_encode($data);
    exit;
  }
}
