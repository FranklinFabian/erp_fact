<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periodo extends CI_Controller{

  
    public function __construct() {
        parent::__construct();
        $this->load->model('fact/periodos_model');
        $this->load->model('fact/localidades_model');
        if (!$this->auth->is_logged()) {
          $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
        }
        $this->auth->check_admin_auth();
    
      }

    public function lista(){
   
      $data['periodos'] = $this->periodos_model->get_all_desc();
      $data['main_content'] = 'fact/periodo/lista_view';
      $data['title'] = 'Lista de periodo';
      $content = $this->parser->parse('fact/periodo/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
   
  }

  public function nuevo(){
    
      //$data['procesos'] = $this->procesos_model->get_all();
      //$data['periodo'] = $this->periodos_model->get_all();
      $data['main_content'] = 'fact/periodo/nuevo_view';
      $data['title'] = 'Nueva periodo';
      $content = $this->parser->parse('fact/periodo/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function crear(){
   
      $data['emision'] = $this->input->post('emision');
      $data['vencimiento'] = $this->input->post('vencimiento');
      $data['medicion'] = $this->input->post('medicion');
      $data['semision'] = $this->input->post('semision');
      $data['idproceso'] = 1;

      $data['usuario'] = $this->session->userdata('user_id');
      $data['estatus'] = 'V';

      //$data_periodo['idproceso']=3;
      $this->periodos_model->actualizar_idproceso();
      $this->periodos_model->insertar($data);

      echo 'ok';
    
    
  }

  public function editar($id){
    
      
      /*$data['localidades'] = $this->localidades_model->get_all();*/
      $data['periodo'] = $this->periodos_model->get_periodo($id);
      $data['main_content'] = 'fact/periodo/editar_view';
      $data['title'] = 'Editar periodo';
      $content = $this->parser->parse('fact/periodo/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function actualizar($id){
    
      $data['emision'] = mb_strtoupper(trim($this->input->post('emision')));
      $data['vencimiento'] = mb_strtoupper(trim($this->input->post('vencimiento')));
      $data['medicion'] = mb_strtoupper(trim($this->input->post('medicion')));
      $data['semision'] = mb_strtoupper(trim($this->input->post('semision')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->periodos_model->actualizar($id, $data);
      redirect(base_url().'fact/periodo/lista');
   
  }
  
  public function eliminar($id){
    
      $this->periodos_model->eliminar($id);
      redirect(base_url().'fact/periodo/lista');
    
  }
  
}//fin class
