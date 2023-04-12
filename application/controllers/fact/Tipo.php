<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipo extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/tipos_model');

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function lista(){
   
      $data['tipos'] = $this->tipos_model->get_all();
      $data['main_content'] = 'fact/tipo/lista_view';
      $data['title'] = 'Lista de tipos';
      $content = $this->parser->parse('fact/tipo/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
  }

  public function nuevo(){
    
      $data['main_content'] = 'fact/tipo/nuevo_view';
      $data['title'] = 'Nueva tipo';
      $content = $this->parser->parse('fact/tipo/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
  }

  public function crear(){
   
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['tipo'] = mb_strtoupper(trim($this->input->post('tipo')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->tipos_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
    
      
      $data['tipo'] = $this->tipos_model->get_tipos($id);
      $data['main_content'] = 'fact/tipo/editar_view';
      $data['title'] = 'Editar tipo';
      $content = $this->parser->parse('fact/tipo/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function actualizar($id){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['tipo'] = mb_strtoupper(trim($this->input->post('tipo')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->tipos_model->actualizar($id, $data);
      redirect(base_url().'fact/tipo/lista');
    
  }
  
  public function eliminar($id){
   
      $this->tipos_model->eliminar($id);
      redirect(base_url().'fact/tipo/lista');
    
  }
  
}//fin class
