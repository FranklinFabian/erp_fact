<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller{
  public function __construct() {
    parent::__construct();
    $this->load->model('fact/lecturas_model');
    $this->load->model('fact/lecturas_observadas_model');
    $this->load->model('fact/centros_model');
    $this->load->model('fact/abonados_model');
    $this->load->model('fact/periodos_model');
    $this->load->model('fact/calles_model');
    $this->load->model('fact/localidades_model');
    $this->load->model('fact/cliente_model');
    $this->load->model('fact/postes_model');
    $this->load->model('fact/categorias_model');
    $this->load->model('fact/categoria_model');
    $this->load->model('fact/estados_model');
    $this->load->model('fact/zonas_model');
    $this->load->model('fact/configuracion_model');
    $this->load->model('fact/comprobantes_model');
    $this->load->model('fact/servicios_model');
    $this->load->model('fact/reporte_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function index(){
    
      $data['main_content'] = 'fact/reporte/index_view';
      $data['title'] = 'Reportes';
      $content = $this->parser->parse('fact/reporte/index_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
  }

  public function resumen_electrica(){
    
      $data['periodos'] = $this->periodos_model->get_all_desc();
      $data['title'] = 'Resumen venta energia electrica';
      $data['main_content'] = 'fact/reporte/resumen_electrica_view';
      $content = $this->parser->parse('fact/reporte/resumen_electrica_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }//fin

  public function generar_venta_electrica(){
    
      $categorias = $this->categorias_model->get_categorias_servicio(1);
      $periodo = $this->periodos_model->get_periodo($this->input->post('idperiodo'));
      $data['title'] = 'Reporte venta de energia electrica';
      $data['periodo'] = $periodo;
      $data['categorias'] = $categorias;
      $this->load->view('fact/reporte/generar_venta_electrica_view', $data);
    
  }//fin


}//fin class
