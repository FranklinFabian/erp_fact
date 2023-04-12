<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Items extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Ítems', base_url('rrhh/items'));
  }

  # routes
  public function index()
  {
    $data = [
      'data_items' => $this->rrhhModel->getItems(),
      'data_secciones' => $this->rrhhModel->getSecciones()
    ];

    $content = $this->parser->parse('rrhh/items/indexItems', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function registrar()
  {
    $data = $this->input->post('data_form');
    $data['creadoPor'] = $this->session->userdata('user_id');
    $data['creadoEn'] = date('Y-m-d H:i:s');
    $data['id'] = $this->rrhhModel->crearNuevoItem($data);
    echo json_encode($data);
    exit;
  }
  public function actualizar()
  {
    $data = $this->input->post('data_form');
    $id_item = $this->input->post('id_item');
    $data['actualizadoPor'] = $this->session->userdata('user_id');
    $data['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->updateItem($id_item, $data);
    $data['id'] = $id_item;
    echo json_encode($data);
    exit;
  }
}
