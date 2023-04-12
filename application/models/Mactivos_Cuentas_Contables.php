<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mactivos_Cuentas_Contables extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function list_dropdown() {
        $this->db->select('*');
        $this->db->from('cofi_cuentas');
        $this->db->where('cuenta_grupo_id',1);
        $this->db->where('final',1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

}
