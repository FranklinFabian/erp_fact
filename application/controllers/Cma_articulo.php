<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_articulo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lma_articulo');
        $this->load->library('session');
        $this->load->model('Ma_Articulos');
        $this->auth->check_admin_auth();
    }

    // ================ by default create unit page load. =============
    public function index() {
        $content = $this->lma_articulo->add_form();
        $this->template->full_admin_html_view($content);
    }

//    ========== close index method ============
//    =========== unit add is start ====================
    public function insert() {

        $pre_correlativo = $this->db->get_where("almacen_grupo",array('id' => $this->input->post('id_grupo')))->row()->codigo;

        $correlativo = $this->db->order_by('id', 'DESC')->get_where("almacen_articulo",array('id_grupo' => $this->input->post('id_grupo')))->row();

        $correlativo_inicial = 1;
        $pre_correlativo = str_pad(substr($pre_correlativo, -1), 4, '0', STR_PAD_RIGHT);
        if ($correlativo == ""){
            $correlativo = $correlativo_inicial;
            $correlativo_formateado = (int)$pre_correlativo + (int)$correlativo_inicial;
        }else{
            $correlativo = $correlativo->correlativo + 1;
            $correlativo_formateado = (int)$pre_correlativo + (int)$correlativo;
        }

        $data = array(
            'id_grupo' => $this->input->post('id_grupo'),
            'correlativo' => $correlativo,
            'codigo' => $correlativo_formateado,
            'nombre' => $this->input->post('nombre'),
            'id_unidad' => $this->input->post('id_unidad'),
            'stock_minimo' => $this->input->post('stock_minimo'),
            'monto_minimo' => $this->input->post('monto_minimo'),
            'monto_maximo' => $this->input->post('monto_maximo'),
            'monto_venta' => $this->input->post('monto_venta'),
            'descripcion' => $this->input->post('descripcion')
        );
        $result = $this->Ma_Articulos->insert($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cma_articulo'));

        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('Cma_articulo'));
        }
    }

//    ========== its for all unit record show close ================
//    =========== its for unit edit form start ===============
    public function update_form($id) {
        $content = $this->lma_articulo->editable_data($id);
        $this->template->full_admin_html_view($content);
    }

//    =========== its for unit edit form close ===============
//    =========== its for unit update start  ===============
    public function update() {
        $this->load->model('Ma_Articulos');
        $id = $this->input->post('id');
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'id_unidad' => $this->input->post('id_unidad'),
            'stock_minimo' => $this->input->post('stock_minimo'),
            'monto_minimo' => $this->input->post('monto_minimo'),
            'monto_maximo' => $this->input->post('monto_maximo'),
            'monto_venta' => $this->input->post('monto_venta'),
            'descripcion' => $this->input->post('descripcion')
        );
        $this->Ma_Articulos->update($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cma_articulo'));
    }

//    =========== its for unit update close ===============
//    =========== its for unit delete start ===============
    public function delete($id) {
        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('almacen_articulo');
        if ( $this->db->error()['code'] == 0 ){
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => 'Este registro no puede ser eliminado debido a que fue utilizado en uno o mas formularios'));
        }

        redirect(base_url('Cma_articulo'));
    }

    public function verificar_stock(){
        $ingreso = $this->db->query('SELECT sum(m.cantidad) as cantidad FROM almacen_movimiento m
                                     LEFT JOIN almacen_cabecera c on c.id = m.id_cabecera
                                     WHERE c.tipo = "Ingreso" AND c.estado = "Aprobado" AND
                                     m.id_articulo = ' . $_POST["id"])->row()->cantidad;

        $egreso = $this->db->query('SELECT sum(m.cantidad) as cantidad FROM almacen_movimiento m
                                    LEFT JOIN almacen_cabecera c on c.id = m.id_cabecera
                                    WHERE c.tipo = "Egreso" AND c.estado = "Aprobado" AND
                                    m.id_articulo = '. $_POST["id"])->row()->cantidad;
        $stock = $ingreso - $egreso;
        echo $stock;
    }

    public function lista(){
        $id = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('almacen_articulo');
        $this->db->where('id_grupo', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            echo json_encode($query->result_array());
        }
        return FALSE;
    }

    public function stock(){
        $id = $this->input->get('id');
        $ingreso = $this->Ma_Articulos->retrieve_stock_ingreso($id)[0]['cantidad'];
        $egreso = $this->Ma_Articulos->retrieve_stock_egreso($id)[0]['cantidad'];
        $res = $ingreso - $egreso;
        echo $res;
    }

}
