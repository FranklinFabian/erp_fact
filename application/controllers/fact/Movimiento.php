<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movimiento extends CI_Controller
{
  public function index()
  {
    if(isLogin() && ($this->session->userdata['nivel']>1))
    {
      $data['main_content'] = 'movimiento/index_view';
      $data['title'] = 'movimientos';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function buscar()
  {
    if(isLogin() && ($this->session->userdata['nivel']>1))
    {
      $id_orden = $this->input->post('id_orden');
      $orden = $this->orden_model->get_orden($id_orden);
      $data['id_orden'] = $id_orden;
      $data['orden'] = $orden;
      $this->load->view('movimiento/buscar_view', $data);
    }
    else
      redirect(base_url());
  }

  public function atender($id_orden)
  {
    if(isLogin() && ($this->session->userdata['nivel']>1))
    {
      $data['main_content'] = 'movimiento/atender_view';
      $data['title'] = 'Atender correlativo N° '.$id_orden;
      $data['orden'] = $this->orden_model->get_orden($id_orden);
      $data['items_orden'] = $this->items_orden_model->get_items($id_orden);
      
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function procesar_solicitud($id_orden, $n)
  {
    if(isLogin() && ($this->session->userdata['nivel']>1)){

      //llenando la tabla salida
      $id_salida = $this->salida_model->current_num();
      $data_salida['id_salida'] = $id_salida;
      $data_salida['id_orden'] = $id_orden;
      $data_salida['id_empleado_responsable_salida'] = $this->session->userdata('id_empleado');
      $data_salida['fecha_salida'] = date('Y-m-d H:i:s');
      $data_salida['observacion_salida'] = $this->input->post('observacion_salida');
      $this->salida_model->insertar($data_salida);

      for ($i=0; $i < $n ; $i++) { 
        $idProducto = $this->input->post('idProducto_'.$i);
        $csalida = $this->input->post('csalida_'.$i);

        //actualizamos el campo cantidad_salida de la tabla items_orden
        $items_orden_data['cantidad_salida']=$csalida;
        $this->items_orden_model->actualizar_cant_salida($id_orden, $idProducto, $items_orden_data);
        // fin items_orden

        $total_valorado = 0;

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
        }//fin foreach

        //llenado de la tabla adquisicion_producto (salida)
        $data_adquisicion_producto['tipo'] = 0;
        $data_adquisicion_producto['id_salida'] = $id_salida;
        $data_adquisicion_producto['id_producto'] = $idProducto;
        
        $data_adquisicion_producto['cantidad_salida'] = $this->input->post('csalida_'.$i);
        $data_adquisicion_producto['saldo_fisico'] = ($ultimo_saldo_fisico - $this->input->post('csalida_'.$i));
        $data_adquisicion_producto['salida_valorado'] = $total_valorado;
        $data_adquisicion_producto['saldo_valorado'] = ($ultimo_saldo_valorado - $total_valorado);
        //para n_salida
        $ultima_fila = $this->adquisicion_producto_model->ultimo_nro_adquisicion(0, $idProducto);
        if(is_null($ultima_fila))
          $data_adquisicion_producto['n_salida']=1;
        else          
          $data_adquisicion_producto['n_salida']=($ultima_fila['n_salida']+1);

        $this->adquisicion_producto_model->insertar($data_adquisicion_producto);

      }//fin for principal

    //cambiar estado de orden
    $data_orden['estado_orden'] = 2;
    $this->orden_model->actualizar($id_orden, $data_orden);
    echo $id_orden;
    }//if login
    else      redirect(base_url());

  }

  public function success($id_orden)
  {
    if(isLogin() && ($this->session->userdata['nivel']>1))
    {
      $data['main_content'] = 'movimiento/success_view';
      $data['title'] = 'Orden finalizada';
      $data['id_orden'] = $id_orden;
      //$data['movimientos'] = $this->movimiento_model->get_movimientos($id_orden);
      
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }// fin success

  public function imprimir_salida($id_orden)
  {
    if(isLogin() && ($this->session->userdata['nivel']>1))
    {
      $data['title'] = 'Salida N°:'.$id_orden;
      $data['id_orden'] = $id_orden;
      $data['orden'] = $this->orden_model->get_orden($id_orden);
      $data['items_orden'] = $this->items_orden_model->get_items($id_orden);
      $salida = $this->salida_model->get_all_id_orden($id_orden);
      $data['salida'] = $salida;
      $data['salida_items'] = $this->adquisicion_producto_model->get_all_id_salida($salida['id_salida']);
      //$this->load->view('movimiento/imprimir_salida_view', $data);
      
      $this->load->library('Pdf');
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);
      $pdf->SetMargins(10, 5, 10, true);
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      $pdf->SetFont('dejavusans', '', 6);
      $pdf->AddPage('P', 'A4');

      $html = $this->load->view('movimiento/imprimir_salida_view', $data, true);
      $pdf->writeHTML($html, true, false, true, false, '');
      $pdf->Output('salida_'.$id_orden.'.pdf', 'I');
      
      
    }
    else
      redirect(base_url());
  }// fin imprimir_salida

  public function atendidos()
  {
    if(isLogin() && ($this->session->userdata['nivel']>1))
    {
      $data['main_content'] = 'movimiento/atendidos_view';
      $data['title'] = 'movimientos atendidos';
      $data['atendidos'] = $this->orden_model->get_atendidos();
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion


  public function anular($id_orden, $devolver=null){
    if(isLogin()){
      $proveedor = '';
      if(is_null($devolver)){
        //actualizando la tabla orden para anulado
        $data_orden['estado_orden'] = '3';
        $data_orden['glosa'] = 'ANULADO EN FECHA '.date('Y-m-d H:i:s').' POR USUARIO '.$this->session->userdata('usuario');
        $proveedor = 'ANULACIÓN';
      }else{
        //actualizando la tabla orden por devolucion
        $data_orden['estado_orden'] = '1';
        $proveedor = 'DEVOLUCIÓN';
      }
      $this->orden_model->actualizar($id_orden, $data_orden);

      //Insertando datos tabla nro_adquisicion por anulacion/devolucion
      $id_nro_adquisicion = $this->nro_adquisicion_model->current_num();
      $data_nro_ad['id_nro_adquisicion'] = $id_nro_adquisicion;
      $data_nro_ad['fecha_adquisicion'] = date('Y-m-d H:i:s');
      $data_nro_ad['id_empleado'] = $this->session->userdata('id_empleado');

      $data_nro_ad['proveedor'] = $proveedor;
      $data_nro_ad['observacion_general'] = "INGRESO POR ".$proveedor." O- ".$id_orden;
      $data_nro_ad['doc_respaldo'] = $proveedor." O-";
      $data_nro_ad['nro_doc_respaldo'] = $id_orden;
      $this->nro_adquisicion_model->insertar($data_nro_ad);

      //Insertando los productos anulados o devueltos en tabla adquisicion_producto
      $items_orden = $this->items_orden_model->get_items($id_orden);
      $n_elementos = count($items_orden);
      $data_adquisicion_producto = array();

      for($i=0; $i<$n_elementos; $i++){
        //para insertar adquisicion_producto
        $ultima_fila = $this->adquisicion_producto_model->ultimo_nro_adquisicion(1, $items_orden[$i]['id_producto']);
        //var_dump($ultima_fila);
        $data_adquisicion_producto['tipo']=1;
        $data_adquisicion_producto['id_nro_adquisicion']=$id_nro_adquisicion;
        $data_adquisicion_producto['id_producto']=$items_orden[$i]['id_producto'];
        $data_adquisicion_producto['cantidad_ingreso']=$items_orden[$i]['cantidad_salida'];
        $data_adquisicion_producto['cantidad_existente_adquisicion']=$items_orden[$i]['cantidad_salida'];
        $data_adquisicion_producto['precio_adquisicion']=$ultima_fila['precio_adquisicion'];
        $data_adquisicion_producto['observacion']="INGRESO POR ".$proveedor;;
        // para el n_ingreso
        $data_adquisicion_producto['n_ingreso']=($ultima_fila['n_ingreso']+1);
        //para datos kardex restantes
        $maxID = $this->adquisicion_producto_model->ultimoID($items_orden[$i]['id_producto']);
        $ultimoID = $maxID['ultimoID'];
        $ultimaFila = $this->adquisicion_producto_model->get_adquisicion_producto($ultimoID);
        $data_adquisicion_producto['saldo_fisico']=$items_orden[$i]['cantidad_salida']+$ultimaFila['saldo_fisico'];
        $data_adquisicion_producto['ingreso_valorado']=($items_orden[$i]['cantidad_salida']*$ultima_fila['precio_adquisicion']);
        $data_adquisicion_producto['saldo_valorado']=($items_orden[$i]['cantidad_salida']*$ultima_fila['precio_adquisicion'])+$ultimaFila['saldo_valorado'];
        //var_dump($data_adquisicion_producto);
        $this->adquisicion_producto_model->insertar($data_adquisicion_producto);
      }
      
      redirect(base_url().'incrementar/');
    }else
      redirect(base_url());
  }//fin funcion

}//fin class
