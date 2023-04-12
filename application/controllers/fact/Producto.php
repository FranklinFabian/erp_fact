<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller
{
  public function index(){
    if(isAdmin()){
      $data['main_content'] = 'producto/index_view';
      $data['title'] = 'productos';
      $data['productos'] = $this->producto_model->get_all();
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo_producto(){
    if(isAdmin()){
      
      $data['unidades'] = $this->parametrica_unidad_medida_model->get_all();
      $data['prod_serv'] = $this->producto_servicio_model->get_all();

      $data['main_content'] = 'producto/producto_view';
      $data['title'] = 'Crear producto';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function crear_producto()
  {
    if(isAdmin()){

      $resultado_verificacion = $this->producto_model->verificar_nombre(trim(mb_strtoupper($this->input->post('nombre_producto'))));

      if($resultado_verificacion){
        $data['nombre_producto']=trim(mb_strtoupper($this->input->post('nombre_producto')));
        $data['cod_producto']=trim(mb_strtoupper($this->input->post('cod_producto')));
        $data['id_unidad_medida']=trim(mb_strtoupper($this->input->post('id_parametrica_unidad_medida')));
        $data['id_producto_servicio']=$this->input->post('id_producto_servicio');
        $data['estado_producto']=trim(mb_strtoupper($this->input->post('estado_producto')));
        $data['precio_venta']=trim(mb_strtoupper($this->input->post('precio_venta')));
        $data['id_categoria']=$this->input->post('id_categoria');
        $this->producto_model->insertar($data);
        echo "ok";
      }else{
        echo trim(mb_strtoupper($this->input->post('nombre_producto')));// nombre prod repetido
      }

    }
    else
      redirect(base_url());
  }//fin funcion

  public function editar_producto($id_producto)
  {
    if(isAdmin())
    {
      $data['producto']=$this->producto_model->get_producto($id_producto);
      $data['unidades'] = $this->parametrica_unidad_medida_model->get_all();
      $data['prod_serv'] = $this->producto_servicio_model->get_all();

      $data['main_content'] = 'producto/editar_producto_view';
      $data['title'] = 'Editar producto';
      $this->load->view('template/template_view', $data);
    }
  }

  public function actualizar_producto($id_producto)
  {
    if(isAdmin()){
      $producto = $this->producto_model->get_producto($id_producto);
      $duplicado = false;
      $resultado = $this->producto_model->extraer_menos(trim(mb_strtoupper($producto['nombre_producto'])));
      //var_dump($resultado);
      foreach ($resultado as $key => $value) {
        if($value['nombre_producto'] == trim(mb_strtoupper($this->input->post('nombre_producto')))){
          $duplicado = true;
          break;
        }
      }

      if (!$duplicado){
        $data['nombre_producto']=trim(mb_strtoupper($this->input->post('nombre_producto')));
        $data['cod_producto']=trim(mb_strtoupper($this->input->post('cod_producto')));
        $data['id_unidad_medida']=trim(mb_strtoupper($this->input->post('id_unidad_medida')));
        $data['id_producto_servicio']=trim(mb_strtoupper($this->input->post('id_producto_servicio')));
        $data['estado_producto']=trim(mb_strtoupper($this->input->post('estado_producto')));
        $data['precio_venta']=trim(mb_strtoupper($this->input->post('precio_venta')));
        $data['id_categoria']=$this->input->post('id_categoria');

        $this->producto_model->actualizar($id_producto, $data);  
        echo "ok";
      }else{
        echo trim(mb_strtoupper($this->input->post('nombre_producto')));
      }

    }
  }//fin funcion

  public function eliminar_producto($id_producto)
  {
    if(isAdmin())
    {
      $this->producto_model->eliminar($id_producto);
      redirect(base_url().'producto');
    }
  }//fin funcion

  public function imp_productos()
  {
    if(isLogin()){
      $data['productos'] = $this->producto_model->get_all();
      $data['title'] = 'Productos del sistema';
      $this->load->view('producto/imp_productos_view', $data);
    }
    else
      redirect(base_url());    
  }


}//fin class
