<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmcajachica_configuracion extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mcajachica_Configuracion');
        $this->load->library('auth');
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lmcajachica_configuracion');
        $content = $CI->lmcajachica_configuracion->edit_data();
        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $this->load->model('Mcajachica_Configuracion');

        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->Mcajachica_Configuracion->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }

        $this->load->view('modulo_cajachica/configuracion/modal', $data);
    }

    public function update() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('caja_chica_configuracion', $data);
        }else{
            $this->db->insert('caja_chica_configuracion', $data);
        }
        echo 1;
    }

    public function delete() {
        $id = $this->input->post('id');

        // Borrar Registro
        $this->db->where('id', $id);
        $this->db->delete('caja_chica_configuracion');
        $res = 1;

        echo $res;
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Mcajachica_Configuracion');
        $postData = $this->input->post();
        $data = $this->Mcajachica_Configuracion->getList($postData);
        echo json_encode($data);
    }

}
