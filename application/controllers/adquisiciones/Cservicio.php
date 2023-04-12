<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cservicio extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('adquisiciones/Servicio');
        $this->load->library('auth');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('adquisiciones/Lservicio');
        $content = $CI->lservicio->edit_data();
        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->Servicio->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }
        $this->load->view('adquisiciones/servicio/modal', $data);
    }

    public function update() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        $data['costo'] = floatval(str_replace(',', '.', str_replace('.', '', $data['costo'])));

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('adq_servicio', $data);
        }else{
            $data['id_usuario'] = $this->session->userdata("user_id");
            $this->db->insert('adq_servicio', $data);
        }

        $this->db->affected_rows() != 1 ? $res = 0 : $res = 1;

        echo $res;

    }


    public function delete() {
        $id = $this->input->post('id');

        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('adq_servicio');
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
        $data = $this->Servicio->getList($postData);
        echo json_encode($data);
    }




}
