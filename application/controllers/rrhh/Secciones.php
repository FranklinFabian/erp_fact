<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Secciones extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Secciones', base_url('rrhh/secciones'));
  }

  # routes
  public function index()
  {
    $data = [
      'data_secciones' => $this->rrhhModel->getSecciones(),
      'data_servicios' => $this->rrhhModel->getSisServicios()
    ];

    $content = $this->parser->parse('rrhh/secciones/indexSecciones', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function registrar()
  {
    $data = $this->input->post('data_form');
    $data['creadoPor'] = $this->session->userdata('user_id');
    $data['creadoEn'] = date('Y-m-d H:i:s');
    $data['id'] = $this->rrhhModel->crearNuevaSeccion($data);
    echo json_encode($data);
    exit;
  }
  public function actualizar()
  {
    $data = $this->input->post('data_form');
    $id_seccion = $this->input->post('id_seccion');
    $data['actualizadoPor'] = $this->session->userdata('user_id');
    $data['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->updateSeccion($id_seccion, $data);
    $data['id'] = $id_seccion;
    echo json_encode($data);
    exit;
  }
}
