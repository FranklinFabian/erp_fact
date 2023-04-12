<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mga_Reportes extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function cliente() {
        $this->db->select('*, DATE_FORMAT(fecha_registro, "%d-%m-%Y") fecha_registro_formato,
        DATE_FORMAT(fecha_nacimiento, "%d-%m-%Y") fecha_nacimiento_formato,
        DATE_FORMAT(fecha_socio, "%d-%m-%Y") fecha_socio_formato');
        $this->db->from('ga_cliente');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
}
