<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reporte extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function detalle_cliente() {
        $this->db->select('ac.*');
        $this->db->from('adq_cliente ac ');
        $this->db->order_by('ac.id', 'desc');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    public function detalle_abonado($inicio, $fin) {
        $this->db->select('aa.*,
        DATE_FORMAT(aa.fecha_registro, "%d-%m-%Y") as fecha_registro,
        ac.cid id_cliente,
        acat.nombre id_categoria,
        azon.nombre id_zona,
        act.nombre as transformador,
        apos.nombre id_poste,
        asu.nombre as id_suministro,
        acon.nombre as id_consumidor,
        amed.nombre as id_medicion,
        alib.nombre as id_liberacion,
        aeste.nombre as id_existe_inquilino,
        aesti.nombre as id_ley_adulto
        ');
        $this->db->from('adq_abonado aa ');
        $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
        $this->db->join('adq_categoria acat','acat.id = aa.id_categoria','left');
        $this->db->join('adq_zona azon','azon.id = aa.id_zona','left');
        $this->db->join('adq_poste apos','apos.id = aa.id_poste','left');
        $this->db->join('adq_centro_transformacion act','act.id = apos.id_centro_transformacion','left');
        $this->db->join('adq_suministro asu','asu.id = aa.id_suministro','left');
        $this->db->join('adq_consumidor acon','acon.id = aa.id_consumidor','left');
        $this->db->join('adq_medicion amed','amed.id = aa.id_medicion','left');
        $this->db->join('adq_liberacion alib','alib.id = aa.id_liberacion','left');
        $this->db->join('adq_estado aeste','aeste.id = aa.id_existe_inquilino','left');
        $this->db->join('adq_estado aesti','aesti.id = aa.id_ley_adulto','left');

        $this->db->order_by('aa.id', 'desc');
        $this->db->where('aa.fecha_registro >=', $inicio);
        $this->db->where('aa.fecha_registro <=', $fin);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    public function detalle_orden($inicio, $fin) {
        $this->db->select('
        aos.*,
        abon.id id_abonado,
        ase.nombre as id_servicio,
        ase.nombre as id_estado_servicio,
        aesta.nombre as id_estado_cobro,
        DATE_FORMAT(aos.fecha_registro, "%d-%m-%Y") as fecha_registro,
        DATE_FORMAT(aos.fecha_inicio, "%d-%m-%Y") as fecha_inicio,
        DATE_FORMAT(aos.fecha_fin, "%d-%m-%Y") as fecha_fin,
        ac.cid id_cliente,
        ac.razon_social razon_social,
        u.first_name as nombre,
        u.last_name as apellido
        ');
        $this->db->from('adq_orden_servicio aos');
        $this->db->join('adq_abonado abon','abon.id = aos.id_abonado','left');
        $this->db->join('adq_cliente ac','ac.id = abon.id_cliente','left');
        $this->db->join('adq_servicio ase','ase.id = aos.id_servicio','left');
        $this->db->join('adq_estado_servicio aes','aes.id = aos.id_estado_servicio','left');
        $this->db->join('adq_estado aesta','aesta.id = aos.id_estado_cobro','left');
        $this->db->join('users u','u.id = aos.id_empleado','left');
        $this->db->order_by('aos.id', 'desc');
        $this->db->where('aos.fecha_registro >=', $inicio);
        $this->db->where('aos.fecha_registro <=', $fin);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    public function detalle_corte($inicio, $fin) {
        $this->db->select('
        acr.*,
        abon.id id_abonado,
        ac.cid id_cliente,
        ac.razon_social razon_social,
        DATE_FORMAT(acr.fecha, "%d-%m-%Y") as fecha,
        at.nombre as id_tipo
        ');
        $this->db->from('adq_corte_reposicion acr');
        $this->db->join('adq_abonado abon','abon.id = acr.id_abonado','left');
        $this->db->join('adq_cliente ac','ac.id = abon.id_cliente','left');
        $this->db->join('adq_tipo at','at.id = acr.id_tipo','left');
        $this->db->order_by('acr.id', 'desc');
        $this->db->where('acr.fecha >=', $inicio);
        $this->db->where('acr.fecha <=', $fin);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }





}
