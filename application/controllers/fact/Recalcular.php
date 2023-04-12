<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recalcular extends CI_Controller{

  public function index(){//MENU
    if(isAdmin()){
      $data['main_content'] = 'recalcular/index_view';
      $data['title'] = 'Menu Recalcular';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function busqueda(){
    if(isAdmin()){
      $data['main_content'] = 'recalcular/busqueda_view';
      $data['title'] = 'recalcular';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function buscar_cliente(){
    if(isLogin()){
      $apellidos = trim(mb_strtoupper($this->input->post('apellidos')));
      $nombres = trim(mb_strtoupper($this->input->post('nombres')));
      $abonado = trim(mb_strtoupper($this->input->post('abonado')));
      $medidor = trim(mb_strtoupper($this->input->post('medidor')));

      $resultado = array();
      if(($apellidos=='') && ($nombres=='') && ($abonado=='') && ($medidor==''))
        $resultado = null; //echo 'Debe indroducir algún criterio de busqueda';
      elseif(($abonado=='') && ($medidor=='')){
        $resultado = $this->cliente_model->buscar_app_nom($apellidos, $nombres);
      }elseif($abonado != ''){//buscar por abonado
        $resultado = $this->cliente_model->buscar_por_abonado($abonado);
      }else{//por medidor
        $resultado = $this->cliente_model->buscar_por_medidor($medidor);
      }

      $salida='';
      $i=1;
      if(!is_null($resultado)){
        $salida.= '
        <table>
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
                <td> <a id="btn_editar" class="button-small pure-button pure-button-primary" href="'.base_url().'gestion_factura/mostrar_factura/'.$value['idcliente'].'">Seleccionar</button></td>
              </tr>';
            }else{
              $salida.='
              <tr>
                <td></td>
                <td>'.($value['razon_social']).'</td>
                <td></td>
                <td></td>
                <td> <a id="btn_editar" class="button-small pure-button pure-button-primary" href="'.base_url().'gestion_factura/mostrar_factura/'.$value['idcliente'].'">Seleccionar</button></td>
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
    else
      redirect(base_url());
  }

  
}//fin class
