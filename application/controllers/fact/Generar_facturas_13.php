<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generar_facturas_13 extends CI_Controller{

  public function index(){
    if(isAdmin()){
      
      $periodo_act = $this->periodos_model->get_activo();
      $lecturas_array = $this->generar_facturas_13_model->get_lecturas_periodo($periodo_act['idperiodo'], 1);
      $cantidad_restante = count($lecturas_array);
      $data['periodo_act'] = $periodo_act;
      $data['main_content'] = 'generar_facturas_13/index_view';
      $data['title'] = 'Calcular lecturas';
      $data['cantidad_restante'] = $cantidad_restante;
      $this->load->view('template/template_view', $data);
    }else
    redirect(base_url());
  }

  public function calcular(){
    if(isAdmin()){
      if(file_exists('./facturas_13/final.tar') || file_exists('./facturas_13/final.tar.gz')){
        //unlink('./facturas_13/final.tar'); 
        unlink('./facturas_13/final.tar.gz'); 
      }

      $periodo_act = $this->periodos_model->get_activo();
      if(is_null($periodo_act))
        echo 'Error al obtener el periodo o factor';
      else{
        $lecturas_array = $this->generar_facturas_13_model->get_lecturas($periodo_act['idperiodo'], 1);
      //var_dump($lecturas_array);
      $i=1;
      $miliseg=1;
      $total_fact_xml=0;
      
      $cont_enviado = 0;
      $empleado = $this->empleado_model->get_empleado($this->session->userdata('id_empleado'));
      $array_cuf_correo = array();
      $array_nro_fact_correo = array();
      foreach ($lecturas_array as $key => $lecturas) {
        
        $pv = $this->punto_venta_model->get_punto_venta($empleado['id_punto_venta']);
        $cufd_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);

        $cliente = $this->cliente_model->get_cliente($lecturas['idcliente']);
        $razon_social = $cliente['razon_social'];
        $nro_doc = NULL;
        
        if(is_null($cliente['tipo_doc_fact']))
          $cliente['tipo_doc_fact']='1';

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
           if($i >= 960){
              $i=1;
              $miliseg=1;
            }
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
          
          $nro_factura = $pv['cont_fact'];
          $numeroFactura = $xml->createElement('numeroFactura',$nro_factura);
          $numeroFactura = $cabecera->appendChild($numeroFactura);

          //para el CUF
          $tipo_emision = 3;
          $tipo_factura = 1;
          $tipo_doc_sector = 13;

          //para los milisegundos
          if($miliseg < 10)
            $miliseg='00'.$i;
          elseif($miliseg < 100)
            $miliseg='0'.$i;
          else 
            $miliseg=$i;

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
          $codigoPuntoVenta = $xml->createElement('codigoPuntoVenta',$pv['codigo_punto_venta']);
          $codigoPuntoVenta = $cabecera->appendChild($codigoPuntoVenta);

          $mes_periodo = substr($periodo_act['emision'],5,2);
          $anio_gestion = substr($periodo_act['emision'],0,4);

          $mes = $xml->createElement('mes', $mes_periodo);
          $mes = $cabecera->appendChild($mes);
  
          $gestion = $xml->createElement('gestion', $anio_gestion);
          $gestion = $cabecera->appendChild($gestion);
  
          $ciudad = $xml->createElement('ciudad',$this->config->item('ciudad'));
          $ciudad = $cabecera->appendChild($ciudad);
  
          $zona_cliente = $this->calles_model->get_all_all($lecturas['idcalle']);
          
          $zona = $xml->createElement('zona',$zona_cliente['zona']);
          $zona = $cabecera->appendChild($zona);
  
          $numeroMedidor = $xml->createElement('numeroMedidor',$lecturas['medidor']);
          $numeroMedidor = $cabecera->appendChild($numeroMedidor);

          $fechaEmision = $xml->createElement('fechaEmision',date('Y-m-d\TH:i:s.'.($miliseg)));
          $fechaEmision = $cabecera->appendChild($fechaEmision);
  
          $razon_social_cliente = $razon_social; // $lecturas['razon_social'];
          $nombreRazonSocial = $xml->createElement('nombreRazonSocial',$razon_social_cliente);
          $nombreRazonSocial = $cabecera->appendChild($nombreRazonSocial);
  
          $domicilioCliente_cliente = $zona_cliente['calle'].' nro. '.$lecturas['numero'];
          $domicilioCliente = $xml->createElement('domicilioCliente',$domicilioCliente_cliente);
          $domicilioCliente = $cabecera->appendChild($domicilioCliente);

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
          
          $total_cobrar = ($lecturas['imp_total']+$lecturas['conexion']+$lecturas['reposicion']+$lecturas['recargo']+$lecturas['aseo']+$lecturas['alumbrado']+$lecturas['afcoop']-$lecturas['ley1886']-$lecturas['dignidad']-$lecturas['devolucion']-$lecturas['desdom']-$lecturas['desap']-$lecturas['desau']-$lecturas['desafcoop']);
          
          $consumo_periodo = round($lecturas['imp_total']-$lecturas['ley1886']-$lecturas['dignidad'] ,2);
          $ajustes_sujetos_iva=($lecturas['conexion']+$lecturas['reposicion']);
          $t_tasas = ($lecturas['aseo']+$lecturas['alumbrado']);
          $t_no_sujeto_iva = round($lecturas['afcoop']+$lecturas['recargo'], 1);
          $t_sujeto_iva = round($lecturas['conexion']+$lecturas['reposicion'], 1);

          //1 montoTotal -> Monto total por el cual se realiza el hecho generador.
          $sin_monto_total = $total_cobrar;
          //var_dump($sin_monto_total);

          //2 montoTotalSujetoIva -> Monto base para el cálculo del crédito fiscal.
          $sin_montoTotalSujetoIva = $total_cobrar - $t_tasas - $t_no_sujeto_iva;
          //var_dump($sin_montoTotalSujetoIva);

          //3 montoTotalMoneda -> Es el Monto Total expresado en el tipo de moneda, si el código de moneda es boliviano deberá ser igual al monto total.
          $sin_montoTotalMoneda = $total_cobrar;
          //var_dump($sin_montoTotalMoneda);

          //4 precioUnitario -> Precio que otorga el contribuyente a su servicio o producto.
          $sin_precio_unitario=$consumo_periodo;
          //var_dump($sin_precio_unitario);

          //5 subTotal -> El subtotal siempre será en bolivianos es igual a la (cantidad * precio unitario) – descuento.
          $sin_subTotal = $total_cobrar - $t_tasas - $t_no_sujeto_iva - $t_sujeto_iva; 
          
          $montoTotal = $xml->createElement('montoTotal', $sin_monto_total);
          $montoTotal = $cabecera->appendChild($montoTotal);

          $montoTotalSujetoIva = $xml->createElement('montoTotalSujetoIva', $sin_montoTotalSujetoIva);///////////// total_cobrar-tasas-aportes
          $montoTotalSujetoIva = $cabecera->appendChild($montoTotalSujetoIva);
  
          $consumoPeriodo = $xml->createElement('consumoPeriodo', $lecturas['kwh']);
          $consumoPeriodo = $cabecera->appendChild($consumoPeriodo);
          //$consumoPeriodo->setAttribute('xsi:nil', 'true');
          
          if($lecturas['ley1886'] > 0){
            $beneficiarioLey1886 = $xml->createElement('beneficiarioLey1886', $lecturas['ci']);
            $beneficiarioLey1886 = $cabecera->appendChild($beneficiarioLey1886);

            $montoDescuentoLey1886 = $xml->createElement('montoDescuentoLey1886', $lecturas['ley1886']);//element vacio
            $montoDescuentoLey1886 = $cabecera->appendChild($montoDescuentoLey1886);

          }else{
            $beneficiarioLey1886 = $xml->createElement('beneficiarioLey1886');
            $beneficiarioLey1886 = $cabecera->appendChild($beneficiarioLey1886);
            $beneficiarioLey1886->setAttribute('xsi:nil', 'true');  

            $montoDescuentoLey1886 = $xml->createElement('montoDescuentoLey1886');//element vacio
            $montoDescuentoLey1886 = $cabecera->appendChild($montoDescuentoLey1886);
            $montoDescuentoLey1886->setAttribute('xsi:nil', 'true');
            }
  
          if($lecturas['dignidad'] > 0){          
            $montoDescuentoTarifaDignidad = $xml->createElement('montoDescuentoTarifaDignidad',$lecturas['dignidad']);
            $montoDescuentoTarifaDignidad = $cabecera->appendChild($montoDescuentoTarifaDignidad);
          }else{
            $montoDescuentoTarifaDignidad = $xml->createElement('montoDescuentoTarifaDignidad');
            $montoDescuentoTarifaDignidad = $cabecera->appendChild($montoDescuentoTarifaDignidad);
            $montoDescuentoTarifaDignidad->setAttribute('xsi:nil', 'true');
          }

          $tasaAseo = $xml->createElement('tasaAseo', (float)$lecturas['aseo']);
          $tasaAseo = $cabecera->appendChild($tasaAseo);
  
          $tasaAlumbrado = $xml->createElement('tasaAlumbrado', (float)$lecturas['alumbrado']);
          $tasaAlumbrado = $cabecera->appendChild($tasaAlumbrado);
  
          $ajusteNoSujetoIva = $xml->createElement('ajusteNoSujetoIva');
          $ajusteNoSujetoIva = $cabecera->appendChild($ajusteNoSujetoIva);
          $ajusteNoSujetoIva->setAttribute('xsi:nil', 'true');
  
          $detalleAjusteNoSujetoIva = $xml->createElement('detalleAjusteNoSujetoIva');
          $detalleAjusteNoSujetoIva = $cabecera->appendChild($detalleAjusteNoSujetoIva);
          $detalleAjusteNoSujetoIva->setAttribute('xsi:nil', 'true');
  
          //conexion
          if($ajustes_sujetos_iva > 0){
            $ajusteSujetoIva = $xml->createElement('ajusteSujetoIva', $ajustes_sujetos_iva);
            $ajusteSujetoIva = $cabecera->appendChild($ajusteSujetoIva);
    
            $detalleAjusteSujetoIva = $xml->createElement('detalleAjusteSujetoIva','{"Cobro por Conexión/Reconexión":'.$ajustes_sujetos_iva.'}');
            $detalleAjusteSujetoIva = $cabecera->appendChild($detalleAjusteSujetoIva);  
          }else{
            $ajusteSujetoIva = $xml->createElement('ajusteSujetoIva', 0);
            $ajusteSujetoIva = $cabecera->appendChild($ajusteSujetoIva);
    
            $detalleAjusteSujetoIva = $xml->createElement('detalleAjusteSujetoIva','{}');
            $detalleAjusteSujetoIva = $cabecera->appendChild($detalleAjusteSujetoIva);  
          }
  
          
          if($t_no_sujeto_iva > 0 ){
            $otrosPagosNoSujetoIva = $xml->createElement('otrosPagosNoSujetoIva', $t_no_sujeto_iva);
            $otrosPagosNoSujetoIva = $cabecera->appendChild($otrosPagosNoSujetoIva);
    
            $detalleOtrosPagosNoSujetoIva = $xml->createElement('detalleOtrosPagosNoSujetoIva','{"OTROS PAGOS (AFCOOP, INTERES MORATORIO, ETC)":'.$t_no_sujeto_iva.'}');
            $detalleOtrosPagosNoSujetoIva = $cabecera->appendChild($detalleOtrosPagosNoSujetoIva);  
          }else{
            $otrosPagosNoSujetoIva = $xml->createElement('otrosPagosNoSujetoIva', 0);
            $otrosPagosNoSujetoIva = $cabecera->appendChild($otrosPagosNoSujetoIva);
    
            $detalleOtrosPagosNoSujetoIva = $xml->createElement('detalleOtrosPagosNoSujetoIva','{}');
            $detalleOtrosPagosNoSujetoIva = $cabecera->appendChild($detalleOtrosPagosNoSujetoIva);  
          }
          
          $otrasTasas = $xml->createElement('otrasTasas','0');
          $otrasTasas = $cabecera->appendChild($otrasTasas);

          $codigoMoneda = $xml->createElement('codigoMoneda','1');
          $codigoMoneda = $cabecera->appendChild($codigoMoneda);
  
          $tipoCambio = $xml->createElement('tipoCambio','1');
          $tipoCambio = $cabecera->appendChild($tipoCambio);

          $montoTotalMoneda = $xml->createElement('montoTotalMoneda', $sin_montoTotalMoneda);//monto total
          $montoTotalMoneda = $cabecera->appendChild($montoTotalMoneda);
  
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
  
          $codigoDocumentoSector = $xml->createElement('codigoDocumentoSector','13');
          $codigoDocumentoSector = $cabecera->appendChild($codigoDocumentoSector);
  
        //DETALLE
        $detalle = $xml->createElement('detalle');
        $detalle = $facturaElectronicaServicioBasico->appendChild($detalle);

        $actividadEconomica = $xml->createElement('actividadEconomica','351000');//sacar de sincronizacion
        $actividadEconomica = $detalle->appendChild($actividadEconomica);

        $codigoProductoSin = $xml->createElement('codigoProductoSin','86311');//sacar de producto homolgar
        $codigoProductoSin = $detalle->appendChild($codigoProductoSin);

        $codigoProducto = $xml->createElement('codigoProducto','2121');//propio codigo
        $codigoProducto = $detalle->appendChild($codigoProducto);

        $descripcion = $xml->createElement('descripcion','CONSUMO');
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

        $xml->formatOutput = true;

        $xml->save('facturas_13/'.$lecturas['idlectura'].'.xml');//Nombre archivo
        $fir = new FirmarXml();
        $fir->firmar('facturas_13/'.$lecturas['idlectura'].'.xml');//Nombre archivo_firmado

        //Insertamos en la tabla factura_13
        $data_fact['cuf'] = $res_str_16.$cuf_act['codigo_control'];
        $data_fact['fecha_emision'] = date('Y-m-d H:i:s');
        $data_fact['estado_fact'] = 'P';//emitido
        $data_fact['id_punto_venta'] = $pv['id_punto_venta'];
        $data_fact['idcliente'] = $lecturas['idcliente'];  
        $data_fact['leyenda_fact'] = $leyenda_fact;
        $data_fact['usuario'] = $this->session->userdata('usuario');
        $data_fact['nro_fact'] = $nro_factura;
        $data_fact['idlectura'] = $lecturas['idlectura'];
        $data_fact['monto_total'] = $total_cobrar;
        $data_fact['cufd'] = $cufd_act['codigo'];
        $this->factura_13_model->insertar($data_fact);

        //Arrays para cuf y nro fact correo
        $array_cuf_correo[$lecturas['idlectura']]=$res_str_16.$cuf_act['codigo_control'];
        $array_nro_fact_correo[$lecturas['idlectura']]=$nro_factura;

        //actualizamos el contador de facturas en 1 del pv
        $data_pv['cont_fact'] = ($nro_factura+1);
        $this->punto_venta_model->actualizar($pv['id_punto_venta'], $data_pv);

        //actualizacmos el campo generado de lectura
        $data_lect['generado']='1';
        $this->lecturas_model->actualizar($lecturas['idlectura'], $data_lect);
        
        $i++;
        $miliseg++;
        $total_fact_xml++;
        $cont_enviado++;
        usleep(1000);
        }//fin foreach while

        //COMPRESION Y ENVIO
        $p = new PharData('./facturas_13/final.tar');

        $pv = $this->punto_venta_model->get_punto_venta($empleado['id_punto_venta']);

        foreach ($lecturas_array as $key => $lecturas)
          $p[$lecturas['idlectura'].'_firmado.xml'] = file_get_contents('./facturas_13/'.$lecturas['idlectura'].'_firmado.xml');
          //for($i=1;$i<=$total_fact_xml;$i++)
        
        $p->compress(Phar::GZ);
        unlink('./facturas_13/final.tar');

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
              
              'archivo' => file_get_contents('facturas_13/final.tar.gz'),
              'hashArchivo' => hash_file('sha256', 'facturas_13/final.tar.gz'),
              'cantidadFacturas' => $total_fact_xml,
              'fechaEnvio' => date("Y-m-d\TH:i:s.v")
              );
              //var_dump($parametros);

          $metodo = array('SolicitudServicioRecepcionMasiva'=> $parametros);
          $resultado = $client->__soapCall('recepcionMasivaFactura', array($metodo));
          $codigoRecepcion = null;
            if($resultado->RespuestaServicioFacturacion->transaccion){
              //var_dump($resultado->RespuestaServicioFacturacion);
              //echo 'masivo enviado exitosamente';
              $data['mensaje_paquete'] = 'Paquete masivo enviado exitosamente';
              $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
              $salida = true;
            }elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
              $salida = false;
              echo 'ERROR: no se envio el paquete';
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
                if($resultado->RespuestaServicioFacturacion->transaccion){//////////////////////////////////////////// VALIDACION EXITOSA
                  $codigoRecepcion = $resultado->RespuestaServicioFacturacion->codigoRecepcion;
                  foreach ($lecturas_array as $key => $lecturas) {
                    unlink('./facturas_13/'.$lecturas['idlectura'].'.xml');
                    
                    $data_factu['estado_fact'] = 'E';//emitido
                    $this->factura_13_model->actualizar_lectura($lecturas['idlectura'], $data_factu);
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////codigo pdf y email

                  }
                  unlink('./facturas_13/final.tar.gz');

                  $data['cont_enviado'] = $cont_enviado;
                  $data['mensaje'] = 'Paquete validado exitosamente';
                  $data['main_content'] = 'generar_facturas_13/calcular_view';
                  $data['title'] = 'Paquete validado exitosamente';
                  $this->load->view('template/template_view', $data);
                  
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
      }// fin else periodo activo

    }// is admin
    else
      redirect(base_url());
  }

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
