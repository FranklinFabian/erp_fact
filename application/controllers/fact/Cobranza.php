<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cobranza extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/lecturas_model');
    $this->load->model('fact/lecturas_observadas_model');
    $this->load->model('fact/centros_model');
    $this->load->model('fact/abonados_model');
    $this->load->model('fact/periodos_model');
    $this->load->model('fact/calles_model');
    $this->load->model('fact/localidades_model');
    $this->load->model('fact/cliente_model');
    $this->load->model('fact/postes_model');
    $this->load->model('fact/categorias_model');
    $this->load->model('fact/categoria_model');
    $this->load->model('fact/estados_model');
    $this->load->model('fact/zonas_model');
    $this->load->model('fact/configuracion_model');
    $this->load->model('fact/comprobantes_model');
    $this->load->model('fact/servicios_model');
    $this->load->model('fact/facturas_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function index(){
    
      $data['main_content'] = 'fact/cobranza/index_view';
      $data['title'] = 'Cobranza';
      $content = $this->parser->parse('fact/cobranza/index_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
    
  }

  public function buscar_cliente(){
    
      $apellidos = trim(mb_strtoupper($this->input->post('apellidos')));
      $nombres = trim(mb_strtoupper($this->input->post('nombres')));
      $abonado = trim(mb_strtoupper($this->input->post('abonado')));
      $medidor = trim(mb_strtoupper($this->input->post('medidor')));

      $resultado = array();
      if(($apellidos=='') && ($nombres=='') && ($abonado=='') && ($medidor==''))
        $resultado = null; //echo 'Debe indroducir algún criterio de busqueda';
      elseif(($abonado=='') && ($medidor=='')){
        $resultado = $this->cliente_model->buscar_app_nom($apellidos, $nombres);
      }elseif($abonado != ''){//buscar por abonado
        $resultado = $this->cliente_model->buscar_por_abonado($abonado);
      }else{//por medidor
        $resultado = $this->cliente_model->buscar_por_medidor($medidor);
      }

      $salida='';
      $i=1;
      if(!is_null($resultado)){
        $salida.= '
        <table id="tabla_empleados" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
        <caption>Resultado busqueda</caption>
          <thead>
            <tr>
              <th>Abonado</th>
              <th>Razón Social</th>
              <th>Medidor</th>
              <th>Dirección</th>
              <th>Referencia</th>
              <th></th>
            </tr>
          </thead>
          <tbody>';
          foreach ($resultado as $key => $value) {
            $direccion = $this->calles_model->get_all_all($value['idcalle']);
            $salida.='
            <tr>
              <td>'.($value['abonado']).'</td>
              <td>'.($value['razon_social']).'</td>
              <td>'.($value['medidor']).'</td>
              <td>'.($direccion['localidad'].' / '.$direccion['zona'].' / '.$direccion['calle']).'</td>
              <td>'.($value['descripcion']).'</td>
              <td> <a id="btn_editar" class="button-small pure-button pure-button-primary" href="javascript:cargar_kardex('.$value['idabonado'].')">Seleccionar</button></td>
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

  public function ver_kardex(){
   
      $abonado = $this->abonados_model->get_abonado($this->input->get('idabonado'));
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);

      $abonados = $this->abonados_model->get_abonos_cliente($abonado['idcliente']);
      $lecturas = $this->lecturas_model->get_lecturas_abonado_servicio($abonado['idabonado'], $abonado['idservicio'], );

      $data['cliente'] = $cliente;
      $data['abonado'] = $abonado;
      $data['abonados'] = $abonados;
      $data['lecturas'] = $lecturas;
      $this->load->view('fact/cobranza/ver_kardex_view', $data);
    
  }

  public function pagar_lectura(){
    
      $lectura = $this->lecturas_model->get_lectura($this->input->get('idlectura'));
      $lecturas_abonado = $this->lecturas_model->get_lecturas_abonado($lectura['idabonado']);
      if(!is_null($lecturas_abonado))
        if($lecturas_abonado[0]['idperiodo']==$lectura['idperiodo']){
          $data_lectura['estado'] = '1';
          $data_lectura['pago'] = date('Y-m-d H:i:s');
          $data_lectura['cobrador'] = $this->session->userdata('user_id');
          $this->lecturas_model->actualizar($this->input->get('idlectura'), $data_lectura);
          echo 'ok';
        }
        else 
          echo 'err';
    
  }

  public function impresion_factura($idlectura){
    
      
      $this->load->library('ciqrcode');
      $lectura = $this->lecturas_model->get_lectura($idlectura);

      if(!is_null($lectura) && ($lectura['estado']=='1')){
        //Extraccion de datos
        $configuracion = $this->configuracion_model->get_all();
        if(is_null($configuracion)){
          $configuracion['logo_linea1'] = 'MI EMPRESA';
          $configuracion['logo_linea2'] = 'MI SLOGAN';
          $configuracion['direccion'] = 'AV. SIEMPRE VIVA NRO. 16, SANTA CRUZ - BOLIVIA';
          $configuracion['telefono'] = '';
          $configuracion['whatsapp'] = '';
          $configuracion['pie_impresion'] = 'GRACIAS POR SU PREFERENCIA.';
        }
        $factura = $this->facturas_model->get_factura_lectura($lectura['idlectura']);
        
        if(is_null($factura))
          echo 'Factura no disponible';
        else{
          $autorizacion = $this->autorizaciones_model->get_autorizacion($factura['idautorizacion']);
          $abonado = $this->abonados_model->get_abonado($lectura['idabonado']);
          $direccion_abonado = $this->calles_model->get_all_all($abonado['idcalle']);
          $periodo = $this->periodos_model->get_periodo($lectura['idperiodo']);
          $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
  
          $data['lectura'] = $lectura;
          $data['factura'] = $factura;
          $data['direccion_abonado'] = $direccion_abonado;
          $data['periodo'] = $periodo;
          $data['autorizacion'] = $autorizacion;
          $data['configuracion'] = $configuracion;
          $data['abonado'] = $abonado;
          $data['cliente'] = $cliente;
          $data['title'] = 'Factura';
          if($lectura['idservicio']=='1')
            $this->load->view('fact/cobranza/impresion_factura_view', $data); 
          elseif($lectura['idservicio']=='2')
            $this->load->view('fact/cobranza/impresion_factura_tv_view', $data); 
        }
      }else{
        echo 'No existe información';
      }
    
  }

  
}//fin class
