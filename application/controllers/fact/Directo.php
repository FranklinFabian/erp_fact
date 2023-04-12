<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Directo extends CI_Controller{

  public function lista(){
    if(isAdmin()){
      $data['directos'] = $this->directos_model->get_all();
      $data['main_content'] = 'directo/lista_view';
      $data['title'] = 'Lista de directos';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isAdmin()){
      $data['directos'] = $this->directos_model->get_all();
      $data['main_content'] = 'directo/nuevo_view';
      $data['title'] = 'Nueva directo';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin())
    {
      $data['beneficiario'] = mb_strtoupper(trim($this->input->post('beneficiario')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->directos_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
      
      $data['directo'] = $this->directos_model->get_directos($id);
      $data['main_content'] = 'directo/editar_view';
      $data['title'] = 'Editar directo';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $data['beneficiario'] = mb_strtoupper(trim($this->input->post('beneficiario')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->directos_model->actualizar($id, $data);
      redirect(base_url().'directo/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->directos_model->eliminar($id);
      redirect(base_url().'directo/lista');
    }
    else
      redirect(base_url());
  }
  
}//fin class
