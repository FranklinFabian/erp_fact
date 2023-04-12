<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_almacen extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lma_almacen');
        $this->load->library('session');
        $this->load->model('Ma_Almacenes');
        $this->auth->check_admin_auth();
    }

    // ================ by default create unit page load. =============
    public function index() {
        $content = $this->lma_almacen->add_form();
        $this->template->full_admin_html_view($content);
    }

//    ========== close index method ============
//    =========== unit add is start ====================
    public function insert() {
        //Get current correlative
        $puntero = 'nivel3';

        while($puntero != ''){
            $cadena = $this->db->get_where("almacen_correlativo",array('nombre' => $puntero))->row_array();
            $puntero = $cadena['padre'];
            $cadena_concatenada[] =   $cadena['formato'] . $cadena['numero'];
        }
        $cadena_formateada='';
        foreach (array_reverse($cadena_concatenada) as $res){
            $cadena_formateada .= $res . '.';
        }

        //$pre_correlativo = rtrim($cadena_formateada,'.');

        $correlativo = $this->db->order_by('id', 'DESC')->get("almacen_almacen")->row();

        $correlativo_inicial = 2;
        if ($correlativo == ""){
            $correlativo_formateado = $cadena_formateada . str_pad($correlativo_inicial, 2, '0', STR_PAD_LEFT);
            $correlativo = $correlativo_inicial;
        }else{
            $correlativo = $correlativo->correlativo + 1;
            $correlativo_formateado = $cadena_formateada . str_pad($correlativo, 2, '0', STR_PAD_LEFT);
        }

        $data = array(
            'correlativo' => $correlativo,
            'codigo' => $correlativo_formateado,
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion')
        );
        $result = $this->Ma_Almacenes->insert($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cma_almacen'));

        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('Cma_almacen'));
        }
    }

//    ========== its for all unit record show close ================
//    =========== its for unit edit form start ===============
    public function update_form($id) {
        $content = $this->lma_almacen->editable_data($id);
        $this->template->full_admin_html_view($content);
    }

//    =========== its for unit edit form close ===============
//    =========== its for unit update start  ===============
    public function update() {
        $this->load->model('Ma_Almacenes');
        $id = $this->input->post('id');
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'descripcion'    => $this->input->post('descripcion')
        );
        $this->Ma_Almacenes->update($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cma_almacen'));
    }

//    =========== its for unit update close ===============
//    =========== its for unit delete start ===============
    public function delete($id) {
        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('almacen_almacen');
        if ( $this->db->error()['code'] == 0 ){
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => 'Este registro no puede ser eliminado debido a que fue utilizado en uno o mas formularios'));
        }

        redirect(base_url('Cma_almacen'));
    }

}
