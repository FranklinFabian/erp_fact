<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cga_valor_certificado extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lga_valor_certificado');
        $this->load->library('session');
        $this->load->model('Mga_Valores_certificado');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $content = $this->lga_valor_certificado->add_form();
        $this->template->full_admin_html_view($content);
    }

    public function insert() {
        $data = array(
            'monto' => $this->input->post('monto')
        );

        $result = $this->Mga_Valores_certificado->insert($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cga_valor_certificado'));

        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('Cga_valor_certificado'));
        }
    }

    public function update_form($id) {
        $content = $this->lga_valor_certificado->editable_data($id);
        $this->template->full_admin_html_view($content);
    }

    public function update() {
        $id = $this->input->post('id');
        $data = array(
            'monto' => $this->input->post('monto')
        );
        $this->Mga_Valores_certificado->update($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cga_valor_certificado'));
    }

    public function delete($id) {
        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('ga_valor_certificado');
        if ( $this->db->error()['code'] == 0 ){
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => 'Este registro no puede ser eliminado debido a que fue utilizado en uno o mas formularios'));
        }

        redirect(base_url('Cga_valor_certificado'));
    }

}
