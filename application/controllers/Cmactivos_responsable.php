<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmactivos_responsable extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mactivos_Responsable');
        $this->load->library('auth');
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lmactivos_responsable');
        $content = $CI->lmactivos_responsable->edit_data();
        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $this->load->model('Mactivos_Responsable');
        $this->load->model('Mactivos_Tipo_Responsable');
        $this->load->model('Mactivos_Empresa');
        $id = $_GET['id'];
        $type = $_GET['type'];
        if($type == 'update'){
            $data['item'] = $this->Mactivos_Responsable->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }
        $data['tipo_responsables'] = $this->Mactivos_Tipo_Responsable->list_dropdown();
        $data['empresas'] = $this->Mactivos_Empresa->list_dropdown();
        $this->load->view('modulo_activos/responsable/modal', $data);
    }

    public function update() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('activos_catalogo_responsable', $data);
        }else{
            $this->db->insert('activos_catalogo_responsable', $data);
        }
        echo 1;
    }

    public function delete() {
        $id = $this->input->post('id');
        //Verificar Relaciones registro
        $this->db->select('id');
        $this->db->from('activos_registro');
        $this->db->where('id_responsable', $id);
        $this->db->get();
        $affected_row = $this->db->affected_rows();
        if ($affected_row == 0){
            // Borrar Registro
            $this->db->where('id', $id);
            $this->db->delete('activos_catalogo_responsable');
            $res = 1;
        }else{
            $res = 0;
        }
        echo $res;
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Mactivos_Responsable');
        $postData = $this->input->post();
        $data = $this->Mactivos_Responsable->getList($postData);
        echo json_encode($data);
    }

}
