<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maniobra extends CI_Controller{

  
  public function __construct() {
    parent::__construct();
    $this->load->model('fact/maniobras_model');
    $this->load->model('fact/zonas_model');
    $this->load->model('fact/alimentadores_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  
  public function lista(){

      $data['maniobras'] = $this->maniobras_model->get_all();
      $data['main_content'] = 'fact/maniobra/lista_view';
      $data['title'] = 'Lista de maniobras';
      $content = $this->parser->parse('fact/maniobra/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function nuevo(){
    
      $data['zonas'] = $this->zonas_model->get_all();
      $data['alimentadores'] = $this->alimentadores_model->get_all();
      $data['main_content'] = 'fact/maniobra/nuevo_view';
      $data['title'] = 'Nueva maniobra';
      $content = $this->parser->parse('fact/maniobra/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function crear(){
   
      $data['tipo_proteccion'] = mb_strtoupper(trim($this->input->post('tipo_proteccion')));
      $data['estado'] = mb_strtoupper(trim($this->input->post('estado')));
      $data['kva_proteccion'] = mb_strtoupper(trim($this->input->post('kva_proteccion')));
      $data['kv_proteccion'] = mb_strtoupper(trim($this->input->post('kv_proteccion')));
      $data['consum_mt_1'] = mb_strtoupper(trim($this->input->post('consum_mt_1')));
      $data['consum_mt_2'] = mb_strtoupper(trim($this->input->post('consum_mt_2')));
      $data['consum_bt_1'] = mb_strtoupper(trim($this->input->post('consum_bt_1')));
      $data['consum_bt_2'] = mb_strtoupper(trim($this->input->post('consum_bt_2')));
      $data['proteccion_sup'] = mb_strtoupper(trim($this->input->post('proteccion_sup')));
      $data['direccion'] = mb_strtoupper(trim($this->input->post('direccion')));
      $data['usuario'] = $this->session->userdata('user_id');
      $data['idalimentador'] = mb_strtoupper(trim($this->input->post('idalimentador')));
      $data['idzona'] = mb_strtoupper(trim($this->input->post('idzona')));
      $this->maniobras_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
   
      $data['zonas'] = $this->zonas_model->get_all();
      $data['alimentadores'] = $this->alimentadores_model->get_all();
      $data['maniobra'] = $this->maniobras_model->get_maniobra($id);
      $data['main_content'] = 'fact/maniobra/editar_view';
      $data['title'] = 'Editar maniobra';
      $content = $this->parser->parse('fact/maniobra/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function actualizar($id){
    
      $data['tipo_proteccion'] = mb_strtoupper(trim($this->input->post('tipo_proteccion')));
      $data['estado'] = mb_strtoupper(trim($this->input->post('estado')));
      $data['kva_proteccion'] = mb_strtoupper(trim($this->input->post('kva_proteccion')));
      $data['kv_proteccion'] = mb_strtoupper(trim($this->input->post('kv_proteccion')));
      $data['consum_mt_1'] = mb_strtoupper(trim($this->input->post('consum_mt_1')));
      $data['consum_mt_2'] = mb_strtoupper(trim($this->input->post('consum_mt_2')));
      $data['consum_bt_1'] = mb_strtoupper(trim($this->input->post('consum_bt_1')));
      $data['consum_bt_2'] = mb_strtoupper(trim($this->input->post('consum_bt_2')));
      $data['proteccion_sup'] = mb_strtoupper(trim($this->input->post('proteccion_sup')));
      $data['direccion'] = mb_strtoupper(trim($this->input->post('direccion')));
      $data['usuario'] = $this->session->userdata('user_id');
      $data['idalimentador'] = mb_strtoupper(trim($this->input->post('idalimentador')));
      $data['idzona'] = mb_strtoupper(trim($this->input->post('idzona')));
      $this->maniobras_model->actualizar($id, $data);
      redirect(base_url().'fact/maniobra/lista');
    
  }
  
  public function eliminar($id){
    
      $this->maniobras_model->eliminar($id);
      redirect(base_url().'fact/maniobra/lista');
    
  }
  
}//fin class
