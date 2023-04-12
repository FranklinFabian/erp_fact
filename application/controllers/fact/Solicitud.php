<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud extends CI_Controller{
  public function index(){
    if(isLogin()){
      $salida=$this->producto_model->get_json3();
      $sumaCant=0;
      $salidaResultado = array();
      $I=0;
      sort($salida);

      for ($i=0; $i < count($salida) ; $i++) {
        $duplicado = false;
        $sumaCant = (float)$salida[$i]['cantidad_existente_adquisicion'];
        for($j=($i+1) ;$j < count($salida); $j++){
          if(((int)$salida[$i]['id_producto']) == ((int)$salida[$j]['id_producto'])){
            $sumaCant+= $salida[$j]['cantidad_existente_adquisicion'];
            $duplicado = true;
          }
          else
          break;
        }
        if($i==0){
          $salidaResultado[$I]['id_producto']=$salida[$i]['id_producto'];
          $salidaResultado[$I]['nombre_producto']=$salida[$i]['nombre_producto'];
          $salidaResultado[$I]['cantidad_existente_adquisicion']=$sumaCant;  
          $I++;
        }
        else{
          if(((int)$salida[$i]['id_producto']) == ((int)$salida[$i-1]['id_producto']))
            continue;
          else{
            $salidaResultado[$I]['id_producto']=$salida[$i]['id_producto'];
            $salidaResultado[$I]['nombre_producto']=$salida[$i]['nombre_producto'];
            $salidaResultado[$I]['cantidad_existente_adquisicion']=$sumaCant;  
            $I++;  
          }
        }
      }
      $salidaFinal = '';
      foreach ($salidaResultado as $key => $value)
      {
        $salidaFinal.= '"'.$value['nombre_producto'].'",';
      }


      $data['salida'] = $salidaFinal;
      $data['main_content'] = 'solicitud/index_view';
      $data['title'] = 'Solicitud';
      $this->load->view('template/template_view', $data);
      
    }
    else
      redirect(base_url());
  }
  
  public function buscar_producto($codBarras=null){
    if(is_null($codBarras)){
      $postProducto = $this->input->post('nombre_producto');
      //$porciones = explode("|", $postProducto);
      
      $producto = $this->producto_model->get_nombre_producto($postProducto);
      $resultado=$this->producto_model->suma_existentes($producto['id_producto']);
      $suma_stock = $resultado['suma_stock'];
      if (count($producto)>0){
        echo '{"id_producto":'.$producto['id_producto'].', "nombre_producto":"'.$producto['nombre_producto'].'", "cantidad_producto":1, "disponible":'.$suma_stock.'}';
      }
      else echo "";
    }else{
      $producto = $this->producto_model->get_nombre_codBarras($codBarras);
      $resultado=$this->producto_model->suma_existentes($producto['id_producto']);
      $suma_stock = $resultado['suma_stock'];
      if (count($producto)>0){
        echo '{"id_producto":'.$producto['id_producto'].', "nombre_producto":"'.$producto['nombre_producto'].'", "cantidad_producto":1, "disponible":'.$suma_stock.'}';
      }
      else echo "";  
    }
  }

  public function realizar_venta(){
    if(isLogin()){
      //RECIBIENDO DATOS
      $data = json_decode($this->input->get('carrito'));
      $glosa = mb_strtoupper(trim($this->input->get('glosa')));

      //llenando tabla orden
      $empleado = $this->empleado_model->get_empleado($this->session->userdata('id_empleado'));

      $id_orden = $this->orden_model->current_num();
      $data_orden['id_orden'] = $id_orden;
      $data_orden['id_empleado'] = $this->session->userdata('id_empleado');
      $data_orden['fecha_orden'] = date('Y-m-d H:i:s');
      $data_orden['estado_orden'] = '1';
      $data_orden['glosa'] = $glosa;
      $data_orden['contador']=intval($empleado['contador_solicitud_pedido'])+1;

      $this->orden_model->insertar($data_orden);
      
      $n = count($data);
      for ($i=0; $i < $n ; $i++) {
        $idProducto = $data[$i]->id_producto;
        $csalida = $data[$i]->cantidad_producto;

        //insertando tabla items_orden
        $data_items_orden['id_producto'] = $idProducto;
        $data_items_orden['id_orden'] = $id_orden;
        $data_items_orden['cantidad'] = $csalida;
        $this->items_orden_model->insertar($data_items_orden);
      }//fin for principal
      
      echo $id_orden;//para el ajax retorno de la funcion
    }
  }

  public function realizar_venta_credito(){
    if(isLogin()){
      //verificamos que el codigo cliente se envie y exista
      $cliente = $this->input->get('cliente');
      $porciones_cliente = explode("|", $cliente);
      if(count($porciones_cliente)>1){
        $id_datos_cliente = (int)$porciones_cliente[1];
        $cli_existe=$this->datos_cliente_model->get_datos_cliente($id_datos_cliente);  
      }else 
        $cli_existe=null;

      if(!is_null($cli_existe)){//verificamos que el codigo cliente se envie y exista
        //llenando tabla orden
        $id_orden = $this->orden_model->current_num();
        $data_orden['id_orden'] = $id_orden;
        $data_orden['id_empleado'] = $this->session->userdata('id_empleado');
        $data_orden['fecha_orden'] = date('Y-m-d H:i:s');
        $data_orden['estado_orden'] = '2';
        $data_orden['justificacion'] = 'Solicitud';
        $data_orden['tipo_orden'] = '2';
        $data_orden['monto_descuento'] = $this->input->get('monto_descuento_credito');
        $this->orden_model->insertar($data_orden);
  
        //llenado tabla salida
        $id_salida = $this->salida_model->current_num();
        $data_salida['id_salida'] = $id_salida;
        $data_salida['id_orden'] = $id_orden;
        $data_salida['id_empleado_responsable_salida'] = $this->session->userdata('id_empleado');
        $data_salida['fecha_salida'] = date('Y-m-d H:i:s');
        $this->salida_model->insertar($data_salida);
  
        //RECIBIENDO DATOS
        //para adquisicion_producto
        $data = json_decode($this->input->get('carrito'));
        $monto_transaccion = 0;
  
  
        //PARA TABLA ORDEN Y PEPS
        $n = count($data);
        for ($i=0; $i < $n ; $i++) {
          $idProducto = $data[$i]->id_producto;
          $csalida = $data[$i]->cantidad_producto;
          $precio_venta = $data[$i]->precio_venta;
          $total_valorado = 0;
          $monto_transaccion+=$data[$i]->sub_total;
  
          //insertando tabla items_orden
          $data_items_orden['id_producto'] = $idProducto;
          $data_items_orden['id_orden'] = $id_orden;
          $data_items_orden['cantidad'] = $csalida;
          $data_items_orden['precio_venta'] = $precio_venta;
          $this->items_orden_model->insertar($data_items_orden);
  
          $ultimoID = $this->adquisicion_producto_model->ultimoID($idProducto);
          $ultima_fila = $this->adquisicion_producto_model->get_id_adquisicion($ultimoID['ultimoID']);        
          $ultimo_saldo_fisico=$ultima_fila['saldo_fisico'];
          $ultimo_saldo_valorado = $ultima_fila['saldo_valorado'];
    
          $item_adq_prod = $this->adquisicion_producto_model->get_ingresos($idProducto);
          
          //PEPS 
          foreach ($item_adq_prod as $key2 => $item) {
            if($item['cantidad_existente_adquisicion'] > $csalida){
              //multiplicando y sumando
              $total_valorado += ($item['precio_adquisicion'] * $csalida);
    
              $data_ad['cantidad_existente_adquisicion'] = $item['cantidad_existente_adquisicion'] - $csalida;
              $this->adquisicion_producto_model->actualizar($item['id_adquisicion_producto'], $data_ad);
              break;
            }if(($item['cantidad_existente_adquisicion'] == $csalida)){
              //multiplicando y sumando
              $total_valorado += ($item['precio_adquisicion'] * $csalida);
    
              $data_ad['cantidad_existente_adquisicion'] = 0;
              $this->adquisicion_producto_model->actualizar($item['id_adquisicion_producto'], $data_ad);
              break;
            }else{
              //multiplicando y sumando
              $total_valorado += ($item['precio_adquisicion'] * $item['cantidad_existente_adquisicion']);
    
              $csalida = $csalida - $item['cantidad_existente_adquisicion'];
              $data_ad['cantidad_existente_adquisicion'] = 0;
              $this->adquisicion_producto_model->actualizar($item['id_adquisicion_producto'], $data_ad);
            }//fin else foreach
          }//fin foreach PEPS
    
          //llenado de la tabla adquisicion_producto (salida)
          $data_adquisicion_producto['tipo'] = 0;
          $data_adquisicion_producto['id_salida'] = $id_salida;
          $data_adquisicion_producto['id_producto'] = $idProducto;
          
          $data_adquisicion_producto['cantidad_salida'] = $data[$i]->cantidad_producto;
          $data_adquisicion_producto['saldo_fisico'] = ($ultimo_saldo_fisico - $data[$i]->cantidad_producto);
          $data_adquisicion_producto['salida_valorado'] = $total_valorado;
          $data_adquisicion_producto['saldo_valorado'] = ($ultimo_saldo_valorado - $total_valorado);
          //para n_salida
          $ultima_fila = $this->adquisicion_producto_model->ultimo_nro_adquisicion(0, $idProducto);
          if(is_null($ultima_fila))
            $data_adquisicion_producto['n_salida']=1;
          else 
            $data_adquisicion_producto['n_salida']=($ultima_fila['n_salida']+1);
    
          $this->adquisicion_producto_model->insertar($data_adquisicion_producto);
    
        }//fin for principal de productos
  
        //Para tabla credito
        //$cliente = $this->input->get('cliente');
        //$porciones_cliente = explode("|", $cliente);
        //$id_datos_cliente = (int)$porciones_cliente[1];
  
        $data_credito = array();
        $id_credito = $this->credito_model->current_num();
        $data_credito['id_credito'] = $id_credito;
        $data_credito['id_orden'] = $id_orden;
        $data_credito['estado'] = 1;
        $data_credito['fecha_limite'] = $this->input->get('fecha_limite');
        $data_credito['id_datos_cliente'] = $id_datos_cliente;
        $data_credito['monto_total_credito'] = $monto_transaccion;
        $this->credito_model->insertar($data_credito);
        
        //Para tabla pago parcial
        $a_cuenta = $this->input->get('a_cuenta');
        if($a_cuenta > 0){
          $data_pago_parcial = array();
          $id_pago_parcial = $this->pago_parcial_model->current_num();
          $data_pago_parcial['id_pago_parcial'] = $id_pago_parcial;
          $data_pago_parcial['monto_parcial'] = $a_cuenta;
          $data_pago_parcial['fecha_pago'] = date('Y-m-d');
          $data_pago_parcial['nota_pago'] = 'PAGO A CUENTA EL DÍA DEL PEDIDO';
          $data_pago_parcial['id_credito'] = $id_credito;
          $this->pago_parcial_model->insertar($data_pago_parcial);
        }
        echo $id_orden;//para el ajax retorno de la funcion        
      }else
        echo 'error_cliente';
    }
  }//fin venta credito

  public function success_solicitud($id_orden=null){
    if(isLogin()){
      if(is_null($id_orden))
        redirect(base_url().'solicitud');
      else{
        $orden = $this->orden_model->get_orden($id_orden);
        $data['orden'] = $orden;
        $data['main_content'] = 'solicitud/success_solicitud_view';
        $data['title'] = 'Solicitud';
        $this->load->view('template/template_view', $data);
      }
    }
    else
    redirect(base_url());
  }

  public function error_cliente(){
    if(isLogin()){
      $data['main_content'] = 'solicitud/error_cliente_view';
      $data['title'] = 'Error cliente';
      $this->load->view('template/template_view', $data);
    }
    else
    redirect(base_url());
  }

  public function success_especial($id_factura){
    if(isLogin()){
      $factura = $this->factura_model->get_factura($id_factura);
      $data['factura'] = $factura;
      $data['main_content'] = 'solicitud/success_especial_view';
      $data['title'] = 'Solicitud';
      $this->load->view('template/template_view', $data);
      //echo "Orden: ".$id_factura;
    }
  }

  function impresion_factura($id_orden){

    if(isLogin()){
      $this->load->library('ciqrcode');
      $datos = $this->orden_model->get_all_orden_fact_cliente($id_orden);
      $data['datos'] = $datos;
      $data['id_orden'] = $id_orden;
      $data['title'] = 'Factura';
      $configuracion = $this->configuracion_model->get_all();
      if(!empty($configuracion) && ($configuracion['papel_factura']==0))
        $this->load->view('solicitud/impresion_factura_rollo_view', $data);
      else
        $this->load->view('solicitud/impresion_factura_normal_view', $data);
    }
    else{
      redirect(base_url());
    }
  }

  function impresion_factura_especial($id_factura){

    if(isLogin()){
      $this->load->library('ciqrcode');
      $factura = $this->factura_model->get_fact_cli($id_factura);

      $data['factura'] = $factura;
      $data['title'] = 'Factura';
      $configuracion = $this->configuracion_model->get_all();
      if(!empty($configuracion) && ($configuracion['papel_factura']==0))
        $this->load->view('solicitud/impresion_factura_especial_rollo_view', $data);
      else
        $this->load->view('solicitud/impresion_factura_especial_normal_view', $data);
    }
    else{
      redirect(base_url());
    }
  }

  function impresion_constancia($id_orden=null, $credito=null){
    if(isLogin() && (!is_null($id_orden))){
      $datos = $this->orden_model->get_orden($id_orden);
      $configuracion = $this->configuracion_model->get_all();
      if(is_null($configuracion)){
        $configuracion['logo_linea1'] = 'MI EMPRESA';
        $configuracion['logo_linea2'] = 'MI SLOGAN';
        $configuracion['direccion'] = 'AV. SIEMPRE VIVA NRO. 16, SANTA CRUZ - BOLIVIA';
        $configuracion['telefono'] = '';
        $configuracion['whatsapp'] = '';
        $configuracion['pie_impresion'] = 'GRACIAS POR SU PREFERENCIA.';
      }

      $data['datos'] = $datos;
      $data['id_orden'] = $id_orden;
      $data['configuracion'] = $configuracion;
      $data['title'] = 'Nota de venta';
      if(is_null($credito))
        $this->load->view('solicitud/impresion_constancia_view', $data);
      else{
        $data['data_credito'] = $this->credito_model->get_credito_datos_cliente_id_orden($id_orden);
        $this->load->view('solicitud/impresion_constancia_credito_view', $data);
      }
    }else
      redirect(base_url());
  }// fin impresion_constancia

  public function lista_ventas($fecha){
    if(isLogin()){
      $ventas = array();
      $ventas = $this->orden_model->ventas_dia($fecha);
      
      $data['ventas'] = $ventas;
      $data['main_content'] = 'solicitud/lista_ventas_view';
      $data['title'] = 'Lista de ventas';
      $this->load->view('template/template_view', $data);
    }else
      redirect(base_url());
  }

  public function anular($id_orden){
    if(isLogin()){
      //actualizando la tabla orden para anulado
      $data_orden['estado_orden'] = '3';
      $data_orden['justificacion'] = 'ANULADO EN FECHA '.date('Y-m-d H:i:s').' POR USUARIO '.$this->session->userdata('usuario');
      $data_orden['tipo_orden'] = '3';
      $this->orden_model->actualizar($id_orden, $data_orden);

      //Insertando datos tabla nro_adquisicion por anulacion/devolucion
      $id_nro_adquisicion = $this->nro_adquisicion_model->current_num();
      $data_nro_ad['id_nro_adquisicion'] = $id_nro_adquisicion;
      $data_nro_ad['fecha_adquisicion'] = date('Y-m-d H:i:s');
      $data_nro_ad['id_empleado'] = $this->session->userdata('id_empleado');
      $data_nro_ad['proveedor'] = "ANULACIÓN/DEVOLUCIÓN";
      $data_nro_ad['observacion_general'] = "INGRESO POR ANULACIÓN O- ".$id_orden;
      $data_nro_ad['doc_respaldo'] = "DEVOLUCIÓN O-";
      $data_nro_ad['nro_doc_respaldo'] = $id_orden;
      $this->nro_adquisicion_model->insertar($data_nro_ad);

      //Insertando los productos anulados o devueltos en tabla adquisicion_producto
      $items_orden = $this->items_orden_model->get_items($id_orden);
      $n_elementos = count($items_orden);
      $data_adquisicion_producto = array();
      //$id_nro_adquisicion = $this->nro_adquisicion_model->current_num();

      for($i=0; $i<$n_elementos; $i++){
        //para insertar adquisicion_producto
        $ultima_fila = $this->adquisicion_producto_model->ultimo_nro_adquisicion(1, $items_orden[$i]['id_producto']);

        $data_adquisicion_producto['tipo']=1;
        $data_adquisicion_producto['id_nro_adquisicion']=$id_nro_adquisicion;
        $data_adquisicion_producto['id_producto']=$items_orden[$i]['id_producto'];
        $data_adquisicion_producto['cantidad_ingreso']=$items_orden[$i]['cantidad'];
        $data_adquisicion_producto['cantidad_existente_adquisicion']=$items_orden[$i]['cantidad'];
        $data_adquisicion_producto['precio_adquisicion']=$ultima_fila['precio_adquisicion'];
        $data_adquisicion_producto['observacion']="INGRESO POR ANULACIÓN/DEVOLUCIÓN";
        // para el n_ingreso
        $data_adquisicion_producto['n_ingreso']=($ultima_fila['n_ingreso']+1);
        //para datos kardex restantes
        $maxID = $this->adquisicion_producto_model->ultimoID($items_orden[$i]['id_producto']);
        $ultimoID = $maxID['ultimoID'];
        $ultimaFila = $this->adquisicion_producto_model->get_adquisicion_producto($ultimoID);
        $data_adquisicion_producto['saldo_fisico']=$items_orden[$i]['cantidad']+$ultimaFila['saldo_fisico'];
        $data_adquisicion_producto['ingreso_valorado']=($items_orden[$i]['cantidad']*$ultima_fila['precio_adquisicion']);
        $data_adquisicion_producto['saldo_valorado']=($items_orden[$i]['cantidad']*$ultima_fila['precio_adquisicion'])+$ultimaFila['saldo_valorado'];
        //var_dump($data_adquisicion_producto);
        $this->adquisicion_producto_model->insertar($data_adquisicion_producto);
      }

      //actualizando tabla credito, solo si es una venta a credito
      $credito = $this->credito_model->get_credito_id_orden($id_orden);
      if(!is_null($credito)){
        $data_credito['estado']='2';//estado 2 anulado
        $this->credito_model->actualizar($credito['id_credito'], $data_credito);
      }
      
      redirect(base_url().'solicitud/lista_ventas/'.date('Y-m-d'));
    }else
      redirect(base_url());
  }

  public function anular_especial($id_factura){
    if(isLogin()){
      //actualizando la tabla factura para anulado
      $data_fact['monto_transaccion']=0;
      $data_fact['codigo_control']=NULL;
      $data_fact['estado']=false;
      $this->factura_model->actualizar($id_factura, $data_fact);
      redirect(base_url().'solicitud/lista_especial/');
    }else
      redirect(base_url());
  }

  public function especial(){
    if(isLogin()){
      $data['main_content'] = 'solicitud/especial_view';
      $data['title'] = 'Venta especial';
      $this->load->view('template/template_view', $data);  
    }else
      redirect(base_url());
  }

  public function generar_venta_especial(){
    if(isLogin()){
      $nit_ci = $this->input->post('nit_ci');
      $razon_social = mb_strtoupper(trim($this->input->post('razon_social')));
      $monto_transaccion = $this->input->post('monto_transaccion');
      $descripcion_especial = mb_strtoupper(trim($this->input->post('descripcion_especial')));      
      $id_cliente = null;
      //PARA TABLA CLIENTE
      //hay factura
      if(($nit_ci!='') && ($razon_social!='')){
        $cliente = $this->cliente_model->get_clienteNITCI($nit_ci);
        if(!is_null($cliente))
          $id_cliente = $cliente['id_cliente'];
        else{
          $id_cliente = $this->cliente_model->current_num();
        }

        //$generarFactura = true;
        // nuevo registro de cliente
        if(is_null($cliente) && ($nit_ci!="")){
          $data_cliente['nit_ci'] = $nit_ci;
          $data_cliente['razon_social'] = $razon_social;
          $this->cliente_model->insertar($data_cliente);
        }else{
        //si la razon_social es distinto actualizar
          if($cliente['razon_social'] != $razon_social){
            $data_cliente['razon_social'] = $razon_social;
            $this->cliente_model->actualizar($cliente['id_cliente'], $data_cliente);
          }
        }
      }//fin hay factura

      $id_factura = $this->factura_model->current_num();
      $this->load->library('CodigoControl');
      $codigo_control = $this->codigocontrol->generar($this->config->item('autorizacion'), $id_factura, $nit_ci, (str_replace("-", "", substr(date('Y-m-d H:i:s'),0 , 10))), round($monto_transaccion), $this->config->item('llave_sin'));
      $data_factura['id_factura'] = $id_factura;
      $data_factura['fecha_transaccion'] = date('Y-m-d H:i:s');
      $data_factura['monto_transaccion'] = $monto_transaccion;
      $data_factura['codigo_control'] = $codigo_control;
      $data_factura['estado'] = true;
      $data_factura['fact_nit_ci'] = $nit_ci;
      $data_factura['fact_razon_social'] = $razon_social;
      
      $data_factura['id_cliente'] = $id_cliente;
      $data_factura['descripcion_especial'] = $descripcion_especial;
      //var_dump($data_factura);
      $this->factura_model->insertar($data_factura);
      redirect(base_url().'solicitud/success_especial/'.$id_factura);
      //echo $nit_ci.' '.$razon_social.' '.$monto_transaccion.' '.$descripcion_especial;
    }else
      redirect(base_url());
  }

  public function buscar_nit_ci(){

    $nit_ci = trim($this->input->get('nit_ci'));
    $cliente = $this->cliente_model->buscar_nit_ci($nit_ci);
    if(!is_null($cliente))
      echo $cliente['razon_social'];
    else
      echo '';
  }

  // FALTA LISTA ESPECIAL
  public function lista_especial(){
    if(isLogin()){      
      $data['facturas'] = $this->factura_model->get_facturas_especiales();
      $data['main_content'] = 'solicitud/lista_especial_view';
      $data['title'] = 'Solicitud';
      $this->load->view('template/template_view', $data);
    }
  }


}//fin class
