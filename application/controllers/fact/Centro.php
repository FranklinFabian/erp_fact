<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Centro extends CI_Controller{

  
  public function __construct() {
    parent::__construct();
    $this->load->model('fact/centros_model');
    $this->load->model('fact/propiedades_model');
    $this->load->model('fact/localidades_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function lista(){
    
      $data['centros'] = $this->centros_model->get_all();
      $data['main_content'] = 'fact/centro/lista_view';
      $data['title'] = 'Lista de centro';
      $content = $this->parser->parse('fact/centro/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
  }

  public function nuevo(){
    
      $data['localidades'] = $this->localidades_model->get_all();
      $data['propiedades'] = $this->propiedades_model->get_all();
      $data['centro'] = $this->centros_model->get_all();
      $data['main_content'] = 'fact/centro/nuevo_view';
      $data['title'] = 'Nueva centro';
      $content = $this->parser->parse('fact/centro/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function crear(){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['centro'] = mb_strtoupper(trim($this->input->post('centro')));
      $data['idlocalidad'] = mb_strtoupper(trim($this->input->post('idlocalidad')));
      $data['idpropiedad'] = mb_strtoupper(trim($this->input->post('idpropiedad')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->centros_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
   
      $data['localidades'] = $this->localidades_model->get_all();
      $data['propiedades'] = $this->propiedades_model->get_all();
      $data['centro'] = $this->centros_model->get_centro($id);
      $data['main_content'] = 'fact/centro/editar_view';
      $data['title'] = 'Editar centro';
      $content = $this->parser->parse('fact/centro/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function actualizar($id){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['centro'] = mb_strtoupper(trim($this->input->post('centro')));
      $data['idlocalidad'] = mb_strtoupper(trim($this->input->post('idlocalidad')));
      $data['idpropiedad'] = mb_strtoupper(trim($this->input->post('idpropiedad')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->centros_model->actualizar($id, $data);
      redirect(base_url().'fact/centro/lista');
    
  }
  
  public function eliminar($id){
    
      $this->centros_model->eliminar($id);
      redirect(base_url().'fact/centro/lista');
    
  }
  
}//fin class
