<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturacion extends CI_Controller{
  
  public function __construct() {
    parent::__construct();
    $this->load->model('fact/facturas_model');

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }

  public function index(){
   /* $prods = $this->facturas_model->get_all();*/

    $data['title'] = 'Administración';
   /* $data['prods'] = $prods;*/
    
    $content = $this->parser->parse('fact/facturacion/index_view', $data, true);
    $this->template->full_admin_html_view($content);
  }
  /*public function index(){//MENU
    if(isAdmin()){
      $data['main_content'] = 'fact/facturacion/index_view';
      $data['title'] = 'Menu facturación';
      $this->load->view('fact/template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function lista(){
    if(isAdmin()){
      $data['facturaciones'] = $this->facturaciones_model->get_all();
      $data['main_content'] = 'fact/facturacion/lista_view';
      $data['title'] = 'Lista de facturaciones';
      $this->load->view('fact/template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isAdmin()){
      $data['facturaciones'] = $this->facturaciones_model->get_all();
      $data['main_content'] = 'fact/facturacion/nuevo_view';
      $data['title'] = 'Nueva facturacion';
      $this->load->view('fact/template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin())
    {
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['facturacion'] = mb_strtoupper(trim($this->input->post('facturacion')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->facturaciones_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
      
      $data['facturacion'] = $this->facturaciones_model->get_facturaciones($id);
      $data['main_content'] = 'fact/facturacion/editar_view';
      $data['title'] = 'Editar facturacion';
      $this->load->view('fact/template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['facturacion'] = mb_strtoupper(trim($this->input->post('facturacion')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->facturaciones_model->actualizar($id, $data);
      redirect(base_url().'fact/facturacion/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->facturaciones_model->eliminar($id);
      redirect(base_url().'fact/facturacion/lista');
    }
    else
      redirect(base_url());
  }*/
  
}//fin class
