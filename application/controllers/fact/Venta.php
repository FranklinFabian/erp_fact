<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta extends CI_Controller{
  
  public function __construct() {
    parent::__construct();
    $this->load->model('fact/empleado_model');
    $this->load->model('fact/cuis_model');
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
    $this->load->model('fact/facturas_model');
    $this->load->model('fact/producto_model');
    $this->load->model('fact/factura_model');
    $this->load->model('fact/punto_venta_model');
    $this->load->model('fact/orden_model');
    $this->load->model('fact/parametrica_evento_significativo_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }

  public function index(){
    
      $data['main_content'] = 'fact/venta/index_view';
      $data['title'] = 'Venta';
      $content = $this->parser->parse('fact/venta/index_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
  }

  public function lista($idcliente){
    
    $data['almacen_proforma_items'] = $this->cliente_model->get_proformas($idcliente);
    $data['main_content'] = 'fact/venta/vender_view';
    $data['title'] = 'Proforma';
    $content = $this->parser->parse('fact/venta/vender_view', $data, true);
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
        <table id="tabla_cliente" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
        <caption>Resultado busqueda</caption>
          <thead>
            <tr>
              <th>Id cliente</th>
              <th>Razón Social</th>
              <th>NIT</th>
              <th>CI</th>
              <th></th>
            </tr>
          </thead>
          <tbody>';
          foreach ($resultado as $key => $value) {
            $salida.='
            <tr>
              <td>'.($value['idcliente']).'</td>
              <td>'.($value['razon_social']).'</td>
              <td>'.($value['nit']).'</td>
              <td>'.($value['ci']).'</td>
              <td> <a id="btn_editar" class="button-small pure-button pure-button-primary" href="javascript:enviar_a_venta('.$value['idcliente'].')">Seleccionar</button></td>
            </tr>            
            ';
          }
          $salida.='</tbody>
        </table>        
        ';
        echo $salida;
      }else{
        echo 'Debe indroducir algún criterio de busqueda';
      }
    
  }

  
  
  public function buscar_producto($codBarras=null){
    if(is_null($codBarras)){
      $postProducto = $this->input->post('nombre_producto');
      //$porciones = explode("|", $postProducto);
      
      $producto = $this->producto_model->get_nombre_producto($postProducto);
      $resultado=$this->producto_model->suma_existentes($producto['id_producto']);
      $suma_stock = $resultado['suma_stock'];
      if (count($producto)>0){
        echo '{"id_producto":'.$producto['id_producto'].', "precio_venta":'.$producto['precio_venta'].', "nombre_producto":"'.$producto['nombre_producto'].'", "cantidad_producto":1, "sub_total":'.($producto['precio_venta']).', "disponible":'.$suma_stock.', "descuento":0 }';
      }
      else echo "";
    }else{
      $producto = $this->producto_model->get_nombre_codBarras($codBarras);
      $resultado=$this->producto_model->suma_existentes($producto['id_producto']);
      $suma_stock = $resultado['suma_stock'];
      if (count($producto)>0){
        echo '{"id_producto":'.$producto['id_producto'].', "precio_venta":'.$producto['precio_venta'].', "nombre_producto":"'.$producto['nombre_producto'].'", "cantidad_producto":1, "sub_total":'.($producto['precio_venta']).', "disponible":'.$suma_stock.', "descuento":0 }';
      }
      else echo "";  
    }
  }

  public function vender($idcliente){
    
      $cliente = $this->cliente_model->get_cliente($idcliente);

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
      foreach ($salidaResultado as $key => $value){
        $salidaFinal.= '"'.$value['nombre_producto'].'",';
      }

      $data['nombre_cliente'] = $cliente['razon_social'];
      //nro control tributario si es 0 o negativo
      // if(($cliente['nit'])<=0 && ($cliente['nit']<=0)){
      //   $cliente['nit']=99002;
      //   $cliente['razon_social']='CONTROL TRIBUTARIO';
      // }
      // if(($cliente['nit']==0) && ($cliente['ci']>0)){
      //   $cliente['nit']=$cliente['ci'];
      // }
      
      //$data['eventos'] = $this->parametrica_evento_significativo_model->get_all();
      $data['facturas_off'] = $this->factura_model->get_factura_offline();
      $data['cliente'] = $cliente;
      $data['salida'] = $salidaFinal;
      $data['main_content'] = 'fact/venta/vender_view';
      $data['title'] = 'Venta';
      $content = $this->parser->parse('fact/venta/vender_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
      
    
  }



  public function error_cliente(){
    
      $data['main_content'] = 'fact/venta/error_cliente_view';
      $data['title'] = 'Error cliente';
      $content = $this->parser->parse('fact/venta/error_cliente_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
    
  }

  

 



  

}//fin class
