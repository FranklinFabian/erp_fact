<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ccliente extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('adquisiciones/Cliente');
        $this->load->library('auth');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('adquisiciones/Lcliente');
        $content = $CI->lcliente->edit_data();

        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $id = $_GET['id'];
        $type = $_GET['type'];

        $this->load->model('adquisiciones/Tipodocumento');
        $data['documentos'] = $this->Tipodocumento->documentos();

        if($type == 'update'){
            $data['item'] = $this->Cliente->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }
        $this->load->view('adquisiciones/cliente/modal', $data);
    }

    public function update() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        $data['nacimiento'] = date("Y-m-d", strtotime($data['nacimiento']));
        $data['id_usuario'] = $this->session->userdata("user_id");
        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('fact_cliente', $data);
        }else{
            $data['cid'] = $this->codigo();
            $this->db->insert('fact_cliente', $data);
        }

        $this->db->affected_rows() != 1 ? $res = 0 : $res = 1;

        echo $res;

    }


    public function delete() {
        $id = $this->input->post('id');

        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('fact_cliente');
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
        $data = $this->Cliente->getList($postData);
        echo json_encode($data);
    }

    public function codigo(){
        $this->db->select('prefijo, numero');
        $this->db->from('adq_correlativo');
        $row =$this->db->get()->row();
        $res = $row->prefijo . '-' . str_pad($row->numero, 7, '0', STR_PAD_LEFT );

        $data['numero'] = $row->numero + 1 ;
        $this->db->update('adq_correlativo', $data, "id = 1");

        return $res;
    }

    public function getEdad(){
        $id = $_GET['id'];
        $this->db->select('nacimiento');
        $this->db->from('fact_cliente');
        $this->db->where('id',$id);
        $row =$this->db->get()->row()->nacimiento;

        // Creates DateTime objects
        $datetime1 = date_create($row);
        $datetime2 = date_create(date("Y-m-d"));

        // Calculates the difference between DateTime objects
        $interval = date_diff($datetime1, $datetime2);

        // Printing result in years
        $res =$interval->format('%y');
        echo $res;
    }

    public function calculoEdad($id){
        $this->db->select('nacimiento');
        $this->db->from('fact_cliente');
        $this->db->where('id',$id);
        $row =$this->db->get()->row()->nacimiento;

        // Creates DateTime objects
        $datetime1 = date_create($row);
        $datetime2 = date_create(date("Y-m-d"));

        // Calculates the difference between DateTime objects
        $interval = date_diff($datetime1, $datetime2);

        // Printing result in years
        $res =$interval->format('%y');
        return $res;
    }


}
