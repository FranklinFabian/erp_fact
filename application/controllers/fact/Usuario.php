<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller
{
  public function index()
  {
    if(isAdmin())
    {
      $data['main_content'] = 'usuario/index_view';
      $data['title'] = 'Usuarios';
      $data['usuarios'] = $this->empleado_model->get_all();
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo_usuario()
  {
    if(isAdmin())
    {
      $data['main_content'] = 'usuario/usuario_view';
      $data['title'] = 'crear usuario';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function crear_usuario()
  {
    if(isAdmin())
    {
      $data['nombre']=trim(mb_strtoupper($this->input->post('nombre')));
      $data['apellido']=trim(mb_strtoupper($this->input->post('apellido')));
      $data['usuario']=trim($this->input->post('usuario'));
      $data['password']=md5($this->input->post('password'));
      $data['nivel']=trim(mb_strtoupper($this->input->post('nivel')));
      if($this->input->post('nivel') != 0)
        $data['id_punto_venta']=$this->input->post('id_punto_venta');
      else 
        $data['id_punto_venta']=NULL;
      $data['estado']=trim(mb_strtoupper($this->input->post('estado')));
      $this->empleado_model->insertar($data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function editar_usuario($id_empleado)
  {
    if(isAdmin())
    {
      $data['usuario']=$this->empleado_model->get_empleado($id_empleado);
      $data['main_content'] = 'usuario/editar_usuario_view';
      $data['title'] = 'editar usuario';
      $this->load->view('template/template_view', $data);
    }
  }

  public function actualizar_usuario($id_empleado)
  {
    if(isAdmin())
    {
      $data['nombre']=trim(mb_strtoupper($this->input->post('nombre')));
      $data['apellido']=trim(mb_strtoupper($this->input->post('apellido')));
      $data['usuario']=trim($this->input->post('usuario'));
      $data['nivel']=trim(mb_strtoupper($this->input->post('nivel')));
      if($this->input->post('nivel') != 0)
        $data['id_punto_venta']=$this->input->post('id_punto_venta');
      else 
        $data['id_punto_venta']=NULL;
      $data['estado']=trim(mb_strtoupper($this->input->post('estado')));
      $this->empleado_model->actualizar($id_empleado, $data);
    }
  }//fin funcion

  public function bloquear_usuario($id_empleado)
  {
    if(isAdmin())
    {
      $data['estado']='0';
      $this->empleado_model->actualizar($id_empleado, $data);
      redirect(base_url().'usuario');
    }
  }//fin funcion

  public function borrar_password($id_empleado)
  {
    if(isAdmin())
    {
      $data['password']=md5('123456');
      $this->empleado_model->actualizar($id_empleado, $data);
      redirect(base_url().'usuario');
    }
  }//fin funcion

}//fin class
