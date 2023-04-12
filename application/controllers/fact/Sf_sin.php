<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sf_sin extends CI_Controller
{
  public function index(){
    if(isAdmin()){
      $data['main_content'] = 'sf_sin/index_view';
      $data['title'] = 'SF SIN';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sinc_actividades(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_actividades_view';
      $data['title'] = 'Sincronizar actividades';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_actividades(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else 
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarActividades', array($metodo));
        
        if($resultado->RespuestaListaActividades->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaActividades=array();
              $listaActividades=$resultado->RespuestaListaActividades->listaActividades;
    
              foreach ($listaActividades as $key => $value) {
                $data['codigo_caeb'] = $value->codigoCaeb;
                $data['descripcion'] = $value->descripcion;
                $data['tipo_actividad'] = $value->tipoActividad;
                $busqueda_caeb = $this->actividad_model->buscar_codigo_caeb($value->codigoCaeb);
                if(is_null($busqueda_caeb))
                  $this->actividad_model->insertar($data);
              }
            }
            $salida = true;
            
          }
          elseif($resultado->RespuestaListaActividades->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaActividades);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_fecha_hr(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_fecha_hr_view';
      $data['title'] = 'Sincronizar feha y hora';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_fecha_hr(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else 
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarFechaHora', array($metodo));
        
        if($resultado->RespuestaFechaHora->transaccion){
              $salida = true;
          }
          elseif($resultado->RespuestaFechaHora->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaFechaHora);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while

      if($salida)
        echo $nro_peticiones.' Sincronización existosa: '.(date('Y-m-d H:i:s'));
      
    }
    else
      redirect(base_url());
  }

  public function sinc_ListaActividadesDocumentoSector(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_ListaActividadesDocumentoSector_view';
      $data['title'] = 'Sincronizar Lista Actividades Documento Sector';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_ListaActividadesDocumentoSector(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarListaActividadesDocumentoSector', array($metodo));
        
        if($resultado->RespuestaListaActividadesDocumentoSector->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaActividadesDocumentoSector=array();
              $listaActividadesDocumentoSector=$resultado->RespuestaListaActividadesDocumentoSector->listaActividadesDocumentoSector;
              
    
              foreach ($listaActividadesDocumentoSector as $key => $value) {
                $data['codigo_actividad'] = $value->codigoActividad;
                $data['codigo_documento_sector'] = $value->codigoDocumentoSector;
                $data['tipo_documento_sector'] = $value->tipoDocumentoSector;
                $busqueda_codigo_documento_sector = $this->documento_sector_model->buscar_codigo_documento_sector($value->codigoActividad, $value->codigoDocumentoSector);
                if(is_null($busqueda_codigo_documento_sector))
                  $this->documento_sector_model->insertar($data);
              }
            }
            $salida = true;
            
          }
          elseif($resultado->RespuestaListaActividadesDocumentoSector->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaActividadesDocumentoSector);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_ListaLeyendasFactura(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_ListaLeyendasFactura_view';
      $data['title'] = 'Sincronizar lista de leyendas de factura';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_ListaLeyendasFactura(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarListaLeyendasFactura', array($metodo));
        
        if($resultado->RespuestaListaParametricasLeyendas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaLeyendas=array();
              $listaLeyendas=$resultado->RespuestaListaParametricasLeyendas->listaLeyendas;
              
              foreach ($listaLeyendas as $key => $value) {
                $data['codigo_actividad'] = $value->codigoActividad;
                $data['descripcion_leyenda'] = $value->descripcionLeyenda;
                $busqueda_leyenda_factura = $this->leyenda_factura_model->buscar_codigo_leyenda_factura($value->codigoActividad, $value->descripcionLeyenda);
                if(is_null($busqueda_leyenda_factura))
                  $this->leyenda_factura_model->insertar($data);
              }
            }
            $salida = true;
            
          }
          elseif($resultado->RespuestaListaParametricasLeyendas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricasLeyendas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }
  
  public function sinc_ListaMensajesServicios(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_ListaMensajesServicios_view';
      $data['title'] = 'Sincronizar lista de mensajes de servicios';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_ListaMensajesServicios(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarListaMensajesServicios', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_mensaje_servicio = $this->mensaje_servicio_model->buscar_codigo_mensaje_servicio($value->codigoClasificador);
                if(is_null($busqueda_mensaje_servicio))
                  $this->mensaje_servicio_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_ListaProductosServicios(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_ListaProductosServicios_view';
      $data['title'] = 'Sincronizar lista de productos y servicios';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_ListaProductosServicios(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarListaProductosServicios', array($metodo));
        
        if($resultado->RespuestaListaProductos->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaProductos->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_actividad'] = $value->codigoActividad;
                $data['codigo_producto'] = $value->codigoProducto;
                $data['descripcion_producto'] = $value->descripcionProducto;
                $busqueda_producto_servicio = $this->producto_servicio_model->buscar_codigo_producto_servicio($value->codigoActividad, $value->codigoProducto, $value->descripcionProducto);
                if(is_null($busqueda_producto_servicio))
                  $this->producto_servicio_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaProductos->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaProductos);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_ParametricaEventosSignificativos(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_ParametricaEventosSignificativos_view';
      $data['title'] = 'Sincronizar parametricas eventos significativos';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_ParametricaEventosSignificativos(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaEventosSignificativos', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_evento_significativo = $this->parametrica_evento_significativo_model->buscar_codigo_parametrica_evento_significativo($value->codigoClasificador);
                if(is_null($busqueda_parametrica_evento_significativo))
                  $this->parametrica_evento_significativo_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_ParametricaMotivoAnulacion(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_ParametricaMotivoAnulacion_view';
      $data['title'] = 'Sincronizar parametricas motivos de anulación';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_ParametricaMotivoAnulacion(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaMotivoAnulacion', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_motivo_anulacion = $this->parametrica_motivo_anulacion_model->buscar_codigo_parametrica_motivo_anulacion($value->codigoClasificador);
                if(is_null($busqueda_parametrica_motivo_anulacion))
                  $this->parametrica_motivo_anulacion_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_ParametricaPaisOrigen(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_ParametricaPaisOrigen_view';
      $data['title'] = 'Sincronizar parametricas país de origen';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_ParametricaPaisOrigen(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaPaisOrigen', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_pais_origen = $this->parametrica_pais_origen_model->buscar_codigo_parametrica_pais_origen($value->codigoClasificador);
                if(is_null($busqueda_parametrica_pais_origen))
                  $this->parametrica_pais_origen_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_TipoDocumentoIdentidad(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_TipoDocumentoIdentidad_view';
      $data['title'] = 'Sincronizar parametricas país de origen';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_TipoDocumentoIdentidad(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaTipoDocumentoIdentidad', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_tipo_documento_identidad = $this->parametrica_tipo_documento_identidad_model->buscar_codigo_parametrica_tipo_documento_identidad($value->codigoClasificador);
                if(is_null($busqueda_parametrica_tipo_documento_identidad))
                  $this->parametrica_tipo_documento_identidad_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_TipoDocumentoSector(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_TipoDocumentoSector_view';
      $data['title'] = 'Sincronizar parametricas tipo documento sector';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_TipoDocumentoSector(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaTipoDocumentoSector', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_tipo_documento_sector = $this->parametrica_tipo_documento_sector_model->buscar_codigo_parametrica_tipo_documento_sector($value->codigoClasificador);
                if(is_null($busqueda_parametrica_tipo_documento_sector))
                  $this->parametrica_tipo_documento_sector_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_TipoEmision(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_TipoEmision_view';
      $data['title'] = 'Sincronizar tipo emisión';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_TipoEmision(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaTipoEmision', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_tipo_emision = $this->parametrica_tipo_emision_model->buscar_codigo_parametrica_tipo_emision($value->codigoClasificador);
                if(is_null($busqueda_parametrica_tipo_emision))
                  $this->parametrica_tipo_emision_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_TipoHabitacion(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_TipoHabitacion_view';
      $data['title'] = 'Sincronizar tipo habitación';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_TipoHabitacion(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaTipoHabitacion', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_tipo_habitacion = $this->parametrica_tipo_habitacion_model->buscar_codigo_parametrica_tipo_habitacion($value->codigoClasificador);
                if(is_null($busqueda_parametrica_tipo_habitacion))
                  $this->parametrica_tipo_habitacion_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_TipoMetodoPago(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_TipoMetodoPago_view';
      $data['title'] = 'Sincronizar tipo método de pago';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_TipoMetodoPago(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaTipoMetodoPago', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_tipo_metodo_pago = $this->parametrica_tipo_metodo_pago_model->buscar_codigo_parametrica_tipo_metodo_pago($value->codigoClasificador);
                if(is_null($busqueda_parametrica_tipo_metodo_pago))
                  $this->parametrica_tipo_metodo_pago_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_TipoMoneda(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_TipoMoneda_view';
      $data['title'] = 'Sincronizar tipo moneda';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_TipoMoneda(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaTipoMoneda', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_tipo_moneda = $this->parametrica_tipo_moneda_model->buscar_codigo_parametrica_tipo_moneda($value->codigoClasificador);
                if(is_null($busqueda_parametrica_tipo_moneda))
                  $this->parametrica_tipo_moneda_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_TipoPuntoVenta(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_TipoPuntoVenta_view';
      $data['title'] = 'Sincronizar tipo punto de venta';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_TipoPuntoVenta(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaTipoPuntoVenta', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_tipo_punto_venta = $this->parametrica_tipo_punto_venta_model->buscar_codigo_parametrica_tipo_punto_venta($value->codigoClasificador);
                if(is_null($busqueda_parametrica_tipo_punto_venta))
                  $this->parametrica_tipo_punto_venta_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_TipoFactura(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_TipoFactura_view';
      $data['title'] = 'Sincronizar tipos de factura';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_TipoFactura(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaTiposFactura', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_tipo_factura = $this->parametrica_tipo_factura_model->buscar_codigo_parametrica_tipo_factura($value->codigoClasificador);
                if(is_null($busqueda_parametrica_tipo_factura))
                  $this->parametrica_tipo_factura_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  public function sinc_UnidadMedida(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/sinc_UnidadMedida_view';
      $data['title'] = 'Sincronizar unidad medida';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function sincronizar_UnidadMedida(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionSincronizacion');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudSincronizacion'=> $parametros);
        
        $resultado = $client->__soapCall('sincronizarParametricaUnidadMedida', array($metodo));
        
        if($resultado->RespuestaListaParametricas->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              $listaCodigos=array();
              $listaCodigos=$resultado->RespuestaListaParametricas->listaCodigos;
              
              foreach ($listaCodigos as $key => $value) {
                $data['codigo_clasificador'] = $value->codigoClasificador;
                $data['descripcion'] = $value->descripcion;
                $busqueda_parametrica_unidad_medida = $this->parametrica_unidad_medida_model->buscar_codigo_parametrica_unidad_medida($value->codigoClasificador);
                if(is_null($busqueda_parametrica_unidad_medida))
                  $this->parametrica_unidad_medida_model->insertar($data);
              }
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaParametricas->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaParametricas);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' Sincronización(es) existosa(s).';            
    }
    else
      redirect(base_url());
  }

  /* CUFD */
  public function cufd(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['main_content'] = 'sf_sin/cufd_view';
      $data['title'] = 'Obtener CUFD';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function obtener_cufd(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionCodigos');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoModalidad' => $this->config->item('codigoModalidad'), 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudCufd'=> $parametros);
        
        $resultado = $client->__soapCall('cufd', array($metodo));
        
        if($resultado->RespuestaCufd->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){              
                $data['codigo'] = $resultado->RespuestaCufd->codigo;
                $data['codigo_control'] = $resultado->RespuestaCufd->codigoControl;
                $data['direccion'] = $resultado->RespuestaCufd->direccion;
                $data['fecha_vigencia'] = $resultado->RespuestaCufd->fechaVigencia;
                $data['id_punto_venta'] = $pv['id_punto_venta'];

                $busqueda_codigo_cufd = $this->cufd_model->buscar_codigo_cufd($resultado->RespuestaCufd->codigo);
                if(is_null($busqueda_codigo_cufd))
                  $this->cufd_model->insertar($data);
            }
            $salida = true;
          }
          elseif($resultado->RespuestaCufd->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaCufd);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' CUFD(s) existosa(s).';
    }
    else
      redirect(base_url());
  }

  /* PARA CONSUMO DE FACTURA INDIVIDUAL*/
  public function genera_fac_xml(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;

      $data['main_content'] = 'sf_sin/genera_fac_xml_view';
      $data['title'] = 'Factura indivicual';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function generar_factura_xml(){//compra venta
    if(isAdmin()){

      //recepción de post    
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));

      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $xml = new DomDocument('1.0', 'UTF-8');
        $xml->xmlStandalone = true;
        $facturaElectronicaCompraVenta = $xml->createElement('facturaElectronicaCompraVenta');
        $facturaElectronicaCompraVenta = $xml->appendChild($facturaElectronicaCompraVenta);
        $facturaElectronicaCompraVenta->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $facturaElectronicaCompraVenta->setAttribute('xsi:noNamespaceSchemaLocation', 'facturaElectronicaCompraVenta.xsd');
        
        $cabecera = $xml->createElement('cabecera');
        $cabecera = $facturaElectronicaCompraVenta->appendChild($cabecera);
              
        $nitEmisor = $xml->createElement('nitEmisor',$this->config->item('nit'));
        $nitEmisor = $cabecera->appendChild($nitEmisor);
        
        $razonSocialEmisor = $xml->createElement('razonSocialEmisor',$this->config->item('razonSocial'));
        $razonSocialEmisor = $cabecera->appendChild($razonSocialEmisor);
        
        $municipio = $xml->createElement('municipio',$this->config->item('municipio'));
        $municipio = $cabecera->appendChild($municipio);
        
        $telefono = $xml->createElement('telefono',$this->config->item('telefono'));
        $telefono = $cabecera->appendChild($telefono);
        
        $nro_factura=1;//Extraer nro factura
        $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
        $numeroFactura = $cabecera->appendChild($numeroFactura);
        
        //para el CUF
        $tipo_emision = 1;
        $tipo_factura = 1;
        $tipo_doc_sector = 1;
        
        $res_concat = concatenar_ceros($this->config->item('nit'), date("YmdHisv"),$pv['codigo_sucursal'],$this->config->item('codigoModalidad'),$tipo_emision,$tipo_factura,$tipo_doc_sector,$nro_factura,$pv['codigo_punto_venta']);
        $res_m_11 = mod_11($res_concat,1,9,false);
        $res_str_16 = strtoupper(str_16($res_concat.$res_m_11));
        $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
    
        $cuf = $xml->createElement('cuf',$res_str_16.$cuf_act['codigo_control']);
        $cuf = $cabecera->appendChild($cuf);
        //Fin CUF
        
        $cufd = $xml->createElement('cufd',$cuf_act['codigo']);
        $cufd = $cabecera->appendChild($cufd);
        
        $codigoSucursal = $xml->createElement('codigoSucursal',$pv['codigo_sucursal']);
        $codigoSucursal = $cabecera->appendChild($codigoSucursal);
        
        $direccion = $xml->createElement('direccion',$this->config->item('direccion'));
        $direccion = $cabecera->appendChild($direccion);
        
        $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta',$pv['codigo_punto_venta']);
        $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);

        $fechaEmision = $xml->createElement('fechaEmision',date("Y-m-d\TH:i:s.v"));
        $fechaEmision = $cabecera->appendChild($fechaEmision);

        $razon_social_cliente = 'Carmelo Molina';
        $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
        $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);

        $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad','1');
        $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);

        $nro_doc_cliente=4043274;
        $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc_cliente);
        $numeroDocumento = $cabecera->appendChild($numeroDocumento);

        $complemento = $xml->createElement('complemento');//element vacio
        $complemento = $cabecera->appendChild($complemento);
        $complemento->setAttribute('xsi:nil', 'true');

        $codigoCliente = $xml->createElement('codigoCliente','51158891');
        $codigoCliente = $cabecera->appendChild($codigoCliente);

        $codigoMetodoPago = $xml->createElement('codigoMetodoPago','1');
        $codigoMetodoPago = $cabecera->appendChild($codigoMetodoPago);

        $numeroTarjeta = $xml->createElement('numeroTarjeta');//element vacio
        $numeroTarjeta = $cabecera->appendChild($numeroTarjeta);
        $numeroTarjeta->setAttribute('xsi:nil', 'true');

        $montoTotal = $xml->createElement('montoTotal','99');
        $montoTotal = $cabecera->appendChild($montoTotal);

        $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva','99');
        $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);

        $codigoMoneda = $xml->createElement('codigoMoneda','1');
        $codigoMoneda = $cabecera->appendChild($codigoMoneda);

        $tipoCambio = $xml->createElement('tipoCambio','1');
        $tipoCambio = $cabecera->appendChild($tipoCambio);

        $montoTotalMoneda = $xml->createElement('montoTotalMoneda','99');
        $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);

        $montoGiftCard = $xml->createElement('montoGiftCard');//element vacio
        $montoGiftCard = $cabecera->appendChild($montoGiftCard);
        $montoGiftCard->setAttribute('xsi:nil', 'true');

        $descuentoAdicional = $xml->createElement('descuentoAdicional','1');
        $descuentoAdicional = $cabecera->appendChild($descuentoAdicional);

        $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
        $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
        $codigoExcepcion->setAttribute('xsi:nil', 'true');

        $cafc = $xml->createElement('cafc');//element vacio
        $cafc = $cabecera->appendChild($cafc);
        $cafc->setAttribute('xsi:nil', 'true');

        $leyenda = $xml->createElement('leyenda','Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.');
        $leyenda = $cabecera->appendChild($leyenda);

        $usuario = $xml->createElement('usuario','pperez');
        $usuario = $cabecera->appendChild($usuario);

        $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','1');
        $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);

        //DETALLE
        $detalle = $xml->createElement('detalle');
        $detalle = $facturaElectronicaCompraVenta->appendChild($detalle);

        $actividadEconomica = $xml->createElement('actividadEconomica','351000');//sacar de sincronizacion
        $actividadEconomica = $detalle->appendChild($actividadEconomica);

        $codigoProductoSin = $xml->createElement('codigoProductoSin','86311');//sacar de producto homolgar
        $codigoProductoSin = $detalle->appendChild($codigoProductoSin);

        $codigoProducto = $xml->createElement('codigoProducto','12345');//propio codigo
        $codigoProducto = $detalle->appendChild($codigoProducto);

        $descripcion = $xml->createElement('descripcion','Servicio Mes agosto');
        $descripcion = $detalle->appendChild($descripcion);

        $cantidad = $xml->createElement('cantidad','1');
        $cantidad = $detalle->appendChild($cantidad);

        $unidadMedida = $xml->createElement('unidadMedida','1');
        $unidadMedida = $detalle->appendChild($unidadMedida);

        $precioUnitario = $xml->createElement('precioUnitario','100');
        $precioUnitario = $detalle->appendChild($precioUnitario);

        $montoDescuento = $xml->createElement('montoDescuento','0');
        $montoDescuento = $detalle->appendChild($montoDescuento);

        $subTotal = $xml->createElement('subTotal','100');
        $subTotal = $detalle->appendChild($subTotal);

        $numeroSerie = $xml->createElement('numeroSerie','1000');
        $numeroSerie = $detalle->appendChild($numeroSerie);

        $numeroImei = $xml->createElement('numeroImei','100001');
        $numeroImei = $detalle->appendChild($numeroImei);

        $xml->formatOutput = true;

        $xml->save('facturas/'.$res_str_16.$cuf_act['codigo_control'].'.xml');//$res_str_16.$cuf_act['codigo_control']
        $fir = new FirmarXml();
        $fir->firmar('facturas/'.$res_str_16.$cuf_act['codigo_control'].'.xml');//$res_str_16.$cuf_act['codigo_control']

        //comprimirmos gzip
        $origen = 'facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.xml';//$res_str_16.$cuf_act['codigo_control']
        $destino = 'facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.gz';//$res_str_16.$cuf_act['codigo_control']
        $fp = fopen($origen, "r");
        $data = fread ($fp, filesize($origen));
        fclose($fp);
        $zp = gzopen($destino, "w9");
        gzwrite($zp, $data);
        gzclose($zp);
        //echo 'archivo creado';

        //Enviando la solicitud
        $wsdl = $this->config->item('ServicioFacturacionCompraVenta');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoDocumentoSector' => '1', 
            'codigoEmision' => '1', 
            'codigoModalidad' => $this->config->item('codigoModalidad'),
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cufd' => $cuf_act['codigo'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit'),
            'tipoFacturaDocumento' => '1', 
            'archivo' => file_get_contents('facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.gz'),//$res_str_16.$cuf_act['codigo_control']
            'fechaEnvio' => date("Y-m-d\TH:i:s.v"), 
            'hashArchivo' => hash_file('sha256', 'facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.gz'),//$res_str_16.$cuf_act['codigo_control']
            );
            //var_dump($parametros);
        $metodo = array('SolicitudServicioRecepcionFactura'=> $parametros);
        $resultado = $client->__soapCall('recepcionFactura', array($metodo));

        if($resultado->RespuestaServicioFacturacion->transaccion){
          $data_fact['cuf'] = $res_str_16.$cuf_act['codigo_control'];
          $data_fact['fecha_emision'] = date('Y-m-d H:i:s');
          $data_fact['estado_fact'] = 'E';//emitido
          $data_fact['id_empleado'] = $this->session->userdata('id_empleado');
          $data_fact['id_punto_venta'] = $pv['id_punto_venta'];
          $this->factura_model->insertar($data_fact);
          unlink('./facturas/'.$res_str_16.$cuf_act['codigo_control'].'.xml');
          unlink('./facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.xml');
          $salida = true;
        }
        elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
          $salida = false;
          echo 'ERROR: FALSE';
          var_dump($resultado->RespuestaServicioFacturacion);
        }else{
          $salida = false;
          echo 'Error desconocido.';
        }
        sleep(1);
        $i++;//incrementar contador
      }// fin while
      if($salida)
        echo $nro_peticiones.' facturas existosa(s).';

    }//fin if admin
    else
      redirect(base_url());
  }//fin funcion

  public function genera_fac_xml_13(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;

      $data['main_content'] = 'sf_sin/genera_fac_xml_13_view';
      $data['title'] = 'Factura indivicual';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function generar_factura_xml_13(){//servicios basicos
    if(isAdmin()){

      //recepción de post
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));

      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
      
        $xml = new DomDocument('1.0', 'UTF-8');
        $xml->xmlStandalone = true;
        $facturaElectronicaServicioBasico = $xml->createElement('facturaElectronicaServicioBasico');
        $facturaElectronicaServicioBasico = $xml->appendChild($facturaElectronicaServicioBasico);
        $facturaElectronicaServicioBasico->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $facturaElectronicaServicioBasico->setAttribute('xsi:noNamespaceSchemaLocation', 'facturaElectronicaServicioBasico.xsd');
        
        $cabecera = $xml->createElement('cabecera');
        $cabecera = $facturaElectronicaServicioBasico->appendChild($cabecera);
              
        $nitEmisor = $xml->createElement('nitEmisor',$this->config->item('nit'));
        $nitEmisor = $cabecera->appendChild($nitEmisor);
        
        $razonSocialEmisor = $xml->createElement('razonSocialEmisor',$this->config->item('razonSocial'));
        $razonSocialEmisor = $cabecera->appendChild($razonSocialEmisor);
        
        $municipio = $xml->createElement('municipio',$this->config->item('municipio'));
        $municipio = $cabecera->appendChild($municipio);
        
        $telefono = $xml->createElement('telefono',$this->config->item('telefono'));
        $telefono = $cabecera->appendChild($telefono);
        
        $nro_factura=1;//Extraer nro factura
        $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
        $numeroFactura = $cabecera->appendChild($numeroFactura);
        
        //para el CUF
        $tipo_emision = 1;
        $tipo_factura = 1;
        $tipo_doc_sector = 13;
        
        $res_concat = concatenar_ceros($this->config->item('nit'), date("YmdHisv"),$pv['codigo_sucursal'],$this->config->item('codigoModalidad'),$tipo_emision,$tipo_factura,$tipo_doc_sector,$nro_factura,$pv['codigo_punto_venta']);
        $res_m_11 = mod_11($res_concat,1,9,false);
        $res_str_16 = strtoupper(str_16($res_concat.$res_m_11));
        $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
    
        $cuf = $xml->createElement('cuf',$res_str_16.$cuf_act['codigo_control']);
        $cuf = $cabecera->appendChild($cuf);
        //Fin CUF
        
        $cufd = $xml->createElement('cufd',$cuf_act['codigo']);
        $cufd = $cabecera->appendChild($cufd);
        
        $codigoSucursal = $xml->createElement('codigoSucursal',$pv['codigo_sucursal']);
        $codigoSucursal = $cabecera->appendChild($codigoSucursal);
        
        $direccion = $xml->createElement('direccion',$this->config->item('direccion'));
        $direccion = $cabecera->appendChild($direccion);
        
        $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta',$pv['codigo_punto_venta']);
        $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);

        $mes = $xml->createElement('mes','SEPTIEMBRE');
        $mes = $cabecera->appendChild($mes);

        $gestion = $xml->createElement('gestion',date('Y'));
        $gestion = $cabecera->appendChild($gestion);

        $ciudad = $xml->createElement('ciudad',$this->config->item('ciudad'));
        $ciudad = $cabecera->appendChild($ciudad);

        $zona = $xml->createElement('zona','Zona cliente');
        $zona = $cabecera->appendChild($zona);

        $numeroMedidor = $xml->createElement('numeroMedidor','21');
        $numeroMedidor = $cabecera->appendChild($numeroMedidor);

        $fechaEmision = $xml->createElement('fechaEmision',date("Y-m-d\TH:i:s.v"));
        $fechaEmision = $cabecera->appendChild($fechaEmision);

        $razon_social_cliente = 'Carmelo Molina';
        $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
        $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);

        $domicilioCliente_cliente = 'TTe. leon y litoral nro 933';
        $domicilioCliente = $xml->createElement('domicilioCliente',$domicilioCliente_cliente);
        $domicilioCliente = $cabecera->appendChild($domicilioCliente);

        $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad','1');
        $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);

        $nro_doc_cliente=4043274;
        $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc_cliente);
        $numeroDocumento = $cabecera->appendChild($numeroDocumento);

        $complemento = $xml->createElement('complemento');//element vacio
        $complemento = $cabecera->appendChild($complemento);
        $complemento->setAttribute('xsi:nil', 'true');

        $codigoCliente = $xml->createElement('codigoCliente','51158891');
        $codigoCliente = $cabecera->appendChild($codigoCliente);

        $codigoMetodoPago = $xml->createElement('codigoMetodoPago','1');
        $codigoMetodoPago = $cabecera->appendChild($codigoMetodoPago);

        $numeroTarjeta = $xml->createElement('numeroTarjeta');//element vacio
        $numeroTarjeta = $cabecera->appendChild($numeroTarjeta);
        $numeroTarjeta->setAttribute('xsi:nil', 'true');

        $montoTotal = $xml->createElement('montoTotal','124.50');
        $montoTotal = $cabecera->appendChild($montoTotal);

        $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva','110');
        $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);

        $consumoPeriodo = $xml->createElement('consumoPeriodo');//element vacio
        $consumoPeriodo = $cabecera->appendChild($consumoPeriodo);
        $consumoPeriodo->setAttribute('xsi:nil', 'true');

        $beneficiarioLey1886 = $xml->createElement('beneficiarioLey1886');//element vacio
        $beneficiarioLey1886 = $cabecera->appendChild($beneficiarioLey1886);
        $beneficiarioLey1886->setAttribute('xsi:nil', 'true');

        $montoDescuentoLey1886 = $xml->createElement('montoDescuentoLey1886');//element vacio
        $montoDescuentoLey1886 = $cabecera->appendChild($montoDescuentoLey1886);
        $montoDescuentoLey1886->setAttribute('xsi:nil', 'true');

        $montoDescuentoTarifaDignidad = $xml->createElement('montoDescuentoTarifaDignidad');//element vacio
        $montoDescuentoTarifaDignidad = $cabecera->appendChild($montoDescuentoTarifaDignidad);
        $montoDescuentoTarifaDignidad->setAttribute('xsi:nil', 'true');

        $tasaAseo = $xml->createElement('tasaAseo','5');
        $tasaAseo = $cabecera->appendChild($tasaAseo);

        $tasaAlumbrado = $xml->createElement('tasaAlumbrado','2');
        $tasaAlumbrado = $cabecera->appendChild($tasaAlumbrado);

        $ajusteNoSujetoIva = $xml->createElement('ajusteNoSujetoIva','5');
        $ajusteNoSujetoIva = $cabecera->appendChild($ajusteNoSujetoIva);

        $detalleAjusteNoSujetoIva = $xml->createElement('detalleAjusteNoSujetoIva','{"Ajuste por Reclamo":5}');
        $detalleAjusteNoSujetoIva = $cabecera->appendChild($detalleAjusteNoSujetoIva);

        $ajusteSujetoIva = $xml->createElement('ajusteSujetoIva','10');
        $ajusteSujetoIva = $cabecera->appendChild($ajusteSujetoIva);

        $detalleAjusteSujetoIva = $xml->createElement('detalleAjusteSujetoIva','{"Cobropor Reconexión":10}');
        $detalleAjusteSujetoIva = $cabecera->appendChild($detalleAjusteSujetoIva);

        $otrosPagosNoSujetoIva = $xml->createElement('otrosPagosNoSujetoIva','7');
        $otrosPagosNoSujetoIva = $cabecera->appendChild($otrosPagosNoSujetoIva);

        $detalleOtrosPagosNoSujetoIva = $xml->createElement('detalleOtrosPagosNoSujetoIva','{"Pago Cuota Cooperativa":7}');
        $detalleOtrosPagosNoSujetoIva = $cabecera->appendChild($detalleOtrosPagosNoSujetoIva);

        $otrasTasas = $xml->createElement('otrasTasas','0.50');
        $otrasTasas = $cabecera->appendChild($otrasTasas);

        $codigoMoneda = $xml->createElement('codigoMoneda','1');
        $codigoMoneda = $cabecera->appendChild($codigoMoneda);

        $tipoCambio = $xml->createElement('tipoCambio','1');
        $tipoCambio = $cabecera->appendChild($tipoCambio);

        $montoTotalMoneda = $xml->createElement('montoTotalMoneda','124.50');
        $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);

        $descuentoAdicional = $xml->createElement('descuentoAdicional');//element vacio
        $descuentoAdicional = $cabecera->appendChild($descuentoAdicional);
        $descuentoAdicional->setAttribute('xsi:nil', 'true');

        $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
        $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
        $codigoExcepcion->setAttribute('xsi:nil', 'true');

        $cafc = $xml->createElement('cafc');//element vacio
        $cafc = $cabecera->appendChild($cafc);
        $cafc->setAttribute('xsi:nil', 'true');

        $leyenda = $xml->createElement('leyenda','Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.');
        $leyenda = $cabecera->appendChild($leyenda);

        $usuario = $xml->createElement('usuario','pperez');
        $usuario = $cabecera->appendChild($usuario);

        $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','13');
        $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);

        //DETALLE
        $detalle = $xml->createElement('detalle');
        $detalle = $facturaElectronicaServicioBasico->appendChild($detalle);

        $actividadEconomica = $xml->createElement('actividadEconomica','351000');//sacar de sincronizacion
        $actividadEconomica = $detalle->appendChild($actividadEconomica);

        $codigoProductoSin = $xml->createElement('codigoProductoSin','86311');//sacar de producto homolgar
        $codigoProductoSin = $detalle->appendChild($codigoProductoSin);

        $codigoProducto = $xml->createElement('codigoProducto','12345');//propio codigo
        $codigoProducto = $detalle->appendChild($codigoProducto);

        $descripcion = $xml->createElement('descripcion','Servicio Mes agosto');
        $descripcion = $detalle->appendChild($descripcion);

        $cantidad = $xml->createElement('cantidad','1');
        $cantidad = $detalle->appendChild($cantidad);

        $unidadMedida = $xml->createElement('unidadMedida','1');
        $unidadMedida = $detalle->appendChild($unidadMedida);

        $precioUnitario = $xml->createElement('precioUnitario','100');
        $precioUnitario = $detalle->appendChild($precioUnitario);

        $montoDescuento = $xml->createElement('montoDescuento','0');
        $montoDescuento = $detalle->appendChild($montoDescuento);

        $subTotal = $xml->createElement('subTotal','100');
        $subTotal = $detalle->appendChild($subTotal);

        $xml->formatOutput = true;

        $xml->save('facturas/'.$res_str_16.$cuf_act['codigo_control'].'.xml');//$res_str_16.$cuf_act['codigo_control']
        $fir = new FirmarXml();
        $fir->firmar('facturas/'.$res_str_16.$cuf_act['codigo_control'].'.xml');//$res_str_16.$cuf_act['codigo_control']
        
        
        //comprimirmos gzip
        $origen = 'facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.xml';//$res_str_16.$cuf_act['codigo_control']
        $destino = 'facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.gz';//$res_str_16.$cuf_act['codigo_control']
        $fp = fopen($origen, "r");
        $data = fread ($fp, filesize($origen));
        fclose($fp);
        $zp = gzopen($destino, "w9");
        gzwrite($zp, $data);
        gzclose($zp);
        //echo 'archivo creado';

        //Enviando la solicitud
        $wsdl = $this->config->item('endPoint_FacturaServiciosBasicos');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoDocumentoSector' => '13', 
            'codigoEmision' => '1', 
            'codigoModalidad' => $this->config->item('codigoModalidad'),
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cufd' => $cuf_act['codigo'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit'),
            'tipoFacturaDocumento' => '1', 
            'archivo' => file_get_contents('facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.gz'),//$res_str_16.$cuf_act['codigo_control']
            'fechaEnvio' => date("Y-m-d\TH:i:s.v"), 
            'hashArchivo' => hash_file('sha256', 'facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.gz'),//$res_str_16.$cuf_act['codigo_control']
            );
            //var_dump($parametros);
        $metodo = array('SolicitudServicioRecepcionFactura'=> $parametros);
        $resultado = $client->__soapCall('recepcionFactura', array($metodo));

        if($resultado->RespuestaServicioFacturacion->transaccion){
          $data_fact['cuf'] = $res_str_16.$cuf_act['codigo_control'];
          $data_fact['fecha_emision'] = date('Y-m-d H:i:s');
          $data_fact['estado_fact'] = 'E';//emitido
          $data_fact['id_empleado'] = $this->session->userdata('id_empleado');
          $data_fact['id_punto_venta'] = $pv['id_punto_venta'];
          $this->factura_model->insertar($data_fact);
          unlink('./facturas/'.$res_str_16.$cuf_act['codigo_control'].'.xml');
          unlink('./facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.xml');
          $salida = true;
        }
        elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
          $salida = false;
          echo 'ERROR: FALSE';
          var_dump($resultado->RespuestaServicioFacturacion);
        }else{
          $salida = false;
          echo 'Error desconocido.';
        }
        $i++;//incrementar contador
        sleep(1);
      }// fin while
      if($salida)
        echo $nro_peticiones.' facturas existosa(s).';

    }//fin if admin
    else
      redirect(base_url());
  }//fin funcion sector 13

  public function genera_fac_xml_22(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;

      $data['main_content'] = 'sf_sin/genera_fac_xml_22_view';
      $data['title'] = 'Factura indivicual';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function generar_factura_xml_22(){//compra venta
    if(isAdmin()){

      //recepción de post    
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));

      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
      
        $xml = new DomDocument('1.0', 'UTF-8');
        $xml->xmlStandalone = true;
        $facturaElectronicaTelecomunicacion = $xml->createElement('facturaElectronicaTelecomunicacion');
        $facturaElectronicaTelecomunicacion = $xml->appendChild($facturaElectronicaTelecomunicacion);
        $facturaElectronicaTelecomunicacion->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $facturaElectronicaTelecomunicacion->setAttribute('xsi:noNamespaceSchemaLocation', 'facturaElectronicaTelecomunicacion.xsd');
        
        $cabecera = $xml->createElement('cabecera');
        $cabecera = $facturaElectronicaTelecomunicacion->appendChild($cabecera);
              
        $nitEmisor = $xml->createElement('nitEmisor',$this->config->item('nit'));
        $nitEmisor = $cabecera->appendChild($nitEmisor);
        
        $razonSocialEmisor = $xml->createElement('razonSocialEmisor',$this->config->item('razonSocial'));
        $razonSocialEmisor = $cabecera->appendChild($razonSocialEmisor);
        
        $municipio = $xml->createElement('municipio',$this->config->item('municipio'));
        $municipio = $cabecera->appendChild($municipio);
        
        $telefono = $xml->createElement('telefono',$this->config->item('telefono'));
        $telefono = $cabecera->appendChild($telefono);

        $nitConjunto = $xml->createElement('nitConjunto');//element vacio
        $nitConjunto = $cabecera->appendChild($nitConjunto);
        $nitConjunto->setAttribute('xsi:nil', 'true');

        
        $nro_factura=1;//Extraer nro factura
        $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
        $numeroFactura = $cabecera->appendChild($numeroFactura);
        
        //para el CUF
        $tipo_emision = 1;
        $tipo_factura = 1;
        $tipo_doc_sector = 22;
        
        $res_concat = concatenar_ceros($this->config->item('nit'), date("YmdHisv"),$pv['codigo_sucursal'],$this->config->item('codigoModalidad'),$tipo_emision,$tipo_factura,$tipo_doc_sector,$nro_factura,$pv['codigo_punto_venta']);
        $res_m_11 = mod_11($res_concat,1,9,false);
        $res_str_16 = strtoupper(str_16($res_concat.$res_m_11));
        $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
    
        $cuf = $xml->createElement('cuf',$res_str_16.$cuf_act['codigo_control']);
        $cuf = $cabecera->appendChild($cuf);
        //Fin CUF
        
        $cufd = $xml->createElement('cufd',$cuf_act['codigo']);
        $cufd = $cabecera->appendChild($cufd);
        
        $codigoSucursal = $xml->createElement('codigoSucursal',$pv['codigo_sucursal']);
        $codigoSucursal = $cabecera->appendChild($codigoSucursal);
        
        $direccion = $xml->createElement('direccion',$this->config->item('direccion'));
        $direccion = $cabecera->appendChild($direccion);
        
        $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta',$pv['codigo_punto_venta']);
        $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);

        $fechaEmision = $xml->createElement('fechaEmision',date("Y-m-d\TH:i:s.v"));
        $fechaEmision = $cabecera->appendChild($fechaEmision);

        $razon_social_cliente = 'Carmelo Molina';
        $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
        $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);

        $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad','1');
        $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);

        $nro_doc_cliente=4043274;
        $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc_cliente);
        $numeroDocumento = $cabecera->appendChild($numeroDocumento);

        $complemento = $xml->createElement('complemento');//element vacio
        $complemento = $cabecera->appendChild($complemento);
        $complemento->setAttribute('xsi:nil', 'true');

        $codigoCliente = $xml->createElement('codigoCliente','51158891');
        $codigoCliente = $cabecera->appendChild($codigoCliente);

        $codigoMetodoPago = $xml->createElement('codigoMetodoPago','1');
        $codigoMetodoPago = $cabecera->appendChild($codigoMetodoPago);

        $numeroTarjeta = $xml->createElement('numeroTarjeta');//element vacio
        $numeroTarjeta = $cabecera->appendChild($numeroTarjeta);
        $numeroTarjeta->setAttribute('xsi:nil', 'true');

        $montoTotal = $xml->createElement('montoTotal','100');
        $montoTotal = $cabecera->appendChild($montoTotal);

        $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva','100');
        $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);

        $codigoMoneda = $xml->createElement('codigoMoneda','1');
        $codigoMoneda = $cabecera->appendChild($codigoMoneda);

        $tipoCambio = $xml->createElement('tipoCambio','1');
        $tipoCambio = $cabecera->appendChild($tipoCambio);

        $montoTotalMoneda = $xml->createElement('montoTotalMoneda','100');
        $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);

        $montoGiftCard = $xml->createElement('montoGiftCard');//element vacio
        $montoGiftCard = $cabecera->appendChild($montoGiftCard);
        $montoGiftCard->setAttribute('xsi:nil', 'true');

        $descuentoAdicional = $xml->createElement('descuentoAdicional');//element vacio
        $descuentoAdicional = $cabecera->appendChild($descuentoAdicional);
        $descuentoAdicional->setAttribute('xsi:nil', 'true');

        $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
        $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
        $codigoExcepcion->setAttribute('xsi:nil', 'true');

        $cafc = $xml->createElement('cafc');//element vacio
        $cafc = $cabecera->appendChild($cafc);
        $cafc->setAttribute('xsi:nil', 'true');

        $leyenda = $xml->createElement('leyenda','Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.');
        $leyenda = $cabecera->appendChild($leyenda);

        $usuario = $xml->createElement('usuario','pperez');
        $usuario = $cabecera->appendChild($usuario);

        $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','22');
        $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);

        //DETALLE
        $detalle = $xml->createElement('detalle');
        $detalle = $facturaElectronicaTelecomunicacion->appendChild($detalle);

        $actividadEconomica = $xml->createElement('actividadEconomica','351000');//sacar de sincronizacion
        $actividadEconomica = $detalle->appendChild($actividadEconomica);

        $codigoProductoSin = $xml->createElement('codigoProductoSin','86311');//sacar de producto homolgar
        $codigoProductoSin = $detalle->appendChild($codigoProductoSin);

        $codigoProducto = $xml->createElement('codigoProducto','12345');//propio codigo
        $codigoProducto = $detalle->appendChild($codigoProducto);

        $descripcion = $xml->createElement('descripcion','PAGO DE MES DE ABRIL DE POSTPAGO');
        $descripcion = $detalle->appendChild($descripcion);

        $cantidad = $xml->createElement('cantidad','1');
        $cantidad = $detalle->appendChild($cantidad);

        $unidadMedida = $xml->createElement('unidadMedida','1');
        $unidadMedida = $detalle->appendChild($unidadMedida);

        $precioUnitario = $xml->createElement('precioUnitario','100');
        $precioUnitario = $detalle->appendChild($precioUnitario);

        $montoDescuento = $xml->createElement('montoDescuento','0');
        $montoDescuento = $detalle->appendChild($montoDescuento);

        $subTotal = $xml->createElement('subTotal','100');
        $subTotal = $detalle->appendChild($subTotal);

        $numeroSerie = $xml->createElement('numeroSerie','67755FD');
        $numeroSerie = $detalle->appendChild($numeroSerie);

        $numeroImei = $xml->createElement('numeroImei','44100');
        $numeroImei = $detalle->appendChild($numeroImei);

        $xml->formatOutput = true;

        $xml->save('facturas/'.$res_str_16.$cuf_act['codigo_control'].'.xml');//$res_str_16.$cuf_act['codigo_control']
        $fir = new FirmarXml();
        $fir->firmar('facturas/'.$res_str_16.$cuf_act['codigo_control'].'.xml');//$res_str_16.$cuf_act['codigo_control']
        
        
        //comprimirmos gzip
        $origen = 'facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.xml';//$res_str_16.$cuf_act['codigo_control']
        $destino = 'facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.gz';//$res_str_16.$cuf_act['codigo_control']
        $fp = fopen($origen, "r");
        $data = fread ($fp, filesize($origen));
        fclose($fp);
        $zp = gzopen($destino, "w9");
        gzwrite($zp, $data);
        gzclose($zp);
        //echo 'archivo creado';

        //Enviando la solicitud
        $wsdl = $this->config->item('endPoint_FacturaTelecomunicaciones');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoDocumentoSector' => '22', 
            'codigoEmision' => '1', 
            'codigoModalidad' => $this->config->item('codigoModalidad'),
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cufd' => $cuf_act['codigo'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit'),
            'tipoFacturaDocumento' => '1', 
            'archivo' => file_get_contents('facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.gz'),//$res_str_16.$cuf_act['codigo_control']
            'fechaEnvio' => date("Y-m-d\TH:i:s.v"), 
            'hashArchivo' => hash_file('sha256', 'facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.gz'),//$res_str_16.$cuf_act['codigo_control']
            );
            //var_dump($parametros);
        $metodo = array('SolicitudServicioRecepcionFactura'=> $parametros);
        $resultado = $client->__soapCall('recepcionFactura', array($metodo));

        if($resultado->RespuestaServicioFacturacion->transaccion){
          $data_fact['cuf'] = $res_str_16.$cuf_act['codigo_control'];
          $data_fact['fecha_emision'] = date('Y-m-d H:i:s');
          $data_fact['estado_fact'] = 'E';//emitido
          $data_fact['id_empleado'] = $this->session->userdata('id_empleado');
          $data_fact['id_punto_venta'] = $pv['id_punto_venta'];
          $this->factura_model->insertar($data_fact);
          unlink('./facturas/'.$res_str_16.$cuf_act['codigo_control'].'.xml');
          unlink('./facturas/'.$res_str_16.$cuf_act['codigo_control'].'_firmado.xml');
          $salida = true;
        }
        elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
          $salida = false;
          echo 'ERROR: FALSE';
          var_dump($resultado->RespuestaServicioFacturacion);
        }else{
          $salida = false;
          echo 'Error desconocido.';
        }
        
        $i++;//incrementar contador
        sleep(1);
      }// fin while
      if($salida)
        echo $nro_peticiones.' facturas existosa(s).';

    }//fin if admin
    else
      redirect(base_url());
  }//fin funcion sector 22


  public function reg_evento_significativo(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['eventos'] = $this->parametrica_evento_significativo_model->get_all();

      $data['main_content'] = 'sf_sin/reg_evento_significativo_view';
      $data['title'] = 'Registro de eventos significativos';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function registro_evento_significativo(){
    if(isAdmin()){
      
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      $ev = $this->parametrica_evento_significativo_model->get_parametrica_evento_significativo($this->input->post('id_parametrica_evento_significativo'));
      $cufd = $this->cufd_model->get_cufd_by_id_pv($this->input->post('id_punto_venta'));
      $i=1;
      $salida = false;
      while($i<=$nro_peticiones){
        $wsdl = $this->config->item('endPoint_FacturacionOperaciones');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoMotivoEvento' => $ev['codigo_clasificador'], 
            'codigoPuntoVenta' => $pv['codigo_punto_venta'],
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cufd' => $cufd['codigo'],
            'cufdEvento' => $cufd['codigo'],
            'cuis' => $cuis['cuis_codigo'],
            'descripcion' => $ev['descripcion'],
            'fechaHoraFinEvento' => date("Y-m-d\TH:i:0".($i*2).".v"),
            'fechaHoraInicioEvento' => date("Y-m-d\TH:i:0".($i*2-1).".v"),
            'nit' => $this->config->item('nit')
            );
        $metodo = array('SolicitudEventoSignificativo'=> $parametros);
        
        $resultado = $client->__soapCall('registroEventoSignificativo', array($metodo));
        
        if($resultado->RespuestaListaEventos->transaccion){
            //if($this->config->item('codigoModalidad')=='1'){// PARA PRODUCCION
            if($nro_peticiones==1){
              ;
            }
            $salida = true;
          }
          elseif($resultado->RespuestaListaEventos->transaccion == false){
            $salida = false;
            echo 'ERROR: FALSE';
            var_dump($resultado->RespuestaListaEventos);
          }else{
            $salida = false;
            echo 'Error desconocido.';
          }
        $i++;//incrementar contador
        sleep(1);
      }// fin while
      if($salida)
        echo $nro_peticiones.' Registro(s) existosa(s).';
    }
    else
      redirect(base_url());
  }

  /* PAQUETES */
  public function genera_paquete_xml(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['eventos'] = $this->parametrica_evento_significativo_model->get_all();

      $data['main_content'] = 'sf_sin/genera_paquete_xml_view';
      $data['title'] = 'Emisión de paquetes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function generar_paquete_xml(){
    if(isAdmin()){

      //recepción de post
      $n = $this->input->post('peticiones');
      $k=1;
      while($k<=$n){
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      $ev = $this->parametrica_evento_significativo_model->get_parametrica_evento_significativo($this->input->post('id_parametrica_evento_significativo'));
      
      /* REGISTRO EVENTO*/
        //para el CUF
      $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);

      $wsdl = $this->config->item('endPoint_FacturacionOperaciones');
      $token = $this->config->item('token');
      $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
      $context = stream_context_create($opts);
      $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
      
      $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
      $parametros = array(
          'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
          'codigoMotivoEvento' => $ev['codigo_clasificador'], 
          'codigoPuntoVenta' => $pv['codigo_punto_venta'],
          'codigoSistema' => $this->config->item('codigoSistema'),
          'codigoSucursal' => $pv['codigo_sucursal'],
          'cufd' => $cuf_act['codigo'],
          'cufdEvento' => $cuf_act['codigo'],
          'cuis' => $cuis['cuis_codigo'],
          'descripcion' => $ev['descripcion'],
          'fechaHoraFinEvento' => date("Y-m-d\TH:i:10.000"),
          'fechaHoraInicioEvento' => date("Y-m-d\TH:i:00.000"),
          'nit' => $this->config->item('nit')
          );
      
      $metodo = array('SolicitudEventoSignificativo'=> $parametros);
      $resultado = $client->__soapCall('registroEventoSignificativo', array($metodo));
      $codigoRecepcionEventoSignificativo = null;
      if($resultado->RespuestaListaEventos->transaccion){
            $codigoRecepcionEventoSignificativo = $resultado->RespuestaListaEventos->codigoRecepcionEventoSignificativo;
          $salida = true;
        }
        elseif($resultado->RespuestaListaEventos->transaccion == false){
          $salida = false;
          echo 'ERROR: FALSE';
          var_dump($resultado->RespuestaListaEventos);
        }else{
          $salida = false;
          echo 'Error desconocido.';
        }
      if(!is_null($codigoRecepcionEventoSignificativo)){
        // GENERAR LOS ARCHIVOS XML
        $i=1;
        $total_fact_xml = $nro_peticiones;
        while($i<=$total_fact_xml){
      
          $xml = new DomDocument('1.0', 'UTF-8');
          $xml->xmlStandalone = true;
          $facturaElectronicaCompraVenta = $xml->createElement('facturaElectronicaCompraVenta');
          $facturaElectronicaCompraVenta = $xml->appendChild($facturaElectronicaCompraVenta);
          $facturaElectronicaCompraVenta->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
          $facturaElectronicaCompraVenta->setAttribute('xsi:noNamespaceSchemaLocation', 'facturaElectronicaCompraVenta.xsd');
            
          $cabecera = $xml->createElement('cabecera');
          $cabecera = $facturaElectronicaCompraVenta->appendChild($cabecera);
                
          $nitEmisor = $xml->createElement('nitEmisor',$this->config->item('nit'));
          $nitEmisor = $cabecera->appendChild($nitEmisor);
          
          $razonSocialEmisor = $xml->createElement('razonSocialEmisor',$this->config->item('razonSocial'));
          $razonSocialEmisor = $cabecera->appendChild($razonSocialEmisor);
          
          $municipio = $xml->createElement('municipio',$this->config->item('municipio'));
          $municipio = $cabecera->appendChild($municipio);
          
          $telefono = $xml->createElement('telefono',$this->config->item('telefono'));
          $telefono = $cabecera->appendChild($telefono);
          
          $nro_factura=1;//Extraer nro factura
          $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
          $numeroFactura = $cabecera->appendChild($numeroFactura);
            
          //para el CUF
          $tipo_emision = 2;
          $tipo_factura = 1;
          $tipo_doc_sector = 1;
          
          $res_concat = concatenar_ceros($this->config->item('nit'), date("YmdHisv"),$pv['codigo_sucursal'],$this->config->item('codigoModalidad'),$tipo_emision,$tipo_factura,$tipo_doc_sector,$nro_factura,$pv['codigo_punto_venta']);
          $res_m_11 = mod_11($res_concat,1,9,false);
          $res_str_16 = strtoupper(str_16($res_concat.$res_m_11));
          $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
      
          $cuf = $xml->createElement('cuf',$res_str_16.$cuf_act['codigo_control']);
          $cuf = $cabecera->appendChild($cuf);
          //Fin CUF
          
          $cufd = $xml->createElement('cufd',$cuf_act['codigo']);
          $cufd = $cabecera->appendChild($cufd);
          
          $codigoSucursal = $xml->createElement('codigoSucursal',$pv['codigo_sucursal']);
          $codigoSucursal = $cabecera->appendChild($codigoSucursal);
          
          $direccion = $xml->createElement('direccion',$this->config->item('direccion'));
          $direccion = $cabecera->appendChild($direccion);
          
          if($pv['codigo_punto_venta']==0){
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta');//element vacio
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
            $codigoPuntoVenta->setAttribute('xsi:nil', 'true');  
          }else{
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta',$pv['codigo_punto_venta']);
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
          }
  
          $fechaEmision = $xml->createElement('fechaEmision',date("Y-m-d\TH:i:s.v"));
          $fechaEmision = $cabecera->appendChild($fechaEmision);
  
          $razon_social_cliente = 'Carmelo Molina';
          $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
          $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);
  
          $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad','1');
          $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);
  
          $nro_doc_cliente=4043274;
          $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc_cliente);
          $numeroDocumento = $cabecera->appendChild($numeroDocumento);
    
          $complemento = $xml->createElement('complemento');//element vacio
          $complemento = $cabecera->appendChild($complemento);
          $complemento->setAttribute('xsi:nil', 'true');
  
          $codigoCliente = $xml->createElement('codigoCliente','51158891');
          $codigoCliente = $cabecera->appendChild($codigoCliente);
  
          $codigoMetodoPago = $xml->createElement('codigoMetodoPago','1');
          $codigoMetodoPago = $cabecera->appendChild($codigoMetodoPago);
  
          $numeroTarjeta = $xml->createElement('numeroTarjeta');//element vacio
          $numeroTarjeta = $cabecera->appendChild($numeroTarjeta);
          $numeroTarjeta->setAttribute('xsi:nil', 'true');
  
          $montoTotal = $xml->createElement('montoTotal','99');
          $montoTotal = $cabecera->appendChild($montoTotal);
  
          $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva','99');
          $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);
  
          $codigoMoneda = $xml->createElement('codigoMoneda','1');
          $codigoMoneda = $cabecera->appendChild($codigoMoneda);
  
          $tipoCambio = $xml->createElement('tipoCambio','1');
          $tipoCambio = $cabecera->appendChild($tipoCambio);
  
          $montoTotalMoneda = $xml->createElement('montoTotalMoneda','99');
          $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);
  
          $montoGiftCard = $xml->createElement('montoGiftCard');//element vacio
          $montoGiftCard = $cabecera->appendChild($montoGiftCard);
          $montoGiftCard->setAttribute('xsi:nil', 'true');
  
          $descuentoAdicional = $xml->createElement('descuentoAdicional','1');
          $descuentoAdicional = $cabecera->appendChild($descuentoAdicional);
  
          $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
          $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
          $codigoExcepcion->setAttribute('xsi:nil', 'true');
  
          $cafc = $xml->createElement('cafc');
          $cafc = $cabecera->appendChild($cafc);
          $cafc->setAttribute('xsi:nil', 'true');
          
          /*$cafc = $xml->createElement('cafc','123456');
          $cafc = $cabecera->appendChild($cafc);*/
  
  
          $leyenda = $xml->createElement('leyenda','Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.');
          $leyenda = $cabecera->appendChild($leyenda);
  
          $usuario = $xml->createElement('usuario','pperez');
          $usuario = $cabecera->appendChild($usuario);
  
          $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','1');
          $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);
  
          //DETALLE
          $detalle = $xml->createElement('detalle');
          $detalle = $facturaElectronicaCompraVenta->appendChild($detalle);
    
          $actividadEconomica = $xml->createElement('actividadEconomica','351000');//sacar de sincronizacion
          $actividadEconomica = $detalle->appendChild($actividadEconomica);
  
          $codigoProductoSin = $xml->createElement('codigoProductoSin','86311');//sacar de producto homolgar
          $codigoProductoSin = $detalle->appendChild($codigoProductoSin);
  
          $codigoProducto = $xml->createElement('codigoProducto','TUL-13');//propio codigo
          $codigoProducto = $detalle->appendChild($codigoProducto);
  
          $descripcion = $xml->createElement('descripcion','JUGO DE NARANJA EN VASO');
          $descripcion = $detalle->appendChild($descripcion);
  
          $cantidad = $xml->createElement('cantidad','1');
          $cantidad = $detalle->appendChild($cantidad);
  
          $unidadMedida = $xml->createElement('unidadMedida','1');
          $unidadMedida = $detalle->appendChild($unidadMedida);
  
          $precioUnitario = $xml->createElement('precioUnitario','100');
          $precioUnitario = $detalle->appendChild($precioUnitario);
  
          $montoDescuento = $xml->createElement('montoDescuento','0');
          $montoDescuento = $detalle->appendChild($montoDescuento);
  
          $subTotal = $xml->createElement('subTotal','100');
          $subTotal = $detalle->appendChild($subTotal);
  
          $numeroSerie = $xml->createElement('numeroSerie','124548');
          $numeroSerie = $detalle->appendChild($numeroSerie);
  
          $numeroImei = $xml->createElement('numeroImei','545454');
          $numeroImei = $detalle->appendChild($numeroImei);
  
          $xml->formatOutput = true;
          $xml->save('facturas/off_line_'.$i.'.xml');
          $fir = new FirmarXml();
          $fir->firmar('facturas/off_line_'.$i.'.xml');//$res_str_16.$cuf_act['codigo_control']
  
          usleep(10000);//250000 100000 
          $i++;
        }// fin while

        $p = new PharData('./facturas/final_'.$k.'.tar');
        for($i=1;$i<=$total_fact_xml;$i++)
        $p['off_line_'.$i.'_firmado.xml'] = file_get_contents('./facturas/off_line_'.$i.'_firmado.xml');
        
        $p->compress(Phar::GZ);
        unlink('./facturas/final_'.$k.'.tar');

          //Enviando la solicitud
          $wsdl = $this->config->item('ServicioFacturacionCompraVenta');
          $token = $this->config->item('token');
          $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
          $context = stream_context_create($opts);
          $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
          
          $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
          $parametros = array(
              'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
              'codigoDocumentoSector' => '1', 
              'codigoEmision' => '2', 
              'codigoModalidad' => $this->config->item('codigoModalidad'), 
              'codigoPuntoVenta' => $pv['codigo_punto_venta'],
              'codigoSistema' => $this->config->item('codigoSistema'),
              'codigoSucursal' => $pv['codigo_sucursal'],
              'cufd' => $cuf_act['codigo'],
              'cuis' => $cuis['cuis_codigo'],
              'nit' => $this->config->item('nit'),
              'tipoFacturaDocumento' => '1', 
              
              'cafc' => '101B4E33B5A1D',
              'descripcion' => $ev['descripcion'],
              'archivo' => file_get_contents('facturas/final_'.$k.'.tar.gz'),
              'hashArchivo' => hash_file('sha256', 'facturas/final_'.$k.'.tar.gz'),
              'cantidadFacturas' => $total_fact_xml,
              'fechaEnvio' => date("Y-m-d\TH:i:s.v"), 
              'codigoEvento' => $codigoRecepcionEventoSignificativo,
              'codigoRecepcionEvento' => $codigoRecepcionEventoSignificativo,
              );
              //var_dump($parametros);
              
          $metodo = array('SolicitudServicioRecepcionPaquete'=> $parametros);
          $resultado = $client->__soapCall('recepcionPaqueteFactura', array($metodo));
          $codigoRecepcion = null;
            if($resultado->RespuestaServicioFacturacion->transaccion){
              var_dump($resultado->RespuestaServicioFacturacion);
              echo 'paquete enviado exitosamente';
              $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
              $salida = true;
            }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
              $salida = false;
              echo 'ERROR: FALSE';
              var_dump($resultado->RespuestaServicioFacturacion);
            }else{
              $salida = false;
              echo 'Error desconocido.';
            }

            /* VERIFICACION PAQUETE */
            if(!is_null($codigoRecepcion)){
              //Enviando la solicitud
              $wsdl = $this->config->item('ServicioFacturacionCompraVenta');
              $token = $this->config->item('token');
              $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
              $context = stream_context_create($opts);
              $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
              
              $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
              $parametros = array(
                  'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
                  'codigoDocumentoSector' => '1', 
                  'codigoEmision' => '2', 
                  'codigoModalidad' => $this->config->item('codigoModalidad'), 
                  'codigoPuntoVenta' => $pv['codigo_punto_venta'],
                  'codigoSistema' => $this->config->item('codigoSistema'),
                  'codigoSucursal' => $pv['codigo_sucursal'],
                  'cufd' => $cuf_act['codigo'],
                  'cuis' => $cuis['cuis_codigo'],
                  'nit' => $this->config->item('nit'),
                  'tipoFacturaDocumento' => '1', 
                  'codigoRecepcion' => $codigoRecepcion,//Codigo del evento registrado anteriormente 
                  );
                  //var_dump($parametros);
                  
              $metodo = array('SolicitudServicioValidacionRecepcionPaquete'=> $parametros);
              $resultado = $client->__soapCall('validacionRecepcionPaqueteFactura', array($metodo));
                if($resultado->RespuestaServicioFacturacion->transaccion){
                  var_dump($resultado->RespuestaServicioFacturacion);
                  echo 'Validacion exitosamente<br>';
                  $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
                  for ($i=1; $i <=$total_fact_xml ; $i++) { 
                    unlink('./facturas/off_line_'.$i.'.xml');
                    unlink('./facturas/off_line_'.$i.'_firmado.xml');
                  }
                  unlink('./facturas/final_'.$k.'.tar.gz');
                  echo 'Eliminación archivos exitosamente';
                }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
                  $salida = false;
                  echo 'ERROR: FALSE';
                  var_dump($resultado->RespuestaServicioFacturacion);
                }else{
                  $salida = false;
                  echo 'Error desconocido.';
                }
            }else{
              echo 'ERROR el codigoRecepcion es null';
            }

      }else{//fin error evento
          echo 'Error en evento registrado';
          }
          $k++;
          if(((int)$pv['codigo_punto_venta'])==1)
            sleep(10);
          else 
            sleep(20);
        }//fin while K
    }//fin if admin
    else
      redirect(base_url());
  }//fin funcion

  /* PAQUETES  13 */
  public function genera_paquete_xml_13(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['eventos'] = $this->parametrica_evento_significativo_model->get_all();

      $data['main_content'] = 'sf_sin/genera_paquete_xml_13_view';
      $data['title'] = 'Emisión de paquetes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function generar_paquete_xml_13(){
    if(isAdmin()){

      //recepción de post
      $n = $this->input->post('peticiones');
      $k=1;
      while($k<=$n){
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      $ev = $this->parametrica_evento_significativo_model->get_parametrica_evento_significativo($this->input->post('id_parametrica_evento_significativo'));
      
      /* REGISTRO EVENTO*/
        //para el CUF
        $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
        
      $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);

      $wsdl = $this->config->item('endPoint_FacturacionOperaciones');
      $token = $this->config->item('token');
      $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
      $context = stream_context_create($opts);
      $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
      
      $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
      $parametros = array(
          'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
          'codigoMotivoEvento' => $ev['codigo_clasificador'], 
          'codigoPuntoVenta' => $pv['codigo_punto_venta'],
          'codigoSistema' => $this->config->item('codigoSistema'),
          'codigoSucursal' => $pv['codigo_sucursal'],
          'cufd' => $cuf_act['codigo'],
          'cufdEvento' => $cuf_act['codigo'],
          'cuis' => $cuis['cuis_codigo'],
          'descripcion' => $ev['descripcion'],
          'fechaHoraFinEvento' => date("Y-m-d\TH:i:10.000"),
          'fechaHoraInicioEvento' => date("Y-m-d\TH:i:01.000"),
          'nit' => $this->config->item('nit')
          );
      
      $metodo = array('SolicitudEventoSignificativo'=> $parametros);
      
      $resultado = $client->__soapCall('registroEventoSignificativo', array($metodo));
      $codigoRecepcionEventoSignificativo = null;
      if($resultado->RespuestaListaEventos->transaccion){
            $codigoRecepcionEventoSignificativo = $resultado->RespuestaListaEventos->codigoRecepcionEventoSignificativo;
          $salida = true;
        }
        elseif($resultado->RespuestaListaEventos->transaccion == false){
          $salida = false;
          echo 'ERROR: FALSE';
          var_dump($resultado->RespuestaListaEventos);
        }else{
          $salida = false;
          echo 'Error desconocido.';
        }
      if(!is_null($codigoRecepcionEventoSignificativo)){
        // GENERAR LOS ARCHIVOS XML
        $i=1;
        $total_fact_xml = $nro_peticiones;
        while($i<=$total_fact_xml){
      
          $xml = new DomDocument('1.0', 'UTF-8');
          $xml->xmlStandalone = true;
          $facturaElectronicaServicioBasico = $xml->createElement('facturaElectronicaServicioBasico');
          $facturaElectronicaServicioBasico = $xml->appendChild($facturaElectronicaServicioBasico);
          $facturaElectronicaServicioBasico->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
          $facturaElectronicaServicioBasico->setAttribute('xsi:noNamespaceSchemaLocation', 'facturaElectronicaServicioBasico.xsd');
                
          $cabecera = $xml->createElement('cabecera');
          $cabecera = $facturaElectronicaServicioBasico->appendChild($cabecera);
                    
          $nitEmisor = $xml->createElement('nitEmisor',$this->config->item('nit'));
          $nitEmisor = $cabecera->appendChild($nitEmisor);
          
          $razonSocialEmisor = $xml->createElement('razonSocialEmisor',$this->config->item('razonSocial'));
          $razonSocialEmisor = $cabecera->appendChild($razonSocialEmisor);
          
          $municipio = $xml->createElement('municipio',$this->config->item('municipio'));
          $municipio = $cabecera->appendChild($municipio);
          
          $telefono = $xml->createElement('telefono',$this->config->item('telefono'));
          $telefono = $cabecera->appendChild($telefono);
          
          $nro_factura=1;//Extraer nro factura
          $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
          $numeroFactura = $cabecera->appendChild($numeroFactura);
                
          //para el CUF
          $tipo_emision = 2;
          $tipo_factura = 1;
          $tipo_doc_sector = 13;
          
          $res_concat = concatenar_ceros($this->config->item('nit'), date("YmdHisv"),$pv['codigo_sucursal'],$this->config->item('codigoModalidad'),$tipo_emision,$tipo_factura,$tipo_doc_sector,$nro_factura,$pv['codigo_punto_venta']);
          $res_m_11 = mod_11($res_concat,1,9,false);
          $res_str_16 = strtoupper(str_16($res_concat.$res_m_11));
          $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
      
          $cuf = $xml->createElement('cuf',$res_str_16.$cuf_act['codigo_control']);
          $cuf = $cabecera->appendChild($cuf);
          //Fin CUF
          
          $cufd = $xml->createElement('cufd',$cuf_act['codigo']);
          $cufd = $cabecera->appendChild($cufd);
          
          $codigoSucursal = $xml->createElement('codigoSucursal',$pv['codigo_sucursal']);
          $codigoSucursal = $cabecera->appendChild($codigoSucursal);
          
          $direccion = $xml->createElement('direccion',$this->config->item('direccion'));
          $direccion = $cabecera->appendChild($direccion);
          
          if($pv['codigo_punto_venta']==0){
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta');//element vacio
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
            $codigoPuntoVenta->setAttribute('xsi:nil', 'true');  
          }else{
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta',$pv['codigo_punto_venta']);
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
          }
  
          $mes = $xml->createElement('mes','SEPTIEMBRE');
          $mes = $cabecera->appendChild($mes);
    
          $gestion = $xml->createElement('gestion',date('Y'));
          $gestion = $cabecera->appendChild($gestion);
    
          $ciudad = $xml->createElement('ciudad',$this->config->item('ciudad'));
          $ciudad = $cabecera->appendChild($ciudad);
    
          $zona = $xml->createElement('zona','Zona cliente');
          $zona = $cabecera->appendChild($zona);
    
          $numeroMedidor = $xml->createElement('numeroMedidor','21');
          $numeroMedidor = $cabecera->appendChild($numeroMedidor);
    
          $fechaEmision = $xml->createElement('fechaEmision',date("Y-m-d\TH:i:s.v"));
          $fechaEmision = $cabecera->appendChild($fechaEmision);
    
          $razon_social_cliente = 'Carmelo Molina';
          $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
          $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);
    
          $domicilioCliente_cliente = 'TTe. leon y litoral nro 933';
          $domicilioCliente = $xml->createElement('domicilioCliente',$domicilioCliente_cliente);
          $domicilioCliente = $cabecera->appendChild($domicilioCliente);
    
          $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad','1');
          $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);
    
          $nro_doc_cliente=4043274;
          $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc_cliente);
          $numeroDocumento = $cabecera->appendChild($numeroDocumento);
    
          $complemento = $xml->createElement('complemento');//element vacio
          $complemento = $cabecera->appendChild($complemento);
          $complemento->setAttribute('xsi:nil', 'true');
    
          $codigoCliente = $xml->createElement('codigoCliente','51158891');
          $codigoCliente = $cabecera->appendChild($codigoCliente);
    
          $codigoMetodoPago = $xml->createElement('codigoMetodoPago','1');
          $codigoMetodoPago = $cabecera->appendChild($codigoMetodoPago);
    
          $numeroTarjeta = $xml->createElement('numeroTarjeta');//element vacio
          $numeroTarjeta = $cabecera->appendChild($numeroTarjeta);
          $numeroTarjeta->setAttribute('xsi:nil', 'true');
    
          $montoTotal = $xml->createElement('montoTotal','124.50');
          $montoTotal = $cabecera->appendChild($montoTotal);
    
          $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva','110');
          $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);
    
          $consumoPeriodo = $xml->createElement('consumoPeriodo');//element vacio
          $consumoPeriodo = $cabecera->appendChild($consumoPeriodo);
          $consumoPeriodo->setAttribute('xsi:nil', 'true');
    
          $beneficiarioLey1886 = $xml->createElement('beneficiarioLey1886');//element vacio
          $beneficiarioLey1886 = $cabecera->appendChild($beneficiarioLey1886);
          $beneficiarioLey1886->setAttribute('xsi:nil', 'true');
    
          $montoDescuentoLey1886 = $xml->createElement('montoDescuentoLey1886');//element vacio
          $montoDescuentoLey1886 = $cabecera->appendChild($montoDescuentoLey1886);
          $montoDescuentoLey1886->setAttribute('xsi:nil', 'true');
    
          $montoDescuentoTarifaDignidad = $xml->createElement('montoDescuentoTarifaDignidad');//element vacio
          $montoDescuentoTarifaDignidad = $cabecera->appendChild($montoDescuentoTarifaDignidad);
          $montoDescuentoTarifaDignidad->setAttribute('xsi:nil', 'true');
    
          $tasaAseo = $xml->createElement('tasaAseo','5');
          $tasaAseo = $cabecera->appendChild($tasaAseo);
    
          $tasaAlumbrado = $xml->createElement('tasaAlumbrado','2');
          $tasaAlumbrado = $cabecera->appendChild($tasaAlumbrado);
    
          $ajusteNoSujetoIva = $xml->createElement('ajusteNoSujetoIva','5');
          $ajusteNoSujetoIva = $cabecera->appendChild($ajusteNoSujetoIva);
    
          $detalleAjusteNoSujetoIva = $xml->createElement('detalleAjusteNoSujetoIva','{"Ajuste por Reclamo":5}');
          $detalleAjusteNoSujetoIva = $cabecera->appendChild($detalleAjusteNoSujetoIva);
    
          $ajusteSujetoIva = $xml->createElement('ajusteSujetoIva','10');
          $ajusteSujetoIva = $cabecera->appendChild($ajusteSujetoIva);
    
          $detalleAjusteSujetoIva = $xml->createElement('detalleAjusteSujetoIva','{"Cobropor Reconexión":10}');
          $detalleAjusteSujetoIva = $cabecera->appendChild($detalleAjusteSujetoIva);
    
          $otrosPagosNoSujetoIva = $xml->createElement('otrosPagosNoSujetoIva','7');
          $otrosPagosNoSujetoIva = $cabecera->appendChild($otrosPagosNoSujetoIva);
    
          $detalleOtrosPagosNoSujetoIva = $xml->createElement('detalleOtrosPagosNoSujetoIva','{"Pago Cuota Cooperativa":7}');
          $detalleOtrosPagosNoSujetoIva = $cabecera->appendChild($detalleOtrosPagosNoSujetoIva);
    
          $otrasTasas = $xml->createElement('otrasTasas','0.50');
          $otrasTasas = $cabecera->appendChild($otrasTasas);
    
          $codigoMoneda = $xml->createElement('codigoMoneda','1');
          $codigoMoneda = $cabecera->appendChild($codigoMoneda);
    
          $tipoCambio = $xml->createElement('tipoCambio','1');
          $tipoCambio = $cabecera->appendChild($tipoCambio);
    
          $montoTotalMoneda = $xml->createElement('montoTotalMoneda','124.50');
          $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);
    
          $descuentoAdicional = $xml->createElement('descuentoAdicional');//element vacio
          $descuentoAdicional = $cabecera->appendChild($descuentoAdicional);
          $descuentoAdicional->setAttribute('xsi:nil', 'true');
    
          $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
          $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
          $codigoExcepcion->setAttribute('xsi:nil', 'true');
    
          $cafc = $xml->createElement('cafc');//element vacio
          $cafc = $cabecera->appendChild($cafc);
          $cafc->setAttribute('xsi:nil', 'true');
    
          $leyenda = $xml->createElement('leyenda','Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.');
          $leyenda = $cabecera->appendChild($leyenda);
    
          $usuario = $xml->createElement('usuario','pperez');
          $usuario = $cabecera->appendChild($usuario);
    
          $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','13');
          $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);
      
          //DETALLE
          $detalle = $xml->createElement('detalle');
          $detalle = $facturaElectronicaServicioBasico->appendChild($detalle);
    
          $actividadEconomica = $xml->createElement('actividadEconomica','351000');//sacar de sincronizacion
          $actividadEconomica = $detalle->appendChild($actividadEconomica);
    
          $codigoProductoSin = $xml->createElement('codigoProductoSin','86311');//sacar de producto homolgar
          $codigoProductoSin = $detalle->appendChild($codigoProductoSin);
    
          $codigoProducto = $xml->createElement('codigoProducto','12345');//propio codigo
          $codigoProducto = $detalle->appendChild($codigoProducto);
    
          $descripcion = $xml->createElement('descripcion','Servicio Mes agosto');
          $descripcion = $detalle->appendChild($descripcion);
    
          $cantidad = $xml->createElement('cantidad','1');
          $cantidad = $detalle->appendChild($cantidad);
    
          $unidadMedida = $xml->createElement('unidadMedida','1');
          $unidadMedida = $detalle->appendChild($unidadMedida);
    
          $precioUnitario = $xml->createElement('precioUnitario','100');
          $precioUnitario = $detalle->appendChild($precioUnitario);
    
          $montoDescuento = $xml->createElement('montoDescuento','0');
          $montoDescuento = $detalle->appendChild($montoDescuento);
    
          $subTotal = $xml->createElement('subTotal','100');
          $subTotal = $detalle->appendChild($subTotal);
      
          $xml->formatOutput = true;
          $xml->save('facturas/off_line_'.$i.'.xml');
          $fir = new FirmarXml();
          $fir->firmar('facturas/off_line_'.$i.'.xml');//$res_str_16.$cuf_act['codigo_control']
  
          usleep(10000);//250000 100000 
          $i++;
        }// fin while

        $p = new PharData('./facturas/final_'.$k.'.tar');
        for($i=1;$i<=$total_fact_xml;$i++)
        $p['off_line_'.$i.'_firmado.xml'] = file_get_contents('./facturas/off_line_'.$i.'_firmado.xml');
        
        $p->compress(Phar::GZ);
        unlink('./facturas/final_'.$k.'.tar');

          //Enviando la solicitud
          $wsdl = $this->config->item('endPoint_FacturaServiciosBasicos');
          $token = $this->config->item('token');
          $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
          $context = stream_context_create($opts);
          $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
          
          $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
          $parametros = array(
              'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
              'codigoDocumentoSector' => '13', 
              'codigoEmision' => '2', 
              'codigoModalidad' => $this->config->item('codigoModalidad'), 
              'codigoPuntoVenta' => $pv['codigo_punto_venta'],
              'codigoSistema' => $this->config->item('codigoSistema'),
              'codigoSucursal' => $pv['codigo_sucursal'],
              'cufd' => $cuf_act['codigo'],
              'cuis' => $cuis['cuis_codigo'],
              'nit' => $this->config->item('nit'),
              'tipoFacturaDocumento' => '1', 
              
              'cafc' => '113ACA30EC11D',
              'descripcion' => $ev['descripcion'],
              'archivo' => file_get_contents('facturas/final_'.$k.'.tar.gz'),
              'hashArchivo' => hash_file('sha256', 'facturas/final_'.$k.'.tar.gz'),
              'cantidadFacturas' => $total_fact_xml,
              'fechaEnvio' => date("Y-m-d\TH:i:s.v"), 
              'codigoEvento' => $codigoRecepcionEventoSignificativo,//Codigo del evento registrado anteriormente 
              'codigoRecepcionEvento' => $codigoRecepcionEventoSignificativo,//Codigo del evento registrado anteriormente 
              );
              //var_dump($parametros);
              
          $metodo = array('SolicitudServicioRecepcionPaquete'=> $parametros);
          $resultado = $client->__soapCall('recepcionPaqueteFactura', array($metodo));
          $codigoRecepcion = null;
            if($resultado->RespuestaServicioFacturacion->transaccion){
              var_dump($resultado->RespuestaServicioFacturacion);
              echo 'paquete enviado exitosamente';
              $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
              $salida = true;
            }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
              $salida = false;
              echo 'ERROR: FALSE';
              var_dump($resultado->RespuestaServicioFacturacion);
            }else{
              $salida = false;
              echo 'Error desconocido.';
            }

            /* VERIFICACION PAQUETE */
            if(!is_null($codigoRecepcion)){
              //Enviando la solicitud
              $wsdl = $this->config->item('endPoint_FacturaServiciosBasicos');
              $token = $this->config->item('token');
              $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
              $context = stream_context_create($opts);
              $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
              
              $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
              $parametros = array(
                  'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
                  'codigoDocumentoSector' => '13', 
                  'codigoEmision' => '2', 
                  'codigoModalidad' => $this->config->item('codigoModalidad'), 
                  'codigoPuntoVenta' => $pv['codigo_punto_venta'],
                  'codigoSistema' => $this->config->item('codigoSistema'),
                  'codigoSucursal' => $pv['codigo_sucursal'],
                  'cufd' => $cuf_act['codigo'],
                  'cuis' => $cuis['cuis_codigo'],
                  'nit' => $this->config->item('nit'),
                  'tipoFacturaDocumento' => '1', 
                  'codigoRecepcion' => $codigoRecepcion,//Codigo del evento registrado anteriormente 
                  );
                  //var_dump($parametros);
                  
              $metodo = array('SolicitudServicioValidacionRecepcionPaquete'=> $parametros);
              $resultado = $client->__soapCall('validacionRecepcionPaqueteFactura', array($metodo));
                if($resultado->RespuestaServicioFacturacion->transaccion){
                  var_dump($resultado->RespuestaServicioFacturacion);
                  echo 'Validacion exitosamente<br>';
                  $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
                  for ($i=1; $i <=$total_fact_xml ; $i++) { 
                    unlink('./facturas/off_line_'.$i.'.xml');
                    unlink('./facturas/off_line_'.$i.'_firmado.xml');
                  }
                  unlink('./facturas/final_'.$k.'.tar.gz');
                  echo 'Eliminación archivos exitosamente';
                }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
                  $salida = false;
                  echo 'ERROR: FALSE';
                  var_dump($resultado->RespuestaServicioFacturacion);
                }else{
                  $salida = false;
                  echo 'Error desconocido.';
                }
            }else{
              echo 'ERROR el codigoRecepcion es null';
            }

      }else{//fin error evento
          echo 'Error en evento registrado';
          }
          $k++;
          if(((int)$pv['codigo_punto_venta'])==1)
            sleep(10);
          else 
            sleep(20);
        }//fin while K
    }//fin if admin
    else
      redirect(base_url());
  }//fin funcion    

  /* PAQUETES  13 */
  public function genera_paquete_xml_22(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['eventos'] = $this->parametrica_evento_significativo_model->get_all();

      $data['main_content'] = 'sf_sin/genera_paquete_xml_22_view';
      $data['title'] = 'Emisión de paquetes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function generar_paquete_xml_22(){
    if(isAdmin()){

      //recepción de post
      $n = $this->input->post('peticiones');
      $k=1;
      while($k<=$n){
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      $ev = $this->parametrica_evento_significativo_model->get_parametrica_evento_significativo($this->input->post('id_parametrica_evento_significativo'));
      
      /* REGISTRO EVENTO*/
        //para el CUF
        $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
        
      $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);

      $wsdl = $this->config->item('endPoint_FacturacionOperaciones');
      $token = $this->config->item('token');
      $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
      $context = stream_context_create($opts);
      $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
      
      $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
      $parametros = array(
          'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
          'codigoMotivoEvento' => $ev['codigo_clasificador'], 
          'codigoPuntoVenta' => $pv['codigo_punto_venta'],
          'codigoSistema' => $this->config->item('codigoSistema'),
          'codigoSucursal' => $pv['codigo_sucursal'],
          'cufd' => $cuf_act['codigo'],
          'cufdEvento' => $cuf_act['codigo'],
          'cuis' => $cuis['cuis_codigo'],
          'descripcion' => $ev['descripcion'],
          'fechaHoraFinEvento' => date("Y-m-d\TH:i:10.000"),
          'fechaHoraInicioEvento' => date("Y-m-d\TH:i:01.000"),
          'nit' => $this->config->item('nit')
          );
      
      $metodo = array('SolicitudEventoSignificativo'=> $parametros);
      
      
      $resultado = $client->__soapCall('registroEventoSignificativo', array($metodo));
      $codigoRecepcionEventoSignificativo = null;
      if($resultado->RespuestaListaEventos->transaccion){
            $codigoRecepcionEventoSignificativo = $resultado->RespuestaListaEventos->codigoRecepcionEventoSignificativo;
          $salida = true;
        }
        elseif($resultado->RespuestaListaEventos->transaccion == false){
          $salida = false;
          echo 'ERROR: FALSE';
          var_dump($resultado->RespuestaListaEventos);
        }else{
          $salida = false;
          echo 'Error desconocido.';
        }
      if(!is_null($codigoRecepcionEventoSignificativo)){
        // GENERAR LOS ARCHIVOS XML
        $i=1;
        $total_fact_xml = $nro_peticiones;
        while($i<=$total_fact_xml){
      
          $xml = new DomDocument('1.0', 'UTF-8');
          $xml->xmlStandalone = true;
          $facturaElectronicaTelecomunicacion = $xml->createElement('facturaElectronicaTelecomunicacion');
          $facturaElectronicaTelecomunicacion = $xml->appendChild($facturaElectronicaTelecomunicacion);
          $facturaElectronicaTelecomunicacion->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
          $facturaElectronicaTelecomunicacion->setAttribute('xsi:noNamespaceSchemaLocation', 'facturaElectronicaTelecomunicacion.xsd');
                  
          $cabecera = $xml->createElement('cabecera');
          $cabecera = $facturaElectronicaTelecomunicacion->appendChild($cabecera);
                      
          $nitEmisor = $xml->createElement('nitEmisor',$this->config->item('nit'));
          $nitEmisor = $cabecera->appendChild($nitEmisor);
          
          $razonSocialEmisor = $xml->createElement('razonSocialEmisor',$this->config->item('razonSocial'));
          $razonSocialEmisor = $cabecera->appendChild($razonSocialEmisor);
          
          $municipio = $xml->createElement('municipio',$this->config->item('municipio'));
          $municipio = $cabecera->appendChild($municipio);
          
          $telefono = $xml->createElement('telefono',$this->config->item('telefono'));
          $telefono = $cabecera->appendChild($telefono);
  
          $nitConjunto = $xml->createElement('nitConjunto');//element vacio
          $nitConjunto = $cabecera->appendChild($nitConjunto);
          $nitConjunto->setAttribute('xsi:nil', 'true');
            
          $nro_factura=1;//Extraer nro factura
          $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
          $numeroFactura = $cabecera->appendChild($numeroFactura);
                
          //para el CUF
          $tipo_emision = 2;
          $tipo_factura = 1;
          $tipo_doc_sector = 22;
          
          $res_concat = concatenar_ceros($this->config->item('nit'), date("YmdHisv"),$pv['codigo_sucursal'],$this->config->item('codigoModalidad'),$tipo_emision,$tipo_factura,$tipo_doc_sector,$nro_factura,$pv['codigo_punto_venta']);
          $res_m_11 = mod_11($res_concat,1,9,false);
          $res_str_16 = strtoupper(str_16($res_concat.$res_m_11));
          $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
      
          $cuf = $xml->createElement('cuf',$res_str_16.$cuf_act['codigo_control']);
          $cuf = $cabecera->appendChild($cuf);
          //Fin CUF
          
          $cufd = $xml->createElement('cufd',$cuf_act['codigo']);
          $cufd = $cabecera->appendChild($cufd);
          
          $codigoSucursal = $xml->createElement('codigoSucursal',$pv['codigo_sucursal']);
          $codigoSucursal = $cabecera->appendChild($codigoSucursal);
          
          $direccion = $xml->createElement('direccion',$this->config->item('direccion'));
          $direccion = $cabecera->appendChild($direccion);
            
          if($pv['codigo_punto_venta']==0){
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta');//element vacio
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
            $codigoPuntoVenta->setAttribute('xsi:nil', 'true');  
          }else{
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta',$pv['codigo_punto_venta']);
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
          }
      
          $fechaEmision = $xml->createElement('fechaEmision',date("Y-m-d\TH:i:s.v"));
          $fechaEmision = $cabecera->appendChild($fechaEmision);
    
          $razon_social_cliente = 'Carmelo Molina';
          $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
          $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);
    
          $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad','1');
          $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);
    
          $nro_doc_cliente=4043274;
          $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc_cliente);
          $numeroDocumento = $cabecera->appendChild($numeroDocumento);
    
          $complemento = $xml->createElement('complemento');//element vacio
          $complemento = $cabecera->appendChild($complemento);
          $complemento->setAttribute('xsi:nil', 'true');
    
          $codigoCliente = $xml->createElement('codigoCliente','51158891');
          $codigoCliente = $cabecera->appendChild($codigoCliente);
    
          $codigoMetodoPago = $xml->createElement('codigoMetodoPago','1');
          $codigoMetodoPago = $cabecera->appendChild($codigoMetodoPago);
    
          $numeroTarjeta = $xml->createElement('numeroTarjeta');//element vacio
          $numeroTarjeta = $cabecera->appendChild($numeroTarjeta);
          $numeroTarjeta->setAttribute('xsi:nil', 'true');
    
          $montoTotal = $xml->createElement('montoTotal','100');
          $montoTotal = $cabecera->appendChild($montoTotal);
  
          $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva','100');
          $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);
          
          $codigoMoneda = $xml->createElement('codigoMoneda','1');
          $codigoMoneda = $cabecera->appendChild($codigoMoneda);
    
          $tipoCambio = $xml->createElement('tipoCambio','1');
          $tipoCambio = $cabecera->appendChild($tipoCambio);
    
          $montoTotalMoneda = $xml->createElement('montoTotalMoneda','100');
          $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);
      
          $montoGiftCard = $xml->createElement('montoGiftCard');//element vacio
          $montoGiftCard = $cabecera->appendChild($montoGiftCard);
          $montoGiftCard->setAttribute('xsi:nil', 'true');
  
          $descuentoAdicional = $xml->createElement('descuentoAdicional');//element vacio
          $descuentoAdicional = $cabecera->appendChild($descuentoAdicional);
          $descuentoAdicional->setAttribute('xsi:nil', 'true');
  
          $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
          $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
          $codigoExcepcion->setAttribute('xsi:nil', 'true');
      
          $cafc = $xml->createElement('cafc');//element vacio
          $cafc = $cabecera->appendChild($cafc);
          $cafc->setAttribute('xsi:nil', 'true');
    
          $leyenda = $xml->createElement('leyenda','Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.');
          $leyenda = $cabecera->appendChild($leyenda);
    
          $usuario = $xml->createElement('usuario','pperez');
          $usuario = $cabecera->appendChild($usuario);
    
          $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','22');
          $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);
      
          //DETALLE
          $detalle = $xml->createElement('detalle');
          $detalle = $facturaElectronicaTelecomunicacion->appendChild($detalle);
      
          $actividadEconomica = $xml->createElement('actividadEconomica','351000');//sacar de sincronizacion
          $actividadEconomica = $detalle->appendChild($actividadEconomica);
  
          $codigoProductoSin = $xml->createElement('codigoProductoSin','86311');//sacar de producto homolgar
          $codigoProductoSin = $detalle->appendChild($codigoProductoSin);
  
          $codigoProducto = $xml->createElement('codigoProducto','12345');//propio codigo
          $codigoProducto = $detalle->appendChild($codigoProducto);
  
          $descripcion = $xml->createElement('descripcion','PAGO DE MES DE ABRIL DE POSTPAGO');
          $descripcion = $detalle->appendChild($descripcion);
  
          $cantidad = $xml->createElement('cantidad','1');
          $cantidad = $detalle->appendChild($cantidad);
  
          $unidadMedida = $xml->createElement('unidadMedida','1');
          $unidadMedida = $detalle->appendChild($unidadMedida);
  
          $precioUnitario = $xml->createElement('precioUnitario','100');
          $precioUnitario = $detalle->appendChild($precioUnitario);
  
          $montoDescuento = $xml->createElement('montoDescuento','0');
          $montoDescuento = $detalle->appendChild($montoDescuento);
  
          $subTotal = $xml->createElement('subTotal','100');
          $subTotal = $detalle->appendChild($subTotal);
  
          $numeroSerie = $xml->createElement('numeroSerie','67755FD');
          $numeroSerie = $detalle->appendChild($numeroSerie);
  
          $numeroImei = $xml->createElement('numeroImei','44100');
          $numeroImei = $detalle->appendChild($numeroImei);
        
          $xml->formatOutput = true;
          $xml->save('facturas/off_line_'.$i.'.xml');
          $fir = new FirmarXml();
          $fir->firmar('facturas/off_line_'.$i.'.xml');//$res_str_16.$cuf_act['codigo_control']
  
          usleep(10000);//250000 100000 
          $i++;
        }// fin while

        $p = new PharData('./facturas/final_'.$k.'.tar');
        for($i=1;$i<=$total_fact_xml;$i++)
        $p['off_line_'.$i.'_firmado.xml'] = file_get_contents('./facturas/off_line_'.$i.'_firmado.xml');
        
        $p->compress(Phar::GZ);
        unlink('./facturas/final_'.$k.'.tar');

          //Enviando la solicitud
          $wsdl = $this->config->item('endPoint_FacturaTelecomunicaciones');
          $token = $this->config->item('token');
          $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
          $context = stream_context_create($opts);
          $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
          
          $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
          $parametros = array(
              'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
              'codigoDocumentoSector' => '22', 
              'codigoEmision' => '2', 
              'codigoModalidad' => $this->config->item('codigoModalidad'), 
              'codigoPuntoVenta' => $pv['codigo_punto_venta'],
              'codigoSistema' => $this->config->item('codigoSistema'),
              'codigoSucursal' => $pv['codigo_sucursal'],
              'cufd' => $cuf_act['codigo'],
              'cuis' => $cuis['cuis_codigo'],
              'nit' => $this->config->item('nit'),
              'tipoFacturaDocumento' => '1', 
              
              'cafc' => '122E8C1918E0D',
              'descripcion' => $ev['descripcion'],
              'archivo' => file_get_contents('facturas/final_'.$k.'.tar.gz'),
              'hashArchivo' => hash_file('sha256', 'facturas/final_'.$k.'.tar.gz'),
              'cantidadFacturas' => $total_fact_xml,
              'fechaEnvio' => date("Y-m-d\TH:i:s.v"), 
              'codigoEvento' => $codigoRecepcionEventoSignificativo,//Codigo del evento registrado anteriormente 
              'codigoRecepcionEvento' => $codigoRecepcionEventoSignificativo,//Codigo del evento registrado anteriormente 
              );
              //var_dump($parametros);
              
          $metodo = array('SolicitudServicioRecepcionPaquete'=> $parametros);
          $resultado = $client->__soapCall('recepcionPaqueteFactura', array($metodo));
          $codigoRecepcion = null;
            if($resultado->RespuestaServicioFacturacion->transaccion){
              var_dump($resultado->RespuestaServicioFacturacion);
              echo 'paquete enviado exitosamente';
              $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
              $salida = true;
            }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
              $salida = false;
              echo 'ERROR: FALSE';
              var_dump($resultado->RespuestaServicioFacturacion);
            }else{
              $salida = false;
              echo 'Error desconocido.';
            }

            /* VERIFICACION PAQUETE */
            if(!is_null($codigoRecepcion)){
              //Enviando la solicitud
              $wsdl = $this->config->item('endPoint_FacturaTelecomunicaciones');
              $token = $this->config->item('token');
              $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
              $context = stream_context_create($opts);
              $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
              
              $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
              $parametros = array(
                  'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
                  'codigoDocumentoSector' => '22', 
                  'codigoEmision' => '2', 
                  'codigoModalidad' => $this->config->item('codigoModalidad'), 
                  'codigoPuntoVenta' => $pv['codigo_punto_venta'],
                  'codigoSistema' => $this->config->item('codigoSistema'),
                  'codigoSucursal' => $pv['codigo_sucursal'],
                  'cufd' => $cuf_act['codigo'],
                  'cuis' => $cuis['cuis_codigo'],
                  'nit' => $this->config->item('nit'),
                  'tipoFacturaDocumento' => '1', 
                  'codigoRecepcion' => $codigoRecepcion,//Codigo del evento registrado anteriormente 
                  );
                  //var_dump($parametros);
                  
              $metodo = array('SolicitudServicioValidacionRecepcionPaquete'=> $parametros);
              $resultado = $client->__soapCall('validacionRecepcionPaqueteFactura', array($metodo));
                if($resultado->RespuestaServicioFacturacion->transaccion){
                  var_dump($resultado->RespuestaServicioFacturacion);
                  echo 'Validacion exitosamente<br>';
                  $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
                  for ($i=1; $i <=$total_fact_xml ; $i++) { 
                    unlink('./facturas/off_line_'.$i.'.xml');
                    unlink('./facturas/off_line_'.$i.'_firmado.xml');
                  }
                  unlink('./facturas/final_'.$k.'.tar.gz');
                  echo 'Eliminación archivos exitosamente';
                }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
                  $salida = false;
                  echo 'ERROR: FALSE';
                  var_dump($resultado->RespuestaServicioFacturacion);
                }else{
                  $salida = false;
                  echo 'Error desconocido.';
                }
            }else{
              echo 'ERROR el codigoRecepcion es null';
            }

      }else{//fin error evento
          echo 'Error en evento registrado';
          }
          $k++;
          if(((int)$pv['codigo_punto_venta'])==1)
            sleep(10);
          else 
            sleep(20);
        }//fin while K
    }//fin if admin
    else
      redirect(base_url());
  }//fin funcion    

  /* PARA CONSUMO DE FACTURA INDIVIDUAL*/
  public function anul_factura(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['doc_sec'] = $doc_sec = $this->parametrica_tipo_documento_sector_model->get_all();
      $data['motivos'] = $motivos = $this->parametrica_motivo_anulacion_model->get_all();

      $data['main_content'] = 'sf_sin/anul_factura_view';
      $data['title'] = 'Factura indivicual';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function anular_factura(){//compra venta
    if(isAdmin()){

      //recepción de post    
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      $doc_sec = $this->parametrica_tipo_documento_sector_model->get_parametrica_tipo_documento_sector($this->input->post('id_parametrica_tipo_documento_sector'));
      $motivo = $this->parametrica_motivo_anulacion_model->get_parametrica_motivo_anulacion($this->input->post('id_parametrica_motivo_anulacion'));
      
      $i=1;
      $salida = false;
      //while($i<=$nro_peticiones)
      $facturas = $this->factura_model->get_punto_venta($this->input->post('id_punto_venta'));
      foreach ($facturas as $key => $fact){

        $cufd_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);

        //Enviando la solicitud
        switch ($doc_sec['codigo_clasificador']) {
          case 1: $wsdl = $this->config->item('ServicioFacturacionCompraVenta'); break;
          case 13: $wsdl = $this->config->item('endPoint_FacturaServiciosBasicos'); break;
          case 22: $wsdl = $this->config->item('endPoint_FacturaTelecomunicaciones'); break;          
        }
        //$wsdl = $this->config->item('ServicioFacturacionCompraVenta');
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
            'cufd' => $cufd_act['codigo'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit'),
            'tipoFacturaDocumento' => '1', 
            
            'codigoMotivo' => $motivo['codigo_clasificador'], 
            'cuf' => $fact['cuf']
            );
            //var_dump($parametros);
        $metodo = array('SolicitudServicioAnulacionFactura'=> $parametros);
        $resultado = $client->__soapCall('anulacionFactura', array($metodo));

        if($resultado->RespuestaServicioFacturacion->transaccion){
          $this->factura_model->eliminar($fact['id_factura']);
          $salida = true;
        }
        elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
          $salida = false;
          echo 'ERROR: FALSE';
          var_dump($resultado->RespuestaServicioFacturacion);
        }else{
          $salida = false;
          echo 'Error desconocido.';
        }
        //sleep(1);
        
      }// fin while
      if($salida)
        echo count($facturas).' facturas anuladas existosa(s).';

    }//fin if admin
    else
      redirect(base_url());
  }//fin funcion

/* ENVIO MASIVO*/  
  public function genera_masivo_xml(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;
      $data['eventos'] = $this->parametrica_evento_significativo_model->get_all();

      $data['main_content'] = 'sf_sin/genera_masivo_xml_view';
      $data['title'] = 'Emisión de paquetes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function generar_masivo_xml(){
    if(isAdmin()){

      //recepción de post
      $n = $this->input->post('peticiones');
      $k=1;
      while($k<=$n){
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      /* REGISTRO EVENTO*/
        //para el CUF
        $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);

        // GENERAR LOS ARCHIVOS XML
        $i=1;
        $total_fact_xml = $nro_peticiones;
        while($i<=$total_fact_xml){
      
          $xml = new DomDocument('1.0', 'UTF-8');
          $xml->xmlStandalone = true;
          $facturaElectronicaCompraVenta = $xml->createElement('facturaElectronicaCompraVenta');
          $facturaElectronicaCompraVenta = $xml->appendChild($facturaElectronicaCompraVenta);
          $facturaElectronicaCompraVenta->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
          $facturaElectronicaCompraVenta->setAttribute('xsi:noNamespaceSchemaLocation', 'facturaElectronicaCompraVenta.xsd');
            
          $cabecera = $xml->createElement('cabecera');
          $cabecera = $facturaElectronicaCompraVenta->appendChild($cabecera);
                
          $nitEmisor = $xml->createElement('nitEmisor',$this->config->item('nit'));
          $nitEmisor = $cabecera->appendChild($nitEmisor);
          
          $razonSocialEmisor = $xml->createElement('razonSocialEmisor',$this->config->item('razonSocial'));
          $razonSocialEmisor = $cabecera->appendChild($razonSocialEmisor);
          
          $municipio = $xml->createElement('municipio',$this->config->item('municipio'));
          $municipio = $cabecera->appendChild($municipio);
          
          $telefono = $xml->createElement('telefono',$this->config->item('telefono'));
          $telefono = $cabecera->appendChild($telefono);
          
          $nro_factura=1;//Extraer nro factura
          $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
          $numeroFactura = $cabecera->appendChild($numeroFactura);
            
          //para el CUF
          $tipo_emision = 3;//emision masiva
          $tipo_factura = 1;
          $tipo_doc_sector = 1;
          
          $res_concat = concatenar_ceros($this->config->item('nit'), date("YmdHisv"),$pv['codigo_sucursal'],$this->config->item('codigoModalidad'),$tipo_emision,$tipo_factura,$tipo_doc_sector,$nro_factura,$pv['codigo_punto_venta']);
          $res_m_11 = mod_11($res_concat,1,9,false);
          $res_str_16 = strtoupper(str_16($res_concat.$res_m_11));
          $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
      
          $cuf = $xml->createElement('cuf',$res_str_16.$cuf_act['codigo_control']);
          $cuf = $cabecera->appendChild($cuf);
          //Fin CUF
          
          $cufd = $xml->createElement('cufd',$cuf_act['codigo']);
          $cufd = $cabecera->appendChild($cufd);
          
          $codigoSucursal = $xml->createElement('codigoSucursal',$pv['codigo_sucursal']);
          $codigoSucursal = $cabecera->appendChild($codigoSucursal);
          
          $direccion = $xml->createElement('direccion',$this->config->item('direccion'));
          $direccion = $cabecera->appendChild($direccion);
          
          if($pv['codigo_punto_venta']==0){
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta');//element vacio
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
            $codigoPuntoVenta->setAttribute('xsi:nil', 'true');  
          }else{
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta',$pv['codigo_punto_venta']);
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
          }
  
          $fechaEmision = $xml->createElement('fechaEmision',date("Y-m-d\TH:i:s.v"));
          $fechaEmision = $cabecera->appendChild($fechaEmision);
  
          $razon_social_cliente = 'Carmelo Molina';
          $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
          $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);
  
          $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad','1');
          $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);
  
          $nro_doc_cliente=4043274;
          $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc_cliente);
          $numeroDocumento = $cabecera->appendChild($numeroDocumento);
    
          $complemento = $xml->createElement('complemento');//element vacio
          $complemento = $cabecera->appendChild($complemento);
          $complemento->setAttribute('xsi:nil', 'true');
  
          $codigoCliente = $xml->createElement('codigoCliente','51158891');
          $codigoCliente = $cabecera->appendChild($codigoCliente);
  
          $codigoMetodoPago = $xml->createElement('codigoMetodoPago','1');
          $codigoMetodoPago = $cabecera->appendChild($codigoMetodoPago);
  
          $numeroTarjeta = $xml->createElement('numeroTarjeta');//element vacio
          $numeroTarjeta = $cabecera->appendChild($numeroTarjeta);
          $numeroTarjeta->setAttribute('xsi:nil', 'true');
  
          $montoTotal = $xml->createElement('montoTotal','99');
          $montoTotal = $cabecera->appendChild($montoTotal);
  
          $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva','99');
          $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);
  
          $codigoMoneda = $xml->createElement('codigoMoneda','1');
          $codigoMoneda = $cabecera->appendChild($codigoMoneda);
  
          $tipoCambio = $xml->createElement('tipoCambio','1');
          $tipoCambio = $cabecera->appendChild($tipoCambio);
  
          $montoTotalMoneda = $xml->createElement('montoTotalMoneda','99');
          $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);
  
          $montoGiftCard = $xml->createElement('montoGiftCard');//element vacio
          $montoGiftCard = $cabecera->appendChild($montoGiftCard);
          $montoGiftCard->setAttribute('xsi:nil', 'true');
  
          $descuentoAdicional = $xml->createElement('descuentoAdicional','1');
          $descuentoAdicional = $cabecera->appendChild($descuentoAdicional);
  
          $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
          $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
          $codigoExcepcion->setAttribute('xsi:nil', 'true');
  
          $cafc = $xml->createElement('cafc');
          $cafc = $cabecera->appendChild($cafc);
          $cafc->setAttribute('xsi:nil', 'true');
            
          $leyenda = $xml->createElement('leyenda','Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.');
          $leyenda = $cabecera->appendChild($leyenda);
  
          $usuario = $xml->createElement('usuario','pperez');
          $usuario = $cabecera->appendChild($usuario);
  
          $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','1');
          $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);
  
          //DETALLE
          $detalle = $xml->createElement('detalle');
          $detalle = $facturaElectronicaCompraVenta->appendChild($detalle);
    
          $actividadEconomica = $xml->createElement('actividadEconomica','351000');//sacar de sincronizacion
          $actividadEconomica = $detalle->appendChild($actividadEconomica);
  
          $codigoProductoSin = $xml->createElement('codigoProductoSin','86311');//sacar de producto homolgar
          $codigoProductoSin = $detalle->appendChild($codigoProductoSin);
  
          $codigoProducto = $xml->createElement('codigoProducto','TUL-13');//propio codigo
          $codigoProducto = $detalle->appendChild($codigoProducto);
  
          $descripcion = $xml->createElement('descripcion','JUGO DE NARANJA EN VASO');
          $descripcion = $detalle->appendChild($descripcion);
  
          $cantidad = $xml->createElement('cantidad','1');
          $cantidad = $detalle->appendChild($cantidad);
  
          $unidadMedida = $xml->createElement('unidadMedida','1');
          $unidadMedida = $detalle->appendChild($unidadMedida);
  
          $precioUnitario = $xml->createElement('precioUnitario','100');
          $precioUnitario = $detalle->appendChild($precioUnitario);
  
          $montoDescuento = $xml->createElement('montoDescuento','0');
          $montoDescuento = $detalle->appendChild($montoDescuento);
  
          $subTotal = $xml->createElement('subTotal','100');
          $subTotal = $detalle->appendChild($subTotal);
  
          $numeroSerie = $xml->createElement('numeroSerie','124548');
          $numeroSerie = $detalle->appendChild($numeroSerie);
  
          $numeroImei = $xml->createElement('numeroImei','545454');
          $numeroImei = $detalle->appendChild($numeroImei);
  
          $xml->formatOutput = true;
          $xml->save('facturas/masivo_'.$i.'.xml');
          $fir = new FirmarXml();
          $fir->firmar('facturas/masivo_'.$i.'.xml');//$res_str_16.$cuf_act['codigo_control']
  
          usleep(10000);//250000 100000 
          $i++;
        }// fin while

        $p = new PharData('./facturas/final_'.$k.'.tar');
        for($i=1;$i<=$total_fact_xml;$i++)
        $p['masivo_'.$i.'_firmado.xml'] = file_get_contents('./facturas/masivo_'.$i.'_firmado.xml');
        
        $p->compress(Phar::GZ);
        unlink('./facturas/final_'.$k.'.tar');

          //Enviando la solicitud
          $wsdl = $this->config->item('ServicioFacturacionCompraVenta');
          $token = $this->config->item('token');
          $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
          $context = stream_context_create($opts);
          $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
          
          $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
          $parametros = array(
              'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
              'codigoDocumentoSector' => '1', 
              'codigoEmision' => '3', // 3 masivo
              'codigoModalidad' => $this->config->item('codigoModalidad'), 
              'codigoPuntoVenta' => $pv['codigo_punto_venta'],
              'codigoSistema' => $this->config->item('codigoSistema'),
              'codigoSucursal' => $pv['codigo_sucursal'],
              'cufd' => $cuf_act['codigo'],
              'cuis' => $cuis['cuis_codigo'],
              'nit' => $this->config->item('nit'),
              'tipoFacturaDocumento' => '1', 
              
              'archivo' => file_get_contents('facturas/final_'.$k.'.tar.gz'),
              'hashArchivo' => hash_file('sha256', 'facturas/final_'.$k.'.tar.gz'),
              'cantidadFacturas' => $total_fact_xml,
              'fechaEnvio' => date("Y-m-d\TH:i:s.v")
              );
              //var_dump($parametros);
              
          $metodo = array('SolicitudServicioRecepcionMasiva'=> $parametros);
          $resultado = $client->__soapCall('recepcionMasivaFactura', array($metodo));
          $codigoRecepcion = null;
            if($resultado->RespuestaServicioFacturacion->transaccion){
              var_dump($resultado->RespuestaServicioFacturacion);
              echo 'masivo enviado exitosamente';
              $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
              $salida = true;
            }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
              $salida = false;
              echo 'ERROR: FALSE';
              var_dump($resultado->RespuestaServicioFacturacion);
            }else{
              $salida = false;
              echo 'Error desconocido.';
            }

            /* VERIFICACION masivo */
            if(!is_null($codigoRecepcion)){
              //Enviando la solicitud
              $wsdl = $this->config->item('ServicioFacturacionCompraVenta');
              $token = $this->config->item('token');
              $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
              $context = stream_context_create($opts);
              $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
              
              $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
              $parametros = array(
                  'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
                  'codigoDocumentoSector' => '1', 
                  'codigoEmision' => '3', //emision masiva 3
                  'codigoModalidad' => $this->config->item('codigoModalidad'), 
                  'codigoPuntoVenta' => $pv['codigo_punto_venta'],
                  'codigoSistema' => $this->config->item('codigoSistema'),
                  'codigoSucursal' => $pv['codigo_sucursal'],
                  'cufd' => $cuf_act['codigo'],
                  'cuis' => $cuis['cuis_codigo'],
                  'nit' => $this->config->item('nit'),
                  'tipoFacturaDocumento' => '1', 
                  'codigoRecepcion' => $codigoRecepcion,//Codigo del evento registrado anteriormente 
                  );
                  //var_dump($parametros);
                  
              $metodo = array('SolicitudServicioValidacionRecepcionMasiva'=> $parametros);
              $resultado = $client->__soapCall('validacionRecepcionMasivaFactura', array($metodo));
                if($resultado->RespuestaServicioFacturacion->transaccion){
                  var_dump($resultado->RespuestaServicioFacturacion);
                  echo 'Validacion exitosamente<br>';
                  $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
                  for ($i=1; $i <=$total_fact_xml ; $i++) { 
                    unlink('./facturas/masivo_'.$i.'.xml');
                    unlink('./facturas/masivo_'.$i.'_firmado.xml');
                  }
                  unlink('./facturas/final_'.$k.'.tar.gz');
                  echo 'Eliminación archivos exitosamente';
                }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
                  $salida = false;
                  echo 'ERROR: FALSE';
                  var_dump($resultado->RespuestaServicioFacturacion);
                }else{
                  $salida = false;
                  echo 'Error desconocido.';
                }
            }else{
              echo 'ERROR el codigoRecepcion es null';
            }

          $k++;
          if(((int)$pv['codigo_punto_venta'])==1)
            sleep(10);
          else 
            sleep(10);
        }//fin while K
    }//fin if admin
    else
      redirect(base_url());
  }//fin funcion

  /* ENVIO MASIVO 13 */  
  public function genera_masivo_xml_13(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;

      $data['main_content'] = 'sf_sin/genera_masivo_xml_13_view';
      $data['title'] = 'Emisión masiva servicios básicos';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function generar_masivo_xml_13(){
    if(isAdmin()){

      //recepción de post
      $n = $this->input->post('peticiones');
      $k=1;
      while($k<=$n){
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      /* REGISTRO EVENTO*/
        //para el CUF
        $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);

        // GENERAR LOS ARCHIVOS XML
        $i=1;
        $total_fact_xml = $nro_peticiones;
        while($i<=$total_fact_xml){
      
          $xml = new DomDocument('1.0', 'UTF-8');
          $xml->xmlStandalone = true;
          $facturaElectronicaServicioBasico = $xml->createElement('facturaElectronicaServicioBasico');
          $facturaElectronicaServicioBasico = $xml->appendChild($facturaElectronicaServicioBasico);
          $facturaElectronicaServicioBasico->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
          $facturaElectronicaServicioBasico->setAttribute('xsi:noNamespaceSchemaLocation', 'facturaElectronicaServicioBasico.xsd');
                
          $cabecera = $xml->createElement('cabecera');
          $cabecera = $facturaElectronicaServicioBasico->appendChild($cabecera);
                    
          $nitEmisor = $xml->createElement('nitEmisor',$this->config->item('nit'));
          $nitEmisor = $cabecera->appendChild($nitEmisor);
          
          $razonSocialEmisor = $xml->createElement('razonSocialEmisor',$this->config->item('razonSocial'));
          $razonSocialEmisor = $cabecera->appendChild($razonSocialEmisor);
          
          $municipio = $xml->createElement('municipio',$this->config->item('municipio'));
          $municipio = $cabecera->appendChild($municipio);
          
          $telefono = $xml->createElement('telefono',$this->config->item('telefono'));
          $telefono = $cabecera->appendChild($telefono);
          
          $nro_factura=1;//Extraer nro factura
          $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
          $numeroFactura = $cabecera->appendChild($numeroFactura);
                
          //para el CUF
          $tipo_emision = 3;
          $tipo_factura = 1;
          $tipo_doc_sector = 13;
          
          $res_concat = concatenar_ceros($this->config->item('nit'), date("YmdHisv"),$pv['codigo_sucursal'],$this->config->item('codigoModalidad'),$tipo_emision,$tipo_factura,$tipo_doc_sector,$nro_factura,$pv['codigo_punto_venta']);
          $res_m_11 = mod_11($res_concat,1,9,false);
          $res_str_16 = strtoupper(str_16($res_concat.$res_m_11));
          $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
          
          $cuf = $xml->createElement('cuf',$res_str_16.$cuf_act['codigo_control']);
          $cuf = $cabecera->appendChild($cuf);
          //Fin CUF
          
          $cufd = $xml->createElement('cufd',$cuf_act['codigo']);
          $cufd = $cabecera->appendChild($cufd);
          
          $codigoSucursal = $xml->createElement('codigoSucursal',$pv['codigo_sucursal']);
          $codigoSucursal = $cabecera->appendChild($codigoSucursal);
          
          $direccion = $xml->createElement('direccion',$this->config->item('direccion'));
          $direccion = $cabecera->appendChild($direccion);
          
          if($pv['codigo_punto_venta']==0){
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta');//element vacio
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
            $codigoPuntoVenta->setAttribute('xsi:nil', 'true');  
          }else{
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta',$pv['codigo_punto_venta']);
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
          }
          
          $mes = $xml->createElement('mes','SEPTIEMBRE');
          $mes = $cabecera->appendChild($mes);
          
          $gestion = $xml->createElement('gestion',date('Y'));
          $gestion = $cabecera->appendChild($gestion);
          
          $ciudad = $xml->createElement('ciudad',$this->config->item('ciudad'));
          $ciudad = $cabecera->appendChild($ciudad);
          
          $zona = $xml->createElement('zona','Zona cliente');
          $zona = $cabecera->appendChild($zona);
          
          $numeroMedidor = $xml->createElement('numeroMedidor','21');
          $numeroMedidor = $cabecera->appendChild($numeroMedidor);
          
          $fechaEmision = $xml->createElement('fechaEmision',date("Y-m-d\TH:i:s.v"));
          $fechaEmision = $cabecera->appendChild($fechaEmision);
          
          $razon_social_cliente = 'Carmelo Molina';
          $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
          $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);
          
          $domicilioCliente_cliente = 'TTe. leon y litoral nro 933';
          $domicilioCliente = $xml->createElement('domicilioCliente',$domicilioCliente_cliente);
          $domicilioCliente = $cabecera->appendChild($domicilioCliente);
          
          $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad','1');
          $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);
          
          $nro_doc_cliente=4043274;
          $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc_cliente);
          $numeroDocumento = $cabecera->appendChild($numeroDocumento);
          
          $complemento = $xml->createElement('complemento');//element vacio
          $complemento = $cabecera->appendChild($complemento);
          $complemento->setAttribute('xsi:nil', 'true');
          
          $codigoCliente = $xml->createElement('codigoCliente','51158891');
          $codigoCliente = $cabecera->appendChild($codigoCliente);
          
          $codigoMetodoPago = $xml->createElement('codigoMetodoPago','1');
          $codigoMetodoPago = $cabecera->appendChild($codigoMetodoPago);
          
          $numeroTarjeta = $xml->createElement('numeroTarjeta');//element vacio
          $numeroTarjeta = $cabecera->appendChild($numeroTarjeta);
          $numeroTarjeta->setAttribute('xsi:nil', 'true');
          
          $montoTotal = $xml->createElement('montoTotal','124.50');
          $montoTotal = $cabecera->appendChild($montoTotal);
          
          $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva','110');
          $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);
          
          $consumoPeriodo = $xml->createElement('consumoPeriodo');//element vacio
          $consumoPeriodo = $cabecera->appendChild($consumoPeriodo);
          $consumoPeriodo->setAttribute('xsi:nil', 'true');
          
          $beneficiarioLey1886 = $xml->createElement('beneficiarioLey1886');//element vacio
          $beneficiarioLey1886 = $cabecera->appendChild($beneficiarioLey1886);
          $beneficiarioLey1886->setAttribute('xsi:nil', 'true');
          
          $montoDescuentoLey1886 = $xml->createElement('montoDescuentoLey1886');//element vacio
          $montoDescuentoLey1886 = $cabecera->appendChild($montoDescuentoLey1886);
          $montoDescuentoLey1886->setAttribute('xsi:nil', 'true');
          
          $montoDescuentoTarifaDignidad = $xml->createElement('montoDescuentoTarifaDignidad');//element vacio
          $montoDescuentoTarifaDignidad = $cabecera->appendChild($montoDescuentoTarifaDignidad);
          $montoDescuentoTarifaDignidad->setAttribute('xsi:nil', 'true');
          
          $tasaAseo = $xml->createElement('tasaAseo','5');
          $tasaAseo = $cabecera->appendChild($tasaAseo);
          
          $tasaAlumbrado = $xml->createElement('tasaAlumbrado','2');
          $tasaAlumbrado = $cabecera->appendChild($tasaAlumbrado);
          
          $ajusteNoSujetoIva = $xml->createElement('ajusteNoSujetoIva','5');
          $ajusteNoSujetoIva = $cabecera->appendChild($ajusteNoSujetoIva);
          
          $detalleAjusteNoSujetoIva = $xml->createElement('detalleAjusteNoSujetoIva','{"Ajuste por Reclamo":5}');
          $detalleAjusteNoSujetoIva = $cabecera->appendChild($detalleAjusteNoSujetoIva);
          
          $ajusteSujetoIva = $xml->createElement('ajusteSujetoIva','10');
          $ajusteSujetoIva = $cabecera->appendChild($ajusteSujetoIva);
          
          $detalleAjusteSujetoIva = $xml->createElement('detalleAjusteSujetoIva','{"Cobropor Reconexión":10}');
          $detalleAjusteSujetoIva = $cabecera->appendChild($detalleAjusteSujetoIva);
          
          $otrosPagosNoSujetoIva = $xml->createElement('otrosPagosNoSujetoIva','7');
          $otrosPagosNoSujetoIva = $cabecera->appendChild($otrosPagosNoSujetoIva);
          
          $detalleOtrosPagosNoSujetoIva = $xml->createElement('detalleOtrosPagosNoSujetoIva','{"Pago Cuota Cooperativa":7}');
          $detalleOtrosPagosNoSujetoIva = $cabecera->appendChild($detalleOtrosPagosNoSujetoIva);
          
          $otrasTasas = $xml->createElement('otrasTasas','0.50');
          $otrasTasas = $cabecera->appendChild($otrasTasas);
          
          $codigoMoneda = $xml->createElement('codigoMoneda','1');
          $codigoMoneda = $cabecera->appendChild($codigoMoneda);
          
          $tipoCambio = $xml->createElement('tipoCambio','1');
          $tipoCambio = $cabecera->appendChild($tipoCambio);
          
          $montoTotalMoneda = $xml->createElement('montoTotalMoneda','124.50');
          $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);
          
          $descuentoAdicional = $xml->createElement('descuentoAdicional');//element vacio
          $descuentoAdicional = $cabecera->appendChild($descuentoAdicional);
          $descuentoAdicional->setAttribute('xsi:nil', 'true');
          
          $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
          $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
          $codigoExcepcion->setAttribute('xsi:nil', 'true');
          
          $cafc = $xml->createElement('cafc');//element vacio
          $cafc = $cabecera->appendChild($cafc);
          $cafc->setAttribute('xsi:nil', 'true');
          
          $leyenda = $xml->createElement('leyenda','Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.');
          $leyenda = $cabecera->appendChild($leyenda);
          
          $usuario = $xml->createElement('usuario','pperez');
          $usuario = $cabecera->appendChild($usuario);
          
          $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','13');
          $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);
          
          //DETALLE
          $detalle = $xml->createElement('detalle');
          $detalle = $facturaElectronicaServicioBasico->appendChild($detalle);
          
          $actividadEconomica = $xml->createElement('actividadEconomica','351000');//sacar de sincronizacion
          $actividadEconomica = $detalle->appendChild($actividadEconomica);
          
          $codigoProductoSin = $xml->createElement('codigoProductoSin','86311');//sacar de producto homolgar
          $codigoProductoSin = $detalle->appendChild($codigoProductoSin);
          
          $codigoProducto = $xml->createElement('codigoProducto','12345');//propio codigo
          $codigoProducto = $detalle->appendChild($codigoProducto);
          
          $descripcion = $xml->createElement('descripcion','Servicio Mes agosto');
          $descripcion = $detalle->appendChild($descripcion);
          
          $cantidad = $xml->createElement('cantidad','1');
          $cantidad = $detalle->appendChild($cantidad);
          
          $unidadMedida = $xml->createElement('unidadMedida','1');
          $unidadMedida = $detalle->appendChild($unidadMedida);
          
          $precioUnitario = $xml->createElement('precioUnitario','100');
          $precioUnitario = $detalle->appendChild($precioUnitario);
          
          $montoDescuento = $xml->createElement('montoDescuento','0');
          $montoDescuento = $detalle->appendChild($montoDescuento);
          
          $subTotal = $xml->createElement('subTotal','100');
          $subTotal = $detalle->appendChild($subTotal);
          
          $xml->formatOutput = true;
          $xml->save('facturas/masivo_'.$i.'.xml');
          $fir = new FirmarXml();
          $fir->firmar('facturas/masivo_'.$i.'.xml');//$res_str_16.$cuf_act['codigo_control']

          usleep(10000);//250000 100000 
          $i++;
        }// fin while

        $p = new PharData('./facturas/final_'.$k.'.tar');
        for($i=1;$i<=$total_fact_xml;$i++)
        $p['masivo_'.$i.'_firmado.xml'] = file_get_contents('./facturas/masivo_'.$i.'_firmado.xml');
        
        $p->compress(Phar::GZ);
        unlink('./facturas/final_'.$k.'.tar');

          //Enviando la solicitud
          $wsdl = $this->config->item('endPoint_FacturaServiciosBasicos');
          $token = $this->config->item('token');
          $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
          $context = stream_context_create($opts);
          $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
          
          $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
          $parametros = array(
              'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
              'codigoDocumentoSector' => '13', //sector serv. basicos
              'codigoEmision' => '3', // 3 masivo
              'codigoModalidad' => $this->config->item('codigoModalidad'), 
              'codigoPuntoVenta' => $pv['codigo_punto_venta'],
              'codigoSistema' => $this->config->item('codigoSistema'),
              'codigoSucursal' => $pv['codigo_sucursal'],
              'cufd' => $cuf_act['codigo'],
              'cuis' => $cuis['cuis_codigo'],
              'nit' => $this->config->item('nit'),
              'tipoFacturaDocumento' => '1', 
              
              'archivo' => file_get_contents('facturas/final_'.$k.'.tar.gz'),
              'hashArchivo' => hash_file('sha256', 'facturas/final_'.$k.'.tar.gz'),
              'cantidadFacturas' => $total_fact_xml,
              'fechaEnvio' => date("Y-m-d\TH:i:s.v")
              );
              //var_dump($parametros);
              
          $metodo = array('SolicitudServicioRecepcionMasiva'=> $parametros);
          $resultado = $client->__soapCall('recepcionMasivaFactura', array($metodo));
          $codigoRecepcion = null;
            if($resultado->RespuestaServicioFacturacion->transaccion){
              var_dump($resultado->RespuestaServicioFacturacion);
              echo 'masivo enviado exitosamente';
              $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
              $salida = true;
            }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
              $salida = false;
              echo 'ERROR: FALSE';
              var_dump($resultado->RespuestaServicioFacturacion);
            }else{
              $salida = false;
              echo 'Error desconocido.';
            }

            /* VERIFICACION masivo */
            if(!is_null($codigoRecepcion)){
              //Enviando la solicitud
              $wsdl = $this->config->item('endPoint_FacturaServiciosBasicos');
              $token = $this->config->item('token');
              $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
              $context = stream_context_create($opts);
              $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
              
              $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
              $parametros = array(
                  'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
                  'codigoDocumentoSector' => '13', 
                  'codigoEmision' => '3', //emision masiva 3
                  'codigoModalidad' => $this->config->item('codigoModalidad'), 
                  'codigoPuntoVenta' => $pv['codigo_punto_venta'],
                  'codigoSistema' => $this->config->item('codigoSistema'),
                  'codigoSucursal' => $pv['codigo_sucursal'],
                  'cufd' => $cuf_act['codigo'],
                  'cuis' => $cuis['cuis_codigo'],
                  'nit' => $this->config->item('nit'),
                  'tipoFacturaDocumento' => '1', 
                  'codigoRecepcion' => $codigoRecepcion,//Codigo del evento registrado anteriormente 
                  );
                  //var_dump($parametros);
                  
              $metodo = array('SolicitudServicioValidacionRecepcionMasiva'=> $parametros);
              $resultado = $client->__soapCall('validacionRecepcionMasivaFactura', array($metodo));
                if($resultado->RespuestaServicioFacturacion->transaccion){
                  var_dump($resultado->RespuestaServicioFacturacion);
                  echo 'Validacion exitosamente<br>';
                  $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
                  for ($i=1; $i <=$total_fact_xml ; $i++) { 
                    unlink('./facturas/masivo_'.$i.'.xml');
                    unlink('./facturas/masivo_'.$i.'_firmado.xml');
                  }
                  unlink('./facturas/final_'.$k.'.tar.gz');
                  echo 'Eliminación archivos exitosamente';
                }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
                  $salida = false;
                  echo 'ERROR: FALSE';
                  var_dump($resultado->RespuestaServicioFacturacion);
                }else{
                  $salida = false;
                  echo 'Error desconocido.';
                }
            }else{
              echo 'ERROR el codigoRecepcion es null';
            }

          $k++;
          if(((int)$pv['codigo_punto_venta'])==1)
            sleep(10);
          else 
            sleep(10);
        }//fin while K
    }//fin if admin
    else
      redirect(base_url());
  }//fin funcion 13

  /* ENVIO MASIVO 22 */  
  public function genera_masivo_xml_22(){
    if(isAdmin()){
      $pvs=$this->punto_venta_model->get_all();
      $data['pvs'] = $pvs;

      $data['main_content'] = 'sf_sin/genera_masivo_xml_22_view';
      $data['title'] = 'Emisión masiva telecomunicaciones';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function generar_masivo_xml_22(){
    if(isAdmin()){

      //recepción de post
      $n = $this->input->post('peticiones');
      $k=1;
      while($k<=$n){
      if($this->config->item('codigoAmbiente')=='2')
        $nro_peticiones = $this->input->post('nro_peticiones');
      else
        $nro_peticiones = 1;
      $pv = $this->punto_venta_model->get_punto_venta($this->input->post('id_punto_venta'));
      
      /* REGISTRO EVENTO*/
        //para el CUF
        $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);

        // GENERAR LOS ARCHIVOS XML
        $i=1;
        $total_fact_xml = $nro_peticiones;
        while($i<=$total_fact_xml){
      
          $xml = new DomDocument('1.0', 'UTF-8');
          $xml->xmlStandalone = true;
          $facturaElectronicaTelecomunicacion = $xml->createElement('facturaElectronicaTelecomunicacion');
          $facturaElectronicaTelecomunicacion = $xml->appendChild($facturaElectronicaTelecomunicacion);
          $facturaElectronicaTelecomunicacion->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
          $facturaElectronicaTelecomunicacion->setAttribute('xsi:noNamespaceSchemaLocation', 'facturaElectronicaTelecomunicacion.xsd');
                  
          $cabecera = $xml->createElement('cabecera');
          $cabecera = $facturaElectronicaTelecomunicacion->appendChild($cabecera);
                      
          $nitEmisor = $xml->createElement('nitEmisor',$this->config->item('nit'));
          $nitEmisor = $cabecera->appendChild($nitEmisor);
          
          $razonSocialEmisor = $xml->createElement('razonSocialEmisor',$this->config->item('razonSocial'));
          $razonSocialEmisor = $cabecera->appendChild($razonSocialEmisor);
          
          $municipio = $xml->createElement('municipio',$this->config->item('municipio'));
          $municipio = $cabecera->appendChild($municipio);
          
          $telefono = $xml->createElement('telefono',$this->config->item('telefono'));
          $telefono = $cabecera->appendChild($telefono);
  
          $nitConjunto = $xml->createElement('nitConjunto');//element vacio
          $nitConjunto = $cabecera->appendChild($nitConjunto);
          $nitConjunto->setAttribute('xsi:nil', 'true');
            
          $nro_factura=1;//Extraer nro factura
          $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
          $numeroFactura = $cabecera->appendChild($numeroFactura);

          //para el CUF
          $tipo_emision = 3;
          $tipo_factura = 1;
          $tipo_doc_sector = 22;
          
          $res_concat = concatenar_ceros($this->config->item('nit'), date("YmdHisv"),$pv['codigo_sucursal'],$this->config->item('codigoModalidad'),$tipo_emision,$tipo_factura,$tipo_doc_sector,$nro_factura,$pv['codigo_punto_venta']);
          $res_m_11 = mod_11($res_concat,1,9,false);
          $res_str_16 = strtoupper(str_16($res_concat.$res_m_11));
          $cuf_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
      
          $cuf = $xml->createElement('cuf',$res_str_16.$cuf_act['codigo_control']);
          $cuf = $cabecera->appendChild($cuf);
          //Fin CUF
          
          $cufd = $xml->createElement('cufd',$cuf_act['codigo']);
          $cufd = $cabecera->appendChild($cufd);
          
          $codigoSucursal = $xml->createElement('codigoSucursal',$pv['codigo_sucursal']);
          $codigoSucursal = $cabecera->appendChild($codigoSucursal);
          
          $direccion = $xml->createElement('direccion',$this->config->item('direccion'));
          $direccion = $cabecera->appendChild($direccion);
            
          if($pv['codigo_punto_venta']==0){
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta');//element vacio
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
            $codigoPuntoVenta->setAttribute('xsi:nil', 'true');  
          }else{
            $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta',$pv['codigo_punto_venta']);
            $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);
          }
      
          $fechaEmision = $xml->createElement('fechaEmision',date("Y-m-d\TH:i:s.v"));
          $fechaEmision = $cabecera->appendChild($fechaEmision);
    
          $razon_social_cliente = 'Carmelo Molina';
          $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
          $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);
    
          $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad','1');
          $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);
    
          $nro_doc_cliente=4043274;
          $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc_cliente);
          $numeroDocumento = $cabecera->appendChild($numeroDocumento);
    
          $complemento = $xml->createElement('complemento');//element vacio
          $complemento = $cabecera->appendChild($complemento);
          $complemento->setAttribute('xsi:nil', 'true');
    
          $codigoCliente = $xml->createElement('codigoCliente','51158891');
          $codigoCliente = $cabecera->appendChild($codigoCliente);
    
          $codigoMetodoPago = $xml->createElement('codigoMetodoPago','1');
          $codigoMetodoPago = $cabecera->appendChild($codigoMetodoPago);
    
          $numeroTarjeta = $xml->createElement('numeroTarjeta');//element vacio
          $numeroTarjeta = $cabecera->appendChild($numeroTarjeta);
          $numeroTarjeta->setAttribute('xsi:nil', 'true');
    
          $montoTotal = $xml->createElement('montoTotal','100');
          $montoTotal = $cabecera->appendChild($montoTotal);
  
          $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva','100');
          $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);
          
          $codigoMoneda = $xml->createElement('codigoMoneda','1');
          $codigoMoneda = $cabecera->appendChild($codigoMoneda);
    
          $tipoCambio = $xml->createElement('tipoCambio','1');
          $tipoCambio = $cabecera->appendChild($tipoCambio);
    
          $montoTotalMoneda = $xml->createElement('montoTotalMoneda','100');
          $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);
      
          $montoGiftCard = $xml->createElement('montoGiftCard');//element vacio
          $montoGiftCard = $cabecera->appendChild($montoGiftCard);
          $montoGiftCard->setAttribute('xsi:nil', 'true');
  
          $descuentoAdicional = $xml->createElement('descuentoAdicional');//element vacio
          $descuentoAdicional = $cabecera->appendChild($descuentoAdicional);
          $descuentoAdicional->setAttribute('xsi:nil', 'true');
  
          $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
          $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
          $codigoExcepcion->setAttribute('xsi:nil', 'true');
      
          $cafc = $xml->createElement('cafc');//element vacio
          $cafc = $cabecera->appendChild($cafc);
          $cafc->setAttribute('xsi:nil', 'true');
    
          $leyenda = $xml->createElement('leyenda','Ley N° 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices.');
          $leyenda = $cabecera->appendChild($leyenda);
    
          $usuario = $xml->createElement('usuario','pperez');
          $usuario = $cabecera->appendChild($usuario);
    
          $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','22');
          $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);
      
          //DETALLE
          $detalle = $xml->createElement('detalle');
          $detalle = $facturaElectronicaTelecomunicacion->appendChild($detalle);
      
          $actividadEconomica = $xml->createElement('actividadEconomica','351000');//sacar de sincronizacion
          $actividadEconomica = $detalle->appendChild($actividadEconomica);
  
          $codigoProductoSin = $xml->createElement('codigoProductoSin','86311');//sacar de producto homolgar
          $codigoProductoSin = $detalle->appendChild($codigoProductoSin);
  
          $codigoProducto = $xml->createElement('codigoProducto','12345');//propio codigo
          $codigoProducto = $detalle->appendChild($codigoProducto);
  
          $descripcion = $xml->createElement('descripcion','PAGO DE MES DE ABRIL DE POSTPAGO');
          $descripcion = $detalle->appendChild($descripcion);
  
          $cantidad = $xml->createElement('cantidad','1');
          $cantidad = $detalle->appendChild($cantidad);
  
          $unidadMedida = $xml->createElement('unidadMedida','1');
          $unidadMedida = $detalle->appendChild($unidadMedida);
  
          $precioUnitario = $xml->createElement('precioUnitario','100');
          $precioUnitario = $detalle->appendChild($precioUnitario);
  
          $montoDescuento = $xml->createElement('montoDescuento','0');
          $montoDescuento = $detalle->appendChild($montoDescuento);
  
          $subTotal = $xml->createElement('subTotal','100');
          $subTotal = $detalle->appendChild($subTotal);
  
          $numeroSerie = $xml->createElement('numeroSerie','67755FD');
          $numeroSerie = $detalle->appendChild($numeroSerie);
  
          $numeroImei = $xml->createElement('numeroImei','44100');
          $numeroImei = $detalle->appendChild($numeroImei);
          
          $xml->formatOutput = true;
          $xml->save('facturas/masivo_'.$i.'.xml');
          $fir = new FirmarXml();
          $fir->firmar('facturas/masivo_'.$i.'.xml');//$res_str_16.$cuf_act['codigo_control']

          usleep(10000);//250000 100000 
          $i++;
        }// fin while

        $p = new PharData('./facturas/final_'.$k.'.tar');
        for($i=1;$i<=$total_fact_xml;$i++)
        $p['masivo_'.$i.'_firmado.xml'] = file_get_contents('./facturas/masivo_'.$i.'_firmado.xml');
        
        $p->compress(Phar::GZ);
        unlink('./facturas/final_'.$k.'.tar');

          //Enviando la solicitud
          $wsdl = $this->config->item('endPoint_FacturaTelecomunicaciones');
          $token = $this->config->item('token');
          $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
          $context = stream_context_create($opts);
          $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
          
          $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
          $parametros = array(
              'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
              'codigoDocumentoSector' => '22', //sector telco
              'codigoEmision' => '3', // 3 masivo
              'codigoModalidad' => $this->config->item('codigoModalidad'), 
              'codigoPuntoVenta' => $pv['codigo_punto_venta'],
              'codigoSistema' => $this->config->item('codigoSistema'),
              'codigoSucursal' => $pv['codigo_sucursal'],
              'cufd' => $cuf_act['codigo'],
              'cuis' => $cuis['cuis_codigo'],
              'nit' => $this->config->item('nit'),
              'tipoFacturaDocumento' => '1', 
              
              'archivo' => file_get_contents('facturas/final_'.$k.'.tar.gz'),
              'hashArchivo' => hash_file('sha256', 'facturas/final_'.$k.'.tar.gz'),
              'cantidadFacturas' => $total_fact_xml,
              'fechaEnvio' => date("Y-m-d\TH:i:s.v")
              );
              //var_dump($parametros);
              
          $metodo = array('SolicitudServicioRecepcionMasiva'=> $parametros);
          $resultado = $client->__soapCall('recepcionMasivaFactura', array($metodo));
          $codigoRecepcion = null;
            if($resultado->RespuestaServicioFacturacion->transaccion){
              var_dump($resultado->RespuestaServicioFacturacion);
              echo 'masivo enviado exitosamente';
              $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
              $salida = true;
            }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
              $salida = false;
              echo 'ERROR: FALSE';
              var_dump($resultado->RespuestaServicioFacturacion);
            }else{
              $salida = false;
              echo 'Error desconocido.';
            }

            /* VERIFICACION masivo */
            if(!is_null($codigoRecepcion)){
              //Enviando la solicitud
              $wsdl = $this->config->item('endPoint_FacturaTelecomunicaciones');
              $token = $this->config->item('token');
              $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
              $context = stream_context_create($opts);
              $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
              
              $cuis = $this->cuis_model->get_cuis_id_punto_venta($pv['id_punto_venta']);
              $parametros = array(
                  'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
                  'codigoDocumentoSector' => '22', 
                  'codigoEmision' => '3', //emision masiva 3
                  'codigoModalidad' => $this->config->item('codigoModalidad'), 
                  'codigoPuntoVenta' => $pv['codigo_punto_venta'],
                  'codigoSistema' => $this->config->item('codigoSistema'),
                  'codigoSucursal' => $pv['codigo_sucursal'],
                  'cufd' => $cuf_act['codigo'],
                  'cuis' => $cuis['cuis_codigo'],
                  'nit' => $this->config->item('nit'),
                  'tipoFacturaDocumento' => '1', 
                  'codigoRecepcion' => $codigoRecepcion,//Codigo del evento registrado anteriormente 
                  );
                  //var_dump($parametros);
                  
              $metodo = array('SolicitudServicioValidacionRecepcionMasiva'=> $parametros);
              $resultado = $client->__soapCall('validacionRecepcionMasivaFactura', array($metodo));
                if($resultado->RespuestaServicioFacturacion->transaccion){
                  var_dump($resultado->RespuestaServicioFacturacion);
                  echo 'Validacion exitosamente<br>';
                  $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
                  for ($i=1; $i <=$total_fact_xml ; $i++) { 
                    unlink('./facturas/masivo_'.$i.'.xml');
                    unlink('./facturas/masivo_'.$i.'_firmado.xml');
                  }
                  unlink('./facturas/final_'.$k.'.tar.gz');
                  echo 'Eliminación archivos exitosamente';
                }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
                  $salida = false;
                  echo 'ERROR: FALSE';
                  var_dump($resultado->RespuestaServicioFacturacion);
                }else{
                  $salida = false;
                  echo 'Error desconocido.';
                }
            }else{
              echo 'ERROR el codigoRecepcion es null';
            }

          $k++;
          if(((int)$pv['codigo_punto_venta'])==1)
            sleep(10);
          else 
            sleep(10);
        }//fin while K
    }//fin if admin
    else
      redirect(base_url());
  }//fin funcion 22
  
}//fin class

