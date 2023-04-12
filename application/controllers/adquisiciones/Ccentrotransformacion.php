<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ccentrotransformacion extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('adquisiciones/CentroTransformacion');
        $this->load->library('auth');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('adquisiciones/Lcentrotransformacion');
        $content = $CI->lcentrotransformacion->edit_data();
        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->CentroTransformacion->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }
        $this->load->view('adquisiciones/centrotransformacion/modal', $data);
    }

    public function update() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('adq_centro_transformacion', $data);
        }else{
            $data['id_usuario'] = $this->session->userdata("user_id");
            $this->db->insert('adq_centro_transformacion', $data);
        }

        $this->db->affected_rows() != 1 ? $res = 0 : $res = 1;

        echo $res;

    }


    public function delete() {
        $id = $this->input->post('id');

        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('adq_centro_transformacion');
        if ( $this->db->error()['code'] == 0 ){
            $res = 1;
        }else{
            $res = 0;
        }

        echo $res;



    }

    //DataTables
    public function dataList(){
        $postData = $this->input->post();
        $data = $this->CentroTransformacion->getList($postData);
        echo json_encode($data);
    }




}
