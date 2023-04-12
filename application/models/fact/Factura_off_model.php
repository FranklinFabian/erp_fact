<?php
class Factura_off_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_factura_off WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_factura_off WHERE 1 ORDER BY nro_factura_off DESC ');
    return $query->result_array();
  }
  
  function get_factura_off($id_factura_off)
  {
    $query = $this->db->query('SELECT * FROM fact_factura_off WHERE id_factura_off=?', array($id_factura_off));
    return $query->row_array();
  }

  function get_factura_off_by_id_orden($id_orden){
    $query = $this->db->query('SELECT * FROM fact_factura_off WHERE id_orden=?', array($id_orden));
    return $query->row_array();
  }

  function get_factura_off_cuf($cuf)
  {
    $query = $this->db->query('SELECT * FROM fact_factura_off WHERE cuf=?', array($cuf));
    return $query->row_array();
  }


  function get_fact_idcliente($idcliente)
  {
    $query = $this->db->query('SELECT * FROM fact_factura_off WHERE idcliente=? ', array($idcliente));
    return $query->result_array();
  }

  function get_punto_venta($id_punto_venta){
    $query = $this->db->query('SELECT * FROM fact_factura_off
                                WHERE estado_fact = "E" AND
                                      id_punto_venta = ?
                              ', array($id_punto_venta));
    return $query->result_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_factura_off" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_factura_off',$data);
  }

  function actualizar_cuf($cuf, $data)
  {
    $this->db->where('cuf', $cuf);
    $this->db->update('fact_factura_off', $data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_factura_off', $id);
    $this->db->update('fact_factura_off', $data);
  }

  function eliminar($id_factura_off){
    $this->db->where('id_factura_off', $id_factura_off);
    $this->db->delete('fact_factura_off');
  }

}//fin class
