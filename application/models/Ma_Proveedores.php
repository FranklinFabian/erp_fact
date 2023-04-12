<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ma_Proveedores extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

//    =========== its for unit check and insert start ===============
    public function insert($data) {
        $this->db->select('*');
        $this->db->from('almacen_proveedor');
        $this->db->where('nombre', $data['nombre']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('almacen_proveedor', $data);
            return TRUE;
        }
    }

//    =========== its for unit check and insert close ===============
//    =========== its for unit list show start ===============
    public function list() {
        $this->db->select('p.*, d.nombre ciudad');
        $this->db->from('almacen_proveedor p');
        $this->db->join('almacen_departamento d', 'd.id=p.id_ciudad', 'left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

//    =========== its for unit list show close ===============
//    =========== its for unit editable data show start ===============
    public function retrieve_editdata($id) {
        $this->db->select('*');
        $this->db->from('almacen_proveedor');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

//    =========== its for unit editable data show close ===============
//    =========== its for unit update start  ===============
    public function update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('almacen_proveedor', $data);
        return TRUE;
    }

//    =========== its for unit update close  ===============
//    =========== its for unit unit delete start  ===============
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('almacen_proveedor');
        return TRUE;
    }

}
