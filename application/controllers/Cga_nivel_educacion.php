<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cga_nivel_educacion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lga_nivel_educacion');
        $this->load->library('session');
        $this->load->model('Mga_Niveles_educacion');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $content = $this->lga_nivel_educacion->add_form();
        $this->template->full_admin_html_view($content);
    }

    public function insert() {
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion')
        );

        $result = $this->Mga_Niveles_educacion->insert($data);

        if ($result == TRUE) {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect(base_url('Cga_nivel_educacion'));

        } else {
            $this->session->set_userdata(array('error_message' => display('already_inserted')));
            redirect(base_url('Cga_nivel_educacion'));
        }
    }

    public function update_form($id) {
        $content = $this->lga_nivel_educacion->editable_data($id);
        $this->template->full_admin_html_view($content);
    }

    public function update() {
        $id = $this->input->post('id');
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'descripcion'    => $this->input->post('descripcion')
        );
        $this->Mga_Niveles_educacion->update($data, $id);
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect(base_url('Cga_nivel_educacion'));
    }

    public function delete($id) {
        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('ga_nivel_educacion');
        if ( $this->db->error()['code'] == 0 ){
            $this->session->set_userdata(array('message' => display('successfully_delete')));
        }else{
            $this->session->set_userdata(array('error_message' => 'Este registro no puede ser eliminado debido a que fue utilizado en uno o mas formularios'));
        }

        redirect(base_url('Cga_nivel_educacion'));
    }

}
