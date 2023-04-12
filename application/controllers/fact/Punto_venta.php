<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Punto_venta extends CI_Controller
{
  public function __construct() {
    parent::__construct();
    $this->load->model('fact/cuis_model');
    $this->load->model('fact/punto_venta_model');
    $this->load->model('fact/parametrica_tipo_punto_venta_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function index(){
    
      $puntos=$this->punto_venta_model->get_all();
      $data['puntos'] = $puntos;
      $data['main_content'] = 'fact/punto_venta/index_view';
      $data['title'] = 'Puntos de venta';
      $content = $this->parser->parse('fact/punto_venta/index_view', $data, true);
    $this->template->full_admin_html_view($content);
    
  }

  public function nuevo_punto_venta($id_punto_venta=null){
   
      if(is_null($id_punto_venta)){
        $data['main_content'] = 'fact/punto_venta/nuevo_punto_venta_view';
        $data['title'] = 'Nuevo punto de venta';
        $content = $this->parser->parse('fact/punto_venta/nuevo_punto_venta_view', $data, true);
    $this->template->full_admin_html_view($content);
      }else{
        $data['pv'] = $this->punto_venta_model->get_punto_venta($id_punto_venta);
        $data['main_content'] = 'fact/punto_venta/nuevo_punto_data_venta_view';
        $data['title'] = 'Editar punto de venta';
        $content = $this->parser->parse('fact/punto_venta/nuevo_punto_data_venta_view', $data, true);
    $this->template->full_admin_html_view($content);
      }

       
   
  }

  public function guardar_punto_venta($cuis=null){
   
      $wsdl = $this->config->item('endPoint_FacturacionOperaciones');
      $token = $this->config->item('token');
      $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
      $context = stream_context_create($opts);
      $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
      
      $parametros = array(
          'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
          'codigoModalidad' => $this->config->item('codigoModalidad'),
          'codigoSistema' => $this->config->item('codigoSistema'),
          'codigoSucursal' => $this->input->post('codigo_sucursal'),
          'codigoTipoPuntoVenta' => $this->input->post('codigo_tipo_punto_venta'),
          'cuis' => $cuis,
          'descripcion' => mb_strtoupper(trim($this->input->post('descripcion'))),
          'nit' => $this->config->item('nit'),
          'nombrePuntoVenta' => mb_strtoupper(trim($this->input->post('nombre_punto_venta')))
          );
      $metodo = array('SolicitudRegistroPuntoVenta'=> $parametros);
      
      $resultado = $client->__soapCall('registroPuntoVenta', array($metodo));
      //var_dump($resultado);
      
      if($resultado->RespuestaRegistroPuntoVenta->transaccion){
        //insertar en tabla punto_venta
        $id_punto_venta = $this->punto_venta_model->current_num();
        $data['id_punto_venta']=$id_punto_venta;
        $data['codigo_sucursal']=$this->input->post('codigo_sucursal');
        $data['codigo_punto_venta']=$resultado->RespuestaRegistroPuntoVenta->codigoPuntoVenta;
        $data['codigo_tipo_punto_venta']=$this->input->post('codigo_tipo_punto_venta');
        $data['descripcion_punto_venta']=mb_strtoupper(trim($this->input->post('descripcion_punto_venta')));
        $data['nombre_punto_venta']=mb_strtoupper(trim($this->input->post('nombre_punto_venta')));
        $this->punto_venta_model->insertar($data);
        echo 'ok';
        }
        elseif($resultado->RespuestaRegistroPuntoVenta->transaccion == false){
          echo 'ERROR: EL PARAMETRO TIPO DE PUNTO DE VENTA ES INVALIDO';
          var_dump($resultado->RespuestaRegistroPuntoVenta);
        }else{
          echo 'Error desconocido';
        }
    
  }

  public function solicitar_cuis_punto_venta($id_punto_venta=null){
    
      $data['pv'] = $this->punto_venta_model->get_punto_venta($id_punto_venta);
      $data['main_content'] = 'fact/punto_venta/solicitar_cuis_punto_venta_view';
      $data['title'] = 'Solicitud de CUIS';
      $content = $this->parser->parse('fact/punto_venta/solicitar_cuis_punto_venta_view', $data, true);
    $this->template->full_admin_html_view($content);
    

  }

  public function obtener_cuis($id_punto_venta){
  

      $wsdl = $this->config->item('endPoint_FacturacionCodigos');
      $token = $this->config->item('token');
      $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
      $context = stream_context_create($opts);
      $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
      
      $parametros = array(
          'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
          'codigoModalidad' => $this->config->item('codigoModalidad'),
          'codigoPuntoVenta' => $this->input->post('codigo_punto_venta'),
          'codigoSistema' => $this->config->item('codigoSistema'),
          'codigoSucursal' => $this->input->post('codigo_sucursal'),
          'nit' => $this->config->item('nit')
          );
      $metodo = array('SolicitudCuis'=> $parametros);
      
      $resultado = $client->__soapCall('cuis', array($metodo));
      
      if($resultado->RespuestaCuis->transaccion){
        $id_cuis = $this->cuis_model->current_num();
        $data['id_cuis'] = $id_cuis;
        $data['cuis_codigo'] = $resultado->RespuestaCuis->codigo;
        $data['cuis_fecha_vigencia'] = $resultado->RespuestaCuis->fechaVigencia;
        $data['id_punto_venta'] = $id_punto_venta;
        $this->cuis_model->insertar($data);
        echo 'ok';
        }
        elseif($resultado->RespuestaCuis->transaccion == false){
          echo 'ERROR: El cuis quiza ya este asignado al punto de venta o sucursal';
          var_dump($resultado->RespuestaCuis);
        }else{
          echo 'Error al solicitar el cuis, posiblemente los datos no son correctos.';
        }

    
  }

}//fin class
