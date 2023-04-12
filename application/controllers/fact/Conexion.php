<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Conexion extends CI_Controller{

  public function nuevo($idorden){
    if(isLogin()){
      $conexion = $this->conexiones_model->get_conexion_idorden($idorden);
      $orden = $this->ordenes_model->get_orden($idorden);
      if(is_null($conexion)){
        $data['orden'] = $orden;
        $data['main_content'] = 'conexion/nuevo_view';
        $data['title'] = 'Nueva conexión';
        $this->load->view('template/template_view', $data);
  
      }else{
        redirect(base_url().'orden_servicio/listar_ordenes_servicio/'.$orden['idabonado'].'/'.$orden['idservicio']);
      }

    }
    else
      redirect(base_url());
  }

  public function crear($idorden){
    if(isLogin())
    {
      $orden=$this->ordenes_model->get_orden($idorden);
      $ultima_fila = $this->conexiones_model->get_ultima_fila($orden['idservicio']);
      $numero=null;
      if(is_null($ultima_fila))
        $numero = 1;
      else
        $numero = $ultima_fila['numero'] + 1;

      $data['numero'] = $numero;
      $data['idservicio'] = $orden['idservicio'];;
      $data['idorden'] = $orden['idorden'];
      $data['usuario'] = $this->session->userdata('id_empleado');
      $data['fecha'] = date('Y-m-d h:i:s');
      $data['nota'] = trim(mb_strtoupper($this->input->post('nota')));
      $data['estado'] = 'S';
      $data['solicitante'] = trim(mb_strtoupper($this->input->post('solicitante')));
      $this->conexiones_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function imprimir_conexion($idconexion){
    if(isLogin()){
      $conexion = $this->conexiones_model->get_conexion($idconexion);
      $orden = $this->ordenes_model->get_orden($conexion['idorden']);
      $abonado = $this->abonados_model->get_abonado($orden['idabonado']);
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
      $centro = $this->centros_model->get_centro($abonado['idcentro']);
      $poste = $this->postes_model->get_poste($abonado['idposte']);
      $categoria = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      $servicio = $this->gestiones_model->get_gestion($orden['idgestion']);
      $costo = $this->costos_model->get_costo_by_idgestion($servicio['idgestion']);

      $data['orden'] = $orden;
      $data['conexion'] = $conexion;
      $data['abonado'] = $abonado;
      $data['cliente'] = $cliente;
      $data['centro'] = $centro;
      $data['poste'] = $poste;
      $data['categoria'] = $categoria;
      $data['direccion'] = $direccion;
      $data['servicio'] = $servicio;
      $data['costo'] = $costo;
      $data['ncategoria'] = $this->categorias_model->get_categorias($orden['ncategoria']);;
      $data['ncliente'] = $this->cliente_model->get_cliente($orden['ncliente']);;
      
      $data['title'] = 'Impresión nueva conexión';
      $this->load->view('conexion/imprimir_conexion_view', $data);      
    }
    else
      redirect(base_url());
  }
 
}//fin class
