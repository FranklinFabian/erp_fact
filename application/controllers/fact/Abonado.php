<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Abonado extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/abonados_model');
    $this->load->model('fact/clientes_model');
    $this->load->model('fact/zonas_model');
    $this->load->model('fact/localidades_model');
    $this->load->model('fact/calles_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  } 
  public function lista(){
        
      $data['main_content'] = 'abonado/lista_view';
      $data['title'] = 'Lista de abonados';
      $this->load->view('template/template_view', $data);
    
  }

  public function buscar_cliente(){
    
      $razon_social = trim(mb_strtoupper($this->input->post('razon_social')));
      $resultado = array();
      if(($razon_social==''))
        $resultado = null; //echo 'Debe indroducir algún criterio de busqueda';
      else
        $resultado = $this->cliente_model->buscar_completo($razon_social);
        $html='';
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
              <th>Email</th>';
                if(isAdmin())
                  $html.='<th>Editar</th>';
              $salida.='
              <th>Alerta</th>
              <th>Abonados</th>
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
              <td>'.($value['correo']).'</td>';
              if(isAdmin())
                  $html.='<td> <a id="btn_editar" class="button-small pure-button button-warning" href="'.base_url().'abonado/editar/'.$value['idcliente'].'">Editar</button></td>';
              $salida.='
              <td> <a id="btn_eliminar" class="button-small pure-button button-warning" href="javascript:eliminar('.$value['idcliente'].')">Alerta</button></td>
              <td> <a id="btn_editar" class="button-small pure-button pure-button-primary" href="'.base_url().'abonado/listar_abonos_cliente/'.$value['idcliente'].'">Abonados</button></td>
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

  public function listar_abonos_cliente($idcliente){
   
      $data['cliente'] = $this->cliente_model->get_cliente($idcliente);      
      $data['abonos_cliente'] = $this->abonados_model->get_abonos_cliente($idcliente);      
      $data['main_content'] = 'abonado/listar_abonos_cliente_view';
      $data['title'] = 'Lista de abonados por cliente';
      $this->load->view('template/template_view', $data);
    
  }

  public function imprimir_contrato($idabonado){
    
      $abonado=$this->abonados_model->get_abonado($idabonado);
      $data['abonado'] = $abonado;
      $data['title'] = 'Contrato';
      if($abonado['idservicio']=='1')
        $this->load->view('abonado/imprimir_contrato_view', $data);
      else 
        $this->load->view('abonado/imprimir_contrato_cable_view', $data);
    
  }

  public function cargar_categoria_servicio($idservicio){
    $html='<select name="idcategoria" id="idcategoria" required="required">';
    $html.='<option value="">Seleccione</option>';
    $categorias = $this->categorias_model->get_categorias_servicio($idservicio);
    foreach ($categorias as $key => $value)
      $html.='<option value="'.$value['idcategoria'].'">'.$value['categoria'].'</option>';
    $html.='</select>';
    echo $html;
  }//fin funcion para ajax

  public function cargar_zona_localidad($id_localidad){
    $html='<select name="idzona" id="idzona" onchange="cambio_calle();" required="required">';
    $html.='<option value="">Seleccione</option>';
    $zonas = $this->zonas_model->get_zona_localidad($id_localidad);
    foreach ($zonas as $key => $value)
      $html.='<option value="'.$value['idzona'].'">'.$value['zona'].'</option>';
    $html.='</select>';
    echo $html;
  }//fin funcion para ajax

  public function cargar_poste_centro($idcentro){
    $html='<select name="idposte" id="idposte" onchange="" required="required">';
    $html.='<option value="">Seleccione</option>';
    $postes = $this->postes_model->get_poste_centro($idcentro);
    foreach ($postes as $key => $value)
      $html.='<option value="'.$value['idposte'].'">'.$value['poste'].'</option>';
    $html.='</select>';
    echo $html;
  }//fin funcion para ajax

  public function cargar_centro_localidad($id_localidad){
    $html='<select name="idcentro" id="idcentro" onchange="cambio_poste();" required="required">';
    $html.='<option value="">Seleccione</option>';
    $centros = $this->centros_model->get_centro_localidad($id_localidad);
    foreach ($centros as $key => $value)
      $html.='<option value="'.$value['idcentro'].'">'.$value['codigo'].' - '.$value['centro'].'</option>';
    $html.='</select>';
    echo $html;
  }//fin funcion para ajax

  public function cargar_calle_zona($id_zona){
    $html='<select name="idcalle" id="idcalle" required="required">';
    $html.='<option value="">Seleccione</option>';
    $calles = $this->calles_model->get_calle_zona($id_zona);
    foreach ($calles as $key => $value)
      $html.='<option value="'.$value['idcalle'].'">'.$value['calle'].'</option>';
    $html.='</select>';
    echo $html;
  }//fin funcion para ajax

  public function nuevo($idcliente){
    
      $data['cliente'] = $this->cliente_model->get_cliente($idcliente);
      $data['localidades'] = $this->localidades_model->get_all();
      $data['suministros'] = $this->suministros_model->get_all();

      $data['postes'] = $this->postes_model->get_all();
      $data['calles'] = $this->calles_model->get_all();
      $data['categorias'] = $this->categorias_model->get_all();
      $data['estados'] = $this->estados_model->get_all();
      $data['liberaciones'] = $this->liberaciones_model->get_all();
      $data['consumidores'] = $this->consumidores_model->get_all();
      $data['mediciones'] = $this->mediciones_model->get_all();
      $data['servicios'] = $this->servicios_model->get_all();
      
      $data['main_content'] = 'abonado/nuevo_view';
      $data['title'] = 'Nueva abonado';
      $this->load->view('template/template_view', $data);
    
  }

  public function crear(){
    
      $ultimo_registro=$this->abonados_model->get_ultimo_correlativo_abonado($this->input->post('idservicio'));
      $abonado=0;
      if(is_null($ultimo_registro))
        $abonado=1;
      else{
        $abonado=$ultimo_registro['abonado']+1;
      }
      $data['abonado'] = $abonado;

      $data['fase'] = 'R';
      $data['numero'] = mb_strtoupper(trim($this->input->post('numero')));
      $data['descripcion'] = mb_strtoupper(trim($this->input->post('descripcion')));
      $data['medidor'] = mb_strtoupper(trim($this->input->post('medidor')));
      $data['capacidad'] = 100;
      $data['indiceinicial'] = 0;
      $data['mulmed'] = 1;
      $data['encorte'] = 0;
      $data['instalacion'] = NULL;
      $data['corte'] = NULL;
      $data['reposicion'] = NULL;
      $data['cantidad'] = mb_strtoupper(trim($this->input->post('cantidad')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $data['idcliente'] = $this->input->post('idcliente');
      $data['idposte'] = $this->input->post('idposte');
      $data['idcalle'] = $this->input->post('idcalle');
      $data['idcategoria'] = $this->input->post('idcategoria');
      $data['idestado'] = 1;//1 SIN CONEXION, 
      $data['idliberacion'] = $this->input->post('idliberacion');
      $data['idsuministro'] = $this->input->post('idsuministro');
      $data['idconsumidor'] = $this->input->post('idconsumidor');
      $data['idmedicion'] = $this->input->post('idmedicion');
      $data['idservicio'] = $this->input->post('idservicio')==''?NULL:$this->input->post('idservicio');
      $data['idcentro'] = $this->input->post('idcentro');
      $data['fecha_registro_abonado'] = date('Y-m-d');
      $data['abonado'] = $abonado;
      //var_dump($data);
      $this->abonados_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
  
    
      $data['localidades'] = $this->localidades_model->get_all();
      $data['zonas'] = $this->zonas_model->get_all();
      $data['postes'] = $this->postes_model->get_all();
      $data['centros'] = $this->centros_model->get_all();

      $data['calles'] = $this->calles_model->get_all();
      $data['categorias'] = $this->categorias_model->get_all();
      $data['estados'] = $this->estados_model->get_all();
      $data['liberaciones'] = $this->liberaciones_model->get_all();
      $data['suministros'] = $this->suministros_model->get_all();
      $data['consumidores'] = $this->consumidores_model->get_all();
      $data['mediciones'] = $this->mediciones_model->get_all();
      $data['servicios'] = $this->servicios_model->get_all();

      $data['abonado'] = $this->abonados_model->get_abonado($id);
      $data['main_content'] = 'abonado/editar_view';
      $data['title'] = 'Editar abonado';
      $this->load->view('template/template_view', $data);
    
  }

  public function actualizar($id){
    
      $abonado = $this->abonados_model->get_abonado($id);
      $data['fase'] = mb_strtoupper(trim($this->input->post('fase')));
      $data['medidor'] = mb_strtoupper(trim($this->input->post('medidor')));
      $data['capacidad'] = mb_strtoupper(trim($this->input->post('capacidad')));
      $data['indiceinicial'] = mb_strtoupper(trim($this->input->post('indiceinicial')));
      $data['mulmed'] = mb_strtoupper(trim($this->input->post('mulmed')));
      $data['encorte'] = mb_strtoupper(trim($this->input->post('encorte')));
      $data['instalacion'] = $this->input->post('instalacion');
      $data['corte'] = $this->input->post('corte');
      $data['reposicion'] = $this->input->post('reposicion');
      $data['idestado'] = $this->input->post('idestado');
      $data['idservicio'] = $this->input->post('idservicio')==''?NULL:$this->input->post('idservicio');
      $data['idcategoria'] = $this->input->post('idcategoria');
      //$data['idlocalidad'] = $this->input->post('idlocalidad');
      //$data['idzona'] = $this->input->post('idzona');
      $data['idcalle'] = $this->input->post('idcalle');
      $data['numero'] = mb_strtoupper(trim($this->input->post('numero')));
      $data['descripcion'] = mb_strtoupper(trim($this->input->post('descripcion')));
      //$data['idcentro'] = $this->input->post('idcentro');
      $data['idposte'] = $this->input->post('idposte');
      $data['idsuministro'] = $this->input->post('idsuministro');
      $data['idconsumidor'] = $this->input->post('idconsumidor');
      $data['idmedicion'] = $this->input->post('idmedicion');
      $data['idliberacion'] = $this->input->post('idliberacion');
      $data['cantidad'] = mb_strtoupper(trim($this->input->post('cantidad')));

      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->abonados_model->actualizar($id, $data);
      redirect(base_url().'abonado/listar_abonos_cliente/'.$abonado['idcliente']);
    
  }
  
  public function eliminar($id){
    
      $this->abonados_model->eliminar($id);
      redirect(base_url().'abonado/lista');
    
  }
  
}//fin class
