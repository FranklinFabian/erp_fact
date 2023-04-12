<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/controles_model');

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }

  public function lista(){
    
      $data['controles'] = $this->controles_model->get_all();
      $data['main_content'] = 'fact/control/lista_view';
      $data['title'] = 'Lista de controles';
      $content = $this->parser->parse('fact/control/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
    
  }

 public function nuevo(){
    
      $data['main_content'] = 'fact/control/nuevo_view';
      $data['title'] = 'Nueva control';
      $content = $this->parser->parse('fact/control/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    }
    
  

  public function crear(){
    $data['control'] = mb_strtoupper(trim($this->input->post('control')));
    $data['usuario'] = $this->session->userdata('user_id');
    $this->controles_model->insertar($data);
    echo 'ok';
  }

  public function editar($id){
   
      
      $data['control'] = $this->controles_model->get_controles($id);
      $data['main_content'] = 'fact/control/editar_view';
      $data['title'] = 'Editar control';
      $content = $this->parser->parse('fact/control/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function actualizar($id){
   
      $data['control'] = mb_strtoupper(trim($this->input->post('control')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->controles_model->actualizar($id, $data);
      redirect(base_url().'fact/control/lista');
  }
  
  public function eliminar($id){
    
      $this->controles_model->eliminar($id);
      redirect(base_url().'fact/control/lista');
   
    
  }
  
}//fin class
