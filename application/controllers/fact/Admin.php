<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/producto_model');
    $this->load->model('fact/configuracion_model');
    $this->load->model('fact/empleado_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }

  public function index(){
    $data['main_content'] = 'fact/admin/index_view';
      $data['title'] = 'Administración';
    
    $content = $this->parser->parse('fact/admin/index_view', $data, true);
    $this->template->full_admin_html_view($content);
  }

  public function empresa()
  {
    
      $nro_conf = $this->configuracion_model->get_all();
      if(empty($nro_conf)){
        $data['main_content'] = 'admin/empresa_view';
        $data['title'] = 'Administración';
        $content = $this->parser->parse('fact/admin/empresa_view', $data, true);
    $this->template->full_admin_html_view($content);
      }else{

          $data['empresa'] = $nro_conf;
          $data['main_content'] = 'admin/editar_empresa_view';
          $data['title'] = 'Administración';
          $content = $this->parser->parse('fact/admin/editar_empresa_view', $data, true);
          $this->template->full_admin_html_view($content);
      }
  }

  public function guardar_empresa()
  {
    
      $data_empresa['logo_linea1'] = mb_strtoupper(trim($this->input->post('logo_linea1')));
      $data_empresa['logo_linea2'] = mb_strtoupper(trim($this->input->post('logo_linea2')));
      $data_empresa['whatsapp'] = mb_strtoupper(trim($this->input->post('whatsapp')));
      $data_empresa['direccion'] = mb_strtoupper(trim($this->input->post('direccion')));
      $data_empresa['telefono'] = mb_strtoupper(trim($this->input->post('telefono')));
      $data_empresa['pie_impresion'] = trim($this->input->post('pie_impresion'));
      $this->configuracion_model->insertar($data_empresa);
      echo 'ok';
 
  }

  public function actualizar_empresa($id)
  {
    
      $data_empresa['logo_linea1'] = mb_strtoupper(trim($this->input->post('logo_linea1')));
      $data_empresa['logo_linea2'] = mb_strtoupper(trim($this->input->post('logo_linea2')));
      $data_empresa['whatsapp'] = mb_strtoupper(trim($this->input->post('whatsapp')));
      $data_empresa['direccion'] = mb_strtoupper(trim($this->input->post('direccion')));
      $data_empresa['telefono'] = mb_strtoupper(trim($this->input->post('telefono')));
      $data_empresa['pie_impresion'] = trim($this->input->post('pie_impresion'));
      $this->configuracion_model->actualizar($id, $data_empresa);
      echo 'ok';
    
  }
  
  public function imp_usuarios()
  {
    
      $configuracion = $this->configuracion_model->get_all();
      if(is_null($configuracion))
        $direccion_telefono = $this->config->item('cel_reporte');
      else
        $direccion_telefono = $configuracion['direccion'].' - Telf./Cel.: '.$configuracion['telefono'];

      $data['direccion_telefono'] = $direccion_telefono;
      $data['usuarios'] = $this->empleado_model->get_all();
      $data['title'] = 'Usuarios del sistema';
      $this->load->view('fact/admin/imp_usuarios_view', $data);
     
  }

  
}
//fin class
