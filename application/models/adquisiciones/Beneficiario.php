<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Beneficiario extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function beneficiarios() {
        $this->db->select('*');
        $this->db->from('adq_beneficiarios_ley1886');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function insert($data)
    {
        $this->db->insert('adq_beneficiarios_ley1886', $data);
    }
}
