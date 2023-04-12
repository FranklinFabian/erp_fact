<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emision_individual extends CI_Controller{

  public $repetidos_afcoop=array();
  public $i=1;

  public function index(){//MENU
    if(isLogin()){
      $data['main_content'] = 'emision_individual/index_view';
      $data['title'] = 'Menu emision individual';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }
  public function abonado_no_encontrado(){
    if(isLogin()){
      $data['main_content'] = 'emision_individual/abonado_no_encontrado_view';
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
        redirect(base_url().'emision_individual/abonado_no_encontrado');
      
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
      $data['main_content'] = 'emision_individual/cargar_abonado_view';
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
      $data_lect['idservicio'] = $abonado['idservicio'];
      $data_lect['idcategoria'] = $abonado['idcategoria'];
      $data_lect['indice'] = $this->input->post('lectura_actual');
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
      
      $data_lect['mulmed'] = $this->input->post('factor_mul');
      $data_lect['kwh'] = $this->input->post('consumo_kwh');
      $data_lect['potencia'] = $this->input->post('potencia');
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

      $lec_observada=$this->input->post('lec_observada');
      if($lec_observada > 0){
        $data_lecturas_observadas['idlectura']=$idlectura;
        $data_lecturas_observadas['idtipo']=$lec_observada;
        $data_lecturas_observadas['usuario']=$this->session->userdata('usuario');
        $this->lecturas_observadas_model->insertar($data_lecturas_observadas);
      }
      
      $this->calcular($idlectura);
    }
    else
      redirect(base_url());
  }

  public function calcular($idlectura){
    if(isAdmin()){
      $periodo_act = $this->periodos_model->get_activo();
      $factores = $this->factores_model->get_factor_periodo($periodo_act['idperiodo']);
      if(is_null($periodo_act) || is_null($factores))
        echo 'Error al obtener el periodo o factor';
      else{
        $lecturas = $this->calculo_lecturas_model->get_lecturas_unica($periodo_act['idperiodo'], 1, $idlectura);
        // var_dump($lecturas);
        // var_dump($periodo_act);
        foreach ($lecturas as $key => $value) {
          
          switch ($value['idcategoria']) {
            case '1': $importe_residencial = $this->residencial($value, $factores);
                      $this->lecturas_model->actualizar($importe_residencial['idlectura'], $importe_residencial);
                    break;
            case '2': $importe_general = $this->general($value, $factores);
                      $this->lecturas_model->actualizar($importe_general['idlectura'], $importe_general);
                      break;
            case '3': $importe_ind_menor = $this->industrial_menor($value, $factores);
                      $this->lecturas_model->actualizar($importe_ind_menor['idlectura'], $importe_ind_menor);
                      break;
            case '4': $importe_ind_mayor = $this->industrial_mayor($value, $factores);
                      $this->lecturas_model->actualizar($importe_ind_mayor['idlectura'], $importe_ind_mayor);
                      break;
            case '5': $importe_alumbrado_publico = $this->alumbrado_publico($value, $factores);
                      $this->lecturas_model->actualizar($importe_alumbrado_publico['idlectura'], $importe_alumbrado_publico);
                      break;

          }//fin switch
        }//fin foreach

        //echo 'El calculo finalizo con exito. <a href="'.base_url().'"> volver al inicio</a> ';//// enviar a generar factura
        $this->generar_fact($idlectura);
      }

    }
    else
      redirect(base_url());
  }// fin funcion calcular

  public function generar_fact($idlectura){
    $periodo_act = $this->periodos_model->get_activo();
    $lecturas_array = $this->generar_facturas_13_model->get_lecturas_unica($periodo_act['idperiodo'], 1, $idlectura);
    $empleado = $this->empleado_model->get_empleado($this->session->userdata('id_empleado'));
    
    $pv = $this->punto_venta_model->get_punto_venta($empleado['id_punto_venta']);
    $cufd_act = $this->cufd_model->get_cufd_by_id_pv($pv['id_punto_venta']);        
    foreach ($lecturas_array as $key => $lecturas) {
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
        $tipo_emision = 1;
        $tipo_factura = 1;
        $tipo_doc_sector = 13;

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

      $origen = 'facturas_13/'.$lecturas['idlectura'].'_firmado.xml';
      $destino = 'facturas_13/'.$lecturas['idlectura'].'_firmado.gz';
      $fp = fopen($origen, "r");
      $data_compress = fread ($fp, filesize($origen));
      fclose($fp);
      $zp = gzopen($destino, "w9");
      gzwrite($zp, $data_compress);
      gzclose($zp);

      //Insertamos en la tabla factura_13
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
      //$miliseg++;
      ///////////////////////////////////////////////////////////////////////////////////ENVIANDO LA FACTURA
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
            'archivo' => file_get_contents('facturas_13/'.$lecturas['idlectura'].'_firmado.gz'),//$lecturas['idlectura']
            'fechaEnvio' => date("Y-m-d\TH:i:s.v"), 
            'hashArchivo' => hash_file('sha256', 'facturas_13/'.$lecturas['idlectura'].'_firmado.gz'),//$lecturas['idlectura']
            );
            //var_dump($parametros);
        $metodo = array('SolicitudServicioRecepcionFactura'=> $parametros);
        $resultado = $client->__soapCall('recepcionFactura', array($metodo));

        if($resultado->RespuestaServicioFacturacion->transaccion){          
          /////////////////////////////////////////////////////////////////PDF
          $configuracion = $this->configuracion_model->get_all();
          if(is_null($configuracion)){
            $configuracion['logo_linea1'] = 'MI EMPRESA';
            $configuracion['logo_linea2'] = 'MI SLOGAN';
            $configuracion['direccion'] = 'AV. SIEMPRE VIVA NRO. 16, SANTA CRUZ - BOLIVIA';
            $configuracion['telefono'] = '';
            $configuracion['whatsapp'] = '';
            $configuracion['pie_impresion'] = 'GRACIAS POR SU PREFERENCIA.';
          }
          $factura = $this->factura_13_model->get_factura_lectura($lecturas['idlectura']);
          if(is_null($factura))
          echo 'Factura no disponible: id '.$factura['idfactura_13'];
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
          
          $html = $this->load->view('gestion_factura/impresion_factura_13_pdf_view', $data, true);
          $pdf->writeHTML($html, true, false, true, false, '');
          $pdf->Output(getcwd().'/facturas_13/'.$lecturas['idlectura'].'_'.$factura['cuf'].'.pdf', 'F');

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
            $this->email->subject($this->config->item('razonSocial').' Factura Servicios Básicos Nro. '.$factura['nro_fact'].' periodo '.($periodo_act['emision']));
            $this->email->message('
            <p>
              Consultar en SIAT <a target="_blank" href="'.$this->config->item('url_qr').'nit='.$this->config->item('nit').'&cuf='.$factura['cuf'].'&numero='.$factura['nro_fact'].' ">aquí</a>
            </p> 
            ');
  
            $this->email->attach(getcwd().'/facturas_13/'.$factura['idlectura'].'_'.$factura['cuf'].'.pdf');
            $this->email->attach(getcwd().'/facturas_13/'.$factura['idlectura'].'_firmado.xml');
            $this->email->send();
          }

          if(!is_null($lecturas['correo']))
            echo 'Factura enviado a '.$lecturas['correo'].' correctamente. <a href="'.base_url().'">Volver a Inicio</a>';
          else
            echo 'No se encontro correo electronico. <a href="'.base_url().'">Volver a Inicio</a>';


          unlink('./facturas_13/'.$lecturas['idlectura'].'.xml');
          //unlink('./facturas_13/'.$lecturas['idlectura'].'_firmado.xml');
          
        }
        elseif($resultado->RespuestaServicioFacturacion->transaccion == false){
          echo 'ERROR: FALSE';
          var_dump($resultado->RespuestaServicioFacturacion);
        }else{
          echo 'Error desconocido.';
        }


      }//fin foreach while




  }

  public function residencial($lectura, $factores){
    $kwh = $lectura['kwh'];
    $importe=array();

    if(($kwh >= 0) && ($kwh <= 20)){/////////////////////////////////////////0_20///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['re_020'],1);
      $importe['imp_adic']=0;
      //DIGNIDAD Aberiguamos si el cliente tiene solo 1 unico abonado
      $abonado_dignidad = $this->calculo_lecturas_model->contar_abonados_residenciales($lectura['idcliente']);
      if(((int)$abonado_dignidad['nro_abonados'])==1)
        $importe['dignidad']=round(($importe['imp_fijo']*0.25), 1);
      else{
        $importe['dignidad']=0;
        $importe['frepetido']=1;
      }//FIN DIGNIDAD
      //LEY1886 
      $ley1886=$this->calculo_lecturas_model->get_vigente();
      $abonado_ley1886=$this->calculo_lecturas_model->beneficiario_ley1886($lectura['idabonado'], $ley1886['idley1886']);
      if(!is_null($abonado_ley1886))
        $importe['ley1886']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.2, 1);
      else
        $importe['ley1886']=0;
      // FIN LEY
      $importe['imp_total']=$importe['imp_fijo'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))
        $importe['aseo']=round($importe['imp_fijo']*0.87*($factores['aseo']), 1);
      else 
        $importe['aseo']=0;//ASEO

      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round($importe['imp_fijo']*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;//ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo'])){
          $importe['devolucion']=$importe['imp_fijo'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      if($importe['dignidad']==0)
        $importe['freg_ene0']=1;
      else 
        $importe['freg_ene0']=0;

      return $importe;

    }elseif(($kwh >= 21) && ($kwh <= 100)){/////////////////////////////////////////21_100///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['re_020'],1);
      $importe['imp_adic']=round((($lectura['kwh']-20)*$factores['re_100']),1);
      //DIGNIDAD Aberiguamos si el cliente tiene solo 1 unico abonado
      $abonado_dignidad = $this->calculo_lecturas_model->contar_abonados_residenciales($lectura['idcliente']);
      if((((int)$abonado_dignidad['nro_abonados'])==1) && ($kwh <70))
        $importe['dignidad']=round((($importe['imp_fijo']+$importe['imp_adic'])*0.25), 1);
      else{
          $importe['dignidad']=0;
          $importe['frepetido']=1;
      }//FIN DIGNIDAD
        //LEY1886 
      $ley1886=$this->calculo_lecturas_model->get_vigente();
      $abonado_ley1886=$this->calculo_lecturas_model->beneficiario_ley1886($lectura['idabonado'], $ley1886['idley1886']);
      if(!is_null($abonado_ley1886))
        $importe['ley1886']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.2, 1);
      else
        $importe['ley1886']=0;
      // FIN LEY
      $importe['imp_total']=$importe['imp_fijo']+$importe['imp_adic'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))      
        $importe['aseo']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;// FIN ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo']+$importe['imp_adic'])){
          $importe['devolucion']=$importe['imp_fijo']+$importe['imp_adic'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      if($importe['dignidad']==0)
        $importe['freg_ene0']=1;
      else 
        $importe['freg_ene0']=0;

      return $importe;

    }else{/////////////////////////////////////////100 ADE///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['re_020'],1);
      $importe['imp_adic']=round((80*$factores['re_100']),1) + round((($lectura['kwh']-100)*$factores['re_ade']),1);
      $importe['dignidad']=0;// kwh > 100 no reciben beneficio
      $importe['frepetido']=1;      
      //LEY1886 
      $ley1886=$this->calculo_lecturas_model->get_vigente();
      $abonado_ley1886=$this->calculo_lecturas_model->beneficiario_ley1886($lectura['idabonado'], $ley1886['idley1886']);
      if(!is_null($abonado_ley1886))
        $importe['ley1886']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.2, 1);
      else
        $importe['ley1886']=0;
      // FIN LEY
      $importe['imp_total']=$importe['imp_fijo']+$importe['imp_adic'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))      
        $importe['aseo']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['aseo']=round((($importe['imp_fijo']+$importe['imp_adic']))*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ALUMBRADO
      $importe['alumbrado']=round((($importe['imp_fijo']+$importe['imp_adic']))*0.87*($factores['alumbrado']), 1);
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo']+$importe['imp_adic'])){
          $importe['devolucion']=$importe['imp_fijo']+$importe['imp_adic'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      if($importe['dignidad']==0)
        $importe['freg_ene0']=1;
      else 
        $importe['freg_ene0']=0;
      return $importe;
    }//fin else 100_ade
  }//Fin funcion RESIDENCIAL

  public function general($lectura, $factores){
    $kwh = $lectura['kwh'];
    $importe=array();

    if(($kwh >= 0) && ($kwh <= 20)){//GENERAL/////////////////////////////0_20///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['ge_020'],1);
      $importe['imp_adic']=0;
      //DIGNIDAD
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      $importe['imp_total']=$importe['imp_fijo'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))
        $importe['aseo']=round($importe['imp_fijo']*0.87*($factores['aseo']), 1);
      else 
        $importe['aseo']=0;//ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round($importe['imp_fijo']*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;//ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo'])){
          $importe['devolucion']=$importe['imp_fijo'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;

    }elseif(($kwh >= 21) && ($kwh <= 100)){//GENERAL////////////////////////////////21_100///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['ge_020'],1);
      $importe['imp_adic']=round((($lectura['kwh']-20)*$factores['ge_100']),1);
      //DIGNIDAD Aberiguamos si el cliente tiene solo 1 unico abonado
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      
      $importe['imp_total']=$importe['imp_fijo']+$importe['imp_adic'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))      
        $importe['aseo']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;// FIN ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo']+$importe['imp_adic'])){
          $importe['devolucion']=$importe['imp_fijo']+$importe['imp_adic'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;

    }else{////GENERAL////////////////////////////100 ADE///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['ge_020'],1);
      $importe['imp_adic']=round((80*$factores['ge_100']),1) + round((($lectura['kwh']-100)*$factores['ge_ade']),1);
      $importe['dignidad']=0;// kwh > 100 no reciben beneficio
      $importe['frepetido']=0;      
      //LEY1886 
      $importe['ley1886']=0;
      // FIN LEY
      $importe['imp_total']=$importe['imp_fijo']+$importe['imp_adic'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))      
        $importe['aseo']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['aseo']=round((($importe['imp_fijo']+$importe['imp_adic']))*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ALUMBRADO
      $importe['alumbrado']=round((($importe['imp_fijo']+$importe['imp_adic']))*0.87*($factores['alumbrado']), 1);
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo']+$importe['imp_adic'])){
          $importe['devolucion']=$importe['imp_fijo']+$importe['imp_adic'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;
      return $importe;
    }//fin else 100_ade
  }//Fin funcion GENERAL

  public function industrial_menor($lectura, $factores){
    $kwh = $lectura['kwh'];
    $importe=array();

    if(($kwh >= 0) && ($kwh <= 50)){//IND MENOR /////////////////////////////0_50///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['i1_050'],1);
      $importe['imp_adic']=0;
      //DIGNIDAD
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      $importe['imp_total']=$importe['imp_fijo'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))
        $importe['aseo']=round($importe['imp_fijo']*0.87*($factores['aseo']), 1);
      else 
        $importe['aseo']=0;//ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round($importe['imp_fijo']*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;//ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo'])){
          $importe['devolucion']=$importe['imp_fijo'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;

    }elseif(($kwh >= 51)){//IND MENOR////////////////////////////////>51///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['i1_050'],1);
      $importe['imp_adic']=round((($lectura['kwh']-50)*$factores['i1_ade']),1);
      //DIGNIDAD Aberiguamos si el cliente tiene solo 1 unico abonado
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      
      $importe['imp_total']=$importe['imp_fijo']+$importe['imp_adic'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))      
        $importe['aseo']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;// FIN ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo']+$importe['imp_adic'])){
          $importe['devolucion']=$importe['imp_fijo']+$importe['imp_adic'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;
    }//fin if
    
  }//Fin funcion IND MENOR

  public function industrial_mayor($lectura, $factores){
    $kwh = $lectura['kwh'];
    $importe=array();
      
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=0;
      $importe['imp_adic']=$kwh*$factores['i2_ade'];
      $importe['imp_poten']=round($lectura['potencia']*$factores['i2_dem'],1);
      //DIGNIDAD
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      $importe['imp_total']=$importe['imp_adic']+$importe['imp_poten'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))
        $importe['aseo']=round($importe['imp_total']*0.87*($factores['aseo']), 1);
      else 
        $importe['aseo']=0;//ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round($importe['imp_total']*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;//ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_total'])){
          $importe['devolucion']=$importe['imp_total'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;    
  }//Fin funcion IND MAYOR

  public function alumbrado_publico($lectura, $factores){
    $kwh = $lectura['kwh'];
    $importe=array();
      
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=0;
      $importe['imp_adic']=round($kwh*$factores['ta_ade'], 1);
      $importe['imp_poten']=0;
      //DIGNIDAD
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      $importe['imp_total']=$importe['imp_adic'];
      $importe['aseo']=0;//ASEO
      $importe['alumbrado']=0;//ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_total'])){
          $importe['devolucion']=$importe['imp_total'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;    
  }//Fin funcion IND MAYOR


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
