<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ma_Fact_cliente extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data) {
        $this->db->insert('fact_cliente', $data);
        return $this->db->insert_id();
    }

    public function get_tipo_doc($id_tipo_doc) {
        $query = $this->db->select('nombre')
            ->from('adq_catalogo_tipodoc')
            ->where('id', $id_tipo_doc)
            ->get();
        $result = $query->row_array();
        return $result['nombre'];
    }
}
