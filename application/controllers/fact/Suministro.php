<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suministro extends CI_Controller{

  public function index(){//MENU
    if(isAdmin()){
      $data['main_content'] = 'suministro/index_view';
      $data['title'] = 'Menu suministro';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function lista(){
    if(isAdmin()){
      $data['suministros'] = $this->suministros_model->get_all();
      $data['main_content'] = 'suministro/lista_view';
      $data['title'] = 'Lista de suministros';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isAdmin()){
      $data['suministros'] = $this->suministros_model->get_all();
      $data['main_content'] = 'suministro/nuevo_view';
      $data['title'] = 'Nuevo suministro';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin())
    {
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['suministro'] = mb_strtoupper(trim($this->input->post('suministro')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->suministros_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
      
      $data['suministro'] = $this->suministros_model->get_suministro($id);
      $data['main_content'] = 'suministro/editar_view';
      $data['title'] = 'Editar suministro';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['suministro'] = mb_strtoupper(trim($this->input->post('suministro')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->suministros_model->actualizar($id, $data);
      redirect(base_url().'suministro/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->suministros_model->eliminar($id);
      redirect(base_url().'suministro/lista');
    }
    else
      redirect(base_url());
  }
  
}//fin class
