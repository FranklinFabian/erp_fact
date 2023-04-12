<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidad_medida extends CI_Controller{
  public function index(){
    if(isLogin()){
      $unidad_medidaes = $this->unidad_medida_model->get_all();
      $data['unidad_medidaes'] = $unidad_medidaes;

      $data['main_content'] = 'unidad_medida/index_view';
      $data['title'] = 'unidad_medida';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }
  
  public function nuevo(){
    if(isLogin()){
      $tipo_unidad_medida = $this->config->item('tipo_unidad_medida');
      $data['tipo_unidad_medida'] = $tipo_unidad_medida;
      $data['main_content'] = 'unidad_medida/nuevo_view';
      $data['title'] = 'Crear unidad_medida';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function crear()
  {
    if(isLogin()){
        $data['descripcion']=trim(mb_strtoupper($this->input->post('descripcion')));
        $data['estado']=trim(mb_strtoupper($this->input->post('estado')));
        $this->unidad_medida_model->insertar($data);
        echo "ok";
    }
    else
      redirect(base_url());
  }//fin funcion

  public function editar($id_unidad_medida){
    if(isLogin()){

      $data['unidad_medida']=$this->unidad_medida_model->get_unidad_medida($id_unidad_medida);
      $data['main_content'] = 'unidad_medida/editar_view';
      $data['title'] = 'Editar unidad_medida';
      $this->load->view('template/template_view', $data);
    }
  }

  public function actualizar($id_unidad_medida){
    if(isLogin()){
      $data['descripcion']=trim(mb_strtoupper($this->input->post('descripcion')));
      $data['estado']=trim(mb_strtoupper($this->input->post('estado')));
      $this->unidad_medida_model->actualizar($id_unidad_medida, $data);  
      echo "ok";
    }
    else
    redirect(base_url());
  }//fin funcion

  public function bloquear($id_unidad_medida){
    if(isLogin()){
      $data['estado']='0';
      $this->unidad_medida_model->actualizar($id_unidad_medida, $data); 
      redirect(base_url().'unidad_medida');
    }
  }//fin funcion

  public function imprimir(){
    if(isLogin()){
      $data['unidades_medida'] = $this->unidad_medida_model->get_all();
      $data['title'] = 'Unidades de medida del sistema';
      $this->load->view('unidad_medida/imprimir_view', $data);
    }
    else
      redirect(base_url());    
  }


}//fin class
