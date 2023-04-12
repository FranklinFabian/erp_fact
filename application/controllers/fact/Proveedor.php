<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller{
  public function index(){
    if(isLogin()){
      $proveedores = $this->proveedor_model->get_all();
      $data['proveedores'] = $proveedores;

      $data['main_content'] = 'proveedor/index_view';
      $data['title'] = 'Proveedor';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }
  
  public function nuevo(){
    if(isLogin()){
      $tipo_proveedor = $this->config->item('tipo_proveedor');
      $data['tipo_proveedor'] = $tipo_proveedor;
      $data['main_content'] = 'proveedor/nuevo_view';
      $data['title'] = 'Crear proveedor';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function crear()
  {
    if(isLogin()){
        $data['tipo_proveedor']=$this->input->post('tipo_proveedor');
        $data['razon_social']=trim(mb_strtoupper($this->input->post('razon_social')));
        $data['nit_ci']=trim(mb_strtoupper($this->input->post('nit_ci')));
        $data['direccion']=trim(mb_strtoupper($this->input->post('direccion')));
        $data['telefono']=trim(mb_strtoupper($this->input->post('telefono')));
        $data['celular']=trim(mb_strtoupper($this->input->post('celular')));
        $data['contacto']=trim(mb_strtoupper($this->input->post('contacto')));
        $data['cel_contacto']=trim(mb_strtoupper($this->input->post('cel_contacto')));
        $data['estado']='1';
//        $data['estado_proveedor']=trim(mb_strtoupper($this->input->post('estado_proveedor')));
        $this->proveedor_model->insertar($data);
        echo "ok";
    }
    else
      redirect(base_url());
  }//fin funcion

  public function editar($id_proveedor){
    if(isLogin()){
      $tipo_proveedor = $this->config->item('tipo_proveedor');
      $data['tipo_proveedor'] = $tipo_proveedor;

      $data['proveedor']=$this->proveedor_model->get_proveedor($id_proveedor);
      $data['main_content'] = 'proveedor/editar_view';
      $data['title'] = 'Editar proveedor';
      $this->load->view('template/template_view', $data);
    }
  }

  public function actualizar($id_proveedor){
    if(isLogin()){
      $data['tipo_proveedor']=$this->input->post('tipo_proveedor');
      $data['razon_social']=trim(mb_strtoupper($this->input->post('razon_social')));
      $data['nit_ci']=trim(mb_strtoupper($this->input->post('nit_ci')));
      $data['direccion']=trim(mb_strtoupper($this->input->post('direccion')));
      $data['telefono']=trim(mb_strtoupper($this->input->post('telefono')));
      $data['celular']=trim(mb_strtoupper($this->input->post('celular')));
      $data['contacto']=trim(mb_strtoupper($this->input->post('contacto')));
      $data['cel_contacto']=trim(mb_strtoupper($this->input->post('cel_contacto')));
      $data['estado']=trim(mb_strtoupper($this->input->post('estado')));
      $this->proveedor_model->actualizar($id_proveedor, $data);  
      echo "ok";
    }
    else
    redirect(base_url());
  }//fin funcion

  public function bloquear($id_proveedor){
    if(isLogin()){
      $data['estado']='0';
      $this->proveedor_model->actualizar($id_proveedor, $data); 
      redirect(base_url().'proveedor');
    }
  }//fin funcion

  public function imprimir(){
    if(isLogin()){
      $tipo_proveedor = $this->config->item('tipo_proveedor');
      $data['tipo_proveedor'] = $tipo_proveedor;
      $data['proveedores'] = $this->proveedor_model->get_all();
      $data['title'] = 'proveedores del sistema';
      $this->load->view('proveedor/imprimir_view', $data);
    }
    else
      redirect(base_url());    
  }


}//fin class
