<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestion_factura extends CI_Controller{

  
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
      $this->load->model('fact/factura_13_model');
      $this->load->model('fact/factura_22_model');
      $this->load->model('fact/factura_model');
      if (!$this->auth->is_logged()) {
        $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
      }
      $this->auth->check_admin_auth();
  
    }
  public function index(){
   
      $data['main_content'] = 'fact/gestion_factura/index_view';
      $data['title'] = 'gestion_factura';
      $content = $this->parser->parse('fact/gestion_factura/index_view', $data, true);
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
        $resultado = $this->cliente_model->buscar_app_nom_venta($apellidos, $nombres);
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
              <th></th>
            </tr>
          </thead>
          <tbody>';
          foreach ($resultado as $key => $value) {
            if(isset($value['idcalle'])){
              $direccion = $this->calles_model->get_all_all($value['idcalle']);
              $salida.='
              <tr>
                <td>'.($value['abonado']).'</td>
                <td>'.($value['razon_social']).'</td>
                <td>'.($value['medidor']).'</td>
                <td>'.($direccion['localidad'].' / '.$direccion['zona'].' / '.$direccion['calle']).'</td>
                <td> <a id="btn_editar" class="button-small pure-button pure-button-primary" href="'.base_url().'fact/gestion_factura/mostrar_factura/'.$value['idcliente'].'">Seleccionar</button></td>
              </tr>';
            }else{
              $salida.='
              <tr>
                <td></td>
                <td>'.($value['razon_social']).'</td>
                <td></td>
                <td></td>
                <td> <a id="btn_editar" class="button-small pure-button pure-button-primary" href="'.base_url().'fact/gestion_factura/mostrar_factura/'.$value['idcliente'].'">Seleccionar</button></td>
              </tr>';
            }

          }// fin for
          $salida.='</tbody>
        </table>        
        ';
        echo $salida;
      }else{
        echo 'Debe indroducir algún criterio de busqueda';
      }
    
  }

  public function mostrar_factura($idcliente){
    
      $facturas_13 = $this->factura_13_model->get_fact_idcliente($idcliente);
      $facturas_22 = $this->factura_22_model->get_fact_idcliente($idcliente);
      $facturas = $this->factura_model->get_fact_idcliente($idcliente);
      //var_dump($facturas);
      $cliente = $this->cliente_model->get_cliente($idcliente);
      $data['cliente'] = $cliente;
      $data['facturas_13'] = $facturas_13;
      $data['facturas_22'] = $facturas_22;
      $data['facturas'] = $facturas;
      $data['main_content'] = 'fact/gestion_factura/mostrar_factura_view';
      $data['title'] = 'gestion_factura';
      $content = $this->parser->parse('fact/gestion_factura/mostrar_factura_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  public function impresion_factura($idlectura, $sector){/////////////////////////////////SOLO NUEVAS FACTURAS
    
      
      $this->load->library('ciqrcode');
      if($sector != 1)
        $lectura = $this->lecturas_model->get_lectura($idlectura);
      else ///// lectura ahora es factura
        $lectura = $this->factura_model->get_factura($idlectura);
      
      //var_dump($lectura);

      if(!is_null($lectura) ){///////////////////////////////// && ($lectura['estado']=='1')
        $configuracion = $this->configuracion_model->get_all();
        if(is_null($configuracion)){
          $configuracion['logo_linea1'] = 'MI EMPRESA';
          $configuracion['logo_linea2'] = 'MI SLOGAN';
          $configuracion['direccion'] = 'AV. SIEMPRE VIVA NRO. 16, SANTA CRUZ - BOLIVIA';
          $configuracion['telefono'] = '';
          $configuracion['whatsapp'] = '';
          $configuracion['pie_impresion'] = 'GRACIAS POR SU PREFERENCIA.';
        }
        if($sector == 13){
          $factura = $this->factura_13_model->get_factura_lectura($idlectura);
        }else if($sector == 22){
          $factura = $this->factura_22_model->get_factura_lectura($idlectura);
        }else{
          $factura = $this->factura_model->get_factura($idlectura);
        }
        
        if(is_null($factura))
          echo 'Factura no disponible';
        else{
          if($sector != 1){////////////solo si es 13 o 22
            $abonado = $this->abonados_model->get_abonado($lectura['idabonado']);
            $direccion_abonado = $this->calles_model->get_all_all($abonado['idcalle']);
            $periodo = $this->periodos_model->get_periodo($lectura['idperiodo']);
            $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
            $data['lectura'] = $lectura;
            $data['factura'] = $factura;
            $data['direccion_abonado'] = $direccion_abonado;
            $data['periodo'] = $periodo;
            $data['configuracion'] = $configuracion;
            $data['abonado'] = $abonado;
            $data['cliente'] = $cliente;
            $data['title'] = 'Factura';  
          }

          if($sector==1)
            redirect(base_url().'fact/venta/impresion_constancia/'.$lectura['id_orden']);// sector 1
          elseif($sector==13)
            $this->load->view('fact/gestion_factura/impresion_factura_13_view', $data); // sector 13
          else
            $this->load->view('fact/gestion_factura/impresion_factura_tv_view', $data); // sector 22
        }
      }else{
        echo 'No existe información';
      }
    
  }

  public function enviar_factura($idlectura, $sector){///////////////////////////////// ENVIAR FACTURAS
    
      if($sector != 1){
        $lectura = $this->lecturas_model->get_lectura($idlectura);
        $abonado = $this->abonados_model->get_abonado($lectura['idabonado']);
        $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);  
      }
      else{
        $factura = $this->factura_model->get_factura($idlectura);//idlectura es idfactura
        $cliente = $this->cliente_model->get_cliente($factura['idcliente']);//idlectura es idfactura
      }

        if($sector == 13){
          $factura = $this->factura_13_model->get_factura_lectura($idlectura);
        }else if($sector == 22){
          $factura = $this->factura_22_model->get_factura_lectura($idlectura);
        }

      $this->load->library('email');
      $this->email->clear(TRUE);
      $config['protocol'] = 'smtp';
      $config["smtp_host"] = $this->config->item('smtp_host');
      $config["smtp_user"] = $this->config->item('smtp_user');
      $config["smtp_pass"] = $this->config->item('smtp_pass');
      $config["smtp_port"] = $this->config->item('smtp_port');
      $config["mailtype"] = 'html';
      $config['charset'] = 'utf-8';
      $config['wordwrap'] = true;
      $config['validate'] = true;
      $config['newline'] = "\r\n";

      $this->email->initialize($config);
      $this->email->from($this->config->item('smtp_user'), $this->config->item('razonSocial'));
      $this->email->to($cliente['correo']);
      $this->email->subject($this->config->item('razonSocial').' Factura consumo electrico ');
      $this->email->message('
      <p>
        Puede imprimir o descargar <a target="_blank" href="'.$this->config->item('url_qr').'nit='.$this->config->item('nit').'&cuf='.$factura['cuf'].'&numero='.$factura['nro_fact'].' ">aquí</a>
      </p> 
      ');//$array_nro_fact_correo
      
      if($sector == 13){
        $this->email->attach(getcwd().'/facturas_13/'.$factura['idlectura'].'_'.$factura['cuf'].'.pdf');
        $this->email->attach(getcwd().'/facturas_13/'.$factura['idlectura'].'_firmado.xml');
      }elseif($sector == 22){
        $this->email->attach(getcwd().'/facturas_22/'.$factura['idlectura'].'_'.$factura['cuf'].'.pdf');
        $this->email->attach(getcwd().'/facturas_22/'.$factura['idlectura'].'_firmado.xml');
      }else{
        $this->email->attach(getcwd().'/facturas_1/'.$factura['id_orden'].'_'.$factura['cuf'].'.pdf');
        $this->email->attach(getcwd().'/facturas_1/'.$factura['id_orden'].'_'.$factura['cuf'].'_firmado.xml');
      }

      $this->email->send();
      echo 'Factura enviada a: '.$cliente['correo'].' correctamente. <a href="javascript:window.close();">Cerrar ventana</a>';
   
  }//fin funcion

  public function anular($idlectura, $sector){///////////////////////////////// ANULA FACTURAS VISTA
    
      $lectura = $this->lecturas_model->get_lectura($idlectura);
      $abonado = $this->abonados_model->get_abonado($lectura['idabonado']);
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);

        if($sector == '13'){
          $factura = $this->factura_13_model->get_factura_lectura($idlectura);
        }else if($sector == '22'){
          $factura = $this->factura_22_model->get_factura_lectura($idlectura);
        }else{
          $factura = $this->factura_model->get_factura($idlectura);
        }

      $data['idlectura'] = $idlectura;
      $data['sector'] = $sector;

      $data['cliente'] = $cliente;
      $data['factura'] = $factura;

      $data['doc_sec'] = $doc_sec = $this->parametrica_tipo_documento_sector_model->get_all();
      $data['motivos'] = $motivos = $this->parametrica_motivo_anulacion_model->get_all();
      $data['main_content'] = 'fact/gestion_factura/anular_view';
      $data['title'] = 'Anular factura';
      $content = $this->parser->parse('fact/gestion_factura/anular_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }//fin funcion  
  
  public function anular_fact($cuf, $sector){///////////////////////////////// ANULA FACTURAS VISTA
    

      $empleado = $this->empleado_model->get_empleado($this->session->userdata('id_empleado'));
      $pv = $this->punto_venta_model->get_punto_venta($empleado['id_punto_venta']);
      $factura = NULL;
      
      if($sector == '13'){
        $factura = $this->factura_13_model->get_factura_cuf($cuf);
      }else if($sector == '22'){
        $factura = $this->factura_22_model->get_factura_cuf($cuf);
      }else{
        $factura = $this->factura_model->get_factura_cuf($cuf);
      }
      
      $doc_sec = $this->parametrica_tipo_documento_sector_model->get_parametrica_tipo_documento_sector($this->input->post('id_parametrica_tipo_documento_sector'));
      $motivo = $this->parametrica_motivo_anulacion_model->get_parametrica_motivo_anulacion($this->input->post('id_parametrica_motivo_anulacion'));
      
      switch ($sector) {
        case '1': $wsdl = $this->config->item('ServicioFacturacionCompraVenta'); break;
        case '13': $wsdl = $this->config->item('endPoint_FacturaServiciosBasicos'); break;
        case '22': $wsdl = $this->config->item('endPoint_FacturaTelecomunicaciones'); break;          
      }
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoDocumentoSector' => $doc_sec['codigo_clasificador'], 
            'codigoEmision' => '1', 
            'codigoModalidad' => $this->config->item('codigoModalidad'),
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cufd' => $factura['cufd'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit'),
            'tipoFacturaDocumento' => '1', 
            
            'codigoMotivo' => $motivo['codigo_clasificador'], 
            'cuf' => $factura['cuf']
            );
        $metodo = array('SolicitudServicioAnulacionFactura'=> $parametros);
        $resultado = $client->__soapCall('anulacionFactura', array($metodo));

        if($resultado->RespuestaServicioFacturacion->transaccion){
          $salida = true;
          $data_fact['estado_fact']='A';
          if($sector == '13'){
            $this->factura_13_model->actualizar_cuf($cuf, $data_fact); 
          }else if($sector == '22'){
            $this->factura_22_model->actualizar_cuf($cuf, $data_fact);
          }else{
            $this->factura_model->actualizar_cuf($cuf, $data_fact);
          }
        $cliente=$this->cliente_model->get_cliente($factura['idcliente']) ;
          //EMAIL
          if(!is_null($cliente['correo'])){
            $this->load->library('email');
            $this->email->clear(TRUE);
            $config['protocol'] = 'smtp';
            $config["smtp_host"] = $this->config->item('smtp_host');
            $config["smtp_user"] = $this->config->item('smtp_user');
            $config["smtp_pass"] = $this->config->item('smtp_pass');
            $config["smtp_port"] = $this->config->item('smtp_port');
            $config["mailtype"] = 'html';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = true;
            $config['validate'] = true;
            $config['newline'] = "\r\n";
            $this->email->clear(TRUE);
            $this->email->initialize($config);
            $this->email->from($this->config->item('smtp_user'), $this->config->item('razonSocial'));
            $this->email->to($cliente['correo']);
            //$this->email->subject($this->config->item('razonSocial').' Factura consumo  '.$periodo_act['emision']);
            $this->email->subject($this->config->item('razonSocial').' Factura Nro. '.$factura['nro_fact'].' ANALUADA');

            $this->email->message('
            <p>
              Le comunicamos que la Factura Nro.'.$factura['nro_fact'].' con Cód. Autorización: '.$factura['cuf'].' fue ANULADA.
            </p> 
            ');
  
            // $this->email->attach(getcwd().'/facturas_22/'.$factura['idlectura'].'_'.$factura['cuf'].'.pdf');
            // $this->email->attach(getcwd().'/facturas_22/'.$factura['idlectura'].'_firmado.xml');
            $this->email->send();
          }

          redirect(base_url().'fact/gestion_factura/mostrar_factura/'.$factura['idcliente']);
        }
        elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
          $salida = false;
          echo 'ERROR: FALSE';
          var_dump($resultado->RespuestaServicioFacturacion);
        }else{
          $salida = false;
          echo 'Error desconocido.';
        }

    
  }//fin funcion  
  
}//fin class
