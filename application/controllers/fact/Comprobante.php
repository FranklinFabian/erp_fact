<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobante extends CI_Controller{

  public function lista(){
    if(isAdmin()){
      $data['comprobantes'] = $this->comprobantes_model->get_all();
      $data['main_content'] = 'comprobante/lista_view';
      $data['title'] = 'Lista de comprobantes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isAdmin()){
      $data['main_content'] = 'comprobante/nuevo_view';
      $data['title'] = 'Nueva comprobante';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin())
    {
      $data['fecha'] = $this->input->post('fecha');
      $data['abierto'] = mb_strtoupper(trim($this->input->post('abierto')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->comprobantes_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
      
      $data['comprobante'] = $this->comprobantes_model->get_comprobantes($id);
      $data['main_content'] = 'comprobante/editar_view';
      $data['title'] = 'Editar comprobante';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $data['fecha'] = $this->input->post('fecha');
      $data['abierto'] = mb_strtoupper(trim($this->input->post('abierto')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->comprobantes_model->actualizar($id, $data);
      redirect(base_url().'comprobante/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->comprobantes_model->eliminar($id);
      redirect(base_url().'comprobante/lista');
    }
    else
      redirect(base_url());
  }
  
}//fin class
