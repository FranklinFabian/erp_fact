<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmactivos_cuenta extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mactivos_Cuenta');
        $this->load->library('auth');
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lmactivos_cuenta');
        $content = $CI->lmactivos_cuenta->edit_data();
        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $this->load->model('Mactivos_Cuenta');
        $this->load->model('Mactivos_Servicio');
        $this->load->model('Mactivos_Grupo');
        $this->load->model('Mactivos_Cuentas_Contables');
        $id = $_GET['id'];
        $type = $_GET['type'];
        if($type == 'update'){
            $data['item'] = $this->Mactivos_Cuenta->retrieve_datamodal($id)[0];
            $data['grupos'] = $this->Mactivos_Grupo->list_filtrada($data['item']['id_servicio']);
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }
        $data['servicios'] = $this->Mactivos_Servicio->list_dropdown();
        $data['cuentas'] = $this->Mactivos_Cuentas_Contables->list_dropdown();

        //print_r($data['cuentas']); exit;
        $this->load->view('modulo_activos/cuenta/modal', $data);
    }

    public function update() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('activos_catalogo_cuenta', $data);
        }else{
            $this->db->insert('activos_catalogo_cuenta', $data);
        }
        echo 1;
    }

    public function delete() {
        $id = $this->input->post('id');
        //Verificar Relaciones registro
        $this->db->select('id');
        $this->db->from('activos_registro');
        $this->db->where('id_cuenta', $id);
        $this->db->get();
        $affected_row = $this->db->affected_rows();
        if ($affected_row == 0){
            // Borrar Registro
            $this->db->where('id', $id);
            $this->db->delete('activos_catalogo_cuenta');
            $res = 1;
        }else{
            $res = 0;
        }
        echo $res;
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Mactivos_Cuenta');
        $postData = $this->input->post();
        $data = $this->Mactivos_Cuenta->getList($postData);
        echo json_encode($data);
    }

    public function lista(){
        $id = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('activos_catalogo_cuenta');
        $this->db->where('id_grupo', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            echo json_encode($query->result_array());
        }
        return FALSE;
    }

}
