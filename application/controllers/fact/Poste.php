<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poste extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/centros_model');
    $this->load->model('fact/propiedades_model');
    $this->load->model('fact/localidades_model');
    $this->load->model('fact/postes_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function lista(){
   
      $data['postes'] = $this->postes_model->get_all();
      $data['main_content'] = 'fact/poste/lista_view';
      $data['title'] = 'Lista de poste';
      $content = $this->parser->parse('fact/poste/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function nuevo(){
    
      $data['centros'] = $this->centros_model->get_all();
      $data['main_content'] = 'fact/poste/nuevo_view';
      $data['title'] = 'Nueva poste';
      $content = $this->parser->parse('fact/poste/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function crear(){
   
      $data['poste'] = mb_strtoupper(trim($this->input->post('poste')));
      $data['distancia'] = mb_strtoupper(trim($this->input->post('distancia')));
      $data['unidades'] = mb_strtoupper(trim($this->input->post('unidades')));
      $data['idcentro'] = mb_strtoupper(trim($this->input->post('idcentro')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->postes_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
    
      $data['centros'] = $this->centros_model->get_all();      
      $data['poste'] = $this->postes_model->get_poste($id);
      $data['main_content'] = 'fact/poste/editar_view';
      $data['title'] = 'Editar poste';
      $content = $this->parser->parse('fact/poste/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function actualizar($id){
   
      $data['poste'] = mb_strtoupper(trim($this->input->post('poste')));
      $data['distancia'] = mb_strtoupper(trim($this->input->post('distancia')));
      $data['unidades'] = mb_strtoupper(trim($this->input->post('unidades')));
      $data['idcentro'] = mb_strtoupper(trim($this->input->post('idcentro')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->postes_model->actualizar($id, $data);
      redirect(base_url().'fact/poste/lista');
    
  }
  
  public function eliminar($id){
    
      $this->postes_model->eliminar($id);
      redirect(base_url().'fact/poste/lista');
    
  }
  
}//fin class
