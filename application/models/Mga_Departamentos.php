<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mga_Departamentos extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert($data) {
        $this->db->select('*');
        $this->db->from('ga_departamento');
        $this->db->where('nombre', $data['nombre']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('ga_departamento', $data);
            return TRUE;
        }
    }

    public function list() {
        $this->db->select('*');
        $this->db->from('ga_departamento');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function retrieve_editdata($id) {
        $this->db->select('*');
        $this->db->from('ga_departamento');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('ga_departamento', $data);
        return TRUE;
    }

}
