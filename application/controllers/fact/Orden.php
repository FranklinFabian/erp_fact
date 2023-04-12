<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orden extends CI_Controller
{
  public function nueva_solicitud()
  {
    if(isLogin())
    {
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
          $salidaFinal.= '"'.$value['nombre_producto'].'|'.$value['cantidad_existente_adquisicion'].'",';
      }
  
      
      $data['salida'] = $salidaFinal;
      $data['main_content'] = 'orden/nueva_solicitud_view';
      $data['title'] = 'Nueva solicitud';
      $this->load->view('template/template_view', $data);
      
    }
    else
      redirect(base_url());
  }//fin funcion

  public function buscar_producto()
  {
    $postProducto = $this->input->post('nombre_producto');
    $porciones = explode("|", $postProducto);

    $producto = $this->producto_model->get_nombre_producto($porciones[0]);
    if (count($producto)>0)
      echo $producto['nombre_producto'];
    else echo "";
  }

  public function crear_orden($n_elementos)
  {
    if(isLogin())
    {
      for($i=0; $i<$n_elementos; $i++)
      {
        $productos[$i] = $this->producto_model->get_nombre_producto($this->input->post('prod_'.$i));
        $cantidades[$i] = $this->input->post('cant_'.$i);
      }
      $empleado = $this->empleado_model->get_empleado($this->session->userdata('id_empleado'));
      //insertamos orden
      $id_orden = $this->orden_model->current_num();
      $data_orden['id_orden']=$id_orden;
      $data_orden['id_empleado']=$this->session->userdata('id_empleado');
//      $data_orden['id_sub_area']=$this->input->post('id_sub_area');
      $data_orden['fecha_orden']=date('Y-m-d H:i:s');
      $data_orden['estado_orden']='1';
      $data_orden['glosa']=strtoupper(trim($this->input->post('justificacion')));
      $data_orden['contador']=intval($empleado['contador_solicitud_pedido'])+1;
      $this->orden_model->insertar($data_orden);

      //insertamos items_orden
      for($i=0; $i<$n_elementos; $i++)
      {
        $data_items_orden['id_producto']=$productos[$i]['id_producto'];
        $data_items_orden['id_orden']=$id_orden;
        $data_items_orden['cantidad']=$cantidades[$i];
        $this->items_orden_model->insertar($data_items_orden);
      }
      $data_empleado['contador_solicitud_pedido']=intval($empleado['contador_solicitud_pedido'])+1;
      $this->empleado_model->actualizar($this->session->userdata('id_empleado'), $data_empleado);
      echo $id_orden;
    }
    else
      redirect(base_url());
  }//fin funcion

  public function imprimir($id_orden)
  {
    if(isLogin())
    {
      $data['title'] = 'Solicitud N°:'.$id_orden;
      $data['id_orden'] = $id_orden;
      $data['orden'] = $this->orden_model->get_orden($id_orden);
      $data['items_orden'] = $this->items_orden_model->get_items($id_orden);
      
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

      $html = $this->load->view('orden/imprimir_view', $data, true);
      $pdf->writeHTML($html, true, false, true, false, '');
      $pdf->Output('solicitud_'.$id_orden.'.pdf', 'I');
    }
    else
      redirect(base_url());    
  }

  public function mis_solicitudes()
  {
    if(isLogin())
    {
      $data['main_content'] = 'orden/mis_solicitudes_view';
      $data['title'] = 'Mis solicitudes';
      $data['mis_ordenes'] = $this->orden_model->mis_ordenes($this->session->userdata('id_empleado'));
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function editar_items($id_orden)
  {
    if(isLogin())
    {
      $orden= $this->orden_model->get_orden($id_orden);
      $items_orden = $this->items_orden_model->get_items($id_orden);
      $data['main_content'] = 'orden/editar_items_view';
      $data['title'] = 'Editar items';
      $data['orden'] = $orden;
      $data['items_orden'] = $items_orden;
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function editar_item($id_items_orden)
  {
    if(isLogin())
    {
      $item = $this->items_orden_model->get_items_orden($id_items_orden);
      $data['main_content'] = 'orden/editar_item_view';
      $data['title'] = 'Editar item';
      $data['item'] = $item;
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function actualizar_item($id_items_orden)
  {
    if(isLogin())
    {
      $item = $this->items_orden_model->get_items_orden($id_items_orden);
      $dataItem['id_producto']=$this->input->post('id_producto');
      $dataItem['cantidad']=mb_strtoupper($this->input->post('cantidad'));
      $this->items_orden_model->actualizar($id_items_orden, $dataItem);
      redirect(base_url().'orden/editar_items/'.$item['id_orden']);
    }
    else
      redirect(base_url());
  }//fin funcion


  public function eliminar_item($id_items_orden)
  {
    if(isLogin())
    {
      $item = $this->items_orden_model->get_items_orden($id_items_orden);
      $this->items_orden_model->eliminar($id_items_orden);
      redirect(base_url().'orden/editar_items/'.$item['id_orden']);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function add_item($id_orden)
  {
    if(isLogin())
    {
      $data['id_orden']=$id_orden;
      $this->load->view('orden/add_item_view',$data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function add_item_to_items_orden($id_orden)
  {
    if(isLogin())
    {
        $id_producto = $this->input->post('id_producto');
        $existe = false;
        $items = $this->items_orden_model->get_items($id_orden);
        foreach ($items as $key => $value) {
          if($value['id_producto']==$id_producto)
            $existe = true;
        }

        if(!$existe){
          $data['id_producto']=$id_producto;
          $data['id_orden']=$id_orden;
          $data['cantidad']=$this->input->post('cantidad');
          $this->items_orden_model->insertar($data);
          redirect(base_url().'orden/editar_items/'.$id_orden);  
        }else
        redirect(base_url().'orden/editar_items/'.$id_orden);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function editar_datos($id_orden)
  {
    if(isLogin())
    {
      $orden = $this->orden_model->get_orden($id_orden);
      $data['main_content'] = 'orden/editar_datos_view';
      $data['title'] = 'Editar datos';
      $data['orden'] = $orden;
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function actualizar_datos($id_orden)
  {
    if(isLogin())
    {
      $fecha = $this->input->post('fecha');
      $hora = $this->input->post('hora');

      $data['fecha_orden']=$fecha.' '.$hora;
      $data['glosa']=mb_strtoupper($this->input->post('glosa'));
      $this->orden_model->actualizar($id_orden, $data);
      redirect(base_url().'orden/mis_solicitudes');      
    }
    else
      redirect(base_url());
  }//fin funcion

}//fin class
