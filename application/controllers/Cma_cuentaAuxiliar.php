<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_cuentaAuxiliar extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('session');
        $this->auth->check_admin_auth();
    }

    // ================ by default create unit page load. =============

    public function lista(){
        $id = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('almacen_cuenta_auxiliar');
        $this->db->where('id_cuenta_contable', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            echo json_encode($query->result_array());
        }
        return FALSE;
    }

}
