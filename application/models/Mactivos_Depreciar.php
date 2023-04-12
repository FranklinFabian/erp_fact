<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mactivos_Depreciar extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function lista_activos() {
        $this->db->select('ar.*, acc.coeficiente_depreciacion');
        $this->db->from('activos_registro ar');
        $this->db->join('activos_catalogo_cuenta acc', 'acc.id = ar.id_cuenta', 'left');
        $this->db->where('valor_neto >', '1');
        $this->db->order_by('fecha_alta','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function lista_ufv($fecha) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_ufv');
        $this->db->order_by('fecha','asc');
        $this->db->where('fecha > ', $fecha);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }













    public function retrieve_datamodal($id) {
        $this->db->select('
        acc.*,
        acs.id id_servicio
        ');
        $this->db->from('activos_catalogo_cuenta acc');
        $this->db->join('activos_catalogo_grupo acg','acg.id = acc.id_grupo','left');
        $this->db->join('activos_catalogo_servicio acs','acs.id = acg.id_servicio','left');
        $this->db->where('acc.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function dropdown() {
        $this->db->select('*');
        $this->db->from('activos_catalogo_cuenta');
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
        $this->db->from('activos_catalogo_cuenta');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function list_filtrada($var) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_cuenta');
        $this->db->where('id_grupo', $var);
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_abreviatura($id) {
        $this->db->select('abreviatura');
        $this->db->from('activos_catalogo_cuenta');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->abreviatura;
        }
        return FALSE;
    }

    public function get_correlativo($id) {
        $this->db->select('correlativo');
        $this->db->from('activos_catalogo_cuenta');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->correlativo;
        }
        return FALSE;
    }


}
