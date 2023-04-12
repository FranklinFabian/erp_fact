<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consumidor extends CI_Controller{

  public function index(){//MENU
    if(isAdmin()){
      $data['main_content'] = 'consumidor/index_view';
      $data['title'] = 'Menu consumidor';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function lista(){
    if(isAdmin()){
      $data['consumidores'] = $this->consumidores_model->get_all();
      $data['main_content'] = 'consumidor/lista_view';
      $data['title'] = 'Lista de consumidores';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isAdmin()){
      $data['consumidores'] = $this->consumidores_model->get_all();
      $data['main_content'] = 'consumidor/nuevo_view';
      $data['title'] = 'Nuevo consumidor';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin())
    {
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['consumidor'] = mb_strtoupper(trim($this->input->post('consumidor')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->consumidores_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
      
      $data['consumidor'] = $this->consumidores_model->get_consumidor($id);
      $data['main_content'] = 'consumidor/editar_view';
      $data['title'] = 'Editar consumidor';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['consumidor'] = mb_strtoupper(trim($this->input->post('consumidor')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->consumidores_model->actualizar($id, $data);
      redirect(base_url().'consumidor/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->consumidores_model->eliminar($id);
      redirect(base_url().'consumidor/lista');
    }
    else
      redirect(base_url());
  }
  
}//fin class
