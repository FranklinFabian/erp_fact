<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emision_individual_tv extends CI_Controller{

  public $repetidos_afcoop=array();
  public $i=1;

  public function index(){//MENU
    if(isLogin()){
      $data['main_content'] = 'emision_individual_tv/index_view';
      $data['title'] = 'Menu emision individual';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }
  public function abonado_no_encontrado(){
    if(isLogin()){
      $data['main_content'] = 'emision_individual_tv/abonado_no_encontrado_view';
      $data['title'] = 'Abonado no encontrado';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());

  }

  public function cargar_abonado(){
    if(isLogin()){
      //data
      $idabonado = $this->input->post('idabonado');
      $abonado = $this->abonados_model->get_abonado($idabonado);
      if(is_null($abonado))
        redirect(base_url().'emision_individual_tv/abonado_no_encontrado');
      
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      $data['direccion'] = $direccion;
      $data['abonado'] = $abonado;
      $data['cliente'] = $this->cliente_model->get_cliente($abonado['idcliente']);
      $data['centro'] = $this->centros_model->get_centro($abonado['idcentro']);
      $data['poste'] = $this->postes_model->get_poste($abonado['idposte']);
      $data['categoria'] = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $data['estado'] = $this->estados_model->get_estado($abonado['idestado']);

      //form
      $periodo_activo = $this->periodos_model->get_activo();
      $lectura = $this->lecturas_model->buscar_abonado_periodo($idabonado, $periodo_activo['idperiodo']);
      //var_dump($lectura);
      if(!is_null($lectura))
        $data['lectura'] = $lectura;
      else 
        $data['lectura'] = NULL;

      $lecturas = $this->lecturas_model->get_lecturas_abonado_5($idabonado, $periodo_activo['idperiodo']);
      $lectura_anterior = $this->lecturas_model->get_lectura_anterior($idabonado, $periodo_activo['idperiodo']);

      $data['lectura_anterior'] = $lectura_anterior;
      $data['periodo_activo'] = $periodo_activo;
      $data['lecturas'] = $lecturas;
  
      //vista
      $data['main_content'] = 'emision_individual_tv/cargar_abonado_view';
      $data['title'] = 'Menu emision individual';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear($idabonado){
    if(isLogin()){
      $abonado=$this->abonados_model->get_abonado($idabonado);
      $periodo_activo = $this->periodos_model->get_activo();
      

      $data_lect['idabonado'] = $idabonado;
      $data_lect['idperiodo'] = $periodo_activo['idperiodo'];
      $data_lect['idservicio'] = 2;
      $data_lect['idcategoria'] = $abonado['idcategoria'];
      $data_lect['indice'] = 0;
      $estado = $this->input->post('operacion');
      
      switch ($estado) {
        case '2':
          $data_lect['estado'] = 'L';  
          $data_lect['estimado'] = '0';
          break;
          case '1':
            $data_lect['estado'] = '0';  
            $data_lect['estimado'] = '1';
            break;
          default:
            $data_lect['estado'] = '0';  
            $data_lect['estimado'] = '0';
            break;
      }
      
      $data_lect['mulmed'] = 0;
      $data_lect['kwh'] = $this->input->post('dias');;
      $data_lect['potencia'] = 0;
      $data_lect['imp_fijo']=0;
      $data_lect['imp_adic']=0;
      $data_lect['imp_poten']=0;
      $data_lect['imp_total']=0;
      $data_lect['conexion']=0;
      $data_lect['reposicion']=0;
      $data_lect['recargo']=0;
      $data_lect['aseo']=0;
      $data_lect['alumbrado']=0;
      $data_lect['ley1886']=0;
      $data_lect['dignidad']=0;
      $data_lect['afcoop']=0;
      $data_lect['devolucion']=0;
      $data_lect['desdom']=0;
      $data_lect['desap']=0;
      $data_lect['desau']=0;
      $data_lect['desafcoop']=0;
      $data_lect['kvarh']=0;
      $data_lect['imp_penal']=0;
      $data_lect['lectreactiva']=0;
      $data_lect['freg_ene0']=0;
      $data_lect['frepetido']=0;
      $data_lect['usuario'] = $this->session->userdata('usuario');
      //var_dump($data_lect);
      $lectura = $this->lecturas_model->buscar_abonado_periodo($idabonado, $periodo_activo['idperiodo']);
      if(is_null($lectura)){
        $idlectura = $this->lecturas_model->current_num();
        $data_lect['idlectura'] = $idlectura;  
        $this->lecturas_model->insertar($data_lect);
      }
      else{
        $this->lecturas_model->actualizar($lectura['idlectura'], $data_lect);
        $idlectura = $lectura['idlectura'];
      }

      //var_dump($data_lect);
      
      $this->calcular($idlectura);
    }
    else
      redirect(base_url());
  }

  public function calcular($idlectura){
    if(isAdmin()){
      $dias_mes = date('t');
      $periodo_act = $this->periodos_model->get_activo();
      $factores = $this->factores_model->get_factor_periodo($periodo_act['idperiodo']);
      $lectura = $this->lecturas_model->get_lectura($idlectura);
      $monto_total = 0;
      switch ($lectura['idcategoria']) {
        case '8': $monto_total = ($factores['tv_ts']/$dias_mes)*$lectura['kwh']; break;
        case '9': $monto_total = ($factores['tv_tp']/$dias_mes)*$lectura['kwh']; break;
        case '10': $monto_total = ($factores['tv_c1']/$dias_mes)*$lectura['kwh']; break;
        case '11': $monto_total = ($factores['tv_c2']/$dias_mes)*$lectura['kwh']; break;
        case '12': $monto_total = ($factores['tv_c3']/$dias_mes)*$lectura['kwh']; break;
      }
      //actualizamos la lectura
      $data_lectura['imp_total'] = round($monto_total, 1);
      $this->lecturas_model->actualizar($idlectura, $data_lectura);

      $lecturas_array = $this->generar_facturas_22_model->get_lecturas_unica($periodo_act['idperiodo'], 2, $idlectura);
      $empleado = $this->empleado_model->get_empleado($this->session->userdata('id_empleado'));
      foreach ($lecturas_array as $key => $lecturas) {

        $pv = $this->punto_venta_model->get_punto_venta($empleado['id_punto_venta']);
        $cufd_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);
        
        $cliente = $this->cliente_model->get_cliente($lecturas['idcliente']);
        $razon_social = $cliente['razon_social'];
        $nro_doc = NULL;
        switch ($cliente['tipo_doc_fact']) {
          case '1': $nro_doc = $cliente['ci']; break;
          case '2': $nro_doc = $cliente['cex']; break;
          case '3': $nro_doc = $cliente['pas']; break;
          case '4': $nro_doc = $cliente['od']; break;
          case '5': $nro_doc = $cliente['nit']; break;
          default:  $nro_doc = $cliente['ci']; break;
        }
        if ($nro_doc == '0'){
          $razon_social = 'Control Tributario';
          $nro_doc = 99002;
        }

          //para los milisegundos
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
          
          $nro_factura = $pv['cont_fact'];
          $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
          $numeroFactura = $cabecera->appendChild($numeroFactura);

          //para el CUF
          $tipo_emision = 1;
          $tipo_factura = 1;
          $tipo_doc_sector = 22;

          //para los milisegundos
          $miliseg='000';

          $res_concat = concatenar_ceros($this->config->item('nit'), date('YmdHis'.$miliseg),$pv['codigo_sucursal'],$this->config->item('codigoModalidad'),$tipo_emision,$tipo_factura,$tipo_doc_sector,$nro_factura,$pv['codigo_punto_venta']);
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

          $fechaEmision = $xml->createElement('fechaEmision',date('Y-m-d\TH:i:s.'.($miliseg)));
          $fechaEmision = $cabecera->appendChild($fechaEmision);
  
          $razon_social_cliente = $razon_social; // $lecturas['razon_social'];
          $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
          $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);
  
          // $complemento_cliente = explode('-', $lecturas['nit']);
          // $contador_nit_ci = strlen($lecturas['nit']);
          // if(($contador_nit_ci>=9) && ($contador_nit_ci<=11) && (count($complemento_cliente)==1))  $cod_tipo_iden = 5;
          // elseif(($contador_nit_ci>=0) && ($contador_nit_ci<=8)) $cod_tipo_iden = 1;
          // else $cod_tipo_iden = 4;
    
          // if(count($complemento_cliente) >= 2){
          //   $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad', 1);
          //   $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);  
          // }else{
          //   $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad', $cod_tipo_iden);
          //   $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);  
          // }
    
          // $numeroDocumento = $xml->createElement('numeroDocumento',$lecturas['nit']);
          // $numeroDocumento = $cabecera->appendChild($numeroDocumento);
    
          // if(count($complemento_cliente) >= 2){
          //   $complemento = $xml->createElement('complemento', $complemento_cliente[1]);
          //   $complemento = $cabecera->appendChild($complemento);
            
          // }else{
          //   $complemento = $xml->createElement('complemento');
          //   $complemento = $cabecera->appendChild($complemento);
          //   $complemento->setAttribute('xsi:nil', 'true');  
          // }
          $codigoTipoDocumentoIdentidad = $xml->createElement('codigoTipoDocumentoIdentidad', $cliente['tipo_doc_fact']);
          $codigoTipoDocumentoIdentidad = $cabecera->appendChild($codigoTipoDocumentoIdentidad);
      
          if(($cliente['tipo_doc_fact']=='1')){
            $complemento_cliente = explode('-', $nro_doc);
            if( count($complemento_cliente)>1 ){
              $numeroDocumento = $xml->createElement('numeroDocumento',$complemento_cliente[0]);
              $numeroDocumento = $cabecera->appendChild($numeroDocumento);
            }else{
              $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc);
              $numeroDocumento = $cabecera->appendChild($numeroDocumento);  
            }
          }else{
            $numeroDocumento = $xml->createElement('numeroDocumento',$nro_doc);
            $numeroDocumento = $cabecera->appendChild($numeroDocumento);
          }
      
          if(($cliente['tipo_doc_fact']=='1')){
            $complemento_cliente = explode('-', $nro_doc);
            if( count($complemento_cliente)>=2 ){
              $complemento = $xml->createElement('complemento', $complemento_cliente[1]);
              $complemento = $cabecera->appendChild($complemento);
              }else{
                $complemento = $xml->createElement('complemento');
                $complemento = $cabecera->appendChild($complemento);
                $complemento->setAttribute('xsi:nil', 'true');      
              }
            }else{
              $complemento = $xml->createElement('complemento');
              $complemento = $cabecera->appendChild($complemento);
              $complemento->setAttribute('xsi:nil', 'true');  
            }
        
          $codigoCliente = $xml->createElement('codigoCliente', $lecturas['idcliente']);
          $codigoCliente = $cabecera->appendChild($codigoCliente);
  
          $codigoMetodoPago = $xml->createElement('codigoMetodoPago','1');
          $codigoMetodoPago = $cabecera->appendChild($codigoMetodoPago);
  
          $numeroTarjeta = $xml->createElement('numeroTarjeta');//element vacio
          $numeroTarjeta = $cabecera->appendChild($numeroTarjeta);
          $numeroTarjeta->setAttribute('xsi:nil', 'true');
          
          $total_cobrar = ($lecturas['imp_total']+$lecturas['conexion']+$lecturas['reposicion']+$lecturas['recargo']);

          //1 montoTotal -> Monto total por el cual se realiza el hecho generador.
          $sin_monto_total = $total_cobrar;

          //2 montoTotalSujetoIva -> Monto base para el cálculo del crédito fiscal.
          $sin_montoTotalSujetoIva = $total_cobrar;

          //3 montoTotalMoneda -> Es el Monto Total expresado en el tipo de moneda, si el código de moneda es boliviano deberá ser igual al monto total.
          $sin_montoTotalMoneda = $total_cobrar;

          //4 precioUnitario -> Precio que otorga el contribuyente a su servicio o producto.
          $sin_precio_unitario=$total_cobrar;

          //5 subTotal -> El subtotal siempre será en bolivianos es igual a la (cantidad * precio unitario) – descuento.
          $sin_subTotal = $total_cobrar; 
          
          $montoTotal = $xml->createElement('montoTotal', $sin_monto_total);
          $montoTotal = $cabecera->appendChild($montoTotal);

          $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva', $sin_montoTotalSujetoIva);///////////// total_cobrar-tasas-aportes
          $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);
  
          $codigoMoneda = $xml->createElement('codigoMoneda','1');
          $codigoMoneda = $cabecera->appendChild($codigoMoneda);
  
          $tipoCambio = $xml->createElement('tipoCambio','1');
          $tipoCambio = $cabecera->appendChild($tipoCambio);

          $montoTotalMoneda = $xml->createElement('montoTotalMoneda', $sin_montoTotalMoneda);//monto total
          $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);

          $montoGiftCard = $xml->createElement('montoGiftCard');//element vacio
          $montoGiftCard = $cabecera->appendChild($montoGiftCard);
          $montoGiftCard->setAttribute('xsi:nil', 'true');
          
          $descuentoAdicional = $xml->createElement('descuentoAdicional');//element vacio
          $descuentoAdicional = $cabecera->appendChild($descuentoAdicional);
          $descuentoAdicional->setAttribute('xsi:nil', 'true');
  
          if(($cliente['tipo_doc_fact']=='5')){
            if($this->verifica_nit($cliente['nit'])){
              $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
              $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
              $codigoExcepcion->setAttribute('xsi:nil', 'true');
            }else{
              $codigoExcepcion = $xml->createElement('codigoExcepcion', 1);
              $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
            }            
          }else{
            $codigoExcepcion = $xml->createElement('codigoExcepcion');//element vacio
            $codigoExcepcion = $cabecera->appendChild($codigoExcepcion);
            $codigoExcepcion->setAttribute('xsi:nil', 'true');  
          }
        
          $cafc = $xml->createElement('cafc');//element vacio
          $cafc = $cabecera->appendChild($cafc);
          $cafc->setAttribute('xsi:nil', 'true');
  
          $leyenda_random = $this->leyenda_factura_model->get_all();
          $randomNum = rand(0, count($leyenda_random)-1);
          $leyenda_fact = $leyenda_random[$randomNum]['descripcion_leyenda'];
                        
          $leyenda = $xml->createElement('leyenda', $leyenda_fact);
          $leyenda = $cabecera->appendChild($leyenda);
  
          $usuario = $xml->createElement('usuario', $this->session->userdata('usuario') );
          $usuario = $cabecera->appendChild($usuario);
  
          $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','22');
          $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);
  
        //DETALLE
        $detalle = $xml->createElement('detalle');
        $detalle = $facturaElectronicaTelecomunicacion->appendChild($detalle);

        $actividadEconomica = $xml->createElement('actividadEconomica','600000');//sacar de sincronizacion
        $actividadEconomica = $detalle->appendChild($actividadEconomica);

        $codigoProductoSin = $xml->createElement('codigoProductoSin','84612');//sacar de producto homolgar
        $codigoProductoSin = $detalle->appendChild($codigoProductoSin);

        $codigoProducto = $xml->createElement('codigoProducto','6161');//propio codigo
        $codigoProducto = $detalle->appendChild($codigoProducto);

        $descripcion = $xml->createElement('descripcion','CONSUMO TV CABLE');
        $descripcion = $detalle->appendChild($descripcion);

        $cantidad = $xml->createElement('cantidad','1');
        $cantidad = $detalle->appendChild($cantidad);

        $unidadMedida = $xml->createElement('unidadMedida','58');
        $unidadMedida = $detalle->appendChild($unidadMedida);

        $precioUnitario = $xml->createElement('precioUnitario', $sin_precio_unitario);
        $precioUnitario = $detalle->appendChild($precioUnitario);

        $montoDescuento = $xml->createElement('montoDescuento','0');
        $montoDescuento = $detalle->appendChild($montoDescuento);

        $subTotal = $xml->createElement('subTotal', $sin_subTotal);//$total_cobrar
        $subTotal = $detalle->appendChild($subTotal);

        $numeroSerie = $xml->createElement('numeroSerie','0');
        $numeroSerie = $detalle->appendChild($numeroSerie);

        $numeroImei = $xml->createElement('numeroImei','0');
        $numeroImei = $detalle->appendChild($numeroImei);

        $xml->formatOutput = true;
        $xml->save('facturas_22/'.$lecturas['idlectura'].'.xml');//Nombre archivo
        $fir = new FirmarXml();
        $fir->firmar('facturas_22/'.$lecturas['idlectura'].'.xml');//Nombre archivo_firmado

        $origen = 'facturas_22/'.$lecturas['idlectura'].'_firmado.xml';
        $destino = 'facturas_22/'.$lecturas['idlectura'].'_firmado.gz';
        $fp = fopen($origen, "r");
        $data_compress = fread ($fp, filesize($origen));
        fclose($fp);
        $zp = gzopen($destino, "w9");
        gzwrite($zp, $data_compress);
        gzclose($zp);

        //actualizamos el contador de facturas en 1 del pv
        $data_pv['cont_fact'] = ($nro_factura+1);
        $this->punto_venta_model->actualizar($pv['id_punto_venta'], $data_pv);

        //actualizacmos el campo generado de lectura
        $data_lect['generado']='1';
        $this->lecturas_model->actualizar($lecturas['idlectura'], $data_lect);
        //////////////////////////////////////////////////////////////////////////////ENVIANDO SOLICITUD
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
            'archivo' => file_get_contents('facturas_22/'.$lecturas['idlectura'].'_firmado.gz'),
            'fechaEnvio' => date("Y-m-d\TH:i:s.v"), 
            'hashArchivo' => hash_file('sha256', 'facturas_22/'.$lecturas['idlectura'].'_firmado.gz'),
            );
            //var_dump($parametros);
        $metodo = array('SolicitudServicioRecepcionFactura'=> $parametros);
        $resultado = $client->__soapCall('recepcionFactura', array($metodo));

        if($resultado->RespuestaServicioFacturacion->transaccion){///////////////////////////////   ENVIO EXISTOSO
          //Insertamos en la tabla factura_22
          $data_fact['cuf'] = $res_str_16.$cuf_act['codigo_control'];
          $data_fact['fecha_emision'] = date('Y-m-d H:i:s');
          $data_fact['estado_fact'] = 'E';//emitido
          $data_fact['id_punto_venta'] = $pv['id_punto_venta'];
          $data_fact['idcliente'] = $lecturas['idcliente'];  
          $data_fact['leyenda_fact'] = $leyenda_fact;
          $data_fact['usuario'] = $this->session->userdata('usuario');
          $data_fact['nro_fact'] = $nro_factura;
          $data_fact['idlectura'] = $lecturas['idlectura'];
          $data_fact['monto_total'] = $total_cobrar;
          $data_fact['cufd'] = $cufd_act['codigo'];
          $this->factura_22_model->insertar($data_fact);
          ///////////// PDF 
          $configuracion = $this->configuracion_model->get_all();
          if(is_null($configuracion)){
            $configuracion['logo_linea1'] = 'MI EMPRESA';
            $configuracion['logo_linea2'] = 'MI SLOGAN';
            $configuracion['direccion'] = 'AV. SIEMPRE VIVA NRO. 16, SANTA CRUZ - BOLIVIA';
            $configuracion['telefono'] = '';
            $configuracion['whatsapp'] = '';
            $configuracion['pie_impresion'] = 'GRACIAS POR SU PREFERENCIA.';
          }
          $factura = $this->factura_22_model->get_factura_lectura($lecturas['idlectura']);
          if(is_null($factura))
          echo 'Factura no disponible: id '.$factura['idfactura_22'];
          else{
              $abonado = $this->abonados_model->get_abonado($lecturas['idabonado']);
              $direccion_abonado = $this->calles_model->get_all_all($abonado['idcalle']);
              //$periodo = $this->periodos_model->get_periodo($lecturas['idperiodo']);//periodo
              $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
              $data['lectura'] = $this->lecturas_model->get_lectura($idlectura);
              $data['factura'] = $factura;
              $data['direccion_abonado'] = $direccion_abonado;
              $data['periodo'] = $periodo_act;
              $data['configuracion'] = $configuracion;
              $data['abonado'] = $abonado;
              $data['cliente'] = $cliente;
              $data['title'] = 'Factura';
          }//fin if is_null lectura
          
          $this->load->library('Pdf');
          $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
          $pdf->SetCreator(PDF_CREATOR);
          $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
          $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
          $pdf->setPrintHeader(false);
          $pdf->setPrintFooter(false);
          $pdf->SetMargins(10, 5, 10, true);
          $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
          $pdf->SetFont('dejavusans', '', 4);
          $pdf->AddPage('P', 'A4');
          
          $html = $this->load->view('gestion_factura/impresion_factura_22_pdf_view', $data, true);
          $pdf->writeHTML($html, true, false, true, false, '');
          $pdf->Output(getcwd().'/facturas_22/'.$lecturas['idlectura'].'_'.$factura['cuf'].'.pdf', 'F');
          //EMAIL
          if(!is_null($lecturas['correo'])){
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
            $this->email->to($lecturas['correo']);
            //$this->email->subject($this->config->item('razonSocial').' Factura consumo  '.$periodo_act['emision']);
            $this->email->subject($this->config->item('razonSocial').' Factura Telecomunicaciones Nro. '.$factura['nro_fact'].' periodo '.($periodo_act['emision']));

            $this->email->message('
            <p>
              Consultar en SIAT <a target="_blank" href="'.$this->config->item('url_qr').'nit='.$this->config->item('nit').'&cuf='.$factura['cuf'].'&numero='.$factura['nro_fact'].' ">aquí</a>
            </p> 
            ');
  
            $this->email->attach(getcwd().'/facturas_22/'.$factura['idlectura'].'_'.$factura['cuf'].'.pdf');
            $this->email->attach(getcwd().'/facturas_22/'.$factura['idlectura'].'_firmado.xml');
            $this->email->send();
          }

          if(!is_null($lecturas['correo']))
            echo 'Factura enviado a '.$lecturas['correo'].' correctamente. <a href="'.base_url().'emision_individual_tv">Volver a Inicio</a>';
          else
            echo 'No se encontro correo electronico. <a href="'.base_url().'emision_individual_tv">Volver a Inicio</a>';

          unlink('./facturas_22/'.$lecturas['idlectura'].'.xml');
          //unlink('./facturas_22/'.$lecturas['idlectura'].'_firmado.xml');
          
        }
        elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
          echo 'ERROR: FALSE';
          var_dump($resultado->RespuestaServicioFacturacion);
        }else{
          echo 'Error desconocido.';
        }

        
        
        }//fin foreach 


      //var_dump($lecturas_array);
      //echo 'Monto a facturar: '.round($monto_total, 1);
      
    }
    else
      redirect(base_url());
  }// fin funcion calcular

  public function verifica_nit($nit=null){
    $empleado = $this->empleado_model->get_empleado($this->session->userdata('id_empleado'));
    
    if(!is_null($nit) ){

        $wsdl = $this->config->item('endPoint_FacturacionCodigos');
        $token = $this->config->item('token');
        $opts = array('http' => array('header' => "apiKey: TokenApi $token",));
        $context = stream_context_create($opts);
        $client = new SoapClient($wsdl, ['stream_context' => $context,'cache_wsdl' => WSDL_CACHE_NONE,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,]);
        $pv = $this->punto_venta_model->get_punto_venta($empleado['id_punto_venta']);
        $cuis = $this->cuis_model->get_cuis_id_punto_venta($empleado['id_punto_venta']);

        $parametros = array(
            'codigoAmbiente' => $this->config->item('codigoAmbiente'), 
            'codigoModalidad' => $this->config->item('codigoModalidad'), 
            'codigoSistema' => $this->config->item('codigoSistema'),
            'codigoSucursal' => $pv['codigo_sucursal'],
            'cuis' => $cuis['cuis_codigo'],
            'nit' => $this->config->item('nit'),
            'nitParaVerificacion' => $nit
            );
        $metodo = array('SolicitudVerificarNit'=> $parametros);
        $resultado = $client->__soapCall('verificarNit', array($metodo));
        
        if($resultado->RespuestaVerificarNit->transaccion)
          return TRUE;
        else 
          return FALSE;
      }
  }// fin verifica

}//fin class
