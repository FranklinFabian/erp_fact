<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_unidad extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lma_unidad');
        $this->load->library('session');
        $this->load->model('Ma_Unidades');
        $this->auth->check_admin_auth();
    }

    // ================ by default create unit page load. =============
    public function index() {
        $content = $this->lma_unidad->add_form();
        $this->template->full_admin_html_view($content);
    }

//    ========== close index method ============
//    =========== unit add is start ====================
    public function insert() {
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion')
        );
        $result = $this->Ma_Unidades->insert($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cma_unidad'));

        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('Cma_unidad'));
        }
    }

//    ========== its for all unit record show close ================
//    =========== its for unit edit form start ===============
    public function update_form($id) {
        $content = $this->lma_unidad->editable_data($id);
        $this->template->full_admin_html_view($content);
    }

//    =========== its for unit edit form close ===============
//    =========== its for unit update start  ===============
    public function update() {
        $this->load->model('Ma_Unidades');
        $id = $this->input->post('id');
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'descripcion'    => $this->input->post('descripcion'),
        );
        $this->Ma_Unidades->update($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cma_unidad'));
    }

//    =========== its for unit update close ===============
//    =========== its for unit delete start ===============
    public function delete($id) {
        //Verificar Relaciones registro
        $this->db->select('id');
        $this->db->from('almacen_articulo');
        $this->db->where('id_unidad', $id);
        $this->db->get();
        $affected_row = $this->db->affected_rows();

        if ($affected_row == 0){
            // Borrar Registro
            $this->db->where('id', $id);
            $this->db->delete('almacen_unidad');
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => 'Este registro no puede ser eliminado debido a que fue utilizado en uno o mas formularios'));
        }
        redirect(base_url('Cma_unidad'));

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

}
