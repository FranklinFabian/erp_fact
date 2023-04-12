<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller
{
  protected $empresa_nombre = '';
  protected $empresa_direccion = '';
  private $parametros_mes;
  private $seccion_empleado   = 1; # para las planillas salariales, para usuar array_filter()
  private $servicio           = 1; # para reporte

  public function __construct()
  {
    parent::__construct();
    $this->load->model('rrhhModel');
    $this->load->helper('rrhh');
    date_default_timezone_set("America/La_Paz");

    # Motrar todos los errores de PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // ini_set('memory_limit', '-1'); # memory limit (no limit)
    // set_time_limit(0); # maximum execution time (no limit)

    $company_information = $this->rrhhModel->get_company_information();
    $this->empresa_nombre = $company_information->company_name;
    $this->empresa_direccion = $company_information->address;

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

    $this->breadcrumb->add('<i class="pe-7s-home"></i> Inicio', base_url());
    $this->breadcrumb->add('Recursos Humanos', base_url('rrhh/core'));
  }

  public function index()
  {
    redirect(base_url('rrhh/empleados'));
  }
}
