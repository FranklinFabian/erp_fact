<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_grupo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lma_grupo');
        $this->load->library('session');
        $this->load->model('Ma_Grupos');
        $this->auth->check_admin_auth();
    }

    // ================ by default create unit page load. =============
    public function index() {
        $content = $this->lma_grupo->add_form();
        $this->template->full_admin_html_view($content);
    }

//    ========== close index method ============
//    =========== unit add is start ====================
    public function insert() {

        $pre_correlativo = $this->db->get_where("almacen_almacen",array('id' => $this->input->post('id_almacen')))->row()->codigo;

        $correlativo = $this->db->order_by('id', 'DESC')->get_where("almacen_grupo",array('id_almacen' => $this->input->post('id_almacen')))->row();

        $correlativo_inicial = 1;
        if ($correlativo == ""){
            $correlativo = $correlativo_inicial;
            $correlativo_formateado = $pre_correlativo . '.' .$correlativo_inicial;
        }else{
            $correlativo = $correlativo->correlativo + 1;
            $correlativo_formateado = $pre_correlativo . '.' .$correlativo;
        }


        $data = array(
            'correlativo' => $correlativo,
            'codigo' => $correlativo_formateado,
            'id_almacen' => $this->input->post('id_almacen'),
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion')
        );
        $result = $this->Ma_Grupos->insert($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cma_grupo'));

        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('Cma_grupo'));
        }
    }

//    ========== its for all unit record show close ================
//    =========== its for unit edit form start ===============
    public function update_form($id) {
        $content = $this->lma_grupo->editable_data($id);
        $this->template->full_admin_html_view($content);
    }

//    =========== its for unit edit form close ===============
//    =========== its for unit update start  ===============
    public function update() {
        $this->load->model('Ma_Grupos');
        $id = $this->input->post('id');
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'descripcion'    => $this->input->post('descripcion'),
        );
        $this->Ma_Grupos->update($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cma_grupo'));
    }

//    =========== its for unit update close ===============
//    =========== its for unit delete start ===============
    public function delete($id) {
        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('almacen_grupo');
        if ( $this->db->error()['code'] == 0 ){
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => 'Este registro no puede ser eliminado debido a que fue utilizado en uno o mas formularios'));
        }

        redirect(base_url('Cma_grupo'));
    }

    public function lista(){
        $id = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('almacen_grupo');
        $this->db->where('id_almacen', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            echo json_encode($query->result_array());
        }
        return FALSE;
    }

}
