<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/categorias_model');
    
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  } 
  public function index(){//MENU
    
      $data['main_content'] = 'fact/categorias/index_view';
      $data['title'] = 'Menu categorias';
      $content = $this->parser->parse('fact/categorias/index_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function lista(){
   
      $data['categorias'] = $this->categorias_model->get_all();
      $data['main_content'] = 'categorias/lista_view';
      $data['title'] = 'Lista de categorias';
      $this->load->view('template/template_view', $data);
    
  }

  public function nuevo(){
   
      $data['categorias'] = $this->categorias_model->get_all();
      $data['main_content'] = 'categorias/nuevo_view';
      $data['title'] = 'Nueva categorias';
      $this->load->view('template/template_view', $data);
    
  }

  public function crear(){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['categoria'] = mb_strtoupper(trim($this->input->post('categoria')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->categorias_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
   
      
      $data['categorias'] = $this->categorias_model->get_categorias($id);
      $data['main_content'] = 'categorias/editar_view';
      $data['title'] = 'Editar categorias';
      $this->load->view('template/template_view', $data);
    
  }

  public function actualizar($id){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['categoria'] = mb_strtoupper(trim($this->input->post('categoria')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->categorias_model->actualizar($id, $data);
      redirect(base_url().'categorias/lista');
    
  }
  
  public function eliminar($id){
    
      $this->categorias_model->eliminar($id);
      redirect(base_url().'categorias/lista');
    
  }
  
}//fin class
