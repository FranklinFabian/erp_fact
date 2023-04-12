<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calle extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/zonas_model');
    $this->load->model('fact/localidades_model');
    $this->load->model('fact/calles_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  } 
  public function lista(){
    
      $data['zonas'] = $this->zonas_model->get_all();
      $data['calles'] = $this->calles_model->get_all();
      $data['main_content'] = 'fact/calle/lista_view';
      $data['title'] = 'Lista de calles';
      $content = $this->parser->parse('fact/calle/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function nuevo(){
    
      $data['zonas'] = $this->zonas_model->get_all();
      $data['calle'] = $this->calles_model->get_all();
      $data['main_content'] = 'fact/calle/nuevo_view';
      $data['title'] = 'Nueva calle';
      $content = $this->parser->parse('fact/calle/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function crear(){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['calle'] = mb_strtoupper(trim($this->input->post('calle')));
      $data['idzona'] = mb_strtoupper(trim($this->input->post('idzona')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->calles_model->insertar($data);
      echo 'ok';
   
  }

  public function editar($id){
   
      $data['zonas'] = $this->zonas_model->get_all();
      $data['calle'] = $this->calles_model->get_calle($id);
      $data['main_content'] = 'fact/calle/editar_view';
      $data['title'] = 'Editar calle';
      $content = $this->parser->parse('fact/calle/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
  }

  public function actualizar($id){
    
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['calle'] = mb_strtoupper(trim($this->input->post('calle')));
      $data['idzona'] = mb_strtoupper(trim($this->input->post('idzona')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->calles_model->actualizar($id, $data);
      redirect(base_url().'fact/calle/lista');
    
  }
  
  public function eliminar($id){
    
      $this->calles_model->eliminar($id);
      redirect(base_url().'fact/calle/lista');
    
  }
  
}//fin class
