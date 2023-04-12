<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Security extends CI_Controller
{
  public function __construct() {
    parent::__construct();
    $this->load->model(['securityModel', 'cofiModel']);
  }

  public function index() {
    $data['plantillas'] = $this->cofiModel->getPlantillasByGestionEmpresa();

    $content = $this->parser->parse('security/index', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function reports() {
    $modules = $this->input->get('modules');
    $form_data['modules_id'] = $modules ? explode(',', $modules) : [];

    $sites = $this->input->get('sites');
    $form_data['sites_id'] = $sites ? explode(',', $sites) : [];

    $initial_date = $this->input->get('initial_date');
    $form_data['initial_date'] = $initial_date ? $initial_date : date('Y-m-d');

    $initial_date = $this->input->get('final_date');
    $form_data['final_date'] = $initial_date ? $initial_date : date('Y-m-d');

    $users = $this->input->get('users');
    $form_data['users_id'] = $users ? explode(',', $users) : [];

    $data = [
      'actions' => count($form_data['sites_id']) > 0 ? $this->securityModel->getActionsReport($form_data) : [],
      'modules' => $this->securityModel->getModules(),
      'sites' => $this->securityModel->getSites(),
      'users' => $this->securityModel->getUsers(),
      'form_data' => $form_data,
    ];

    $content = $this->parser->parse('security/reports', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function form() {
    echo '<pre>';
    print_r($this->input->post());
  }

  # functions
  public function update_session_data() {
    $data = $this->input->post();
    $this->session->set_userdata($data);
    echo json_encode($data);
    exit;
  }
}
