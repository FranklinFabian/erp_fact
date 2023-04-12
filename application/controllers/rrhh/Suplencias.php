<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Suplencias extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Suplencias', base_url('rrhh/suplencias'));
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

    $content = $this->parser->parse('rrhh/suplencias/indexSuplencias', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function get_data()
  {
    list($anio, $mes, $dia) = explode('-', $this->input->post('mes'));
    $mes_ini = $anio . '-' . $mes . '-01';
    $mes_fin = $this->input->post('mes');
    $data = $this->rrhhModel->getSuplenciasByMes($mes_ini, $mes_fin);
    echo json_encode($data);
    exit;
  }
  public function registrar()
  {
    $data = $this->input->post('data_form');
    $data['creadoPor'] = $this->session->userdata('user_id');  # id del usuario logeado
    $data['creadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->crearNuevaSuplencia($data);
    echo json_encode($data);
    exit;
  }
  public function actualizar()
  {
    $data = $this->input->post('data_form');
    $empleado = $data['empleado'];
    $mes = $data['mes'];
    $item = $data['item'];
    $data['actualizadoPor'] = $this->session->userdata('user_id');  # id del usuario logeado
    $data['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->updateSuplencia($empleado, $mes, $item, $data);
    echo json_encode($data);
    exit;
  }
  public function eliminar()
  {
    $empleado = $this->input->post('empleado');
    $mes = $this->input->post('mes');
    $item = $this->input->post('item');
    $this->rrhhModel->deleteSuplencia($empleado, $mes, $item);
  }
}
