<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mactivos_tipo_responsable extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert($data) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_tipo_responsable');
        $this->db->where('nombre', $data['nombre']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            $this->db->insert('activos_catalogo_tipo_responsable', $data);
            return TRUE;
        }
    }

    public function list() {
        $this->db->select('*');
        $this->db->from('activos_catalogo_tipo_responsable');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function retrieve_editdata($id) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_tipo_responsable');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('activos_catalogo_tipo_responsable', $data);
        return TRUE;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('activos_catalogo_tipo_responsable');
        return TRUE;
    }

    public function dropdown() {
        $this->db->select('*');
        $this->db->from('activos_catalogo_tipo_responsable');
        $query=$this->db->get();
        $data=$query->result();
        $list[''] = 'Seleccionar una opcion';
        if(!empty($data)){
            foreach ($data as  $value) {
                $list[$value->id] = $value->nombre;
            }
        }
        return $list;
    }

    public function list_dropdown() {
        $this->db->select('*');
        $this->db->from('activos_catalogo_tipo_responsable');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

}
