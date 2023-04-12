<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orden_model extends CI_Model
{
  function get_all()
  {
    $query = $this->db->query('SELECT * FROM fact_orden');
    return $query->result_array();
  }
  function get_atendidos()
  {
    $query = $this->db->query('SELECT * FROM fact_orden, fact_salida WHERE fact_orden.id_orden=fact_salida.id_orden AND estado_orden="2" ORDER BY fact_orden.id_orden DESC');
    return $query->result_array();
  }
  function mis_ordenes($id_empleado)
  {
    $query = $this->db->query('SELECT * FROM fact_orden WHERE id_empleado=? ORDER BY id_orden DESC',array($id_empleado));
    return $query->result_array();
  }  
  function get_ordenes_id_empleado($id_empleado)
  {
    $query = $this->db->query('SELECT * FROM fact_orden WHERE id_empleado=?',array($id_empleado));
    return $query->result_array();
  }  
  function mis_ordenes_atendidos($id_empleado)
  {
    $query = $this->db->query('SELECT * FROM fact_orden, fact_salida
                                WHERE id_empleado=? AND
                                      fact_orden.id_orden=fact_salida.id_orden
                                      ORDER BY fact_salida.fecha_salida
                                ',array($id_empleado));
    return $query->result_array();
  }  
  function get_all_all($id_orden)
  {
    $query = $this->db->query('SELECT * FROM fact_orden, fact_items_orden WHERE fact_orden.id_orden=fact_items_orden.id_orden AND fact_orden.id_orden=?',array($id_orden));
    return $query->result_array();
  }
  function get_orden($id_orden)
  {
    $query = $this->db->query('SELECT * FROM fact_orden WHERE id_orden=?',array($id_orden));
    return $query->row_array();
  }
  function get_all_fecha($fecha)
  {
    $query = $this->db->query('SELECT * FROM fact_orden WHERE DATE_FORMAT(`fecha_orden`, "%Y-%m-%d")=? ORDER BY fecha_orden DESC',array($fecha));
    return $query->result_array();
  }
  function get_all_orden_fact_cliente($id_orden)
  {
    $query = $this->db->query('SELECT * FROM fact_orden, fact_factura, fact_cliente 
                                WHERE (fact_orden.id_orden=fact_factura.id_orden)
                                AND fact_orden.id_orden=?',array($id_orden));
    return $query->row_array();
  }  

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_orden" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }
  function insertar($data)
  {
    $this->db->insert('fact_orden',$data);
  }
  function actualizar($id_orden, $data)
  {
    $this->db->where('id_orden', $id_orden);
    $this->db->update('fact_orden', $data);
  }
  function eliminar($id_orden)
  {
    $this->db->where('id_orden', $id_orden);
    $this->db->delete('fact_orden');
  }

  function ventas_dia($dia){
    $query = $this->db->query('SELECT * FROM fact_orden WHERE tipo_orden="2" AND date(fecha_orden)=? ORDER BY fecha_orden DESC', array($dia));
    return $query->result_array();
  }
  function buscar_id_orden($id_orden)
  {
    $query = $this->db->query('SELECT * FROM fact_orden WHERE id_orden=?', array($id_orden));
    $resultado = $query->result_array();
    if(count($resultado)==0)
    return false;
          else
    return true;
  }

}
