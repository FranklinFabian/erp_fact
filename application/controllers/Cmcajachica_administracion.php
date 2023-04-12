<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmcajachica_administracion extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mcajachica_Administracion');
        $this->load->library('auth');
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lmcajachica_administracion');
        $content = $CI->lmcajachica_administracion->edit_data();
        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $this->load->model('Mcajachica_Administracion');
        $this->load->model('Mcajachica_Cuenta');
        $this->load->model('Mcajachica_Solicitante');

        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->Mcajachica_Administracion->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }

        $data['cuentas'] = $this->Mcajachica_Cuenta->list_dropdown();
        $data['solicitantes'] = $this->Mcajachica_Solicitante->list_dropdown();
        $this->load->view('modulo_cajachica/administracion/modal', $data);
    }

    public function update() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        $data['fecha'] = date('Y-m-d');

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('caja_chica_registro', $data);
        }else{
            $this->db->insert('caja_chica_registro', $data);
        }
        echo 1;
    }

    public function delete() {
        $id = $this->input->post('id');
        //Verificar Relaciones registro
        // Borrar Registro
        $this->db->where('id', $id);
        $this->db->delete('caja_chica_registro');
        $res = 1;     
        echo $res;
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Mcajachica_Administracion');
        $postData = $this->input->post();
        $data = $this->Mcajachica_Administracion->getList($postData);
        echo json_encode($data);
    }

}
