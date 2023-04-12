<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicion extends CI_Controller{

  public function index(){//MENU
    if(isAdmin()){
      $data['main_content'] = 'medicion/index_view';
      $data['title'] = 'Menu liberación';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function lista(){
    if(isAdmin()){
      $data['mediciones'] = $this->mediciones_model->get_all();
      $data['main_content'] = 'medicion/lista_view';
      $data['title'] = 'Lista de mediciones';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isAdmin()){
      $data['mediciones'] = $this->mediciones_model->get_all();
      $data['main_content'] = 'medicion/nuevo_view';
      $data['title'] = 'Nuevo medicion';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin())
    {
      $data['codigo'] = mb_strtoupper(trim($this->input->post('medicion')));
      $data['medicion'] = mb_strtoupper(trim($this->input->post('medicion')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->mediciones_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
      
      $data['medicion'] = $this->mediciones_model->get_medicion($id);
      $data['main_content'] = 'medicion/editar_view';
      $data['title'] = 'Editar medicion';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['medicion'] = mb_strtoupper(trim($this->input->post('medicion')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->mediciones_model->actualizar($id, $data);
      redirect(base_url().'medicion/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->mediciones_model->eliminar($id);
      redirect(base_url().'medicion/lista');
    }
    else
      redirect(base_url());
  }
  
}//fin class
