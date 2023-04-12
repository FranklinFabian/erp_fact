<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ma_Reportes extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function inventario_fisico() {
        $this->db->select('
        a.id id,
        a.codigo codigo_articulo,
        a.nombre articulo,
        g.id id_grupo,
        g.codigo codigo_grupo,
        g.nombre grupo,
        SUM(if(m.tipo = "Ingreso", m.cantidad, 0)) ingreso,
        SUM(if(m.tipo = "Egreso", m.cantidad, 0)) egreso,
        SUM(if(m.tipo = "Ingreso", m.cantidad, 0)) - SUM(if(m.tipo = "Egreso", m.cantidad, 0)) saldo
        ');
        $this->db->from('almacen_articulo a');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->join('almacen_movimiento m','m.id_articulo = a.id','left');
        $this->db->order_by('a.codigo', 'asc');
        $this->db->group_by('a.id','a.codigo','a.nombre', 'g.id', 'g.codigo','g.nombre');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    public function kardex_general($fecha_inicio, $fecha_fin, $tipo) {
        $this->db->select('m.*, DATE_FORMAT(c.fecha, "%d-%m-%Y") fecha, c.codigo comprobante,  cc.codigo as codigo_cuenta_contable, p.nombre as proyecto, cc.nombre as cuenta_contable, ca.nombre as cuenta_auxiliar, a.nombre as nombre_articulo, g.nombre as grupo, a.codigo as codigo_articulo, u.nombre as nombre_unidad');
        $this->db->from('almacen_movimiento m');
        $this->db->join('almacen_cabecera c','c.id = m.id_cabecera','left');
        $this->db->join('almacen_articulo a','a.id = m.id_articulo','left');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->join('almacen_unidad u','u.id = a.id_unidad','left');
        $this->db->join('almacen_proyecto p','p.id = m.id_proyecto','left');
        $this->db->join('almacen_cuenta_contable cc','cc.id = m.id_cuenta_contable','left');
        $this->db->join('almacen_cuenta_auxiliar ca','ca.id = m.id_cuenta_auxiliar','left');
        $this->db->where('c.fecha >=',$fecha_inicio);
        $this->db->where('c.fecha <=',$fecha_fin);
        $this->db->where('m.tipo',$tipo);
        $this->db->order_by('m.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function resumen_kardex_general($fecha_inicio, $fecha_fin, $tipo) {
        $this->db->select('cc.codigo codigo, cc.nombre nombre, SUM(m.cantidad * m.costo_contable) importe');
        $this->db->from('almacen_movimiento m');
        $this->db->join('almacen_cabecera c','c.id = m.id_cabecera','left');
        $this->db->join('almacen_cuenta_contable cc','cc.id = m.id_cuenta_contable','left');
        $this->db->where('c.fecha >=',$fecha_inicio);
        $this->db->where('c.fecha <=',$fecha_fin);
        $this->db->where('m.tipo',$tipo);
        $this->db->order_by('m.id', 'desc');
        $this->db->group_by('m.id_cuenta_contable');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function salida_almacen($fecha_inicio, $fecha_fin) {
        $this->db->select('
        m.*,
        DATE_FORMAT(c.fecha, "%d-%m-%Y") fecha,
        cc.codigo as codigo_cuenta_contable,
        p.nombre as proyecto,
        cc.nombre as cuenta_contable,
        ca.nombre as cuenta_auxiliar,
        a.nombre as nombre_articulo,
        a.codigo as codigo_articulo,
        u.nombre as nombre_unidad');
        $this->db->from('almacen_movimiento m');
        $this->db->join('almacen_cabecera c','c.id = m.id_cabecera','left');
        $this->db->join('almacen_articulo a','a.id = m.id_articulo','left');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->join('almacen_unidad u','u.id = a.id_unidad','left');
        $this->db->join('almacen_proyecto p','p.id = m.id_proyecto','left');
        $this->db->join('almacen_cuenta_contable cc','cc.id = m.id_cuenta_contable','left');
        $this->db->join('almacen_cuenta_auxiliar ca','ca.id = m.id_cuenta_auxiliar','left');
        $this->db->where('c.fecha >=',$fecha_inicio);
        $this->db->where('c.fecha <=',$fecha_fin);
        $this->db->where('m.tipo', 'Egreso');
        $this->db->order_by('m.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }



}
