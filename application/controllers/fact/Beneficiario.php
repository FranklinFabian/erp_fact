<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beneficiario extends CI_Controller{

  public function index(){
    if(isAdmin()){
      $data['main_content'] = 'beneficiario/index_view';
      $data['title'] = 'beneficiarios';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function buscar_cliente(){
    if(isAdmin()){
      $razon_social = trim(mb_strtoupper($this->input->post('razon_social')));
      $resultado = array();
      if(($razon_social==''))
        $resultado = null; //echo 'Debe indroducir algún criterio de busqueda';
      else
        $resultado = $this->cliente_model->buscar_completo($razon_social);
      
      $salida='';
      $i=1;
      if(!is_null($resultado)){
        $salida.= '
        <table>
          <thead>
            <tr>
              <th>Nro.</th>
              <th>Abonado</th>
              <th>Razón</th>
              <th>Fecha Nac.</th>
              <th>Edad</th>
              <th>Circuito</th>
              <th>Dirección</th>
              <th>Asignar</th>
            </tr>
          </thead>
          <tbody>';
          foreach ($resultado as $key => $value) {
            $abonado_electrico = $this->abonados_model->get_abonado_elect($value['idcliente']);
            if(is_null($abonado_electrico)) continue;
            else{
              $poste_centro=$this->postes_model->get_poste_circu($abonado_electrico['idposte']);
              $direccion=$this->calles_model->get_calle($abonado_electrico['idcalle']);
              if(is_null($value['nacimiento'])){
                $arr_edad[0]=0;
                $arr_edad[1]=0;
              }else{
                $edad = calculaAnios(($value['nacimiento']), date('d/m/Y'));
                $arr_edad = explode(',',$edad);  
              }
            }
            $salida.='
            <tr>
              <td>'.$i++.'</td>
              <td>'.($abonado_electrico['idabonado']).'</td>
              <td>'.($value['razon_social']).'</td>
              <td>'.(($value['nacimiento'])).'</td>
              <td>'.($arr_edad[0].' Años y '.$arr_edad[1].' meses').'</td>
              <td>'.($poste_centro['codigo']).'</td>
              <td>'.($direccion['calle']).'</td>';
              $salida.='<td> <a id="btn_editar" class="button-small pure-button pure-button-primary" href="'.base_url().'beneficiario/nuevo/'.$value['idcliente'].'">Asignar beneficio</button></td>';

            $salida.='</tr>';
          }
          $salida.='</tbody>
        </table>        
        ';
        echo $salida;
      }else
        echo 'Debe indroducir algún criterio de busqueda';
      
    }
    else
      redirect(base_url());
  }

  /* Para buscar el ci del beneficiario indirecto */
  public function buscar_ci($ci){
    $resultado = $this->cliente_model->buscar_ci2($ci);// buscar_ci2 por si hay duplicados
    
    $salida='<table>';
    foreach ($resultado as $key => $value) {
      $edad = calculaAnios(($value['nacimiento']), date('d/m/Y'));
      $arr_edad = explode(',',$edad);
      
      $salida.= '
        <tr>
          <td>'.$value['idcliente'].'</td>
          <td>'.$value['razon_social'].'</td>
          <td>'.($value['nacimiento']).'</td>';
      if($arr_edad[0]>=$this->config->item('edad_ley1886'))
        $salida.='<td>Cumple</td> <td><button onclick="establecer_id_cliente('.$value['idcliente'].');">agregar</button></td>';
      else 
        $salida.='<td>No Cumple</td> <td></td>';
      
      $salida.='</tr>'; 
    }
    $salida.='</table>';

    if(empty($resultado))
      echo '<p style="color: #DE9D00; font-weight:bold;">EL CI ingresado no ese encuntra registrado.</p>';
    else 
      echo $salida;
  }

  public function listar_abonos_cliente($idcliente){
    if(isAdmin()){
      $data['cliente'] = $this->cliente_model->get_cliente($idcliente);      
      $data['abonos_cliente'] = $this->beneficiarios_model->get_abonos_cliente($idcliente);      
      $data['main_content'] = 'beneficiario/listar_abonos_cliente_view';
      $data['title'] = 'Lista de beneficiarios por cliente';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo($idcliente){
    if(isAdmin()){
      
      $data['cliente'] = $this->cliente_model->get_cliente($idcliente);
      $data['abonados'] = $this->abonados_model->get_abonos_elect_cliente($idcliente);
      $data['ley1886'] = $this->ley1886_model->get_habilitados();
      $data['directos'] = $this->directos_model->get_all();
      
      $data['main_content'] = 'beneficiario/nuevo_view';
      $data['title'] = 'Nuevo beneficiario';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isAdmin()){
      $data['fecha'] = date('Y-m-d');
      $data['usuario'] = $this->session->userdata('id_empleado');
      $data['iddirecto'] = $this->input->post('iddirecto');
      $data['idley1886'] = $this->input->post('idley1886');
      $data['idabonado'] = $this->input->post('idabonado');
      $data['idcliente'] = $this->input->post('idcliente');
      $this->beneficiarios_model->insertar($data);

      if($this->input->post('iddirecto')=='2'){
        $data_inquilinos['usuario'] = $this->session->userdata('id_empleado');
        $data_inquilinos['idcliente'] = $this->input->post('idcliente');
        $data_inquilinos['idabonado'] = $this->input->post('idabonado');
        $this->inquilinos_model->insertar($data_inquilinos);
      }

       echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function editar($id){
    if(isAdmin()){
    
      $data['localidades'] = $this->localidades_model->get_all();
      $data['zonas'] = $this->zonas_model->get_all();
      $data['postes'] = $this->postes_model->get_all();
      $data['centros'] = $this->centros_model->get_all();

      $data['calles'] = $this->calles_model->get_all();
      $data['categorias'] = $this->categorias_model->get_all();
      $data['estados'] = $this->estados_model->get_all();
      $data['liberaciones'] = $this->liberaciones_model->get_all();
      $data['suministros'] = $this->suministros_model->get_all();
      $data['consumidores'] = $this->consumidores_model->get_all();
      $data['mediciones'] = $this->mediciones_model->get_all();
      $data['servicios'] = $this->servicios_model->get_all();

      $data['beneficiario'] = $this->beneficiarios_model->get_beneficiario($id);
      $data['main_content'] = 'beneficiario/editar_view';
      $data['title'] = 'Editar beneficiario';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function actualizar($id){
    if(isAdmin()){
      $beneficiario = $this->beneficiarios_model->get_beneficiario($id);
      $data['fase'] = mb_strtoupper(trim($this->input->post('fase')));
      $data['medidor'] = mb_strtoupper(trim($this->input->post('medidor')));
      $data['capacidad'] = mb_strtoupper(trim($this->input->post('capacidad')));
      $data['indiceinicial'] = mb_strtoupper(trim($this->input->post('indiceinicial')));
      $data['mulmed'] = mb_strtoupper(trim($this->input->post('mulmed')));
      $data['encorte'] = mb_strtoupper(trim($this->input->post('encorte')));
      $data['instalacion'] = $this->input->post('instalacion');
      $data['corte'] = $this->input->post('corte');
      $data['reposicion'] = $this->input->post('reposicion');
      $data['idestado'] = $this->input->post('idestado');
      $data['idservicio'] = $this->input->post('idservicio')==''?NULL:$this->input->post('idservicio');
      $data['idcategoria'] = $this->input->post('idcategoria');
      //$data['idlocalidad'] = $this->input->post('idlocalidad');
      //$data['idzona'] = $this->input->post('idzona');
      $data['idcalle'] = $this->input->post('idcalle');
      $data['numero'] = mb_strtoupper(trim($this->input->post('numero')));
      //$data['idcentro'] = $this->input->post('idcentro');
      $data['idposte'] = $this->input->post('idposte');
      $data['idsuministro'] = $this->input->post('idsuministro');
      $data['idconsumidores'] = $this->input->post('idconsumidores');
      $data['idmedicion'] = $this->input->post('idmedicion');
      $data['idliberacion'] = $this->input->post('idliberacion');
      $data['cantidad'] = mb_strtoupper(trim($this->input->post('cantidad')));

      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->beneficiarios_model->actualizar($id, $data);
      redirect(base_url().'beneficiario/listar_abonos_cliente/'.$beneficiario['idcliente']);
    }
    else
      redirect(base_url());
  }
  
  public function eliminar($id){
    if(isAdmin()){
      $this->beneficiarios_model->eliminar($id);
      redirect(base_url().'beneficiario/lista');
    }
    else
      redirect(base_url());
  }
  
}//fin class
