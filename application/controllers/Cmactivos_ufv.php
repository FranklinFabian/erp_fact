<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmactivos_ufv extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lmactivos_ufv');
        $this->load->library('session');
        $this->load->model('Mactivos_Ufv');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $content = $this->lmactivos_ufv->add_form();
        $this->template->full_admin_html_view($content);
    }

    public function insert() {
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $data = array(
            'fecha' => $fecha,
            'valor' => $this->input->post('valor'),
        );
        $result = $this->Mactivos_Ufv->insert($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cmactivos_ufv'));

        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('Cmactivos_ufv'));
        }
    }

    public function update_form($id) {
        $content = $this->lmactivos_ufv->editable_data($id);
        $this->template->full_admin_html_view($content);
    }

    public function update() {
        $this->load->model('Mactivos_Ufv');
        $id = $this->input->post('id');

        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $data = array(
            'fecha' => $fecha,
            'valor' => $this->input->post('valor'),
        );
        $this->Mactivos_Ufv->update($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cmactivos_ufv'));
    }

    public function delete($id) {
        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('activos_catalogo_ufv');
        if ( $this->db->error()['code'] == 0 ){
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => 'Este registro no puede ser eliminado debido a que fue utilizado en uno o mas formularios'));
        }

        redirect(base_url('Cmactivos_ufv'));
    }

}
