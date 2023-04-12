<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Liberacion extends CI_Controller{

  public function index(){//MENU
    if(isAdmin()){
      $data['main_content'] = 'liberacion/index_view';
      $data['title'] = 'Menu liberación';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function lista(){
    if(isAdmin()){
      $data['liberaciones'] = $this->liberaciones_model->get_all();
      $data['main_content'] = 'liberacion/lista_view';
      $data['title'] = 'Lista de liberaciones';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isAdmin()){
      $data['liberaciones'] = $this->liberaciones_model->get_all();
      $data['main_content'] = 'liberacion/nuevo_view';
      $data['title'] = 'Nuevo liberacion';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin())
    {
      $data['liberacion'] = mb_strtoupper(trim($this->input->post('liberacion')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->liberaciones_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
      
      $data['liberacion'] = $this->liberaciones_model->get_liberacion($id);
      $data['main_content'] = 'liberacion/editar_view';
      $data['title'] = 'Editar liberacion';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $data['liberacion'] = mb_strtoupper(trim($this->input->post('liberacion')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->liberaciones_model->actualizar($id, $data);
      redirect(base_url().'liberacion/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->liberaciones_model->eliminar($id);
      redirect(base_url().'liberacion/lista');
    }
    else
      redirect(base_url());
  }
  
}//fin class
