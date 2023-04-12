<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ma_Articulos extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

//    =========== its for unit check and insert start ===============
    public function insert($data) {
        $this->db->select('*');
        $this->db->from('almacen_articulo');
        $this->db->where('nombre', $data['nombre']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('almacen_articulo', $data);
            return TRUE;
        }
    }

//    =========== its for unit check and insert close ===============
//    =========== its for unit list show start ===============
    public function list() {
        $this->db->select('ar.*, g.nombre as grupo, u.nombre as unidad, a.nombre as almacen');
        $this->db->from('almacen_articulo ar');
        $this->db->join('almacen_grupo g', 'g.id=ar.id_grupo', 'left');
        $this->db->join('almacen_almacen a', 'a.id=g.id_almacen', 'left');
        $this->db->join('almacen_unidad u', 'u.id=ar.id_unidad', 'left');
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
        $this->db->from('almacen_articulo');
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
        $this->db->update('almacen_articulo', $data);
        return TRUE;
    }

//    =========== its for unit update close  ===============
//    =========== its for unit unit delete start  ===============
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('almacen_articulo');
        return TRUE;
    }

    public function unidad_dropdown(){
        $this->db->select('*');
        $this->db->from('almacen_unidad');
        $query=$this->db->get();
        $data=$query->result();
        $list[''] = 'Seleccionar un opción';
        if(!empty($data)){
            foreach ($data as  $value) {
                $list[$value->id] = $value->nombre;
            }
        }
        return $list;
    }

    public function grupo_dropdown(){
        $this->db->select('*');
        $this->db->from('almacen_grupo');
        $query=$this->db->get();
        $data=$query->result();
        $list[''] = 'Seleccionar una opción';
        if(!empty($data)){
            foreach ($data as  $value) {
                $list[$value->id] = $value->nombre;
            }
        }
        return $list;
    }

    //Stock ingreso
    public function retrieve_stock_ingreso($id) {
        $this->db->select_sum('cantidad');
        $this->db->from('almacen_movimiento m');
        $this->db->where('m.tipo', "Ingreso");
        $this->db->where('m.id_articulo', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Stock Egreso
    public function retrieve_stock_egreso($id) {
        $this->db->select_sum('cantidad');
        $this->db->from('almacen_movimiento m');
        $this->db->where('m.tipo', "Egreso");
        $this->db->where('m.id_articulo', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function list_filtrada($var) {
        $this->db->select('*');
        $this->db->from('almacen_articulo');
        $this->db->where('id_grupo', $var);
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

}
