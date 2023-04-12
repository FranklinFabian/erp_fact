<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mactivos_Ubicacion extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert($data) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_ubicacion');
        $this->db->where('nombre', $data['nombre']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('activos_catalogo_ubicacion', $data);
            return TRUE;
        }
    }

    public function list() {
        $this->db->select('u.*, l.nombre lugar');
        $this->db->from('activos_catalogo_ubicacion u');
        $this->db->join('activos_catalogo_lugar l', 'l.id=u.id_lugar', 'left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function retrieve_editdata($id) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_ubicacion');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('activos_catalogo_ubicacion', $data);
        return TRUE;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('activos_catalogo_ubicacion');
        return TRUE;
    }

    public function list_filtrada($var) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_ubicacion');
        $this->db->where('id_lugar', $var);
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function list_ubicaciones() {
        $this->db->select('*');
        $this->db->from('activos_catalogo_ubicacion');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

}
