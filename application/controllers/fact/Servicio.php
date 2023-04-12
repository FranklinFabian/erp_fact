<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicio extends CI_Controller{

  public function index(){//MENU
    if(isAdmin()){
      $data['main_content'] = 'servicio/index_view';
      $data['title'] = 'Menu liberación';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function lista(){
    if(isAdmin()){
      $data['servicios'] = $this->servicios_model->get_all();
      $data['main_content'] = 'servicio/lista_view';
      $data['title'] = 'Lista de servicios';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isAdmin()){
      $data['servicios'] = $this->servicios_model->get_all();
      $data['main_content'] = 'servicio/nuevo_view';
      $data['title'] = 'Nuevo servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin())
    {
      $data['descripcion'] = mb_strtoupper(trim($this->input->post('descripcion')));
      $this->servicios_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
      
      $data['servicio'] = $this->servicios_model->get_servicio($id);
      $data['main_content'] = 'servicio/editar_view';
      $data['title'] = 'Editar servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $data['descripcion'] = mb_strtoupper(trim($this->input->post('descripcion')));
      $this->servicios_model->actualizar($id, $data);
      redirect(base_url().'servicio/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->servicios_model->eliminar($id);
      redirect(base_url().'servicio/lista');
    }
    else
      redirect(base_url());
  }
  
}//fin class
