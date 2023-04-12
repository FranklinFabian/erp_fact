<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Propiedad extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/propiedades_model');

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function index(){//MENU
    
      $data['main_content'] = 'fact/propiedad/index_view';
      $data['title'] = 'Menu propiedades';
      $content = $this->parser->parse('fact/propiedad/index_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
 
    
  }

  public function lista(){
    
      $data['propiedades'] = $this->propiedades_model->get_all();
      $data['main_content'] = 'fact/propiedad/lista_view';
      $data['title'] = 'Lista de propiedades';
      $content = $this->parser->parse('fact/propiedad/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
 
    
  }

  public function nuevo(){
   
      $data['propiedades'] = $this->propiedades_model->get_all();
      $data['main_content'] = 'fact/propiedad/nuevo_view';
      $data['title'] = 'Nueva propiedad';
      $content = $this->parser->parse('fact/propiedad/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
 
    
  }

  public function crear(){
   
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['propiedad'] = mb_strtoupper(trim($this->input->post('propiedad')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->propiedades_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
    
      
      $data['propiedad'] = $this->propiedades_model->get_propiedades($id);
      $data['main_content'] = 'fact/propiedad/editar_view';
      $data['title'] = 'Editar propiedad';
      $content = $this->parser->parse('fact/propiedad/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
 
    
  }

  public function actualizar($id){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['propiedad'] = mb_strtoupper(trim($this->input->post('propiedad')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->propiedades_model->actualizar($id, $data);
      redirect(base_url().'fact/propiedad/lista');
    
  }
  
  public function eliminar($id){
    
      $this->propiedades_model->eliminar($id);
      redirect(base_url().'fact/propiedad/lista');
    
  }
  
}//fin class
