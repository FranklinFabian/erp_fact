<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proceso extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/procesos_model');

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function lista(){
    
      $data['procesos'] = $this->procesos_model->get_all();
      $data['main_content'] = 'fact/proceso/lista_view';
      $data['title'] = 'Lista de procesos';
      /*$this->load->view('template/template_view', $data);*/
      $content = $this->parser->parse('fact/proceso/lista_view', $data, true);
      $this->template->full_admin_html_view($content);
  }

  public function nuevo(){    

      $data['main_content'] = 'fact/proceso/nuevo_view';
      $data['title'] = 'Nueva proceso';
      $content = $this->parser->parse('fact/proceso/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
  
  }

  public function crear(){
   
      $data['proceso'] = mb_strtoupper(trim($this->input->post('proceso')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->procesos_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
  
      
      $data['proceso'] = $this->procesos_model->get_procesos($id);
      $data['main_content'] = 'fact/proceso/editar_view';
      $data['title'] = 'Editar proceso';
      $content = $this->parser->parse('fact/proceso/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
 
  }

  public function actualizar($id){
    
      $data['proceso'] = mb_strtoupper(trim($this->input->post('proceso')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->procesos_model->actualizar($id, $data);
      redirect(base_url().'fact/proceso/lista');
  
  }
  
  public function eliminar($id){
   
      $this->procesos_model->eliminar($id);
      redirect(base_url().'fact/proceso/lista');
   
  }
  
}//fin class
