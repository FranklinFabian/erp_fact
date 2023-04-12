<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller
{
  public function __construct() {
    parent::__construct();
    $this->load->model('fact/cliente_model');
    $this->load->model('fact/parametrica_tipo_documento_identidad_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  } 
  public function index(){
    
      $datos_cliente=$this->cliente_model->get_all();
      
      $data['datos_cliente'] = $datos_cliente;
      $data['main_content'] = 'fact/cliente/index_view';
      $data['title'] = 'Clientes';
      $content = $this->parser->parse('fact/cliente/index_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function nuevo_cliente(){
    
      $data['tipos_doc_iden'] = $this->parametrica_tipo_documento_identidad_model->get_all();
      $data['main_content'] = 'fact/cliente/nuevo_cliente_view';
      $data['title'] = 'Registro de nuevo cliente';
      $content = $this->parser->parse('fact/cliente/nuevo_cliente_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function crear(){
    
      $datos_cliente['razon_social'] = mb_strtoupper(trim($this->input->post('razon_social')));
      $datos_cliente['nit'] = mb_strtoupper(trim($this->input->post('nit')));
      $datos_cliente['ci'] = mb_strtoupper(trim($this->input->post('ci')));
      $datos_cliente['correo'] = mb_strtolower(trim($this->input->post('correo')));
      $datos_cliente['direccion'] = mb_strtoupper(trim($this->input->post('direccion')));
      $datos_cliente['nacimiento'] = mb_strtoupper(trim($this->input->post('nacimiento')));
      $datos_cliente['telefono'] = mb_strtoupper(trim($this->input->post('telefono')));
      $datos_cliente['usuario'] = $this->session->userdata('user_id');
      $datos_cliente['cex'] = mb_strtoupper(trim($this->input->post('cex')));
      $datos_cliente['pas'] = mb_strtoupper(trim($this->input->post('pas')));
      $datos_cliente['od'] = mb_strtoupper(trim($this->input->post('od')));
      $datos_cliente['tipo_doc_fact'] = $this->input->post('tipo_doc_fact');
      $this->cliente_model->insertar($datos_cliente);
      echo 'ok';
    
  }

  public function editar($idcliente){
    
      $datos_cliente = $this->cliente_model->get_cliente($idcliente);
      $data['tipos_doc_iden'] = $this->parametrica_tipo_documento_identidad_model->get_all();
      $data['datos_cliente'] = $datos_cliente;
      $data['main_content'] = 'fact/cliente/editar_view';
      $data['title'] = 'Editar registro';
      $content = $this->parser->parse('fact/cliente/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function actualizar($idcliente){
    
      $datos_cliente = $this->cliente_model->get_cliente($idcliente);

      $datos_cliente['razon_social'] = mb_strtoupper(trim($this->input->post('razon_social')));
      $datos_cliente['nit'] = mb_strtoupper(trim($this->input->post('nit')));
      $datos_cliente['ci'] = mb_strtoupper(trim($this->input->post('ci')));
      $datos_cliente['correo'] = mb_strtolower(trim($this->input->post('correo')));
      $datos_cliente['direccion'] = mb_strtoupper(trim($this->input->post('direccion')));
      $datos_cliente['nacimiento'] = mb_strtoupper(trim($this->input->post('nacimiento')));
      $datos_cliente['telefono'] = mb_strtoupper(trim($this->input->post('telefono')));
      $datos_cliente['usuario'] = $this->session->userdata('user_id');
      $datos_cliente['cex'] = mb_strtoupper(trim($this->input->post('cex')));
      $datos_cliente['pas'] = mb_strtoupper(trim($this->input->post('pas')));
      $datos_cliente['od'] = mb_strtoupper(trim($this->input->post('od')));
      $datos_cliente['tipo_doc_fact'] = $this->input->post('tipo_doc_fact');

      $this->cliente_model->actualizar($idcliente, $datos_cliente);

      echo 'ok';
    
  }
}//fin class
