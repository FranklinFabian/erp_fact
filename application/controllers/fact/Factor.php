<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Factor extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/factores_model');
    $this->load->model('fact/periodos_model');

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function lista(){
   
      $data['factores'] = $this->factores_model->get_all_desc();
      $data['main_content'] = 'fact/factor/lista_view';
      $data['title'] = 'Lista de factores';
      $content = $this->parser->parse('fact/factor/lista_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
  
  }

  public function nuevo(){
    
      $data['periodos'] = $this->periodos_model->get_all_desc();
      $data['main_content'] = 'fact/factor/nuevo_view';
      $data['title'] = 'Nueva factor';
      $content = $this->parser->parse('fact/factor/nuevo_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
  }

  public function crear(){
    
      $data['idperiodo'] = $this->input->post('idperiodo');
      $data['re_020'] = $this->input->post('re_020');
      $data['re_100'] = $this->input->post('re_100');
      $data['re_ade'] = $this->input->post('re_ade');
      $data['ge_020'] = $this->input->post('ge_020');
      $data['ge_100'] = $this->input->post('ge_100');
      $data['ge_ade'] = $this->input->post('ge_ade');
      $data['i1_050'] = $this->input->post('i1_050');
      $data['i1_ade'] = $this->input->post('i1_ade');
      $data['i2_ade'] = $this->input->post('i2_ade');
      $data['i2_dem'] = $this->input->post('i2_dem');

      $data['ta_ade'] = $this->input->post('ta_ade');

      $data['ba_020'] = $this->input->post('ba_020');
      $data['ba_100'] = $this->input->post('ba_100');
      $data['ba_ade'] = $this->input->post('ba_ade');

      $data['sc_020'] = $this->input->post('sc_020');
      $data['sc_100'] = $this->input->post('sc_100');
      $data['sc_ade'] = $this->input->post('sc_ade');
      
      $data['aseo'] = $this->input->post('aseo');
      $data['alumbrado'] = $this->input->post('alumbrado');
      $data['dignidad'] = $this->input->post('dignidad');
      $data['ley1886'] = $this->input->post('ley1886');

      $data['tv_ts'] = $this->input->post('tv_ts');
      $data['tv_tp'] = $this->input->post('tv_tp');

      $data['tv_c1'] = $this->input->post('tv_c1');
      $data['tv_c1_adi'] = $this->input->post('tv_c1_adi');
      $data['tv_c2'] = $this->input->post('tv_c2');
      $data['tv_c2_adi'] = $this->input->post('tv_c2_adi');
      $data['tv_c3'] = $this->input->post('tv_c3');
      $data['tv_c3_adi'] = $this->input->post('tv_c3_adi');

      $data['usuario'] = $this->session->userdata('user_id');
      $this->factores_model->insertar($data);
      echo 'ok';
    
  }

  public function editar($id){
   
      $data['periodos'] = $this->periodos_model->get_all_desc();
      $data['factor'] = $this->factores_model->get_factor($id);
      $data['main_content'] = 'fact/factor/editar_view';
      $data['title'] = 'Editar factor';
      $content = $this->parser->parse('fact/factor/editar_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
  
  }

  public function actualizar($id){
   
      $data['idperiodo'] = $this->input->post('idperiodo');
      $data['re_020'] = $this->input->post('re_020');
      $data['re_100'] = $this->input->post('re_100');
      $data['re_ade'] = $this->input->post('re_ade');
      $data['ge_020'] = $this->input->post('ge_020');
      $data['ge_100'] = $this->input->post('ge_100');
      $data['ge_ade'] = $this->input->post('ge_ade');
      $data['i1_050'] = $this->input->post('i1_050');
      $data['i1_ade'] = $this->input->post('i1_ade');
      $data['i2_ade'] = $this->input->post('i2_ade');
      $data['i2_dem'] = $this->input->post('i2_dem');

      $data['ta_ade'] = $this->input->post('ta_ade');

      $data['ba_020'] = $this->input->post('ba_020');
      $data['ba_100'] = $this->input->post('ba_100');
      $data['ba_ade'] = $this->input->post('ba_ade');

      $data['sc_020'] = $this->input->post('sc_020');
      $data['sc_100'] = $this->input->post('sc_100');
      $data['sc_ade'] = $this->input->post('sc_ade');
      
      $data['aseo'] = $this->input->post('aseo');
      $data['alumbrado'] = $this->input->post('alumbrado');
      $data['dignidad'] = $this->input->post('dignidad');
      $data['ley1886'] = $this->input->post('ley1886');

      $data['tv_ts'] = $this->input->post('tv_ts');
      $data['tv_tp'] = $this->input->post('tv_tp');

      $data['tv_c1'] = $this->input->post('tv_c1');
      $data['tv_c1_adi'] = $this->input->post('tv_c1_adi');
      $data['tv_c2'] = $this->input->post('tv_c2');
      $data['tv_c2_adi'] = $this->input->post('tv_c2_adi');
      $data['tv_c3'] = $this->input->post('tv_c3');
      $data['tv_c3_adi'] = $this->input->post('tv_c3_adi');

      $data['usuario'] = $this->session->userdata('user_id');

      $this->factores_model->actualizar($id, $data);
      redirect(base_url().'fact/factor/lista');
    
  }
  
  public function eliminar($id){
   
      $this->factores_model->eliminar($id);
      redirect(base_url().'fact/factor/lista');
  
  }
  
}//fin class
