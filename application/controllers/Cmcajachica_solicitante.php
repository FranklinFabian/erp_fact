<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmcajachica_solicitante extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mcajachica_Solicitante');
        $this->load->library('auth');
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lmcajachica_solicitante');
        $content = $CI->lmcajachica_solicitante->edit_data();
        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $this->load->model('Mcajachica_Solicitante');

        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->Mcajachica_Solicitante->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }

        $this->load->view('modulo_cajachica/solicitante/modal', $data);
    }

    public function update() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('caja_chica_catalogo_solicitante', $data);
        }else{
            $this->db->insert('caja_chica_catalogo_solicitante', $data);
        }
        echo 1;
    }

    public function delete() {
        $id = $this->input->post('id');

        $this->db->select('id');
        $this->db->from('caja_chica_registro');
        $this->db->where('id_solicitante', $id);
        $this->db->get();
        $affected_row = $this->db->affected_rows();
        if ($affected_row == 0){
            // Borrar Registro
            $this->db->where('id', $id);
            $this->db->delete('caja_chica_catalogo_solicitante');
            $res = 1;
        }else{
            $res = 0;
        }
        echo $res;
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Mcajachica_Solicitante');
        $postData = $this->input->post();
        $data = $this->Mcajachica_Solicitante->getList($postData);
        echo json_encode($data);
    }

}
