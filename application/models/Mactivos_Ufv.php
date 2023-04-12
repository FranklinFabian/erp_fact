<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mactivos_Ufv extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert($data) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_ufv');
        $this->db->where('fecha', $data['fecha']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('activos_catalogo_ufv', $data);
            return TRUE;
        }
    }

    public function list() {
        $this->db->select('acu.id as id, DATE_FORMAT(acu.fecha, "%d-%m-%Y") as fecha_formateada, acu.valor as valor');
        $this->db->from('activos_catalogo_ufv acu');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function retrieve_editdata($id) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_ufv');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('activos_catalogo_ufv', $data);
        return TRUE;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('activos_catalogo_ufv');
        return TRUE;
    }

}
