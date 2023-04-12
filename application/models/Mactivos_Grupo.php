<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mactivos_Grupo extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert($data) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_grupo');
        $this->db->where('nombre', $data['nombre']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('activos_catalogo_grupo', $data);
            return TRUE;
        }
    }

    public function list() {
        $this->db->select('g.*, s.nombre servicio');
        $this->db->from('activos_catalogo_grupo g');
        $this->db->join('activos_catalogo_servicio s', 's.id=g.id_servicio', 'left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function retrieve_editdata($id) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_grupo');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('activos_catalogo_grupo', $data);
        return TRUE;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('activos_catalogo_grupo');
        return TRUE;
    }

    public function list_filtrada($var) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_grupo');
        $this->db->where('id_servicio', $var);
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

}
