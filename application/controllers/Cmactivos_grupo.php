<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmactivos_grupo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lmactivos_grupo');
        $this->load->library('session');
        $this->load->model('Mactivos_Grupo');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $content = $this->lmactivos_grupo->add_form();
        $this->template->full_admin_html_view($content);
    }

    public function insert() {
        $data = array(
            'id_servicio' => $this->input->post('id_servicio'),
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion'),
            'estado' => $this->input->post('estado')
        );
        $result = $this->Mactivos_Grupo->insert($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cmactivos_grupo'));

        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('Cmactivos_grupo'));
        }
    }

    public function update_form($id) {
        $content = $this->lmactivos_grupo->editable_data($id);
        $this->template->full_admin_html_view($content);
    }

    public function update() {
        $this->load->model('Mactivos_Grupo');
        $id = $this->input->post('id');
        $data = array(
            'id_servicio' => $this->input->post('id_servicio'),
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion'),
            'estado' => $this->input->post('estado')
        );
        $this->Mactivos_Grupo->update($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cmactivos_grupo'));
    }

    public function delete($id) {
        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('activos_catalogo_grupo');
        if ( $this->db->error()['code'] == 0 ){
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => 'Este registro no puede ser eliminado debido a que fue utilizado en uno o mas formularios'));
        }

        redirect(base_url('Cmactivos_grupo'));
    }

    public function lista(){
        $id = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('activos_catalogo_grupo');
        $this->db->where('id_servicio', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            echo json_encode($query->result_array());
        }
        return FALSE;
    }

}
