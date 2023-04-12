<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zona extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/zonas_model');
    $this->load->model('fact/localidades_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function lista(){
    
      $data['zonas'] = $this->zonas_model->get_all();
      $data['main_content'] = 'fact/zona/lista_view';
      $data['title'] = 'Lista de zona';
      $content = $this->parser->parse('fact/zona/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function nuevo(){
    
      $data['localidades'] = $this->localidades_model->get_all();
      $data['zona'] = $this->zonas_model->get_all();
      $data['main_content'] = 'fact/zona/nuevo_view';
      $data['title'] = 'Nueva zona';
      $content = $this->parser->parse('fact/zona/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function crear(){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['zona'] = mb_strtoupper(trim($this->input->post('zona')));
      $data['idlocalidad'] = mb_strtoupper(trim($this->input->post('idlocalidad')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->zonas_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
    
      
      $data['localidades'] = $this->localidades_model->get_all();
      $data['zona'] = $this->zonas_model->get_zona($id);
      $data['main_content'] = 'fact/zona/editar_view';
      $data['title'] = 'Editar zona';
      $content = $this->parser->parse('fact/zona/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function actualizar($id){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['zona'] = mb_strtoupper(trim($this->input->post('zona')));
      $data['idlocalidad'] = mb_strtoupper(trim($this->input->post('idlocalidad')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->zonas_model->actualizar($id, $data);
      redirect(base_url().'fact/zona/lista');
    
  }
  
  public function eliminar($id){
   
      $this->zonas_model->eliminar($id);
      redirect(base_url().'fact/zona/lista');
    
  }
  
}//fin class
