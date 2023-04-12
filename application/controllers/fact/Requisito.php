<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisito extends CI_Controller{

  public function lista(){
    if(isLogin()){
      $data['requisitos'] = $this->requisitos_model->get_all_idservicio(1);
      $data['main_content'] = 'requisito/lista_view';
      $data['title'] = 'Lista de requisitos';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function lista_cable(){
    if(isLogin()){
      $data['requisitos'] = $this->requisitos_model->get_all_idservicio(2);
      $this->load->view('requisito/lista_cable_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo(){
    if(isLogin()){
      
      $data['main_content'] = 'requisito/nuevo_view';
      $data['title'] = 'Nuevo requisito';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function buscar_cliente(){
    if(isLogin()){
      $razon_social = trim(mb_strtoupper($this->input->post('razon_social')));
      $resultado = array();
      if(($razon_social==''))
        $resultado = null; //echo 'Debe indroducir algún criterio de busqueda';
      else
        $resultado = $this->cliente_model->buscar_completo($razon_social);
      $salida='';
      $i=1;
      if(!is_null($resultado)){
        $salida.= '
        <table>
          <thead>
            <tr>
              <th>Nro.</th>
              <th>Cliente</th>
              <th>Nombre</th>
              <th>NIT</th>
              <th>Nacimiento</th>
              <th>Telefono</th>
              <th>Email</th>
              <th>Generar</th>
            </tr>
          </thead>
          <tbody>';
          foreach ($resultado as $key => $value) {
            $salida.='
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['ci']).'</td>
              <td>'.($value['razon_social']).'</td>
              <td>'.($value['nit']).'</td>
              <td>'.($value['nacimiento']).'</td>
              <td>'.($value['telefono']).'</td>
              <td>'.($value['correo']).'</td>
              <td> <a id="btn_editar" class="button-small pure-button pure-button-primary" href="javascript:generar_requisito('.$value['idcliente'].')">Generar</button></td>
            </tr>            
            ';
          }
          $salida.='</tbody>
        </table>        
        ';
        echo $salida;
      }else{
        echo 'Debe indroducir algún criterio de busqueda';
      }
    }
    else
      redirect(base_url());
  }
  public function generar_nuevo_requisito($idcliente){
    $data['cliente'] = $this->cliente_model->get_cliente($idcliente);
    $data['zonas'] = $this->zonas_model->get_all();
    $data['servicios'] = $this->servicios_model->get_all();
    
    $this->load->view('requisito/generar_nuevo_requisito_view', $data);
  }

  public function cargar_calle_zona($id_zona){
    $html='<select name="idcalle" id="idcalle" style="width: 90%;" required="required">';
    $html.='<option value="">Seleccione</option>';
    $calles = $this->calles_model->get_calle_zona($id_zona);
    foreach ($calles as $key => $value)
      $html.='<option value="'.$value['idcalle'].'">'.$value['calle'].'</option>';
    $html.='</select>';
    echo $html;
  }//fin funcion para ajax


  public function crear_requisito(){
    if(isLogin())
    {
      $ultimo_registro=$this->requisitos_model->get_ultimo_correlativo_servicio($this->input->post('idservicio'));
      $correlativo=0;
      if(is_null($ultimo_registro))
        $correlativo=1;
      else{
        $correlativo=$ultimo_registro['correlativo']+1;
      }
      $data['correlativo'] = $correlativo;
      $data['idservicio'] = $this->input->post('idservicio');
      $data['fecha'] = date('Y-m-d H:i:s');
      $data['idcliente'] = mb_strtoupper(trim($this->input->post('idcliente')));
      $data['idzona'] = mb_strtoupper(trim($this->input->post('idzona')));
      $data['idcalle'] = mb_strtoupper(trim($this->input->post('idcalle')));
      $data['numero'] = mb_strtoupper(trim($this->input->post('numero')));
      $data['referencias'] = mb_strtoupper(trim($this->input->post('referencias')));
      $data['estado'] = 'S';
      $data['atencion'] = NULL;
      $data['empleado'] = NULL;
      $data['usuario'] = $this->session->userdata('usuario');
      $this->requisitos_model->insertar($data);
      //var_dump($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isLogin()){
      
      $data['requisito'] = $this->requisitos_model->get_requisito($id);
      $data['main_content'] = 'requisito/editar_view';
      $data['title'] = 'Editar requisito';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isLogin()){
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['requisito'] = mb_strtoupper(trim($this->input->post('requisito')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->requisitos_model->actualizar($id, $data);
      redirect(base_url().'requisito/lista');
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isLogin()){
      $this->requisitos_model->eliminar($id);
      redirect(base_url().'requisito/lista');
    }
    else
      redirect(base_url());
  }
  
  public function imprimir_solicitud($id){
    if(isLogin()){
      $data['requisito'] = $this->requisitos_model->get_requisito($id);
      $data['main_content'] = 'requisito/lista_view';
      $data['title'] = 'Impresión requisitos';
      $this->load->view('requisito/imprimir_solicitud_view', $data);
    }
    else
      redirect(base_url());
  }
  
  public function imprimir_solicitud_cable($id){
    if(isLogin()){
      $data['requisito'] = $this->requisitos_model->get_requisito($id);
      $data['main_content'] = 'requisito/lista_view';
      $data['title'] = 'Impresión requisitos';
      $this->load->view('requisito/imprimir_solicitud_cable_view', $data);
    }
    else
      redirect(base_url());
  }

  public function cerrar_solicitud($id){
    if(isLogin()){
      $requisito = $this->requisitos_model->get_requisito($id);
      $cliente = $this->cliente_model->get_cliente($requisito['idcliente']);
      $direccion = $this->calles_model->get_all_all($requisito['idcalle']);
      $empleados = $this->empleados_model->get_all_vigente();
      
      $data['empleados'] = $empleados;
      $data['direccion'] = $direccion;
      $data['cliente'] = $cliente;
      $data['requisito'] = $requisito;
      $data['main_content'] = 'requisito/cerrar_solicitud_view';
      $data['title'] = 'Cerrar requisito';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function ejecutar_cierre($id){
    if(isLogin()){
      $fecha_atencion = $this->input->post('fecha_atencion');
      $hora_atencion = $this->input->post('hora_atencion');
      //$tiempo = $this->input->post('tiempo');
      $idempleado = $this->input->post('idempleado');
      $empleado = $this->empleados_model->get_empleado($idempleado);

      $data_requisito['estado'] = 'E';
      $data_requisito['atencion'] = $fecha_atencion.' '.$hora_atencion.':00';
      $data_requisito['empleado'] = $empleado['paterno'].' '.$empleado['materno'].' '.$empleado['nombre'];
      //$data_requisito['tiempo'] = $tiempo;
      $data_requisito['usuario'] = $this->session->userdata('usuario');
      $this->requisitos_model->actualizar($id, $data_requisito);
      echo 'ok';
    }
    else
      redirect(base_url());
  }


  
}//fin class
