<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado extends CI_Controller{

  public function index(){//MENU
    if(isAdmin()){
      $data['main_content'] = 'estado/index_view';
      $data['title'] = 'Menu estado';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function lista(){
    if(isAdmin()){
      $data['estados'] = $this->estados_model->get_all();
      $data['main_content'] = 'estado/lista_view';
      $data['title'] = 'Lista de estados';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isAdmin()){
      $data['estados'] = $this->estados_model->get_all();
      $data['main_content'] = 'estado/nuevo_view';
      $data['title'] = 'Nuevo estado';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin())
    {
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['estado'] = mb_strtoupper(trim($this->input->post('estado')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->estados_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
      
      $data['estado'] = $this->estados_model->get_estado($id);
      $data['main_content'] = 'estado/editar_view';
      $data['title'] = 'Editar estado';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['estado'] = mb_strtoupper(trim($this->input->post('estado')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->estados_model->actualizar($id, $data);
      redirect(base_url().'estado/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->estados_model->eliminar($id);
      redirect(base_url().'estado/lista');
    }
    else
      redirect(base_url());
  }
  
}//fin class
