<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Factores extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Factores', base_url('rrhh/factores'));
  }

  # routes
  public function index()
  {
    $data = [
      'data_meses' => $this->rrhhModel->getMeses()
    ];

    $content = $this->parser->parse('rrhh/factores/indexFactores', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function registrar()
  {
    $data = $this->input->post('data_form');
    $data['estado'] = 1;
    $data['creadoPor'] = $this->session->userdata('user_id');
    $data['creadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->crearNuevoMes($data);
    $mes_desactivar = $this->input->post('mes_de');
    $data_md['estado'] = 0;
    $this->rrhhModel->updateMes($mes_desactivar, $data_md);
    echo json_encode($data);
    exit;
  }
  public function actualizar()
  {
    $data = $this->input->post('data_form');
    $mes = $this->input->post('mes');
    $data['actualizadoPor'] = $this->session->userdata('user_id');
    $data['actualizadoEn'] = date('Y-m-d H:i:s');
    unset($data['mes']);
    $this->rrhhModel->updateMes($mes, $data);
    $data['mes'] = $mes;
    echo json_encode($data);
    exit;
  }
}
