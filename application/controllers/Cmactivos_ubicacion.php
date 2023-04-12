<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmactivos_ubicacion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lmactivos_ubicacion');
        $this->load->library('session');
        $this->load->model('Mactivos_Ubicacion');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $content = $this->lmactivos_ubicacion->add_form();
        $this->template->full_admin_html_view($content);
    }

    public function insert() {
        $data = array(
            'id_lugar' => $this->input->post('id_lugar'),
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion'),
            'estado' => $this->input->post('estado')
        );
        $result = $this->Mactivos_Ubicacion->insert($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cmactivos_ubicacion'));

        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('Cmactivos_ubicacion'));
        }
    }

    public function update_form($id) {
        $content = $this->lmactivos_ubicacion->editable_data($id);
        $this->template->full_admin_html_view($content);
    }

    public function update() {
        $this->load->model('Mactivos_Ubicacion');
        $id = $this->input->post('id');
        $data = array(
            'id_lugar' => $this->input->post('id_lugar'),
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion'),
            'estado' => $this->input->post('estado')
        );
        $this->Mactivos_Ubicacion->update($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cmactivos_ubicacion'));
    }

    public function delete($id) {
        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('activos_catalogo_ubicacion');
        if ( $this->db->error()['code'] == 0 ){
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => 'Este registro no puede ser eliminado debido a que fue utilizado en uno o mas formularios'));
        }

        redirect(base_url('Cmactivos_ubicacion'));
    }

    public function lista(){
        $id = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('activos_catalogo_ubicacion');
        $this->db->where('id_lugar', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            echo json_encode($query->result_array());
        }
        return FALSE;
    }

}
