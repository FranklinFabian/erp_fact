<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alimentador extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/alimentadores_model');
    $this->load->model('fact/centros_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function lista(){
   
      $data['alimentadores'] = $this->alimentadores_model->get_all();
      $data['main_content'] = 'fact/alimentador/lista_view';
      $data['title'] = 'Lista de alimentadores';
      $content = $this->parser->parse('fact/alimentador/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
    
  }

  public function nuevo(){
  
      $data['centros'] = $this->centros_model->get_all();
      $data['main_content'] = 'fact/alimentador/nuevo_view';
      $data['title'] = 'Nueva alimentador';
      $content = $this->parser->parse('fact/alimentador/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
    
  }

  public function crear(){
    
    
      $data['cod_alimentador'] = mb_strtoupper(trim($this->input->post('cod_alimentador')));
      $data['subestacion'] = mb_strtoupper(trim($this->input->post('subestacion')));
      $data['kva_alimentador'] = mb_strtoupper(trim($this->input->post('kva_alimentador')));
      $data['kv_alimentador'] = mb_strtoupper(trim($this->input->post('kv_alimentador')));
      $data['consum_mt_1'] = mb_strtoupper(trim($this->input->post('consum_mt_1')));
      $data['consum_mt_2'] = mb_strtoupper(trim($this->input->post('consum_mt_2')));
      $data['consum_bt_1'] = mb_strtoupper(trim($this->input->post('consum_bt_1')));
      $data['consum_bt_2'] = mb_strtoupper(trim($this->input->post('consum_bt_2')));
      $data['cod_localidades'] = mb_strtoupper(trim($this->input->post('cod_localidades')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->alimentadores_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
    
      $data['alimentador'] = $this->alimentadores_model->get_alimentador($id);
      $data['main_content'] = 'fact/alimentador/editar_view';
      $data['title'] = 'Editar alimentador';
      $content = $this->parser->parse('fact/alimentador/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
    
  }

  public function actualizar($id){
    
      $data['cod_alimentador'] = mb_strtoupper(trim($this->input->post('cod_alimentador')));
      $data['subestacion'] = mb_strtoupper(trim($this->input->post('subestacion')));
      $data['kva_alimentador'] = mb_strtoupper(trim($this->input->post('kva_alimentador')));
      $data['kv_alimentador'] = mb_strtoupper(trim($this->input->post('kv_alimentador')));
      $data['consum_mt_1'] = mb_strtoupper(trim($this->input->post('consum_mt_1')));
      $data['consum_mt_2'] = mb_strtoupper(trim($this->input->post('consum_mt_2')));
      $data['consum_bt_1'] = mb_strtoupper(trim($this->input->post('consum_bt_1')));
      $data['consum_bt_2'] = mb_strtoupper(trim($this->input->post('consum_bt_2')));
      $data['cod_localidades'] = mb_strtoupper(trim($this->input->post('cod_localidades')));
      $data['usuario'] = $this->session->userdata('user_id');
      $this->alimentadores_model->actualizar($id, $data);
      redirect(base_url().'fact/alimentador/lista');
    
  }
  
  public function eliminar($id){
    
      $this->alimentadores_model->eliminar($id);
      redirect(base_url().'fact/alimentador/lista');
    
  }
  
}//fin class
