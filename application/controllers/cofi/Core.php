<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller
{
  public $EMPRESA_GESTION;
  public $EMPRESA_GESTION_ID;

  public function __construct() {
    parent::__construct();
    $this->load->model('cofiModel');
    $this->load->helper('cofi_helper');

    # Select the idGestionEmpresa
    if ($this->session->userdata('idGestionEmpresa') == -1 || $this->session->userdata('idGestionEmpresa') == 0) {
      # first company, last management || 0
      $data['idGestionEmpresa'] = $this->cofiModel->getPrimeraEmpresaUltimaGestion();
      $this->session->set_userdata($data);
    }

    $this->EMPRESA_GESTION_ID = $this->session->userdata('idGestionEmpresa');

    # Case when there is no a company registered
    if ($this->EMPRESA_GESTION_ID === 0 && $_SERVER['PATH_INFO'] !== '/cofi/administracion/adicionar_empresa' && $_SERVER['PATH_INFO'] !== '/cofi/administracion/registrar_empresa') {
      redirect(base_url('cofi/administracion/adicionar_empresa'));
    }

    $this->EMPRESA_GESTION = $this->cofiModel->getEmpresaGestionArray($this->EMPRESA_GESTION_ID);

    ini_set('memory_limit', '-1'); # memory limit (no limit)
    set_time_limit(0); # maximum execution time (no limit)

    $this->breadcrumb->add('<i class="pe-7s-home"></i> Inicio', base_url());
    $this->breadcrumb->add('Contabilidad y Finanzas', base_url('cofi/core'));
  }

  public function index() {
    redirect(base_url('cofi/administracion/empresa_gestion'));
  }

  public function vue() { # this is a test
    $data = [
      'cc' => 'variable del controlador',
    ];
    $content = $this->parser->parse('cofi/vue', $data, true);
    $this->template->full_admin_html_view($content);
  }
}
