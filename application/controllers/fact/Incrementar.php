<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Incrementar extends CI_Controller
{
  public function index()
  {
    if(isLogin())
    {
      $data['main_content'] = 'incrementar/index_view';
      $data['title'] = 'Lista';
      $data['lista'] = $this->nro_adquisicion_model->get_all_all();
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo()
  {
    if(isLogin())
    {
      $salida=$this->producto_model->get_json2();
      $data['salida'] = $salida;
      $data['main_content'] = 'incrementar/nuevo_view';
      $data['title'] = 'Incrementar';

      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function editar_datos($id_nro_adquisicion)
  {
    if(isLogin())
    {
      $adquisicion = $this->nro_adquisicion_model->get_id_nro_adquisicion($id_nro_adquisicion);
      $data['main_content'] = 'incrementar/editar_datos_view';
      $data['title'] = 'Editar datos';
      $data['adquisicion'] = $adquisicion;
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function actualizar_datos($id_nro_adquisicion)
  {
    if(isLogin())
    {
      //$data_nro_adquisicion['fecha_adquisicion']=datetime_to_mysql($this->input->post('fecha_ingreso_almacen'));
      $data_nro_adquisicion['fecha_adquisicion']=date('Y-m-d H:i:s');
      $data_nro_adquisicion['id_empleado']=$this->session->userdata('id_empleado');
      $data_nro_adquisicion['proveedor']=mb_strtoupper($this->input->post('proveedor'));
      
      $data_nro_adquisicion['observacion']=mb_strtoupper($this->input->post('observacion_general'));
      $data_nro_adquisicion['doc_respaldo']=mb_strtoupper($this->input->post('doc_respaldo'));
      $data_nro_adquisicion['nro_doc_respaldo']=mb_strtoupper($this->input->post('nro_doc_respaldo'));
      
      $this->nro_adquisicion_model->actualizar($id_nro_adquisicion, $data_nro_adquisicion);
      redirect(base_url().'incrementar');
      
    }
    else
      redirect(base_url());
  }//fin funcion

  public function editar_items($id_nro_adquisicion)
  {
    if(isLogin())
    {
      $data['main_content'] = 'incrementar/editar_items_view';
      $data['title'] = 'Editar items';
      $data['id_nro_adquisicion'] = $id_nro_adquisicion;
      $data['items'] = $this->adquisicion_producto_model->get_all_id_nro_adquisicion($id_nro_adquisicion);

      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function editar_item($id_adquisicion_producto)
  {
    if(isLogin())
    {
      $item = $this->adquisicion_producto_model->get_id_adquisicion($id_adquisicion_producto);
      $data['main_content'] = 'incrementar/editar_item_view';
      $data['title'] = 'Editar item';
      $data['item'] = $item;
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function actualizar_item($id_adquisicion_producto, $id_nro_adquisicion)
  {
    if(isLogin())
    {
      /*FALTA ACTUALIZAR STOCKS*/

      $dataItem['id_producto']=$this->input->post('id_producto');
      $dataItem['cantidad_existente_adquisicion']=mb_strtoupper($this->input->post('cantidad_ingreso'));
      $dataItem['cantidad_ingreso']=mb_strtoupper($this->input->post('cantidad_ingreso'));
      $dataItem['precio_adquisicion']=mb_strtoupper($this->input->post('precio_adquisicion'));
      //$dataItem['observacion']=mb_strtoupper($this->input->post('observacion'));
      $this->adquisicion_producto_model->actualizar($id_adquisicion_producto, $dataItem);
      redirect(base_url().'incrementar/editar_items/'.$id_nro_adquisicion);      
    }
    else
      redirect(base_url());
  }//fin funcion

  public function eliminar_item($id_adquisicion_producto)
  {
    if(isLogin())
    {
      $item = $this->adquisicion_producto_model->get_id_adquisicion($id_adquisicion_producto);
      $this->adquisicion_producto_model->eliminar($id_adquisicion_producto);
      redirect(base_url().'incrementar/editar_items/'.$item['id_nro_adquisicion']);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function add_item($id_nro_adquisicion)
  {
    if(isLogin())
    {
      $data['id_nro_adquisicion']=$id_nro_adquisicion;
      $this->load->view('incrementar/add_item_view',$data);
    }
    else
      redirect(base_url());
  }//fin funcion

  public function add_to_adq($id_nro_adquisicion)
  {
    if(isLogin())
    {
        $data_adquisicion_producto['id_nro_adquisicion']=$id_nro_adquisicion;
        $data_adquisicion_producto['cantidad_ingreso']=$this->input->post('cantidad_ingreso');
        $data_adquisicion_producto['cantidad_existente_adquisicion']=$this->input->post('cantidad_ingreso');
        $data_adquisicion_producto['precio_adquisicion']=$this->input->post('precio_adquisicion');
        $data_adquisicion_producto['id_producto']=$this->input->post('id_producto');
        //$data_adquisicion_producto['observacion']=$this->input->post('observacion');
        $this->adquisicion_producto_model->insertar($data_adquisicion_producto);
        redirect(base_url().'incrementar/editar_items/'.$id_nro_adquisicion);
      
    }
    else
      redirect(base_url());
  }//fin funcion

  public function buscar_producto()
  {
    $producto = $this->producto_model->get_nombre_producto($this->input->post('nombre_producto'));
    if (count($producto)>0)
      echo $producto['nombre_producto'];
    else echo "";
  }

  public function incrementar_item($n_elementos)
  {
    if(isLogin())
    {
      for($i=0; $i<$n_elementos; $i++)
      {
        $productos[$i] = $this->producto_model->get_nombre_producto($this->input->post('prod_'.$i));
        $cantidades[$i] = $this->input->post('cant_'.$i);
        $precios[$i] = $this->input->post('precio_'.$i);
        //$observaciones[$i] = $this->input->post('obs_'.$i);
      }
      //$empleado = $this->empleado_model->get_empleado($this->session->userdata('id_empleado'));

      //insertamos nro_adquisicion
      $id_nro_adquisicion = $this->nro_adquisicion_model->current_num();

      $data_nro_adquisicion['id_nro_adquisicion']=$id_nro_adquisicion;
      $data_nro_adquisicion['fecha_adquisicion']=date('Y-m-d H:i:s');
      //$data_nro_adquisicion['fecha_adquisicion']=datetime_to_mysql($this->input->post('fecha_ingreso_almacen')).' '.date('H:i:s');
      $data_nro_adquisicion['id_empleado']=$this->session->userdata('id_empleado');
      $data_nro_adquisicion['proveedor']=mb_strtoupper($this->input->post('proveedor'));
      $data_nro_adquisicion['observacion']=mb_strtoupper($this->input->post('observacion_general'));
      $data_nro_adquisicion['doc_respaldo']=mb_strtoupper($this->input->post('doc_respaldo'));
      $data_nro_adquisicion['nro_doc_respaldo']=mb_strtoupper($this->input->post('nro_doc_respaldo'));
      $this->nro_adquisicion_model->insertar($data_nro_adquisicion);

      //insertamos adquisicion_producto
      $data_adquisicion_producto = array();
      for($i=0; $i<$n_elementos; $i++)
      {
        //para insertar adquisicion_producto
        $data_adquisicion_producto['tipo']=1;
        $data_adquisicion_producto['id_nro_adquisicion']=$id_nro_adquisicion;
        $data_adquisicion_producto['id_producto']=$productos[$i]['id_producto'];
        $data_adquisicion_producto['cantidad_ingreso']=$cantidades[$i];
        $data_adquisicion_producto['cantidad_existente_adquisicion']=$cantidades[$i];
        $data_adquisicion_producto['precio_adquisicion']=$precios[$i];
        //$data_adquisicion_producto['observacion']=$observaciones[$i];
        // para el n_ingreso
        $ultima_fila = $this->adquisicion_producto_model->ultimo_nro_adquisicion(1, $productos[$i]['id_producto']);
        if(is_null($ultima_fila))
          $data_adquisicion_producto['n_ingreso']=1;
          else
        $data_adquisicion_producto['n_ingreso']=($ultima_fila['n_ingreso']+1);

        $filas_adquisicion =  $this->adquisicion_producto_model->contar_filas($productos[$i]['id_producto']);
        if(((int)$filas_adquisicion['filas'])==0){
          $data_adquisicion_producto['saldo_fisico']=$cantidades[$i];
          $data_adquisicion_producto['ingreso_valorado']=$cantidades[$i]*$precios[$i];
          $data_adquisicion_producto['saldo_valorado']=$cantidades[$i]*$precios[$i];
        }
        else{
          $maxID = $this->adquisicion_producto_model->ultimoID($productos[$i]['id_producto']);
          $ultimoID = $maxID['ultimoID'];
          $ultimaFila = $this->adquisicion_producto_model->get_adquisicion_producto($ultimoID);
          $data_adquisicion_producto['saldo_fisico']=$cantidades[$i]+$ultimaFila['saldo_fisico'];
          $data_adquisicion_producto['ingreso_valorado']=($cantidades[$i]*$precios[$i]);
          $data_adquisicion_producto['saldo_valorado']=($cantidades[$i]*$precios[$i])+$ultimaFila['saldo_valorado'];
        }        
        $this->adquisicion_producto_model->insertar($data_adquisicion_producto);
      }
    }
    else
      redirect(base_url());    
  }//fin funcion

  public function ver_detalle($id_nro_adquisicion){
    if(isLogin()){
      $detalle = array();
      $detalle = $this->nro_adquisicion_model->get_all_id_nro_adquisicion($id_nro_adquisicion);

      $data['main_content'] = 'incrementar/ver_detalle_view';
      $data['title'] = 'Detalle ingreso';
      $data['detalle'] = $detalle;
      $configuracion = $this->configuracion_model->get_all();
      if(is_null($configuracion)){
        $configuracion = array();
        //$configuracion['nombre_almacen'] = '';
        $configuracion['direccion'] = '';
        $configuracion['telefono'] = '';
      }
      $data['configuracion'] = $configuracion;
      //$this->load->view('incrementar/ver_detalle_view', $data);

      $this->load->library('Pdf');
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Inventario FactOzz');
      $pdf->SetTitle('Detalle ingreso '.$id_nro_adquisicion);      
      // set default header data

      $pdf->SetHeaderData('../../../public/img/logo.png', 13, $configuracion['logo_linea1'], "Dirección: ".$configuracion['direccion']."\nTelefono: ".$configuracion['telefono'], array(0,0,0), array(0,0,0));
      $pdf->setFooterData(array(0,64,0), array(0,64,128));

      // set header and footer fonts
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 8));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

      //$pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
      //$pdf->setPrintHeader(false);
      //$pdf->setPrintFooter(false);
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      $pdf->SetFont('dejavusans', '', 8);
      //$pdf->AddPage('P', 'A4');
      $pdf->AddPage();

      $html = $this->load->view('incrementar/ver_detalle_view', $data, true);
      $pdf->writeHTML($html, true, false, true, false, '');
      $pdf->Output('comprobante_ingreso_'.$detalle['id_nro_adquisicion'].'.pdf', 'I');      
    }
    else
      redirect(base_url());    
  }//fin funcion

}//fin class
