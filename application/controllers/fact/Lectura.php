<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lectura extends CI_Controller{

  public function __construct() {
    parent::__construct();
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
    $this->load->model('fact/estados_model');
    $this->load->model('fact/zonas_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }

  public function index(){
    $data['centros'] = $this->centros_model->get_all();
    $data['main_content'] = 'fact/lectura/index_view';
    $data['title'] = 'Lecturas';
    $content = $this->parser->parse('fact/lectura/index_view', $data, true);
    /*$this->load->view('fact/template/template_view', $data);*/
    $this->template->full_admin_html_view($content);
    
  }

  public function cargar_centro($idcentro){
    
      $periodo_activo = $this->periodos_model->get_ultimo();
      $abonados = $this->abonados_model->get_abonos_centro($idcentro);
      $data['abonados'] = $abonados;
      $data['periodo_activo'] = $periodo_activo;
      $this->load->view('fact/lectura/cargar_centro_view', $data);
      /*$content = $this->parser->parse('fact/lectura/cargar_centro_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      /*$this->template->full_admin_html_view($content);*/
  }

  public function cargar_abonado($idabonado){
    
      $abonado = $this->abonados_model->get_abonado($idabonado);
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      $data['direccion'] = $direccion;
      $data['abonado'] = $abonado;
      $data['cliente'] = $this->cliente_model->get_cliente($abonado['idcliente']);
      $data['centro'] = $this->centros_model->get_centro($abonado['idcentro']);
      $data['poste'] = $this->postes_model->get_poste($abonado['idposte']);
      $data['categoria'] = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $data['estado'] = $this->estados_model->get_estado($abonado['idestado']);
      $this->load->view('fact/lectura/cargar_abonado_view',$data);
      /*$content = $this->parser->parse('fact/lectura/cargar_abonado_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      /*$this->template->full_admin_html_view($content);*/
  }
  
  public function cargar_historico($idabonado){
    
      $periodo_activo = $this->periodos_model->get_activo();
      $lecturas = $this->lecturas_model->get_lecturas_abonado_5($idabonado, $periodo_activo['idperiodo']);
      $data['lecturas'] = $lecturas;
      $this->load->view('fact/lectura/cargar_historico_view', $data);
      /*$content = $this->parser->parse('fact/lectura/cargar_historico_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
     /* $this->template->full_admin_html_view($content);*/
  
  }
  
  public function cargar_formulario($idabonado){
    
      $periodo_activo = $this->periodos_model->get_activo();
      $lectura = $this->lecturas_model->buscar_abonado_periodo($idabonado, $periodo_activo['idperiodo']);
      //var_dump($lectura);
      if(!is_null($lectura))
        $data['lectura'] = $lectura;
      else 
        $data['lectura'] = NULL;
        
      $abonado = $this->abonados_model->get_abonado($idabonado);
      $lecturas = $this->lecturas_model->get_lecturas_abonado_5($idabonado, $periodo_activo['idperiodo']);
      $lectura_anterior = $this->lecturas_model->get_lectura_anterior($idabonado, $periodo_activo['idperiodo']);
      $data['abonado'] = $abonado;
      $data['lectura_anterior'] = $lectura_anterior;
      $data['periodo_activo'] = $periodo_activo;
      $data['lecturas'] = $lecturas;
      $this->load->view('fact/lectura/cargar_formulario_view',$data); 
      /*$content = $this->parser->parse('fact/lectura/cargar_formulario_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      /*$this->template->full_admin_html_view($content); */
   
  }
  
  public function crear($idabonado){
    
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
      $data_lect['usuario'] = $this->session->userdata('user_id');
      //var_dump($data_lect);
      $lectura = $this->lecturas_model->buscar_abonado_periodo($idabonado, $periodo_activo['idperiodo']);
      if(is_null($lectura)){
        $idlectura = $this->lecturas_model->current_num();
        $data_lect['idlectura'] = $idlectura;  
        $this->lecturas_model->insertar($data_lect);
      }
      else
        $this->lecturas_model->actualizar($lectura['idlectura'], $data_lect);

      $lec_observada=$this->input->post('lec_observada');
      if($lec_observada > 0){
        $data_lecturas_observadas['idlectura']=$idlectura;
        $data_lecturas_observadas['idtipo']=$lec_observada;
        $data_lecturas_observadas['usuario']=$this->session->userdata('user_id');
        $this->lecturas_observadas_model->insertar($data_lecturas_observadas);
      }
      
      echo 'ok';
    
  }
  

}//fin class
