<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmactivos_empresa extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lmactivos_empresa');
        $this->load->library('session');
        $this->load->model('Mactivos_Empresa');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $content = $this->lmactivos_empresa->add_form();
        $this->template->full_admin_html_view($content);
    }

    public function insert() {
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'direccion' => $this->input->post('direccion'),
            'telefono' => $this->input->post('telefono'),
            'abreviatura' => $this->input->post('abreviatura'),
            'estado' => $this->input->post('estado'),
            'descripcion' => $this->input->post('descripcion')
        );
        $result = $this->Mactivos_Empresa->insert($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cmactivos_empresa'));

        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('Cmactivos_empresa'));
        }
    }

    public function update_form($id) {
        $content = $this->lmactivos_empresa->editable_data($id);
        $this->template->full_admin_html_view($content);
    }

    public function update() {
        $this->load->model('Mactivos_Empresa');
        $id = $this->input->post('id');
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'direccion' => $this->input->post('direccion'),
            'telefono' => $this->input->post('telefono'),
            'abreviatura' => $this->input->post('abreviatura'),
            'estado' => $this->input->post('estado'),
            'descripcion' => $this->input->post('descripcion')
        );
        $this->Mactivos_Empresa->update($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cmactivos_empresa'));
    }

    public function delete($id) {
        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('activos_catalogo_empresa');
        if ( $this->db->error()['code'] == 0 ){
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => 'Este registro no puede ser eliminado debido a que fue utilizado en uno o mas formularios'));
        }

        redirect(base_url('Cmactivos_empresa'));
    }

}
