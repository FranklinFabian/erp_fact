<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Localidad extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/localidades_model');

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function index(){//MENU
   
      $data['main_content'] = 'fact/localidad/index_view';
      $data['title'] = 'Menu localidades';
      $content = $this->parser->parse('fact/localidad/index_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
 
  }

  public function lista(){
    
      $data['localidades'] = $this->localidades_model->get_all();
      $data['main_content'] = 'fact/localidad/lista_view';
      $data['title'] = 'Lista de localidades';
      $content = $this->parser->parse('fact/localidad/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
  }

  public function nuevo(){
   
      $data['localidades'] = $this->localidades_model->get_all();
      $data['main_content'] = 'fact/localidad/nuevo_view';
      $data['title'] = 'Nueva localidad';
      $content = $this->parser->parse('fact/localidad/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
  }

  public function crear(){
   
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['localidad'] = mb_strtoupper(trim($this->input->post('localidad')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->localidades_model->insertar($data);
      echo 'ok';
 
  }

  public function editar($id){
  
      $data['localidad'] = $this->localidades_model->get_localidades($id);
      $data['main_content'] = 'fact/localidad/editar_view';
      $data['title'] = 'Editar localidad';
      $content = $this->parser->parse('fact/localidad/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);

  }

  public function actualizar($id){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['localidad'] = mb_strtoupper(trim($this->input->post('localidad')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->localidades_model->actualizar($id, $data);
      redirect(base_url().'fact/localidad/lista');
  
  }
  
  public function eliminar($id){
    
      $this->localidades_model->eliminar($id);
      redirect(base_url().'fact/localidad/lista');
  
  }
  
}//fin class
