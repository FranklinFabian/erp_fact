<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller
{
  public function index()
  {
    if(isAdmin())
    {
      $data['main_content'] = 'categoria/index_view';
      $data['title'] = 'Apertura programaticas';
      $data['aperturas_programaticas'] = $this->categoria_model->get_all();
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo_categoria()
  {
    if(isAdmin())
    {
      $data['main_content'] = 'categoria/categoria_view';
      $data['title'] = 'Crear categoria';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function crear_categoria()
  {
    if(isAdmin())
    {
      $data['nombre_categoria']=trim(mb_strtoupper($this->input->post('nombre_categoria')));
      $data['estado_categoria']=trim(mb_strtoupper($this->input->post('estado_categoria')));
      $this->categoria_model->insertar($data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function editar_categoria($id_categoria)
  {
    if(isAdmin())
    {
      $data['categoria']=$this->categoria_model->get_categoria($id_categoria);
      $data['main_content'] = 'categoria/editar_categoria_view';
      $data['title'] = 'Editar apertura programatica';
      $this->load->view('template/template_view', $data);
    }
  }

  public function actualizar_categoria($id_categoria)
  {
    if(isAdmin())
    {
      $data['nombre_categoria']=trim(mb_strtoupper($this->input->post('nombre_categoria')));
      $data['estado_categoria']=trim(mb_strtoupper($this->input->post('estado_categoria')));
      $this->categoria_model->actualizar($id_categoria, $data);
    }
  }//fin funcion

  public function bloquear_categoria($id_categoria)
  {
    if(isAdmin())
    {
      $data['estado_categoria']='0';
      $this->categoria_model->actualizar($id_categoria, $data);
      redirect(base_url().'categoria');
    }
  }//fin funcion

  public function imp_categorias()
  {
    if(isLogin()){
      $configuracion = $this->configuracion_model->get_all();
      if(is_null($configuracion))
        $direccion_telefono = $this->config->item('cel_reporte');
      else
        $direccion_telefono = $configuracion['direccion'].' - Telf./Cel.: '.$configuracion['telefono'];

      $data['direccion_telefono'] = $direccion_telefono;
      $data['categorias'] = $this->categoria_model->get_all();
      $data['title'] = 'Categorias del sistema';
      $this->load->view('categoria/imp_categorias_view', $data);
    }
    else
      redirect(base_url());    
  }

}//fin class
