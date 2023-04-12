<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ley1886 extends CI_Controller{

  public function index(){//MENU
    if(isAdmin()){
      $data['main_content'] = 'ley1886/index_view';
      $data['title'] = 'Menu ley1886';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function lista(){
    if(isAdmin()){
      $data['ley1886s'] = $this->ley1886_model->get_all();
      $data['main_content'] = 'ley1886/lista_view';
      $data['title'] = 'Lista de ley1886';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isAdmin()){
      $data['ley1886'] = $this->ley1886_model->get_all();
      $data['main_content'] = 'ley1886/nuevo_view';
      $data['title'] = 'Nueva ley1886';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin())
    {
      $data['inicio'] = $this->input->post('inicio');
      $data['final'] = $this->input->post('final');
      $data['vigente'] = $this->input->post('vigente');
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->ley1886_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
      
      $data['ley1886'] = $this->ley1886_model->get_ley1886($id);
      $data['main_content'] = 'ley1886/editar_view';
      $data['title'] = 'Editar ley1886';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $data['inicio'] = $this->input->post('inicio');
      $data['final'] = $this->input->post('final');
      $data['vigente'] = $this->input->post('vigente');
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->ley1886_model->actualizar($id, $data);
      redirect(base_url().'ley1886/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->ley1886_model->eliminar($id);
      redirect(base_url().'ley1886/lista');
    }
    else
      redirect(base_url());
  }
  
}//fin class
